<?php

/**
 * Provide a admin area view for the plugin
 *
 * This file is used to markup the admin-facing aspects of the plugin.
 *
 * @link       https://profiles.wordpress.org/javmah/
 * @since      1.0.0
 * @package    Automail
 * @subpackage Automail/admin/partials
 */
?>
<!-- This file should primarily consist of HTML with a little bit of PHP. -->
<div class="wrap">
	<div id="icon-options-general" class="icon32"></div>
	<h2><?php esc_attr_e( 'Automate new event Email.', 'automail' ); ?></h2>

	<div id="poststuff">
        <div id="automailNewVue">

            <!-- <pre> {{$data}} </pre> -->
            <!-- Form Starts  -->
            <form action="<?php echo esc_url( admin_url( 'admin-post.php' ) ); ?>" method="post" >
                <input type="hidden" name="action" value="automail_saveAutomation">
                <input type="hidden" name="status" value="newAutomation" />

                <div id="post-body" class="metabox-holder columns-2">
                    <!-- main content -->
                    <div id="post-body-content">
                        <div class="meta-box-sortables ui-sortable">

                            <div class="postbox">
                                <h2> <span> <?php esc_attr_e( 'Fill the fields for new Email Automaton', 'automail' ); ?> </span> </h2>

                                <div class="inside">
                                    <b> Automaton Name:  </b>
                                    <input type="text" name="automatonName" id="automatonName" class="large-text" /><br><br>

                                    <b> Event Name:  </b><br>
                                    <select  style="width: 99%;" @change="eventSelected($event)" name="eventName" id="eventName">
                                        <!-- Loop Here  -->
                                        <?php
                                            if( ! empty( $this->events ) AND is_array( $this->events ) ){
                                                foreach ( $this->events  as $key => $value ) {
                                                    # Starting the Thing 
                                                    if ( $key == "wp_newUser" ) {
                                                        echo"<optgroup label='WordPress User Events'>";
                                                    } else if ( $key == "wp_newPost" ) {
                                                        echo"<optgroup label='WordPress Post Events'>";
                                                    } else if ( $key == "wp_comment" ) {
                                                        echo"<optgroup label='WordPress Comment Events'>";
                                                    }  else {
                                                    # Left Empty 
                                                    } 

                                                    echo"<option value='" . $key . "'> " . $value . " </option>";

                                                    # Ending The Tag 
                                                    if ( $key == "wp_userLogout" ) {
                                                        echo"</optgroup>";
                                                    } else if ( $key == "wp_page" ) {
                                                        echo"</optgroup>";
                                                    } else if ( $key == "wp_edit_comment" ) {
                                                        echo"</optgroup>";
                                                    } else {
                                                        # Left Empty 
                                                    }
                                                }
                                            }
                                        ?>
                                    </select>

                                    <br><br>
                                    <b> Email Receiver : TO </b>
                                    <select multiple="multiple" style="width: 99%; "  name="mailReceiver[]" id="mailReceiver">

                                        <optgroup label="Event Data Source ">
                                            <option value="Email">   Email      </option>
                                        </optgroup>

                                        <optgroup label="User Role">
                                            <option value="Admin">   Admin (1)   </option>
                                            <option value="Editor">  Editor(2)  </option>
                                        </optgroup>

                                        <optgroup label="User">
                                            <option value="khaled@gmail.com">   Khaled mahmud  - khaled@gmail.com  </option>
                                            <option value="javed@gmail.com">    Javed Mahmud   - javed@gmail.com   </option>
                                            <option value="zubayer@gmail.com">  Zubayer Mahmud - zubayer@gmail.com </option>
                                        </optgroup>

                                    </select>
                                    <br> <br>
                                    
                                    <!-- <b> Email Body: </b> -->
                                    <?php
                                        wp_editor( 
                                                    "Please write your Email here, Use &#123; &#123; Data_tags &#125; &#125;", 
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
                                            &#123; &#123; wpgsi_submitted_time &#125; &#125;
                                        </li>

                                        <li style="padding: 10px;">
                                            Tea
                                            <br>
                                            &#123; &#123; get_variation_default_attributes &#125; &#125;
                                        </li>

                                        <li class="alternate" style="padding: 10px;"> 
                                            Milk
                                            <br>
                                            &#123; &#123; wpgsi_Form_submitted &#125; &#125;
                                        </li>

                                        <li style="padding: 10px;"> 
                                            Fanta
                                            <br>
                                            &#123; &#123; wpgsi_Form_submitted &#125; &#125;
                                        </li>

                                        <li class="alternate" style="padding: 10px;"> 
                                            Coke
                                            <br>
                                            &#123; &#123; wpgsi_Form_submitted &#125; &#125;
                                        </li>

                                        <li  style="padding: 10px;"> 
                                            Pespsi
                                            <br>
                                            &#123; &#123; wpgsi_Form_submitted &#125; &#125;
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
	</div>
	<!-- #poststuff -->

</div> <!-- .wrap -->

<!-- https://wordpress.org/plugins/notification/ -->