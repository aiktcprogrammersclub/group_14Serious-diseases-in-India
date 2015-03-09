<?php

class Kopa_Widget_Recent_Comments extends WP_Widget {

    function __construct() {
        $widget_ops = array('classname' => 'kopa_widget_recent_comments', 'description' => __('Display recent comments', kopa_get_domain()));
        $control_ops = array('width' => 'auto', 'height' => 'auto');
        parent::__construct('kopa_widget_recent_comments', __('Kopa Recent Comments', kopa_get_domain()), $widget_ops, $control_ops);
    }

    function widget($args, $instance) {
        extract($args);
        $title = apply_filters('widget_title', empty($instance['title']) ? '' : $instance['title'], $instance, $this->id_base);
        $number = !empty($instance['number']) ? (int) $instance['number'] : 5;
        $limit = !empty($instance['limit']) ? (int) $instance['limit'] : 100;
        $show_avatar = $instance['show_avatar'];

        echo $before_widget;
        if (!empty($title)) {
            echo $before_title . $title . $after_title;
        }

        $comments = get_comments(array('number' => $number));

        if ($comments) {
            ?>
            <ul class="kp-latest-comment">
                <?php
                foreach ($comments as $comment):
                    $comment_content = $comment->comment_content;
                    if (strlen($comment_content) > $limit)
                        $comment_content = substr(strip_tags($comment->comment_content), 0, $limit);
                    ?>
                    <li>
                        <article class="clearfix">
                            <?php if ('true' == $show_avatar): ?>
                                <a class="entry-thumb" href="<?php echo get_permalink($comment->comment_post_ID); ?>">
                                    <?php echo get_avatar($comment->comment_author_email, 60); ?>                                
                                </a>
                            <?php endif; ?>

                            <div class="entry-content clearfix">
                                <a class="comment-name" href="<?php echo get_permalink($comment->comment_post_ID); ?>"><?php printf(__('%1$s says:', kopa_get_domain()), $comment->comment_author); ?></a>
                                <p><?php echo $comment_content; ?></p>
                            </div>
                        </article>
                    </li>
                    <?php
                endforeach;
                ?>
            </ul>
            <?php
        }

        echo $after_widget;
    }

    function update($new_instance, $old_instance) {
        $instance = $old_instance;
        $instance['title'] = strip_tags($new_instance['title']);
        $instance['number'] = (int) strip_tags($new_instance['number']);
        $instance['limit'] = (int) strip_tags($new_instance['limit']);
        $instance['show_avatar'] = isset($new_instance['show_avatar']) ? $new_instance['show_avatar'] : 'false';
        return $instance;
    }

    function form($instance) {
        $instance = wp_parse_args((array) $instance, array('title' => '', 'number' => 5, 'limit' => 100, 'show_avatar' => 'true'));
        $title = strip_tags($instance['title']);
        $number = (int) strip_tags($instance['number']);
        $limit = (int) strip_tags($instance['limit']);
        $show_avatar = $instance['show_avatar'];
        ?>
        <p>
            <label for="<?php echo $this->get_field_id('title'); ?>"><?php _e('Title:', kopa_get_domain()); ?></label>
            <input class="widefat" id="<?php echo $this->get_field_id('title'); ?>" name="<?php echo $this->get_field_name('title'); ?>" type="text" value="<?php echo esc_attr($title); ?>" />
        </p>  
        <p>
            <label for="<?php echo $this->get_field_id('number'); ?>"><?php _e('Number of comments to show:', kopa_get_domain()); ?></label>
            <input class="widefat" id="<?php echo $this->get_field_id('number'); ?>" name="<?php echo $this->get_field_name('number'); ?>" type="text" value="<?php echo esc_attr($number); ?>" />
        </p> 
        <p>
            <label for="<?php echo $this->get_field_id('limit'); ?>"><?php _e('Character limit of comment content', kopa_get_domain()); ?></label>
            <input class="widefat" id="<?php echo $this->get_field_id('limit'); ?>" name="<?php echo $this->get_field_name('limit'); ?>" type="text" value="<?php echo esc_attr($limit); ?>" />
        </p>   
        <p>
            <input class="" id="<?php echo $this->get_field_id('show_avatar'); ?>" name="<?php echo $this->get_field_name('show_avatar'); ?>" type="checkbox" value="true" <?php echo ('true' === $show_avatar) ? 'checked="checked"' : ''; ?> />
            <label for="<?php echo $this->get_field_id('show_avatar'); ?>"><?php _e('Show Avatar', kopa_get_domain()); ?></label>                                
        </p>
        <?php
    }

}
