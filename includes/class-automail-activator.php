<?php
/**
 * Fired during plugin activation. This class defines all code necessary to run during the plugin's activation.
 * @since      1.0.0
 * @package    Automail
 * @subpackage Automail/includes
 * @author     javmah <jaedmah@gmail.com>
 */
class Automail_Activator {
	/**
	 * This Function will track First Install of This Plugin on this site and Last install of this Plugin.
	 * @since    1.0.0
	*/
	public static function activate(){
		# Setting the Instal time 
		$installed = get_option("autoMail_installed");
		# check & balance 
		if(!$installed){
			update_option("autoMail_installed", time());	# first time installed date;
		}else{
			update_option("autoMail_re-installed", time());	# last time installed date;
		}
	}
}
