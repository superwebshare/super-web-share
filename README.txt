=== Plugin Name ===
Contributors: superwebshare
Donate link: https://www.superwebshare.com
Tags: share button, web share, native share, Share API, share
Requires at least: 3.0.1
Tested up to: 5.9
Stable tag: trunk
License: GPLv2 or later
License URI: http://www.gnu.org/licenses/gpl-2.0.html

Super Web Share helps to easily add native share prompt to your website for easy page/post sharing in less than a minute.

== Description ==

Super Web Share is a WordPress-based native share plugin that helps users easily share the page/post with others by prompting the native share action. As SuperWebShare only shows the apps installed within the device upon the share prompt, the rate of sharing of post/page will be higher. Due to that reason, website developers can skip the usage of other social media icons upon their website and keep the share more prominent. 

The Super Web Share plugin for WordPress helps increase your traffic and engagement by a single quick click to share the website with your friends and social media. Super Web Share works on all supported browsers like Chrome for Android, Edge for Android, Brave for Android, and Opera for Android. It will show the native apps installed upon the device once you share the article with others; due to that, users can easily share the page/post with others super easily in just a click. Upon the native share, which prompts up, they can easily copy the website page link if the users need it.

It takes less than a minute to set up Super Web Share, and we provide a clean uninstall by removing the entire data entry it creates. We also won't save any settings to your database until you manually save the settings. We also provide a fallback native popup if the Native Web Share is not supported within the browser.

Currently, the Super Web Share plugin provides a share button before and after the post/page content and a floating share button where you can set the color, the text of the share buttons, the position of the floating button, and can also set the pages or posts which you would like to show the share buttons via our Settings page, to easily add the share feature to your websites. As an addon, we are fully compatible with the AMP plugin, which means you can add the native share to your AMP pages provided by the AMP plugin.

### Advantages of using Super Web Share
* Increase the rate of sharing of pages and posts by users
* Developers / Bloggers can easily skip the number of social icons to be used on the page or post
* Lightweight and super fast loading share plugin
* Fully AMP supported native share plugin

#### Want to test to know how SuperWebShare works on a website? 

* Open [SuperWebShare.com](https://superwebshare.com/?utm_source=wordpress-plugin&utm_medium=wordpress-readme) in a supported device. See [FAQ to know the supported browsers](https://wordpress.org/plugins/super-web-share/#faq)
* You can see a floating button at the right bottom corner
* Tap on it, instantly you can see the native Web Share prompt with the applications, which you can share the page.
* Tap on the icon of application from the prompt, and send.
* If the website is not supporting Native share option, you will notice the fallback popup which we created to make a all in one Share plugin for your website

#### Requirments for working SuperWebShare?
* The Website should be served fully via a secured origin, i.e., the green padlock should be there on the address for working Super Web Share. Else by default, our fallback popup will show on those browsers.

== Installation ==

* Visit WordPress Admin Dashboard > Plugins > Add New
* Search for 'Super Web Share.'
* Click "Install now" and then "Activate" Super Web Share

Install manually:
1. Upload `super-web-share.zip` zip file to the `/wp-content/plugins/` directory
2. Go to WordPress admin > Plugins
2. Activate Super Web Share plugin from the Plugins list

== Customize Super Web Share ==
You can easily customize the color, position, and pages you would like to show the button before and after the page or post content and the floating share button. To customize goto Super Web Share from the admin dashboard.

== Frequently Asked Questions ==

= Which all browsers do the Super Web Share plugin works? =

The Web Share plugin works on browsers like Chrome for Android, iOS Safari (from version 12.2), Samsung Internet for Android (version 9.2+), Edge for Android, Brave for Android, Opera for Android, Google Chrome 89 or later on Chrome OS and Windows and Safari 12 or later on macOS and iOS.

= Will the floating share button and normal button on page and post will show upon non-supported browsers? =

No, the floating share button and normal share button on pages and posts will be hidden automatically if the browser won't support Web Share API.

= How do I report bugs and new feature suggestions? =

You can report the bugs and features you need at our [GitHub repository](https://github.com/superwebshare/featurerequests/issues) 

= How can I contribute to this awesome plugin? =

You can contribute to this Web Share plugin via our [GitHub repository](https://github.com/superwebshare/featurerequests/issues) 

= Did I need to register or signup anywhere to use Super Web Share plugin? =

No, super web share is super easy to set up for anyone to create a native share on their websites without any registration needed. If the browser supports the API, it will do the magic prompt over those browsers. 

= Is SuperWebShare plugin GDPR Compliant? =

Yes, SuperWebShare is fully GDPR Compliant. Unlike other social sharing tools, this share plugin does not use any cookies, tracking scripts, or store any user data.

== Screenshots ==

1. Settings page in WordPress Admin > Super Web Share
2. Native Share prompt on Google Chrome for Android browser, when Share button is tapped

== Changelog ==

= 2.0 =
Release Date: January 8th, 2022

Enhancements:

* Introducing the Fallback feature so that the fallback prompt with the copy link option will be shown if the Share API does not support the browser. You can find out the settings within Super Web Share > Fallback page.

Bugfixes:

* Fixed floating button not showing as round shape within the AMP pages
* Made the plugin lightweight

= 1.4.5 =
Release Date: March 16th, 2021

Enhancements:

* Goodbye jQuery! We're now using JavaScript code, and our small JavaScript file will be loaded once the website gets fully loaded.

Bugfixes:

* Fixed floating button not showing at the left of the page
* Style on AMP pages reduced to load the share more faster


= 1.4.4 =
Release Date: January 19th, 2020

Enhancements:

* Now we're supporting AMP pages
* AMP settings options added to dashboard for enabling native web share button over AMP pages for before and after post content
* AMP settings options added to floating button settings

= 1.4.3 =
Release Date: December 28th, 2019

Bugfixes:

* Fixed a compatibility issue over PHP versions - 5.3, 5.4, 5.5 and 5.6
(Thanks to Gijo)


= 1.4.2 =
Release Date: December 21st, 2019

Enhancements:

* Loading scripts on AMP pages fixed
* Introducing admin notices for better user experience
* Minor improvements over the overall code to load faster

Bugfixes:

* Fixed a php error if none of the tab's value is received to the variable


= 1.4.1 =
Release Date: December 1st, 2019

Enhancements:

* Settings page improved
* SVG icon for share both share buttons - Thanks to Ajith
* Floating share button style changed
* General share button style changed for good user experience


= 1.4 =
Release Date: November 19th, 2019

Enhancements:

* WordPress 5.3 support
* Settings link corrected


= 1.3.1 =
Release Date: April 19th, 2019

Enhancements:

* Normal Share Button default value set to disabled, once plugin is activated

= 1.3 =
Release Date: April 19th, 2019

Enhancements:

* Introducing tab option to select General settings and Floating settings
* Status option to check whether the website will support SuperWebShare
* Adds Submenu for eay navigation
* Improves the coding structure for future features

Bugfixes:

* Fixes an issue where non-secure loading of Twitter share widget within the Admin dashboard to secured

= 1.2 =
Release Date: March 8th, 2019

Enhancements:

* Adds share button to prompt native share over above and below of the post/page content
* Option to select the color, text on the share button added
* Adds option's to select the pages to display the normal share button
* Minor performance improvements to render SuperWebShare faster.
Thanks to Jyothis for reporting the bug.

= 1.1 =
Release Date: December 15th, 2018

Enhancements:

* Adds option to select color via color picker for floating share button
* Adds option's to select pages to display the floating button
* Adds option's to select the position of Floating Share Button (Left/Right)


= 1.0 =
Release Date: October 31st, 2018
Inital Release

Enhancements:

* Initial release with Floating Share Button
* Option to change color of button from Settings page