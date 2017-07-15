<?php
/**
 * Uninstallation actions
 */

// If uninstall.php is not called by WordPress, die.
if ( ! defined( 'WP_UNINSTALL_PLUGIN' ) ) {
    die;
}

// Delete our added user role.
remove_role( 'webmaster' );

// Delete the option with the plugin version.
delete_option( 'dcsites-version' );
