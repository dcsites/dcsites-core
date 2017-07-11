<?php
/**
 * Functions that run on the front-end of WordPress
 */

namespace DCSites;

class Core {

	public static function get_instance() {
		static $instance = null;
		if ( null === $instance ) {
			$instance = new static();
		}
		return $instance;
	}

	protected function __construct() {
		// Add login page styles
		add_action( 'login_head', [ $this, 'login_page_styles' ] );

		// Change the login page logo's link
		add_filter( 'login_headerurl', [ $this, 'change_login_logo_link' ] );

		// Change "Howdy" in the admin bar
		add_filter( 'gettext', [ $this, 'change_howdy' ], 10, 3 );
	}

	public static function deactivate() {
		remove_role( 'webmaster' );
		delete_option( DOMAIN . '-version' );
	}

	/**
	 * Translate the "Howdy, Username" string
	 * to something less colloquial
	 *
	 * @param  string $translated The translated text of the string
	 * @param  string $text       The original text of the string
	 * @param  string $domain     The translation domain
	 * @return string             The (maybe) new translated text
	 */
	public function change_howdy( $translated, $text, $domain ) {

		if ( false !== strpos( $translated, 'Howdy' ) && 'default' == $domain ) {
			return str_replace( 'Howdy', 'Welcome', $translated );
		}

		return $translated;
	}

	/**
	 * Change the link for the big logo on the login page
	 *
	 * @return string Link to DC Sites
	 */
	public function change_login_logo_link() {
		return 'https://dcsit.es';
	}

	/**
	 * Echo out our custom CSS for the login page
	 * White label that page!
	 */
	public function login_page_styles() {
		$logo = URL . '/images/logo.svg';

		echo <<<HTML

        <style type="text/css">
            body.login {
                background-color: #FFFFFF;
            }

            body.login .message, body.login form {
                box-shadow: 1px 1px 3px 1px rgba(0,0,0,0.3);
                            }

            body.login .message, body.login #login_error {
                border-left-color: #A7383D;
            }

            #wp-submit {
                background-color: #A7383D;
                border-color: #A7383D;
                box-shadow: none;
                text-shadow: none;
            }

            #wp-submit:hover, #wp-submit:focus {
                background-color: #530004;
                border-color: #530004;
            }

            #login h1 a {
                background-image:url({$logo});
                background-size: contain;
                height: 125px;
                width: 100%;
            }
        </style>';

HTML;
	}
}

Core::get_instance();
