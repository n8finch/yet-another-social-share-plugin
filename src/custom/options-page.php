<?php
/**
 * Yet Another Social Share Plugin
 *
 * @package     YetAnotherSocialShare\Main
 * @since       1.0.0
 * @author      n8finch
 * @link        https://n8finch.com
 * @license     GNU General Public License 2.0+
 */
//namespace YetAnotherSocialShare\Main;


/**
 * This function introduces the theme options into the 'Appearance' menu and into a top-level
 * 'yass Theme' menu.
 */
function yass_example_theme_menu() {

	add_menu_page(
		'yass Theme',                    // The value used to populate the browser's title bar when the menu page is active
		'yass Theme',                    // The text of the menu in the administrator's sidebar
		'administrator',                    // What roles are able to access the menu
		'yass_theme_menu',                // The ID used to bind submenu items to this menu
		'yass_theme_display',                // The callback function used to render this menu
		'dashicons-share'
	);

} // end yass_example_theme_menu
add_action( 'admin_menu', 'yass_example_theme_menu' );
/**
 * Renders a simple page to display for the theme menu defined above.
 */
function yass_theme_display() {
	?>
	<!-- Create a header in the default WordPress 'wrap' container -->
	<div class="wrap">

		<div id="icon-themes" class="icon32"></div>
		<h2><?php _e( 'yass Theme Options', 'ya_social_share' ); ?></h2>
		<?php settings_errors(); ?>


		<h2 class="nav-tab-wrapper"> <?php _e( 'Sharing Options', 'ya_social_share' ); ?> </h2>


		<form method="post" action="options.php">
			<?php


			settings_fields( 'yass_theme_input_examples' );
			do_settings_sections( 'yass_theme_input_examples' );


			submit_button();

			?>
		</form>

	</div><!-- /.wrap -->
	<?php
} // end yass_theme_display


/* ------------------------------------------------------------------------ *
 * Setting Registration
 * ------------------------------------------------------------------------ */
/**
 * Provides default values for the Input Options.
 */
function yass_theme_default_input_options() {

	$defaults = array(
		'input_example'    => '',
		'textarea_example' => '',
		'checkbox_example' => '',
		'radio_example'    => '',
		'time_options'     => 'default'
	);

	return apply_filters( 'yass_theme_default_input_options', $defaults );

} // end yass_theme_default_input_options


/**
 * Initializes the theme's input example by registering the Sections,
 * Fields, and Settings. This particular group of options is used to demonstration
 * validation and sanitization.
 *
 * This function is registered with the 'admin_init' hook.
 */
function yass_theme_initialize_input_examples() {
	if ( false == get_option( 'yass_theme_input_examples' ) ) {
		add_option( 'yass_theme_input_examples', apply_filters( 'yass_theme_default_input_options', yass_theme_default_input_options() ) );
	} // end if
	add_settings_section(
		'input_examples_section',
		__( 'Input Examples', 'ya_social_share' ),
		'yass_input_examples_callback',
		'yass_theme_input_examples'
	);


	add_settings_field(
		'yass-activate-social-sharing',
		__( 'Actiavte Social Sharing?', 'ya_social_share' ),
		__NAMESPACE__ . '\yass_actiavte_sharing',
		'yass_theme_input_examples',
		'input_examples_section'
	);

	add_settings_field(
		'yass-display-on-post-types',
		__( 'Choose post types to display on', 'ya_social_share' ),
		__NAMESPACE__ . '\yass_display_on_post_types',
		'yass_theme_input_examples',
		'input_examples_section'
	);

	add_settings_field(
		'yass-select-sharing-networks',
		__( 'Select networks to display, drag to change order.', 'ya_social_share' ),
		__NAMESPACE__ . '\yass_select_sharing_networks',
		'yass_theme_input_examples',
		'input_examples_section'
	);

	add_settings_field(
		'yass-select-sharing-button-size',
		__( 'Select Icon Size', 'ya_social_share' ),
		__NAMESPACE__ . '\yass_select_sharing_button_size',
		'yass_theme_input_examples',
		'input_examples_section'
	);

	add_settings_field(
		'yass-select-sharing-button-color',
		__( 'Select Icon Colors', 'ya_social_share' ),
		__NAMESPACE__ . '\yass_select_sharing_button_color',
		'yass_theme_input_examples',
		'input_examples_section'
	);

	add_settings_field(
		'yass-select-sharing-button-location',
		__( 'Where do you want to display your social sharing buttons?', 'ya_social_share' ),
		__NAMESPACE__ . '\yass_select_sharing_button_location',
		'yass_theme_input_examples',
		'input_examples_section'
	);


	register_setting(
		'yass_theme_input_examples',
		'yass_theme_input_examples',
		'yass_theme_validate_input_examples'
	);
} // end yass_theme_initialize_input_examples
add_action( 'admin_init', 'yass_theme_initialize_input_examples' );
/* ------------------------------------------------------------------------ *
 * Section Callbacks
 * ------------------------------------------------------------------------ */
/**
 * This function provides a simple description for the General Options page.
 *
 * It's called from the 'yass_initialize_theme_options' function by being passed as a parameter
 * in the add_settings_section function.
 */
function yass_general_options_callback() {
	echo '<p>' . __( 'Select which areas of content you wish to display.', 'ya_social_share' ) . '</p>';
} // end yass_general_options_callback
/**
 * This function provides a simple description for the Social Options page.
 *
 * It's called from the 'yass_theme_initialize_social_options' function by being passed as a parameter
 * in the add_settings_section function.
 */
function yass_social_options_callback() {
	echo '<p>' . __( 'Provide the URL to the social networks you\'d like to display.', 'ya_social_share' ) . '</p>';
} // end yass_general_options_callback
/**
 * This function provides a simple description for the Input Examples page.
 *
 * It's called from the 'yass_theme_initialize_input_examples_options' function by being passed as a parameter
 * in the add_settings_section function.
 */
function yass_input_examples_callback() {
	echo '<p>' . __( 'Provides examples of the five basic element types.', 'ya_social_share' ) . '</p>';
} // end yass_general_options_callback
/* ------------------------------------------------------------------------ *
 * Field Callbacks
 * ------------------------------------------------------------------------ */
/**
 * This function renders the interface elements for toggling the visibility of the header element.
 *
 * It accepts an array or arguments and expects the first element in the array to be the description
 * to be displayed next to the checkbox.
 */

function yass_actiavte_sharing() {

	$options = get_option( 'yass_theme_input_examples' );


	$html = '<input type="checkbox" id="checkbox_example" name="yass_theme_input_examples[checkbox_example]" value="1"' . checked( 1, $options['checkbox_example'], false ) . '/>';
	$html .= '&nbsp;';
	$html .= '<label for="checkbox_example">Check this box to activate sharing</label>';

	echo $html;

} // end yass_actiavte_sharing

function yass_display_on_post_types() {

	$options = get_option( 'yass_theme_input_examples' );


	$html = '<input type="checkbox" id="checkbox_example" name="yass_theme_input_examples[checkbox_example]" value="1"' . checked( 1, $options['checkbox_example'], false ) . '/>';
	$html .= '&nbsp;';
	$html .= '<label for="checkbox_example">posts </label>';

	$html .= '<input type="checkbox" id="checkbox_example" name="yass_theme_input_examples[checkbox_example]" value="1"' . checked( 1, $options['checkbox_example'], false ) . '/>';
	$html .= '&nbsp;';
	$html .= '<label for="checkbox_example">pages </label>';

	$html .= '<input type="checkbox" id="checkbox_example" name="yass_theme_input_examples[checkbox_example]" value="1"' . checked( 1, $options['checkbox_example'], false ) . '/>';
	$html .= '&nbsp;';
	$html .= '<label for="checkbox_example">custom </label>';

	//TODO query for all active post types and display in place of all these.

	echo $html;

} // end yass_display_on_post_types


function yass_select_sharing_networks() {

	$options = get_option( 'yass_theme_input_examples' );

	$html = '<table><tbody id="sortable">
			  <tr id="yass-table-header" class="ui-state-disabled"><th>Order</th><th>Network</th><th>Active</th></tr>
			  <tr class="ui-state-default"><td>^</td><td>Item 1</td><td>^</td></tr>
			  <tr class="ui-state-default"><td>^</td><td>Item 2</td><td>^</td></tr>
			  <tr class="ui-state-default"><td>^</td><td>Item 3</td><td>^</td></tr>
			  <tr class="ui-state-default"><td>^</td><td>Item 4</td><td>^</td></tr>
			  <tr class="ui-state-default"><td>^</td><td>Item 5</td><td>^</td></tr>
			  <tr class="ui-state-default"><td>^</td><td>Item 6</td><td>^</td></tr>
			  <tr class="ui-state-default"><td>^</td><td>Item 7</td><td>^</td></tr>
			</tbody></table>';


	$html .= '<input type="checkbox" id="checkbox_example" name="yass_theme_input_examples[checkbox_example]" value="1"' . checked( 1, $options['checkbox_example'], false ) . '/>';
	$html .= '&nbsp;';
	$html .= '<label for="checkbox_example">Check this box to activate sharing</label>';

	echo $html;

} // end yass_select_sharing_networks


function yass_select_sharing_button_size() {
	$options = get_option( 'yass_theme_input_examples' );


	$html = '<input type="radio" id="radio_example_one" name="yass_theme_input_examples[radio_example]" value="1"' . checked( 1, $options['radio_example'], false ) . '/>';
	$html .= '&nbsp;';
	$html .= '<label for="radio_example_one">Small</label>';
	$html .= '&nbsp;';
	$html .= '<input type="radio" id="radio_example_two" name="yass_theme_input_examples[radio_example]" value="2"' . checked( 2, $options['radio_example'], false ) . '/>';
	$html .= '&nbsp;';
	$html .= '<label for="radio_example_two">Medium</label>';
	$html .= '&nbsp;';
	$html .= '<input type="radio" id="radio_example_three" name="yass_theme_input_examples[radio_example]" value="2"' . checked( 3, $options['radio_example'], false ) . '/>';
	$html .= '&nbsp;';
	$html .= '<label for="radio_example_three">Large</label>';

	echo $html;
} // end yass_radio_element_callback


function yass_select_sharing_button_color() {
	$options = get_option( 'yass_theme_input_examples' );


	$html = '<input type="radio" id="color_example_one" name="yass_theme_input_examples[radio_example]" value="1"' . checked( 1, $options['radio_example'], false ) . '/>';
	$html .= '&nbsp;';
	$html .= '<label for="color_example_one">Default</label>';
	$html .= '&nbsp;';
	$html .= '<input type="radio" id="color_example_two" name="yass_theme_input_examples[radio_example]" value="2"' . checked( 2, $options['radio_example'], false ) . '/>';
	$html .= '&nbsp;';
	$html .= '<label for="color_example_two">Black</label>';
	$html .= '&nbsp;';
	$html .= '<input type="radio" id="color_example_three" name="yass_theme_input_examples[radio_example]" value="2"' . checked( 3, $options['radio_example'], false ) . '/>';
	$html .= '&nbsp;';
	$html .= '<label for="color_example_three">White</label>';
	$html .= '&nbsp;';
	$html .= '<input type="text" id="color_example_text" name="yass_theme_input_examples[radio_example]" value="2"' . checked( 3, $options['radio_example'], false ) . '/>';
	$html .= '&nbsp;';
	$html .= '<label for="color_example_text">Hex Code</label>';

	echo $html;
} // end yass_select_sharing_button_color

function yass_select_sharing_button_location() {

	$options = get_option( 'yass_theme_input_examples' );

	$html = '<input type="checkbox" id="checkbox_location_below_post_tile" name="yass_theme_input_examples[checkbox_example]" value="1"' . checked( 1, $options['checkbox_example'], false ) . '/>';
	$html .= '&nbsp;';
	$html .= '<label for="checkbox_location_below_post_tile">below post title </label>';

	$html .= '<input type="checkbox" id="checkbox_location_floating_left" name="yass_theme_input_examples[checkbox_example]" value="1"' . checked( 1, $options['checkbox_example'], false ) . '/>';
	$html .= '&nbsp;';
	$html .= '<label for="checkbox_location_floating_left">floating left </label>';


	$html .= '<input type="checkbox" id="checkbox_locationafter_post_content" name="yass_theme_input_examples[checkbox_example]" value="1"' . checked( 1, $options['checkbox_example'], false ) . '/>';
	$html .= '&nbsp;';
	$html .= '<label for="checkbox_locationafter_post_content">after post content </label>';

	$html .= '<input type="checkbox" id="checkbox_example_inside_feature_image" name="yass_theme_input_examples[checkbox_example]" value="1"' . checked( 1, $options['checkbox_example'], false ) . '/>';
	$html .= '&nbsp;';
	$html .= '<label for="checkbox_example_inside_feature_image">inside feature image </label>';

	echo $html;

} // end yass_select_sharing_button_location








/* ------------------------------------------------------------------------ *
 * Setting Callbacks
 * ------------------------------------------------------------------------ */

/**
 * Sanitization callback for the social options. Since each of the social options are text inputs,
 * this function loops through the incoming option and strips all tags and slashes from the value
 * before serializing it.
 *
 * @params    $input    The unsanitized collection of options.
 *
 * @returns            The collection of sanitized values.
 */
function yass_theme_sanitize_social_options( $input ) {

	// Define the array for the updated options
	$output = array();
	// Loop through each of the options sanitizing the data
	foreach ( $input as $key => $val ) {

		if ( isset ( $input[ $key ] ) ) {
			$output[ $key ] = esc_url_raw( strip_tags( stripslashes( $input[ $key ] ) ) );
		} // end if

	} // end foreach

	// Return the new collection
	return apply_filters( 'yass_theme_sanitize_social_options', $output, $input );
} // end yass_theme_sanitize_social_options
function yass_theme_validate_input_examples( $input ) {
	// Create our array for storing the validated options
	$output = array();

	// Loop through each of the incoming options
	foreach ( $input as $key => $value ) {

		// Check to see if the current option has a value. If so, process it.
		if ( isset( $input[ $key ] ) ) {

			// Strip all HTML and PHP tags and properly handle quoted strings
			$output[ $key ] = strip_tags( stripslashes( $input[ $key ] ) );

		} // end if

	} // end foreach

	// Return the array processing any additional functions filtered by this action
	return apply_filters( 'yass_theme_validate_input_examples', $output, $input );
} // end yass_theme_validate_input_examples