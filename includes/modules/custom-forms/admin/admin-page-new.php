<?php
/**
 * Ai_Robot_CForm_New_Page Class
 *
 * @since  1.0.0
 * @package Ai Robot
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
} // Exit if accessed directly

if ( ! class_exists( 'Ai_Robot_CForm_New_Page' ) ) :

class Ai_Robot_CForm_New_Page extends Ai_Robot_Admin_Page {

    /**
     * Get wizard title
     *
     * @since 1.0
     * @return mixed
     */
    public function getWizardTitle() {
        if ( isset( $_REQUEST['id'] ) ) { // WPCS: CSRF OK
            return __( "Edit Campaign", 'ai-robot' );
        } else {
            return __( "New Campaign", 'ai-robot' );
        }
    }

    /**
     * Add page screen hooks
     *
     * @since 1.0.0
     * @param $hook
     */
    public function enqueue_scripts( $hook ) {

        // Load admin styles
        ai_robot_admin_enqueue_styles( AI_ROBOT_VERSION );

        $ai_robot_data = new Ai_Robot_Admin_Data();


        // Load admin scripts
        ai_robot_admin_enqueue_scripts(
            AI_ROBOT_VERSION,
            $ai_robot_data->get_options_data()
        );

    }

    /**
     * Render page header
     *
     * @since 1.0
     */
    protected function render_header() { ?>
        <?php
        if ( $this->template_exists( $this->folder . '/header' ) ) {
            $this->template( $this->folder . '/header' );
        } else {
            ?>
            <h1 class="robot-header-title"><?php echo esc_html( get_admin_page_title() ); ?></h1>
        <?php } ?>
        <?php
    }


    /**
     * Return single model
     *
     * @since 1.0.0
     *
     * @param int $id
     *
     * @return array
     */
    public function get_single_model( $id ) {
        $data = Ai_Robot_Custom_Form_Model::model()->get_single_model( $id );

        return $data;
    }
}

endif;
