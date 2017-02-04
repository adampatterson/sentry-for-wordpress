<?php

namespace SentryWordPress;

use Raven_Client;
use Raven_Autoloader;
use Raven_ErrorHandler;

class App extends Raven_Client {

	/**
	 * @var array
	 */
	protected $settings;

	/**
	 * @var array
	 */
	protected $errorLevelMap;

	public function __construct() {
		$this->errorLevelMap = array(
			'E_NONE'              => 0,
			'E_ERROR'             => 1,
			'E_WARNING'           => 2,
			'E_PARSE'             => 4,
			'E_NOTICE'            => 8,
			'E_USER_ERROR'        => 256,
			'E_USER_WARNING'      => 512,
			'E_USER_NOTICE'       => 1024,
			'E_RECOVERABLE_ERROR' => 4096,
			'E_ALL'               => 8191
		);

		$this->settings = get_option( 'sentry-settings' );

		if ( ! isset( $this->settings['dsn'] ) ) {
			return;
		}

		if ( $this->settings['dsn'] == '' ) {
			return;
		}

		parent::__construct( $this->settings['dsn'] );

		$this->setErrorReportingLevel( $this->settings['reporting_level'] );

		$this->registerSentry();
	}

	/**
	 * Registeres Sentry
	 */
	public function registerSentry() {
		Raven_Autoloader::register();

		$error_handler = new Raven_ErrorHandler( $this );
		$error_handler->registerExceptionHandler();
		$error_handler->registerErrorHandler();
		$error_handler->registerShutdownFunction();
	}

	/**
	 * @param string $level
	 */
	private function setErrorReportingLevel( $level = 'E_ERROR' ) {
		error_reporting( $this->errorLevelMap[ $level ] );
	}
}