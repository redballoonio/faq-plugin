=== RB FAQ Output ===
Contributors: markredballoon, redballoondesignltd
Tags: Frequently asked questions, FAQs, questions
Requires at least: 4.3
Tested up to: 4.8
Stable tag: 4.8
License: GPLv2 or later
License URI: http://www.gnu.org/licenses/gpl-2.0.html

A plugin for managing and displaying Frequently asked questions using a custom post type.

== Description ==
A plugin for managing and displaying Frequently asked questions using a custom post type. The faqs are output using a shortcode and can be divided into multiple categories. The questions and/or categories can be collapsable, making them easier to view. The output from this plugin comes mostly unstyled, allowing for maximum customisation using css.

= Shortcode examples =

Output all of the faqs. Divided by category, output headings for category names:

`[faqs][/faqs]`

Output faqs for a single category. The first question is open, the rest are collapsed:

`[faqs cat="1" show_question="first"][/faqs]`

= Shortcode options =

**FAQ categories to output**

`cat="[cat-id]" (default:blank)`


**Question to exlude**

`exclude="[faq-id]" (default:blank)`

**Show or hide the category titles**

`title="show/hide" (default: "show)`

**Initial state of the questions**

`show_question="show/hide/first" (default: "close")`

**Initial state of the categories**

`show_category="show/hide/first" (default: "close")`

**Type of Icon**

`icon="[icon-type]" (default: "none")`

== Installation ==
1. Download the plugin files
1. Upload the plugin files to the `/wp-content/plugins/` directory of your site
1. Activate the plugin through the 'Plugins' menu in Wordpress
1. Add questions as custom posts in wordpress
1. Add a category for the questions
1. Add the `[faqs][/faqs]` shortcode where you want the video to be output
1. Use the shortcode options to customise how the video gets displayed

== Frequently Asked Questions ==

= Where do I change my category title? =

Change the title of the category on this page: your.website/wp-admin/edit-tags.php?taxonomy=faqs_cat&post_type=faqs

= Why are none of my questions are being output? =

If your questions aren't being output you may not have added a category to the questions. Create a new FAQ category and asign all of the questions to it.

= Does this plugin support category higherarchy? =

This plugin doesn't support categories with a higherarchy.

== Screenshots ==

== Changelog ==

= 1.0 =

* Added video post type, Modals and controlling the videos using the youtube api

== Upgrade Notice ==

No upgrades yet possible 