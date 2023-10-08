=== PZ Frontend Manager ===
Contributors: Project Zealous
Tags: frontend, dashboard, admin, frontend dashboard, role
Requires at least: 6.1
Tested up to: 6.2.2
Stable tag: 1.0.5
Requires PHP: 7.4
License: GPLv2 or later
License URI: https://www.gnu.org/licenses/gpl-2.0.html

PZ Frontend Manager allows your clients to manage their platform without accessing the wp-admin dashboard.

== Description ==

PZ Frontend Manager is a free plugin that allows your clients to manage their users and posts without accessing the WordPress admin. That way, you can reduce the possibility of the error caused by accidental clicks and also reduce the confusion on your client's end to not access pages that are not necessary to their needs or capabilities.

= Key features: =

* User login and registration - Allow your visitors or site users to create their accounts by enabling your user registration in your Frontend Manager Settings. Verify their emails by enabling the account activation which will be sent to the email they have registered with.
* User Profile - Allow your users to customize their profiles. You can add more user information fields on their profile page to fill in. It also has a password field to allow your users to change their passwords anytime they want.
* Post Management - Add or manage your posts through the Frontend Manager with the same functionality as the wp-admin. Add your content and featured images and categorize your posts based on your preference. You can also create your categories and tags.
* User Management - Add or manage your user’s data including their passwords. You can add/update/remove fields based on your desired information from your users. 
* User role capability - Control what can be accessed by the users based on their user role.

== Installation ==

This section describes how to install the plugin and get it working.

e.g.

1. Upload the plugin files to the `/wp-content/plugins/` directory, or install the plugin through the WordPress plugins screen directly.
2. Activate the plugin through the 'Plugins' screen in WordPress
3. Use the Settings->Plugin Name screen to configure the plugin
4. (Make your instructions match the desired user flow for activating and installing your plugin. Include any steps that might be needed for explanatory purposes)


== Frequently Asked Questions ==

= How to activate frontend dashboard? =

After the plugin is activated, it will automatically create page for the front-end dashboard

= Can we customize the plugin? = 

Yes. There are available hooks you can use to customize your dashboard from menu to pages. There are also ready settings that you can use to update you dashboard colors, logos and accessibility. You can find our <a href="https://www.proj-z.com/snippet_cat/frontend-manager/" target="_blank">documentations</a>.

= Do I really need this plugin? =

Not necessarily, But if you want to enhance the user experience with the post and page dashboard, then this plugin is the right one for you.


== Upgrade Notice ==

= 1.0 =
Make sure you have PHP 7.4 version in yout server. 

== Changelog ==

= 1.0.5 =
- Updated user table to show user status
- Removed pending activation card in dashboard
- Updated profile fields layout
- Added pzfm_count_users filter for count users in users
- Added license card in settings for PZ plugins
- Added disable plugin feature in settings when using dashboard page to avoid conflict
- Updated alert script
- Add additional action hook for the Navigation menu
- Fixed email CSS error no ending semi colon
- Fixed error function "pzfm_billing_info_fields" not exist
- Add action hook "pzfm_after_post_row_data_{metakey}" for the posts list table

= 1.0.4 =
- Added restriction if other PZ plugins is installed before deactivating the plugin
- Fixed status label in post
- Updated active behavior in sidebar

= 1.0.3 =
- Updated button labels
- Updated miscellaneous text
- Fixed Search Filter of posts

= 1.0.2 =
- Fixed menu active class error
- Removed height in pzfm-row-actions.
- Fixed duplicate semicolon error
- Updated can_assign_role condition.
- Updated users page links
- Updated post links
- Fixed dashboard post and user url
- Fixed active class for custom menus
- Added filter hook in form section header labels

= 1.0.1 =
- Fixed error dashboard page upon activation

= 1.0.0 =
- Initial release