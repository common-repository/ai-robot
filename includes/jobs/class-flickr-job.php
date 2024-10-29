<?php
/**
 * Ai_Robot_Flickr_Job Class
 *
 * @since  1.0.0
 * @package Ai Robot
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit;
} // Exit if accessed directly

if ( ! class_exists( 'Ai_Robot_Flickr_Job' ) ) :

    class Ai_Robot_Flickr_Job extends Ai_Robot_Job{

        /**
         * Ai_Robot_Flickr_Job constructor.
         *
         * @since 1.0.0
         */
        public function __construct($id, $type, $keyword, $settings) {
            $this->id = $id;
            $this->get_api_data($type);
            $this->keyword = $keyword;
            $this->settings = $settings;
            $this->logger = new Ai_Robot_Log($id);
        }

        /**
         * Run this job
         *
         * @return array
         */
        public function run(){
            // Fetch Data
            $data = $this->fetch_data();

            // Create new post when return data is not null
            if(!is_null($data)){
                $title = $data['title']['_content'];
                $url = $data['urls']['url'][0]['_content'];

                $this->log[] = array(
                    'message'   => 'Fetch Flickr Title: '.$title,
                    'level'     => 'log'
                );
                $this->log[] = array(
                    'message'   => 'Fetch Flickr URL: <a href="'.$url.'">'.$url.'</a>',
                    'level'     => 'log'
                );

                // Build post content
                $content = $url.'<br>';
                $content .= '<a href="'.$url.'">source</a>';

                // Generate New Post
                $this->create_post($title, $content, $this->settings);
            }

            // Add this job running log to system log file
            foreach($this->log as $key => $value){
                $this->logger->add($value['message'], $value['level']);
            }

            return $this->log;
        }

        /**
        * fetch_data
        *
        * @return array
        */
        public function fetch_data() {

          $api_data = $this->api_data;
          $api_key = $api_data['api_key'];
          $limit = 50;

          $url = 'https://api.flickr.com/services/rest/?method=flickr.photos.getRecent&';

          $req_params = [
              'api_key'  => $api_key,
              'text' => $this->keyword,
              'format' => 'php_serial',
              'per_page' => $limit
          ];

          $url .= http_build_query($req_params);

          // fetch url json data
          $return_data  = $this->fetch_stream( $url );

          $result = unserialize($return_data);

          $rand = rand(0, 49);

          $photo_id = $result['photos']['photo'][$rand]['id'];


          // Get single Photo Image
          $single_photo_url = 'https://api.flickr.com/services/rest/?method=flickr.photos.getInfo&';

          $req_params = [
              'api_key'  => $api_key,
              'format' => 'php_serial',
              'photo_id' => $photo_id
          ];

          $single_photo_url .= http_build_query($req_params);

          // fetch url json data
          $return_photo_data  = $this->fetch_stream( $single_photo_url );

          $photo_result = unserialize($return_photo_data);

          return $photo_result['photo'];

        }
}

endif;
