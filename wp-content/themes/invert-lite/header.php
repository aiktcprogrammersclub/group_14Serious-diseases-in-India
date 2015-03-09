<?php
/**
 * The Header for our theme.
 */
?>
<!DOCTYPE html>
<?php 	
global $invert_shortname;	
global $invert_themename;
?>
<!--[if IE 7]>
<html class="ie ie7" <?php language_attributes(); ?>>
<![endif]-->
<!--[if IE 8]>
<html class="ie ie8" <?php language_attributes(); ?>>
<![endif]-->
<!--[if !(IE 7) | !(IE 8)  ]><!-->
<html <?php language_attributes(); ?>>
<!--<![endif]-->
<head>
<meta http-equiv="Content-Type" content="<?php bloginfo('html_type'); ?>; charset=<?php bloginfo('charset'); ?>" />
<title><?php wp_title( '|', true, 'right' ); ?></title>
<meta content="text/html; charset=utf-8" http-equiv="Content-Type" />
<meta http-equiv="X-UA-Compatible" content="IE=9" />
<link rel="pingback" href="<?php bloginfo('pingback_url'); ?>" />
<link rel="profile" href="http://gmpg.org/xfn/11" />
<?php wp_head(); ?>
</head>
<body <?php body_class(); ?> >

<div id="wrapper" class="skepage">

	<div id="header" class="skehead-headernav clearfix">
		<div class="glow">
			<div id="skehead">
				<div class="container">      
					<div class="row-fluid clearfix">  
						<!-- #logo -->
						<div id="logo" class="span3">
							<?php if(sketch_get_option($invert_shortname."_logo_img")){ ?>
							<a href="<?php echo esc_url(home_url('/')); ?>" title="<?php bloginfo('name'); ?>" ><img class="logo" src="<?php echo sketch_get_option($invert_shortname."_logo_img"); ?>" alt="<?php echo sketch_get_option($invert_shortname."_logo_alt"); ?>" /></a>
							<?php } else{ ?>
							<!-- #description -->
							<div id="site-title" class="logo_desp">
								<a href="<?php echo esc_url(home_url('/')); ?>" title="<?php bloginfo('name') ?>" ><?php bloginfo('name'); ?></a> 
								<div id="site-description"><?php bloginfo( 'description' ); ?></div>
							</div>
							<!-- #description -->
							<?php } ?>
						</div>
						<!-- #logo -->
						
						<!-- navigation-->
						<div class="top-nav-menu span9">
							<?php invert_nav(); ?>
						</div>
						<!-- #navigation --> 
					</div>
				</div>
			</div>
			<!-- #skehead -->
		</div>
		<!-- .glow --> 
	</div>
	<!-- #header -->
	
	<!-- header slider -->
	<?php if ( is_page_template('template-front-page.php') ) { ?>
	<!-- Flexslider Slider -->
	<div class="flexslider">
		<div class="post"><img alt="invert-default-slider-image" class="default-slider-image"  src="<?php if(sketch_get_option($invert_shortname.'_frontslider_stype')) { echo sketch_get_option($invert_shortname.'_frontslider_stype'); } ?>" ></div>
	</div>
	<!-- end Flexslider Slider -->
	<!-- header slider -->
	<?php } ?>
		
	
<div id="main" class="clearfix">