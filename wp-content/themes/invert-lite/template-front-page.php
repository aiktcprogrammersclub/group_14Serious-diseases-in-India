<?php
/*
Template Name: Home page Template
*/
?>
<?php get_header(); ?>
<?php global $invert_shortname; ?>
<!-- Featured box -->
<?php include("includes/front-mid-box.php"); ?>

<?php  $ctameta = get_post_meta( $post->ID,'_skt_calltoaction_metabox',true );
if($ctameta == '1'){ ?>
<div id="call-to-action-box" class="skt-section">
	<div class="container">
		<div class="call-to-action-block row-fluid">
			<div id="content" class="span12">
				<!-- Featured Area 2 -->
				<div class="skt-ctabox"> 
					<div class="skt-ctabox-content">
						<?php if(sketch_get_option($invert_shortname."_catoac_heading")) { ?><h2><?php echo sketch_get_option($invert_shortname."_catoac_heading"); ?></h2><?php } ?>
						<?php if(sketch_get_option($invert_shortname."_catoac_content")) { ?><p><?php echo sketch_get_option($invert_shortname."_catoac_content"); ?></p><?php } ?>
					</div>
					<?php if(sketch_get_option($invert_shortname."_catoac_txt")) { ?>
					<div class="skt-ctabox-button">
						<a href="<?php if(sketch_get_option($invert_shortname.'_catoac_link')) { echo esc_url(sketch_get_option($invert_shortname.'_catoac_link')); } ?>" class="skt-ctabox-button"><?php echo sketch_get_option($invert_shortname."_catoac_txt"); ?></a>
					</div>
					<?php } ?>
				</div>
			</div>
		</div>
	</div>
</div>
<?php } ?>

<!-- full-division-box -->
<?php  $parallaxeffectmeta = get_post_meta( $post->ID,'_skt_parallaxeffect_metabox',true );
if($parallaxeffectmeta == '1'){ ?>
<div id="full-division-box">
<div class="full-bg-image full-bg-image-fixed"></div>
	<div class="container full-content-box" >
		<div class="row-fluid">
			<div class="span12">
				<?php if(sketch_get_option($invert_shortname."_para_content_left")) { echo sketch_get_option($invert_shortname."_para_content_left");} ?>				
			</div>
		</div>
	</div>
</div>
<?php } ?>

<?php if(have_posts()) : ?>
	<?php while(have_posts()) : the_post(); ?>
		<div id="front-content-box" >
			<div class="container">
				<?php the_content(); ?>
			</div>
		</div>
	<?php endwhile; ?>
<?php endif; ?>

<!-- full-client-box -->
<?php  $clientlogometa = get_post_meta( $post->ID,'_skt_clientlogo_metabox',true );
if($clientlogometa === '1'){ ?>
<div id="full-client-box" class="skt-section">
	<div class="container">
		<div class="row-fluid">
		<?php if(sketch_get_option($invert_shortname."_clientsec_title")){?><h3 class="inline-border"><?php echo sketch_get_option($invert_shortname."_clientsec_title"); ?></h3><?php } ?>
		<span class="border_left"></span>
		<ul class="clients-items clearfix">
			<?php if(sketch_get_option($invert_shortname.'_img1_icon')){ ?><li class="span2"><a href="<?php if(sketch_get_option($invert_shortname.'_img1_link')){ echo esc_url(sketch_get_option($invert_shortname.'_img1_link','invert')); } ?>" title="<?php if(sketch_get_option($invert_shortname.'_img1_title')){ echo sketch_get_option($invert_shortname.'_img1_title','invert'); } ?>"><img alt="client-logo" src="<?php if(sketch_get_option($invert_shortname.'_img1_icon')){ echo sketch_get_option($invert_shortname.'_img1_icon','invert'); } ?>"></a></li><?php } ?>
			<?php if(sketch_get_option($invert_shortname.'_img2_icon')){ ?><li class="span2"><a href="<?php if(sketch_get_option($invert_shortname.'_img2_link')){ echo esc_url(sketch_get_option($invert_shortname.'_img2_link','invert')); } ?>" title="<?php if(sketch_get_option($invert_shortname.'_img2_title')){ echo sketch_get_option($invert_shortname.'_img2_title','invert'); } ?>"><img alt="client-logo" src="<?php if(sketch_get_option($invert_shortname.'_img2_icon')){ echo sketch_get_option($invert_shortname.'_img2_icon','invert'); } ?> "></a></li><?php } ?>
			<?php if(sketch_get_option($invert_shortname.'_img3_icon')){ ?><li class="span2"><a href="<?php if(sketch_get_option($invert_shortname.'_img3_link')){ echo esc_url(sketch_get_option($invert_shortname.'_img3_link','invert')); } ?>" title="<?php if(sketch_get_option($invert_shortname.'_img3_title')){ echo sketch_get_option($invert_shortname.'_img3_title','invert'); } ?>"><img alt="client-logo" src="<?php if(sketch_get_option($invert_shortname.'_img3_icon')){ echo sketch_get_option($invert_shortname.'_img3_icon','invert'); } ?>"></a></li><?php } ?>
			<?php if(sketch_get_option($invert_shortname.'_img4_icon')){ ?><li class="span2"><a href="<?php if(sketch_get_option($invert_shortname.'_img4_link')){ echo esc_url(sketch_get_option($invert_shortname.'_img4_link','invert')); } ?>" title="<?php if(sketch_get_option($invert_shortname.'_img4_title')){ echo sketch_get_option($invert_shortname.'_img4_title','invert'); } ?>"><img alt="client-logo" src="<?php if(sketch_get_option($invert_shortname.'_img4_icon')){ echo sketch_get_option($invert_shortname.'_img4_icon','invert'); } ?>"></a></li><?php } ?>
			<?php if(sketch_get_option($invert_shortname.'_img5_icon')){ ?><li class="span2"><a href="<?php if(sketch_get_option($invert_shortname.'_img5_link')){ echo esc_url(sketch_get_option($invert_shortname.'_img5_link','invert')); } ?>" title="<?php if(sketch_get_option($invert_shortname.'_img5_title')){ echo sketch_get_option($invert_shortname.'_img5_title','invert'); } ?>"><img alt="client-logo" src="<?php if(sketch_get_option($invert_shortname.'_img5_icon')){ echo sketch_get_option($invert_shortname.'_img5_icon','invert'); } ?>"></a></li><?php } ?>
		</ul>
		</div>
	</div>
</div>
<?php } ?>

<?php get_footer(); ?>