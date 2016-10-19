<?php
/**
 * Description
 *
 * @package     YetAnotherSocialShare\Custom
 * @since       1.0.0
 * @author      n8finch
 * @link        https://n8finch.com
 * @license     GNU General Public License
 */


namespace YetAnotherSocialShare\Custom;

$yass_options = get_option( 'yass_options' );

//Bail out if plugin is deactivated
if ( $yass_options['yass_field_activate'] === 'activate' ) {

	$display_left = array_key_exists('yass_field_sharing_location_floating_left', $yass_options);
	if ( $display_left  ) {
		add_action( 'wp_footer', __NAMESPACE__ . '\add_yass_social_icons_floating_left' );
	}

	$display_left = array_key_exists('yass_field_sharing_location_floating_left', $yass_options);

	if ( is_single() ) {
		add_filter( 'the_title', __NAMESPACE__ . '\add_yass_social_icons_below_post_title' );
	}


	$display_left = array_key_exists('yass_field_sharing_location_floating_left', $yass_options);

	add_filter( 'the_content', __NAMESPACE__ . '\add_yass_social_icons_below_post_content' );
}

/**
 * Build the Social Sharing Icons
 *
 * @param $yass_options
 * @param $yass_size_option
 * @param $yass_color_option
 * @param $dad_list
 *
 * @return string
 */

function build_the_yass_icons() {

	//Get all the options and settings to build the buttons

	$yass_options = get_option( 'yass_options' );
	$dad_list     = get_option( 'dad_list' );

	//Color option
	if ( $yass_options['yass_field_button_colors'] === 'default' ) {
		$yass_color_option = '';
	} else {
		$yass_color_option = 'style="color: ' . $yass_options['yass_field_custom_icon_color'] . '; background-color: ' . $yass_options['yass_field_custom_background_color'] . ';"';
	}

	//Size
	if ( $yass_options['yass_field_icon_size'] === 'medium' ) {
		$yass_size_option = 'fa-2x';
	} elseif ( $yass_options['yass_field_icon_size'] === 'large' ) {
		$yass_size_option = 'fa-3x';
	} else {
		$yass_size_option = '';
	}


	$html = '<div class="yass-social-div">';

	$yass_active_array = array();

	foreach ( $dad_list as $key => $value ) {
		if ( array_key_exists( 'yass_field_active_networks_' . $key, $yass_options ) ) {
			array_push( $yass_active_array, $key );
		}
	}


	foreach ( $dad_list as $key => $value ) {

		if ( in_array( $key, $yass_active_array ) ) {

			switch ( $key ) {

				case 'fb':
					$html .= '<span class="yass-icon-default ' . $yass_size_option . ' fa fa-facebook" ' . $yass_color_option . '></span>';
					break;
				case 'tw':
					$html .= '<span class="yass-icon-default ' . $yass_size_option . ' fa fa-twitter" ' . $yass_color_option . '></span>';
					break;
				case 'go':
					$html .= '<span class="yass-icon-default ' . $yass_size_option . ' fa fa-google-plus" ' . $yass_color_option . '></span>';
					break;
				case 'pi':
					$html .= '<span class="yass-icon-default ' . $yass_size_option . ' fa fa-pinterest" ' . $yass_color_option . '></span>';
					break;
				case 'li':
					$html .= '<span class="yass-icon-default ' . $yass_size_option . ' fa fa-linkedin" ' . $yass_color_option . '></span>';
					break;
				case 'wa':
					if ( wp_is_mobile() ) {
						$html .= '<span class="yass-icon-default ' . $yass_size_option . ' fa fa-whatsapp" ' . $yass_color_option . '></span>';
					} //end wp_is_mobile
			} // end switch
		} // end if statement
	} // end foreach
	$html .= '</div>';

	return $html;
}

/** --------------------------------------------
 * Add Social Sharing icons to various locations
 * ----------------------------------------------*/

//Add social sharing to the left, fixed for all pages.
function add_yass_social_icons_floating_left() {

	echo '<div class="yass-float-left">';
	echo build_the_yass_icons();
	echo '</div>';

}

//Add social sharing to
function add_yass_social_icons_below_post_title( $content ) {

		$yass_icons = build_the_yass_icons();
		$content    = $content . $yass_icons;

	return $content;

}

//Add social sharing to
function add_yass_social_icons_inside_featured_image() {

}

//Add social sharing to
function add_yass_social_icons_below_post_content($content) {

	if ( is_single() && ( !is_home() || !is_front_page() ) ) {
		$yass_icons = build_the_yass_icons();
		$content      = $content . $yass_icons;
	}

	return $content;
}


//Add social sharing shortcode
function add_yass_social_icons_shortcode() {
	return build_the_yass_icons();
}

add_shortcode( 'yass-share', __NAMESPACE__ . '\add_yass_social_icons_shortcode');