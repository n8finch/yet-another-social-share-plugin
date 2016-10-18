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
if ($yass_options['yass_field_activate'] === 'activate') {
	add_action('wp_footer', __NAMESPACE__ . '\add_yass_social_icons_floating_left');
}

function build_the_yass_icons($yass_size_option, $yass_color_option) {

	$html = '<div class="yass-social-div">
		<span class="yass-icon-default ' . $yass_size_option . ' fa fa-facebook" ' .  $yass_color_option .'></span><br/>
		<span class="yass-icon-default ' . $yass_size_option . ' fa fa-twitter" ' . $yass_color_option . '></span><br/>
		<span class="yass-icon-default ' . $yass_size_option . ' fa fa-google-plus" '. $yass_color_option .'></span><br/>
		<span class="yass-icon-default ' . $yass_size_option . ' fa fa-pinterest" '. $yass_color_option . '></span><br/>
		<span class="yass-icon-default ' . $yass_size_option . ' fa fa-linkedin" ' . $yass_color_option . '></span><br/>';
	if( wp_is_mobile()){
		$html .= '<span class="yass-icon-default ' . $yass_size_option . ' fa fa-whatsapp" '. $yass_color_option.'></span><br/>';
	} //end wp_is_mobile
	$html .= '</div>';

	return $html;
}

function add_yass_social_icons_floating_left() {

	$yass_options = get_option( 'yass_options' );

	//Color option
	if ( $yass_options['yass_field_button_colors'] === 'default') {
		$yass_color_option = '';
	} else {
		$yass_color_option = 'style="color: '.$yass_options['yass_field_custom_icon_color'].'; background-color: '.$yass_options['yass_field_custom_background_color'].';"';
	}

	//Size
	if ( $yass_options['yass_field_icon_size'] === 'medium') {
		$yass_size_option = 'fa-2x';
	} elseif ( $yass_options['yass_field_icon_size'] === 'large') {
		$yass_size_option = 'fa-3x';
	} else {
		$yass_size_option = '';
	}

	echo build_the_yass_icons($yass_size_option, $yass_color_option);

}