<?php
/*
 Plugin Name: Advanced Custom Fields: Post Status
 Plugin URI:  https://github.com/romain-d/acf-post-status
 Description: Add Post Status selector to ACF
 Version:     1.0.0
 Author:      Romain DORR
 Author URI:  https://github.com/romain-d
 License:     GPL3
 Text Domain: acf-post-status
 ----
 Copyright 2019 Romain DORR (contact@romaindorr.fr)
 */
if ( ! defined( 'ABSPATH' ) ) {
	die();
}
define( 'ACF_POST_STATUS_VERSION', '1.0.0' );
define( 'ACF_POST_STATUS_DIR', plugin_dir_path( __FILE__ ) );

class acf_field_post_status_plugin {
	/**
	 * Constructor.
	 *
	 * Load plugin's translation and register ACF Post Status fields.
	 * @author Romain DORR
	 * @since 1.0.0
	 */
	function __construct() {
		add_action( 'init', array( __CLASS__, 'load_translation' ), 1 );
		// Register ACF fields
		add_action( 'acf/include_field_types', array( __CLASS__, 'register_field_v5' ) );
	}
	/**
	 * Load plugin translation.
	 * @author Romain DORR
	 * @since 1.0.0
	 */
	public static function load_translation() {
		load_plugin_textdomain( 'acf-post-status', false, dirname( plugin_basename( __FILE__ ) ) . '/languages' );
	}
	/**
	 * Register Post Status selector field for ACF v5.
	 * @author Romain DORR
	 * @since 1.0.0
	 */
	public static function register_field_v5() {

		include_once( ACF_POST_STATUS_DIR . 'fields/field-post-status.php' );
		new acf_field_post_status_select();
	}
}
/**
 * Init plugin.
 * @author Romain DORR
 * @since 1.0.0
 */
function acf_field_post_status() {
	new acf_field_post_status_plugin();
}
add_action( 'plugins_loaded', 'acf_field_post_status' );
