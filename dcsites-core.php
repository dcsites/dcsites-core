<?php
/*
Plugin Name: DC Sites Core Features
Plugin URI: https://github.com/drunken-coding/dcsites-core
Description: Provides a number of features for clients of DC Sites
Version: 0.1.0
Author: DC Sites
Author URI: https://dcsit.es
Text Domain: dcsites
*/

namespace DCSites;

define( __NAMESPACE__ . '\PATH', plugin_dir_path( __FILE__ ) );
define( __NAMESPACE__ . '\URL',  plugin_dir_url(  __FILE__ ) );

require 'inc/core.php';

if ( is_admin() ) {
    require 'inc/dashboard.php';
}
