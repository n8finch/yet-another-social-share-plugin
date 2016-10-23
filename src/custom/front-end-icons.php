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

if ( $yass_options['yass_field_activate'] === 'activate' ) {
	add_action( 'wp_head', __NAMESPACE__ . '\post_type_check' );
	yass_display_social_left( $yass_options );

}
function post_type_check() {

	$public_post_types = get_post_types( array( "public" => true ) );
	$yass_options      = get_option( 'yass_options' );

	foreach ( $public_post_types as $post_type ) {
		$post_type_exists = array_key_exists( 'yass_field_post_types_' . $post_type, $yass_options );
		if ( is_singular( $post_type ) && $post_type_exists ) {
			yass_display_under_title( $yass_options );
			yass_display_on_featured_image( $yass_options );
			yass_display_after_content( $yass_options );
		}
	}

}

function yass_display_social_left( $yass_options ) {
	$display_left = array_key_exists( 'yass_field_sharing_location_floating_left', $yass_options );
	if ( $display_left ) {
		add_action( 'wp_footer', __NAMESPACE__ . '\add_yass_social_icons_floating_left' );
	}
}

function yass_display_under_title( $yass_options ) {

	$display_under_title = array_key_exists( 'yass_field_sharing_location_below_post_title', $yass_options );

	if ( $display_under_title ) {
		add_filter( 'the_content', __NAMESPACE__ . '\add_yass_social_icons_below_post_title' );
	}
}

function yass_display_on_featured_image( $yass_options ) {
	$display_on_featured_image = array_key_exists( 'yass_field_sharing_location_inside_feature_image', $yass_options );

	if ( $display_on_featured_image ) {
		add_filter( 'post_thumbnail_html', __NAMESPACE__ . '\add_yass_social_icons_inside_featured_image' );
	}
}

function yass_display_after_content( $yass_options ) {
	$display_after_content = array_key_exists( 'yass_field_sharing_location_after_post_content', $yass_options );

	if ( $display_after_content ) {
		add_filter( 'the_content', __NAMESPACE__ . '\add_yass_social_icons_below_post_content' );
	}
}


/**
 * Build the Social Sharing Icons
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

			global $post;

			$post_permalink = get_permalink( $post->ID );
			$post_title = $post->ID;
			$post_attachment_url = wp_get_attachment_url( get_post_thumbnail_id( $post->ID ) );

			$fb_link = 'href="http://www.facebook.com/sharer.php?u=' . $post_permalink . '" target="_blank"';
			$tw_link = 'href="https://twitter.com/intent/tweet?url=' . $post_permalink . '" target="_blank"';
			$go_link = 'href="https://plus.google.com/share?url=' . $post_permalink . '" target="_blank"';
			$pi_link = 'data-pin-do="buttonPin" data-pin-count="above" href="https://www.pinterest.com/pin/create/button/?url=https%3A%2F%2Fakgoods.com&media=' . $post_attachment_url . '&description=Check%20this%20out!" target="_blank"';
			$li_link = 'href="https://www.linkedin.com/shareArticle?mini=true&url=' . $post_permalink . '&title=' . $post_title . '" target="_blank"';
			$wa_link = 'href="whatsapp://send?text=' . $post_permalink . '" data-action="share/whatsapp/share" target="_blank"';





			switch ( $key ) {

				case 'fb':
					$html .= '<a ' . $fb_link . '><span class="yass-icon-default ' . $yass_size_option . ' fa fa-facebook" ' . $yass_color_option . '></span></a>';
					break;
				case 'tw':
					$html .= '<a ' . $tw_link . '><span class="yass-icon-default ' . $yass_size_option . ' fa fa-twitter" ' . $yass_color_option . '></span></a>';
					break;
				case 'go':
					$html .= '<a ' . $go_link . '><span class="yass-icon-default ' . $yass_size_option . ' fa fa-google-plus" ' . $yass_color_option . '></span></a>';
					break;
				case 'pi':
					$html .= '<a ' . $pi_link . '><span class="yass-icon-default ' . $yass_size_option . ' fa fa-pinterest" ' . $yass_color_option . '></span></a>';
					break;
				case 'li':
					$html .= '<a ' . $li_link . '><span class="yass-icon-default ' . $yass_size_option . ' fa fa-linkedin" ' . $yass_color_option . '></span></a>';
					break;
				case 'wa':
					if ( wp_is_mobile() ) {
						$html .= '<a ' . $wa_link . '><span class="yass-icon-default ' . $yass_size_option . ' fa fa-whatsapp" ' . $yass_color_option . '></span></a>';
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

//Add social sharing to below post title
function add_yass_social_icons_below_post_title( $content ) {

	$yass_icons = build_the_yass_icons();
	$content    = $yass_icons . $content;

	return $content;

}

//Add social sharing to featured image
function add_yass_social_icons_inside_featured_image( $html ) {

	$post_thumbnail = $html;

	$yass_icons = '<div class="yass-featured-image-overlay">';
	$yass_icons .= $post_thumbnail;
	$yass_icons .= build_the_yass_icons();
	$yass_icons .= '</div>';

	return $yass_icons;
}

//Add social sharing to below post content
function add_yass_social_icons_below_post_content( $content ) {

	$yass_icons = build_the_yass_icons();
	$content    = $content . $yass_icons;

	return $content;
}


//Add social sharing shortcode
function add_yass_social_icons_shortcode() {
	return build_the_yass_icons();
}

add_shortcode( 'yass-share', __NAMESPACE__ . '\add_yass_social_icons_shortcode' );