<?php
/*
 * Plugin Name: Latest Custom Post Type Updates
 * Plugin URI: http://technicalmastermind.com/wordpress-plugins/latest-custom-post-type-updates/
 * Description: A simple widget that allows quick and easy display of posts from (nearly) any post type. It also has a set of advanced features: Ability to show posts from multiple post types, in one widget; Can sort results by one or more criteria; Can display the date in any format you want; Developer filters for even more customization of output (requires use of PHP code)
 * Version: 2.0.0
 * Author: David Wood
 * Author URI: http://davidwood.ninja/
 * License: GPLv3
 * Text Domain: latest-custom-post-type-updates
 */

// Make sure we aren't being loaded directly!
if ( ! defined( 'ABSPATH' ) ) {
	exit();
}

/**
 * Class TM_LCPTU
 * @since 2.0.0
 */
class TM_LCPTU {

	public function __construct() {
		require_once( __DIR__ . '/includes/class-tm-lcptu-widget.php' );
		add_action( 'widgets_init', array( $this, '_register_widget' ) );
		add_action( 'admin_enqueue_scripts', array( $this, '_admin_enqueue_scripts' ) );
	}

	/**
	 * Registers our widget so it can be used
	 * @since 2.0.0
	 */
	public function _register_widget() {
		register_widget( 'TM_LCPTU_Widget' );
	}

	/**
	 * Register our admin scripts and styles
	 *
	 * @param $hook
	 *
	 * @since 2.0.0
	 */
	public function _admin_enqueue_scripts( $hook ) {
		$min = ( defined( 'SCRIPT_DEBUG' ) && SCRIPT_DEBUG ) ? '' : '.min';

		if ( 'widgets.php' == $hook ) {
			wp_enqueue_style( 'tm-lcptu-admin', plugins_url( "css/tm-lcptu-admin{$min}.css", __FILE__ ) );
			wp_enqueue_script( 'tm-lcptu-admin', plugins_url( "js/tm-lcptu-admin{$min}.js", __FILE__ ), array( 'jquery' ) );
		}
	}

	public function _enqueue_scripts() {
	}

}

new TM_LCPTU();