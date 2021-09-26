<?php

/**
 * Provide a admin area view for the plugin
 *
 * This file is used to markup the admin-facing aspects of the plugin.
 *
 * @link       https://profiles.wordpress.org/javmah/
 * @since      1.0.0
 *
 * @package    Automail
 * @subpackage Automail/admin/partials
 */
?>

<!-- This file should primarily consist of HTML with a little bit of PHP. -->
<div class="wrap">

	<div id="icon-options-general" class="icon32"></div>
	<h2><?php esc_attr_e( 'Welcome to Automation List ', 'automail' ); ?></h2>



	<div id="poststuff">

        <?php

            echo "<a href='".  admin_url('/admin.php?page=automail&action=new')  ."' > Add new  Automation </a>";
            echo"<br><hr><br>";

            global $wpdb;
            $results = $wpdb->get_results( "SELECT * FROM {$wpdb->prefix}posts, {$wpdb->prefix}postmeta  WHERE {$wpdb->prefix}posts.ID = {$wpdb->prefix}postmeta.post_id  AND  post_type = 'automail' ", ARRAY_A );

            foreach ( $results as $key => $value) {
                echo "<a href='".  admin_url('/admin.php?page=automail&action=edit&id='. $value["ID"] )  ."' >". $value["ID"] . "</a>";
                echo"<br>";
                echo $value["post_content"];
                echo"<br>";
                echo $value["post_title"];
                echo"<br>";
                echo $value["post_excerpt"];
                echo"<br>";
                echo $value["meta_value"];
                echo"<br><hr><br>";
            }
        ?>

		<br class="clear">
	</div>
	<!-- #poststuff -->

</div> <!-- .wrap -->

<!-- https://wordpress.org/plugins/notification/ -->