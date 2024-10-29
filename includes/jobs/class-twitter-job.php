<?php
/**
 * Ai_Robot_Twitter_Job Class
 *
 * @since  1.0.0
 * @package Ai Robot
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit;
} // Exit if accessed directly

if ( ! class_exists( 'Ai_Robot_Twitter_Job' ) ) :

    class Ai_Robot_Twitter_Job extends Ai_Robot_Job{

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
            // Fetch Tweet
            $tweet = $this->fetch_data();

            // Create new post when return data is not null
            if(!is_null($tweet)){
                $text = $tweet['text'];
                $this->log[] = array(
                    'message'   => 'Fetch Tweet: '.$text,
                    'level'     => 'log'
                );

                $title = substr($text, 0, 45);
                //$tweet_url = 'https://www.twitter.com/p/'.$data['shortcode'];

                // Build post content
                $content = $text.'<br>';
                //$content .= '<a href="'.$tweet_url.'">source</a>';

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
            $client_id = $api_data['client_id'];
            $client_secret = $api_data['client_secret'];

            // generate a new twitter access token
            $concated = urlencode($client_id) . ':'. urlencode($client_secret);

            $header = [
                'Authorization' => 'Basic ' . base64_encode($concated),
                'content-type'  => 'application/x-www-form-urlencoded;charset=UTF-8.'
            ];

            // Get access token
            $url = 'https://api.twitter.com/oauth2/token';

            $body = [
                'grant_type' => 'client_credentials'
            ];

            // fetch url json data
            $return_data  = $this->fetch_post( $url, $header, $body );

            $return_token = json_decode($return_data);

            $access_token = $return_token->access_token;

            // start fetch tweets use http bearer authentication
            $header = array(
                'Authorization' => 'Bearer ' . $access_token
            );

            $url='https://api.twitter.com/1.1/search/tweets.json?';

            $req_params = [
                'tweet_mode' => 'extended',
                'q' => urlencode(trim($this->keyword))
            ];

            $url .= http_build_query($req_params);

            // fetch url json data
            $return_data  = $this->fetch_stream( $url, $header );

            $result = json_decode($return_data);

            $tweets = array();
            foreach($result->statuses as $key => $value) {
                $tweets[$key]['text'] = $value->full_text;
                $tweets[$key]['created_at'] = $value->created_at;
                $tweets[$key]['id'] = $value->id;
            }

            $rand = rand(0, 14);
            return $tweets[$rand];

        }
    }

endif;
