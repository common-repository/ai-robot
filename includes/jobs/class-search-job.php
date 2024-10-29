<?php
/**
 * Ai_Robot_Search_Job Class
 *
 * @since  1.0.0
 * @package Ai Robot
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit;
} // Exit if accessed directly

if ( ! class_exists( 'Ai_Robot_Search_Job' ) ) :

    class Ai_Robot_Search_Job extends Ai_Robot_Job{

        /**
         * Feed Link
         *
         * @var string
         */
        public $feed_link = '';

        /**
         * Ai_Robot_Search_Job constructor.
         *
         * @since 1.0.0
         */
        public function __construct($id, $type, $keyword, $settings) {
            $this->id = $id;
            $this->keyword = $keyword;
            $this->settings = $settings;
            $this->logger = new Ai_Robot_Log($id);
            $this->log = array();

            // Fetch Open AI Data
            $this->get_api_data('open-ai');
        }

        /**
         * Get API Data.
         *
         * @since 1.0.0
         */
        public function get_api_data($type) {
            $this->api_data = Ai_Robot_Addon_Loader::get_instance()->get_addon_data($type);
        }

        /**
         * Run this job
         *
         * @return array
         */
        public function run(){
            $response = array();

            // Fetch Data
            $data = $this->fetch_data();

            if(is_object($data)){
                $this->log[] = array(
                    'message'   => $data->errors['simplepie-error'][0],
                    'level'     => 'error'
                );
            }else{
                //$title = $data['title'];

                // Build post content
                $content = $this->chatgpt_generate_post($this->keyword);
                //$content = $this->chatgpt_generate_post($title);
                //$content .= '<a href="'.$data['link'].'">source</a>';

                // Generate New Post
                $this->create_post($content['title'], $content['post'], $this->settings, $data['featured_image']);
            }

            // Add this job running log to system log file
            foreach($this->log as $key => $value){
                $this->logger->add($value['message'], $value['level']);
            }

            return $this->log;
        }

        /**
        * Fetch Data
        *
        * @return array
        */
        public function fetch_data() {
            $robot_init_language = str_replace('_', ':' ,$this->settings['robot_init_language']);
            $pieces = explode(":", $robot_init_language);
            $country_code = $pieces[0];
            $language_code = $pieces[1];

            // Search google news feed by keyword
            $url = 'https://news.google.com/rss/search?';
            $req_params = [
                'q' => $this->keyword,
                'hl' => $language_code,
                'gl' => $country_code,
                'ceid' => $robot_init_language,
            ];

            $url .= http_build_query($req_params);

            // Get RSS Feed(s)
            include_once( ABSPATH . WPINC . '/feed.php' );

            // Get a SimplePie feed object from the specified feed source.
            $rss = fetch_feed( $url );

            $maxitems = 0;

            // Checks that the object is created correctly
            if ( ! is_wp_error( $rss ) ) {

                // Figure out how many total items there are, but limit it to 5.
                $maxitems = $rss->get_item_quantity();

                // Build an array of all the items, starting with element 0 (first element).
                $rss_items = $rss->get_items(0, $maxitems);

                foreach($rss_items as $item){
                    if(!is_null($item) && !$this->is_title_duplicate($item->get_title())){
                        $single_item = $item;
                    }
                }

                $return = array();
                if(!is_null($single_item)){
                    // get title
                    $return['title'] = $single_item->get_title();
                    $return['link'] = $single_item->get_permalink();

                    $this->log[] = array(
                        'message'   => 'Fetch Title: '.$return['title'],
                        'level'     => 'log'
                    );

                }else{
                    $this->log[] = array(
                        'message'   => 'There is no new post from this source, Ai Robot will generate new post again when this source have update',
                        'level'     => 'log'
                    );
                }


                return $return;
            }else{
                return $rss;
            }

        }

        /**
         * Get og:image source
         *
         * @return string
         */
        private function get_og_image($original_content){

            $og_img = '';

            // let's find og:image may be the content we got has no image
            preg_match ( '{<meta[^<]*?(?:property|name)=["|\']og:image["|\'][^<]*?>}s', $original_content, $plain_og_matches );

            if (isset ( $plain_og_matches [0] ) && stristr ( $plain_og_matches [0], 'og:image' )) {
                preg_match ( '{content=["|\'](.*?)["|\']}s', $plain_og_matches [0], $matches );
                $og_img = $matches [1];
            }

            return $og_img;
        }

        // Chatgpt Generate Post
        private function chatgpt_generate_post($prompt) {
            // Use the ChatGPT API to generate the post content
            $api_key = $this->api_data['api_key'];
            $url = 'https://api.openai.com/v1/chat/completions';

            // use http bearer authentication
            $headers = array(
                'Content-Type' => 'application/json',
                'Authorization' => 'Bearer ' . $api_key
            );

            $body = '{
                "model": "gpt-3.5-turbo",
                "messages": [{"role": "user", "content": "'.$prompt.'"}],
                "temperature": '.$this->settings['temperature'].',
                "max_tokens": '.$this->settings['max_tokens'].'}';

            // fetch url json data
            $return_data  = $this->post_request( $url, $headers, $body);

            $result = json_decode($return_data, true);

            $rawContent = $result['choices'][0]['message']['content'];

            //$content = $this->remove_first_paragraph($rawContent);

            // Split the input string into paragraphs
            $pieces = explode(".", $rawContent);

            $content = array();

            $content['title'] = $pieces[0];
            $content['post'] = $rawContent;

            return $content;
        }

        private function remove_first_paragraph($input){
            // Split the input string into paragraphs
            $paragraphs = explode(".", $input);

            // Remove the first two paragraphs
            array_splice($paragraphs, 0, 2);

            // Join the remaining paragraphs into a string
            $output = implode(".", $paragraphs);

            // Print the output
            return $output;
        }

        /**
         * Fetch stream bt HTTP POST Method
         *
         * @param  string $url
         * @return string
         */
        private function post_request( $url, $headers = array(), $body) {
            // build http request args
            $args = array(
                'headers' => $headers,
                'body'    => $body,
                'method'  => 'POST',
                'timeout' => 45,
            );

            $request = wp_remote_post( $url, $args );

            // retrieve the body from the raw response
            $json_posts = wp_remote_retrieve_body( $request );

            // log error messages
            if ( is_wp_error( $request ) ) {
                $this->log[] = array(
                    'message'   => 'Fetching failed with WP_Error: '. $request->errors['http_request_failed'][0],
                    'level'     => 'warn'
                );
                return $request;
            }

            if ( $request['response']['code'] != 200 ) {
                $this->log[] = array(
                    'message'   => 'Fetching failed with code: ' . $request['response']['code'],
                    'level'     => 'error'
                );
                return false;
            }

            return $json_posts;

        }

}
endif;
