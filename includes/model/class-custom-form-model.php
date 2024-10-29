<?php
/**
 * Ai_Robot_Base_Form_Model Class
 *
 * @since  1.0.0
 * @package Ai Robot
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
} // Exit if accessed directly

if ( ! class_exists( 'Ai_Robot_Custom_Form_Model' ) ) :

    class Ai_Robot_Custom_Form_Model extends Ai_Robot_Base_Form_Model {

        protected $post_type = 'ai_robot_forms';

        /**
         * @param int|string $class_name
         *
         * @since 1.0
         * @return Ai_Robot_Custom_Form_Model
         */
        public static function model( $class_name = __CLASS__ ) { // phpcs:ignore
            return parent::model( $class_name );
        }

        /**
         * Run Campaign
         *
         * @since 1.0.0
         *
         */
        public function run_campaign() {

            $settings = $this->get_settings();

			$id = $this->id;
			$source = $settings['robot_selected_source'];

            //Get RSS Feed Link
            $feed_link = '';
            if(isset($settings['robot_feed_link'])){
               $feed_link = $settings['robot_feed_link'];
            }

            // Get RSS Search Random Keyword
            $rss_keyword = '';
            if(isset($settings['rss_selected_keywords'])){
                $rss_keywords = $settings['rss_selected_keywords'];
                $rss_keyword = ai_robot_get_random($rss_keywords);
            }

            // Get Random Keyword
            $keyword = '';
            if(isset($settings['robot_selected_keywords'])){
                $keywords = $settings['robot_selected_keywords'];
                $keyword = ai_robot_get_random($keywords);
            }

            // Update Campaign Last and Next Run Time
            if ( !is_null( $id ) || $id > 0 ) {
                $form_model = Ai_Robot_Custom_Form_Model::model()->load( $id );
                $settings = $form_model->settings;

                // Update next run time
                $time_length = ai_robot_calculate_next_time($settings['update_frequency'], $settings['update_frequency_unit']);
                $settings['next_run_time'] = time() + $time_length;

                // Update last run time
                $settings['last_run_time'] = time();

                // Save Settings to model
                $form_model->settings = $settings;
                // Save data
                $id = $form_model->save();

                $logger = new Ai_Robot_Log($id);
                $logger->add( "Update Campaign Next Run Time \t\t: " . $settings['next_run_time']. "for campaign id ". $id, 'info'  );
            }


            $result = array();
            switch ( $source ) {
                case 'facebook':
                    $result = ai_robot_process_facebook_job($id, $source, $settings);
                    break;
                case 'twitter':
                    $result = ai_robot_process_twitter_job($id, $source, $keyword, $settings);
                    break;
                case 'youtube':
                    $result = ai_robot_process_youtube_job($id, $source, $keyword, $settings);
                    break;
                case 'vimeo':
                    $result = ai_robot_process_vimeo_job($id, $source, $keyword, $settings);
                    break;
                case 'flickr':
                    $result = ai_robot_process_flickr_job($id, $source, $keyword, $settings);
                    break;
                case 'rss':
                    $result = ai_robot_process_rss_job($id, $source, $feed_link, $settings);
                    break;
                case 'soundcloud':
                    $result = ai_robot_process_soundcloud_job($id, $source, $feed_link, $settings);
                    break;
                case 'search':
                    $result = ai_robot_process_search_job($id, $source, $rss_keyword, $settings);
                    break;
                default:

                    break;
            }


            return $result;
        }
    }

endif;
