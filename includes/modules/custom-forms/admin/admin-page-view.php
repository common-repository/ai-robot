<?php
/**
 * Ai_Robot_CForm_Page Class
 *
 * @since  1.0.0
 * @package Ai Robot
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
} // Exit if accessed directly

if ( ! class_exists( 'Ai_Robot_CForm_Page' ) ) :

class Ai_Robot_CForm_Page extends Ai_Robot_Admin_Page {

    /**
     * Page number
     *
     * @var int
     */
    protected $page_number = 1;

    /**
     * Initialize
     *
     * @since 1.0.0
     */
    public function init() {
        $pagenum           = isset( $_REQUEST['paged'] ) ? absint( $_REQUEST['paged'] ) : 0; // WPCS: CSRF OK
        $this->page_number = max( 1, $pagenum );
        $this->processRequest();
    }

    /**
     * Process request
     *
     * @since 1.0.0
     */
    public function processRequest() {

        if ( ! isset( $_POST['ai_robot_nonce'] ) ) {
            return;
        }

        $nonce = $_POST['ai_robot_nonce'];
        if ( ! wp_verify_nonce( $nonce, 'ai-robot-campaign-request' ) ) {
            return;
        }

        $is_redirect = true;
        $action = "";
        if(isset($_POST['ai_robot_bulk_action'])){
            $action = sanitize_text_field($_POST['ai_robot_bulk_action']);
            $ids = isset( $_POST['ids'] ) ? sanitize_text_field( $_POST['ids'] ) : '';
        }else if(isset($_POST['ai_robot_single_action'])){
            $action = sanitize_text_field($_POST['ai_robot_single_action']);
            $id = isset( $_POST['id'] ) ? sanitize_text_field( $_POST['id'] ) : '';

        }
        switch ( $action ) {
            case 'delete':
                if ( isset( $id ) && !empty( $id ) ) {
                    $this->delete_module( $id );
                }
                break;

            case 'update-status':
                if ( isset( $id ) && !empty( $id ) ) {
                    $this->update_module_status( $id, sanitize_text_field($_POST['status']) );
                }
                break;


            case 'delete-campaigns' :
                if ( isset( $ids ) && !empty( $ids ) ) {
                    $form_ids = explode( ',', $ids );
                    if ( is_array( $form_ids ) && count( $form_ids ) > 0 ) {
                        foreach ( $form_ids as $id ) {
                            $this->delete_module( $id );
                        }
                    }
                }
                break;

            case 'publish-campaigns' :
                if ( isset( $ids ) && !empty( $ids ) ) {
                    $form_ids = explode( ',', $ids );
                    if ( is_array( $form_ids ) && count( $form_ids ) > 0 ) {
                        foreach ( $form_ids as $form_id ) {
                            $this->update_module_status( $form_id, 'publish' );
                        }
                    }
                }
                break;

            case 'draft-campaigns' :
                if ( isset( $ids ) && !empty( $ids ) ) {
                    $form_ids = explode( ',', $ids );
                    if ( is_array( $form_ids ) && count( $form_ids ) > 0 ) {
                        foreach ( $form_ids as $form_id ) {
                            $this->update_module_status( $form_id, 'draft' );
                        }
                    }
                }
                break;

            default:
                break;
        }

        if ( $is_redirect ) {
            $fallback_redirect = admin_url( 'admin.php' );
            $fallback_redirect = add_query_arg(
                array(
                    'page' => $this->get_admin_page(),
                ),
                $fallback_redirect
            );
            $this->maybe_redirect_to_referer( $fallback_redirect );
        }

        exit;
    }

	/**
	 * Count modules
	 *
	 * @since 1.0.0
	 * @return int
	 */
	public function countModules( $status = '' ) {
		return Ai_Robot_Custom_Form_Model::model()->count_all( $status );
	}

	/**
	 * Return modules
	 *
	 * @since 1.0.0
	 * @return array
	 */
	public function getModules() {
		$modules = array();
		$limit   = null;
		if ( defined( 'AI_ROBOT_FORMS_LIST_LIMIT' ) && AI_ROBOT_FORMS_LIST_LIMIT ) {
			$limit = AI_ROBOT_FORMS_LIST_LIMIT;
		}
		$data      = $this->get_models( $limit );

		// Fallback
		if ( ! isset( $data['models'] ) || empty( $data['models'] ) ) {
			return $modules;
		}

		foreach ( $data['models'] as $model ) {
            $settings = $model->get_settings();

            $modules[] = array(
				"id"              => $model->id,
				"title"           => $model->name,
				"date"            => date( get_option( 'date_format' ), strtotime( $model->raw->post_date ) ),
				"status"          => $model->status,
                "type"            => $settings['robot_selected_source'],
                "keywords"        => isset($settings['robot_selected_keywords']) ? $settings['robot_selected_keywords'] : '',
                "last_run_time"   => isset($settings['last_run_time']) ? date("F j, Y @ g:i a", $settings['last_run_time']) : 'Never',
            );
		}

		return $modules;
	}

    /**
     * Return models
     *
     * @since 1.0.0
     *
     * @param int $limit
     *
     * @return array
     */
    public function get_models( $limit = null ) {
        $data = Ai_Robot_Custom_Form_Model::model()->get_all_paged( $this->page_number, $limit );

        return $data;
    }

    /**
     * Delete module
     *
     * @since 1.0.0
     *
     * @param $id
     */
    public function delete_module( $id ) {
        //check if this id is valid and the record is exists
        $model = Ai_Robot_Custom_Form_Model::model()->load( $id );
        if ( is_object( $model ) ) {
            wp_delete_post( $id );
        }
    }

    /**
     * Bulk actions
     *
     * @since 1.0
     * @return array
     */
    public function bulk_actions() {
        return apply_filters(
            'ai_robot_campaign_bulk_actions',
            array(
                'publish-campaigns'    => __( "Publish", 'ai-robot' ),
                'draft-campaigns'      => __( "Unpublish", 'ai-robot' ),
                'delete-campaigns'     => __( "Delete", 'ai-robot' ),
            ) );
    }

    /**
     * Update Module Status
     *
     * @since 1.0.0
     *
     * @param $id
     * @param $status
     */
    public function update_module_status( $id, $status ) {
        // only publish and draft status avail
        if ( in_array( $status, array( 'publish', 'draft' ), true ) ) {
            $model = Ai_Robot_Custom_Form_Model::model()->load( $id );
            if ( $model instanceof Ai_Robot_Custom_Form_Model ) {
                $model->status = $status;
                $model->save();
            }
        }
    }

    /**
     * Pagination
     *
     * @since 1.0
     */
    public function pagination() {
        $count = $this->countModules();
        ai_robot_list_pagination( $count );
    }


}

endif;
