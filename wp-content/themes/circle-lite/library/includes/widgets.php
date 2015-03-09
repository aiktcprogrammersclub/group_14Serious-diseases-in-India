<?php

$dirs = array(
    '/library/includes/widgets/abstract/',
    '/library/includes/widgets/'
);

foreach ($dirs as $dir) {
    $path = trailingslashit(get_template_directory()) . $dir . '*.php';
    $files = glob($path);
    if ($files) {
        foreach ($files as $file) {
            require_once $file;
        }
    }
}

add_action('widgets_init', 'kopa_widgets_init');

function kopa_widgets_init() {
    $widgets = array();

    $widgets[] = 'Kopa_Widget_EiSlideshow';
    $widgets[] = 'Kopa_Widget_EiSlideshow_2';
    $widgets[] = 'Kopa_Widget_ArticleList_Carousel';
    $widgets[] = 'Kopa_Widget_ArticleList_Carousel_2';
    $widgets[] = 'Kopa_Widget_Gallery';
    $widgets[] = 'Kopa_Widget_ArticleList_Small_Thumbnail';    
    $widgets[] = 'Kopa_Widget_ArticleList_Medium_Thumbnail';
    $widgets[] = 'Kopa_Widget_Video';
    $widgets[] = 'Kopa_Widget_Flickr';
    $widgets[] = 'Kopa_Widget_Recent_Comments';    
    $widgets[] = 'Kopa_Widget_ArticleList_No_Thumbnail';
    $widgets[] = 'Kopa_Widget_Advertisement';
   

    $widgets = apply_filters('kopa_get_list_widgets', $widgets);
    if ($widgets) {
        foreach ($widgets as $widget) {
            register_widget($widget);
        }
    }
}

add_action('admin_enqueue_scripts', 'kopa_widget_admin_enqueue_scripts');

function kopa_widget_admin_enqueue_scripts($hook) {
    if ('widgets.php' === $hook) {
        $dir = get_template_directory_uri() . '/library';
        wp_enqueue_style('kopa_widget_admin', "{$dir}/css/widget.css");
        wp_enqueue_script('kopa_widget_admin', "{$dir}/js/widget.js", array('jquery'));
    }
}

function kopa_widget_article_build_query($query_args = array()) {
    $args = array(
        'post_type' => array('post'),
        'post_status' => array('publish'),
        'posts_per_page' => $query_args['number_of_article']
    );
    $tax_query = array();
    if (isset($query_args['categories']) && $query_args['categories']) {
        $tax_query[] = array(
            'taxonomy' => 'category',
            'field' => 'id',
            'terms' => $query_args['categories']
        );
    }
    if (isset($query_args['tags']) && $query_args['tags']) {
        $tax_query[] = array(
            'taxonomy' => 'post_tag',
            'field' => 'id',
            'terms' => $query_args['tags']
        );
    }
    if ($query_args['relation'] && count($tax_query) == 2)
        $tax_query['relation'] = $query_args['relation'];
    if ($tax_query) {
        $args['tax_query'] = $tax_query;
    }
    switch ($query_args['orderby']) {
        case 'popular':
            $args['meta_key'] = 'kopa_' . kopa_get_domain() . '_total_view';
            $args['orderby'] = 'meta_value_num';
            break;
        case 'most_comment':
            $args['orderby'] = 'comment_count';
            break;
        case 'random':
            $args['orderby'] = 'rand';
            break;
        default:
            $args['orderby'] = 'date';
            break;
    }
    if (isset($query_args['post__not_in']) && $query_args['post__not_in']) {
        $args['post__not_in'] = $query_args['post__not_in'];
    }
    return new WP_Query($args);
}

function kopa_widget_posttype_build_query($query_args = array()) {
    $args = array(
        'post_type' => $query_args['post_type'],
        'posts_per_page' => $query_args['posts_per_page']
    );
    $tax_query = array();
    if ($query_args['categories']) {
        $tax_query[] = array(
            'taxonomy' => $query_args['cat_name'],
            'field' => 'id',
            'terms' => $query_args['categories']
        );
    }
    if ($query_args['tags']) {
        $tax_query[] = array(
            'taxonomy' => $query_args['tag_name'],
            'field' => 'id',
            'terms' => $query_args['tags']
        );
    }
    if ($query_args['relation'] && count($tax_query) == 2)
        $tax_query['relation'] = $query_args['relation'];
    if ($tax_query) {
        $args['tax_query'] = $tax_query;
    }
    switch ($query_args['orderby']) {
        case 'popular':
            $args['meta_key'] = 'kopa_' . kopa_get_domain() . '_total_view';
            $args['orderby'] = 'meta_value_num';
            break;
        case 'most_comment':
            $args['orderby'] = 'comment_count';
            break;
        case 'random':
            $args['orderby'] = 'rand';
            break;
        default:
            $args['orderby'] = 'date';
            break;
    }
    if (isset($query_args['post__not_in']) && $query_args['post__not_in']) {
        $args['post__not_in'] = $query_args['post__not_in'];
    }
    return new WP_Query($args);
}
