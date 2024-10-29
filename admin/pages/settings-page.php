<?php
/**
 * Ai_Robot_Settings_Page Class
 *
 * @since  1.0.0
 * @package Ai Robot
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit;
} // Exit if accessed directly

if ( ! class_exists( 'Ai_Robot_Settings_Page' ) ) :

    class Ai_Robot_Settings_Page extends Ai_Robot_Admin_Page {

        /**
         * Add page screen hooks
         *
         * @since 1.0.0
         * @param $hook
         */
        public function enqueue_scripts( $hook ) {

            parent::enqueue_scripts( $hook );


        }
    }

endif;