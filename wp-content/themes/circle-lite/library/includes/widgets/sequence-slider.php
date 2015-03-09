<?php
class Kopa_Widget_Sequence_Slider extends WP_Widget {
    function __construct() {
        $widget_ops = array('classname' => 'sequence-slider-widget', 'description' => __('Display a Sequence Slider from posts', kopa_get_domain()));
        $control_ops = array('width' => '500', 'height' => 'auto');
        parent::__construct('kopa_widget_sequence_slider', __('Kopa Sequence Slider', kopa_get_domain()), $widget_ops, $control_ops);
    }
    function update($new_instance, $old_instance) {
        $instance = $old_instance;
        $instance['title'] = strip_tags($new_instance['title']);
        $instance['categories'] = (empty($new_instance['categories'])) ? array() : array_filter($new_instance['categories']);
        $instance['relation'] = $new_instance['relation'];
        $instance['tags'] = (empty($new_instance['tags'])) ? array() : array_filter($new_instance['tags']);
        $instance['number_of_article'] = $new_instance['number_of_article'];
        $instance['orderby'] = $new_instance['orderby'];
        $instance['autoplay'] = isset($new_instance['autoplay']) ? $new_instance['autoplay'] : 'false';
        $instance['slideshow_interval'] = (int) $new_instance['slideshow_interval'];
        return $instance;
    }
    function form($instance) {
        $default = array(
            'title' => '',
            'categories' => array(),
            'relation' => 'OR',
            'tags' => array(),
            'number_of_article' => 4,
            'orderby' => 'lastest',
            'autoplay' => 'true',
            'slideshow_interval' => 3000,
        );
        $instance = wp_parse_args((array) $instance, $default);
        $title = strip_tags($instance['title']);
        $form['categories'] = $instance['categories'];
        $form['relation'] = esc_attr($instance['relation']);
        $form['tags'] = $instance['tags'];
        $form['number_of_article'] = (int) $instance['number_of_article'];
        $form['orderby'] = $instance['orderby'];
        $form['autoplay'] = $instance['autoplay'];
        $form['slideshow_interval'] = (int) $instance['slideshow_interval'];
        ?>
        <p>
            <label for="<?php echo $this->get_field_id('title'); ?>"><?php _e('Title:', kopa_get_domain()); ?></label>
            <input class="widefat" id="<?php echo $this->get_field_id('title'); ?>" name="<?php echo $this->get_field_name('title'); ?>" type="text" value="<?php echo esc_attr($title); ?>" />
        </p>
        <div class="kopa-one-half">
            <p>
                <label for="<?php echo $this->get_field_id('categories'); ?>"><?php _e('Categories:', kopa_get_domain()); ?></label>                
                <select class="widefat" id="<?php echo $this->get_field_id('categories'); ?>" name="<?php echo $this->get_field_name('categories'); ?>[]" multiple="multiple" size="5" autocomplete="off">
                    <option value=""><?php _e('-- None --', kopa_get_domain()); ?></option>
                    <?php
                    $categories = get_categories();
                    foreach ($categories as $category) {
                        printf('<option value="%1$s" %4$s>%2$s (%3$s)</option>', $category->term_id, $category->name, $category->count, (in_array($category->term_id, (isset($form['categories']) ? $form['categories'] : array()))) ? 'selected="selected"' : '');
                    }
                    ?>
                </select>
            </p>
            <p>
                <label for="<?php echo $this->get_field_id('relation'); ?>"><?php _e('Relation:', kopa_get_domain()); ?></label>                
                <select class="widefat" id="<?php echo $this->get_field_id('relation'); ?>" name="<?php echo $this->get_field_name('relation'); ?>" autocomplete="off">
                    <?php
                    $relation = array(
                        'AND' => __('And', kopa_get_domain()),
                        'OR' => __('Or', kopa_get_domain())
                    );
                    foreach ($relation as $value => $title) {
                        printf('<option value="%1$s" %3$s>%2$s</option>', $value, $title, ($value === $form['relation']) ? 'selected="selected"' : '');
                    }
                    ?>
                </select>
            </p>
            <p>
                <label for="<?php echo $this->get_field_id('tags'); ?>"><?php _e('Tags:', kopa_get_domain()); ?></label>                
                <select class="widefat" id="<?php echo $this->get_field_id('tags'); ?>" name="<?php echo $this->get_field_name('tags'); ?>[]" multiple="multiple" size="5" autocomplete="off">
                    <option value=""><?php _e('-- None --', kopa_get_domain()); ?></option>
                    <?php
                    $tags = get_tags();
                    foreach ($tags as $tag) {
                        printf('<option value="%1$s" %4$s>%2$s (%3$s)</option>', $tag->term_id, $tag->name, $tag->count, (in_array($tag->term_id, (isset($form['tags']) ? $form['tags'] : array()))) ? 'selected="selected"' : '');
                    }
                    ?>
                </select>
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
        </div>
        <div class="kopa-one-half last">
            <p>
                <input class="" id="<?php echo $this->get_field_id('autoplay'); ?>" name="<?php echo $this->get_field_name('autoplay'); ?>" type="checkbox" value="true" <?php echo ('true' === $form['autoplay']) ? 'checked="checked"' : ''; ?> />
                <label for="<?php echo $this->get_field_id('autoplay'); ?>"><?php _e('Auto Play', kopa_get_domain()); ?></label>                                
            </p>
            <p>
                <label for="<?php echo $this->get_field_id('slideshow_interval'); ?>"><?php _e('Interval for the slideshow:', kopa_get_domain()); ?></label> 
                <input class="widefat" id="<?php echo $this->get_field_id('slideshow_interval'); ?>" name="<?php echo $this->get_field_name('slideshow_interval'); ?>" type="number" value="<?php echo $form['slideshow_interval']; ?>" />
            </p>
        </div>
        <div class="kopa-clear"></div>
        <?php
    }
    function widget($args, $instance) {
        extract($args);
        $title = apply_filters('widget_title', empty($instance['title']) ? '' : $instance['title'], $instance, $this->id_base);
        $query_args['categories'] = $instance['categories'];
        $query_args['relation'] = esc_attr($instance['relation']);
        $query_args['tags'] = $instance['tags'];
        $query_args['number_of_article'] = (int) $instance['number_of_article'];
        $query_args['orderby'] = $instance['orderby'];
        $slider_args['autoplay'] = $instance['autoplay'];
        $slider_args['slideshow_interval'] = (int) $instance['slideshow_interval'];
        echo $before_widget;
        if (!empty($title)) {
            echo $before_title . $title . $after_title;
        }
        $posts = kopa_widget_article_build_query($query_args);
        if ($posts->post_count > 0):
            $thumbnails = array();
            ?>
            <div class="sequence-wrapper">
                <div class="sequence-container">
                    <a class="prev" href="#"></a>
                    <a class="next" href="#"></a>
                    <div class="sequence-slider">
                        <div class="sequence" <?php
            foreach ($slider_args as $class => $value) {
                printf('data-%1$s="%2$s" ', $class, $value);
            }
            ?>>
                            <ul>
                                <?php
                                $title_index = 1; // index for title, subtitle & image model
                                while ($posts->have_posts()):
                                    $posts->the_post();
                                    $post_id = get_the_ID();
                                    $post_url = get_permalink();
                                    $post_title = get_the_title();
                                    if (has_post_thumbnail($post_id)):
                                        $feature_image = get_post_thumbnail_id($post_id);
                                        $thumbnail = wp_get_attachment_image_src($feature_image, 'kopa-image-size-3');
                                        $thumbnails[$post_id]['title'] = $post_title;
                                        $thumbnails[$post_id]['url'] = $post_url;
                                        $thumbnails[$post_id]['image'] = $thumbnail[0];
                                        ?>
                                        <li>
                                            <div class="title<?php echo $title_index == 1 ? '' : '-2'; ?> animate-in">
                                                <h2><?php the_title(); ?></h2>
                                            </div> <!-- .title -->
                                            <div class="subtitle<?php echo $title_index == 1 ? '' : '-2'; ?> animate-in">
                                                <h3>With a Clean &amp; Modern design</h3>
                                                <p><?php echo strip_tags(get_the_excerpt()); ?></p>
                                                <a class="more-link" href="<?php the_permalink(); ?>">
                                                    <?php _e('Read more &raquo;', kopa_get_domain()); ?>
                                                </a>
                                            </div> <!-- .subtitle -->
                                            <img class="model<?php echo $title_index == 1 ? '' : '-2-1'; ?> animate-in" src="<?php echo $thumbnail[0]; ?>" alt="<?php the_title(); ?>" />
                                        </li>
                                        <?php
                                        if ($title_index == 1)
                                            $title_index = 0;
                                        else
                                            $title_index = 1;
                                    endif;
                                endwhile;
                                ?>
                            </ul>
                        </div><!--sequence-->
                        <ul class="sequence-nav">
                            <?php
                            while ($posts->have_posts()):
                                $posts->the_post();
                                $post_id = get_the_ID();
                                if (has_post_thumbnail($post_id)):
                                    $feature_image = get_post_thumbnail_id($post_id);
                                    $thumbnail = wp_get_attachment_image_src($feature_image, 'kopa-image-size-3');
                                    ?>
                                    <li><img src="<?php echo $thumbnail[0]; ?>" alt="<?php the_title(); ?>" /></li>
                                    <?php
                                endif;
                            endwhile;
                            ?>
                        </ul>
                    </div><!--sequence-slider-->
                </div><!--sequence-container-->
            </div><!--sequence-wrapper-->
            <?php
        endif;
        wp_reset_postdata();
        echo $after_widget;
    }
}
