<?php 
/**
 * The template for displaying Author archive pages.
 *
 * Learn more: http://codex.wordpress.org/Template_Hierarchy
 */
get_header(); ?>
<?php global $invert_shortname; ?>
<div class="main-wrapper-item">
	<div class="bread-title-holder">
		<div class="bread-title-bg-image full-bg-breadimage-fixed"></div>
		<div class="container">
			<div class="row-fluid">
				<div class="container_inner clearfix">
					<h1 class="title">
						<?php  $curauth = (isset($_GET['author_name'])) ? get_user_by('slug', $author_name) : get_userdata(intval($author)); ?>
						<?php _e('Author Archives: ','invert'); echo $curauth->display_name;  ?>
					</h1>
					<?php
						if(sketch_get_option($invert_shortname."_hide_bread") == 'true') {
							if ((class_exists('invert_breadcrumb_class'))) {$invert_breadcumb->custom_breadcrumb();}
					    }
					?>
				</div>
			</div>
		</div>
	</div>

	<div class="container post-wrap"> 
		<div class="row-fluid">
			<div id="container"class="span8">
				<div id="content">
					<?php if(have_posts()) : ?>
					<?php while(have_posts()) : the_post(); ?>
					<?php get_template_part( 'content', get_post_format() ); ?>
					<?php endwhile; ?>
					<div class="navigation">	
						<?php  if (function_exists("invert_paginate") && sketch_get_option($invert_shortname.'_show_pagination')) { invert_paginate(); } else {?>			
						<div class="alignleft"><?php previous_posts_link(__('&larr;Previous','invert'),0) ?></div>		
						<div class="alignright"><?php next_posts_link(__('Next&rarr;','invert'),0) ?></div>    		
						<?php } ?>					
					</div> 
					<?php else :  ?>
					<?php get_template_part( 'content', 'none' ); ?>
					<?php endif; ?>
				</div>
				<!-- content --> 
			</div>
			<!-- container --> 
			
			<!-- Sidebar -->
			<div id="sidebar" class="span3">
				<?php get_sidebar(); ?>
			</div>
		<!-- Sidebar -->
		</div>
	</div>
</div>
<?php get_footer(); ?>