<?php

class Kopa_Widget_Flickr extends WP_Widget {

    function __construct() {
        $widget_ops = array('classname' => 'kopa_widget_flickr', 'description' => __('Display lastets flickr photos', kopa_get_domain()));
        $control_ops = array('width' => 'auto', 'height' => 'auto');
        parent::__construct('kopa_widget_flickr', __('Kopa Flickr', kopa_get_domain()), $widget_ops, $control_ops);
    }

    function widget($args, $instance) {
        extract($args);
        $title = apply_filters('widget_title', empty($instance['title']) ? '' : $instance['title'], $instance, $this->id_base);
        $account = strip_tags($instance['account']);
        $limit = (int) $instance['limit'];

        echo $before_widget;
        if (!empty($title)) {
            echo $before_title . $title . $after_title;
        }
        ?>
        <div class="flickr-wrap clearfix">       
            <input type='hidden' class='flickr_id' value='<?php echo $account; ?>'>
            <input type='hidden' class='flickr_limit' value='<?php echo $limit; ?>'>
            <ul class="kopa-flickr-widget clearfix"></ul>
        </div>
        <?php
        echo $after_widget;
    }

    function update($new_instance, $old_instance) {
        $instance = $old_instance;
        $instance['title'] = strip_tags($new_instance['title']);
        $instance['account'] = strip_tags($new_instance['account']);
        $instance['limit'] = (int) $new_instance['limit'];
        return $instance;
    }

    function form($instance) {
        $instance = wp_parse_args((array) $instance, array('title' => '', 'account' => '', 'limit' => 4));
        $title = strip_tags($instance['title']);
        $account = strip_tags($instance['account']);
        $limit = (int) $instance['limit'];
        ?>
        <p>
            <label for="<?php echo $this->get_field_id('title'); ?>"><?php _e('Title:', kopa_get_domain()); ?></label>
            <input class="widefat" id="<?php echo $this->get_field_id('title'); ?>" name="<?php echo $this->get_field_name('title'); ?>" type="text" value="<?php echo esc_attr($title); ?>" />
        </p>     
        <p>
            <label for="<?php echo $this->get_field_id('account'); ?>"><?php _e('Account:', kopa_get_domain()); ?></label>
            <input class="widefat" id="<?php echo $this->get_field_id('account'); ?>" name="<?php echo $this->get_field_name('account'); ?>" type="text" value="<?php echo esc_attr($account); ?>" />
        </p>  
        <p>
            <label for="<?php echo $this->get_field_id('limit'); ?>"><?php _e('Limit:', kopa_get_domain()); ?></label>                
            <select class="widefat" id="<?php echo $this->get_field_id('limit'); ?>" name="<?php echo $this->get_field_name('limit'); ?>" autocomplete="off">
                <?php
                $limits = array(1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 15, 20, 25, 30);
                foreach ($limits as $value) {
                    printf('<option value="%1$s" %3$s>%2$s</option>', $value, $value, ($value == $limit) ? 'selected="selected"' : '');
                }
                ?>
            </select>
        </p>
        <?php
    }

}
