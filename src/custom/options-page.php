<?php
/**
 * Sandbox test file
 *
 * @package     YetAnotherSocialShare\Custom
 * @since       1.0.0
 * @author      finchps
 * @link        https://n8finch.com
 * @license     GNU General Public License 2.0+
 */
//namespace YetAnotherSocialShare\Custom;


/**
 * Provides default values for the Input Options.
 */
function wporg_default_options() {

	$defaults = array(
		'wporg_field_activate'                             => 'no',
		'wporg_field_post_types_posts'                     => '1',
		'wporg_field_post_types_pages'                     => '2',
		'wporg_field_post_types_custom'                    => '',
		'wporg_field_active_networks_fb'                   => '1',
		'wporg_field_active_networks_tw'                   => '1',
		'wporg_field_active_networks_go'                   => '1',
		'wporg_field_active_networks_pi'                   => '1',
		'wporg_field_active_networks_li'                   => '1',
		'wporg_field_active_networks_wa'                   => '1',
		'wporg_field_icon_size'                            => 'medium',
		'wporg_field_button_colors'                        => 'default',
		'wporg_field_button_colors_custom_icon'            => '#000000',
		'wporg_field_button_colors_custom_background'      => '#ffffff',
		'wporg_field_sharing_location_below_post_tile'     => '',
		'wporg_field_sharing_location_floating_left'       => '1',
		'wporg_field_sharing_location_after_post_content'  => '',
		'wporg_field_sharing_example_inside_feature_image' => '',

	);

	return apply_filters( 'wporg_default_options', $defaults );

} // end yass_theme_default_input_options

/**
 * custom option and settings
 */
function wporg_settings_init() {

	if ( false == get_option( 'wporg_options' ) ) {
		add_option( 'wporg_options', apply_filters( 'wporg_default_options', wporg_default_options() ) );
	} // end if


	// register a new setting for "wporg" page
	register_setting( 'wporg', 'wporg_options' );

	// register a new section in the "wporg" page
	add_settings_section(
		'wporg_section_developers',
		__( 'The Matrix has you.', 'wporg' ),
		'wporg_section_developers_cb',
		'wporg'
	);

	// register a new field in the "wporg_section_developers" section, inside the "wporg" page


	add_settings_field(
		'wporg_field_activate', // as of WP 4.6 this value is used only internally
		// use $args' label_for to populate the id inside the callback
		__( 'Activation', 'wporg' ),
		'wporg_field_active_cb',
		'wporg',
		'wporg_section_developers',
		[
			'label_for'         => 'wporg_field_activate',
			'class'             => 'wporg_row',
			'wporg_custom_data' => 'yass-plugin-activate',
		]
	);

	add_settings_field(
		'wporg_field_post_types', // as of WP 4.6 this value is used only internally
		// use $args' label_for to populate the id inside the callback
		__( 'Post Types', 'wporg' ),
		'wporg_field_post_types_cb',
		'wporg',
		'wporg_section_developers',
		[
			'label_for'         => 'wporg_field_post_types',
			'class'             => 'wporg_row',
			'wporg_custom_data' => 'yass-plugin-post-types',
		]
	);

	add_settings_field(
		'wporg_field_active_networks', // as of WP 4.6 this value is used only internally
		// use $args' label_for to populate the id inside the callback
		__( 'Active Networks', 'wporg' ),
		'wporg_field_active_networks_cb',
		'wporg',
		'wporg_section_developers',
		[
			'label_for'         => 'wporg_field_active_networks',
			'class'             => 'wporg_row',
			'wporg_custom_data' => 'yass-plugin-active-networks',
		]
	);

	add_settings_field(
		'wporg_field_icon_size', // as of WP 4.6 this value is used only internally
		// use $args' label_for to populate the id inside the callback
		__( 'Icon Size', 'wporg' ),
		'wporg_field_icon_size_cb',
		'wporg',
		'wporg_section_developers',
		[
			'label_for'         => 'wporg_field_icon_size',
			'class'             => 'wporg_row',
			'wporg_custom_data' => 'yass-plugin-icon-size',
		]
	);

	add_settings_field(
		'wporg_field_button_colors', // as of WP 4.6 this value is used only internally
		// use $args' label_for to populate the id inside the callback
		__( 'Button Colors', 'wporg' ),
		'wporg_field_button_colors_cb',
		'wporg',
		'wporg_section_developers',
		[
			'label_for'         => 'wporg_field_button_colors',
			'class'             => 'wporg_row',
			'wporg_custom_data' => 'yass-plugin-button-colors',
		]
	);

	add_settings_field(
		'wporg_field_sharing_location', // as of WP 4.6 this value is used only internally
		// use $args' label_for to populate the id inside the callback
		__( 'Sharing Location', 'wporg' ),
		'wporg_field_sharing_location_cb',
		'wporg',
		'wporg_section_developers',
		[
			'label_for'         => 'wporg_field_sharing_location',
			'class'             => 'wporg_row',
			'wporg_custom_data' => 'yass-plugin-sharing-location',
		]
	);
}

/**
 * register our wporg_settings_init to the admin_init action hook
 */
add_action( 'admin_init', 'wporg_settings_init' );

/**
 * custom option and settings:
 * callback functions
 */

// developers section cb

// section callbacks can accept an $args parameter, which is an array.
// $args have the following keys defined: title, id, callback.
// the values are defined at the add_settings_section() function.
function wporg_section_developers_cb( $args ) {
	?>
	<p id="<?= esc_attr( $args['id'] ); ?>"><?= esc_html__( 'Follow the white rabbit.', 'wporg' ); ?></p>
	<?php
}

// pill field cb

// field callbacks can accept an $args parameter, which is an array.
// $args is defined at the add_settings_field() function.
// wordpress has magic interaction with the following keys: label_for, class.
// the "label_for" key value is used for the "for" attribute of the <label>.
// the "class" key value is used for the "class" attribute of the <tr> containing the field.
// you can add custom key value pairs to be used inside your callbacks.


/**
 * Plugin activation
 *
 * Select type
 *
 * @param $args
 */

function wporg_field_active_cb( $args ) {
	// get the value of the setting we've registered with register_setting()
	$options = get_option( 'wporg_options' );
	// output the field
	?>
	<label for="<?= esc_attr( $args['label_for'] ); ?>">Would you like to activate the Social Sharing plugin?</label>
	<select id="<?= esc_attr( $args['label_for'] ); ?>"
	        data-custom="<?= esc_attr( $args['wporg_custom_data'] ); ?>"
	        name="wporg_options[<?= esc_attr( $args['label_for'] ); ?>]">
		<option
			value="deactivate" <?= isset( $options[ $args['label_for'] ] ) ? ( selected( $options[ $args['label_for'] ], 'deactivate', false ) ) : ( '' ); ?>>
			<?= esc_html( 'no', 'wporg' ); ?>
		</option>
		<option
			value="activate" <?= isset( $options[ $args['label_for'] ] ) ? ( selected( $options[ $args['label_for'] ], 'activate', false ) ) : ( '' ); ?>>
			<?= esc_html( 'yes', 'wporg' ); ?>
		</option>

	</select>

	<?php
}

/**
 * Post Types Checkboxes
 *
 * Input type: checkboxes
 *
 * @param $args
 */
function wporg_field_post_types_cb( $args ) {
	// get the value of the setting we've registered with register_setting()
	$options = get_option( 'wporg_options' );
	// output the field

	if ( array_key_exists( 'wporg_field_post_types_posts', $options ) ) {
		$is_checked_1 = $options['wporg_field_post_types_posts'];
	} else {
		$is_checked_1 = '';
	}

	if ( array_key_exists( 'wporg_field_post_types_pages', $options ) ) {
		$is_checked_2 = $options['wporg_field_post_types_pages'];
	} else {
		$is_checked_2 = '';
	}

	if ( array_key_exists( 'wporg_field_post_types_custom', $options ) ) {
		$is_checked_3 = $options['wporg_field_post_types_custom'];
	} else {
		$is_checked_3 = '';
	}


	?>

	<input type="checkbox" id="<?= esc_attr( $args['label_for'] . '_posts' ); ?>"
	       data-custom="<?= esc_attr( $args['wporg_custom_data'] ); ?>"
	       name="wporg_options[<?= esc_attr( $args['label_for'] . '_posts' ); ?>]"
	       value="1" <?php checked( 1, $is_checked_1, true ); ?>/>

	<label
		for="<?= esc_attr( $args['label_for'] . '_posts' ); ?>"><?= esc_html( 'Posts', 'wporg' ); ?></label>

	<input type="checkbox" id="<?= esc_attr( $args['label_for'] . '_pages' ); ?>"
	       data-custom="<?= esc_attr( $args['wporg_custom_data'] ); ?>"
	       name="wporg_options[<?= esc_attr( $args['label_for'] . '_pages' ); ?>]"
	       value="2" <?php checked( 2, $is_checked_2, true ); ?>/>

	<label
		for="<?= esc_attr( $args['label_for'] . '_pages' ); ?>"><?= esc_html( 'Pages', 'wporg' ); ?></label>

	<input type="checkbox" id="<?= esc_attr( $args['label_for'] . '_custom' ); ?>"
	       data-custom="<?= esc_attr( $args['wporg_custom_data'] ); ?>"
	       name="wporg_options[<?= esc_attr( $args['label_for'] . '_custom' ); ?>]"
	       value="3" <?php checked( 3, $is_checked_3, true ); ?>/>

	<label
		for="<?= esc_attr( $args['label_for'] . '_custom' ); ?>"><?= esc_html( 'Custom', 'wporg' ); ?></label>

	<?php
}

/**
 * Active Networks
 *
 * Input type: checkboxes
 *
 * @param $args
 */
function wporg_field_active_networks_cb( $args ) {
	// get the value of the setting we've registered with register_setting()
	$options = get_option( 'wporg_options' );
	// output the field

	if ( array_key_exists( 'wporg_field_active_networks_fb', $options ) ) {
		$is_checked_fb = $options['wporg_field_active_networks_fb'];
	} else {
		$is_checked_fb = '';
	}

	if ( array_key_exists( 'wporg_field_active_networks_tw', $options ) ) {
		$is_checked_tw = $options['wporg_field_active_networks_tw'];
	} else {
		$is_checked_tw = '';
	}

	if ( array_key_exists( 'wporg_field_active_networks_go', $options ) ) {
		$is_checked_go = $options['wporg_field_active_networks_go'];
	} else {
		$is_checked_go = '';
	}

	if ( array_key_exists( 'wporg_field_active_networks_pi', $options ) ) {
		$is_checked_pi = $options['wporg_field_active_networks_pi'];
	} else {
		$is_checked_pi = '';
	}

	if ( array_key_exists( 'wporg_field_active_networks_li', $options ) ) {
		$is_checked_li = $options['wporg_field_active_networks_li'];
	} else {
		$is_checked_li = '';
	}

	if ( array_key_exists( 'wporg_field_active_networks_wa', $options ) ) {
		$is_checked_wa = $options['wporg_field_active_networks_wa'];
	} else {
		$is_checked_wa = '';
	}

	?>

	<p>Drag the networks in the order you would like them to appear. Check the networks you want activated.</p>
	<ul id="sortable">
		<li class="ui-state-default">
			<input type="checkbox" id="<?= esc_attr( $args['label_for'] . '_fb' ); ?>"
			       data-custom="<?= esc_attr( $args['wporg_custom_data'] ); ?>"
			       name="wporg_options[<?= esc_attr( $args['label_for'] . '_fb' ); ?>]"
			       value="1" <?php checked( 1, $is_checked_fb, true ); ?>/>
			<label for="<?= esc_attr( $args['label_for'] . '_fb' ); ?>">Facbook</label>
		</li>
		<li class="ui-state-default">
			<input type="checkbox" id="<?= esc_attr( $args['label_for'] . '_tw' ); ?>"
			       data-custom="<?= esc_attr( $args['wporg_custom_data'] ); ?>"
			       name="wporg_options[<?= esc_attr( $args['label_for'] . '_tw' ); ?>]"
			       value="1" <?php checked( 1, $is_checked_tw, true ); ?>/>
			<label for="<?= esc_attr( $args['label_for'] . '_tw' ); ?>">Twitter</label>
		</li>
		<li class="ui-state-default">
			<input type="checkbox" id="<?= esc_attr( $args['label_for'] . '_go' ); ?>"
			       data-custom="<?= esc_attr( $args['wporg_custom_data'] ); ?>"
			       name="wporg_options[<?= esc_attr( $args['label_for'] . '_go' ); ?>]"
			       value="1" <?php checked( 1, $is_checked_go, true ); ?>/>
			<label for="<?= esc_attr( $args['label_for'] . '_go' ); ?>">Google+</label>
		</li>
		<li class="ui-state-default">
			<input type="checkbox" id="<?= esc_attr( $args['label_for'] . '_pi' ); ?>"
			       data-custom="<?= esc_attr( $args['wporg_custom_data'] ); ?>"
			       name="wporg_options[<?= esc_attr( $args['label_for'] . '_pi' ); ?>]"
			       value="1" <?php checked( 1, $is_checked_pi, true ); ?>/>
			<label for="<?= esc_attr( $args['label_for'] . '_pi' ); ?>">Pinterest</label>
		</li>
		<li class="ui-state-default">
			<input type="checkbox" id="<?= esc_attr( $args['label_for'] . '_li' ); ?>"
			       data-custom="<?= esc_attr( $args['wporg_custom_data'] ); ?>"
			       name="wporg_options[<?= esc_attr( $args['label_for'] . '_li' ); ?>]"
			       value="1" <?php checked( 1, $is_checked_li, true ); ?>/>
			<label for="<?= esc_attr( $args['label_for'] . '_li' ); ?>">LinkedIn</label>
		</li>
		<li class="ui-state-default">
			<input type="checkbox" id="<?= esc_attr( $args['label_for'] . '_wa' ); ?>"
			       data-custom="<?= esc_attr( $args['wporg_custom_data'] ); ?>"
			       name="wporg_options[<?= esc_attr( $args['label_for'] . '_wa' ); ?>]"
			       value="1" <?php checked( 1, $is_checked_wa, true ); ?>/>
			<label for="<?= esc_attr( $args['label_for'] . '_wa' ); ?>">What's App</label>
		</li>
	</ul>

	<?php
}

/**
 * Icon Size
 *
 * Input type: radio buttons
 *
 * @param $args
 */

function wporg_field_icon_size_cb( $args ) {
	// get the value of the setting we've registered with register_setting()
	$options = get_option( 'wporg_options' );
	// output the field


	if ( array_key_exists( 'wporg_field_icon_size', $options ) ) {
		$is_checked = $options['wporg_field_icon_size'];
	} else {
		$is_checked = '';
	}

	?>

	<input type="radio" id="<?= esc_attr( $args['label_for'] . 'small' ); ?>"
	       data-custom="<?= esc_attr( $args['wporg_custom_data'] ); ?>"
	       name="wporg_options[<?= esc_attr( $args['label_for'] ); ?>]"
	       value="small" <?php checked( 'small', $is_checked, true ); ?>/>

	<label
		for="<?= esc_attr( $args['label_for'] . 'small' ); ?>"><?= esc_html( 'Small', 'wporg' ); ?></label>

	<input type="radio" id="<?= esc_attr( $args['label_for'] . 'medium' ); ?>"
	       data-custom="<?= esc_attr( $args['wporg_custom_data'] ); ?>"
	       name="wporg_options[<?= esc_attr( $args['label_for'] ); ?>]"
	       value="medium" <?php checked( 'medium', $is_checked, true ); ?>/>

	<label
		for="<?= esc_attr( $args['label_for'] . 'medium' ); ?>"><?= esc_html( 'Medium', 'wporg' ); ?></label>

	<input type="radio" id="<?= esc_attr( $args['label_for'] . 'large' ); ?>"
	       data-custom="<?= esc_attr( $args['wporg_custom_data'] ); ?>"
	       name="wporg_options[<?= esc_attr( $args['label_for'] ); ?>]"
	       value="large" <?php checked( 'large', $is_checked, true ); ?>/>

	<label
		for="<?= esc_attr( $args['label_for'] . 'large' ); ?>"><?= esc_html( 'Large', 'wporg' ); ?></label>

	<?php
}


/**
 * Button Colors
 *
 * Input type: radio buttons and text
 *
 * @param $args
 */

function wporg_field_button_colors_cb( $args ) {
	// get the value of the setting we've registered with register_setting()
	$options = get_option( 'wporg_options' );
	// output the field


	if ( array_key_exists( 'wporg_field_button_colors', $options ) ) {
		$is_checked = $options['wporg_field_button_colors'];
	} else {
		$is_checked = '';
	}
	if ( array_key_exists( 'wporg_field_button_colors_custom_icon', $options ) ) {
		$icon_color = $options['wporg_field_button_colors_custom_icon'];
	} else {
		$icon_color = '';
	}
	if ( array_key_exists( 'wporg_field_button_colors_custom_background', $options ) ) {
		$background_color = $options['wporg_field_button_colors_custom_background'];
	} else {
		$background_color = '';
	}

	?>

	<input type="radio" id="<?= esc_attr( $args['label_for'] . 'default' ); ?>"
	       data-custom="<?= esc_attr( $args['wporg_custom_data'] ); ?>"
	       name="wporg_options[<?= esc_attr( $args['label_for'] ); ?>]"
	       value="default" <?php checked( 'default', $is_checked, true ); ?>/>

	<label
		for="<?= esc_attr( $args['label_for'] . 'default' ); ?>"><?= esc_html( 'Default', 'wporg' ); ?></label>

	<input type="radio" id="<?= esc_attr( $args['label_for'] . 'custom' ); ?>"
	       data-custom="<?= esc_attr( $args['wporg_custom_data'] ); ?>"
	       name="wporg_options[<?= esc_attr( $args['label_for'] ); ?>]"
	       value="custom" <?php checked( 'custom', $is_checked, true ); ?>/>

	<label
		for="<?= esc_attr( $args['label_for'] . 'custom' ); ?>"><?= esc_html( 'Custom', 'wporg' ); ?></label>

	<input type="text" id="<?= esc_attr( $args['label_for'] ); ?>"
	       data-custom="<?= esc_attr( $args['wporg_custom_data'] ); ?>"
	       name="wporg_options[<?= esc_attr( $args['label_for'] ); ?>]"
	       value="<?php echo $icon_color; ?>"/>

	<label for="<?= esc_attr( $args['label_for'] ); ?>"><?= esc_html( 'Icon Color', 'wporg' ); ?></label>

	<input type="text" id="<?= esc_attr( $args['label_for'] ); ?>"
	       data-custom="<?= esc_attr( $args['wporg_custom_data'] ); ?>"
	       name="wporg_options[<?= esc_attr( $args['label_for'] ); ?>]"
	       value="<?php echo $background_color; ?>"/>

	<label for="<?= esc_attr( $args['label_for'] ); ?>"><?= esc_html( 'Background Color', 'wporg' ); ?></label>

	<?php
}


/**
 * Sharing Location Checkboxes
 *
 * Input type: checkboxes
 *
 * @param $args
 */
function wporg_field_sharing_location_cb( $args ) {
	// get the value of the setting we've registered with register_setting()
	$options = get_option( 'wporg_options' );
	// output the field

	if ( array_key_exists( 'wporg_field_sharing_location_below_post_title', $options ) ) {
		$below_post_title = $options['wporg_field_sharing_location_below_post_title'];
	} else {
		$below_post_title = '';
	}

	if ( array_key_exists( 'wporg_field_sharing_location_floating_left', $options ) ) {
		$floating_left = $options['wporg_field_sharing_location_floating_left'];
	} else {
		$floating_left = '';
	}

	if ( array_key_exists( 'wporg_field_sharing_location_after_post_content', $options ) ) {
		$after_post_content = $options['wporg_field_sharing_location_after_post_content'];
	} else {
		$after_post_content = '';
	}

	if ( array_key_exists( 'wporg_field_sharing_location_inside_feature_image', $options ) ) {
		$inside_feature_image = $options['wporg_field_sharing_location_inside_feature_image'];
	} else {
		$inside_feature_image = '';
	}
	?>

	<input type="checkbox" id="<?= esc_attr( $args['label_for'] . '_below_post_title' ); ?>"
	       data-custom="<?= esc_attr( $args['wporg_custom_data'] ); ?>"
	       name="wporg_options[<?= esc_attr( $args['label_for'] . '_below_post_title' ); ?>]"
	       value="1" <?php checked( 1, $below_post_title, true ); ?>/>

	<label
		for="<?= esc_attr( $args['label_for'] . '_below_post_title' ); ?>"><?= esc_html( 'Below post title', 'wporg' ); ?></label>

	<input type="checkbox" id="<?= esc_attr( $args['label_for'] . '_floating_left' ); ?>"
	       data-custom="<?= esc_attr( $args['wporg_custom_data'] ); ?>"
	       name="wporg_options[<?= esc_attr( $args['label_for'] . '_floating_left' ); ?>]"
	       value="1" <?php checked( 1, $floating_left, true ); ?>/>

	<label
		for="<?= esc_attr( $args['label_for'] . '_floating_left' ); ?>"><?= esc_html( 'Floating Left', 'wporg' ); ?></label>

	<input type="checkbox" id="<?= esc_attr( $args['label_for'] . '_after_post_content' ); ?>"
	       data-custom="<?= esc_attr( $args['wporg_custom_data'] ); ?>"
	       name="wporg_options[<?= esc_attr( $args['label_for'] . '_after_post_content' ); ?>]"
	       value="1" <?php checked( 1, $after_post_content, true ); ?>/>

	<label
		for="<?= esc_attr( $args['label_for'] . '_after_post_content' ); ?>"><?= esc_html( 'After post content', 'wporg' ); ?></label>

	<input type="checkbox" id="<?= esc_attr( $args['label_for'] . '_inside_feature_image' ); ?>"
	       data-custom="<?= esc_attr( $args['wporg_custom_data'] ); ?>"
	       name="wporg_options[<?= esc_attr( $args['label_for'] . '_inside_feature_image' ); ?>]"
	       value="1" <?php checked( 1, $inside_feature_image, true ); ?>/>

	<label
		for="<?= esc_attr( $args['label_for'] . '_inside_feature_image' ); ?>"><?= esc_html( 'Inside Feature Image', 'wporg' ); ?></label>

	<?php
}


/**
 * Radio Buttons
 *
 * @param $args
 */

function wporg_field_radio_cb( $args ) {
	// get the value of the setting we've registered with register_setting()
	$options = get_option( 'wporg_options' );
	// output the field


	if ( array_key_exists( 'wporg_field_radio', $options ) ) {
		$is_checked = $options['wporg_field_radio'];
	} else {
		$is_checked = '';
	}


	?>

	<input type="radio" id="<?= esc_attr( $args['label_for'] . 'option1' ); ?>"
	       data-custom="<?= esc_attr( $args['wporg_custom_data'] ); ?>"
	       name="wporg_options[<?= esc_attr( $args['label_for'] ); ?>]"
	       value="1" <?php checked( 1, $is_checked, true ); ?>/>

	<label
		for="<?= esc_attr( $args['label_for'] . 'option1' ); ?>"><?= esc_html( 'Option 1', 'wporg' ); ?></label>

	<input type="radio" id="<?= esc_attr( $args['label_for'] . 'option2' ); ?>"
	       data-custom="<?= esc_attr( $args['wporg_custom_data'] ); ?>"
	       name="wporg_options[<?= esc_attr( $args['label_for'] ); ?>]"
	       value="2" <?php checked( 2, $is_checked, true ); ?>/>

	<label
		for="<?= esc_attr( $args['label_for'] . 'option2' ); ?>"><?= esc_html( 'Option 2', 'wporg' ); ?></label>

	<?php
}

/**
 * Input type: checkboxes
 *
 * @param $args
 */
function wporg_field_checkbox_cb( $args ) {
	// get the value of the setting we've registered with register_setting()
	$options = get_option( 'wporg_options' );
	// output the field


	if ( array_key_exists( 'wporg_field_checkbox_option1', $options ) ) {
		$is_checked_1 = $options['wporg_field_checkbox_option1'];
	} else {
		$is_checked_1 = '';
	}

	if ( array_key_exists( 'wporg_field_checkbox_option2', $options ) ) {
		$is_checked_2 = $options['wporg_field_checkbox_option2'];
	} else {
		$is_checked_2 = '';
	}


	?>

	<input type="checkbox" id="<?= esc_attr( $args['label_for'] . '_option1' ); ?>"
	       data-custom="<?= esc_attr( $args['wporg_custom_data'] ); ?>"
	       name="wporg_options[<?= esc_attr( $args['label_for'] . '_option1' ); ?>]"
	       value="1" <?php checked( 1, $is_checked_1, true ); ?>/>

	<label
		for="<?= esc_attr( $args['label_for'] . '_option1' ); ?>"><?= esc_html( 'Option 1', 'wporg' ); ?></label>

	<input type="checkbox" id="<?= esc_attr( $args['label_for'] . '_option2' ); ?>"
	       data-custom="<?= esc_attr( $args['wporg_custom_data'] ); ?>"
	       name="wporg_options[<?= esc_attr( $args['label_for'] . '_option2' ); ?>]"
	       value="2" <?php checked( 2, $is_checked_2, true ); ?>/>

	<label
		for="<?= esc_attr( $args['label_for'] . '_option2' ); ?>"><?= esc_html( 'Option 2', 'wporg' ); ?></label>

	<?php
}

/**
 * Plugin activation
 *
 * Select type
 *
 * @param $args
 */

function wporg_field_select_cb( $args ) {
	// get the value of the setting we've registered with register_setting()
	$options = get_option( 'wporg_options' );
	// output the field
	?>
	<label id="<?= esc_attr( $args['label_for'] ); ?>">Would you like to activate the Social Sharing plugin?</label>
	<select id="<?= esc_attr( $args['label_for'] ); ?>"
	        data-custom="<?= esc_attr( $args['wporg_custom_data'] ); ?>"
	        name="wporg_options[<?= esc_attr( $args['label_for'] ); ?>]">
		<option
			value="deactivate" <?= isset( $options[ $args['label_for'] ] ) ? ( selected( $options[ $args['label_for'] ], 'deactivate', false ) ) : ( '' ); ?>>
			<?= esc_html( 'no', 'wporg' ); ?>
		</option>
		<option
			value="activate" <?= isset( $options[ $args['label_for'] ] ) ? ( selected( $options[ $args['label_for'] ], 'activate', false ) ) : ( '' ); ?>>
			<?= esc_html( 'yes', 'wporg' ); ?>
		</option>

	</select>

	<?php
}


/**
 * Input
 *
 * @param $args
 */

function wporg_field_text_cb( $args ) {
	// get the value of the setting we've registered with register_setting()
	$options = get_option( 'wporg_options' );
	// output the field

	if ( array_key_exists( 'wporg_field_text', $options ) ) {
		$is_checked = $options['wporg_field_text'];
	} else {
		$is_checked = '';
	}

	?>

	<input type="text" id="<?= esc_attr( $args['label_for'] ); ?>"
	       data-custom="<?= esc_attr( $args['wporg_custom_data'] ); ?>"
	       name="wporg_options[<?= esc_attr( $args['label_for'] ); ?>]"
	       value="<?php echo $is_checked; ?>"/>

	<label for="<?= esc_attr( $args['label_for'] ); ?>"><?= esc_html( 'Label', 'wporg' ); ?></label>


	<?php
}


/**
 * top level menu
 */
function wporg_options_page() {
	// add top level menu page
	add_menu_page(
		'WPOrg',
		'WPOrg Options',
		'manage_options',
		'wporg',
		'wporg_options_page_html',
		'dashicons-share'
	);
}

/**
 * register our wporg_options_page to the admin_menu action hook
 */
add_action( 'admin_menu', 'wporg_options_page' );

/**
 * top level menu:
 * callback functions
 */
function wporg_options_page_html() {
	// check user capabilities
	if ( ! current_user_can( 'manage_options' ) ) {
		return;
	}

	// add error/update messages

	// check if the user have submitted the settings
	// wordpress will add the "settings-updated" $_GET parameter to the url
	if ( isset( $_GET['settings-updated'] ) ) {
		// add settings saved message with the class of "updated"
		add_settings_error( 'wporg_messages', 'wporg_message', __( 'Settings Saved', 'wporg' ), 'updated' );
	}

	// show error/update messages
	settings_errors( 'wporg_messages' );
	?>
	<div class="wrap">
		<h1><?= esc_html( get_admin_page_title() ); ?></h1>
		<form action="options.php" method="post">
			<?php
			// output security fields for the registered setting "wporg"
			settings_fields( 'wporg' );
			// output setting sections and their fields
			// (sections are registered for "wporg", each field is registered to a specific section)
			do_settings_sections( 'wporg' );
			// output save settings button
			submit_button( 'Save Settings' );
			?>
		</form>
	</div>
	<?php
}


