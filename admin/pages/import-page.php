<?php
/**
 * Ai_Robot_Import_Page Class
 *
 * @since  1.0.0
 * @package Ai Robot
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit;
} // Exit if accessed directly

if ( ! class_exists( 'Ai_Robot_Import_Page' ) ) :

    class Ai_Robot_Import_Page extends Ai_Robot_Admin_Page {

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

        	// Load admin import scripts
        	ai_robot_admin_enqueue_scripts_import(
            	AI_ROBOT_VERSION,
            	$ai_robot_data->get_options_data()
        	);


        }
    }

endif;