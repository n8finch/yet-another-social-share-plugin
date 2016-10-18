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


//namespace YetAnotherSocialShare\Custom;

$yass_options = get_option( 'yass_options' );

//Bail out if plugin is deactivated
if ( $yass_options['yass_field_activate'] === 'activate' ) {
	add_action( 'wp_footer', __NAMESPACE__ . '\add_yass_social_icons_floating_left' );
}

function build_the_yass_icons( $yass_options, $yass_size_option, $yass_color_option, $dad_list ) {
	$html = '<div class="yass-social-div">';

	$yass_active_array = array();

	foreach ( $dad_list as $key => $value ) {
		if ( array_key_exists( 'yass_field_active_networks_' . $key, $yass_options ) ) {
			array_push($yass_active_array, $key);
		}
	}


	foreach ( $dad_list as $key => $value ) {

		if ( in_array( $key, $yass_active_array ) ) {

			switch ( $key ) {

				case 'fb':
					$html .= '<span class="yass-icon-default ' . $yass_size_option . ' fa fa-facebook" ' . $yass_color_option . '></span><br/>';
					break;
				case 'tw':
					$html .= '<span class="yass-icon-default ' . $yass_size_option . ' fa fa-twitter" ' . $yass_color_option . '></span><br/>';
					break;
				case 'go':
					$html .= '<span class="yass-icon-default ' . $yass_size_option . ' fa fa-google-plus" ' . $yass_color_option . '></span><br/>';
					break;
				case 'pi':
					$html .= '<span class="yass-icon-default ' . $yass_size_option . ' fa fa-pinterest" ' . $yass_color_option . '></span><br/>';
					break;
				case 'li':
					$html .= '<span class="yass-icon-default ' . $yass_size_option . ' fa fa-linkedin" ' . $yass_color_option . '></span><br/>';
					break;
				case 'wa':
					if ( wp_is_mobile() ) {
						$html .= '<span class="yass-icon-default ' . $yass_size_option . ' fa fa-whatsapp" ' . $yass_color_option . '></span><br/>';
					} //end wp_is_mobile
			} // end switch
		} // end if statement
	} // end foreach
	$html .= '</div>';

	return $html;
}

function add_yass_social_icons_floating_left() {

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

	echo build_the_yass_icons( $yass_options, $yass_size_option, $yass_color_option, $dad_list );

}