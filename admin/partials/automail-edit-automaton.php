<?php
/**
 * Provide a admin area view for the plugin This file is used to markup the admin-facing aspects of the plugin.
 * @link       https://profiles.wordpress.org/javmah/
 * @since      1.0.0
 * @package    Automail
 * @subpackage Automail/admin/partials
 */
?>
<!-- This file should primarily consist of HTML with a little bit of PHP. -->
<div class="wrap">
	<div id="icon-options-general" class="icon32"></div>
	<h2><?php esc_attr_e( 'Edit Email Automation.', 'automail' ); ?></h2>
	<div id="poststuff">
        <div id="automailEditVue">
            <!-- Testing is in Here  -->
            <!-- <pre> {{$data}} </pre> -->
            <!-- <pre> ID : {{$data.ID}}                         </pre>
                 <pre> Name : {{$data.automatonName}}                   </pre>
                 <pre> Selected Event : {{$data.selectedEvent}}                </pre>
                 <pre> selected Events And Titles : {{$data.selectedEventsAndTitles}}  </pre>
                 <pre> Mail Receiver : {{$data.mailReceiver}}                                 </pre> -->
            <!-- Form Starts  -->
            <form action="<?php echo esc_url(admin_url('admin-post.php'));?>" @submit="inputValidation" method="post" >
                <input type="hidden" name="action" value="automail_saveAutomation">
                <input type="hidden" name="status" value="editAutomation" />
                <input type="hidden" name="postID" value="<?php echo esc_html($ID); ?>" />

                <div id="post-body" class="metabox-holder columns-2">
                    <!-- main content -->
                    <div id="post-body-content">
                        <div class="meta-box-sortables ui-sortable">
                            <div class="postbox">
                                <h2><span> <?php esc_attr_e('Fill the fields for new Email Automaton', 'automail');?> </span> </h2>

                                <div class="inside">
                                    <b> Automaton Name: </b>
                                    <input type="text" name="automatonName" v-model="automatonName" value="<?php echo esc_html($automatonName); ?>" id="automatonName" class="large-text" /><br><br>

                                    <b> Event Name:  </b><br>
                                    <select  style="width: 99%;" v-model="selectedEvent" @change="eventSelected($event)" name="eventName" id="eventName">
                                        <!-- Loop Here  -->
                                        <?php
                                            if(!empty($this->events) AND is_array($this->events)){
                                                foreach($this->events as $key => $value){
                                                    # Starting the thing
                                                    if(esc_html($key) == "wp_newUser"){
                                                        echo"<optgroup label='WordPress User Events'>";
                                                    }else if(esc_html($key) == "wp_newPost"){
                                                        echo"<optgroup label='WordPress Post Events'>";
                                                    }else if(esc_html($key) == "wp_comment"){
                                                        echo"<optgroup label='WordPress Comment Events'>";
                                                    }else{
                                                        # Left Empty
                                                    }

                                                    echo"<option value='" . esc_html($key) . "' " . selected(esc_html($eventName), esc_html($key)) . " > " . esc_html($value) . " </option>";

                                                    # Ending The Tag
                                                    if(esc_html($key) == "wp_userLogout"){
                                                        echo"</optgroup>";
                                                    }else if(esc_html($key) == "wp_page"){
                                                        echo"</optgroup>";
                                                    }else if(esc_html($key) == "wp_edit_comment"){
                                                        echo"</optgroup>";
                                                    }else{
                                                        # Left Empty
                                                    }
                                                }
                                            }
                                        ?>
                                    </select>
                                    <br><br>
                                    <b> Email Receiver : TO  </b> <span class="dashicons dashicons-info" title="Please select a valid Email address from *Event Data Source we provided all fields but every Fields are not Email field." ></span>
                                    <select multiple="multiple" style="width: 99%; " size="7" v-model="mailReceiver" name="mailReceiver[]" id="mailReceiver">
                                        <?php
                                            # Add event outsource later 
                                            # Most important AKA Must have 
                                            $userRoles = $this->automail_userRoles();
                                            if($userRoles[0]){
                                                echo"<optgroup label='User Role'>";
                                                    foreach($userRoles[1] as $key => $value) {
                                                        echo "<option value='" .  esc_html($key) . "' > " . esc_html($value) . " </option>";
                                                    }
                                                echo"</optgroup>";
                                            }
                                        
                                            # freemius is Active 
                                        ?>   
                                                    
                                        <optgroup v-if="freemiusStatus" label="Event Data Source" id="eventDataSource"> 
                                            <option v-for="(value, key) in selectedEventsAndTitles" :value="key"> {{value}} </option>
                                        </optgroup>
                                                
                                        <?php
                                            
                                            # For User 
                                            global $wpdb;
                                            $results = $wpdb->get_results("SELECT {$wpdb->prefix}users.user_email, {$wpdb->prefix}users.user_nicename FROM `wp_users` ORDER BY `user_email` ASC", ARRAY_A);
                                            #
                                            if(!empty($results)){
                                                echo"<optgroup label='User'>";
                                                    foreach($results as $key => $singleUserArray){
                                                        echo "<option value='" .  esc_html($singleUserArray['user_email']) . "'> " .  esc_html($singleUserArray['user_nicename']) . " - " . esc_html($singleUserArray['user_email']) . "</option>";
                                                    }
                                                echo"</optgroup>";
                                            }
                                        ?>
                                    </select>
                                    <br><br>
                                    <!-- <b> Email Body: </b> -->
                                    <?php
                                        wp_editor( 
                                                    esc_html($automailEmail),
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
                                <h2><span><?php esc_attr_e('Automaton Status','automail');?> </span></h2>
                                <div class="inside">
                                    <input type="checkbox" name="automatonStatus" checked> Automaton Status
                                    <br>
                                    <br>
                                    <input class="button-secondary" type="submit"  value="SAVE"/>
                                </div>
                                <!-- .inside -->
                            </div>
                            <!-- .postbox -->
                        </div>
                        <!-- .meta-box-sortables -->

                        <!-- Conditionally rendered div -->
                        <div class="meta-box-sortables" v-show="selectedEventsAndTitles">
                            <div class="postbox">
                                <h2><span><?php esc_attr_e('Data Tags', 'automail');?></span><code>click to clipboard</code> <span class="dashicons dashicons-info" title="Paste event placeholder data [Tags] to email body as Placeholder, So that in the event it replace with the real data."></span></h2>
                                <div class="inside">
                                    <!-- tag cloud list start -->
                                    <ul :style="[selectedEvent ? {'height':'350px', 'overflow':'hidden', 'overflow-y':'scroll'} : {'height':'350px'}]">
                                        <li v-for="(item, index) in selectedEventsAndTitles" @click="copyTheTag(index)" :class="index % 2 ? '' : 'alternate'" style="padding: 10px;">
                                            {{item}}
                                            <br>
                                            [{{index}}] 
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
        <div>
	</div>
	<!-- #poststuff -->

</div> <!-- .wrap -->

<!-- https://wordpress.org/plugins/notification/ -->
