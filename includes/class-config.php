<?php
/**
 * Ai Robot Config Class
 *
 * @since  1.0.0
 * @package Ai Robot
 */

defined( 'ABSPATH' ) or exit;

if ( ! class_exists( 'Ai_Robot_Config' ) ) :

    /**
     * Ai Robot Config
     */
    class Ai_Robot_Config {

        public static $templateFields=array(
            'video_embed'=>'videoEmbed',
            'video_key'=>'videoKey',
            'video_url'=>'videoUrl',
            'video_title'=>'videoTitle',
            'video_description'=>'videoDescription',
            'video_duration'=>'videoDuration',
            'video_views'=>'videoViews',
            'video_favorites'=>'videoFavorites',
            'video_likes'=>'videoLikes',
            'video_dislikes'=>'videoDislikes',
            'video_comments'=>'videoComments',
            'video_publishedAt'=>'videoPublishedAt',
            'thumbnail_maxres_url'=>'thumbnailMaxresUrl',
            'thumbnail_standard_url'=>'thumbnailStandardUrl',
            'thumbnail_high_url'=>'thumbnailHighUrl',
            'thumbnail_medium_url'=>'thumbnailMediumUrl',
            'thumbnail_default_url'=>'thumbnailDefaultUrl'
        );
    }

endif;
