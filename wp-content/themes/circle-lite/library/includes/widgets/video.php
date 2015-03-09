<?php

class Kopa_Widget_Video extends WP_Widget {

    public function __construct() {
        $widget_ops = array('classname' => 'kopa_widget_video kp-video-widget clearfix', 'description' => __('Display list of videos filter by categories (and/or) tags', kopa_get_domain()));
        $control_ops = array('width' => 'auto', 'height' => 'auto');
        parent::__construct('kopa_widget_video', __('Kopa Video', kopa_get_domain()), $widget_ops, $control_ops);
    }

    function update($new_instance, $old_instance) {
        $instance = $old_instance;
        $instance['title'] = strip_tags($new_instance['title']);
        $instance['number_of_article'] = (int) $new_instance['number_of_article'];
        $instance['orderby'] = $new_instance['orderby'];
        return $instance;
    }

    function form($instance) {
        $default = array(
            'title' => '',
            'number_of_article' => 7,
            'orderby' => 'lastest'
        );
        $instance = wp_parse_args((array) $instance, $default);

        $title = strip_tags($instance['title']);
        $form['number_of_article'] = (int) $instance['number_of_article'];
        $form['orderby'] = $instance['orderby'];
        ?>
        <p>
            <label for="<?php echo $this->get_field_id('title'); ?>"><?php _e('Title:', kopa_get_domain()); ?></label>
            <input class="widefat" id="<?php echo $this->get_field_id('title'); ?>" name="<?php echo $this->get_field_name('title'); ?>" type="text" value="<?php echo esc_attr($title); ?>" />
        </p>
        <p>
            <label for="<?php echo $this->get_field_id('number_of_article'); ?>"><?php _e('Number of article:', kopa_get_domain()); ?></label>                
            <select class="widefat" id="<?php echo $this->get_field_id('number_of_article'); ?>" name="<?php echo $this->get_field_name('number_of_article'); ?>" autocomplete="off">
                <?php
                $number_of_article = array(1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 15, 20, 25, 30);
                foreach ($number_of_article as $value) {
                    printf('<option value="%1$s" %3$s>%2$s</option>', $value, $value, ($value == $form['number_of_article']) ? 'selected="selected"' : '');
                }
                ?>
            </select>
        </p>
        <p>
            <label for="<?php echo $this->get_field_id('orderby'); ?>"><?php _e('Orderby:', kopa_get_domain()); ?></label>                
            <select class="widefat" id="<?php echo $this->get_field_id('orderby'); ?>" name="<?php echo $this->get_field_name('orderby'); ?>" autocomplete="off">
                <?php
                $orderby = array(
                    'lastest' => __('Lastest', kopa_get_domain()),
                    'popular' => __('Popular by View Count', kopa_get_domain()),
                    'most_comment' => __('Popular by Comment Count', kopa_get_domain()),
                    'random' => __('Random', kopa_get_domain()),
                );
                foreach ($orderby as $value => $title) {
                    printf('<option value="%1$s" %3$s>%2$s</option>', $value, $title, ($value === $form['orderby']) ? 'selected="selected"' : '');
                }
                ?>
            </select>
        </p>        
        <?php
    }

    function widget($args, $instance) {
        global $post;
        extract($args);
        $title = apply_filters('widget_title', empty($instance['title']) ? '' : $instance['title'], $instance, $this->id_base);
        $number_of_article = (int) $instance['number_of_article'];
        $orderby = $instance['orderby'];

        $query_args = array(
            'post_type' => array('post'),
            'posts_per_page' => $number_of_article,
            'tax_query' => array(
                array(
                    'taxonomy' => 'post_format',
                    'field' => 'slug',
                    'terms' => array('post-format-video')
                )
            )
        );

        switch ($orderby) {
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

        echo $before_widget;
        if (!empty($title)) {
            echo $before_title . $title . $after_title;
        }

        $posts = new WP_Query($query_args);

        if ($posts->post_count > 0):
            echo '<ul>';
            while ($posts->have_posts()):
                $posts->the_post();
                $videos = kopa_content_get_video($post->post_content);
                if ($videos):
                    foreach ($videos as $video):
                        echo '<li><div class="entry-thumb hover-effect">';
                        if ('disable' === get_option('kopa_theme_options_play_video_in_lightbox', 'disable')) {
                            echo do_shortcode($video['shortcode']);
                        } else {
                            ?>                                
                            <div class="mask">
                                <a class="link-detail" rel="prettyPhoto[blog-videos]" href="<?php echo $video['url']; ?>"><?php echo KopaIcon::getIcon('fa fa-play', 'i'); ?></a>
                            </div>
                            <?php
                            if (has_post_thumbnail()):
                                the_post_thumbnail('kopa-image-size-1');                            
                            endif;
                        }
                        echo '</div></li>';
                    endforeach;
                endif;
            endwhile;
            echo '</ul>';

        endif;

        wp_reset_postdata();
        echo $after_widget;
    }

}
