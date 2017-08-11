=== Debug Notifier ===
Contributors: wcjcs
Donate link: https://www.paypal.com/cgi-bin/webscr?cmd=_donations&business=KABGU8JM42ANY&lc=US&item_name=WCJCS&item_number=wcjcs%2ddonation%2ddebug%2dnotifier&currency_code=USD&bn=PP%2dDonationsBF%3abtn_donateCC_LG%2egif%3aNonHosted
Tags: debug, debug notifier, notifier, notification, developer, developer tools
Requires at least: 3.4
Tested up to: 3.4
Stable tag: trunk
License: GPLv2 or later
License URI: http://www.gnu.org/licenses/gpl-2.0.html

If WP_DEBUG=true, this plugin adds a visual style that prevents admins from forgetting that debugging is enabled.  Simple, slim, handy.

== Description ==
For those developers who write clean code that produces no errors or warnings, it can be unclear whether debug mode is enabled or not.  This plugin solves that problem by adding a visual style to the front-end and back-end (optionally) so that admins can tell at-a-glance if *WP_DEBUG=true* in the *wp-config.php* file.  No more having to check the file manually.

== Installation ==
1. Upload the wcjcs-debug-notifier folder into your plugins directory.
1. Activate the plugin through the Plugins menu in WordPress.
1. To adjust plugin settings, go to *Dashboard*->*Settings*->*Debug Notifier*


== Frequently Asked Questions ==
= Can I disable the visual style from the front-end or back-end? =
Sure, just set your preference on the settings page.
= Where are the plugins' settings located? =
*Dashboard* -> *Settings* -> *Debug Notifier*
= Can I use this plugin in a production environment? =
Yes.  Only those users with 'administrator' capability (or higher) will be able to see the visual style.  Note, however, that enabling debugging in a live environment should be avoided, if possible.

== Screenshots ==
1. A one-line CSS file is enqueued to render the visual style.

== Upgrade Notice ==
= 0.1.0 =
* Initial release; no upgrade notices at this time.

== Changelog ==
= 0.1.0 =
* Initial release.