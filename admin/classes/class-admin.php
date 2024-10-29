<?php
/**
 * Ai_Robot_Admin Class
 *
 * @since  1.0.0
 * @package Ai Robot
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
} // Exit if accessed directly

if ( ! class_exists( 'Ai_Robot_Admin' ) ) :

   class Ai_Robot_Admin {

	   /**
	   * @var array
	   */
	   public $pages = array();

       /**
        * @var array
        */
       public $addons = array();

	   /**
	   * Ai_Robot_Admin constructor.
	   */
	   public function __construct() {
           $this->includes();

		   // Display admin notices
		   //add_action( 'admin_notices', array( $this, 'add_admin_notice' ) );

           // Init admin pages
           add_action( 'admin_menu', array( $this, 'add_dashboard_page' ) );

           // Init Admin AJAX class
           new Ai_Robot_Admin_AJAX();

		   /**
		   * Triggered when Admin is loaded
		   */
		   do_action( 'ai_robot_admin_loaded' );
       }

       /**
	   * Include required files
	   *
	   * @since 1.0.0
	   */
       private function includes() {
           // Admin pages
		   require_once AI_ROBOT_DIR . '/admin/pages/dashboard-page.php';
           require_once AI_ROBOT_DIR . '/admin/pages/integrations-page.php';
		   require_once AI_ROBOT_DIR . '/admin/pages/logs-page.php';
		   require_once AI_ROBOT_DIR . '/admin/pages/settings-page.php';
		   require_once AI_ROBOT_DIR . '/admin/pages/license-page.php';
		   require_once AI_ROBOT_DIR . '/admin/pages/addons-page.php';
		   require_once AI_ROBOT_DIR . '/admin/pages/wizard-page.php';
		   require_once AI_ROBOT_DIR . '/admin/pages/welcome-page.php';
		   require_once AI_ROBOT_DIR . '/admin/pages/import-page.php';

		   // Admin AJAX
		   require_once AI_ROBOT_DIR . '/admin/classes/class-admin-ajax.php';

           // Admin Data
           require_once AI_ROBOT_DIR . '/admin/classes/class-admin-data.php';

		   // Admin Addons
           require_once AI_ROBOT_DIR . '/admin/classes/class-admin-addons.php';
	   }

	   /**
	   * Admin notice
	   *
	   * @since 1.0.0
	   */
	  public function add_admin_notice() {
		$license_activated = get_option( 'ai_robot_license_activated');
		if ( empty($license_activated) || $license_activated != '102' ) {
			echo '<div class="updated"><p><strong>Ai Robot</strong> is ready. Please <a href="'.admin_url( 'admin.php?page=ai-robot-license' ).'">Click Here</a> to add your purchase code and activate the plugin.</p></div>';
		}
   	  }

	   /**
	   * Initialize Dashboard page
	   *
	   * @since 1.0.0
	   */
	   public function add_dashboard_page() {
			$title = __( 'Ai Robot', 'ai-robot' );
			$this->pages['ai_robot']           = new Ai_Robot_Dashboard_Page( 'ai-robot', 'dashboard', $title, $title, false, false );
			$this->pages['ai_robot-dashboard'] = new Ai_Robot_Dashboard_Page( 'ai-robot', 'dashboard', __( 'Ai Robot Dashboard', 'ai-robot' ), __( 'Dashboard', 'ai-robot' ), 'ai-robot' );
	   }

	   /**
		* Add Wizard page
		*
		* @since 1.0.0
		*/
		public function add_wizard_page() {
			add_action( 'admin_menu', array( $this, 'init_wizard_page' ) );
		}

		/**
		 * Initialize Wizard page
		 *
		 * @since 1.0.0
		 */
		public function init_wizard_page() {
			$this->pages['ai-robot-wizard'] = new Ai_Robot_Wizard_Page(
				'ai-robot-wizard',
				'wizard',
				__( 'Activation', 'ai-robot' ),
				__( 'Activation ⇪', 'ai-robot' ),
				'ai-robot'
			);
		}

	   /**
		* Add Integrations page
		*
		* @since 1.0.0
		*/
	   public function add_integrations_page() {
		   add_action( 'admin_menu', array( $this, 'init_integrations_page' ) );
	   }

       /**
        * Initialize Integrations page
        *
        * @since 1.0.0
        */
       public function init_integrations_page() {
           $this->pages['ai-robot-integrations'] = new Ai_Robot_Integrations_Page(
               'ai-robot-integrations',
               'integrations',
               __( 'Open AI', 'ai-robot' ),
               __( 'Open AI', 'ai-robot' ),
               'ai-robot'
           );
       }

	   /**
		* Add Logs page
		*
		* @since 1.0.0
		*/
	   public function add_logs_page() {
		   add_action( 'admin_menu', array( $this, 'init_logs_page' ) );
	   }

	   /**
		* Initialize Logs page
		*
		* @since 1.0.0
		*/
	   public function init_logs_page() {
		   $this->pages['ai-robot-logs'] = new Ai_Robot_Logs_Page(
			   'ai-robot-logs',
			   'logs',
			   __( 'Logs', 'ai-robot' ),
			   __( 'Logs', 'ai-robot' ),
			   'ai-robot'
		   );
	   }

	   /**
		* Add settings page
		*
		* @since 1.0.0
		*/
	   public function add_settings_page() {
		   add_action( 'admin_menu', array( $this, 'init_settings_page' ) );
	   }

	   /**
		* Initialize Logs page
		*
		* @since 1.0.0
		*/
	   public function init_settings_page() {
		   $this->pages['ai-robot-settings'] = new Ai_Robot_Settings_Page(
			   'ai-robot-settings',
			   'settings',
			   __( 'Settings', 'ai-robot' ),
			   __( 'Settings', 'ai-robot' ),
			   'ai-robot'
		   );
	   }

	   /**
		* Add license page
		*
		* @since 1.0.0
		*/
		public function add_license_page() {
			add_action( 'admin_menu', array( $this, 'init_license_page' ) );
		}

		/**
		 * Initialize Logs page
		 *
		 * @since 1.0.0
		 */
		public function init_license_page() {
			$this->pages['ai-robot-license'] = new Ai_Robot_License_Page(
				'ai-robot-license',
				'license',
				__( 'License', 'ai-robot' ),
				__( 'License', 'ai-robot' ),
				'ai-robot'
			);
		}

	   /**
		* Add addons page
		*
		* @since 1.0.0
		*/
		public function add_addons_page() {
			add_action( 'admin_menu', array( $this, 'init_addons_page' ) );
		}

		/**
		 * Initialize addons page
		 *
		 * @since 1.0.0
		 */
		public function init_addons_page() {
			$this->pages['ai-robot-addons'] = new Ai_Robot_Addons_Page(
				'ai-robot-addons',
				'addons',
				__( 'Addons', 'ai-robot' ),
				__( 'Addons', 'ai-robot' ),
				'ai-robot'
			);
		}

		/**
		* Add welcome page
		*
		* @since 1.0.0
		*/
		public function add_welcome_page() {
			add_action( 'admin_menu', array( $this, 'init_welcome_page' ) );
		}

		/**
		 * Initialize Logs page
		 *
		 * @since 1.0.0
		 */
		public function init_welcome_page() {
			$this->pages['ai-robot-welcome'] = new Ai_Robot_Welcome_Page(
				'ai-robot-welcome',
				'welcome',
				__( 'Welcome', 'ai-robot' ),
				__( 'Welcome', 'ai-robot' ),
				'ai-robot'
			);
		}

		/**
		* Add import page
		*
		* @since 1.0.0
		*/
		public function add_import_page() {
			add_action( 'admin_menu', array( $this, 'init_import_page' ) );
		}

		/**
		 * Initialize Logs page
		 *
		 * @since 1.0.0
		 */
		public function init_import_page() {
			$this->pages['ai-robot-import'] = new Ai_Robot_Import_Page(
				'ai-robot-import',
				'import',
				__( 'Import / Export', 'ai-robot' ),
				__( 'Import / Export', 'ai-robot' ),
				'ai-robot'
			);
		}


   }

endif;
