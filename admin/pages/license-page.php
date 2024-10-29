<?php
/**
 * Ai_Robot_License_Page Class
 *
 * @since  1.0.0
 * @package Ai Robot
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
} // Exit if accessed directly

if ( ! class_exists( 'Ai_Robot_License_Page' ) ) :

	class Ai_Robot_License_Page extends Ai_Robot_Admin_Page {
		/**
         * Add page screen hooks
         *
         * @since 1.0.0
         *
         * @param $hook
         */
        public function enqueue_scripts( $hook ) {
            // Load admin styles
			ai_robot_admin_enqueue_styles( AI_ROBOT_VERSION );

            $ai_robot_data = new Ai_Robot_Admin_Data();

        	// Load admin scripts
        	ai_robot_admin_enqueue_scripts_license(
            	AI_ROBOT_VERSION,
            	$ai_robot_data->get_options_data()
        	);
		}

		/**
         * Render page container
         *
         * @since 1.0.0
         */
        public function render() {

            ?>

            <main class="robot-wrap <?php echo esc_attr( 'ai-robot-' . $this->page_slug ); ?>">

                <?php
                $this->render_page_content();
                ?>

            </main>

            <?php
        }
	}

endif;
