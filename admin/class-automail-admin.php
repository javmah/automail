<?php

/**
 * The admin-specific functionality of the plugin.
 *
 * @link       https://profiles.wordpress.org/javmah/
 * @since      1.0.0
 *
 * @package    Automail
 * @subpackage Automail/admin
 */

/**
 * The admin-specific functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the admin-specific stylesheet and JavaScript.
 *
 * @package    Automail
 * @subpackage Automail/admin
 * @author     javmah <jaedmah@gmail.com>
 */
class Automail_Admin {

	/**
	 * The ID of this plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string    $plugin_name    The ID of this plugin.
	 */
	private $plugin_name;

	/**
	 * The version of this plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string    $version    The current version of this plugin.
	 */
	private $version;

	/**
	 * Initialize the class and set its properties.
	 *
	 * @since    1.0.0
	 * @param      string    $plugin_name       The name of this plugin.
	 * @param      string    $version    The version of this plugin.
	 */
	public function __construct( $plugin_name, $version ) {

		$this->plugin_name 	= $plugin_name;
		$this->version 		= $version;

	}

	/**
	 * Register the stylesheets for the admin area.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_styles() {

		wp_enqueue_style( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'css/automail-admin.css', array(), $this->version, 'all' );

	}

	/**
	 * Register the JavaScript for the admin area.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_scripts() {

		wp_enqueue_script( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'js/automail-admin.js', array( 'jquery' ), $this->version, false );

	}


	/**
	 * Register the stylesheets for the admin area.
	 * @since    1.0.0
	*/
	public function automail_menu_pages() {

		add_menu_page( __( 'autoMail', 'automail' ), __( 'autoMail', 'automail' ), 'manage_options', 'automail', array( $this, 'automail_menu_pages_view' ),'dashicons-email-alt', 10);

	}

	/**
	 * Register the stylesheets for the admin area.
	 * @since    1.0.0
	*/
	public function automail_menu_pages_view() {

		// Add new 

		// List 

		// Edit 

		// Adding 
		require_once plugin_dir_path( dirname(__FILE__) ).'admin/partials/automail-admin-display.php';

		// wp_redirect( admin_url( 'admin.php?page=automail&action=new' ) );
        // exit;

	}

	/**
	 * Register the JavaScript for the admin area.
	 * @since    1.0.0
	*/
	public function automail_admin_notice() {
		echo"<pre>";

			# Empty Holder 
			$userRoles = array();
			# If exist then loop
			if( function_exists( "get_editable_roles" ) ){
				foreach ( get_editable_roles() as $key => $valueArray) {
					if( isset( $valueArray['name'] ) ){
						$userRoles[ $key ] = $valueArray['name'];
					}
				}
			}


			

			print_r( $userRoles );

			

			print_r( count_users() );


		echo"</pre>";

	}

}
