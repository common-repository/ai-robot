<?php
/**
 * Ai_Robot_Facebook_Job Class
 *
 * @since  1.0.0
 * @package Ai Robot
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit;
} // Exit if accessed directly

if ( ! class_exists( 'Ai_Robot_Facebook_Job' ) ) :

    class Ai_Robot_Facebook_Job extends Ai_Robot_Job{

        /**
         * Ai_Robot_Facebook_Job constructor.
         *
         * @since 1.0.0
         */
        public function __construct($id, $type, $settings) {
            $this->id = $id;
            $this->get_api_data($type);
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
                $title = substr($data['message'], 0, 45);
                $this->log[] = array(
                    'message'   => 'Fetch Facebook Message: '.$data['message'],
                    'level'     => 'log'
                );
                $content = '<p>'.$data['message'].'</p>';

                if(isset($data['image'])){
                    $content .= '<img src="'.$data['image'].'" />';
                }

                // Generate New Post
                $this->create_post($title, $content, $this->settings);

                // Add this job running log to system log file
                foreach($this->log as $key => $value){
                    $this->logger->add($value['message'], $value['level']);
                }
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
          $access_token = $api_data['access_token'];
          $limit = 100;

          // check if need to fetch data from specific facebook user
          if( $this->settings['facebook_source_type'] == 'profile' ){
            $user_id = $this->get_user_id();
            $url = 'https://graph.facebook.com/v11.0/'.$user_id.'/feed/?';

            // Check previous profile post key
            $fb_profile_post_cache_key = 'ai_robot_fb_profile_post_'.$this->id;
            $fb_profile_post_cache_value = get_option( $fb_profile_post_cache_key, false );
            if($fb_profile_post_cache_value === false){
                $profile_post_key = 0;
                add_option( $fb_profile_post_cache_key, $profile_post_key );
            }else{
                $profile_post_key = intval($fb_profile_post_cache_value) + 1;
                update_option( $fb_profile_post_cache_key, $profile_post_key );
            }


          }else if( $this->settings['facebook_source_type'] == 'group' ){
            $group_id = $this->get_group_id($this->settings['facebook_group']);
            $url = 'https://graph.facebook.com/v11.0/'.$group_id.'/feed/?';

            // Check previous group post key
            $fb_group_post_cache_key = 'ai_robot_fb_group_post_'.$this->id;
            $fb_group_post_cache_value = get_option( $fb_group_post_cache_key, false );
            if($fb_group_post_cache_value === false){
                $group_post_key = 0;
                add_option( $fb_group_post_cache_key, $group_post_key );
            }else{
                $group_post_key = intval($fb_group_post_cache_value) + 1;
                update_option( $fb_group_post_cache_key, $group_post_key );
            }
          }

          $req_params = [
              'access_token'  => $access_token,
              'fields' => 'message,attachments',
              'limit' => $limit,
          ];

          $url .= http_build_query($req_params);

          // fetch url json data
          $return_data  = $this->fetch_stream( $url );

          $result = json_decode($return_data);

          $feeds = array();
          foreach($result->data as $key => $value){
              $feeds[$key]['message'] = $value->message;
              if(isset($value->attachments->data[0]->media->image->src)){
                $feeds[$key]['image'] = $value->attachments->data[0]->media->image->src;
              }
          }

          if( $this->settings['facebook_source_type'] == 'profile' ){
            return $feeds[$profile_post_key];
          }else if( $this->settings['facebook_source_type'] == 'group' ){
            return $feeds[$group_post_key];
          }

        }

        /**
         * Get user is
         *
         * @return int
         */
        public function get_user_id() {
            $api_data = $this->api_data;
            $access_token = $api_data['access_token'];

            $url = 'https://graph.facebook.com/v11.0/me?';

            $req_params = [
              'access_token'  => $access_token,
              'fields' => 'id,name'
            ];

            $url .= http_build_query($req_params);

            // fetch url json data
            $return_data  = $this->fetch_stream( $url );

            $result = json_decode($return_data);

            return $result->id;
        }

        /**
         * Get ID by group name
         *
         * @return int
         */
        public function get_group_id($group_name) {

            $api_data = $this->api_data;
            $access_token = $api_data['access_token'];

            $url = 'https://graph.facebook.com/v11.0/'.$group_name.'/?';

            $req_params = [
              'access_token'  => $access_token,
            ];



            $url .= http_build_query($req_params);

            // fetch url json data
            $return_data  = $this->fetch_stream( $url );

            $result = json_decode($return_data);

            return $result->id;

        }
}

endif;
