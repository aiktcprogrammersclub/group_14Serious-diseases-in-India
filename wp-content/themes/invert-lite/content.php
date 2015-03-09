<?php
/**
 * The default template for displaying content. Used for both single and index/archive/search.
 */
?>
<div <?php post_class('post'); ?> id="post-<?php the_ID(); ?>">

	<?php if ( has_post_thumbnail() ) { // check if the post has a Post Thumbnail assigned to it. ?>
	<div class="featured-image-shadow-box">
		<?php $thumbnail = wp_get_attachment_image_src(get_post_thumbnail_id($post->ID),'invert_standard_img'); ?>
		<a href="<?php the_permalink(); ?>" class="image"><img src="<?php echo $thumbnail[0];?>" alt="<?php the_title(); ?>" class="featured-image alignnon"/></a>
	</div>
   <?php } ?>
  
	<h1 class="post-title">
		<a href="<?php the_permalink(); ?>" title="<?php the_title(); ?>">
			<?php the_title(); ?>
		</a>
	</h1>
	
	<div class="skepost-meta clearfix">
		<span class="date"><?php _e('On','invert');?> <?php the_time('F j, Y') ?></span><?php _e(',','invert');?>
		<span class="author-name"><?php _e('Posted by ','invert'); the_author_posts_link(); ?> </span><?php _e(',','invert');?>
		<?php if (has_category()) { ?><span class="category"><?php _e('In ','invert');?><?php the_category(','); ?></span><?php _e(',','invert');?><?php } ?>
		<?php the_tags('<span class="tags">By ',',','</span> ,'); ?>
		<span class="comments"><?php _e('With ','invert');?><?php comments_popup_link(__('No Comments ','invert'), __('1 Comment ','invert'), __('% Comments ','invert')) ; ?></span>
	</div>
	<!-- skepost-meta -->

	<div class="skepost">
		<?php the_excerpt(); ?> 
		<?php wp_link_pages(__('<p><strong>Pages:</strong> ','invert'), '</p>', __('number','invert')); ?>
		<div class="continue"><a href="<?php the_permalink(); ?>"><?php _e('Read More &rarr;','invert');?></a></div>		  
	</div>
	<!-- skepost -->
	
</div>
<!-- post -->