<?php

/**
 * @wordpress-plugin
 * Plugin Name:     Sentry Cleint for WordPress
 * Plugin URI:      http://www.adampatterson.ca
 * Description:     Sends PHP errors to Sentry using the Sentry PHP library.
 * Version:         0.0.1
 * Author:          Adam Patterson
 * Author URI:      http://www.adampatterson.ca
 * License:         MIT
 */

require_once __DIR__ . '/vendor/autoload.php';
add_action( 'plugins_loaded', array( 'SentryWordPress\Bootstrap', 'init' ) );

register_activation_hook( __FILE__, [ 'StrahcomCore\Actions', 'activationHook' ] );
register_deactivation_hook( __FILE__, [ 'StrahcomCore\Actions', 'deactivationHook' ] );