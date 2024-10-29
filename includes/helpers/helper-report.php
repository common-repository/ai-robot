<?php
if ( ! defined( 'ABSPATH' ) ) {
    exit;
} // Exit if accessed directly


/**
 * Generates a performance report
 *
 * @param int $period Days to look back
 *
 * @return string
 */
function ai_robot_generate_report() {
	global $wpdb;

	$global_settings = get_option( 'ai_robot_global_settings', array() );
	$update_frequency = isset($global_settings[ 'update_frequency']) ? $global_settings[ 'update_frequency'] : 7;
    $update_frequency_unit = isset($global_settings[ 'update_frequency_unit']) ? $global_settings[ 'update_frequency_unit'] : 'Days';


	$ret = '';
	$rows = array();
	$stamp = time() - ai_robot_calculate_next_time($update_frequency, $update_frequency_unit);
	$base_url = admin_url( 'admin.php?page=ai-robot-campaign' );
	$css_td = 'padding: 0.5em 0.5em 0.5em 1em; text-align: left;';
	$css_border = 'border-bottom: solid 2px #f9f9f9;';
	$css_table = 'width: 95%; max-width: 1000px; margin:0 auto; margin-bottom: 10px; background-color: #f5f5f5; text-align: center; font-family: Arial, Helvetica, sans-serif;';

	// Get all campaigns
	// Run campaigns job here
	$models = Ai_Robot_Custom_Form_Model::model()->get_all_models();

	$campaigns = $models['models'];
	$activites = array();

	foreach($campaigns as $key=>$model){
		$id = $model->id;
		$title = $model->settings['robot_campaign_name'];
		$query = "
		SELECT * FROM " . $wpdb->prefix . "ai_robot_logs
		WHERE level = 'success' AND created > '" . $stamp . "' AND
		camp_id = " . $id;
		$wpdb->get_results($query);

		$count = $wpdb->num_rows;

		$activites[$key]['id'] = $id;
		$activites[$key]['title'] = $title;
		$activites[$key]['count'] = $count;
	}

	$posts_count = 0;
	foreach ( $activites as $key => $activity) {
		$posts_count += $activity['count'];
	}

	$site_name = ( is_multisite() ) ? get_site_option( 'site_name' ) : get_option( 'blogname' );

	$ret .= '<div style="' . $css_table . '"><div style="margin:0 auto; text-align: center;"><p style="font-size: 130%; padding-top: 0.5em;">' . $site_name . '</p><p style="padding-bottom: 1em;">Last '.$update_frequency.' '.$update_frequency_unit.' Report</p></div></div>';

	$all_campaigns = '<td style="' . $css_td . ' text-align: right;">' . count($campaigns) . '</td><td style="padding: 0.5em; text-align: left;">Total Campaigns</td>';
	$total_posts = '<td style="' . $css_td . ' text-align: right;">' . $posts_count . '</td><td style="padding: 0.5em; text-align: left;">Total Posts</td>';

	$ret .= '<div style="text-align: center; ' . $css_table . '"><table style="font-size: 130%; margin:0 auto;"><tr>' . $all_campaigns . '</tr></table></div>';
	$ret .= '<div style="text-align: center; ' . $css_table . '"><table style="font-size: 130%; margin:0 auto;"><tr>' . $total_posts . '</tr></table></div>';

	// Activities breakdown
	$rows = array();
	$rows[] = '<td style="' . $css_td . $css_border . '" colspan="2"><p style="line-height: 1.5em; font-weight: bold;">' . __( 'Campaigns details', 'ai-robot' ) . '</p></td>';
	if ( $activites ) {
		foreach ( $activites as $key => $activity) {
			$rows[] = '<td style="' . $css_border . $css_td . '">' . $activity['title'] . '</td><td style="padding: 0.5em; text-align: center; width:10%;' . $css_border . '"><a href="' . $base_url . '">' . $activity['count'] . ' posts</a></td>';
		}
	}
	$ret .= '<table style="border-collapse: collapse; ' . $css_table . '"><tr>' . implode( '</tr><tr>', $rows ) . '</tr></table>';

	$ret = '<div style="width:100%; padding: 1em; text-align: center; background-color: #f9f9f9;">' . $ret . '</div>';

	return $ret;
}

/**
 *
 * Send notification letter
 *
 * @param string $type Notification type
 * @param string|array $msg Additional message
 *
 * @return bool
 */
function ai_robot_send_email( $type = '', $msg = '' ) {
	if ( ! $type ) {
		return false;
	}

	$html_mode = true;

	$subj = '[' . get_option( 'blogname' ) . '] ' . __( 'Ai Robot notify', 'ai-robot' ) . ': ';
	$body = '';

	if ( is_array( $msg ) ) {
		$msg = implode( "\n\n", $msg );
	}

	switch ( $type ) {
		case 'report':
			$html_mode = true;
			$subj = '[' . get_option( 'blogname' ) . '] WP Ai Robot: ' . __( 'Stats Report', 'ai-robot' );
			$body = ai_robot_generate_report();
			$link = admin_url( 'admin.php?page=ai-robot-settings' );
			$body .= '<br/>' . __( 'To change reporting settings visit', 'ai-robot' ) . ' <a href="' . $link . '">' . $link . '</a>';
			$body .= $msg;
			break;
		case 'new_version':
			$subj = __( 'A new version of Ai Robot is available to install', 'ai-robot' );
			$body = __( 'Hi!', 'ai-robot' ) . "\n\n";
			$body .= __( 'A new version of Ai Robot is available to install', 'ai-robot' ) . "\n\n";
			$body .= $msg . "\n\n";
			$body .= __( 'Website', 'ai-robot' ) . ': ' . get_option( 'blogname' );
			break;
	}

	$to_list = ai_robot_get_email( $type, true );
	$to      = implode( ', ', $to_list );

	$footer = '';

	$footer .= "\n\n\n" . __( 'This message was sent by', 'ai-robot' ) . ' Ai Robot ' . AI_ROBOT_VERSION . "\n";
	$footer .= 'https://wpairobot.com';

	if ( $html_mode ) {
		add_filter( 'wp_mail_content_type', 'ai_robot_enable_html' );
		$footer = str_replace( "\n", '<br/>', $footer );
	}

	// Everything is prepared, let's send it out

	$result = null;
	if ( $to && $subj && $body ) {
		if ( function_exists( 'wp_mail' ) ) {
			$body = $body . $footer;
			if ( $html_mode ) {
				$body = '<html>' . $body . '</html>';
			}
			$result = wp_mail( $to, $subj, $body );
		}
	}

	remove_filter('wp_mail_content_type', 'ai_robot_enable_html');

	return $result;
}

/**
 * @param string $type Type of notification email
 * @param bool $array  Return as an array
 *
 * @return array|string Email address(es) for notifications
 */
function ai_robot_get_email( $type = '', $array = false ) {
	$email = '';

	if ( empty( $email ) ) {
		$email = get_site_option( 'admin_email' );
		if ( $array ) {
			$email = array( $email );
		}
	}

	return $email;
}

function ai_robot_enable_html() {
	return 'text/html';
}