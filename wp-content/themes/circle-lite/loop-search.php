<?php

if(!have_posts()){
?>
<li>
    <blockquote><h2><?php _e('No items found', kopa_get_domain()); ?></h2></blockquote>
</li>
<?php
}

while (have_posts()) : the_post();
    $post_id = get_the_ID();
    $post_url = get_permalink();
    $post_title = get_the_title();
    $post_format = get_post_format();    
    ?>
    <li <?php post_class(); ?>>
        <article class="article-no-thumb clearfix"> 
            <div class="entry-content clearfix">
                <header class="entry-header">
                    <h2 class="entry-title">
                        <a href="<?php echo $post_url; ?>"><?php echo $post_title; echo ($post_format) ? " ($post_format)" : '';?></a>
                    </h2>

                    <div class="entry-meta-box">
                        <div class="entry-meta-box-inner">
                            <span class="entry-date"><?php echo KopaIcon::getIcon('fa fa-calendar-o entry-icon', 'span'); ?><?php echo get_the_date(); ?></span>
                            <span class="entry-author"><?php echo KopaIcon::getIcon('fa fa-user entry-icon', 'span'); ?><?php _e('by:', kopa_get_domain()); ?>&nbsp;<a href="<?php echo get_author_posts_url(get_the_author_meta('ID')); ?>"><?php the_author_meta('nickname'); ?></a></span>
                            <?php if (has_category()): ?>
                                <span class="entry-category"><?php echo KopaIcon::getIcon('fa fa-book entry-icon', 'span'); ?><?php _e('in:', kopa_get_domain()); ?>&nbsp;<?php the_category(', '); ?></span>
                            <?php endif; ?>
                            <span class="entry-comment"><?php echo KopaIcon::getIcon('fa fa-comment-o entry-icon', 'span'); ?><?php comments_popup_link(__('No Comment', kopa_get_domain()), __('1 Comment', kopa_get_domain()), __('% Comments', kopa_get_domain()), '', __('Comments Off', kopa_get_domain())); ?></span>                               
                        </div>
                        <span class="entry-meta-circle"></span>                        
                    </div>

                </header>
                <?php the_excerpt(); ?>
                <a class="more-link" href="<?php echo $post_url; ?>"><?php _e('Read more &raquo;' , kopa_get_domain()); ?></a>
            </div><!--entry-content-->
        </article>
    </li>
    <?php
endwhile;