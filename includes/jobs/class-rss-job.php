<?php
/**
 * Ai_Robot_RSS_Job Class
 *
 * @since  1.0.0
 * @package Ai Robot
 */

use Google\Cloud\Translate\V2\TranslateClient;

if ( ! defined( 'ABSPATH' ) ) {
    exit;
} // Exit if accessed directly

if ( ! class_exists( 'Ai_Robot_RSS_Job' ) ) :

    class Ai_Robot_RSS_Job extends Ai_Robot_Job{

        /**
         * Feed Link
         *
         * @var string
         */
        public $feed_link = '';

        /**
         * Ai_Robot_RSS_Job constructor.
         *
         * @since 1.0.0
         */
        public function __construct($id, $type, $feed_link, $settings) {
            $this->id = $id;
            $this->feed_link = $feed_link;
            $this->settings = $settings;
            $this->logger = new Ai_Robot_Log($id);
        }

        /**
         * Run this job
         *
         * @return array
         */
        public function run(){
            $title = '';
            $content = '';

            // Fetch Data
            $data = $this->fetch_data();
            if(is_object($data)){
                $this->log[] = array(
                    'message'   => $data->errors['simplepie-error'][0],
                    'level'     => 'error'
                );
            }else{
                $title = $data['title'];

                // Build post content
                $content = $data['content'].'<br>';
                $content .= '<a href="'.$data['link'].'">source</a>';

                // Generate New Post
                $this->create_post($title, $content, $this->settings, $data['featured_image']);
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
            // Get RSS Feed(s)
            include_once( ABSPATH . WPINC . '/feed.php' );

            $this->log[] = array(
                'message'   => 'Start process feed: '.$this->feed_link,
                'level'     => 'log'
            );

            // Get a SimplePie feed object from the specified feed source.
            $rss = fetch_feed( $this->feed_link );

            $maxitems = 0;

            // Checks that the object is created correctly
            if ( ! is_wp_error( $rss ) ) {

                // Figure out how many total items there are, but limit it to 5.
                $maxitems = $rss->get_item_quantity();

                $this->log[] = array(
                    'message'   => 'Feed contains '.$maxitems.' total items',
                    'level'     => 'log'
                );

                // Build an array of all the items, starting with element 0 (first element).
                $rss_items = $rss->get_items(0, $maxitems);

                $rand = rand(0, $maxitems-1);

                $return = array();

                // translate title
                $return['title'] = $this->translate_innertext($rss_items[$rand]->get_title());
                $return['link'] = $rss_items[$rand]->get_permalink();
                $return['content'] = $rss_items[$rand]->get_content();

                // Fetch origin content
                $original_content  = $this->fetch_stream( $return['link'] );

                $return['featured_image'] = $this->get_og_image($original_content);

                $this->log[] = array(
                    'message'   => 'Fetch Title: '.$return['title'],
                    'level'     => 'log'
                );
                $this->log[] = array(
                    'message'   => 'Fetch URL: <a href="'.$return['link'].'">'.$return['link'].'</a>',
                    'level'     => 'log'
                );

                // get scripts
				$postponedScripts = array ();
				preg_match_all ( '{<script.*?</script>}s', $original_content, $scriptMatchs );
				$scriptMatchs = $scriptMatchs [0];

				foreach ( $scriptMatchs as $singleScript ) {
					if (stristr ( $singleScript, 'connect.facebook' )) {
						$postponedScripts [] = $singleScript;
					}

					$original_content = str_replace ( $singleScript, '', $original_content );
				}

                $ai_robot_Readability = new ai_robot_Readability ( $original_content, $return['link'] );

					$ai_robot_Readability->debug = false;
					$result = $ai_robot_Readability->init ();

					if ($result) {

						// Redability title
						$title = $ai_robot_Readability->getTitle ()->textContent;

						// Redability Content
						$content = $ai_robot_Readability->getContent ()->innerHTML;

						// twitter embed fix
						if (stristr ( $content, 'twitter.com' ) && ! stristr ( $content, 'platform.twitter' )) {
							$content .= '<script async src="//platform.twitter.com/widgets.js" charset="utf-8"></script>';
						}

						// Remove ai_robot_Readability attributes
						$content = preg_replace ( '{ ai_robot_Readability\=".*?"}s', '', $content );

						// Fix iframe if exists
						preg_match_all ( '{<iframe[^<]*/>}s', $content, $ifrMatches );
						$iframesFound = $ifrMatches [0];

						foreach ( $iframesFound as $iframeFound ) {

							$correctIframe = str_replace ( '/>', '></iframe>', $iframeFound );
							$content = str_replace ( $iframeFound, $correctIframe, $content );
						}

						// add postponed scripts
						if (count ( $postponedScripts ) > 0) {
							$content .= implode ( '', $postponedScripts );
						}

						// Cleaning redability for better memory
						unset ( $ai_robot_Readability );
						unset ( $result );

						// Check existence of title words in the content
						$title_arr = explode ( ' ', $title );

						$valid = '';
						$nocompare = array (
								'is',
								'Is',
								'the',
								'The',
								'this',
								'This',
								'and',
								'And',
								'or',
								'Or',
								'in',
								'In',
								'if',
								'IF',
								'a',
								'A',
								'|',
								'-'
						);
						foreach ( $title_arr as $title_word ) {

							if (strlen ( $title_word ) > 3) {

								if (! in_array ( $title_word, $nocompare ) && preg_match ( '/\b' . preg_quote ( trim ( $title_word ), '/' ) . '\b/ui', $content )) {
                                    $this->log[] = array(
                                        'message'   => 'Title word ' . $title_word . ' exists on the content, approving.',
                                        'level'     => 'log'
                                    );

									$valid = 'yeah';
									break;
								} else {
									// echo '<br>Word '.$title_word .' does not exists';
								}
							}
						}

						if (trim ( $valid ) != '') {

							$return['content'] = $content;
							$return['matched_content'] = $content;
							$return['og_img'] = '';

							// let's find og:image may be the content we got has no image
							preg_match ( '{<meta[^<]*?property=["|\']og:image["|\'][^<]*?>}s', $html, $plain_og_matches );

							if (isset ( $plain_og_matches [0] ) && @stristr ( $plain_og_matches [0], 'og:image' )) {
								preg_match ( '{content=["|\'](.*?)["|\']}s', $plain_og_matches [0], $matches );
								$og_img = $matches [1];

								if (trim ( $og_img ) != '') {
									$return['og_img'] = $og_img;
								}
							} // If og:image

                            $feature_image_src = $this->get_image_src($return['content']);
                            if(!empty($feature_image_src)){
                                $return['featured_image'] = $this->get_image_src($return['content']);
                            }
						} else {
                            $this->log[] = array(
                                'message'   => 'Can not make sure if the returned content is the full content, using excerpt instead.',
                                'level'     => 'log'
                            );
						}
					} else {
                        $this->log[] = array(
                            'message'   => 'Looks like we couldn\'t find the full content. :( returning summary',
                            'level'     => 'log'
                        );
					}



                return $return;

            }else{
                return $rss;
            }

        }


        /**
         * Translate inner text
         *
         * @return string
         */
        private function translate_innertext($innertext){

            // translate content for rss campaigns
            if(isset($this->settings['translation']) && $this->settings['translation'] == 'translation-on'){
                switch ( $this->settings['robot_translation_api'] ) {
                    case 0:
                        $translate = new TranslateClient([
                            'key' => 'AIzaSyBOti4mM-6x9WDnZIjIeyEU21OpBXqWBgw'
                        ]);
                        // Translate text.
                        $result = $translate->translate($innertext, ['target' => $this->settings['robot_translation_to_language']]);
                        return $result['text'];
                        break;
                    case 1:
                        break;
                    default:
                        break;
                }
            }else{
                return $innertext;
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

        /**
         * Get imgae source
         *
         * @return string
         */
        private function get_image_src($original_content){
            $dom = new DOMDocument();
            $dom->loadHTML($original_content);
            if(is_object($dom->getElementsByTagName('img')->item(0))){
                return $dom->getElementsByTagName('img')->item(0)->getAttribute('src');
            }else{
                return '';
            }

        }
}

endif;
