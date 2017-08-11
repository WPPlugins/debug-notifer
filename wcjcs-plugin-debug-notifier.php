<?php
/*
Plugin Name: Debug Notifier
Plugin URI: http://static.wcjcs.com/docs/wordpress/plugins/?plugin=debug-notifier
Description: Add a visual style to WordPress when debugging is enabled (ie, WP_DEBUG=true in wp-config.php).  Make it easy to see when debugging is enabled and prevent forgetting to disable it later.  Shows only to admins and can be disabled from front-end/back-end views independantly.  Simple, lightweight, unobstrusive.  For WordPress 3.4 or later.
Version: 0.1.0
Author: John Alarcon
Author URI: http://static.wcjcs.com/docs/wordpress/plugins/?plugin=debug-notifier
License: GPLv2 or later
License URI: http://www.gnu.org/licenses/gpl-2.0.html
Tags: debug, dev tools, developer tools, notification, debugger, debugging, reminder, admin reminder
Requires at least: 3.4
Tested up to: 3.4
Stable tag: trunk
*/

/*  Copyright 2012 John Alarcon (wcj@wcjcs.com)

    This program is free software; you can redistribute it and/or modify
    it under the terms of the GNU General Public License, version 2, as
    published by the Free Software Foundation.

    This program is distributed in the hope that it will be useful,
    but WITHOUT ANY WARRANTY; without even the implied warranty of
    MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
    GNU General Public License for more details.

    You should have received a copy of the GNU General Public License
    along with this program; if not, write to the Free Software
    Foundation, Inc., 51 Franklin St, Fifth Floor, Boston, MA  02110-1301  USA
*/

	// Get plugin settings from options table.
	$options = get_option('wcjcs_plugin_debug_notifier_settings');

	// Enqueue debug style on back-end views, if set on options page.
	if (isset($options['display_admin']) && !empty($options['display_admin'])) {
		if (strpos($_SERVER['REQUEST_URI'], 'wp-admin') || strpos($_SERVER['SCRIPT_URL'], 'wp-admin')) {
			add_action('admin_enqueue_scripts', 'wcjcs_plugin_debug_notifier');
		}
	}

	// Enqueue debug style on front-end views, if set on options page.
	if (isset($options['display_user'])) {
		add_action('wp_enqueue_scripts', 'wcjcs_plugin_debug_notifier');
	}

/*
 * A function to enqueue the plugin stylesheet when needed.
 */
function wcjcs_plugin_debug_notifier()
{
	// Return nothing if debugging disabled or user has insufficient privilege.
	if (!defined('WP_DEBUG') || WP_DEBUG == false || !current_user_can('administrator')) {
		return;
	}
	// Enqueue debug notification style.
	wp_enqueue_style('wcjcs-plugin-debug-notifier', plugins_url('/styles/wcjcs-plugin-debug-notifier.css', __FILE__));
}

/*
 * A function to delete plugin options upon deactivation.
 */
function prefix_on_deactivate()
{
	delete_option('wcjcs_plugin_debug_notifier_settings');
}
register_deactivation_hook(__FILE__, 'prefix_on_deactivate');

/*
 * A function to setup plugin default values in the options table.
 */
function wcjcs_plugin_debug_notifier_default_settings()
{
	// Initialization.
	$settings = array();
	// Plugin settings.
	$settings['display_user'] = (int)1;
	$settings['display_admin'] = (int)1;
	// Update options.
	update_option('wcjcs_plugin_debug_notifier_settings', $settings);
	// Bam!
	return;
}
register_activation_hook(__FILE__, 'wcjcs_plugin_debug_notifier_default_settings');

/*
 * A function to display the plugin's options on the admin side.
 */
function wcjcs_plugin_debug_notifier_display_options()
{
	global $options;

	if (!isset($options['display_user'])) {
		$options['display_user'] = '';
	}
	if (!isset($options['display_admin'])) {
		$options['display_admin'] = '';
	}
	ob_start();
	?>
	<div class="wrap">
		<h2><?php _e('Debug Notifier Options', 'wcjcs_plugin_debug_notifier');?></h2>
		<h3><?php _e('Description', 'wcjcs_plugin_debug_notifier');?></h3>
		<p><?php _e('These settings determine whether the debug highlighting appears on the front-end and the back-end of your site.  General site users will not be able to see the highlighting; it is only shown to those with at least \'administrator\' privilege.', 'wcjcs_plugin_debug_notifier');?></p>
		<form method="post" action="options.php">

		<input type="hidden" name="wcjcs_plugin_debug_notifier_settings[display_user]" value="0" />
		<input type="hidden" name="wcjcs_plugin_debug_notifier_settings[display_admin]" value="0" />

		<?php settings_fields('wcjcs_plugin_debug_notifier_settings_group'); ?>

		<h3><?php _e('Options', 'wcjcs_plugin_debug_notifier');?></h3>
		<p>
			<input type="checkbox" id="wcjcs_plugin_debug_notifier_settings[display_user]" name="wcjcs_plugin_debug_notifier_settings[display_user]" value="1" <?php echo (($options['display_user']==1)?' checked="checked"':''); ?> />
			<label="description" for="wcjcs_plugin_debug_notifier_settings[display_user]"><?php _e('Enable for front-end displays.', 'wcjcs_plugin_debug_notifier');?></label>
		</p>
		<p>
			<input type="checkbox" id="wcjcs_plugin_debug_notifier_settings[display_admin]" name="wcjcs_plugin_debug_notifier_settings[display_admin]" value="1" <?php echo (($options['display_admin']==1)?' checked="checked"':''); ?> />
			<label="description" for="wcjcs_plugin_debug_notifier_settings[display_admin]"><?php _e('Enable for back-end displays.', 'wcjcs_plugin_debug_notifier');?></label>
		</p>
		<p class="submit">
			<input class="button-primary" type="submit" name="submit" value="<?php _e('Save Options', 'wcjcs_plugin_debug_notifier');?>" /></form>
		</p>
	</div>
	<?php
	echo ob_get_clean();
}

/*
 * A function to administer plugin options at Dashboard->Settings->Debug Notifier.
 */
function wcjcs_plugin_debug_notifier_create_settings_link()
{
	add_options_page('Debug Notifier Options', 'Debug Notifier', 'administrator', 'wcjcs-debug-notifier-display-options', 'wcjcs_plugin_debug_notifier_display_options');
}
add_action('admin_menu', 'wcjcs_plugin_debug_notifier_create_settings_link');

/*
 * A function to save the plugin options.
 */
function wcjcs_plugin_debug_notifier_register_settings()
{
	register_setting('wcjcs_plugin_debug_notifier_settings_group', 'wcjcs_plugin_debug_notifier_settings');
}
add_action('admin_init', 'wcjcs_plugin_debug_notifier_register_settings');

?>