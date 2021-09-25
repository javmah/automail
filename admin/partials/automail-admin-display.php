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
	<h2><?php esc_attr_e( 'Automate New Event Email.', 'automail' ); ?></h2>

	<div id="poststuff">

		<div id="post-body" class="metabox-holder columns-2">

			<!-- main content -->
			<div id="post-body-content">
				<div class="meta-box-sortables ui-sortable">

					<div class="postbox">

						<h2><span><?php esc_attr_e( 'Main Content Header', 'automail' ); ?></span></h2>

						<div class="inside">
							<b> Automaton Name:  </b>
                            <input type="text" class="large-text" /><br><br>

							<b> Event Name:  </b><br>
                            <select  multiple style="width: 99%; "  name="eventName" id="eventName">
                                <optgroup label="Swedish Cars">
                                    <option value="volvo">Volvo</option>
                                    <option value="saab">Saab</option>
                                </optgroup>
                                <optgroup label="German Cars">
                                    <option value="mercedes">Mercedes</option>
                                    <option value="audi">Audi</option>
                                </optgroup>
                            </select>

                            <br><br>
                            <b> Email Receiver : TO </b>
                            <select multiple style="width: 99%; "  name="eventName" id="eventName">
                                <optgroup label="Swedish Cars">
                                    <option value="volvo">Volvo</option>
                                    <option value="saab">Saab</option>
                                </optgroup>
                                <optgroup label="German Cars">
                                    <option value="mercedes">Mercedes</option>
                                    <option value="audi">Audi</option>
                                </optgroup>
                            </select>
                            <br>
                            <br>
                            <!-- <b> Email Body: </b> -->

                            <?php
                                
                                wp_editor( 
                                            "Please write your Email here, Use {{Data_tags}}", 
                                            "automail_email", 
                                            array(
                                                'textarea_rows'=> '6',
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
							<input type="checkbox" name="vehicle1" checked value="Bike"> Automaton Status 
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
                                    Milk
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

		<br class="clear">
	</div>
	<!-- #poststuff -->

</div> <!-- .wrap -->

<!-- https://wordpress.org/plugins/notification/ -->