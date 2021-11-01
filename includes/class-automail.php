<?php
/**
 * The file that defines the core plugin class
 * A class definition that includes attributes and functions used across both the public-facing side of the site and the admin area.
 * This is used to define internationalization, admin-specific hooks, and public-facing site hooks.
 * Also maintains the unique identifier of this plugin as well as the current version of the plugin.
 * @since      1.0.0
 * @package    Automail
 * @subpackage Automail/includes
 * @author     javmah <jaedmah@gmail.com>
 */
class Automail {

	/**
	 * The loader that's responsible for maintaining and registering all hooks that power the plugin.
	 * @since    1.0.0
	 * @access   protected
	 * @var      Automail_Loader    $loader    Maintains and registers all hooks for the plugin.
	*/
	protected $loader;

	/**
	 * The unique identifier of this plugin.
	 * @since    1.0.0
	 * @access   protected
	 * @var      string    $plugin_name    The string used to uniquely identify this plugin.
	*/
	protected $plugin_name;

	/**
	 * The current version of the plugin.
	 * @since    1.0.0
	 * @access   protected
	 * @var      string    $version    The current version of the plugin.
	*/
	protected $version;

	/**
	 * Define the core functionality of the plugin. Set the plugin name and the plugin version that can  be used throughout the plugin. 
	 * Load the dependencies, define the locale, and set the hooks for the admin area and the public-facing side of the site.
	 * @since    1.0.0
	*/
	public function __construct(){
		if ( defined( 'AUTOMAIL_VERSION' ) ) {
			$this->version = AUTOMAIL_VERSION;
		} else {
			$this->version = '1.0.0';
		}
		$this->plugin_name = 'automail';

		$this->load_dependencies();
		$this->set_locale();
		$this->define_admin_hooks();
		$this->define_public_hooks();
	}

	/**
	 * Load the required dependencies for this plugin.
	 * Include the following files that make up the plugin:
	 *
	 * - Automail_Loader. Orchestrates the hooks of the plugin.
	 * - Automail_i18n. Defines internationalization functionality.
	 * - Automail_Admin. Defines all hooks for the admin area.
	 * - Automail_Public. Defines all hooks for the public side of the site.
	 *
	 * Create an instance of the loader which will be used to register the hooks with WordPress.
	 * @since    1.0.0
	 * @access   private
	*/
	private function load_dependencies(){
		# The class responsible for orchestrating the actions and filters of the core plugin.
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'includes/class-automail-loader.php';
		# The class responsible for defining internationalization functionality of the plugin.
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'includes/class-automail-i18n.php';
		# The class responsible for defining all actions that occur in the admin area.
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'admin/class-automail-admin.php';
		# The class responsible for defining all actions that occur in the admin area.
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'admin/class-automail-events.php';
		# The class responsible for defining all actions that occur in the public-facing side of the site.
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'public/class-automail-public.php';
		# 
		$this->loader = new Automail_Loader();
	}

	/**
	 * Define the locale for this plugin for internationalization.
	 * Uses the Automail_i18n class in order to set the domain and to register the hook with WordPress.
	 * @since    1.0.0
	 * @access   private
	*/
	private function set_locale(){
		$plugin_i18n = new Automail_i18n();
		$this->loader->add_action( 'plugins_loaded', $plugin_i18n, 'load_plugin_textdomain' );
	}

	/**
	 * Register all of the hooks related to the admin area functionality of the plugin.
	 * @since    1.0.0
	 * @access   private
	*/
	private function define_admin_hooks(){
		$automail_events = new Automail_Events( $this->get_plugin_name(), $this->get_version());																# Events 
		$this->loader->add_action( 'user_register', 	 	 		  			$automail_events, 'automail_wp_newUser', 100, 1);								# New User Event [user_register]
		$this->loader->add_action( 'profile_update',		 		  			$automail_events, 'automail_wp_profileUpdate', 100, 2);							# Update User Event [profile_update]
		$this->loader->add_action( 'delete_user', 			 		  			$automail_events, 'automail_wp_deleteUser', 100, 1);  							# Delete User Event [delete_user]
		$this->loader->add_action( 'wp_login', 			   	 		  			$automail_events, 'automail_wp_userLogin', 100, 2);								# User Logged In  [wp_login]
		$this->loader->add_action( 'clear_auth_cookie', 	 		  			$automail_events, 'automail_wp_userLogout', 100, 1);							# User Logged Out [wp_logout] 
		$this->loader->add_action( 'save_post', 			 		  			$automail_events, 'automail_wp_post', 100, 3);									# Wordpress Post  		  || Fires once a post has been saved. || 3 param 1.post_id 2.post 3.updates
		$this->loader->add_action( 'comment_post', 			 		  			$automail_events, 'automail_wp_comment', 100, 3);								# Wordpress comment_post  || Fires once a comment_post has been saved TO DB.
		$this->loader->add_action( 'edit_comment', 			 		  			$automail_events, 'automail_wp_edit_comment', 100, 2);							# Wordpress comment_post  || Fires once a comment_post has been saved TO DB.
		# New Code Starts 
		$this->loader->add_action( 'transition_post_status', 		  			$automail_events, 'automail_wc_product', 100, 3);								# WooCommerce  Product save_post_product
		$this->loader->add_action( 'woocommerce_order_status_changed',			$automail_events, 'automail_wc_order_status_changed', 100, 3);					# Woocommerce Order Status Changed
		$this->loader->add_action( 'woocommerce_new_order', 	 	  			$automail_events, 'automail_wc_new_order_admin', 100, 1);						# WooCommerce New Order
		$this->loader->add_action( 'woocommerce_thankyou', 	 	  				$automail_events, 'automail_wc_new_order_checkout', 100, 1);					# WooCommerce New Order
		# Form Plugins 
		$this->loader->add_action( 'wpcf7_before_send_mail', 		  			$automail_events, 'automail_cf7_submission');									# CF7 Submission a New Form 
		$this->loader->add_action( 'ninja_forms_after_submission',    			$automail_events, 'automail_ninja_forms_after_submission', 100, 1);				# Ninja form Submission a New Form 
		$this->loader->add_action( 'frm_after_create_entry', 		  			$automail_events, 'automail_formidable_after_save', 30, 2);						# formidable after create form data entry to DB
		$this->loader->add_action( 'wpforms_process', 		  		  			$automail_events, 'automail_wpforms_process', 30, 3);							# formidable after create form data entry to DB
		$this->loader->add_action( 'weforms_entry_submission', 		    		$automail_events, 'automail_weforms_entry_submission', 100, 4);					# weforms after create form data entry to DB				
		$this->loader->add_action( 'gform_after_submission', 		    		$automail_events, 'automail_gravityForms_after_submission', 100, 2);			# gravityForms after form submission			
		$this->loader->add_action( 'forminator_custom_form_submit_field_data', 	$automail_events, 'automail_forminator_custom_form_submit_field_data', 100, 2);	# forminator custom form submit field data		
		# for Testing 
		$this->loader->add_action( 'admin_notices',  							$automail_events, 'automail_event_notices');

		$plugin_admin = new Automail_Admin( $this->get_plugin_name(), $this->get_version());
		# For Custom Post type
		$this->loader->add_action( 'init', 								$plugin_admin, 'automail_register_custom_post_type');
		# For enqueue scripts and Style 
		$this->loader->add_action( 'admin_enqueue_scripts', 			$plugin_admin, 'enqueue_styles');
		$this->loader->add_action( 'admin_enqueue_scripts', 			$plugin_admin, 'enqueue_scripts');
		# Admin menu and Admin Notice 
		$this->loader->add_action( 'admin_menu',						$plugin_admin, 'automail_menu_pages');
		$this->loader->add_action( 'admin_notices', 					$plugin_admin, 'automail_admin_notice');
		# Save Submitted Form 
		$this->loader->add_action( 'admin_post_automail_saveAutomation',$plugin_admin, 'automail_saveAutomation');
	
	}

	/**
	 * Register all of the hooks related to the public-facing functionality of the plugin.
	 * @since    1.0.0
	 * @access   private
	 */
	private function define_public_hooks(){
		#
		$plugin_public = new Automail_Public($this->get_plugin_name(), $this->get_version());
		#
		$this->loader->add_action('wp_enqueue_scripts', $plugin_public, 'enqueue_styles');
		$this->loader->add_action('wp_enqueue_scripts', $plugin_public, 'enqueue_scripts');
	}

	/**
	 * Run the loader to execute all of the hooks with WordPress.
	 * @since    1.0.0
	*/
	public function run(){
		$this->loader->run();
	}

	/**
	 * The name of the plugin used to uniquely identify it within the context of WordPress and to define internationalization functionality.
	 * @since     1.0.0
	 * @return    string    The name of the plugin.
	*/
	public function get_plugin_name(){
		return $this->plugin_name;
	}

	/**
	 * The reference to the class that orchestrates the hooks with the plugin.
	 * @since     1.0.0
	 * @return    Automail_Loader    Orchestrates the hooks of the plugin.
	*/
	public function get_loader(){
		return $this->loader;
	}

	/**
	 * Retrieve the version number of the plugin.
	 * @since     1.0.0
	 * @return    string    The version number of the plugin.
	*/
	public function get_version(){
		return $this->version;
	}
}
