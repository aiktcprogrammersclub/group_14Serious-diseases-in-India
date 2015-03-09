<?php
global $post;
while (have_posts()) : the_post();
    $post_id = get_the_ID();
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

    $article_classes[] = 'clearfix';
    ?>
    <div <?php post_class(); ?>>  
        <?php
        if (!in_array($post_format, array('aside', 'gallery', 'video', 'audio', 'quote')) && has_post_thumbnail()):
            ?>
            <div class="entry-thumb">                       
                <?php the_post_thumbnail('full'); ?>
            </div>
            <?php
        endif;
        ?> 
        <header class="entry-header">
            <?php if ('aside' !== $post_format): ?>
                <h1 class="entry-title"><?php echo $post_title; ?></h1>
            <?php endif; ?>
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
                <span class="entry-meta-icon"><?php echo $post_format_icon; ?></span>
            </div>
        </header>

        <?php the_content(); ?>

        <?php
        wp_link_pages(array('before' => '<div class="pagination">', 'after' => '</div>'));
        ?>       

        <footer class="clearfix">
            <p class="prev-post">
                <?php previous_post_link('%link', __('&laquo;&nbsp;Older Article', kopa_get_domain()), true); ?>                
            </p>
            <p class="next-post">
                <?php next_post_link('%link', __('Next Article&nbsp;&raquo;', kopa_get_domain()), true); ?>                   
            </p>
        </footer>
    </div>

    <div class="socials-link-container-loop-2">
        <?php kopa_get_socials_link(); ?>
    </div>

    <?php kopa_get_about_author(); ?>

    <?php comments_template(); ?>

    <?php kopa_get_facebook_comment(); ?>

    <?php kopa_get_related_articles(); ?>
    <?php
endwhile;
?>