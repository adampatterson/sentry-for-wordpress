<?php

namespace SentryWordPress;

class Bootstrap extends App {

	private static $instance = null;

	function __construct() {
		add_action( 'admin_menu', array( $this, 'adminMenu' ) );

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
			$wps = new Bootstrap();
		} catch ( Exception $e ) {

		}
	}

	/**
	 * Registeres the Admin Menu.
	 */
	public function adminMenu() {
		add_options_page( 'Sentry Error Reporting Settings', 'Sentry', 'edit_pages', 'sentrysettings', array(
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
	 * Handles the sacing of Plugin settings.
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

add_action( 'plugins_loaded', array( 'SentryWordPress\Bootstrap', 'init' ) );