<?php

class Kopa_Widget_EiSlideshow extends WP_Widget {

    function __construct() {
        $widget_ops = array('classname' => 'ei-slider-widget', 'description' => __('Display a EiSlideshow from posts', kopa_get_domain()));
        $control_ops = array('width' => '500', 'height' => 'auto');
        parent::__construct('kopa_widget_eislideshow', __('Kopa EiSlideshow', kopa_get_domain()), $widget_ops, $control_ops);
    }

    function update($new_instance, $old_instance) {
        $instance = $old_instance;
        $instance['title'] = strip_tags($new_instance['title']);
        $instance['categories'] = (empty($new_instance['categories'])) ? array() : array_filter($new_instance['categories']);
        $instance['relation'] = $new_instance['relation'];
        $instance['tags'] = (empty($new_instance['tags'])) ? array() : array_filter($new_instance['tags']);
        $instance['number_of_article'] = $new_instance['number_of_article'];
        $instance['orderby'] = $new_instance['orderby'];

        $instance['animation'] = $new_instance['animation'];
        $instance['autoplay'] = isset($new_instance['autoplay']) ? $new_instance['autoplay'] : 'false';
        $instance['slideshow_interval'] = (int) $new_instance['slideshow_interval'];
        $instance['speed'] = (int) $new_instance['speed'];
        $instance['titlesFactor'] = floatval($new_instance['titlesFactor']);
        $instance['titlespeed'] = (int) $new_instance['titlespeed'];

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
            'animation' => 'center',
            'autoplay' => 'true',
            'slideshow_interval' => 3000,
            'speed' => 800,
            'titlesFactor' => 0.60,
            'titlespeed' => 800
        );
        $instance = wp_parse_args((array) $instance, $default);
        $title = strip_tags($instance['title']);

        $form['categories'] = $instance['categories'];
        $form['relation'] = esc_attr($instance['relation']);
        $form['tags'] = $instance['tags'];
        $form['number_of_article'] = (int) $instance['number_of_article'];
        $form['orderby'] = $instance['orderby'];

        $form['animation'] = $instance['animation'];
        $form['autoplay'] = $instance['autoplay'];
        $form['slideshow_interval'] = (int) $instance['slideshow_interval'];
        $form['speed'] = (int) $instance['speed'];
        $form['titlesFactor'] = $instance['titlesFactor'];
        $form['titlespeed'] = (int) $instance['titlespeed'];
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
                <label for="<?php echo $this->get_field_id('animation'); ?>"><?php _e('Animation:', kopa_get_domain()); ?></label>                
                <select class="widefat" id="<?php echo $this->get_field_id('animation'); ?>" name="<?php echo $this->get_field_name('animation'); ?>" autocomplete="off">
                    <?php
                    $animation = array(
                        'sides' => __('Sides', kopa_get_domain()),
                        'center' => __('Center', kopa_get_domain())
                    );

                    foreach ($animation as $value => $title) {
                        printf('<option value="%1$s" %3$s>%2$s</option>', $value, $title, ($value === $form['animation']) ? 'selected="selected"' : '');
                    }
                    ?>
                </select>
            </p>

            <p>
                <input class="" id="<?php echo $this->get_field_id('autoplay'); ?>" name="<?php echo $this->get_field_name('autoplay'); ?>" type="checkbox" value="true" <?php echo ('true' === $form['autoplay']) ? 'checked="checked"' : ''; ?> />
                <label for="<?php echo $this->get_field_id('autoplay'); ?>"><?php _e('Auto Play', kopa_get_domain()); ?></label>                                
            </p>

            <p>
                <label for="<?php echo $this->get_field_id('slideshow_interval'); ?>"><?php _e('Interval for the slideshow:', kopa_get_domain()); ?></label> 
                <input class="widefat" id="<?php echo $this->get_field_id('slideshow_interval'); ?>" name="<?php echo $this->get_field_name('slideshow_interval'); ?>" type="number" value="<?php echo $form['slideshow_interval']; ?>" />
            </p>

            <p>
                <label for="<?php echo $this->get_field_id('speed'); ?>"><?php _e('Speed for the sliding animation:', kopa_get_domain()); ?></label> 
                <input class="widefat" id="<?php echo $this->get_field_id('speed'); ?>" name="<?php echo $this->get_field_name('speed'); ?>" type="number" value="<?php echo $form['speed']; ?>" />
            </p>

            <p>
                <label for="<?php echo $this->get_field_id('titlesFactor'); ?>"><?php _e('Percentage of speed for the titles animation:', kopa_get_domain()); ?></label> 
                <input class="widefat" id="<?php echo $this->get_field_id('titlesFactor'); ?>" name="<?php echo $this->get_field_name('titlesFactor'); ?>" type="number" value="<?php echo $form['titlesFactor']; ?>" />
            </p>

            <p>
                <label for="<?php echo $this->get_field_id('titlespeed'); ?>"><?php _e('Titles animation speed:', kopa_get_domain()); ?></label> 
                <input class="widefat" id="<?php echo $this->get_field_id('titlespeed'); ?>" name="<?php echo $this->get_field_name('titlespeed'); ?>" type="number" value="<?php echo $form['titlespeed']; ?>" />
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

        $slider_args['animation'] = $instance['animation'];
        $slider_args['autoplay'] = $instance['autoplay'];
        $slider_args['slideshow_interval'] = (int) $instance['slideshow_interval'];
        $slider_args['speed'] = (int) $instance['speed'];
        $slider_args['titlesFactor'] = floatval($instance['titlesFactor']);
        $slider_args['titlespeed'] = (int) $instance['titlespeed'];

        echo $before_widget;
        if (!empty($title)) {
            echo $before_title . $title . $after_title;
        }

        $posts = kopa_widget_article_build_query($query_args);

        if ($posts->post_count > 0):
            $thumbnails = array();
            ?>
            <div class="ei-slider" <?php
            foreach ($slider_args as $class => $value) {
                printf('data-%1$s="%2$s"', $class, $value);
            }
            ?>>
                <ul class="ei-slider-large">
                    <?php
                    while ($posts->have_posts()):
                        $posts->the_post();
                        $post_id = get_the_ID();
                        $post_url = get_permalink();
                        $post_title = get_the_title();

                        if (has_post_thumbnail($post_id)):
                            $feature_image = get_post_thumbnail_id($post_id);
                            $thumbnail = wp_get_attachment_image_src($feature_image, 'kopa-image-size-1');
                            $slide = wp_get_attachment_image_src($feature_image, 'kopa-image-size-2');

                            $thumbnails[$post_id]['title'] = $post_title;
                            $thumbnails[$post_id]['url'] = $post_url;
                            $thumbnails[$post_id]['image'] = $thumbnail[0];
                            ?>
                            <li>
                                <img src="<?php echo $slide[0]; ?>" alt="<?php echo $post_title; ?>"/>
                                <div class="ei-title clearfix">
                                    <h2><a href="<?php echo $post_url; ?>"><?php echo $post_title; ?></a></h2>
                                    <?php if (has_excerpt()): ?>
                                        <h3><?php the_excerpt(); ?></h3>
                                    <?php endif; ?>
                                </div>
                            </li>         
                            <?php
                        endif;
                    endwhile;
                    ?>
                </ul>   
                <ul class="ei-slider-thumbs">
                    <li class="ei-slider-element"></li>
                        <?php foreach ($thumbnails as $thumbnail): ?>
                        <li><a href="<?php echo $thumbnail['url']; ?>"><?php echo $thumbnail['title']; ?></a><img src="<?php echo $thumbnail['image']; ?>" alt="thumb01" /></li>
                    <?php endforeach; ?>
                </ul>
            </div>
            <?php
        endif;

        wp_reset_postdata();
        echo $after_widget;
    }

}
