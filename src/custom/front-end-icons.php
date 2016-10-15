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

/**
 * Define icon variables
 */

$facebook_icon = '';
$twitter_icon = '';
$google_icon = '';
$pinterest_icon = '';
$linkedin_icon = '';
$whatsapp_icon = '';




add_action('wp_footer', __NAMESPACE__ . '\add_yass_social_icons_to_front_end');

function add_yass_social_icons_to_front_end() {

	?>

	<div class="yass-social-div">
		<span class="yass-icon-default fa fa-facebook"></span><br/>
		<span class="yass-icon-default fa fa-twitter"></span><br/>
		<span class="yass-icon-default fa fa-google-plus"></span><br/>
		<span class="yass-icon-default fa fa-pinterest"></span><br/>
		<span class="yass-icon-default fa fa-linkedin"></span><br/>
		<span class="yass-icon-default fa fa-whatsapp"></span><br/>

	</div>

	<?php
}