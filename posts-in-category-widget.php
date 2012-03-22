<?php
/*
Plugin Name: Posts from a Category Widget
Author: Takayuki Miyauchi
Plugin URI: http://firegoby.theta.ne.jp/wp/posts-from-category-widget
Description: Display posts from a selected category on sidebar widget.
Version: 0.7.0
Author URI: http://firegoby.theta.ne.jp/
Domain Path: /languages
Text Domain: posts-from-category-widget
*/

class PostsFromCategoryWidget extends WP_Widget {

private $num = 5;
private $domain = 'posts-from-category-widget';

function __construct()
{
    $widget_ops = array(
        'description' => __(
            'Display Posts from a selected category.',
            $this->domain
        )
    );
    $control_ops = array('width' => 400);
    parent::__construct(
        false,
        __('Category', $this->domain),
        $widget_ops,
        $control_ops
    );
}

public function form($instance) {
    if (isset($instance['title']) && strlen($instance['title'])) {
        $tvalue = esc_attr($instance['title']);
    } else {
        $tvalue = '';
    }
    echo '<p>';
    echo __("Title:", $this->domain);
    echo "<br />";
    $tfield = $this->get_field_id('title');
    $tname = $this->get_field_name('title');
    printf(
        '<input type="text" name="%s" id="%s" value="%s" style="width:100%%" />',
        $tname,
        $tfield,
        $tvalue
    );
    echo '</p>';

    if (isset($instance['category']) && intval($instance['category'])) {
        $category = $instance['category'];
    } else {
        $category = '';
    }
    $pfield = $this->get_field_id('category');
    $pfname = $this->get_field_name('category');
    $cats = get_categories();
    echo '<p>';
    echo __("Category:", $this->domain);
    echo "<br />";
    echo "<select class=\"widefat\" id=\"{$pfield}\" name=\"{$pfname}\">";
    $op = '<option value="%s"%s>%s</option>';
    printf($op, '', '', '');
    foreach ($cats as $c) {
        if ($category === $c->term_id) {
            printf($op, $c->term_id, ' selected="selected"', $c->name);
        } else {
            printf($op, $c->term_id, '', $c->name);
        }
    }
    echo "</select>";
    echo '</p>';

    $sizes = get_intermediate_image_sizes();
    if (isset($instance['size']) && $instance['size']) {
        $size = $instance['size'];
    } else {
        $size = '';
    }
    $sfield = $this->get_field_id('size');
    $sfname = $this->get_field_name('size');
    echo '<p>';
    echo __('Image size:', $this->domain);
    echo '<br />';
    echo "<select class=\"widefat\" id=\"{$sfield}\" name=\"{$sfname}\">";
    printf($op, '', '', '');
    foreach ($sizes as $s) {
        if ($s === $size) {
            printf($op, esc_attr($s), ' selected="selected"', esc_attr($s));
        } else {
            printf($op, esc_attr($s), '', esc_attr($s));
        }
    }
    echo "</select>";
    echo '</p>';

    $nvalue = $this->num;
    if (isset($instance['num']) && intval($instance['num'])) {
        if ($instance['num']) {
            $nvalue = $instance['num'];
        }
    }
    $nfield = $this->get_field_id('num');
    $nfname = $this->get_field_name('num');
    echo '<p>';
    echo __('Number of posts:', $this->domain);
    echo '<br />';
    printf(
        '<input type="text" name="%s" id="%s" value="%s" size="3" />',
        $nfname,
        $nfield,
        $nvalue
    );
    echo '</p>';

    if (isset($instance['tpl']) && $instance['tpl']) {
        $tpl_value = $instance['tpl'];
    } else {
        $tpl_value = $this->template();
    }
    $tpl_field = $this->get_field_id('tpl');
    $tpl_fname = $this->get_field_name('tpl');
    echo '<label for="'.$tpl_field.'">';
    echo __("Template:", $this->domain);
    echo '</label><br />';
    printf(
        '<textarea class="%s" rows="%s" cols="%s" id="%s" name="%s">%s</textarea>',
        'widefat',
        16,
        20,
        $tpl_field,
        $tpl_fname,
        esc_html($tpl_value)
    );

    $tags = array(
        "%post_title%",
        "%post_date%",
        "%post_url%",
        "%post_thumb%",
        "%post_excerpt%",
        "%class%",
    );

    echo '<div style="margin:5px 0;">';
    echo '<code>'.join("</code>, <code>", $tags).'</code>';
    echo '</div>';
}

public function update($new_instance, $old_instance) {
    // processes widget options to be saved
    return $new_instance;
}

public function widget($args, $instance) {
    if (isset($instance['category']) && intval($instance['category'])) {
        $cat = $instance['category'];
    } else {
        return;
    }
    if (isset($instance['size']) && $instance['size']) {
        $size = $instance['size'];
    } else {
        $size = null;
    }
    if (isset($instance['num']) && intval($instance['num'])) {
        $num = $instance['num']; 
    } else {
        $num = $this->num;
    }
    if (isset($instance['title']) && strlen($instance['num'])) {
        $catname = esc_html($instance['title']);
    } else {
        $catname = esc_html(get_cat_name($cat));
    }
    if (isset($instance['tpl']) && $instance['tpl']) {
        $tpl = $instance['tpl'];
    } else {
        $tpl = $this->template();
    }

    $params = array(
        "post_type"      => "post",
        "posts_per_page" => $num,
        "cat"            => $cat,
        "post_status"    => 'publish',
        "orderby"        => 'date',
        "order"          => "DESC",
    );

    echo $args['before_widget'];
    echo $args['before_title'];
    echo $catname;
    echo $args['after_title'];
    echo '<div class="post-cat-widget">';

    $class = array(
        'category-'.$cat,
        'post'
    );
    if ($size) {
        $class[] = 'size-'.$size;
    }

    query_posts($params);
    if (have_posts()){
        $i = 0;
        while (have_posts()){
            the_post();
            $oe = ($i % 2) ? 'even' : 'odd';
            $post_id   = get_the_id();
            $post_date = get_the_time(get_option('date_format'));
            $post_url  = get_permalink();
            $post_title = get_the_title();
            $post_excerpt = get_the_excerpt();
            if ($size) {
                $post_thumb = get_the_post_thumbnail($post_id, $size);
            } else {
                $post_thumb = '';
            }
            $html = $tpl;
            $html = str_replace('%post_title%', esc_html($post_title), $html);
            $html = str_replace('%post_date%', esc_html($post_date), $html);
            $html = str_replace('%post_url%', esc_url($post_url), $html);
            $html = str_replace('%post_thumb%', $post_thumb, $html);
            $html = str_replace('%post_excerpt%', esc_html($post_excerpt), $html);
            $html = str_replace('%class%', join(' ', $class).' '.$oe, $html);
            echo $html;
            $i = $i + 1;
        }
    }
    wp_reset_query();

    echo '</div>';
    echo $args['after_widget'];
}

private function template()
{
    $html = '<div class="%class%">';
    $html .= '<div class="post-thumb"><a href="%post_url%">%post_thumb%</a></div>';
    $html .= '<div class="post-content">';
    $html .= '<h3 class="post-title">';
    $html .= '<a href="%post_url%">%post_title%</a>';
    $html .= '</h3>';
    $html .= '<div class="post-date">%post_date%</div>';
    $html .= '</div>';
    $html .= '</div>';
    return apply_filters("posts-from-category-widget-template", $html);
}
}

class PostsInCategoryWidgetInit {

function __construct()
{
    add_action('widgets_init', array(&$this, "widgets_init"));
    add_action("plugins_loaded", array(&$this, "plugins_loaded"));
    add_action("wp_head", array(&$this, "wp_head"));
}

public function wp_head()
{
    $url = WP_PLUGIN_URL.'/'.dirname(plugin_basename(__FILE__)).'/style.css';
    printf(
        '<link rel="stylesheet" type="text/css" media="all" href="%s" />'."\n",
        apply_filters("posts-from-category-widget-stylesheet", $url)
    );
}

public function widgets_init()
{
    return register_widget("PostsFromCategoryWidget");
}

public function plugins_loaded()
{
    load_plugin_textdomain(
        "posts-from-category-widget",
        false,
        dirname(plugin_basename(__FILE__)).'/languages'
    );
}

}

new PostsInCategoryWidgetInit();

?>
