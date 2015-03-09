<?php 
/**
 * The main template file.
 *
 * This is the most generic template file in a WordPress theme and one of the
 * two required files for a theme (the other being style.css).
 * It is used to display a page when nothing more specific matches a query.
 * For example, it puts together the home page when no home.php file exists.
 *
 * Learn more: http://codex.wordpress.org/Template_Hierarchy
 *
 */
get_header(); ?>
<?php global $invert_shortname; ?>
<div class="main-wrapper-item">
	<div class="bread-title-holder">
		<div class="bread-title-bg-image full-bg-breadimage-fixed"></div>
		<div class="container">
			<div class="row-fluid">
				<div class="container_inner clearfix">
					<h1 class="title"><?php if(sketch_get_option($invert_shortname.'_blogpage_heading')) { echo sketch_get_option($invert_shortname.'_blogpage_heading'); } ?></h1>
				</div>
			 </div>
		</div>
	</div>

	<div class="container post-wrap">
		<div class="row-fluid">
			<div id="container" class="span8">
				<div id="content">
					<?php if(have_posts()) : ?>
					<?php /* The loop */ ?>
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
		<!-- row-fluid -->
	</div><!-- container -->

</div>
<?php get_footer(); ?>