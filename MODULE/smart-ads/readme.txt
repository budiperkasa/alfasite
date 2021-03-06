=== Plugin Name ===
Contributors: johnkolbert
Donate link: http://www.johnkolbert.com
Tags: ads, advertisements, insert, adsense
Requires at least: 2.5
Tested up to: 2.8
Stable tag: 2.2

This plugin allows you to intelligently insert ads (like Adsense) before and after your post content based on post wordcount, post date, or other features.

== Description ==

Smart Ads automatically inserts advertisements like Google's Adsense above and below your post content. These advertisements are only visible when viewing a single post (single.php or page.php). Since it doesn't make sense to fill small posts with ads, users can set a "Wordcount" minimum for their advertisements. Smart Ads will only insert advertisements into posts that meet or exceed the desired Wordcount. Also, to ensure that new content remains fresh, users can choose to only place ads on posts that are over a certain amount of days old. Advertisements can be manually disabled on a post-by-post basis while writing a post, by category, or for registered blog members.

Users can also insert custom ads into their posts or pages by using the Smart Ads shortcode. Just enter [smartads] anywhere in your post or pages to display your custom ad. Custom ads are not affected by the Wordcount or date minimum requirements and can be toggled to show on the index page or only shown when in single post view.

== Installation ==

Upload the plugin folder containing both files to wp-content/plugins/ and activate from the Plugin administrative menu.

Upgrade:

If you�re upgrading from 1.x to 2.x you will notice a significant change. Smart Ads no longer uses the external yourads.php file. You can now directly enter your advertising code into the Smart Ads options page. After you upgrade you will be directed to navigate to the Smart Ads options page and update your options.

Smart Ads will attempt to insert your advertising code from yourads.php into their respective text boxes for you. However, you must press update for it to save it to the database. Until you do so your ads will not be displayed.

== Frequently Asked Questions ==

Please see the plugins homepage for an up-to-date FAQ.

== Changelog ==

= 2.2 =
* fixed an error where posts with ads disabled become re-enabled randomly

= 2.1 =
* fixed a PHP error that affected the settings page before any Ad code was input
* bug fixes for 2.8 compatability

= 2.0 =
* fixed bugs for WP 2.7
* allows you to enter advertising code directly into options page
* introduced the SmartAds shortcode
* many bug fixes included

= 1.2 =
* added ability to hide top ad if post begins with an image
* added an additional custom ad notation
* revamped the �write post� options box and provided a way of hiding it

= 1.1.2 =
* fixed critical error with Smart Ads interfering with RSS content

= 1.1.1 =
* added ability to disable ads for all registered users 
* added ability to exclude ads for entire categories

= 1.0.1 =
* Initial release
