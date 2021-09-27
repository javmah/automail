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
		# router aka request dispatcher 
		if ( isset( $_GET['action'] ) AND $_GET['action'] == 'new' ) {
			# including the new automaton view File 
			require_once plugin_dir_path( dirname(__FILE__) ).'admin/partials/automail-new-automaton.php';
		} elseif ( isset( $_GET['action'], $_GET['id'] ) AND ( $_GET['action'] == 'edit' AND !empty($_GET['id']) ) ) {
			// Getting the Post data 
			$post   		    = get_post( $_GET['id'], ARRAY_A );
			if( $post ){
				$ID             = ( isset( $post['ID']  ) 			AND !empty( $post['ID'] ) ) 			? $post['ID'] 				: "" ;		
				$automatonName  = ( isset( $post['post_title']  ) 	AND !empty( $post['post_title'] ) ) 	? $post['post_title'] 		: "" ;
				$eventName  	= ( isset( $post['post_excerpt']) 	AND !empty( $post['post_excerpt'] ) ) 	? $post['post_excerpt'] 	: "" ;
				$automailEmail  = ( isset( $post['post_content']  ) AND !empty( $post['post_content'] ) ) 	? $post['post_content'] 	: "" ;
				$mailReceiver  	= get_post_meta( $_GET['id'], "mailReceiver", TRUE );
			} else {
				# No Post found in the database so redirecting.
				wp_redirect( admin_url( 'admin.php?page=automail&status=Post ID is Incorrect ! No post in the Database.' ) );
       			exit;
			}
			# including the view File 
			require_once plugin_dir_path( dirname(__FILE__) ).'admin/partials/automail-edit-automaton.php';
		} elseif ( isset( $_GET['action'], $_GET['id'] ) AND ( $_GET['action'] == 'delete' AND !empty( $_GET['id'] ) ) ){
			# Delete and Redirect;
			wp_delete_post( $_GET['id'] ) ? wp_redirect(admin_url('/admin.php?page=automail&status=success')) : wp_redirect(admin_url('/admin.php?page=automail&status=failed'));
		} else {
			# Including The landing File 
			require_once plugin_dir_path( dirname(__FILE__) ).'admin/partials/automail-admin-display.php';
		}
	}

	/**
	 * Register the JavaScript for the admin area.
	 * @since    1.0.0
	*/
	public function automail_admin_notice() {
		echo"<pre>";
			//
			//
			// print_r( $this->automail_userRoles() );
			//
			//
		echo"</pre>";
	}

	/**
	 * Register the JavaScript for the admin area.
	 * @since    1.0.0
	*/

	// public function automail_saveAutomation() {
	// 	echo"<pre>";
	// 		print_r( $_POST );
	// 	echo"</pre>";
	// }

	public function automail_saveAutomation() {
		# automatonName
		if( isset( $_POST['automatonName'] ) AND !empty( $_POST['automatonName'] ) ){
			$automatonName  =  sanitize_text_field( $_POST['automatonName'] );
		} else {
			wp_redirect( admin_url( 'admin.php?page=automail&status=automatonName is not set or empty !' ) );
       		exit;
		}

		# eventName
		if( isset( $_POST['eventName'] ) AND !empty( $_POST['eventName'] ) ){
			$eventName  =  sanitize_text_field( $_POST['eventName'] );
		} else {
			wp_redirect( admin_url( 'admin.php?page=automail&status=eventName is not set or empty !' ) );
       		exit;
		}

		# For mailReceiver
		if( isset( $_POST['mailReceiver'] ) AND !empty( $_POST['mailReceiver'] ) ){
			$mailReceiver  =  $_POST['mailReceiver'];
		} else {
			wp_redirect( admin_url( 'admin.php?page=automail&status=mailReceiver is not set or empty !' ) );
       		exit;
		}

		# For Email Body  
		if( isset( $_POST['automailEmail'] ) AND !empty( $_POST['automailEmail'] ) ){
			$automailEmail  =  $_POST['automailEmail'];
		} else {
			wp_redirect( admin_url( 'admin.php?page=automail&status=automailEmail is not set or empty !' ) );
       		exit;
		}

		# Post Status
		if( isset( $_POST['automatonStatus'] ) AND  $_POST['automatonStatus'] == "on" ){
			$post_status  =  "publish" ;
		} else {
			$post_status  =  "pending";
		}

		# sanitize_text_field  || Below will work for array  ||
		// $ColumnTitle = array_map( 'sanitize_text_field', $_POST['ColumnTitle'] );
		
		# Save new integration
		if ( $_POST['status'] == "newAutomation"  ) {
			# Preparing Post array for DB insert
			$customPost = array(
				'ID'				=> '',
				'post_content'  	=> $automailEmail, 						// Post Email Content
				'post_title'    	=> $automatonName, 						// Post Title
				'post_status'   	=> $post_status,
				'post_excerpt'  	=> $eventName, 							// Event Name || When Will This Automation will Fire 
				'post_name'  		=> '',									
				'post_type'   		=> 'automail',							// Custom post type
				'menu_order'		=> '',
				'post_parent'		=> '',
				'meta_input' 		=> array(
					'mailReceiver'  => $mailReceiver,						//Inserting The Meta 
				)															
			);
			# Inserting New integration custom Post type 
			$post_id = wp_insert_post( $customPost );						//  Insert the post into the database
		} elseif (  $_POST['status'] == "editAutomation" AND ! empty( $_POST['postID'] )  ) {
			# Preparing Post array for status Change 
			$customPost = array(
				'ID'				=> sanitize_text_field( $_POST['postID'] ),
				'post_content'  	=> $automailEmail, 						// Post Email Content
				'post_title'    	=> $automatonName, 						// Post Title
				'post_status'   	=> $post_status, 
				'post_excerpt'  	=> $eventName, 							// Event Name || When Will This Automation will Fire 
				'post_name'  		=> '',					
				'post_type'   		=> 'automail',							// Custom post type
				'menu_order'		=> '',
				'post_parent'		=> '',
				'meta_input' 		=> array(
					'mailReceiver'  => $mailReceiver,						// Inserting the Meta 
				)															
			);
			# Updating Custom Post Type 
			$post_id = wp_update_post( $customPost );						// Insert the post into the database
		} else {
			# Nothing ...
		}

		# Redirect with message
		if( $post_id  ){
			wp_redirect( admin_url( 'admin.php?page=automail&status=success' ) );
       		exit;
		} else {
			wp_redirect( admin_url( 'admin.php?page=automail&status=action failed' ) );
       		exit;
		}
	}

	/**
	 * Register the JavaScript for the admin area.
	 * @since    1.0.0
	*/
	public function automail_userRoles() {
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

		# Setting the Numbers
		if( function_exists( "count_users" ) AND isset( count_users()['avail_roles'] ) ){
			foreach ( count_users()['avail_roles']  as $key => $value) {
				if( isset( $userRoles[ $key ] ) AND  $value ){
					$userRoles[ $key ] = $userRoles[ $key ] . " (".$value.")" ;
				} 
			}
		}

		# return
		if( empty( $userRoles ) ){
			return array( FALSE, "User role is empty." );
		} else {
			return array( TRUE, $userRoles );
		}
	}

}
