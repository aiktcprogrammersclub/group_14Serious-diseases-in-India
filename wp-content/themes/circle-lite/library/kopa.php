<?php

add_action('after_setup_theme', 'kopa_after_setup_theme');

function kopa_after_setup_theme() {
    kopa_i18n();

    add_action('admin_menu', 'kopa_admin_menu');
    add_action('init', 'kopa_add_exceprt_page');
    add_filter('get_avatar', 'kopa_get_avatar');

    require trailingslashit(get_template_directory()) . '/library/classes/icon.class.php';
    require trailingslashit(get_template_directory()) . '/library/includes/widgets.php';

    if (is_admin()) {
        add_action('admin_enqueue_scripts', 'kopa_admin_register_assets', 5);
        add_action('admin_enqueue_scripts', 'kopa_theme_options_enqueue', 10);
        add_action('admin_enqueue_scripts', 'kopa_widget_enqueue', 10);
        add_action('admin_enqueue_scripts', 'kopa_edit_taxonomy_enqueue', 10);
        add_action('admin_enqueue_scripts', 'kopa_edit_post_enqueue', 10);
    }
}

function kopa_get_domain() {
    return constant('KOPA_DOMAIN');
}

function kopa_i18n() {
    load_theme_textdomain(kopa_get_domain(), get_template_directory() . '/languages');
}

function kopa_add_exceprt_page() {
    add_post_type_support('page', 'excerpt');
}

function kopa_admin_menu() {
    add_theme_page(__('Theme Options', kopa_get_domain()), __('Theme Options', kopa_get_domain()), 'edit_theme_options', 'kopa_cpanel_theme_options', 'kopa_cpanel_theme_options');
}

function kopa_cpanel_theme_options() {
    if (isset($_GET['screen'])) {
        $screen = $_GET['screen'];
        switch ($screen) {
            case 'sidebar-manager':
                include trailingslashit(get_template_directory()) . '/library/includes/cpanel/sidebar-manager.php';
                break;
            case 'layout-manager':
                include trailingslashit(get_template_directory()) . '/library/includes/cpanel/layout-manager.php';
                break;
            default:
                include trailingslashit(get_template_directory()) . '/library/includes/cpanel/theme-options.php';
                break;
        }
    } else {
        include trailingslashit(get_template_directory()) . '/library/includes/cpanel/theme-options.php';
    }
}

function kopa_admin_register_assets() {
    /*
     * --------------------------------------------------
     * LOCALIZE
     * --------------------------------------------------
     */
    wp_localize_script('jquery', 'kopa_variable', array(
        'url' => array(
            'ajax' => admin_url('admin-ajax.php')
        )
    ));
}

function kopa_theme_options_enqueue($hook) {
    if ('appearance_page_kopa_cpanel_theme_options' == $hook) {
        $dir = get_template_directory_uri() . '/library';

        wp_enqueue_style('thickbox');
        wp_enqueue_style('wp-color-picker');
        wp_enqueue_style('kopa-font-awesome', "{$dir}/css/font-awesome.css");
        wp_enqueue_style('kopa-bootstrap', "{$dir}/css/bootstrap.css");
        wp_enqueue_style('kopa-bootstrap-responsive', "{$dir}/css/bootstrap-responsive.css");
        wp_enqueue_style('kopa-style', "{$dir}/css/style.css");

        wp_enqueue_script('jquery');
        wp_enqueue_script('jquery-form');
        wp_enqueue_media();
        wp_enqueue_script('media-upload');
        wp_enqueue_script('thickbox');
        wp_enqueue_script('wp-color-picker');


        wp_enqueue_script('kopa-bootstrap', "{$dir}/js/bootstrap.js", array('jquery'), NULL, TRUE);
        wp_enqueue_script('kopa-bootstrap-tooltip', "{$dir}/js/bootstrap.tooltip.js", array('jquery'), NULL, TRUE);
        wp_enqueue_script('kopa-colorpicker', "{$dir}/js/colorpicker.js", array('jquery'), NULL, TRUE);
        wp_enqueue_script('kopa-script', "{$dir}/js/script.js", array('jquery'), NULL, TRUE);
        wp_enqueue_script('kopa-uploader', "{$dir}/js/uploader.js", array('jquery'), NULL, TRUE);
    }
}

function kopa_widget_enqueue($hook) {
    if (in_array($hook, array('widgets.php'))) {
        $dir = get_template_directory_uri() . '/library';

        wp_enqueue_style('thickbox');
        wp_enqueue_style('kopa-style', "{$dir}/css/style.css");

        wp_enqueue_script('thickbox');
        wp_enqueue_script('media-upload');

        wp_enqueue_script('kopa-bootstrap-tooltip', "{$dir}/js/bootstrap.tooltip.js", array('jquery'), NULL, TRUE);
        wp_enqueue_script('kopa-script', "{$dir}/js/script.js", array('jquery'), NULL, TRUE);
        wp_enqueue_script('kopa-uploader', "{$dir}/js/uploader.js", array('jquery'), NULL, TRUE);
    }
}

function kopa_edit_post_enqueue($hook) {
    if (in_array($hook, array('post-new.php', 'post.php'))) {
        $dir = get_template_directory_uri() . '/library';

        wp_enqueue_style('kopa-style', "{$dir}/css/style.css");

        wp_enqueue_script('kopa-bootstrap', "{$dir}/js/bootstrap.js", array('jquery'), NULL, TRUE);
        wp_enqueue_script('kopa-bootstrap-tooltip', "{$dir}/js/bootstrap.tooltip.js", array('jquery'), NULL, TRUE);
        wp_enqueue_script('kopa-script', "{$dir}/js/script.js", array('jquery'), NULL, TRUE);
    }
}

function kopa_edit_taxonomy_enqueue($hook) {
    if (in_array($hook, array('edit-tags.php'))) {
        $dir = get_template_directory_uri() . '/library';
        
        wp_enqueue_style('kopa-style', "{$dir}/css/style.css");

        wp_enqueue_script('kopa-bootstrap', "{$dir}/js/bootstrap.js", array('jquery'), NULL, TRUE);
        wp_enqueue_script('kopa-bootstrap-tooltip', "{$dir}/js/bootstrap.tooltip.js", array('jquery'), NULL, TRUE);
        wp_enqueue_script('kopa-script', "{$dir}/js/script.js", array('jquery'), NULL, TRUE);
    }
}

function kopa_log($message) {
    if (WP_DEBUG === true) {
        if (is_array($message) || is_object($message)) {
            error_log(print_r($message, true));
        } else {
            error_log($message);
        }
    }
}

function kopa_get_avatar($avatar) {
    $avatar = str_replace('"', "'", $avatar);
    return str_replace("class='", "class='author-avatar ", $avatar);
}

function kopa_get_image_src($pid = 0, $size = 'thumbnail') {
    $thumb = get_the_post_thumbnail($pid, $size);
    if (!empty($thumb)) {
        $_thumb = array();
        $regex = '#<\s*img [^\>]*src\s*=\s*(["\'])(.*?)\1#im';
        preg_match($regex, $thumb, $_thumb);
        $thumb = $_thumb[2];
    }
    return $thumb;
}
