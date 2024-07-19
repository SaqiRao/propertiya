<?php
/**
Plugin Name: Propertya Elementor Widgets
Description: Propertya is a premium & responsive WordPress theme designed for Real Estate companies agencies & independent agents where modern aesthetics are combined. Propertya theme provides a complete property management system where users can seta complete online property marketplace for users and members, offering them their separate profile page, dashboards, and accepting different payment gateways.
Author: Scripts Bundle
Theme URI: https://www.propertya-wp.com/
Author URI: http://scriptsbundle.com/
Version: 1.1.6
License: Themeforest Split Licence
License URI: https://themeforest.net/user/scriptsbundle/
Text Domain: propertya-elementor
Tags: translation-ready,theme-options, left-sidebar, right-sidebar, grid-layout, featured-images,sticky-post,  threaded-comments
*/
if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

final class Propertya_Elementor {
	const VERSION = '1.0.0';
	const MINIMUM_ELEMENTOR_VERSION = '2.0.0';
	const MINIMUM_PHP_VERSION = '7.0';
	public function __construct() {
		add_action( 'init', array( $this, 'i18n' ) );
		add_action( 'plugins_loaded', array( $this, 'init' ) );
	}
	public function i18n() {
		load_plugin_textdomain( 'propertya-elementor' );
	}
	public function init() {
		// Check if Elementor installed and activated
		if ( ! did_action( 'elementor/loaded' ) ) {
			add_action( 'admin_notices', array( $this, 'admin_notice_missing_main_plugin' ) );
			return;
		}
		// Check for required Elementor version
		if ( ! version_compare( ELEMENTOR_VERSION, self::MINIMUM_ELEMENTOR_VERSION, '>=' ) ) {
			add_action( 'admin_notices', array( $this, 'admin_notice_minimum_elementor_version' ) );
			return;
		}
		// Check for required PHP version
		if ( version_compare( PHP_VERSION, self::MINIMUM_PHP_VERSION, '<' ) ) {
			add_action( 'admin_notices', array( $this, 'admin_notice_minimum_php_version' ) );
			return;
		}
		// Once we get here, We have passed all validation checks so we can safely include our plugin
		require_once( 'plugin.php' );
	}
	public function admin_notice_missing_main_plugin() {
		if ( isset( $_GET['activate'] ) ) {
			unset( $_GET['activate'] );
		}
		$message = sprintf(
			esc_html__( '"%1$s" requires "%2$s" to be installed and activated.', 'propertya-elementor' ),
			'<strong>' . esc_html__( 'Elementor Hello World', 'propertya-elementor' ) . '</strong>',
			'<strong>' . esc_html__( 'Elementor', 'propertya-elementor' ) . '</strong>'
		);
		printf( '<div class="notice notice-warning is-dismissible"><p>%1$s</p></div>', $message );
	}
	public function admin_notice_minimum_elementor_version() {
		if ( isset( $_GET['activate'] ) ) {
			unset( $_GET['activate'] );
		}
		$message = sprintf(
			esc_html__( '"%1$s" requires "%2$s" version %3$s or greater.', 'propertya-elementor' ),
			'<strong>' . esc_html__( 'Elementor Hello World', 'propertya-elementor' ) . '</strong>',
			'<strong>' . esc_html__( 'Elementor', 'propertya-elementor' ) . '</strong>',
			self::MINIMUM_ELEMENTOR_VERSION
		);
		printf( '<div class="notice notice-warning is-dismissible"><p>%1$s</p></div>', $message );
	}
	public function admin_notice_minimum_php_version() {
		if ( isset( $_GET['activate'] ) ) {
			unset( $_GET['activate'] );
		}
		$message = sprintf(
			esc_html__( '"%1$s" requires "%2$s" version %3$s or greater.', 'propertya-elementor' ),
			'<strong>' . esc_html__( 'Elementor Hello World', 'propertya-elementor' ) . '</strong>',
			'<strong>' . esc_html__( 'PHP', 'propertya-elementor' ) . '</strong>',
			self::MINIMUM_PHP_VERSION
		);
		printf( '<div class="notice notice-warning is-dismissible"><p>%1$s</p></div>', $message );
	}
}
new Propertya_Elementor();