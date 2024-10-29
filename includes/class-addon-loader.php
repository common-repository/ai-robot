<?php
/**
 * Ai_Robot_Addon_Loader Class
 *
 * @since  1.0.0
 * @package Ai Robot
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit;
} // Exit if accessed directly

if ( ! class_exists( 'Ai_Robot_Addon_Loader' ) ) :

    class Ai_Robot_Addon_Loader {

        /**
         * Array Access-able of Registered Addons
         *
         * @since 1.0.0
         * @var array
         */
        private $addons = array();

        /**
         * @since 1.0.0
         * @var self
         */
        private static $instance = null;

        /**
         * Get instance of loader
         *
         * @since 1.0.0
         * @return Ai_Robot_Addon_Loader
         */
        public static function get_instance() {
            if ( is_null( self::$instance ) ) {
                self::$instance = new self();
            }

            return self::$instance;
        }


        /**
         * Ai_Robot_Addon_Loader constructor.
         *
         * @since 1.0.0
         */
        public function __construct() {

            // Initial addons data.
            $addons = array(
                array(
                    'name' => 'Open AI',
                    'slug' => 'open-ai',
                    'type' => 'social',
                    'icon_url' => AI_ROBOT_URL.'/assets/images/open-ai.png',
                    'is_connected' => false
                ),
            );

            $ai_robot_addons = get_option( 'ai_robot_addons', false );

            if ( !$ai_robot_addons || count($ai_robot_addons) !== count($addons) ) {
                update_option( 'ai_robot_addons', $addons );
            }

            $this->addons = get_option( 'ai_robot_addons', false );
        }

        /**
         * Get Addons
         *
         * @since 1.0.0
         **
         * @return array
         */
        public function get_addons( ) {
            return $this->addons;
        }

        /**
         * Save addon data
         *
         * @since 1.0.0
         **
         * @return bool
         */
        public function save_addon_data($data) {

            $addons = $this->addons;

            foreach ( $addons as $key => $addon ) {

                if ( $addon['slug'] == $data['slug'] ) {
                    // Set is_connected true
                    if($data['is_connected']){
                        $data['is_connected'] = false;
                    }else{
                        $data['is_connected'] = true;
                    }
                    $addons[$key] = array_merge($addons[$key], $data);
                }
            }

            update_option( 'ai_robot_addons', $addons );

        }

        /**
         * Get addon data
         *
         * @since 1.0.0
         **
         * @return bool
         */
        public function get_addon_data($slug) {

            $addons = get_option( 'ai_robot_addons', false );
            $selected_addon_data = array();

            foreach ( $addons as $key => $addon ) {
                if ( $addon['slug'] == $slug ) {
                    $selected_addon_data = $addon;
                }
            }

            return $selected_addon_data;
        }

    }

endif;