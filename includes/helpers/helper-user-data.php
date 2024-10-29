<?php
if ( ! defined( 'ABSPATH' ) ) {
    exit;
} // Exit if accessed directly

/**
 * Save user data
 *
 * @since 1.0.0
 * @return string
 */
function ai_robot_save_user_data(){
	global $wp_version, $wpdb;
    $theme_details = array();
	if ( $wp_version >= 3.4 ) {
		$active_theme                   = wp_get_theme();
		$theme_details['theme_name']    = strip_tags( $active_theme->name );
		$theme_details['theme_version'] = strip_tags( $active_theme->version );
		$theme_details['author_url']    = strip_tags( $active_theme->{'Author URI'} );
    }

	$plugin_stat_data                     = array();
	$plugin_stat_data['plugin_slug']      = 'ai-robot-lite';
	$plugin_stat_data['type']             = 'standard_edition';
	$plugin_stat_data['version_number']   = AI_ROBOT_VERSION;
	$plugin_stat_data['event']            = 'activate';
	$plugin_stat_data['domain_url']       = site_url();
	$plugin_stat_data['wp_language']      = defined( 'WPLANG' ) && WPLANG ? WPLANG : get_locale();
	$plugin_stat_data['email']            = get_option( 'admin_email' );
	$plugin_stat_data['wp_version']       = $wp_version;
	$plugin_stat_data['php_version']      = sanitize_text_field( phpversion() );
	$plugin_stat_data['mysql_version']    = $wpdb->db_version();
	$plugin_stat_data['max_input_vars']   = ini_get( 'max_input_vars' );
	$plugin_stat_data['operating_system'] = PHP_OS . '  (' . PHP_INT_SIZE * 8 . ') BIT';
	$plugin_stat_data['php_memory_limit'] = ini_get( 'memory_limit' ) ? ini_get( 'memory_limit' ) : 'N/A';
	$plugin_stat_data['extensions']       = get_loaded_extensions();
	$plugin_stat_data['plugins']          = ai_robot_get_plugin_info();
	$plugin_stat_data['themes']           = $theme_details;
}

/**
 * Get plugin info
 *
 * @since 1.0.0
 */
function ai_robot_get_plugin_info() {
	$active_plugins = (array) get_option( 'active_plugins', array() );
	if ( is_multisite() ) {
		$active_plugins = array_merge( $active_plugins, get_site_option( 'active_sitewide_plugins', array() ) );
	}
	$plugins = array();
	if ( count( $active_plugins ) > 0 ) {
		$get_plugins = array();
		foreach ( $active_plugins as $plugin ) {
			$plugin_data = @get_plugin_data( WP_PLUGIN_DIR . '/' . $plugin );// @codingStandardsIgnoreLine

				$get_plugins['plugin_name']    = strip_tags( $plugin_data['Name'] );
				$get_plugins['plugin_author']  = strip_tags( $plugin_data['Author'] );
				$get_plugins['plugin_version'] = strip_tags( $plugin_data['Version'] );
				array_push( $plugins, $get_plugins );
		}
		return $plugins;
	}
}

/**
 * Envato user identity verify
 *
 * @since 1.0.0
 * @return string
 */
function ai_robot_envato_verify($code, $action){
	global $wp_version, $wpdb;
    $theme_details = array();
	if ( $wp_version >= 3.4 ) {
		$active_theme                   = wp_get_theme();
		$theme_details['theme_name']    = strip_tags( $active_theme->name );
		$theme_details['theme_version'] = strip_tags( $active_theme->version );
		$theme_details['author_url']    = strip_tags( $active_theme->{'Author URI'} );
    }

	$plugin_stat_data                     = array();
	$plugin_stat_data['plugin_slug']      = 'ai-robot-premium';
	$plugin_stat_data['version_number']   = AI_ROBOT_VERSION;
	$plugin_stat_data['event']            = 'activate';
	$plugin_stat_data['domain_url']       = site_url();
	$plugin_stat_data['domain']           = parse_url( site_url(), PHP_URL_HOST );
	$plugin_stat_data['wp_language']      = defined( 'WPLANG' ) && WPLANG ? WPLANG : get_locale();
	$plugin_stat_data['email']            = get_option( 'admin_email' );
	$plugin_stat_data['wp_version']       = $wp_version;
	$plugin_stat_data['php_version']      = sanitize_text_field( phpversion() );
	$plugin_stat_data['mysql_version']    = $wpdb->db_version();
	$plugin_stat_data['max_input_vars']   = ini_get( 'max_input_vars' );
	$plugin_stat_data['operating_system'] = PHP_OS . '  (' . PHP_INT_SIZE * 8 . ') BIT';
	$plugin_stat_data['php_memory_limit'] = ini_get( 'memory_limit' ) ? ini_get( 'memory_limit' ) : 'N/A';
	$plugin_stat_data['extensions']       = get_loaded_extensions();
	$plugin_stat_data['plugins']          = ai_robot_get_plugin_info();
	$plugin_stat_data['themes']           = $theme_details;
	$plugin_stat_data['action']           = $action;
	$plugin_stat_data['code']           = $code;
}