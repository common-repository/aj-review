<?php
/**
 * @package AJ Review
 */

/*
Plugin Name: AJ-Review
Description: Powerfull Review Plugin for post/page
Version: 0.9.3
Author: AJ Bang
Author URI: https://2p1d.com
License: GPLv2 or later
*/
//if ( ! defined( 'WPINC' ) ) { die; }

$ajReviewVersion = "0.9.3";
$ajReviewDBVersion = "1.1";

define('AJRV_PLUGIN_PATH', plugin_dir_path(__FILE__));
define('AJRV_PLUGIN_JS', plugins_url('ajrv.js', __FILE__));
define('AJRV_PLUGIN_URL', plugin_dir_url(__FILE__));
define('AJRV_PLUGIN_CSS', plugins_url('ajrv-styles.css', __FILE__));
define('AJRV_PLUGIN_FA_CSS', plugins_url('css/all.min.css', __FILE__));
define('AJRV_PLUGIN_UR_CSS', plugins_url('css/jquery.rateyo.min.css', __FILE__));

//define('AJRV_S3_AJ_JS', AJRV_PLUGIN_PATH."ajrv.js");

define('AJRV_S3_AJ_BS_ISO', plugins_url('css/aj_bs_iso.min.css', __FILE__));
define('AJRV_S3_AJ_SLIDER_STYLE', plugins_url('css/bootstrap-slider.min.css', __FILE__));
#define('AJRV_S3_AJ_STYLE', plugins_url('css/ajrv-styles.css', __FILE__));
#define('AJRV_S3_AJ_JQUERY', plugins_url('js/jquery-3.4.1.min.js', __FILE__));
#define('AJRV_S3_AJ_JQUERY_MIGR', plugins_url('js/jquery-migrate-1.4.1.min.js', __FILE__));
define('AJRV_S3_AJ_BOOTSTRAP', plugins_url('js/bootstrap.min.js', __FILE__));
define('AJRV_S3_AJ_SLIDER', plugins_url('js/bootstrap-slider.min.js', __FILE__));
define('AJRV_PLUGIN_UR_JS', plugins_url('js/jquery.rateyo.min.js', __FILE__));

define('AJRV_DEBUG', false);

require_once(AJRV_PLUGIN_PATH . "views/ajrv_options_page_html.php");
require_once(AJRV_PLUGIN_PATH . "views/ajrv_rlist.php");
require_once(AJRV_PLUGIN_PATH . "views/ajrv_rlist_new.php");
require_once(AJRV_PLUGIN_PATH . "views/ajrv_rlist_group.php");
require_once(AJRV_PLUGIN_PATH . "views/ajrv_rlist_shcode.php");
require_once(AJRV_PLUGIN_PATH . "views/ajrv_post_metabox_html.php");
require_once(AJRV_PLUGIN_PATH . "views/ajrv_view_single_post_html.php");
require_once(AJRV_PLUGIN_PATH . "views/ajrv_review_list_html.php");
require_once(AJRV_PLUGIN_PATH . "views/ajrv_comment.php");

require_once(AJRV_PLUGIN_PATH . "function.php");
require_once(AJRV_PLUGIN_PATH . "inc/ajrv.install.php");
require_once(AJRV_PLUGIN_PATH . "inc/ajrv.delete.php");
require_once(AJRV_PLUGIN_PATH . "inc/ajrv.widget.php");

function ajrv_load_plugin() {
    load_plugin_textdomain( 'ajreview', FALSE, basename( dirname( __FILE__ ) ) . '/languages/' );
	ajrv_create_plugin_database_table();
}
add_action('plugins_loaded', 'ajrv_load_plugin');

//Admin Pages
add_action('admin_menu', 'ajrv_admin_menu');
add_action('admin_init', 'ajrv_admin_init');
function ajrv_admin_menu(){
    //add_menu_page('Theme page title', 'Theme menu label', 'manage_options', 'theme-options', 'wps_theme_func');
    //add_submenu_page( 'theme-options', 'Settings page title', 'Settings menu label', 'manage_options', 'theme-op-settings', 'wps_theme_func_settings');
    //add_submenu_page( 'theme-options', 'FAQ page title', 'FAQ menu label', 'manage_options', 'theme-op-faq', 'wps_theme_func_faq');

    add_menu_page(__('AJ 리뷰', 'ajreview' ), __('AJ 리뷰', 'ajreview' ), 'manage_options', 'ajrv-plugin-setting', 'ajrv_rlist', AJRV_PLUGIN_URL.'review.png', 40.5);
    add_submenu_page('ajrv-plugin-setting', __('리뷰 목록', 'ajreview' ), __('리뷰 목록', 'ajreview' ), 'manage_options', 'ajrv_rlist', 'ajrv_rlist');
    add_submenu_page('ajrv-plugin-setting', __('리뷰 그룹', 'ajreview' ), __('리뷰 그룹', 'ajreview' ), 'manage_options', 'ajrv_rlist_group', 'ajrv_rlist_group');
    add_submenu_page('ajrv-plugin-setting', __('리뷰 등록', 'ajreview' ), __('리뷰 등록', 'ajreview' ), 'manage_options', 'ajrv_rlist_new', 'ajrv_rlist_new');
    add_submenu_page('ajrv-plugin-setting', __('설정', 'ajreview' ), __('설정', 'ajreview' ), 'manage_options', 'ajrv_options_page_html', 'ajrv_options_page_html');
    add_submenu_page('ajrv-plugin-setting', 'Shortcodes', 'Shortcode Manual', 'manage_options', 'ajrv_rlist_shcode', 'ajrv_rlist_shcode');
    remove_submenu_page('ajrv-plugin-setting', 'ajrv-plugin-setting');
}
function ajrv_admin_init(){
    add_action( 'delete_post', 'ajrv_delete_review', 10 );
}

//Write Post
//add_action('add_meta_boxes', 'ajrv_post_metabox_html');
add_action('save_post', 'save_metabox', 10, 2 );
add_filter('the_content', 'ajrv_content_filter', 20 );

add_shortcode('aj-review', 'ajrv_shcode_review_single');
add_shortcode('aj-review-list', 'ajrv_shcode_review_list');

register_activation_hook( __FILE__, 'ajrv_create_plugin_database_table');

//Widget
add_action( 'widgets_init', function(){
	register_widget('AJ_Review');
});

function ajrv_load_plugin_css(){
    wp_enqueue_style('ajrvcss', AJRV_PLUGIN_CSS);
    wp_enqueue_style('ajcss', AJRV_S3_AJ_BS_ISO);
	wp_enqueue_style('ajrvcss-userrating', AJRV_PLUGIN_UR_CSS);
    //wp_enqueue_style('ajsicss', AJRV_S3_AJ_STYLE);
    wp_enqueue_style('ajsi_slider_css', AJRV_S3_AJ_SLIDER_STYLE);
    wp_enqueue_style('fontawesome', AJRV_PLUGIN_FA_CSS);

    //wp_deregister_script('jquery');
    //wp_register_script('jquery341', AJRV_S3_AJ_JQUERY);
	wp_add_inline_script('jquery341', 'var jquery341 = $.noConflict(true);' );

    //wp_deregister_script('jquery-migrate');
    //wp_register_script('jquery-migrate341', AJRV_S3_AJ_JQUERY_MIGR);

    wp_register_script('bootstrapjs', AJRV_S3_AJ_BOOTSTRAP);
    wp_register_script('bootstrapsliderjs', AJRV_S3_AJ_SLIDER);

    //wp_enqueue_script('plugin-javascript', AJRV_S3_AJ_JQUERY, array( 'jquery341' ) );
    wp_enqueue_script('jquery341');
    wp_enqueue_script('bootstrapjs');
    wp_enqueue_script('bootstrapsliderjs');
	wp_enqueue_script('ajrvjs-userrating', AJRV_PLUGIN_UR_JS);
}
add_action('wp_enqueue_scripts', 'ajrv_load_plugin_css' );
add_action('admin_enqueue_scripts', 'ajrv_load_plugin_css' );

?>
