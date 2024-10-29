<?php
/**
 * Ai Robot Log List Table Class
 *
 * @since  1.0.0
 * @package Ai Robot
 */

defined( 'ABSPATH' ) or exit;

// Load WP_List_Table if not loaded
if ( ! class_exists( 'WP_List_Table' ) ) {
    require_once ABSPATH . 'wp-admin/includes/class-wp-list-table.php';
}

if ( ! class_exists( 'Ai_Robot_Log_List_Table' ) ) :

	/**
	 * Ai Robot Log List Table
	 */
	class Ai_Robot_Log_List_Table extends WP_List_Table{

        /**
         * Number of results to show per page
         *
         * @var string
         * @since 1.0.0
         */
        public $per_page = 20;

        /**
         *
         * Total number of logs
         * @var string
         * @since 1.0.0
         */
        public $total_count;

        /**
         * error level
         *
         * @var string
         * @since 1.0.0
         */
        public $error_count;

        /**
         * warn level
         *
         * @var string
         * @since 1.0.0
         */
        public $warn_count;

        /**
         * info level
         *
         * @var string
         * @since 1.0.0
         */
        public $info_count;

        /**
         * log level
         *
         * @var string
         * @since 1.0.0
         */
        public $log_count;

        /**
         * Base URL
         * @var string
         */
        public $base_url;

        /**
         * EAccounting_Products_List_Table constructor.
         */
        public function __construct() {
            parent::__construct( array(
                'singular' => 'log',
                'plural'   => 'logs',
                'ajax'     => false,
            ) );
            $this->base_url = admin_url( 'admin.php?page=ai-robot-logs' );
            $this->process_bulk_action();
        }

        /**
         * Setup the final data for the table
         *
         * @return void
         * @since 1.0.0
         */
        public function prepare_items() {
            $per_page              = $this->per_page;
            $columns               = $this->get_columns();
            $hidden                = array();
            $sortable              = $this->get_sortable_columns();
            $this->_column_headers = array( $columns, $hidden, $sortable );
            $this->process_bulk_action();
            $data  = $this->get_results();
            $level = isset( $_GET['level'] ) ? sanitize_text_field($_GET['level']) : 'any';

            switch ( $level ) {
                case 'log':
                    $total_items = $this->log_count;
                    break;
                case 'info':
                    $total_items = $this->info_count;
                    break;
                case 'warn':
                    $total_items = $this->warn_count;
                    break;
                case 'error':
                    $total_items = $this->error_count;
                    break;
                case 'any':
                default:
                    $total_items = $this->total_count;
                    break;
            }
            $this->items = $data;
            $this->set_pagination_args( array(
                'total_items' => $total_items,
                'per_page'    => $per_page,
                'total_pages' => ceil( $total_items / $per_page ),
            ) );
        }

        /**
         * Message to be displayed when there are no items
         *
         * @since 1.0.0
         */
        function no_items() {
            echo sprintf( __( 'No %s found.', 'ai-robot' ), $this->_args['plural'] );
        }

        /**
         * Show the search field
         *
         * @param string $text Label for the search box
         * @param string $input_id ID of the search box
         *
         * @return void
         * @since 1.0.0
         *
         */
        public function search_box( $text, $input_id ) {
            if ( empty( $_REQUEST['s'] ) && ! $this->has_items() ) {
                return;
            }

            $input_id = $input_id . '-search-input';

            if ( ! empty( $_REQUEST['orderby'] ) ) {
                echo '<input type="hidden" name="orderby" value="' . esc_attr( $_REQUEST['orderby'] ) . '" />';
            }
            if ( ! empty( $_REQUEST['order'] ) ) {
                echo '<input type="hidden" name="order" value="' . esc_attr( $_REQUEST['order'] ) . '" />';
            }
            ?>
            <p class="search-box">
                <label class="screen-reader-text" for="<?php echo esc_attr($input_id); ?>"><?php echo esc_html($text); ?>:</label>
                <input type="search" id="<?php echo esc_attr($input_id); ?>" name="s" value="<?php _admin_search_query(); ?>"/>
                <?php submit_button( $text, 'button', false, false, array( 'ID' => 'search-submit' ) ); ?>
            </p>
            <?php
        }

        /**
         * Retrieve the view types
         *
         * @return array $views All the views available
         * @since 1.0.0
         */
        public function get_views() {
            $current       = isset( $_GET['level'] ) ? sanitize_key( $_GET['level'] ) : '';
            $total_count   = '&nbsp;<span class="count">(' . $this->total_count . ')</span>';
            $log_count   = '&nbsp;<span class="count">(' . $this->log_count . ')</span>';
            $info_count    = '&nbsp;<span class="count">(' . $this->info_count . ')</span>';
            $warn_count = '&nbsp;<span class="count">(' . $this->warn_count . ')</span>';
            $error_count   = '&nbsp;<span class="count">(' . $this->error_count . ')</span>';
            $views         = array(
                'all'     => sprintf( '<a href="%s"%s>%s</a>', remove_query_arg( 'level', $this->base_url ), $current === 'all' || $current == '' ? ' class="current"' : '', __( 'All', 'ai-robot' ) . $total_count ),
                'log'    => sprintf( '<a href="%s"%s>%s</a>', add_query_arg( 'level', 'log', $this->base_url ), $current === 'info' ? ' class="current"' : '', __( 'Log', 'ai-robot' ) . $log_count ),
                'info'    => sprintf( '<a href="%s"%s>%s</a>', add_query_arg( 'level', 'info', $this->base_url ), $current === 'info' ? ' class="current"' : '', __( 'Info', 'ai-robot' ) . $info_count ),
                'warn' => sprintf( '<a href="%s"%s>%s</a>', add_query_arg( 'level', 'warn', $this->base_url ), $current === 'warn' ? ' class="current"' : '', __( 'Warn', 'ai-robot' ) . $warn_count ),
                'error'   => sprintf( '<a href="%s"%s>%s</a>', add_query_arg( 'level', 'error', $this->base_url ), $current === 'error' ? ' class="current"' : '', __( 'Error', 'ai-robot' ) . $error_count ),
            );

            return $views;
        }

        function extra_tablenav( $which ) {
            if ( $which == "top" ){
                echo sprintf( '<a href="#" class="button button-secondary" id="robot-clear-logs">%s</a>',  __('Clear Logs', 'ai-robot'));
            }
        }

        /**
         * Retrieve the table columns
         *
         * @return array $columns Array of all the list table columns
         * @since 1.0.0
         */
        public function get_columns() {
            $columns = array(
                'campaign' => __( 'Campaign', 'ai-robot' ),
                'level'    => __( 'Level', 'ai-robot' ),
                'log'      => __( 'Log', 'ai-robot' ),
                'date'     => __( 'Date', 'ai-robot' ),
            );

            return $columns;
        }

        /**
         * Retrieve the table's sortable columns
         *
         * @return array Array of all the sortable columns
         *
         * @since 1.0.0
         */
        public function get_sortable_columns() {
            return array(
                'campaign' => array( 'camp_id', false ),
                'level'    => array( 'level', false ),
                'log'      => array( 'message', false ),
                'date'     => array( 'created', false )
            );
        }

        /**
         * @param object $item
         * @param string $column_name
         *
         * @return string;
         * @since 1.0.0
         */
        function column_default( $item, $column_name ) {
            switch ( $column_name ) {
                case 'campaign':
                    $campaign_id = $item->camp_id ? $item->camp_id : '';
                    if ( empty( $campaign_id ) ) {
                        return '&mdash;';
                    }else{
                        $form_model = Ai_Robot_Custom_Form_Model::model()->load( $campaign_id );
                        $settings = $form_model->settings;
                        $source = $settings['robot_selected_source'];
                        $campaign_name = $settings['robot_campaign_name'];
                    }
                    $url   = admin_url( "admin.php?page=ai-robot-campaign-wizard&id={$item->camp_id}&source={$source}" );
                    return sprintf( '<a href="%s">#(%d) - %s</a>', $url, $campaign_id, $campaign_name );
                    break;
                case 'level':
                    return $item->level ? sprintf( '<span class="%s">%s</span>', sanitize_html_class( strtolower( $item->level) ), $item->level ) : '&mdash;';
                    break;
                case 'log':
                    return $item->message ? strip_tags( $item->message ) : '&mdash;';
                    break;
                case 'date':
                    return date("F j, Y, g:i a", $item->created);
                default:
                    return '&mdash;';
                    break;
            }
        }

        /**
         * Process the bulk actions
         *
         * @return void
         * @since 1.0.0
         *
         */
        public function process_bulk_action() {

        }

        /**
         * Retrieve all the data for all the discount codes
         *
         * @return array $get_results Array of all the data for the discount codes
         * @since 1.0.0
         */
        public function get_results() {
            $per_page = $this->per_page;
            $orderby  = isset( $_GET['orderby'] ) ? sanitize_key( $_GET['orderby'] ) : 'created';
            $order    = isset( $_GET['order'] ) ? sanitize_key( $_GET['order'] ) : 'DESC';
            $level    = isset( $_GET['level'] ) ? sanitize_key( $_GET['level'] ) : '';
            $search   = isset( $_GET['s'] ) ? sanitize_text_field( $_GET['s'] ) : null;

            $args = array(
                'per_page' => $per_page,
                'page'     => isset( $_GET['paged'] ) ? sanitize_text_field($_GET['paged']) : 1,
                'orderby'  => $orderby,
                'order'    => $order,
                'level'    => $level,
                'search'   => $search
            );


            if ( array_key_exists( $orderby, $this->get_sortable_columns() ) && 'name' != $orderby ) {
                $args['orderby'] = $orderby;
            }

            $this->total_count   = ai_robot_get_logs( array_merge( $args, array( 'level' => '' ) ), true );
            $this->log_count    = ai_robot_get_logs( array_merge( $args, array( 'level' => 'log' ) ), true );
            $this->info_count    = ai_robot_get_logs( array_merge( $args, array( 'level' => 'info' ) ), true );
            $this->warn_count    = ai_robot_get_logs( array_merge( $args, array( 'level' => 'warn' ) ), true );
            $this->error_count   = ai_robot_get_logs( array_merge( $args, array( 'level' => 'error' ) ), true );

            $results = ai_robot_get_logs( $args );

            return $results;
        }

    }

endif;
