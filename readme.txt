=== Plugin Name ===
Contributors: brucecaldwell
Donate link: https://www.paypal.com/cgi-bin/webscr?cmd=_donations&business=6ZPC8JXLBNAMU&lc=US&item_name=Donation%20to%20the%20development%20of%20Member%20Approval&currency_code=USD&bn=PP%2dDonationsBF%3abtn_donateCC_LG%2egif%3aNonHosted
Tags: comments, spam
Requires at least: 3.2
Tested up to: 3.5.3
Stable tag: 130625
License: GPLv3 or later
License URI: http://www.gnu.org/licenses/gpl-3.0.html

Allows you to create an approval process for new Users on your site by blocking the ability to log in when a User registers until approved.

== Description ==

Works best with edited Emails through the s2Member Framework.

Allow your Users to sign up, and not be able to log in until they have been Approved by an Administrator through the Dashboard. Very simple to set up and get started with.

If you have any bug reports, please report them to my email address bruce@websharks-inc.com

== Installation ==

You can install Member Approval by downloading it through the WordPress Repository, or by uploading it to your Plugins directory via FTP.

After it's installed, activate it through your Plugins list.

== Frequently Asked Questions ==

= You said the plugin works best with the s2Member Framework. Why's that? =

s2Member® allows you to edit the emails that are sent to both the site's Admin and the User that signs up. With this ability to customize emails, you can let your Users know when they sign up that they need to wait to be Approved, and you can also be notified yourself as to when a User needs to be Approved when they signed up.

= Will this plugin work with other login forms/widgets that I have? =

Yep. Member Approval hooks directly into the WordPress core login authentication filter, so any time someone is trying to log in a User they should be given an error if the User is not Approved.

= I'm using a plugin that tracks how many time a User fails to log in correctly, will this cause issues with it? =

It shouldn't. I made sure to keep processes that run on the `wp_login_failed` hook from firing when the User is being kept from logging in because they're not activated.

= Can I edit the message that's shown to Users when they're blocked from logging in? =

Yep. There's an option for that in the Settings page for the plugin.

= Is the plugin translatable? =

Currently the only part of the plugin that displays text on the frontend of your site is the error that shows up when the User is blocked from logging in, which is fully customizable. However, the backend of the plugin is not translatable yet, I'll get to that soon. :-)

== Screenshots ==

1. Screenshot of the backend of the plugin
2. Screenshot of an example error that you might show a User that's not allowed to log in yet.
3. Screenshot of the Approval dropdown in the User Edit panel

== Changelog ==

= 130635 =
* First release of the plugin. Let me know if there are any issues with it!