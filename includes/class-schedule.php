<?php
/**
 * Ai_Robot_Schedule Class
 *
 * @since  1.0.0
 * @package Ai Robot
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit;
} // Exit if accessed directly

if ( ! class_exists( 'Ai_Robot_Schedule' ) ) :

   class Ai_Robot_Schedule {

       /**
        * Plugin instance
        *
        * @var null
        */
       private static $instance = null;

       /**
        * Return the plugin instance
        *
        * @since 1.0.0
        * @return Ai_Robot_Schedule
        */
       public static function get_instance() {
           if ( is_null( self::$instance ) ) {
               self::$instance = new self();
           }

           return self::$instance;
       }

       /**
       * Ai_Robot_Schedule constructor.
       *
       * @since 1.0.0
       */
       public function __construct() {
           // Add a custom interval
           add_filter( 'cron_schedules', array( $this, 'robot_add_cron_interval' ) );
           // Setup Cron Job
           $this->cron_setup();
       }

       /**
        * Add a custom interval
        *
        * @since 1.0.0
        */
       public function robot_add_cron_interval( $schedules ) {
           $schedules['once_robot_a_minute'] = array(
               'interval' => 60,
               'display'  => esc_html__( 'Once Robot Job a Minute' )
           );
           $schedules['once_robot_a_day'] = array(
            'interval' => 60*60*24,
            'display'  => esc_html__( 'Once Robot Job a Day' )
           );
           return $schedules;
       }

       /**
        * Setup Cron Job
        *
        * @since 1.0.0
        */
       public function cron_setup(){
         if ( ! wp_next_scheduled( 'robot_cron_hook' ) ) {
            wp_schedule_event( time(), 'once_robot_a_minute', 'robot_cron_hook' );
         }

         // Add Cron Job Hook Function
         add_action( 'robot_cron_hook', array( $this, 'robot_cron_exec' )  );

       }

       /**
        * Cron Job Execute
        *
        * @since 1.0.0
        */
       public function robot_cron_exec(){
           $current_time = time();

           // Run campaigns job here
           $models = Ai_Robot_Custom_Form_Model::model()->get_all_models();

           $campaigns = $models['models'];

           foreach($campaigns as $key=>$model){
               $settings = $model->settings;
               // Run this campaign when time on schedule time
               if($current_time >= $settings['next_run_time']){
                   $model->run_campaign();
                   // Delete last api request cache data
                   $ai_robot_youtube_cache_key = 'ai_robot_youtube_cache_'.$model->id;
                   if(get_option( $ai_robot_youtube_cache_key, false )){
                       // Start System Log Start
                       $logger = new Ai_Robot_Log($model->id);
                       delete_option( $ai_robot_youtube_cache_key );
                       $logger->add( "Clear Youtube Cache Data  \t\t: on" . time() );
                   }
               }
           }

           // Send email report
           $global_settings = get_option( 'ai_robot_global_settings', array() );

           if ( empty( $global_settings[ 'next_report_time' ] ) ) {
               $global_settings[ 'next_report_time'] = time() + 7*60*60*24;
               update_option( 'ai_robot_global_settings', $global_settings );
           }

		   if($current_time >= $global_settings['next_report_time']){
               $result = ai_robot_send_email('report');
               $update_frequency = isset($global_settings[ 'update_frequency']) ? $global_settings[ 'update_frequency'] : 7;
               $update_frequency_unit = isset($global_settings[ 'update_frequency_unit']) ? $global_settings[ 'update_frequency_unit'] : 'Days';
               // update next report time
               $global_settings[ 'next_report_time'] = time() + ai_robot_calculate_next_time($update_frequency, $update_frequency_unit);
			   update_option( 'ai_robot_global_settings', $global_settings );
           }
       }

       /**
        * Print Current Cron Jobs
        *
        * @since 1.0.0
        */
       public function robot_print_tasks() {
           echo '<pre>'; print_r( _get_cron_array() ); echo '</pre>';
       }

   }

endif;
