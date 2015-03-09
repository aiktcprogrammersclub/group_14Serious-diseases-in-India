<?php

class Kopa_Widget_Advertisement extends WP_Widget {

    function __construct() {
        $widget_ops = array('classname' => 'kopa_widget_adv', 'description' => __('Display Banner in sidebar', kopa_get_domain()));
        $control_ops = array('width' => '500', 'height' => '500');
        parent::__construct('kopa_widget_adv', __('Kopa Banner', kopa_get_domain()), $widget_ops, $control_ops);
    }

    function widget($args, $instance) {
        extract($args);
        $title = apply_filters('widget_title', empty($instance['title']) ? '' : $instance['title'], $instance, $this->id_base);
        $image = strip_tags($instance['image']);
        $link = strip_tags($instance['link']);
        echo $before_widget;
        if (!empty($title)) {
            echo $before_title . $title . $after_title;
        }
        ?>
        <div class="adv-300-300">
            <a href="<?php echo $link; ?>"><img alt="" src="<?php echo $image; ?>"></a>
        </div>
        <?php
        echo $after_widget;
    }

    function update($new_instance, $old_instance) {
        $instance = $old_instance;
        $instance['title'] = strip_tags($new_instance['title']);
        $instance['image'] = strip_tags($new_instance['image']);
        $instance['link'] = strip_tags($new_instance['link']);
        return $instance;
    }

    function form($instance) {
        $instance = wp_parse_args((array) $instance, array('title' => '', 'image' => '', 'link' => ''));
        $title = strip_tags($instance['title']);
        $image = strip_tags($instance['image']);
        $link = strip_tags($instance['link']);
        ?>
        <p>
            <label for="<?php echo $this->get_field_id('title'); ?>"><?php _e('Title:', kopa_get_domain()); ?></label>
            <input class="widefat" id="<?php echo $this->get_field_id('title'); ?>" name="<?php echo $this->get_field_name('title'); ?>" type="text" value="<?php echo esc_attr($title); ?>" />
        </p>  
        <div class="clearfix">
            <input class="kopa_adv_upload_image left" id="<?php echo $this->get_field_id('image'); ?>" name="<?php echo $this->get_field_name('image'); ?>" type="text" value="<?php echo esc_attr($image); ?>" />
            <button class="left btn btn-success widget_upload_image_button" alt="kopa_adv_upload_image"><?php echo KopaIcon::getIcon('fa fa-upload', 'i'); ?><?php _e('Upload', kopa_get_domain()); ?></button>
        </div>
        <p>
            <br>
            <label for="<?php echo $this->get_field_id('link'); ?>"><?php _e('URL:', kopa_get_domain()); ?></label>
            <input class="widefat" id="<?php echo $this->get_field_id('link'); ?>" name="<?php echo $this->get_field_name('link'); ?>" type="text" value="<?php echo esc_attr($link); ?>" />
        </p>  
        <?php
    }

}