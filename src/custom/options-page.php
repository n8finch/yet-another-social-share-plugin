<?php
/**
 * Sandbox test file
 *
 * @package     YetAnotherSocialShare\Custom
 * @since       1.0.0
 * @author      n8finch
 * @link        https://n8finch.com
 * @license     GNU General Public License 2.0+
 */
//namespace YetAnotherSocialShare\Custom;


/**
 * Provides default values for the Input Options.
 */
function yass_default_options() {

	$defaults = array(
		'yass_field_activate'                             => 'yes',
		'yass_field_post_types_post'                      => '1',
		'yass_field_post_types_page'                      => '1',
		'yass_field_active_networks_fb'                   => '1',
		'yass_field_active_networks_tw'                   => '1',
		'yass_field_active_networks_go'                   => '1',
		'yass_field_active_networks_pi'                   => '1',
		'yass_field_active_networks_li'                   => '1',
		'yass_field_active_networks_wa'                   => '1',
		'yass_field_icon_size'                            => 'medium',
		'yass_field_button_colors'                        => 'default',
		'yass_field_button_colors_custom_icon'            => '#000000',
		'yass_field_button_colors_custom_background'      => '#ffffff',
		'yass_field_sharing_location_below_post_tile'     => '',
		'yass_field_sharing_location_floating_left'       => '1',
		'yass_field_sharing_location_after_post_content'  => '',
		'yass_field_sharing_example_inside_feature_image' => '',

	);

	return apply_filters( 'yass_default_options', $defaults );

} // end yass_theme_default_input_options

/**
 * Initialize custom option and settings
 */
function yass_settings_init() {

	if ( false == get_option( 'yass_options' ) ) {
		add_option( 'yass_options', apply_filters( 'yass_default_options', yass_default_options() ) );
	} // end if


	// register a new setting for "yass" page
	register_setting( 'yass', 'yass_options' );

	// register a new section in the "yass" page
	add_settings_section(
		'yass_section',
		__( 'Settings', 'ya-social-share' ),
		'yass_intro_section_cb',
		'yass'
	);

	// register a new field in the "yass_section" section, inside the "yass" page
	add_settings_field(
		'yass_field_activate', // as of WP 4.6 this value is used only internally
		// use $args' label_for to populate the id inside the callback
		__( 'Activation', 'ya-social-share' ),
		'yass_field_active_cb',
		'yass',
		'yass_section',
		[
			'label_for'        => 'yass_field_activate',
			'class'            => 'yass_row',
			'yass_custom_data' => 'yass-plugin-activate',
		]
	);

	add_settings_field(
		'yass_field_post_types',
		__( 'Post Types', 'ya-social-share' ),
		'yass_field_post_types_cb',
		'yass',
		'yass_section',
		[
			'label_for'        => 'yass_field_post_types_',
			'class'            => 'yass_row',
			'yass_custom_data' => 'yass-plugin-post-types',
		]
	);

	add_settings_field(
		'yass_field_active_networks',
		__( 'Active Networks', 'ya-social-share' ),
		'yass_field_active_networks_cb',
		'yass',
		'yass_section',
		[
			'label_for'        => 'yass_field_active_networks',
			'class'            => 'yass_row',
			'yass_custom_data' => 'yass-plugin-active-networks',
		]
	);

	add_settings_field(
		'yass_field_icon_size',
		__( 'Icon Size', 'ya-social-share' ),
		'yass_field_icon_size_cb',
		'yass',
		'yass_section',
		[
			'label_for'        => 'yass_field_icon_size',
			'class'            => 'yass_row',
			'yass_custom_data' => 'yass-plugin-icon-size',
		]
	);

	add_settings_field(
		'yass_field_button_colors',
		__( 'Button Colors', 'ya-social-share' ),
		'yass_field_button_colors_cb',
		'yass',
		'yass_section',
		[
			'label_for'        => 'yass_field_button_colors',
			'class'            => 'yass_row',
			'yass_custom_data' => 'yass-plugin-button-colors',
		]
	);

	add_settings_field(
		'yass_field_custom_icon_color',
		__( 'Custom Icon Color', 'ya-social-share' ),
		'yass_field_custom_icon_color_cb',
		'yass',
		'yass_section',
		[
			'label_for'        => 'yass_field_custom_icon_color',
			'class'            => 'yass-row-custom-icon-color',
			'yass_custom_data' => 'yass-plugin-custom-icon-color',
		]
	);

	add_settings_field(
		'yass_field_custom_background_color',
		__( 'Custom Background Color', 'ya-social-share' ),
		'yass_field_custom_background_color_cb',
		'yass',
		'yass_section',
		[
			'label_for'        => 'yass_field_custom_background_color',
			'class'            => 'yass-row-custom-background-color',
			'yass_custom_data' => 'yass-plugin-custom-background-color',
		]
	);

	add_settings_field(
		'yass_field_sharing_location',
		__( 'Sharing Location', 'ya-social-share' ),
		'yass_field_sharing_location_cb',
		'yass',
		'yass_section',
		[
			'label_for'        => 'yass_field_sharing_location',
			'class'            => 'yass_row',
			'yass_custom_data' => 'yass-plugin-sharing-location',
		]
	);
} //end yass_settings_init

/**
 * register our yass_settings_init to the admin_init action hook
 */
add_action( 'admin_init', 'yass_settings_init' );

/** --------------------------------------------
 * Custom option and settings callback functions
 *  -------------------------------------------- */

/**
 * Intro section cb
 *
 */

function yass_intro_section_cb( $args ) {
	?>
	<p id="<?= esc_attr( $args['id'] ); ?>"><?= esc_html__( 'Configure your social sharing experience here.', 'ya-social-share' ); ?></p>
	<?php
}

/**
 * Plugin activation
 *
 * Select type
 *
 * @param $args
 */

function yass_field_active_cb( $args ) {
	// get the yass_options from the db
	$options = get_option( 'yass_options' );

	?>
	<label for="<?= esc_attr( $args['label_for'] ); ?>">Would you like to activate the Social Sharing plugin?</label>
	<select id="<?= esc_attr( $args['label_for'] ); ?>"
	        data-custom="<?= esc_attr( $args['yass_custom_data'] ); ?>"
	        name="yass_options[<?= esc_attr( $args['label_for'] ); ?>]">
		<option
			value="deactivate" <?= isset( $options[ $args['label_for'] ] ) ? ( selected( $options[ $args['label_for'] ], 'deactivate', false ) ) : ( '' ); ?>><?= esc_html( 'no', 'yass' ); ?>
		</option>
		<option
			value="activate" <?= isset( $options[ $args['label_for'] ] ) ? ( selected( $options[ $args['label_for'] ], 'activate', false ) ) : ( '' ); ?>><?= esc_html( 'yes', 'yass' ); ?>
		</option>

	</select>

	<?php
} //end yass_field_active_cb

/**
 * Post Types Checkboxes
 *
 * Input type: checkboxes
 *
 * @param $args
 */
function yass_field_post_types_cb( $args ) {
	$options = get_option( 'yass_options' );

	$public_post_types = get_post_types( array( "public" => true ) );

	foreach ( $public_post_types as $post_type ) {

		if ( array_key_exists( 'yass_field_post_types_' . $post_type, $options ) ) {
			$is_checked = $options[ 'yass_field_post_types_' . $post_type ];
		} else {
			$is_checked = '';
		}
		?>
		<input type="checkbox" id="<?= esc_attr( $args['label_for'] . $post_type ); ?>"
		       data-custom="<?= esc_attr( $args['yass_custom_data'] ); ?>"
		       name="yass_options[<?= esc_attr( $args['label_for'] . $post_type ); ?>]"
		       value="1" <?php checked( 1, $is_checked, true ); ?>/>

		<label
			for="<?= esc_attr( $args['label_for'] . $post_type ); ?>"><?= esc_html( ucfirst( $post_type ), 'yass' ); ?></label>

		<?php
	}

} // end yass_field_post_types_cb

/**
 * Active Networks
 *
 * Input type: checkboxes
 *
 * @param $args
 */
function yass_field_active_networks_cb( $args ) {
	$options = get_option( 'yass_options' );

	if ( array_key_exists( 'yass_field_active_networks_fb', $options ) ) {
		$is_checked_fb = $options['yass_field_active_networks_fb'];
	} else {
		$is_checked_fb = '';
	}

	if ( array_key_exists( 'yass_field_active_networks_tw', $options ) ) {
		$is_checked_tw = $options['yass_field_active_networks_tw'];
	} else {
		$is_checked_tw = '';
	}

	if ( array_key_exists( 'yass_field_active_networks_go', $options ) ) {
		$is_checked_go = $options['yass_field_active_networks_go'];
	} else {
		$is_checked_go = '';
	}

	if ( array_key_exists( 'yass_field_active_networks_pi', $options ) ) {
		$is_checked_pi = $options['yass_field_active_networks_pi'];
	} else {
		$is_checked_pi = '';
	}

	if ( array_key_exists( 'yass_field_active_networks_li', $options ) ) {
		$is_checked_li = $options['yass_field_active_networks_li'];
	} else {
		$is_checked_li = '';
	}

	if ( array_key_exists( 'yass_field_active_networks_wa', $options ) ) {
		$is_checked_wa = $options['yass_field_active_networks_wa'];
	} else {
		$is_checked_wa = '';
	}
	$dad_list = get_option('dad_list');
	if(!isset($dad_list) || !is_array($dad_list)) {
	$list = array(
	'Option one',
	'Option two',
	'Option three',
	'Option four',
	'Option five',
	'Option six',
	);
	add_option('dad_list', $list);
	}

	global $dad_list;


	ob_start(); ?>
	<div class="wrap">
		<h2><?php _e('Drag and Drop Example', 'pippin'); ?></h2>

		<table class="wp-list-table widefat fixed posts dad-list">
			<thead>
			<tr>
				<th><?php _e('Name', 'pippin'); ?></th>
				<th><?php _e('Order', 'pippin'); ?></th>
			</tr>
			</thead>
			<tfoot>
			<tr>
				<th><?php _e('Name', 'pippin'); ?></th>
				<th><?php _e('Order', 'pippin'); ?></th>
			</tr>
			</tfoot>
			<tbody>
			<?php
			$count = 0;
			foreach($dad_list as $key => $item) :
				echo '<tr id="list_items_' . $key . '" class="list_item">';
				echo '<td>' . $item . '</td>';
				echo '<td>' . $count . '</td>';
				echo '</tr>';
				$count++;
			endforeach;
			?>
			</tbody>
		</table>


	</div>
	<?php
	echo ob_get_clean();
	?>


<!--	<ul id="sortable">-->
<!--		<li class="ui-state-default .list_item">-->
<!--			<input type="checkbox" id="--><?//= esc_attr( $args['label_for'] . '_fb' ); ?><!--"-->
<!--			       data-custom="--><?//= esc_attr( $args['yass_custom_data'] ); ?><!--"-->
<!--			       name="yass_options[--><?//= esc_attr( $args['label_for'] . '_fb' ); ?><!--]"-->
<!--			       value="1" --><?php //checked( 1, $is_checked_fb, true ); ?><!--/>-->
<!--			<label for="--><?//= esc_attr( $args['label_for'] . '_fb' ); ?><!--">Facebook</label>-->
<!--		</li>-->
<!--		<li class="ui-state-default .list_item">-->
<!--			<input type="checkbox" id="--><?//= esc_attr( $args['label_for'] . '_tw' ); ?><!--"-->
<!--			       data-custom="--><?//= esc_attr( $args['yass_custom_data'] ); ?><!--"-->
<!--			       name="yass_options[--><?//= esc_attr( $args['label_for'] . '_tw' ); ?><!--]"-->
<!--			       value="1" --><?php //checked( 1, $is_checked_tw, true ); ?><!--/>-->
<!--			<label for="--><?//= esc_attr( $args['label_for'] . '_tw' ); ?><!--">Twitter</label>-->
<!--		</li>-->
<!--		<li class="ui-state-default .list_item">-->
<!--			<input type="checkbox" id="--><?//= esc_attr( $args['label_for'] . '_go' ); ?><!--"-->
<!--			       data-custom="--><?//= esc_attr( $args['yass_custom_data'] ); ?><!--"-->
<!--			       name="yass_options[--><?//= esc_attr( $args['label_for'] . '_go' ); ?><!--]"-->
<!--			       value="1" --><?php //checked( 1, $is_checked_go, true ); ?><!--/>-->
<!--			<label for="--><?//= esc_attr( $args['label_for'] . '_go' ); ?><!--">Google+</label>-->
<!--		</li>-->
<!--		<li class="ui-state-default .list_item">-->
<!--			<input type="checkbox" id="--><?//= esc_attr( $args['label_for'] . '_pi' ); ?><!--"-->
<!--			       data-custom="--><?//= esc_attr( $args['yass_custom_data'] ); ?><!--"-->
<!--			       name="yass_options[--><?//= esc_attr( $args['label_for'] . '_pi' ); ?><!--]"-->
<!--			       value="1" --><?php //checked( 1, $is_checked_pi, true ); ?><!--/>-->
<!--			<label for="--><?//= esc_attr( $args['label_for'] . '_pi' ); ?><!--">Pinterest</label>-->
<!--		</li>-->
<!--		<li class="ui-state-default .list_item">-->
<!--			<input type="checkbox" id="--><?//= esc_attr( $args['label_for'] . '_li' ); ?><!--"-->
<!--			       data-custom="--><?//= esc_attr( $args['yass_custom_data'] ); ?><!--"-->
<!--			       name="yass_options[--><?//= esc_attr( $args['label_for'] . '_li' ); ?><!--]"-->
<!--			       value="1" --><?php //checked( 1, $is_checked_li, true ); ?><!--/>-->
<!--			<label for="--><?//= esc_attr( $args['label_for'] . '_li' ); ?><!--">LinkedIn</label>-->
<!--		</li>-->
<!--		<li class="ui-state-default .list_item">-->
<!--			<input type="checkbox" id="--><?//= esc_attr( $args['label_for'] . '_wa' ); ?><!--"-->
<!--			       data-custom="--><?//= esc_attr( $args['yass_custom_data'] ); ?><!--"-->
<!--			       name="yass_options[--><?//= esc_attr( $args['label_for'] . '_wa' ); ?><!--]"-->
<!--			       value="1" --><?php //checked( 1, $is_checked_wa, true ); ?><!--/>-->
<!--			<label for="--><?//= esc_attr( $args['label_for'] . '_wa' ); ?><!--">What's App</label>-->
<!--		</li>-->
<!--	</ul>-->

	<?php
} // end yass_field_active_networks_cb

/**
 * Icon Size
 *
 * Input type: radio buttons
 *
 * @param $args
 */

function yass_field_icon_size_cb( $args ) {
	$options = get_option( 'yass_options' );

	if ( array_key_exists( 'yass_field_icon_size', $options ) ) {
		$is_checked = $options['yass_field_icon_size'];
	} else {
		$is_checked = '';
	}
	?>

	<input type="radio" id="<?= esc_attr( $args['label_for'] . 'small' ); ?>"
	       data-custom="<?= esc_attr( $args['yass_custom_data'] ); ?>"
	       name="yass_options[<?= esc_attr( $args['label_for'] ); ?>]"
	       value="small" <?php checked( 'small', $is_checked, true ); ?>/>

	<label
		for="<?= esc_attr( $args['label_for'] . 'small' ); ?>"><?= esc_html( 'Small', 'yass' ); ?></label>

	<input type="radio" id="<?= esc_attr( $args['label_for'] . 'medium' ); ?>"
	       data-custom="<?= esc_attr( $args['yass_custom_data'] ); ?>"
	       name="yass_options[<?= esc_attr( $args['label_for'] ); ?>]"
	       value="medium" <?php checked( 'medium', $is_checked, true ); ?>/>

	<label
		for="<?= esc_attr( $args['label_for'] . 'medium' ); ?>"><?= esc_html( 'Medium', 'yass' ); ?></label>

	<input type="radio" id="<?= esc_attr( $args['label_for'] . 'large' ); ?>"
	       data-custom="<?= esc_attr( $args['yass_custom_data'] ); ?>"
	       name="yass_options[<?= esc_attr( $args['label_for'] ); ?>]"
	       value="large" <?php checked( 'large', $is_checked, true ); ?>/>

	<label
		for="<?= esc_attr( $args['label_for'] . 'large' ); ?>"><?= esc_html( 'Large', 'yass' ); ?></label>

	<?php
} // end yass_field_icon_size_cb


/**
 * Button Colors
 *
 * Input type: radio buttons
 *
 * @param $args
 */

function yass_field_button_colors_cb( $args ) {
	$options = get_option( 'yass_options' );


	if ( array_key_exists( 'yass_field_button_colors', $options ) ) {
		$is_checked = $options['yass_field_button_colors'];
	} else {
		$is_checked = '';
	}
	?>

	<input type="radio" id="<?= esc_attr( $args['label_for'] . 'default' ); ?>"
	       data-custom="<?= esc_attr( $args['yass_custom_data'] ); ?>"
	       name="yass_options[<?= esc_attr( $args['label_for'] ); ?>]"
	       value="default" <?php checked( 'default', $is_checked, true ); ?>/>

	<label
		for="<?= esc_attr( $args['label_for'] . 'default' ); ?>"><?= esc_html( 'Default', 'yass' ); ?></label>

	<input type="radio" id="<?= esc_attr( $args['label_for'] . 'custom' ); ?>"
	       data-custom="<?= esc_attr( $args['yass_custom_data'] ); ?>"
	       name="yass_options[<?= esc_attr( $args['label_for'] ); ?>]"
	       value="custom" <?php checked( 'custom', $is_checked, true ); ?>/>

	<label
		for="<?= esc_attr( $args['label_for'] . 'custom' ); ?>"><?= esc_html( 'Custom', 'yass' ); ?></label>

	<?php
} //end yass_field_button_colors_cb


/**
 * Custom Icon Color
 *
 * Input type: text
 *
 * @param $args
 */

function yass_field_custom_icon_color_cb( $args ) {
	$options = get_option( 'yass_options' );

	if ( array_key_exists( 'yass_field_custom_icon_color', $options ) ) {
		$icon_color = $options['yass_field_custom_icon_color'];
	} else {
		$icon_color = '';
	}
	?>

	<input type="text" id="<?= esc_attr( $args['label_for'] ); ?>"
	       data-custom="<?= esc_attr( $args['yass_custom_data'] ); ?>"
	       name="yass_options[<?= esc_attr( $args['label_for'] ); ?>]"
	       value="<?php echo $icon_color; ?>"/>

	<label for="<?= esc_attr( $args['label_for'] ); ?>"><?= esc_html( 'Icon Color', 'yass' ); ?></label>

	<?php
} //end yass_field_custom_icon_color_cb

/**
 * Custom Background Color
 *
 * Input type: text
 *
 * @param $args
 */

function yass_field_custom_background_color_cb( $args ) {
	$options = get_option( 'yass_options' );

	if ( array_key_exists( 'yass_field_custom_background_color', $options ) ) {
		$background_color = $options['yass_field_custom_background_color'];
	} else {
		$background_color = '';
	}
	?>

	<input type="text" id="<?= esc_attr( $args['label_for'] ); ?>"
	       data-custom="<?= esc_attr( $args['yass_custom_data'] ); ?>"
	       name="yass_options[<?= esc_attr( $args['label_for'] ); ?>]"
	       value="<?php echo $background_color; ?>"/>

	<label for="<?= esc_attr( $args['label_for'] ); ?>"><?= esc_html( 'Background Color', 'yass' ); ?></label>

	<?php
} // end yass_field_custom_background_color_cb


/**
 * Sharing Location Checkboxes
 *
 * Input type: checkboxes
 *
 * @param $args
 */
function yass_field_sharing_location_cb( $args ) {
	$options = get_option( 'yass_options' );

	if ( array_key_exists( 'yass_field_sharing_location_below_post_title', $options ) ) {
		$below_post_title = $options['yass_field_sharing_location_below_post_title'];
	} else {
		$below_post_title = '';
	}

	if ( array_key_exists( 'yass_field_sharing_location_floating_left', $options ) ) {
		$floating_left = $options['yass_field_sharing_location_floating_left'];
	} else {
		$floating_left = '';
	}

	if ( array_key_exists( 'yass_field_sharing_location_after_post_content', $options ) ) {
		$after_post_content = $options['yass_field_sharing_location_after_post_content'];
	} else {
		$after_post_content = '';
	}

	if ( array_key_exists( 'yass_field_sharing_location_inside_feature_image', $options ) ) {
		$inside_feature_image = $options['yass_field_sharing_location_inside_feature_image'];
	} else {
		$inside_feature_image = '';
	}
	?>

	<input type="checkbox" id="<?= esc_attr( $args['label_for'] . '_below_post_title' ); ?>"
	       data-custom="<?= esc_attr( $args['yass_custom_data'] ); ?>"
	       name="yass_options[<?= esc_attr( $args['label_for'] . '_below_post_title' ); ?>]"
	       value="1" <?php checked( 1, $below_post_title, true ); ?>/>

	<label
		for="<?= esc_attr( $args['label_for'] . '_below_post_title' ); ?>"><?= esc_html( 'Below post title', 'yass' ); ?></label>

	<input type="checkbox" id="<?= esc_attr( $args['label_for'] . '_floating_left' ); ?>"
	       data-custom="<?= esc_attr( $args['yass_custom_data'] ); ?>"
	       name="yass_options[<?= esc_attr( $args['label_for'] . '_floating_left' ); ?>]"
	       value="1" <?php checked( 1, $floating_left, true ); ?>/>

	<label
		for="<?= esc_attr( $args['label_for'] . '_floating_left' ); ?>"><?= esc_html( 'Floating Left', 'yass' ); ?></label>

	<input type="checkbox" id="<?= esc_attr( $args['label_for'] . '_after_post_content' ); ?>"
	       data-custom="<?= esc_attr( $args['yass_custom_data'] ); ?>"
	       name="yass_options[<?= esc_attr( $args['label_for'] . '_after_post_content' ); ?>]"
	       value="1" <?php checked( 1, $after_post_content, true ); ?>/>

	<label
		for="<?= esc_attr( $args['label_for'] . '_after_post_content' ); ?>"><?= esc_html( 'After post content', 'yass' ); ?></label>

	<input type="checkbox" id="<?= esc_attr( $args['label_for'] . '_inside_feature_image' ); ?>"
	       data-custom="<?= esc_attr( $args['yass_custom_data'] ); ?>"
	       name="yass_options[<?= esc_attr( $args['label_for'] . '_inside_feature_image' ); ?>]"
	       value="1" <?php checked( 1, $inside_feature_image, true ); ?>/>

	<label
		for="<?= esc_attr( $args['label_for'] . '_inside_feature_image' ); ?>"><?= esc_html( 'Inside Feature Image', 'yass' ); ?></label>

	<?php
} //end yass_field_sharing_location_cb

/**
 * Create the top level menu
 */
function yass_options_page() {
	// add top level menu page
	add_menu_page(
		'YA Social Sharing Plugin',
		'YA Social Sharing',
		'manage_options',
		'yass',
		'yass_options_page_html',
		'dashicons-share'
	);
} //end yass_options_page

/**
 * Register yass_options_page to the admin_menu action hook
 */
add_action( 'admin_menu', 'yass_options_page' );

/**
 * Top level menu callback function
 */
function yass_options_page_html() {
	// check user capabilities
	if ( ! current_user_can( 'manage_options' ) ) {
		return;
	}

	// check if the user have submitted the settings
	// WordPress will add the "settings-updated" $_GET parameter to the url
	if ( isset( $_GET['settings-updated'] ) ) {
		// add settings saved message with the class of "updated"
		add_settings_error( 'yass_messages', 'yass_message', __( 'Settings Saved', 'ya-social-share' ), 'updated' );
	}

	// show error/update messages
	settings_errors( 'yass_messages' );
	?>
	<div class="wrap">
		<h1><?= esc_html( get_admin_page_title() ); ?></h1>
		<form action="options.php" method="post">
			<?php
			// output security fields for the registered setting "yass"
			settings_fields( 'yass' );
			// output setting sections and their fields
			// (sections are registered for "yass", each field is registered to a specific section)
			do_settings_sections( 'yass' );
			// output save settings button
			submit_button( 'Save Settings' );
			?>
		</form>
	</div>
	<?php
}


