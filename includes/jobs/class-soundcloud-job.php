<?php
/**
 * Ai_Robot_SoundCloud_Job Class
 *
 * @since  1.0.0
 * @package Ai Robot
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit;
} // Exit if accessed directly

if ( ! class_exists( 'Ai_Robot_SoundCloud_Job' ) ) :

    class Ai_Robot_SoundCloud_Job extends Ai_Robot_Job{

        /**
         * Ai_Robot_SoundCloud_Job constructor.
         *
         * @since 1.0.0
         */
        public function __construct($id, $type, $keyword, $settings) {
            $this->id = $id;
            $this->settings = $settings;
            $this->get_api_data($type);
            if(strpos($keyword, ' ')){
                $keyword_array = explode( ' ', $keyword );
                $this->keyword = $keyword_array[0];
            }else{
                $this->keyword = $keyword;
            }
        }

        /**
         * Run this job
         *
         * @return array
         */
        public function run(){

        }

        /**
        * Fetch Data
        *
        * @return array
        */
        public function fetch_data() {

        }
}

endif;
