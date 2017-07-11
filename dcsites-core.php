<?php
/*
Plugin Name: DC Sites Core Features
Plugin URI: https://github.com/drunken-coding/dcsites-core
Description: Provides a number of features for clients of DC Sites
Version: 1.0.0
Author: DC Sites
Author URI: https://dcsit.es
Text Domain: dcsites
*/

namespace DCSites;

define( __NAMESPACE__ . '\DOMAIN',  'dcsites' );
define( __NAMESPACE__ . '\VERSION',  '1.0.0' );
define( __NAMESPACE__ . '\PATH', plugin_dir_path( __FILE__ ) );
define( __NAMESPACE__ . '\URL',  plugin_dir_url( __FILE__ ) );

global $webmaster_capabilities;

/**
 * Change this array to change the webmaster's abilities
 */
$webmaster_capabilities = [ 'base', 'theme', 'user' ];

require 'inc/core.php';

if ( is_admin() ) {
	require 'inc/dashboard.php';
}

register_deactivation_hook( __FILE__, [ 'Core', 'deactivate' ] );
