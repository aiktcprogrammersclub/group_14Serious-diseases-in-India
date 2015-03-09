<?php
global $invert_themename, $invert_shortname;
/***********************************************
*  ENQUQUE CSS AND JAVASCRIPT
************************************************/
function invert_script_enqueqe() {
	global $invert_shortname;
	if(!is_admin()) {
		$themevar = wp_get_theme();
		wp_enqueue_script('invert_jquery_easing',get_template_directory_uri().'/js/jquery.easing.1.3.js',array('jquery'), $themevar->Version );
		wp_enqueue_script('invert_componentssimple_slide', get_template_directory_uri() .'/js/custom.js',array('jquery'), $themevar->Version  );
		wp_enqueue_script("comment-reply");
		wp_enqueue_script('invert_colorboxsimple_slide',get_template_directory_uri() .'/js/jquery.prettyPhoto.js',array('jquery'),true, $themevar->Version  );
		wp_enqueue_script('invert_hoverIntent', get_template_directory_uri().'/js/hoverIntent.js',array('jquery'),true, $themevar->Version  );
		wp_enqueue_script('invert_superfish', get_template_directory_uri().'/js/superfish.js',array('jquery'),true, $themevar->Version  );
		wp_enqueue_script('invert_AnimatedHeader', get_template_directory_uri().'/js/cbpAnimatedHeader.js',array('jquery'),true, $themevar->Version  );
	}    
}
add_action('wp_enqueue_scripts', 'invert_script_enqueqe');


function invert_theme_stylesheet() {
	global $invert_themename;
	global $invert_shortname;

	if ( !is_admin() ) {
		$theme = wp_get_theme();
		wp_enqueue_style( 'invert-style', get_stylesheet_uri() );
		wp_enqueue_style( 'sktcolorbox-theme-stylesheet', get_template_directory_uri().'/css/prettyPhoto.css', false, $theme->Version );
		wp_enqueue_style( 'sktawesome-theme-stylesheet', get_template_directory_uri().'/css/font-awesome.css', false, $theme->Version );
		wp_enqueue_style( 'awesome-theme-stylesheet', get_template_directory_uri().'/css/font-awesome-ie7.css', false, $theme->Version  );
		wp_enqueue_style( 'sktddsmoothmenu-superfish-stylesheet', get_template_directory_uri().'/css/superfish.css', false, $theme->Version );/*SUPERFISH*/
		wp_enqueue_style( 'portfolioStyle-theme-stylesheet', get_template_directory_uri().'/css/portfolioStyle.css', false, $theme->Version );
		wp_enqueue_style( 'bootstrap-responsive-theme-stylesheet', get_template_directory_uri().'/css/bootstrap-responsive.css', false, $theme->Version  );

		/*GOOGLE FONTS*/
		wp_enqueue_style( 'googleFontsRoboto','http://fonts.googleapis.com/css?family=Roboto+Condensed:400,400italic,300italic,300', false, $theme->Version );
		wp_enqueue_style( 'googleFontsLato','http://fonts.googleapis.com/css?family=Lato:400,700', false, $theme->Version );
	}
}

add_action('wp_enqueue_scripts', 'invert_theme_stylesheet');

function invert_head(){

	global $invert_shortname;

	$invert_favicon = "";
	$invert_meta = '<meta name="viewport" content="width=device-width; initial-scale=1.0; maximum-scale=1.0; user-scalable=0;">'."\n";

	if(sketch_get_option($invert_shortname.'_favicon')){
		$invert_favicon = sketch_get_option($invert_shortname.'_favicon','invert');
		$invert_meta .= "<link rel=\"shortcut icon\" type=\"image/x-icon\" href=\"$invert_favicon\"/>\n";
	}
	echo $invert_meta;
	
	if(!is_admin())
	{
		require_once(get_template_directory().'/includes/invert-custom-css.php');
	}
	
}
add_action('wp_head', 'invert_head');

//ENQUEUE FOOTER SCRIPT 
function invert_footer_script() {
	global $invert_shortname;
	if(invert_bg_style($invert_shortname."_bg_style") != Null){
	?>
    <style type="text/css">
		#wrapper {
		<?php echo invert_bg_style($invert_shortname."_bg_style"); ?>
		}
	</style>
    <?php
	}
	?>  
<?php 
}
add_action('wp_footer', 'invert_footer_script');