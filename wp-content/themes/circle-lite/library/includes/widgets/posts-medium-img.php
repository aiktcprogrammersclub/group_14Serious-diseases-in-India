<?php

class Kopa_Widget_ArticleList_Medium_Thumbnail extends Kopa_Widget_ArticleList {

    public function __construct() {
        $widget_ops = array('classname' => 'kopa_widget_articlelist_medium_thumbnail clearfix', 'description' => __('Display list of articles filter by categories (and/or) tags', kopa_get_domain()));
        $control_ops = array('width' => 'auto', 'height' => 'auto');
        parent::__construct('kopa_widget_articlelist_medium_thumbnail', __('Kopa Article List Medium Thumbnail', kopa_get_domain()), $widget_ops, $control_ops);
    }

    public function display($query_args) {

        $posts = kopa_widget_article_build_query($query_args);
        if ($posts->post_count > 0):
            global $post;
            ?>
            <ul>
                <?php
                while ($posts->have_posts()):
                    $posts->the_post();
                    $post_url = get_permalink();
                    $post_title = get_the_title();
                    $post_format = get_post_format();
                    $article_classes = array();

                    $post_format_icon = '';
                    switch ($post_format) {
                        case 'audio':
                            $post_format_icon = KopaIcon::getIcon('fa fa-music', 'i');
                            break;
                        case 'video':
                            $post_format_icon = KopaIcon::getIcon('fa fa-play', 'i');
                            break;
                        case 'gallery':
                            $post_format_icon = KopaIcon::getIcon('fa fa-search-plus', 'i');
                            break;
                        case 'quote':
                            $post_format_icon = KopaIcon::getIcon('fa fa-quote-left', 'i');
                            $article_classes[] = 'article-no-thumb';
                            break;
                        case 'aside':
                            $post_format_icon = KopaIcon::getIcon('fa fa-link', 'i');
                            $article_classes[] = 'article-no-thumb';
                            break;
                        default:
                            $post_format_icon = KopaIcon::getIcon('fa fa-link', 'i');
                            if (!has_post_thumbnail()) {
                                $article_classes[] = 'article-no-thumb';
                            }
                            break;
                    }
                    $article_classes[] = 'entry-item';
                    $article_classes[] = 'standard-post';
                    $article_classes[] = 'clearfix';
                    ?>
                    <li>
                        <article class="<?php echo implode(' ', $article_classes); ?>">
                            <?php
                            switch ($post_format):
                                case 'gallery':
                                    $gallery = kopa_content_get_gallery($post->post_content);
                                    if ($gallery) {
                                        echo '<div class="entry-thumb">';
                                        echo do_shortcode($gallery[0]['shortcode']);
                                        echo '</div>';
                                    }
                                    break;
                                case 'video':
                                    $video = kopa_content_get_video($post->post_content);
                                    if ($video) {
                                        echo '<div class="entry-thumb hover-effect">';
                                        if ('disable' === get_option('kopa_theme_options_play_video_in_lightbox', 'disable')) {
                                            echo do_shortcode($video[0]['shortcode']);
                                        } else {
                                            ?>                                
                                            <div class="mask">
                                                <a class="link-detail" rel="prettyPhoto[blog-videos]" href="<?php echo $video[0]['url']; ?>"><?php echo $post_format_icon; ?></a>
                                            </div>
                                            <?php
                                            if (has_post_thumbnail()):
                                                the_post_thumbnail('kopa-image-size-1');                                            
                                            endif;
                                        }
                                        echo '</div>';
                                    }
                                    break;
                                case 'audio':
                                    $audio = kopa_content_get_audio($post->post_content);
                                    if ($audio) {
                                        echo '<div class="entry-thumb hover-effect">';
                                        echo do_shortcode($audio[0]['shortcode']);
                                        echo '</div>';
                                    }
                                    break;
                                default:
                                    if (has_post_thumbnail()):
                                        ?>
                                        <div class="entry-thumb hover-effect">
                                            <div class="mask">
                                                <a class="link-detail" href="<?php echo $post_url; ?>"><?php echo KopaIcon::getIcon('fa fa-link', 'i'); ?></a>
                                            </div>
                                            <?php the_post_thumbnail('kopa-image-size-1'); ?>
                                        </div>
                                        <?php
                                    endif;
                                    break;
                            endswitch;
                            ?>                         
                            <div class="entry-content">
                                <p class="entry-meta">
                                    <span class="entry-date"><?php echo KopaIcon::getIcon('fa fa-calendar-o entry-icon', 'span'); ?><?php echo get_the_date(); ?></span>
                                    <span class="entry-comment"><?php echo KopaIcon::getIcon('fa fa-comment-o entry-icon', 'span'); ?><?php comments_popup_link(__('No Comment', kopa_get_domain()), __('1 Comment', kopa_get_domain()), __('% Comments', kopa_get_domain()), '', __('Comments Off', kopa_get_domain())); ?></span>
                                </p>
                                <h3 class="entry-title"><a href="<?php echo $post_url; ?>"><?php echo $post_title; ?></a></h3>
                                <p><?php the_excerpt(); ?></p>
                                <a href="<?php echo $post_url; ?>" class="more-link"><?php _e('Read more &raquo;', kopa_get_domain()); ?></a>
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
