<?php
/**
 * Functions that run on the dashboard of WordPress
 */

namespace DCSites;

class Dashboard extends Core {
	protected function __construct() {
		parent::__construct();

		// Run our activation features
		add_action( 'admin_init', [ $this, 'activate' ] );

		// Remove menu pages that clients don't need to worry about
		add_action( 'admin_menu', [ $this, 'remove_menu_pages' ] );

		// Register the new dashboard widget
		add_action( 'wp_dashboard_setup', [ $this, 'add_dashboard_widgets' ] );

		// Change the footer text
		add_filter( 'admin_footer_text', [ $this, 'change_footer_admin' ] );
	}

	public function activate() {
		if ( VERSION == get_option( DOMAIN . '-version' ) ) {
			return;
		}

		global $webmaster_capabilities;

		$capabilities = array();

		$capabilities['base'] = array(
			'read'                   => true,
			'read_private_pages'     => true,
			'read_private_posts'     => true,
			'delete_others_pages'    => true,
			'delete_others_posts'    => true,
			'delete_pages'           => true,
			'delete_posts'           => true,
			'delete_private_pages'   => true,
			'delete_private_posts'   => true,
			'delete_published_pages' => true,
			'delete_published_posts' => true,
			'edit_others_pages'      => true,
			'edit_others_posts'      => true,
			'edit_pages'             => true,
			'edit_posts'             => true,
			'edit_private_pages'     => true,
			'edit_private_posts'     => true,
			'edit_published_pages'   => true,
			'edit_published_posts'   => true,
			'publish_pages'          => true,
			'publish_posts'          => true,
			'manage_categories'      => true,
			'manage_links'           => true,
			'moderate_comments'      => true,
			'upload_files'           => true,
			'edit_dashboard'         => true,
		);

		$capabilities['theme'] = array(
			'switch_themes'          => true,
			'edit_theme_options'     => true,
			'customize'              => true,
		);

		$capabilities['user'] = array(
			'list_users'             => true,
			'edit_users'             => true,
			'create_users'           => true,
			'delete_users'           => true,
			'manage_options'         => true,
		);

		$caps = [];

		foreach ( $webmaster_capabilities as $type ) {
			$caps = array_merge( $caps, $capabilities[ $type ] );
		}

		remove_role( 'webmaster' );

		add_role( 'webmaster', 'Webmaster', $caps );

		update_option( DOMAIN . '-version', VERSION );
	}

	public static function get_instance() {
		static $instance = null;
		if ( null === $instance ) {
			$instance = new static();
		}
		return $instance;
	}

	/**
	 * Remove menu links
	 * For all but site administrators
	 */
	public function remove_menu_pages() {
		if ( current_user_can( 'administrator' ) || current_user_can( 'manage_network' ) ) {
			return;
		}

		remove_menu_page( 'jetpack' );                       // Jetpack

		// remove_menu_page( 'themes.php' );                    // Appearance
		// remove_menu_page( 'plugins.php' );                   // Plugins
		// remove_menu_page( 'tools.php' );                     // Tools
		// remove_menu_page( 'options-general.php' );           // Settings
		// remove_menu_page( 'index.php' );                  //Dashboard
		// remove_menu_page( 'edit.php' );                   //Posts
		// remove_menu_page( 'upload.php' );                 //Media
		// remove_menu_page( 'edit.php?post_type=page' );    //Pages
		// remove_menu_page( 'edit-comments.php' );          //Comments
		// remove_menu_page( 'users.php' );                  //Users
	}

	/**
	 * Register our custom dashboard widgets
	 */
	public function add_dashboard_widgets() {
		add_meta_box( 'dcsites-help', 'Help!', [ $this, 'dashboard_widget_help' ], 'dashboard', 'normal', 'high' );
	}

	/**
	 * Print out our Help! dashboard widget
	 */
	public function dashboard_widget_help() {
		$copy = '<p>Lost? Remember, you can access the training manual for your site under <a href="%s">video tutorials</a>.</p>';

		$copy .= '<p>We are here to help. Email, text, or call and we will be happy to help as soon as we can.</p>';

		$copy .= '<p><a href="mailto:services@dcsit.es">services@dcsit.es</a>';
		$copy .= '<br><a href="http://dcsit.es" target="_blank">http://dcsit.es</a>';
		$copy .= '<br>All Web ~ No Stress</p>';

		printf( $copy, admin_url( 'admin.php?page=wp101' ) );
	}

	/**
	 * Change the text that appears in the footer of the page
	 * Instead of promoting WordPress, promote us
	 *
	 * @param  string $copy Original text
	 * @return string       New text
	 */
	public function change_footer_admin( $copy ) {

		$image = '<img src="%s" style="height: 50px; width: auto; margin-right: 15px; vertical-align: baseline;">';

		$copy = '';

		$copy .= sprintf( '<a href="%s" target="_blank">' . $image . '</a>', 'https://dcsit.es', URL . 'images/logo.svg' );

		$copy .= '<em>This site is maintained with care by</em> <a href="https://dcsit.es" target="_blank">DC Sites</a>.';

		return $copy;
	}


}

Dashboard::get_instance();
