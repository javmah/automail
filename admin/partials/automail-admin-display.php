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

            $results = get_posts( array( 
                'post_type'         => 'automail',
                'post_status'       => array('publish', 'pending'),
                'posts_per_page'    => -1,
            )); 
           
            foreach ( $results as $key => $Array) {
                echo "<a href='".  admin_url('/admin.php?page=automail&action=edit&id='. $Array->ID  )."' >". $Array->ID . "</a>";
                echo"<br>";
                echo ">> " . $Array->post_title;
                echo"<br>";
                echo ">> " . $Array->post_content;
                echo"<br>";
                echo ">> " . $Array->post_excerpt;
                echo"<br>";
                $mailReceiver = get_post_meta( $Array->ID, "mailReceiver", TRUE );
                print_r( $mailReceiver ); 
                echo"<br>";
                if( in_array( "AdminX", $mailReceiver ) ){
                    echo"In array.";
                } else {
                    echo"not in array.";
                }
                echo"<br>";
                echo "<a href='".  admin_url('/admin.php?page=automail&action=delete&id='. $Array->ID  )  ."' > Delete Automation</a>";
                echo"<br><hr><br>";
            }
        ?>

		<br class="clear">
	</div>
	<!-- #poststuff -->

</div> <!-- .wrap -->

<!-- https://wordpress.org/plugins/notification/ -->