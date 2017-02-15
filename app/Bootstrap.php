<?php

namespace SentryWordPress;

class Bootstrap extends App {

	private static $instance = null;

	function __construct() {

		if ( is_multisite() ) {
			add_action( 'network_admin_menu', array( $this, 'adminMenuNetwork' ) );
		} else {
			add_action( 'admin_menu', array( $this, 'adminMenu' ) );
		}

		if ( is_admin() && $_POST ) {
			$this->saveOptions();
		}

		parent::__construct();

		static::$instance = $this;
	}

	/**
	 * Initializes the plugin.
	 */
	public static function init() {
		try {
			$sentryWp = new Bootstrap();
		} catch ( Exception $e ) {

		}
	}

	/**
	 * Registeres the Admin Menu.
	 */
	public function adminMenu() {
		$title = 'Sentry Error Reporting Settings';

		add_options_page( $title, 'Sentry', 'edit_pages', 'sentrysettings', array(
			$this,
			'adminOptionsPage'
		) );
	}

	/**
	 * Registeres the Admin Menu.
	 */
	public function adminMenuNetwork() {
		$title = 'Sentry Error Reporting Settings';
		add_submenu_page( 'settings.php', $title, 'Sentry', 'manage_network_options', 'sentrysettings', array(
			$this,
			'adminOptionsPage'
		) );

	}

	/**
	 * Registers the Plugin Admin Page.
	 */
	public function adminOptionsPage() {
		$error_levels = $this->errorLevelMap;
		$settings     = $this->settings;
		require_once( dirname( __FILE__ ) . '/views/options.php' );
	}

	/**
	 * Handles the saving of Plugin settings.
	 */
	public function saveOptions() {
		if ( ! isset( $_POST['sentry_dsn'] ) || ! isset( $_POST['sentry_reporting_level'] ) ) {
			return;
		}

		update_option( 'sentry-settings', array(
			'dsn'             => $_POST['sentry_dsn'],
			'reporting_level' => $_POST['sentry_reporting_level']
		) );
	}

	/**
	 * @return null
	 */
	public static function getInstance() {
		return self::$instance;
	}
}