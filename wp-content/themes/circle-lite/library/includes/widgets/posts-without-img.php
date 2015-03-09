<?php
class Kopa_Widget_ArticleList_No_Thumbnail extends Kopa_Widget_ArticleList {
    function __construct() {
        $widget_ops = array('classname' => 'kopa_widget_blog', 'description' => __('Display list of articles filter by categories (and/or) tags ', kopa_get_domain()));
        $control_ops = array('width' => 'auto', 'height' => 'auto');
        parent::__construct('kopa_widget_blog', __('Kopa Article List No Thumbnail', kopa_get_domain()), $widget_ops, $control_ops);
    }
    function widget($args, $instance) {
        extract($args);
        $title = apply_filters('widget_title', empty($instance['title']) ? '' : $instance['title'], $instance, $this->id_base);
        $query_args['categories'] = $instance['categories'];
        $query_args['relation'] = esc_attr($instance['relation']);
        $query_args['tags'] = $instance['tags'];
        $query_args['number_of_article'] = (int) $instance['number_of_article'];
        $query_args['orderby'] = $instance['orderby'];
        $posts = kopa_widget_article_build_query($query_args);
        if ($posts->post_count <= 0)
            return;
        echo $before_widget;
        if (!empty($title))
            echo $before_title . $title . $after_title;
        ?>            
        <?php while ($posts->have_posts()) : $posts->the_post(); ?>
            <article class="entry-item clearfix">
                <div class="entry-date">
                    <p><?php the_time('j'); ?></p>
                    <strong><?php the_time('M'); ?></strong>
                </div>
                <div class="entry-content">
                    <h3 class="entry-title"><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h3>
                    <p class="entry-meta">
                        <span class="entry-category"><?php echo KopaIcon::getIcon('fa fa-book entry-icon', 'span'); ?>In: <?php the_category(', '); ?></span>
                        <span class="entry-comment"><?php echo KopaIcon::getIcon('fa fa-comment-o entry-icon', 'span'); ?><a href="<?php comments_link(); ?>"><?php comments_number(__('No comments', kopa_get_domain()), '1', '%'); ?></a></span>
                    </p>
                    <p><?php echo strip_tags(get_the_excerpt()); ?></p>
                    <a href="<?php the_permalink(); ?>" class="more-link"><?php _e('Read more &raquo;', kopa_get_domain()); ?></a>
                </div>
            </article>    
        <?php endwhile; ?>
        <?php
        echo $after_widget;
    }
}
