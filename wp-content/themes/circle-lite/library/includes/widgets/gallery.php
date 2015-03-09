<?php

class Kopa_Widget_Gallery extends Kopa_Widget_ArticleList {

    public function __construct() {
        $widget_ops = array('classname' => 'kopa_widget_articlelist_only_small_thumbnail kp-gallery-widget clearfix', 'description' => __('Display list of Gallery postype articles filtered by categories (and/or) tags', kopa_get_domain()));
        $control_ops = array('width' => 'auto', 'height' => 'auto');
        parent::__construct('kopa_widget_articlelist_only_small_thumbnail', __('Kopa Gallery Widget', kopa_get_domain()), $widget_ops, $control_ops);
    }

    public function display($query_args) {

        $posts = kopa_widget_article_build_query($query_args);
        if ($posts->post_count > 0):
            global $post;
            ?>
            <ul class="clearfix">              
                <?php
                while ($posts->have_posts()):
                    $posts->the_post();
                    $gallery = kopa_content_get_gallery($post->post_content);
                    if ($gallery) {
                        $shortcode = substr_replace($gallery[0]['shortcode'], ' display_type = 3]', strlen($gallery[0]['shortcode']) - 1, strlen($gallery[0]['shortcode']));
                        echo do_shortcode($shortcode);
                    }
                endwhile;
                ?>
            </ul>
            <?php
        endif;
        wp_reset_postdata();
    }

}
