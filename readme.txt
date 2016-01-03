=== Posts from a Category Widget ===
Contributors: miyauchi, tkc49
Donate link: http://wpist.me/
Tags: widget
Requires at least: 3.4
Tested up to: 4.4
Stable tag: 1.2.0

Displays post from a selected category with post thumbnail.

== Description ==

Displays post from a selected category with post thumbnail.

[This plugin is maintained on GitHub.](https://github.com/miya0001/posts-in-category-widget)

= Some features: =

* Displays post from a selected category with post thumbnail on sidebar widget.
* You can customize HTML output.
* You can customize default HTML template in your plugin.

= filter hooks example =

Filter for default template.

`<?php
    add_filter("posts-in-category-widget-template", "my_template");
    function my_template($template) {
        return '<div class="%class%"><a href="%post_url%">%post_thumb%</a></div>';
    }
?>`

Filter for stylesheet URI.

`<?php
    add_filter("posts-in-category-widget-stylesheet", "my_style");
    function my_style($url) {
        return 'http://example.com/path/to/style.css';
    }
?>`

= Translators =

* Japanese(ja) - [Takayuki Miyauchi](http://firegoby.theta.ne.jp/)

Please contact me.

* @miya0001 on twitter.
* http://wpist.me/ (en)
* http://firegoby.jp/ (ja)
* https://github.com/miya0001/posts-in-category-widget

= Contributors =

* [Takayuki Miyauchi](http://wpist.me/)
* [Hosoya Takashi](http://ht79.info/)

== Installation ==

* A plugin installation screen is displayed on the WordPress admin panel.
* It installs it in `wp-content/plugins`.
* The plugin is made effective.

== Changelog ==

= 1.1.1 =
* Tested up to 1.1.1.

= 1.0.1 =
* https://github.com/miya0001/posts-in-category-widget/compare/6526d94bb17129414ca675e047daf447ced1c4a4...1.0.1

= 0.9.1 =
* use wp_enqueue_style() for load css
* shortcode supoort

= 0.6.0 =
* Bug fix.

= 0.4.0 =
* Bug fix.

= 0.1.0 =
* The first release.

== Credits ==

This plugin is not guaranteed though the user of WordPress can freely use this plugin free of charge regardless of the purpose.
The author must acknowledge the thing that the operation guarantee and the support in this plugin use are not done at all beforehand.

== Contact ==

twitter @miya0001
