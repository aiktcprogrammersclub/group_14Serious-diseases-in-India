<?php

class Kopa_Widget_ArticleList_Small_Thumbnail extends Kopa_Widget_ArticleList {

    public function __construct() {
        $widget_ops = array('classname' => 'kopa_widget_articlelist_small_thumbnail clearfix', 'description' => __('Display list of articles filter by categories (and/or) tags', kopa_get_domain()));
        $control_ops = array('width' => 'auto', 'height' => 'auto');
        parent::__construct('kopa_widget_articlelist_small_thumbnail', __('Kopa Article List Small Thumbnail', kopa_get_domain()), $widget_ops, $control_ops);
    }

    public function display($query_args) {
        $posts = kopa_widget_article_build_query($query_args);
        if ($posts->post_count > 0):
            ?>
            <ul class="kp-popular-post">                        
                <?php
                while ($posts->have_posts()):
                    $posts->the_post();
                    $post_url = get_permalink();
                    $post_title = get_the_title();
                    ?>
                    <li>
                        <article class="clearfix">
                            <?php if (has_post_thumbnail()): ?>
                                <a href="<?php echo $post_url; ?>" class="entry-thumb"><?php the_post_thumbnail('kopa-image-size-0'); ?></a>
                            <?php endif; ?>
                            <div class="entry-content">
                                <h4 class="entry-title"><a href="<?php echo $post_url; ?>"><?php echo $post_title; ?></a></h4>
                                <span class="entry-date"><?php echo KopaIcon::getIcon('fa fa-calendar-o entry-icon', 'span'); ?><?php echo get_the_date(); ?></span>
                                <span class="entry-comment"><?php echo KopaIcon::getIcon('fa fa-comment-o entry-icon', 'span'); ?><?php comments_popup_link(__('0 Comments', kopa_get_domain()), __('1 Comment', kopa_get_domain()), __('% Comments', kopa_get_domain()), '', __('Comments Off', kopa_get_domain())); ?></span>
                            </div>
                        </article>
                    </li>       
                    <?php
                endwhile;
                ?>
            </ul>
            <?php
        endif;
        wp_reset_postdata();
    }

}
