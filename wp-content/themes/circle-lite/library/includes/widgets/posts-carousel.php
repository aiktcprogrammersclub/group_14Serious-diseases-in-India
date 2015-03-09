<?php

class Kopa_Widget_ArticleList_Carousel extends Kopa_Widget_ArticleList {

    public function __construct() {
        $widget_ops = array('classname' => 'featured-widget', 'description' => __('Display list of articles filter by categories (and/or) tags (carousel effect)', kopa_get_domain()));
        $control_ops = array('width' => 'auto', 'height' => 'auto');
        parent::__construct('kopa_widget_articlelist_carousel', __('Kopa Widget ArticleList Carousel', kopa_get_domain()), $widget_ops, $control_ops);
    }

    public function display($query_args) {
        $posts = kopa_widget_article_build_query($query_args);
        if ($posts->post_count > 0):
            ?>
            <div class="list-carousel responsive">
                <ul class="kopa_widget_articlelist_carousel" data-prev-id="<?php echo $this->get_field_id('prev'); ?>" data-next-id="<?php echo $this->get_field_id('next'); ?>" data-pagination-id="<?php echo $this->get_field_id('pagination'); ?>">     
                    <?php
                    while ($posts->have_posts()):
                        $posts->the_post();
                        $post_id = get_the_ID();
                        $post_url = get_permalink();
                        $post_title = get_the_title();
                        ?>
                        <li style="width: 250px;">
                            <article class="entry-item clearfix">
                                <div class="entry-thumb hover-effect">
                                    <div class="mask">
                                        <a class="link-detail" href="<?php echo $post_url; ?>"><?php echo KopaIcon::getIcon('fa fa-link', 'i'); ?></a>
                                    </div>
                                    <?php
                                    if (has_post_thumbnail()):
                                        the_post_thumbnail('kopa-image-size-1');
                                    else:
                                        printf('<img src="%1$s">', get_template_directory_uri() . '/images/kopa-image-size-1.png');
                                    endif;
                                    ?>
                                </div>
                                <div class="entry-content">
                                    <p class="entry-meta">
                                        <span class="entry-date"><?php echo KopaIcon::getIcon('fa fa-calendar-o entry-icon', 'span'); ?><?php echo get_the_date(); ?></span>
                                        <span class="entry-comment"><?php echo KopaIcon::getIcon('fa fa-comment-o entry-icon', 'span'); ?><?php comments_popup_link(__('No Comment', kopa_get_domain()), __('1 Comment', kopa_get_domain()), __('% Comments', kopa_get_domain()), '', __('Comments Off', kopa_get_domain())); ?></span>
                                    </p>
                                    <h3 class="entry-title"><a href="<?php echo $post_url; ?>"><?php echo $post_title; ?></a></h3>
                                    <a href="<?php echo $post_url; ?>" class="more-link"><?php _e('Read more &raquo;', kopa_get_domain()); ?></a>                                            
                                </div><!--entry-content-->
                            </article><!--entry-item-->
                        </li>
                        <?php
                    endwhile;
                    ?>
                </ul>
                <div class="clearfix"></div>
                <div class="carousel-nav clearfix">
                    <a id="<?php echo $this->get_field_id('prev'); ?>" class="carousel-prev" href="#">&lt;</a>
                    <a id="<?php echo $this->get_field_id('next'); ?>" class="carousel-next" href="#">&gt;</a>
                </div><!--end:carousel-nav-->
                <div id="<?php echo $this->get_field_id('pagination'); ?>" class="pagination"></div>
            </div>
            <?php
        endif;
        wp_reset_postdata();
    }

}
