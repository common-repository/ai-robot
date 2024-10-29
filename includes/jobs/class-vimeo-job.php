<?php
/**
 * Ai_Robot_Vimeo_Job Class
 *
 * @since  1.0.0
 * @package Ai Robot
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit;
} // Exit if accessed directly

if ( ! class_exists( 'Ai_Robot_Vimeo_Job' ) ) :

    class Ai_Robot_Vimeo_Job extends Ai_Robot_Job{

        /**
         * Ai_Robot_Job constructor.
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
            // Fetch Facebook Data
            $data = $this->fetch_data();

            // Create new post when return data is not null
            if(!is_null($data)) {
                $title = $data['title'];
                $video_url = $data['link'];
                $video_id = str_replace('https://vimeo.com/', '', $video_url);

                $this->log[] = array(
                    'message'   => 'Fetch Vimeo Title: ' . $title,
                    'level'     => 'log'
                );
                $this->log[] = array(
                    'message'   => 'Fetch Vimeo URL: <a href="' . $video_url . '">' . $video_url . '</a>',
                    'level'     => 'log'
                );

                // Build post content
                $content = '<iframe title="' . $title . '" src="https://player.vimeo.com/video/' . $video_id . '?title=0&amp;byline=0&amp;portrait=0&amp;badge=0&amp;autopause=0&amp;player_id=0&amp;app_id=175271" width="560" height="280" frameborder="0" allowfullscreen="allowfullscreen"></iframe>';
                $content .= '<br><a href="' . $video_url . '">source</a>';

                // Generate New Post
                $new_post = $this->create_post($title, $content, $this->settings);

//                // if post title duplicate create post again
//                if (false === $new_post['error']) {
//                    $this->run();
//                }
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
            $access_token = $api_data['access_token'];

            $url = 'https://api.vimeo.com/videos?';

            $req_params = [
                'query' => urlencode($this->keyword),
                'page'  => 1,
                'per_page' => 50,
                'sort'  => 'relevant',
                'direction' => 'desc'
            ];

            $url .= http_build_query($req_params);

            // vimeo api need http bearer authentication
            $header = array(
                'Authorization' => 'Bearer ' . $access_token
            );

            // fetch url json data
            $return_data  = $this->fetch_stream( $url, $header );

            $result = json_decode($return_data, true);

            $data = $result['data'];

            $output = array_slice($data, 0, 20);

            $videos = array();
            foreach($output as $key => $value){
                $videos[$key]['title'] = $value['name'];
                $videos[$key]['created_time'] = $value['created_time'];
                $videos[$key]['link'] = $value['link'];
                $videos[$key]['embed'] = $value['embed']['html'];
            }

            $rand = rand(0, 49);
            return $videos[$rand];

        }
}

endif;
