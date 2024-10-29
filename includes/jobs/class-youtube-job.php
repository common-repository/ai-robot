<?php
/**
 * Ai_Robot_Youtube_Job Class
 *
 * @since  1.0.0
 * @package Ai Robot
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit;
} // Exit if accessed directly

if ( ! class_exists( 'Ai_Robot_Youtube_Job' ) ) :

    class Ai_Robot_Youtube_Job extends Ai_Robot_Job{

        public $videoEmbed;
        public $videoKey;
        public $videoUrl;
        public $videoTitle;
        public $videoDescription;

        public $videoDuration;
        public $videoViews;
        public $videoFavorites;
        public $videoLikes;
        public $videoDislikes;
        public $videoComments;
        public $videoPublishedAt;

        public $thumbnailMaxresUrl;
        public $thumbnailStandardUrl;
        public $thumbnailHighUrl;
        public $thumbnailMediumUrl;
        public $thumbnailDefaultUrl;

        public $thumbnailsQuality;

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
            // Fetch Data
            $data = $this->fetch_data();

            // Create new post when return data is not null
            if(!is_null($data)){
                $this->log[] = array(
                    'message'   => 'Fetch Youtube Title: '.$this->videoTitle,
                    'level'     => 'log'
                );
                $this->log[] = array(
                    'message'   => 'Fetch Youtube URL: <a href="'.$this->videoUrl.'">'.$this->videoUrl.'</a>',
                    'level'     => 'log'
                );

                $content = $this->parseTemplate($this->settings['robot_youtube_main_post_content'], Ai_Robot_Config::$templateFields);

                // Generate New Post
                $this->create_post($this->videoTitle, $content, $this->settings);
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

            $source_category = $this->settings['robot_youtube_source_category'];

            // Check if cache youtube data exists
            $auto_youtube_cache_key = 'auto_youtube_cache_'.$source_category.'_'.$this->id;
            $auto_youtube_cache_value = get_option( $auto_youtube_cache_key, false );
            $return_data = '';

            // Set youtube cache value empty when source type is keywords
            if ( $source_category == 'keywords') {
                $auto_youtube_cache_value = '';
            }

            // Start fetch data from youtube api
            if ( ! $auto_youtube_cache_value || empty($auto_youtube_cache_value) ) {

                $api_data = $this->api_data;
                $api_key = $api_data['api_key'];
                $limit = 50;

                switch ( $source_category ) {
                    case 'playlist':
                        $url = 'https://www.googleapis.com/youtube/v3/playlistItems?part=snippet&type=video&';
                        $req_params = [
                            'key'  => $api_key,
                            'playlistId' => $this->settings['robot_youtube_playlist'],
                            'maxResults' => $limit,
                        ];
                        break;
                    case 'channel':
                        $url = 'https://www.googleapis.com/youtube/v3/channels?part=contentDetails,snippet&';
                        $req_params = [
                            'id' => $this->settings['robot_youtube_channel'],
                            'key' => $api_key,
                        ];
                        $url .= http_build_query($req_params);
                        // Get playlist ID by channel
                        $return_data  = $this->fetch_stream( $url );
                        $video_list = json_decode($return_data);
                        $playlistId = $video_list->items[0]->contentDetails->relatedPlaylists->uploads;

                        $url = 'https://www.googleapis.com/youtube/v3/playlistItems?part=snippet&type=video&';
                        $req_params = [
                            'key'  => $api_key,
                            'playlistId' => $playlistId,
                            'maxResults' => $limit,
                        ];

                        break;
                    case 'keywords':
                        $url = 'https://www.googleapis.com/youtube/v3/search?part=snippet&type=video&';
                        $req_params = [
                            'key'  => $api_key,
                            'q' => $this->keyword,
                            'maxResults' => $limit,
                        ];
                        break;
                    default:
                        break;
                }

                $url .= http_build_query($req_params);

                // fetch url json data
                $return_data  = $this->fetch_stream( $url );

                // Check if return data is an empty array
                if(empty($return_data)){
                    return null;
                }else{
                    // Update youtube data cache
                    update_option( $auto_youtube_cache_key, $return_data );
                    $this->log[] = array(
                        'message'   => 'Update youtube cache data on'.time(),
                        'level'     => 'info'
                    );
                }

            }else{
                $return_data = $auto_youtube_cache_value;
            }

            $result = json_decode($return_data);

            // return random video item
            $rand_key = array_rand($result->items, 1);
            $video = $result->items[$rand_key];

            if($source_category === 'playlist' || $source_category === 'channel'){
                $this->videoKey = $video->snippet->resourceId->videoId;
            }else{
                $this->videoKey = $video->id->videoId;
            }

            $this->videoUrl = 'https://www.youtube.com/watch?v='.$this->videoKey;
            $this->videoTitle = $video->snippet->title;
            $this->videoDescription = $video->snippet->description;
            $this->videoPublishedAt = $video->snippet->publishedAt;

            $this->thumbnailStandardUrl = $video->snippet->thumbnails->standard->url;
            $this->thumbnailHighUrl = $video->snippet->thumbnails->high->url;
            $this->thumbnailMediumUrl = $video->snippet->thumbnails->medium->url;
            $this->thumbnailDefaultUrl = $video->snippet->thumbnails->default->url;
            $this->thumbnailMaxresUrl = $video->snippet->thumbnails->maxres->url;

            $width = 680;
            $height = 485;
            $this->videoEmbed = '<iframe width="'.$width.'" height="'.$height.'" src="//www.youtube.com/embed/'.$this->videoKey.'" frameborder="0" allowfullscreen></iframe>';

            $this->videoDuration = $this->getSingleVideoDuration($this->videoKey);
            $statistics = $this->getSingleVideoStatistics($this->videoKey);

            $this->videoComments = $statistics->commentCount;
            $this->videoViews = $statistics->viewCount;
            $this->videoLikes = $statistics->likeCount;
            $this->videoDislikes = $statistics->dislikeCount;
            $this->videoFavorites = $statistics->favoriteCount;

            return $video;

        }

        /**
         * Parse template
         */
        private function parseTemplate($template, $fields)
        {
            $pattern = "/\{\{(\w+)\}\}/";
            $res = array();

            $object_vars =  get_object_vars($this);
            preg_match_all($pattern, $template, $res, PREG_SET_ORDER);

            foreach ($res as $r)
            {
                $current_field=$fields[$r[1]];
                if (isset($object_vars[$current_field]))
                    $template = str_replace($r[0],$object_vars[$current_field],$template);
                else
                    $template = str_replace($r[0],'', $template);
            }//foreach

            return $template;
        }//parseTemplate

        /**
         * Get single video duration
         *
         * @return string
         */
        private function getSingleVideoDuration($id) {
            // Check if cache duration youtube data exists
            $auto_youtube_duration_cache_key = 'auto_youtube_duration_cache_'.$id;
            $auto_youtube_duration_cache_value = get_option( $auto_youtube_duration_cache_key, false );

            if ( ! $auto_youtube_duration_cache_value || empty($auto_youtube_duration_cache_value) ) {

                $api_data = $this->api_data;
                $api_key = $api_data['api_key'];

                $url = 'https://www.googleapis.com/youtube/v3/videos?part=snippet,contentDetails&';

                $req_params = [
                    'id' => $id,
                    'key' => $api_key,
                ];

                $url .= http_build_query($req_params);

                // fetch url json data
                $return_data  = $this->fetch_stream( $url );

                // Check if return data is an empty array
                if(empty($return_data)){
                    return null;
                }else{
                    // Update youtube data cache
                    update_option( $auto_youtube_duration_cache_key, $return_data );
                    $this->log[] = array(
                        'message'   => 'Update youtube duration video '.$id.' cache data on'.time(),
                        'level'     => 'info'
                    );
                }
            }else{
                $return_data = $auto_youtube_duration_cache_value;
            }

            $result = json_decode($return_data);

            return $result->items[0]->contentDetails->duration;
        }

        private function getSingleVideoStatistics($id) {
            // Check if cache statistics youtube data exists
            $auto_youtube_statistics_cache_key = 'auto_youtube_statistics_cache_'.$id;
            $auto_youtube_statistics_cache_value = get_option( $auto_youtube_statistics_cache_key, false );

            if ( ! $auto_youtube_statistics_cache_value || empty($auto_youtube_statistics_cache_value) ) {

                $api_data = $this->api_data;
                $api_key = $api_data['api_key'];

                $url = 'https://www.googleapis.com/youtube/v3/videos?part=statistics&';

                $req_params = [
                    'id' => $id,
                    'key' => $api_key
                ];

                $url .= http_build_query($req_params);

                // fetch url json data
                $return_data  = $this->fetch_stream( $url );

                // Check if return data is an empty array
                if(empty($return_data)){
                    return null;
                }else{
                    // Update youtube data cache
                    update_option( $auto_youtube_statistics_cache_key, $return_data );
                    $this->log[] = array(
                        'message'   => 'Update youtube statistics video '.$id.' cache data on'.time(),
                        'level'     => 'info'
                    );
                }
            }else{
                $return_data = $auto_youtube_statistics_cache_value;
            }

            $result = json_decode($return_data);

            return $result->items[0]->statistics;

        }

    }

endif;
