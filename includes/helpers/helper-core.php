<?php
if ( ! defined( 'ABSPATH' ) ) {
    exit;
} // Exit if accessed directly

/**
 * Return needed cap for admin pages
 *
 * @since 1.0.0
 * @return string
 */
function ai_robot_get_admin_cap() {
	$cap = 'manage_options';

	if ( is_multisite() && is_network_admin() ) {
		$cap = 'manage_network';
	}

	return apply_filters( 'ai_robot_admin_cap', $cap );
}

/**
 * Enqueue admin fonts
 *
 * @since 1.0.0
 * @since 1.5.1 implement $version
 *
 * @param $version
 */
function ai_robot_admin_enqueue_fonts( $version ) {
	wp_enqueue_style(
		'ai_robot-roboto',
		'https://fonts.googleapis.com/css?family=Roboto+Condensed:300,300i,400,400i,700,700i|Roboto:300,300i,400,400i,500,500i,700,700i',
		array(),
		'1.0.0'
	); // cache as long as you can
	wp_enqueue_style(
		'ai_robot-opensans',
		'https://fonts.googleapis.com/css?family=Open+Sans:400,400i,700,700i',
		array(),
		'1.0.0'
	); // cache as long as you can
	wp_enqueue_style(
		'ai_robot-source',
		'https://fonts.googleapis.com/css?family=Source+Code+Pro',
		array(),
		'1.0.0'
	); // cache as long as you can

	// if plugin internal font need to enqueued, please use $version as its subject to cache
}

/**
 * Enqueue admin styles
 *
 * @since 1.0.0
 * @since 1.1 Remove ai_robot-admin css after migrate to shared-ui
 *
 * @param $version
 */
function ai_robot_admin_enqueue_styles( $version ) {
	wp_enqueue_style( 'magnific-popup', AI_ROBOT_URL . 'assets/css/magnific-popup.css', array(), $version, false );
    wp_enqueue_style( 'ai-robot-select2-style', AI_ROBOT_URL . 'assets/css/select2.min.css', array(), $version, false );
    wp_enqueue_style( 'ai-robot-main-style', AI_ROBOT_URL . 'assets/css/main.css', array(), $version, false );
}


/**
 * Load admin scripts
 *
 * @since 1.0.0
 */
function ai_robot_admin_jquery_ui_init() {
	wp_enqueue_script( 'jquery-ui-core' );
	wp_enqueue_script( 'jquery-ui-widget' );
	wp_enqueue_script( 'jquery-ui-mouse' );
	wp_enqueue_script( 'jquery-ui-tabs' );
	wp_enqueue_script( 'jquery-ui-sortable' );
	wp_enqueue_script( 'jquery-ui-draggable' );
	wp_enqueue_script( 'jquery-ui-droppable' );
	wp_enqueue_script( 'jquery-ui-datepicker' );
	wp_enqueue_script( 'jquery-ui-resize' );
	wp_enqueue_style( 'wp-color-picker' );
}

/**
 * Enqueue admin welcome scripts
 *
 * @since 1.0.0
 *
 * @param       $version
 * @param array $data
 * @param array $l10n
 */
function ai_robot_admin_enqueue_scripts_welcome( $version, $data = array(), $l10n = array() ) {
    wp_enqueue_script( 'ionicons', 'https://unpkg.com/ionicons@5.0.0/dist/ionicons.js', array(), $version, false );

    wp_register_script(
		'ai-robot-welcome',
		AI_ROBOT_URL . '/assets/js/welcome.js',
        array( 'jquery', 'wp-util' ),
		$version,
		true
	);

    wp_register_script(
		'ai-robot-snap',
		AI_ROBOT_URL . '/assets/js/library/snap.svg-min.js',
		array(),
		$version,
		true
	);

    wp_enqueue_script( 'ai-robot-snap' );
    wp_enqueue_script( 'ai-robot-welcome' );
    wp_localize_script( 'ai-robot-welcome', 'Ai_Robot_Data', $data );
}

/**
 * Enqueue admin import scripts
 *
 * @since 1.0.0
 *
 * @param       $version
 * @param array $data
 * @param array $l10n
 */
function ai_robot_admin_enqueue_scripts_import( $version, $data = array(), $l10n = array() ) {
    wp_enqueue_script( 'ionicons', 'https://unpkg.com/ionicons@5.0.0/dist/ionicons.js', array(), $version, false );

    wp_register_script(
		'ai-robot-import',
		AI_ROBOT_URL . '/assets/js/import.js',
        array( 'jquery', 'wp-util' ),
		$version,
		true
	);

    wp_enqueue_script( 'ai-robot-import' );
    wp_localize_script( 'ai-robot-import', 'Ai_Robot_Data', $data );
}

/**
 * Enqueue admin scripts
 *
 * @since 1.0.0
 *
 * @param       $version
 * @param array $data
 * @param array $l10n
 */
function ai_robot_admin_enqueue_scripts( $version, $data = array(), $l10n = array() ) {

    if ( function_exists( 'wp_enqueue_editor' ) ) {
        wp_enqueue_editor();
    }
    if ( function_exists( 'wp_enqueue_media' ) ) {
        wp_enqueue_media();
    }

	wp_enqueue_script( 'ionicons', 'https://unpkg.com/ionicons@5.0.0/dist/ionicons.js', array(), $version, false );

    wp_enqueue_script( 'ai-robot-select2', AI_ROBOT_URL . '/assets/js/library/select2.min.js', array( 'jquery' ), $version, false );

    wp_enqueue_script( 'jquery-magnific-popup', AI_ROBOT_URL . '/assets/js/library/jquery.magnific-popup.min.js', array( 'jquery' ), $version, false );

    wp_register_script(
        'ai-robot-admin',
        AI_ROBOT_URL . '/assets/js/main.js',
        array(
            'jquery'
        ),
        $version,
        true
    );
	wp_register_script(
		'ai-robot-action',
		AI_ROBOT_URL . '/assets/js/action.js',
		array(
			'jquery'
		),
		$version,
		true
	);
    wp_register_script(
		'ai-robot-list',
		AI_ROBOT_URL . '/assets/js/list.js',
		array(
			'jquery'
		),
		$version,
		true
	);
	wp_register_script(
		'ai-robot-addon',
		AI_ROBOT_URL . '/assets/js/addon.js',
		array(
			'jquery'
		),
		$version,
		true
	);
    wp_register_script(
        'ai-robot-settings',
        AI_ROBOT_URL . '/assets/js/settings.js',
        array(
            'jquery'
        ),
        $version,
        true
    );

    wp_enqueue_script( 'ai-robot-admin' );
    wp_enqueue_script( 'ai-robot-action' );
    wp_enqueue_script( 'ai-robot-list' );
	wp_enqueue_script( 'ai-robot-addon' );
    wp_enqueue_script( 'ai-robot-settings' );

    wp_localize_script( 'ai-robot-action', 'Ai_Robot_Data', $data );
}

/**
 * Enqueue admin wizard scripts
 *
 * @since 1.0.0
 *
 * @param       $version
 * @param array $data
 * @param array $l10n
 */
function ai_robot_admin_enqueue_scripts_wizard( $version, $data = array(), $l10n = array() ) {
    wp_enqueue_script( 'ionicons', 'https://unpkg.com/ionicons@5.0.0/dist/ionicons.js', array(), $version, false );

    wp_register_script(
		'ai-robot-wizard',
		AI_ROBOT_URL . '/assets/js/wizard.js',
		array(
			'jquery'
		),
		$version,
		true
	);

    wp_enqueue_script( 'ai-robot-wizard' );

    wp_localize_script( 'ai-robot-wizard', 'Ai_Robot_Data', $data );
}

/**
 * Enqueue admin license scripts
 *
 * @since 1.0.0
 *
 * @param       $version
 * @param array $data
 * @param array $l10n
 */
function ai_robot_admin_enqueue_scripts_license( $version, $data = array(), $l10n = array() ) {
    wp_enqueue_script( 'ionicons', 'https://unpkg.com/ionicons@5.0.0/dist/ionicons.js', array(), $version, false );

    wp_register_script(
		'ai-robot-license',
		AI_ROBOT_URL . '/assets/js/license.js',
		array(
			'jquery'
		),
		$version,
		true
	);

    wp_enqueue_script( 'ai-robot-license' );

    wp_localize_script( 'ai-robot-license', 'Ai_Robot_Data', $data );
}

/**
 * Return AJAX url
 *
 * @since 1.0.0
 * @return mixed
 */
function ai_robot_ajax_url() {
    return admin_url( 'admin-ajax.php', is_ssl() ? 'https' : 'http' );
}

/**
 * Return post status
 *
 * @since 1.0.0
 * @return array
 */
function ai_robot_get_post_status() {
    return apply_filters(
        'ai_robot_post_status',
        array(
            'publish'     => esc_html__( 'Publish','ai-robot' ),
            'draft'     => esc_html__( 'Draft','ai-robot' ),
        )
    );
}

/**
 * Return Components
 *
 * @since 1.0.0
 * @return array
 */
function ai_robot_get_components($source) {

    $components_dir = "campaigns/wizard/components/";

    $components = array();

    switch ( $source ) {
        case 'rss':
            $components = ['campaign-name', 'feed-links', 'content-options'];
            break;
        case 'facebook':
            $components = ['campaign-name', 'facebook-links'];
            break;
        case 'instagram':
            $components = ['campaign-name', 'instagram-source'];
            break;
        case 'youtube':
            $components = ['campaign-name', 'youtube-source'];
            break;
        case 'search':
            $components = ['campaign-name', 'language-location', 'feed-keywords'];
            break;
        default:
            $components = ['campaign-name', 'search-keywords'];
            break;
    }

    foreach($components as $key => $value){
        $components[$key] = $components_dir.$value;
    }

    return $components;
}

/**
 * Process Twitter Campaign Job
 * @param string
 * @since 1.0.0
 * @return array
 */
function ai_robot_get_random($keywords) {
    $keywords_array = explode(', ', $keywords);
    $rand = array_rand($keywords_array);

    return $keywords_array[$rand];
}

/**
 * Process Facebook Campaign Job
 *
 * @since 1.0.0
 * @return array
 */
function ai_robot_process_facebook_job($id, $source, $settings){
    // Initial job class and run this job
    $job = new Ai_Robot_Facebook_Job( $id, $source, $settings);
    $result = $job->run();

    // Return this job running result
    return $result;
}

/**
 * Process Twitter Campaign Job
 *
 * @since 1.0.0
 * @return array
 */
function ai_robot_process_twitter_job($id, $source, $keyword, $settings){
    // Initial job class and run this job
    $job = new Ai_Robot_Twitter_Job( $id, $source, $keyword, $settings);
    $result = $job->run();

    // Return this job running result
    return $result;
}

/**
 * Process Youtube Campaign Job
 *
 * @since 1.0.0
 * @return array
 */
function ai_robot_process_youtube_job($id, $source, $keyword, $settings){
    // Initial job class and run this job
    $job = new Ai_Robot_Youtube_Job( $id, $source, $keyword, $settings);
    $result = $job->run();

    // Return this job running result
    return $result;
}

/**
 * Process Vimeo Campaign Job
 *
 * @since 1.0.0
 * @return array
 */
function ai_robot_process_vimeo_job($id, $source, $keyword, $settings){
    // Initial job class and run this job
    $job = new Ai_Robot_Vimeo_Job( $id, $source, $keyword, $settings);
    $result = $job->run();

    // Return this job running result
    return $result;
}

/**
 * Process Flickr Campaign Job
 *
 * @since 1.0.0
 * @return array
 */
function ai_robot_process_flickr_job($id, $source, $keyword, $settings){
    // Initial job class and run this job
    $job = new Ai_Robot_Flickr_Job( $id, $source, $keyword, $settings);
    $result = $job->run();

    // Return this job running result
    return $result;
}

/**
 * Process RSS Campaign Job
 *
 * @since 1.0.0
 * @return array
 */
function ai_robot_process_rss_job($id, $source, $feed_link, $settings){
    // Initial job class and run this job
    $job = new Ai_Robot_RSS_Job( $id, $source, $feed_link, $settings);
    $result = $job->run();

    // Return this job running result
    return $result;
}

/**
 * Process RSS Search Campaign Job
 *
 * @since 1.0.0
 * @return array
 */
function ai_robot_process_search_job($id, $source, $keyword, $settings){
    // Initial job class and run this job
    $job = new Ai_Robot_Search_Job( $id, $source, $keyword, $settings);
    $result = $job->run();

    // Return this job running result
    return $result;
}

/**
 * Process SoundCloud Campaign Job
 *
 * @since 1.0.0
 * @return array
 */
function ai_robot_process_soundcloud_job($id, $source, $keyword, $settings){
    // Initial job class and run this job
    $job = new Ai_Robot_SoundCloud_Job( $id, $source, $keyword, $settings);
    $result = $job->run();

    // Return this job running result
    return $result;
}

/**
 * Process RSS Campaign Job
 *
 * @since 1.0.0
 * @return int
 */
function ai_robot_calculate_next_time($update_frequency, $update_frequency_unit){
    $time_length = 0;

    switch ( $update_frequency_unit ) {
        case 'Minutes':
            $time_length = $update_frequency*60;
            break;
        case 'Hours':
            $time_length = $update_frequency*60*60;
            break;
        case 'Days':
            $time_length = $update_frequency*60*60*24;
            break;
        default:
            break;
    }

    return $time_length;
}

/**
 * Save remote image to wp upload directory
 */
function ai_robot_upload_image($remote_url, $filename){
    $image = wp_remote_get( $remote_url );
    $upload_dir = wp_upload_dir ();

    if (wp_mkdir_p ( $upload_dir ['path'] )){
        $file = $upload_dir ['path'] . '/' . $filename;
    }else{
        $file = $upload_dir ['basedir'] . '/' . $filename;
    }

	// check if same image name already exists
	if (file_exists ( $file )) {
		$filename = time () . '_' . rand ( 0, 999 ) . '_' . $filename;
		if (wp_mkdir_p ( $upload_dir ['path'] ))
			$file = $upload_dir ['path'] . '/' . $filename;
		else
		    $file = $upload_dir ['basedir'] . '/' . $filename;
	}

	file_put_contents ( $file, $image['body'] );
	$file_link = $upload_dir ['url'] . '/' . $filename;
    $guid = $upload_dir ['url'] . '/' . basename ( $filename );

    ai_robot_save_image_to_media($guid, $filename, $file);

    return $file_link;
}

/**
 * Add image to media library and attach to the post
 */
function ai_robot_save_image_to_media($guid, $filename, $file){
        // atttatchment check if exists or not
        global $wpdb;

        $query = "select * from $wpdb->posts where guid = '$guid' limit 1";
        $already_saved_attachment = $wpdb->get_row ( $query );

        if (isset ( $already_saved_attachment->ID )) {
            $attach_id = $already_saved_attachment->ID;
        } else {
            $wp_filetype = wp_check_filetype ( $filename, null );

            if ($wp_filetype ['type'] == false) {
                $wp_filetype ['type'] = 'image/jpeg';
            }

            // Title handling
            $imgTitle = sanitize_file_name ( $filename );

            $attachment = array (
                    'guid' => $guid,
                    'post_mime_type' => $wp_filetype ['type'],
                    'post_title' => $imgTitle,
                    'post_content' => '',
                    'post_status' => 'inherit'
            );

            $attach_id = wp_insert_attachment ( $attachment, $file);
			$attach_data = wp_generate_attachment_metadata ( $attach_id, $file );
			wp_update_attachment_metadata ( $attach_id, $attach_data );
        }

}

/**
 * Save remote image to wp upload directory
 */
function ai_robot_instagram_upload_image($remote_url, $id, $campaign_id){
    $image = wp_remote_get( $remote_url );
    $filename = $id. '.png';

    $upload_dir = ai_robot_mkdir('ai-robot/'.$campaign_id);
    $file = $upload_dir['path'] . '/' . $filename;

	file_put_contents ( $file, $image['body'] );
	$file_link = $upload_dir['url'] . $filename;

    //$guid = $upload_dir ['url'] . '/' . basename ( $filename );
    //ai_robot_save_image_to_media($guid, $filename, $file);

    return $file_link;
}

/**
* Make file directory
*
* @since 1.2.5
* @param  string $dir_name Directory Name.
*/
function ai_robot_mkdir( $dir_name ) {

    $upload_dir = wp_upload_dir();

     // Build the paths.
     $dir_info = array(
         'path' => $upload_dir['basedir'] . '/' . $dir_name . '/',
         'url'  => $upload_dir['baseurl'] . '/' . $dir_name . '/',
     );

     // Create the upload dir if it doesn't exist.
     if ( ! file_exists( $dir_info['path'] ) ) {

         // Create the directory.
         wp_mkdir_p( $dir_info['path'] );

         // Add an index file for security.
         ai_robot_get_filesystem()->put_contents( $dir_info['path'] . 'index.html', '' );
     }

     return $dir_info;
 }

 /**
 * Get an instance of WP_Filesystem_Direct.
 *
 * @since 1.1.0
 * @return object A WP_Filesystem_Direct instance.
 */
 function ai_robot_get_filesystem() {
     global $wp_filesystem;

     require_once ABSPATH . '/wp-admin/includes/file.php';

     WP_Filesystem();

     return $wp_filesystem;
 }
