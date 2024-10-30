=== Mobile Comments Signature ===
Contributors: asechrest
Tags: comments, signature, mobile, mobile browser
Requires at least: 2.7
Tested up to: 2.8
Stable tag: 1.0

This plugin detects when a comment is published from a mobile phone/browser and appends a signature to the comment.

== Description ==

The Mobile Comments Signature plugin uses an efficient script to detect comments made from a mobile browser and then appends a signature to the comment. 
The signature text is user-defined, accepts light HTML markup, and can be aligned left, center, or right. A testing mode allows the administrator to append
the signature to existing comments for live-site viewing.

Mobile Comments Signature was designed based on a request described at my site, [Blog Ingenuity](http://blogingenuity.com/ "Blog Ingenuity"), and that 
originated in a [WordPress forum thread](http://wordpress.org/support/topic/259324?replies=10/ "WordPress forum thread").

The plugin is simple, targeted, lightweight, and fully commented.

Possible plugin uses:

*	Integration into a plugin package for the mobile version of your site
*	To get a feel for the number of commenters visiting and commenting from a mobile phone/browser
*	Emails sent from a mobile phone often notify recipients of such and warn that spelling errors may occur.  Mobile Comments Signature can be used
	as similar notification for your WordPress site

An options page is included that allows a user to:

*	Define the text to be appended
*	Toggle appending the signature on/off
*	Toggle separating the signature from comment text with a horizontal line
*	Align the signature left, center, or right
*	Preview the signature on the options page with a simulated comment
*	Toggle test mode to fake a mobile browser and test the signature on actual comments

Please direct all bug or incompatibility reports to the plugin page @ [Blog Ingenuity](http://blogingenuity.com/2009/06/01/mobile-comments-signature-a-plugin/ "Blog Ingenuity").

== Installation ==

Install the plugin as follows:

1. Download the Mobile Comments Signature plugin
1. Unzip the downloaded plugin folder
1. Upload the plugin folder to `/wp-content/plugins`
1. Activate the plugin through the 'Plugins' menu in WordPress
1. Navigate to the options page (Settings -> Mobilesig) and set your preferences

== Frequently Asked Questions ==

= Will this affect other plugins that already append stuff to my comments? =

It shouldn't. I've already made a revision to specifically prevent this after discovering it on my own site.  Let me know if you still have issues.

= Does this also add a signature to posts? =

Not at this time, though the functionality is being considered.  If you're interested in it, let me know.

= Will you be internationalizing the plugin? =

If there's enough interest in the plugin in general, then yes.

== Screenshots ==

1. Mobile Comment Signature Options Page
2. Mobile Comment Signature In Action

== Changelog ==

1. 1.0:
	* Fixed a code error in initial security check
	* Fixed an error where the plugin version was not displaying properly on the plugin options page
	* Updated to version 1.0 and removed beta designation

1. 0.4:	
	* Verified compatability with WordPress 2.8
	* Updated readme to reflect latest compatibility
	* Updated main PHP file to reflect latest version compatibility
	* No functional plugin changes

1. 0.3:
	* Initial WordPress.org repository release
	* Add plugin page link to options page bio box
	* Amended readme
1. 0.2:
	* Initial Beta Release