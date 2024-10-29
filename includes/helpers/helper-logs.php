<?php
if ( ! defined( 'ABSPATH' ) ) {
    exit;
} // Exit if accessed directly

/**
 * Get logs file
 *
 * @since 1.0.0
 * @return array
 */
function ai_robot_get_logs_file() {

    $log_file = '';

    if ( get_option( 'ai_robot_recent_log_file', false ) ) {
        $log_file = get_option( 'ai_robot_recent_log_file', false );
    }

    return $log_file;
}

/**
 * Get logs data from database
 *
 * @since 1.0.0
 * @return array
 */
function ai_robot_get_logs( $args = array(), $count = false ) {
    global $wpdb;
    $default     = array(
        'search'   => '',
        'level'     => '',
        'orderby'  => 'created',
        'order'    => 'DESC',
        'per_page' => 20,
        'page'     => 1,
        'offset'   => 0,
    );
    $args        = wp_parse_args( $args, $default );
    $query_from  = "FROM {$wpdb->prefix}ai_robot_logs";
    $query_where = 'WHERE 1=1';

    if(!empty( $args['level'])){
        $level = strtoupper( $args['level']);
        $query_where .= $wpdb->prepare( " AND level=%s ", $level);
    }
    //ordering
    $order         = isset( $args['order'] ) ? esc_sql( strtoupper( $args['order'] ) ) : 'ASC';
    $order_by      = esc_sql( $args['orderby'] );
    $query_orderby = sprintf( " ORDER BY %s %s", $order_by, $order );
    if($args['orderby'] !== 'id'){
        $query_orderby .= ' , id DESC ';
    }

    // limit
    if ( isset( $args['per_page'] ) && $args['per_page'] > 0 ) {
        if ( $args['offset'] ) {
            $query_limit = $wpdb->prepare( 'LIMIT %d, %d', $args['offset'], $args['per_page'] );
        } else {
            $query_limit = $wpdb->prepare( 'LIMIT %d, %d', $args['per_page'] * ( $args['page'] - 1 ), $args['per_page'] );
        }
    }

    if ( $count ) {
        return $wpdb->get_var( "SELECT count({$wpdb->prefix}ai_robot_logs.id) $query_from $query_where" );
    }


    return $wpdb->get_results( "SELECT * $query_from $query_where $query_orderby $query_limit" );
}

/**
* Clear logs
*
* @since 1.1.0
*/
function ai_robot_clear_logs(){
    global $wpdb;
    $table = $wpdb->prefix.'ai_robot_logs';
    $return = $wpdb->query( "TRUNCATE TABLE $table" );
    return $return;
}
