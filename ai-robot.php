<?php
/**
 * Plugin Name: Ai Robot
 * Plugin URI: https://wpairobot.com
 * Description: OpenAI and ChatGPT Content Generator
 * Version: 1.0.3
 * Text Domain: ai-robot
 * Author: wphobby
 * Author URI: https://wphobby.com/
 *
 * @package Ai Robot
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit;
} // Exit if accessed directly

/**
 * Set constants
 */
if ( ! defined( 'AI_ROBOT_DIR' ) ) {
    define( 'AI_ROBOT_DIR', plugin_dir_path(__FILE__) );
}

if ( ! defined( 'AI_ROBOT_URL' ) ) {
    define( 'AI_ROBOT_URL', plugin_dir_url(__FILE__) );
}

if ( ! defined( 'AI_ROBOT_FILE' ) ) {
	define( 'AI_ROBOT_FILE', __FILE__ );
}

if ( ! defined( 'AI_ROBOT_VERSION' ) ) {
    define( 'AI_ROBOT_VERSION', '1.0.3' );
}

/**
 * Class Ai_Robot
 *
 * Main class. Initialize plugin
 *
 * @since 1.0.0
 */
if ( ! class_exists( 'Ai_Robot' ) ) {
    /**
     * Ai_Robot
     */
    class Ai_Robot {

        const DOMAIN = 'ai-robot';

        /**
         * Instance of Ai_Robot
         *
         * @since  1.0.0
         * @var (Object) Ai_Robot
         */
        private static $_instance = null;

        /**
         * Get instance of Ai_Robot
         *
         * @since  1.0.0
         *
         * @return object Class object
         */
        public static function get_instance() {
            if ( ! isset( self::$_instance ) ) {
                self::$_instance = new self;
            }
            return self::$_instance;
        }

        /**
         * Constructor
         *
         * @since  1.0.0
         */
        private function __construct() {
            $this->includes();
            $this->init();
        }

        /**
         * Load plugin files
         *
         * @since 1.0
         */
        private function includes() {
            // Autoload files.
            require_once AI_ROBOT_DIR . '/vendor/autoload.php';

            // Core files.
            require_once AI_ROBOT_DIR . '/includes/class-core.php';
            require_once AI_ROBOT_DIR . '/includes/class-addon-loader.php';
        }


        /**
         * Init the plugin
         *
         * @since 1.0.0
         */
        private function init() {
            // Initialize plugin core
            $this->ai_robot = Ai_Robot_Core::get_instance();

            // Create tables
            $this->create_tables();

            // Initial Schedule Class for WP Cron Jobs
            Ai_Robot_Schedule::get_instance();

            /**
             * Triggered when plugin is loaded
             */
            do_action( 'ai_robot_loaded' );

            add_action('current_screen', array( $this, 'current_screen_action') );
        }



        /**
        * Current screen action
        *
        * @since 1.0.3
        * @return void
        */
        public function current_screen_action() {
            $screen = get_current_screen();
            $where = array(
                'toplevel_page_ai-robot',
                'ai-robot_page_ai-robot-campaign',
                'ai-robot_page_ai-robot-integrations',
                'ai-robot_page_ai-robot-wizard',
                'ai-robot_page_ai-robot-campaign-wizard',
                'ai-robot_page_ai-robot-logs',
                'ai-robot_page_ai-robot-settings',
                'ai-robot_page_ai-robot-upgrade',
                'ai-robot_page_ai-robot-welcome'
            );

            $enable_notice = false;
            if ( in_array($screen->base, $where) ) {
                $enable_notice = true;
            };

            if($enable_notice){
                add_action( 'admin_enqueue_scripts', array( $this, 'enqueue_scripts' ));
            }
        }

        public function enqueue_scripts() {
            wp_enqueue_style( 'ai-robot-notice-style', AI_ROBOT_URL . 'assets/css/notice.css', array(), AI_ROBOT_VERSION, false );
        }

        /** Redirect to welcome page when activation */
		public function welcome() {
            $page_url = 'admin.php?page=ai-robot-welcome';
            if ( ! get_transient( '_ai_robot_activation_redirect' ) ) {
                return;
            }
            delete_transient( '_ai_robot_activation_redirect' );
            wp_safe_redirect( admin_url( $page_url ) );
            exit;
		}

        /**
         * @since 1.0.0
         */
        public static function create_tables() {
            global $wpdb;
            $wpdb->hide_errors();

            $table_schema = [
                "CREATE TABLE IF NOT EXISTS `{$wpdb->prefix}ai_robot_logs` (
                `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
                `camp_id` int(11) DEFAULT NULL,
                `level` ENUM('log','info','warn','error','success') NOT NULL DEFAULT 'log',
                `message` text DEFAULT NULL,
                `created` DECIMAL(16, 6) NOT NULL,
                PRIMARY KEY (`id`)
            )  CHARACTER SET utf8 COLLATE utf8_general_ci;",
            ];
            require_once( ABSPATH . 'wp-admin/includes/upgrade.php' );
            foreach ( $table_schema as $table ) {
                dbDelta( $table );
            }
        }

    }
}

if ( ! function_exists( 'ai_robot' ) ) {
    function ai_robot() {
        return Ai_Robot::get_instance();
    }

    /**
     * Init the plugin and load the plugin instance
     *
     * @since 1.0.0
     */
    add_action( 'plugins_loaded', 'ai_robot' );
}

/**
* Plugin install hook
*
* @since 1.8.0
* @return void
*/
if ( ! function_exists( 'ai_robot_install' ) ) {
    function ai_robot_install(){
        // Hook for plugin install.
		do_action( 'ai_robot_install' );

		/*
		* Set current version.
		*/
		update_option( 'ai_robot_version_pro', AI_ROBOT_VERSION );

        set_transient( '_ai_robot_activation_redirect', 1 );
    }
}

// When activated, trigger install method.
register_activation_hook( AI_ROBOT_FILE, 'ai_robot_install' );

if ( ! function_exists( 'ar_fs' ) ) {
    // Create a helper function for easy SDK access.
    function ar_fs() {
        global $ar_fs;

        if ( ! isset( $ar_fs ) ) {
            // Include Freemius SDK.
            require_once dirname(__FILE__) . '/freemius/start.php';

            $ar_fs = fs_dynamic_init( array(
                'id'                  => '12600',
                'slug'                => 'ai-robot',
                'type'                => 'plugin',
                'public_key'          => 'pk_09ceb04d643198a67a7e8c577b122',
                'is_premium'          => false,
                'premium_suffix'      => 'Professional',
                // If your plugin is a serviceware, set this option to false.
                'has_premium_version' => true,
                'has_addons'          => false,
                'has_paid_plans'      => true,
                'menu'                => array(
                    'slug'           => 'ai-robot',
                    'first-path'     => 'admin.php?page=ai-robot-welcome',
                    'support'        => false,
                ),
            ) );
        }

        return $ar_fs;
    }

    // Init Freemius.
    ar_fs();
    // Signal that SDK was initiated.
    do_action( 'ar_fs_loaded' );
}