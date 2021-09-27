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
	<h2><?php esc_attr_e( 'Edit Email Automation.', 'automail' ); ?></h2>

	<div id="poststuff">
        <!-- Form Starts  -->
        <form action="<?php echo esc_url( admin_url( 'admin-post.php' ) ); ?>" method="post" >
            <input type="hidden" name="action" value="automail_saveAutomation">
            <input type="hidden" name="status" value="editAutomation" />
            <input type="hidden" name="postID" value="<?php echo $ID; ?>" />

            <div id="post-body" class="metabox-holder columns-2">
                <!-- main content -->
                <div id="post-body-content">
                    <div class="meta-box-sortables ui-sortable">

                        <div class="postbox">
                            <h2> <span> <?php esc_attr_e( 'Fill the fields for new Email Automaton', 'automail' ); ?> </span> </h2>

                            <div class="inside">
                                <b> Automaton Name:  </b>
                                <input type="text" name="automatonName" value="<?php echo $automatonName; ?>" id="automatonName" class="large-text" /><br><br>

                                <b> Event Name:  </b><br>
                                <select  style="width: 99%;"  name="eventName" id="eventName">

                                    <optgroup label="WordPress Post Events">
                                        <option value="wp_newPost"    <?php selected( $eventName, "wp_newPost" );    ?> >  Wordpress New Post      </option>
                                        <option value="wp_editPost"   <?php selected( $eventName, "wp_editPost" );   ?> >  Wordpress Edit Post     </option>
                                        <option value="wp_deletePost" <?php selected( $eventName, "wp_deletePost" ); ?> >  Wordpress Delete Post   </option>
                                        <option value="wp_page"       <?php selected( $eventName, "wp_page" );       ?> >  Wordpress Page          </option>
                                    </optgroup>

                                    <optgroup label="WordPress User Events">
                                        <option value="wp_newUser"           <?php selected( $eventName, "wp_newUser" );            ?> >   Wordpress New User              </option>
                                        <option value="wp_UserProfileUpdate" <?php selected( $eventName, "wp_UserProfileUpdate" );  ?> >   Wordpress User Profile Update   </option>
                                        <option value="wp_deleteUser"        <?php selected( $eventName, "wp_deleteUser" );         ?> >   Wordpress Delete User           </option>
                                        <option value="wp_userLogin"         <?php selected( $eventName, "wp_userLogin" );          ?> >   Wordpress User Login            </option>
                                        <option value="wp_userLogout"        <?php  selected( $eventName, "wp_userLogout" );        ?> >   Wordpress User Logout           </option>
                                    </optgroup>

                                    <optgroup label="WordPress Comment Events">
                                        <option value="wp_comment"          <?php selected( $eventName, "wp_comment" );          ?>  >  Wordpress Comment       </option>
                                        <option value="wp_edit_comment"     <?php selected( $eventName, "wp_edit_comment" );     ?>  >  Wordpress Edit Comment  </option>
                                        <option value="wp_approve_comment"  <?php selected( $eventName, "wp_approve_comment" );  ?>  >  Approve Comment         </option>
                                    </optgroup>

                                    <!-- For WooCommerce Also add Custom Events  -->
                                    <optgroup label="WooCommerce Events">
                                        <option value="wc-new_order" <?php selected( $eventName, "wc-new_order" );  ?> >   WooCommerce New Checkout Page Order </option>
                                        <option value="wc-pending"   <?php selected( $eventName, "wc-pending" );    ?> >   WooCommerce Order Pending payment   </option>
                                        <option value="wc-processing"<?php selected( $eventName, "wc-processing" ); ?> >   WooCommerce Order Processing        </option>
                                        <option value="wc-on-hold"   <?php selected( $eventName, "wc-on-hold" );    ?> >   WooCommerce Order On-hold           </option>
                                        <option value="wc-completed" <?php selected( $eventName, "wc-completed" );  ?> >   WooCommerce Order Completed         </option>
                                        <option value="wc-cancelled" <?php selected( $eventName, "wc-cancelled" );  ?> >   WooCommerce Order Cancelled         </option>
                                        <option value="wc-refunded"  <?php selected( $eventName, "wc-refunded" );   ?> >   WooCommerce Order Refunded          </option>
                                        <option value="wc-failed"    <?php selected( $eventName, "wc-failed" );     ?> >   WooCommerce Order Failed            </option>
                                    </optgroup>

                                    <optgroup label="Contact form 7 Events">
                                        <option value="1">  Mercedes   </option>
                                        <option value="2">      Audi   </option>
                                    </optgroup>

                                    <optgroup label="WPform Events">
                                        <option value="3">   Mercedes    </option>
                                        <option value="4">       Audi    </option>
                                    </optgroup>

                                    <optgroup label="Ninja form Events">
                                        <option value="5">   Mercedes    </option>
                                        <option value="6">       Audi    </option>
                                    </optgroup>

                                    <optgroup label="Formidable form Events">
                                        <option value="7">   Mercedes    </option>
                                        <option value="8">       Audi    </option>
                                    </optgroup>

                                    <optgroup label="Forminator form Events">
                                        <option value="8">   Mercedes    </option>
                                        <option value="9">       Audi    </option>
                                    </optgroup>

                                    <optgroup label="Custom Post Type Events">
                                        <option value="10">   Mercedes    </option>
                                        <option value="11">       Audi    </option>
                                    </optgroup>
                                </select>

                                <br><br>
                                <b> Email Receiver : TO </b>
                                <select multiple="multiple" style="width: 99%; "  name="mailReceiver[]" id="mailReceiver">

                                    <optgroup label="Event Data Source">
                                        <option value="Email" <?php echo in_array( "Email",  $mailReceiver) ? "selected" : ""; ?> >   Email   </option>
                                    </optgroup>

                                    <optgroup label="User Role">
                                        <option value="Admin"  <?php echo in_array( "Admin",   $mailReceiver)  ? "selected"  : ""; ?> >   Admin (1)   </option>
                                        <option value="Editor" <?php echo in_array( "Editor",  $mailReceiver)  ? "selected"  : ""; ?> >   Editor (2)  </option>
                                    </optgroup>

                                    <optgroup label="User">
                                        <option value="khaled@gmail.com" <?php echo in_array( "khaled@gmail.com",   $mailReceiver) ? "selected" : ""; ?> >    Khaled mahmud  - khaled@gmail.com  </option>
                                        <option value="javed@gmail.com"  <?php echo in_array( "javed@gmail.com",    $mailReceiver) ? "selected" : ""; ?> >    Javed Mahmud   - javed@gmail.com   </option>
                                        <option value="zubayer@gmail.com"<?php echo in_array( "zubayer@gmail.com",  $mailReceiver) ? "selected" : ""; ?> >    Zubayer Mahmud - zubayer@gmail.com </option>
                                    </optgroup>

                                </select>
                                <br>
                                <br>
                                <!-- <b> Email Body: </b> -->

                                <?php
                                    wp_editor( 
                                                $automailEmail, 
                                                "automailEmail", 
                                                array(
                                                    'textarea_rows' => '6',
                                                    'media_buttons' => false,
                                                )
                                            );
                                ?>

                            </div>
                            <!-- .inside -->
                        </div>
                        <!-- .postbox -->
                    </div>
                    <!-- .meta-box-sortables .ui-sortable -->
                </div>
                <!-- post-body-content -->

                <!-- sidebar -->
                <div id="postbox-container-1" class="postbox-container">
                    
                    <div class="meta-box-sortables">

                        <div class="postbox">

                            <h2><span><?php esc_attr_e('Automaton Status', 'automail'); ?></span></h2>

                            <div class="inside">
                                <input type="checkbox" name="automatonStatus" checked > Automaton Status 
                                <br>
                                <br>
                                <input class="button-secondary" type="submit" value="SAVE" />
                            </div>
                            <!-- .inside -->
                        </div>
                        <!-- .postbox -->
                    </div>
                    <!-- .meta-box-sortables -->

                    <div class="meta-box-sortables">

                        <div class="postbox">

                            <h2><span><?php esc_attr_e('Data Tags', 'automail'); ?></span></h2>

                            <div class="inside">
                                
                                <!-- tag cloud list start -->
                                <ul>
                                    <li class="alternate" style="padding: 10px;" >
                                        Coffee
                                        <br>
                                        {{wpgsi_submitted_time}}
                                    </li>

                                    <li style="padding: 10px;">
                                        Tea
                                        <br>
                                        {{get_variation_default_attributes}}
                                    </li>

                                    <li class="alternate" style="padding: 10px;"> 
                                        Milk
                                        <br>
                                        {{wpgsi_Form_submitted}}
                                    </li>

                                    <li style="padding: 10px;"> 
                                        Fanta
                                        <br>
                                        {{wpgsi_Form_submitted}}
                                    </li>

                                    <li class="alternate" style="padding: 10px;"> 
                                        Coke
                                        <br>
                                        {{wpgsi_Form_submitted}}
                                    </li>

                                    <li  style="padding: 10px;"> 
                                        Pespsi
                                        <br>
                                        {{wpgsi_Form_submitted}}
                                    </li>
                                </ul>  
                                <!-- tag cloud list end -->
                            
                            </div>
                            <!-- .inside -->
                        </div>
                        <!-- .postbox -->
                    </div>
                    <!-- .meta-box-sortables -->

                </div>
                <!-- #postbox-container-1 .postbox-container -->
            </div>
            <!-- #post-body .metabox-holder .columns-2 -->

        <!-- Form Ends  -->
        </form>

		<br class="clear">
	</div>
	<!-- #poststuff -->

</div> <!-- .wrap -->

<!-- https://wordpress.org/plugins/notification/ -->