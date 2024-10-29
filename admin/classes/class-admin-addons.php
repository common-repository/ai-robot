<?php
/**
 * Admin Addons List Class
 *
 * Plugin Admin Addons List Class
 *
 * @since  1.0.0
 * @package Ai Robot
 */

defined( 'ABSPATH' ) or exit;

if ( ! class_exists( 'Ai_Robot_Admin_Addons' ) ) :

	/**
	 * Admin Addons List
	 */
	class Ai_Robot_Admin_Addons {

        public static function get_list(){
            // list of addons
                $addons = apply_filters('robot_addons_details_list',array(
                    'wphobby-sticky-header' => array(
                        'id'=>'WHSH',
                        'name'=>'WPHobby Sticky Header',
                        'link'=>'https://wphobby.com/addons/sticky-header/',
                        'download'=>'https://wphobby.com/addons/sticky-header/',
                        'desc'=>'Add sticky header on website.',
                        'thumbnail' => AI_ROBOT_URL.'/assets/images/addons/minimal.png',
                        'price' => '$29.99'
                    ),
                    'wphobby-sticky-footer' => array(
                        'id'=>'WHSF',
                        'name'=>'WPHobby Sticky Footer',
                        'link'=>'https://wphobby.com/addons/sticky-footer/',
                        'download'=>'https://wphobby.com/addons/sticky-footer/',
                        'desc'=>'Add sticky footer on website.',
                        'thumbnail' => AI_ROBOT_URL.'/assets/images/addons/minimal.png',
                        'price' => '$29.99'
                    ),
                    'wphobby-popup-login' => array(
                        'id'=>'WHPL',
                        'name'=>'WPHobby Popup Login',
                        'link'=>'https://wphobby.com/addons/popup-login/',
                        'download'=>'https://wphobby.com/addons/popup-login/',
                        'desc'=>'Add popup login on website.',
                        'thumbnail' => AI_ROBOT_URL.'/assets/images/addons/minimal.png',
                        'price' => '$29.99'
                    ),
                    'wphobby-instagram' => array(
                        'id'=>'WHIN',
                        'name'=>'WPHobby Instagram',
                        'link'=>'https://wphobby.com/addons/instagram/',
                        'download'=>'https://wphobby.com/addons/instagram/',
                        'desc'=>'Add instagram on website.',
                        'thumbnail' => AI_ROBOT_URL.'/assets/images/addons/minimal.png',
                        'price' => '$29.99'
                    ),
                    'wphobby-side-panel' => array(
                        'id'=>'WHSP',
                        'name'=>'WPHobby Side Panel',
                        'link'=>'https://wphobby.com/addons/side-panel/',
                        'download'=>'https://wphobby.com/addons/side-panel/',
                        'desc'=>'Add side panel on website.',
                        'thumbnail' => AI_ROBOT_URL.'/assets/images/addons/minimal.png',
                        'price' => '$29.99'
                    ),
                    'wphobby-elementor-widgets' => array(
                        'id'=>'WHEW',
                        'name'=>'Elementor Widgets',
                        'link'=>'https://wphobby.com/addons/elementor-widgets/',
                        'download'=>'https://wphobby.com/addons/elementor-widgets/',
                        'desc'=>'Add elementor widgets on website.',
                        'thumbnail' => AI_ROBOT_URL.'/assets/images/addons/minimal.png',
                        'price' => '$29.99'
                    ),
                    'wphobby-white-label' => array(
                        'id'=>'WHWL',
                        'name'=>'WPHobby White Label',
                        'link'=>'https://wphobby.com/addons/white-label/',
                        'download'=>'https://wphobby.com/addons/white-label/',
                        'desc'=>'Add white label on website.',
                        'thumbnail' => AI_ROBOT_URL.'/assets/images/addons/minimal.png',
                        'price' => '$29.99'
                    ),
                    'wphobby-cooike-notice' => array(
                        'id'=>'WHCN',
                        'name'=>'WPHobby Cooike Notice',
                        'link'=>'https://wphobby.com/addons/cooike-notice/',
                        'download'=>'https://wphobby.com/addons/cooike-notice/',
                        'desc'=>'Add cooike notice on website.',
                        'thumbnail' => AI_ROBOT_URL.'/assets/images/addons/minimal.png',
                        'price' => '$29.99'
                    )
                ));


                ksort($addons);
                return $addons;
            }


	}



endif;