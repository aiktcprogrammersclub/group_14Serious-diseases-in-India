<?php
/**
 * A unique identifier is defined to store the options in the database and reference them from the theme.
 * By default it uses the theme name, in lowercase and without spaces, but this can be changed if needed.
 * If the identifier changes, it'll appear as if the options have been reset.
 */

function optionsframework_option_name() {
	global $invert_shortname;
	global $invert_themename;

	// This gets the theme name from the stylesheet
	$invert_themename = get_option( 'stylesheet' );
	$invert_themename = preg_replace("/\W/", "_", strtolower($invert_themename) );
	$optionsframework_settings = get_option( 'optionsframework' );
	$optionsframework_settings['id'] = $invert_themename;
	update_option( 'optionsframework', $optionsframework_settings );
}

/**
 * Defines an array of options that will be used to generate the settings page and be saved in the database.
 * When creating the 'id' fields, make sure to use all lowercase and no spaces.
 *
 * If you are making your theme translatable, you should replace 'invert'
 * with the actual text domain for your theme.  Read more:
 * http://codex.wordpress.org/Function_Reference/load_theme_textdomain
 */

function optionsframework_options() {
	global $invert_shortname;
	global $invert_themename;

	// Background Defaults
	$background_style = array(
		'color' => '',
		'image' => '',
		'repeat' => 'repeat',
		'position' => 'top center',
		'attachment'=>'scroll' );
		
	$bread_type = array(
		'brimage' => __('Image', 'invert'),
		'brcolor' => __('Color', 'invert')
	);
	
	// pagination
	$test_pagiarray = array(
		1 => __('Yes', 'invert'),
		0 => __('No', 'invert')
	);

		//breadcumhide_array
	$breadcumhide_array = array(
		'true' => __('Enable', 'invert'),
		'false' => __('Disable', 'invert')
	);
	
	// Pull all the categories into an array
	$options_categories = array();
	$options_categories_obj = get_categories();
	foreach ($options_categories_obj as $category) {
		$options_categories[$category->cat_ID] = $category->cat_name;
	}



	// Pull all tags into an array
	$options_tags = array();
	$options_tags_obj = get_tags();
	foreach ( $options_tags_obj as $tag ) {
		$options_tags[$tag->term_id] = $tag->name;
	}

	// Pull all the pages into an array
	$options_pages = array();
	$options_pages_obj = get_pages('sort_column=post_parent,menu_order');
	$options_pages[''] = 'Select a page:';
	foreach ($options_pages_obj as $page) {
		$options_pages[$page->ID] = $page->post_title;
	}

	// set pages
	$options_pages = array();
	$options_pages_obj = get_pages('sort_column=post_parent,menu_order');
	$options_pages[''] = 'Select a page:';
	foreach ($options_pages_obj as $page) {
		$options_pages[$page->ID] = $page->post_title;
	}

	// If using image radio buttons, define a directory path
	$imagepath =  get_template_directory_uri() . '/images/';
	$options = array();

	//General Settings
	$options[] = array(
		'name' => __('General Settings', 'invert'),
		'type' => 'heading');

		$options[] = array(
			'name' => __('Theme Color:', 'invert'),
			'desc' => __('Choose theme color.', 'invert'),
			'id' => $invert_shortname.'_colorpicker',
			'std' => '#D83B2D',
			'type' => 'color' );
			
		$options[] = array(
			'name' => __('Custom Logo :', 'invert'),
			'desc' => __('Choose your own logo for your site. Size: Width 120px and Height 40px.', 'invert'),
			'id' => $invert_shortname.'_logo_img',
			'std' => '',
			'type' => 'upload');

		$options[] = array(
			'name' => __('Logo Alt Text :', 'invert'),
			'desc' => __('Enter alternate text for logo.', 'invert'),
			'id' => $invert_shortname.'_logo_alt',
			'std' => '',
			'type' => 'text');
			
		$options[] = array(
			'name' => __('Custom favicon :', 'invert'),
			'desc' => __('Choose a custom favicon for your site. Size: Width:16px and Height:16px.', 'invert'),
			'id' => $invert_shortname.'_favicon',
			'std' => '',
			'type' => 'upload');
			
		$options[] = array(
			'name' => __('Header Background Color:', 'invert'),
			'desc' => __('Choose header background color.', 'invert'),
			'id' => $invert_shortname.'_headercolorpicker',
			'std' => '#ffffff',
			'type' => 'color' );

		$options[] = array(
			'name' => __('Navigation Font Color:', 'invert'),
			'desc' => __('Choose navigation font color.', 'invert'),
			'id' => $invert_shortname.'_navfontcolorpicker',
			'std' => '#333333',
			'type' => 'color' );

	   $options[] = array(
			'name' => __('Custom Pagination:', 'invert'),
			'desc' => __('Choose enable to show custom pagination on blog page.', 'invert'),
			'id' => $invert_shortname.'_show_pagination',
			'std' => 'yes',
			'type' => 'select',
			'class' => 'small', //mini, tiny, small
			'options' => $test_pagiarray);


	   //Bg style
	   $options[] = array(
				'name' =>  __('Custom Background:', 'invert'),
				'desc' => __('Change the background CSS.', 'invert'),
				'id' => $invert_shortname.'_bg_style',
				'std' => $background_style,
				'type' => 'background' );
	
	//Breadcrumb	
	$options[] = array(
		'name' => __('Breadcrumb Settings', 'invert'),
		'type' => 'heading');

	$options[] = array(
			'name' => __('Breadcrumb Enable/Disable:', 'invert'),
			'desc' => __('Radio select with default options "Enable".', 'invert'),
			'id' => $invert_shortname.'_hide_bread',
			'std' => 'true',
			'type' => 'radio',
			'options' => $breadcumhide_array);

	$options[] = array(
			'name' => __('Breadcrumb Background Type', 'invert'),
			'desc' => __('Default ( image ).', 'invert'),
			'id' => $invert_shortname.'_bread_stype',
			'std' => 'brimage',
			'type' => 'radio',
			'options' => $bread_type);

    $options[] = array(
			'name' => __('Choose Page Title & Breadcrumb Background Color', 'invert'),
			'desc' => __('No color selected by default.', 'invert'),
			'id' => $invert_shortname.'_bread_color',
			'std' => '#F2F2F2',
			'type' => 'color',
			'class'=>'hidden' );

    $options[] = array(
			'name' => __('Upload Page Title & Breadcrumb Background Image (size: 1600px width and 450px height)', 'invert'),
			'desc' => __('This creates a full size uploader that previews the image.', 'invert'),
			'id' => $invert_shortname.'_bread_image',
			'std' => $imagepath.'danbo_green.jpg',
			'type' => 'upload',
			'class'=>'hidden');


	$options[] = array(
			'name' => __('Choose Page Title & Breadcrumb Color', 'invert'),
			'desc' => __('No color selected by default.', 'invert'),
			'id' => $invert_shortname.'_bread_title_color',
			'std' => '#222222',
			'type' => 'color' );
		
	//Blog	
	$options[] = array(
		'name' => __('Blog Page Title', 'invert'),
		'type' => 'heading');
	
	//Blog page Title
	$options[] = array(
			'name' => __('Blog page Title:', 'invert'),
			'desc' => __('Enter blog page title.', 'invert'),
			'id' => $invert_shortname.'_blogpage_heading',
			'std' => 'Blog',
			'type' => 'text');
			

	//Front Page Options	
	$options[] = array(
			'name' => __('Home Featured Image', 'invert'),
			'type' => 'heading');
		
		$options[] = array(
			'name' => __('Home page Image:', 'invert'),
			'desc' => __('Choose image for home page. Size: Width 1583px and Height 716px.', 'invert'),
			'id' => $invert_shortname.'_frontslider_stype',
			'std' => $imagepath.'invert.jpg',
			'type' => 'upload');
			
		//call-to-action-block
	 $options[] = array(
			'name' => __('Home Featured Box', 'invert'),
			'type' => 'heading');
			
		//Featured Box 1
		$options[] = array(
			'name' => __('First Featured Box Heading:', 'invert'),
			'desc' => __('Enter first featured box heading.', 'invert'),
			'id' => $invert_shortname.'_fb1_first_part_heading',
			'std' => 'Business Strategy',
			'type' => 'text');

		$options[] = array(
			'name' => __('First Featured Box Image:', 'invert'),
			'desc' => __('Choose image for first featured box. Size: Width 150px and Height 150px.', 'invert'),
			'id' => $invert_shortname.'_fb1_first_part_image',
			'std' => '',
			'type' => 'upload');

		 $options[] = array(
			'name' => __('First Featured Box Content:', 'invert'),
			'desc' => __('Enter content for first featured box.','invert'),
			'id' => $invert_shortname.'_fb1_first_part_content',
			'std' => ' Get focused from your target consumers and increase your business with Web portal Design and Development. ',
			'type' => 'textarea');

		$options[] = array(
			'name' => __('First Featured Box Link:', 'invert'),
			'desc' => __('Enter link for first featured box.', 'invert'),
			'id' => $invert_shortname.'_fb1_first_part_link',
			'std' => '#',
			'type' => 'text');


		//Featured Box 2
		$options[] = array(
			'name' => __('Second Featured Box Heading:', 'invert'),
			'desc' => __('Enter second featured box heading.', 'invert'),
			'id' => $invert_shortname.'_fb2_second_part_heading',
			'std' => 'Quality Products',
			'type' => 'text');

		$options[] = array(
			'name' => __('Second Featured Box Image:', 'invert'),
			'desc' => __('Choose image for second featured box. Size: Width 150px and Height 150px.', 'invert'),
			'id' => $invert_shortname.'_fb2_second_part_image',
			'std' => '',
			'type' => 'upload');

	    $options[] = array(
			'name' => __('Second Featured Box Content:', 'invert'),
			'desc' => __('Enter content for second featured box.','invert'),
			'id' => $invert_shortname.'_fb2_second_part_content',
			'std' => ' Products with the ultimate features and functionality that provide the complete satisfaction to the clients.',
			'type' => 'textarea');

	    $options[] = array(
			'name' => __('Second Featured Box Link:', 'invert'),
			'desc' => __('Enter link for second featured box.', 'invert'),
			'id' => $invert_shortname.'_fb2_second_part_link',
			'std' => '#',
			'type' => 'text');

	//Featured Box 3
		$options[] = array(
			'name' => __('Third Featured Box Heading:', 'invert'),
			'desc' => __('Enter third featured box heading.', 'invert'),
			'id' => $invert_shortname.'_fb3_third_part_heading',
			'std' => 'Best Business Plans',
			'type' => 'text');

		$options[] = array(
			'name' => __('Third Featured Box Image', 'invert'),
			'desc' => __('Choose image for third featured box. Size: Width 150px and Height 150px.', 'invert'),
			'id' => $invert_shortname.'_fb3_third_part_image',
			'std' => '',
			'type' => 'upload');

	 	$options[] = array(
			'name' => __('Third Featured Box Content:', 'invert'),
			'desc' => __('Enter content for third featured box.','invert'),
			'id' => $invert_shortname.'_fb3_third_part_content',
			'std' => ' Based on the client requirement, different business plans suits and fulfill your business and cost requirement.',
			'type' => 'textarea');

		$options[] = array(
			'name' => __('Third Featured Box Link:', 'invert'),
			'desc' => __('Enter link for third featured box.', 'invert'),
			'id' => $invert_shortname.'_fb3_third_part_link',
			'std' => '#',
			'type' => 'text');

				
		//call-to-action-block
	 $options[] = array(
			'name' => __('Home Call to Action', 'invert'),
			'type' => 'heading');
			
		$options[] = array(
			'name' => __('Call to Action Box Heading:', 'invert'),
			'desc' => __('Enter Call to Action Box Heading.', 'invert'),
			'id' => $invert_shortname.'_catoac_heading',
			'std' => 'Join The Ultimate And Irreplaceable Experience Now.',
			'type' => 'text');

		$options[] = array(
			'name' => __('Call to Action Box Content:', 'invert'),
			'desc' => __('Enter Call to Action Box Content.','invert'),
			'id' => $invert_shortname.'_catoac_content',
			'std' => 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Donec consequat malesuada urna, non fringilla purus malesuada eget.',
			'type' => 'textarea');

		$options[] = array(
			'name' => __('Call to Action Button Text:', 'invert'),
			'desc' => __('Enter call to action button text.', 'invert'),
			'id' => $invert_shortname.'_catoac_txt',
			'std' => 'Sign-Up Now',
			'type' => 'text');

		$options[] = array(
			'name' => __('Call to Action Button Link:', 'invert'),
			'desc' => __('Enter call to action button Link.', 'invert'),
			'id' => $invert_shortname.'_catoac_link',
			'std' => '#',
			'type' => 'text');

	$options[] = array(
		'name' => __('Home Parallax Section', 'invert'),
		'type' => 'heading');
		
		$options[] = array(
			'name' => __('Upload Your Image for Parallax ', 'invert'),
			'desc' => __('Choose image for front page slider. Size: Width 1600px and Height 800px.', 'invert'),
			'id' => $invert_shortname.'_fullparallax_image',
			'std' => $imagepath.'PArallax_Vimeo_bg.jpg',
			'type' => 'upload');

		$options[] = array(
			'name' => __('Content Box with Parallax Effect Section:', 'invert'),
			'desc' => __('Enter box content.','invert'),
			'id' => $invert_shortname.'_para_content_left',
			'std' => '<div style="color:#222">Lorem ipsum dolor sit amet, consectetur adipiscing elit. Donec consequat malesuada urna, non fringilla purus malesuada eget.Lorem ipsum dolor sit amet, consectetur adipiscing elit. Donec consequat malesuada urna, non fringilla purus malesuada eget.Lorem ipsum dolor sit amet, consectetur adipiscing elit. Donec consequat malesuada urna, non fringilla purus malesuada eget.Lorem ipsum dolor sit amet, consectetur adipiscing elit. Donec consequat malesuada urna, non fringilla purus malesuada eget.Lorem ipsum dolor sit amet, consectetur adipiscing elit. Donec consequat malesuada urna, non fringilla purus malesuada eget.Lorem ipsum dolor sit amet, consectetur adipiscing elit. Donec consequat malesuada urna, non fringilla purus malesuada eget.Lorem ipsum dolor sit amet, consectetur adipiscing elit. Donec consequat malesuada urna, non fringilla purus malesuada eget.Lorem ipsum dolor sit amet, consectetur adipiscing elit. Donec consequat malesuada urna, non fringilla purus malesuada eget.Lorem ipsum dolor sit amet, consectetur adipiscing elit. Donec consequat malesuada urna, non fringilla purus malesuada eget.Lorem ipsum dolor sit amet, consectetur adipiscing elit. Donec consequat malesuada urna, non fringilla purus malesuada eget.Lorem ipsum dolor sit amet, consectetur adipiscing elit. Donec consequat malesuada urna, non fringilla purus malesuada eget.Lorem ipsum dolor sit amet, consectetur adipiscing elit. Donec consequat malesuada urna, non fringilla purus malesuada eget.</div>',
			'type' => 'textarea');

		// Client
	$options[] = array(
		'name' => __('Home Client Logo Section', 'invert'),
		'type' => 'heading');
		
		$options[] = array(
			'name' => __('Client Section Title:', 'invert'),
			'desc' => __('Enter client section title.', 'invert'),
			'id' => $invert_shortname.'_clientsec_title',
			'std' => 'Our Partners',
			'type' => 'text');

		$options[] = array(
			'name' => __('First Client Logo Image Title:', 'invert'),
			'desc' => __('Enter first client logo image title.', 'invert'),
			'id' => $invert_shortname.'_img1_title',
			'std' => '',
			'type' => 'text');

		$options[] = array(
			'name' => __('First Client Logo Image:', 'invert'),
			'desc' => __('Choose image for first client logo area. Size: Width 232px and Height 101px.', 'invert'),
			'id' => $invert_shortname.'_img1_icon',
			'std' => $imagepath.'Sample_Client_Logo.png',
			'type' => 'upload');

		$options[] = array(
			'name' => __('First Client Logo Image Link:', 'invert'),
			'desc' => __('Enter link for first client logo.', 'invert'),
			'id' => $invert_shortname.'_img1_link',
			'std' => '#',
			'type' => 'text');

		$options[] = array(
			'name' => __('Second Client logo Image Title:', 'invert'),
			'desc' => __('Enter second client logo image title.', 'invert'),
			'id' => $invert_shortname.'_img2_title',
			'std' => '',
			'type' => 'text');

		$options[] = array(
			'name' => __('Second Client Logo Image:', 'invert'),
			'desc' => __('Choose image for second client logo area. Size: Width 232px and Height 101px.', 'invert'),
			'id' => $invert_shortname.'_img2_icon',
			'std' => $imagepath.'Sample_Client_Logo.png',
			'type' => 'upload');

		$options[] = array(
			'name' => __('Second Client Logo Image Link:', 'invert'),
			'desc' => __('Enter link for second client logo.', 'invert'),
			'id' => $invert_shortname.'_img2_link',
			'std' => '#',
			'type' => 'text');

		$options[] = array(
			'name' => __('Third Client Logo Image Title:', 'invert'),
			'desc' => __('Enter third client logo image title.', 'invert'),
			'id' => $invert_shortname.'_img3_title',
			'std' => '',
			'type' => 'text');

		$options[] = array(
			'name' => __('Third Client Logo Image:', 'invert'),
			'desc' => __('Choose image for third client logo area. Size: Width 232px and Height 101px.', 'invert'),
			'id' => $invert_shortname.'_img3_icon',
			'std' => $imagepath.'Sample_Client_Logo.png',
			'type' => 'upload');

		$options[] = array(
			'name' => __('Third Client Logo Image Link:', 'invert'),
			'desc' => __('Enter link for third client logo.', 'invert'),
			'id' => $invert_shortname.'_img3_link',
			'std' => '#',
			'type' => 'text');

		$options[] = array(
			'name' => __('Fourth Client Logo Image Title:', 'invert'),
			'desc' => __('Enter fourth client logo image title.', 'invert'),
			'id' => $invert_shortname.'_img4_title',
			'std' => '',
			'type' => 'text');

		$options[] = array(
			'name' => __('Fourth Client Logo Image:', 'invert'),
			'desc' => __('Choose image for fourth client logo area. Size: Width 232px and Height 101px.', 'invert'),
			'id' => $invert_shortname.'_img4_icon',
			'std' => $imagepath.'Sample_Client_Logo.png',
			'type' => 'upload');

		$options[] = array(
			'name' => __('Fourth Client Logo Image Link:', 'invert'),
			'desc' => __('Enter link for fourth client logo.', 'invert'),
			'id' => $invert_shortname.'_img4_link',
			'std' => '#',
			'type' => 'text');

		$options[] = array(
			'name' => __('Fifth Client Logo Image Title:', 'invert'),
			'desc' => __('Enter fifth client logo image title.', 'invert'),
			'id' => $invert_shortname.'_img5_title',
			'std' => '',
			'type' => 'text');

		$options[] = array(
			'name' => __('Fifth Client Logo Image:', 'invert'),
			'desc' => __('Choose image for fifth client logo area. Size: Width 232px and Height 101px.', 'invert'),
			'id' => $invert_shortname.'_img5_icon',
			'std' => $imagepath.'Sample_Client_Logo.png',
			'type' => 'upload');

		$options[] = array(
			'name' => __('Fifth Client Logo Image Link:', 'invert'),
			'desc' => __('Enter link for fifth client logo.', 'invert'),
			'id' => $invert_shortname.'_img5_link',
			'std' => '#',
			'type' => 'text');
			
		//Footer	
	$options[] = array(
		'name' => __('Footer Section', 'invert'),
		'type' => 'heading');

		$options[] = array(
			'name' => __('Copyright Text', 'invert'),
			'desc' => __('You can use HTML for links etc..', 'invert'),
			'id' => $invert_shortname.'_copyright',
			'std' => 'Copyright Text',
			'type' => 'textarea');

	return $options;
}

/*
 * This is an example of how to add custom scripts to the options panel.
 * This example shows/hides an option when a checkbox is clicked.
 */

add_action('optionsframework_custom_scripts', 'optionsframework_custom_scripts');

function optionsframework_custom_scripts() { ?>

<script type="text/javascript">
jQuery(document).ready(function($) {
	$('#example_showhidden').click(function() {
  		$('#section-example_text_hidden').fadeToggle(400);
	});

	if ($('#example_showhidden:checked').val() !== undefined) {
		$('#section-example_text_hidden').show();
	}
 
    var selected_bredbtn = jQuery("#section-invert_bread_stype input[type='radio']:checked").val();
	if (selected_bredbtn === 'brcolor') {jQuery('#section-invert_bread_color').show();}
	else if (selected_bredbtn === 'brimage') {jQuery('#section-invert_bread_image').show();}
	
    var selected_sliderbtn = jQuery("input[name='invert[invert_frontslider_stype]']:checked").val();
	if (selected_sliderbtn == 'video') {jQuery('#section-invert_frvideo_id').show();}
	
	jQuery("input[type='radio']").change(function() 
	{
        var selected_radio = jQuery(this).val();
		if (selected_radio == 'brcolor') {
			jQuery('#section-invert_bread_image').hide();
			jQuery('#section-invert_bread_color').fadeIn();
		}
		if (selected_radio == 'brimage') {
			jQuery('#section-invert_bread_color').hide();
			jQuery('#section-invert_bread_image').fadeIn();
		}
		if (selected_radio == 'slider') {
			jQuery('#section-invert_frvideo_id').hide();
		}
		if (selected_radio == 'video') {
			jQuery('#section-invert_frvideo_id').fadeIn();
		}
    });
});
</script>
<?php
}