=== Posts from a Category Widget ===
Contributors: miyauchi
Donate link: http://wpist.me/
Tags: widget
Requires at least: 3.2
Tested up to: 3.3.1
Stable tag: 0.8.1

Display post from a selected category with post thumbnail.

== Description ==

Display post from a selected category with post thumbnail.

[This plugin maintained on GitHub.](https://github.com/miya0001/posts-in-category-widget)

= Some features: =

* Display post from a selected category with post thumbnail on sidebar widget.
* You can customize HTML output.
* You can customize default HTML template on your plugin.

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

Please contact to me.

* @miya0001 on twitter.
* http://wpist.me/ (en)
* http://firegoby.jp/ (ja)
* https://github.com/miya0001/posts-in-category-widget

= Contributors =

* [Takayuki Miyauchi](http://wpist.me/)

== Installation ==

* A plug-in installation screen is displayed on the WordPress admin panel.
* It installs it in `wp-content/plugins`.
* The plug-in is made effective.

== Changelog ==

= 0.6.0 =
* Bug fix.

= 0.4.0 =
* Bug fix.

= 0.1.0 =
* The first release.

== Credits ==

This plug-in is not guaranteed though the user of WordPress can freely use this plug-in free of charge regardless of the purpose.
The author must acknowledge the thing that the operation guarantee and the support in this plug-in use are not done at all beforehand.

== Contact ==

twitter @miya0001
