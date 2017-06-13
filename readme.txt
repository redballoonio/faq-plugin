=== RB Simple FAQs ===
Contributors: markredballoon, redballoondesignltd
Tags: Frequently asked questions, faqs, faq, questions and answers, customisation
Requires at least: 4.3
Tested up to: 4.8
Stable tag: 4.8
License: GPLv2 or later
License URI: http://www.gnu.org/licenses/gpl-2.0.html

A simple, lightweight plugin for managing and displaying frequently asked questions using a custom post type.

== Description ==

A simple, lightweight plugin for managing and displaying Frequently asked questions using a custom post type. The faqs are output using a shortcode and can be divided into multiple categories allowing you to manage the output of individual questions or categories across your site, output the entire list. The questions and/or categories can be collapsable, making them easier to view. The output from this plugin comes mostly unstyled, allowing for maximum customisation using css.

The background and text colours can be altered on an options page with a live preview of the output. These options accept all valid background-color css values (rgba, hex, etc.).

= Shortcode examples =

These are some examples of how to output questions using shortocodes.

Default settings: output all of the faqs divided by category (if they exist), output headings for category names:

`[faqs][/faqs]`

Output faqs for a single category, "returns". The first question is open, the rest are collapsed:

`[faqs cat="returns" show_question="first"][/faqs]`

= Shortcode options =

**FAQ categories to output**

Only show faqs from these categories. Add the slugs as a comma separated list. You can find the slug for the categories on the "FAQ Category" page in Wordpress.

`cat="[cat-slug]" (default:blank)`

**What parts should be collapsable**

Determines whether the categories and the questions are collapsable.

* none 
* question
* category
* both

`collapsable="[options]" (default:"questions")`

**Question to exclude**

If there are any faqs that you want to exclude from being output, add their IDs as a comma separated list to this attribute.

`exclude="[faq-id]" (default:blank)`


**Show or hide the category titles**

Whether to show or hide the category titles. If this is set to hide and the `cat` attribute isn't set then all of the questions and answers will be output. `collapsable="both"` or `collapsable="categories"` overwrites this option.

`title="show/hide" (default: "show)`

**Initial state of the questions**

Change the initial state of the questions when a visitor opens the page with the FAQs on. If the questions aren't collapsable then this attribute does nothing.

* "close" - all of the answers closed
* "show" - all of the answers expanded
* "first" - the first answer expanded, other answers closed

`show_question="show/close/first" (default: "close")`

**Initial state of the categories**

Change the initial state of the categories when a visitor opens the page with the FAQs on. If the categories aren't collapsable then this attribute does nothing.

* "close" - all of the categories closed
* "show" - all of the categories expanded
* "first" - the first categories expanded, other categories closed

`show_category="show/close/first" (default: "close")`

**Type of Icon**

Changes the type of icon used for collapsable elements. Effects both the categories and answers. Available options:

* "arrow"
* "plus"

`icon="[icon-type]" (default: "none")`

**Secondary icon type**

Changes the type of icon used for collapsable answers when `collapsable` is set to both. Otherwise does nothing. Available options:

* "arrow"
* "plus"

`icon_secondary="[icon-type]" (default: "none")`

= Linking directly to a question =

To link directly to a question from another page, add a "targetQuestion" get variable to the end of the url with the question id like so:

`http://yoursite.com/faq-page/?targetQuestion=21`

When following that link the correct category and question will be open and the user will be moved to the correct location on the page.

= Help us improve this plugin =

If you have any feedback or require any support using this plugin, get in touch with us by email at [support@redballoon.io](mailto:support@redballoon.io)

== Installation ==
1. Download the plugin files
1. Upload the plugin files to the `/wp-content/plugins/` directory of your site
1. Activate the plugin through the 'Plugins' menu in Wordpress
1. Add questions as custom posts in Wordpress
1. Add the `[faqs][/faqs]` shortcode where you want the questions to be output
1. Use the shortcode options to customise how the questions gets displayed

== Frequently Asked Questions ==

= Where do I change my category title? =

Change the title of the category on the FAQ Category page in Wordpress

your.website/wp-admin/edit-tags.php?taxonomy=faqs_cat&post_type=faqs

= Why are some of my questions not being output? =

If your questions aren't being output you may not have added a category to the questions. Change the `title` attribute to hide and leave the `cat` attribute blank to show all of the categories including the uncategorised options.

= Does this plugin support category hierarchy? =

This plugin doesn't support categories with a hierarchy.

= Does this plugin work on multisite? =

A previous version of this plugin is used on a multisite install, but the newer features haven't been tested on multisite.

== Screenshots ==

1. Customising the output in Wordpress

== Changelog ==

= 1.1.0 =

* Published plugin
* Added options page to Wordpress

= Earlier =

* Developed plugin
* Added categories
* Added linking to a specific question using get variable

== Upgrade Notice ==

No upgrades yet possible 