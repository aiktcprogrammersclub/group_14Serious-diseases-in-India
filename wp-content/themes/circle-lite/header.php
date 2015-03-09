<!DOCTYPE html>
<html <?php language_attributes(); ?>>              
    <head>
        <meta charset="<?php bloginfo('charset'); ?>" />                   
        <meta name="viewport" content="width=device-width, initial-scale=1.0" />
        <title><?php kopa_print_page_title(); ?></title>                
        <link rel="pingback" href="<?php bloginfo('pingback_url'); ?>" />       
        <link rel="shortcut icon" type="image/x-icon"  href="<?php echo get_option('kopa_theme_options_favicon_url'); ?>">     
        <link rel="apple-touch-icon" sizes="57x57" href="<?php echo get_option('kopa_theme_options_apple_iphone_icon_url'); ?>">
        <link rel="apple-touch-icon" sizes="72x72" href="<?php echo get_option('kopa_theme_options_apple_ipad_icon_url'); ?>">
        <link rel="apple-touch-icon" sizes="114x114" href="<?php echo get_option('kopa_theme_options_apple_iphone_retina_icon_url'); ?>">
        <link rel="apple-touch-icon" sizes="144x144" href="<?php echo get_option('kopa_theme_options_apple_ipad_retina_icon_url'); ?>">      
        <!--[if lt IE 9]>
            <script src="http://html5shim.googlecode.com/svn/trunk/html5.js"></script>
            <script src="http://css3-mediaqueries-js.googlecode.com/svn/trunk/css3-mediaqueries.js"></script>
        <![endif]-->
        <?php wp_head(); ?>
    </head>    
    <body <?php body_class(); ?>>                                      
        <header id="page-header">
            <div id="header-top">
                <div class="wrapper">
                    <div class="row-fluid">
                        <div class="span12">
                            <?php
                            if (has_nav_menu('main-nav')):
                                wp_nav_menu(
                                        array(
                                            'theme_location' => 'main-nav',
                                            'container' => 'nav',
                                            'container_id' => 'main-nav',
                                            'container_class' => 'clearfix',
                                            'menu_id' => 'main-menu',
                                            'menu_class' => 'clearfix'
                                        )
                                );
                                ?>
                                <nav id="mobile-menu">
                                    <span><?php echo __('Menu', kopa_get_domain()); ?></span>
                                    <?php
                                    wp_nav_menu(
                                            array(
                                                'theme_location' => 'main-nav',
                                                'container' => false,
                                                'menu_id' => 'toggle-view-menu',
                                                'menu_class' => 'clearfix',
                                                'walker' => new kopa_mobile_menu
                                            )
                                    );
                                    ?>
                                </nav>
                                <?php
                            endif;
                            $kopa_theme_options_email_address = get_option('kopa_theme_options_email_address');
                            $kopa_theme_options_phone_number = get_option('kopa_theme_options_phone_number');
                            ?>   
                            <ul class="contact-top clearfix">
                            <?php if ($kopa_theme_options_phone_number): ?>
                                    <li class="clearfix"><i class="fa fa-phone"></i><span><?php echo $kopa_theme_options_phone_number; ?></span></li>
                                <?php
                                endif;
                                if ($kopa_theme_options_email_address):
                                    ?>
                                    <li class="clearfix"><i class="fa fa-envelope-o"></i><a href="mailto:<?php echo $kopa_theme_options_email_address; ?>"><?php echo $kopa_theme_options_email_address; ?></a></li>
                                <?php endif; ?>
                                <?php do_action('kopa_header_contact_info'); ?>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
            <div id="header-bottom">
                <div class="wrapper">
                    <div class="row-fluid">
                        <div class="span12 clearfix">
                            <div id="logo-image" class="pull-left">
                             <?php if (get_header_image()) { ?>
                                     <a href="<?php echo esc_url(home_url()); ?>">
                                            <img src="<?php header_image(); ?>" alt="<?php bloginfo('name'); ?> <?php _e('Logo', kopa_get_domain()); ?>">
                                    </a>
                                <?php } ?>
                                <h1 class="site-title"><a href="<?php echo esc_url(home_url()); ?>"><?php bloginfo('name'); ?></a></h1>
                            </div><!--logo-image-->
                            <div class="social-box clearfix">
                                <?php
                                $social_networks = array(
                                    'facebook' => array('fa fa-facebook', __('Facebook', kopa_get_domain())),
                                    'twitter' => array('fa fa-twitter', __('Twitter', kopa_get_domain())),
                                    'pinterest' => array('fa fa-pinterest', __('Pinterest', kopa_get_domain())),
                                    'google' => array('fa fa-google-plus', __('Google', kopa_get_domain())),
                                    'dribbble' => array('fa fa-dribbble', __('Dribbble', kopa_get_domain())),
                                    'linkedin' => array('fa fa-linkedin', __('Linkedin', kopa_get_domain())),                                    
                                    'youtube' => array('fa fa-youtube', __('Youtube', kopa_get_domain())),
                                    'flickr' => array('fa fa-flickr', __('Flickr', kopa_get_domain())),
                                    'vimeo' => array('fa fa-vimeo-square', __('Vimeo', kopa_get_domain()))
                                );
                                ?>
                                <ul class="socials-link clearfix">
                                    <?php
                                    $rss_url = get_option("kopa_theme_options_social_links_rss_url", FALSE);
                                    if (strtolower($rss_url) != 'hide') {
                                        if ($rss_url) {
                                            ?>
                                            <li class="feed-icon"><a href="<?php echo $rss_url; ?>" target="_blank" title="<?php echo __('RSS', kopa_get_domain()); ?>"><span class="fa fa-rss" aria-hidden="true"></span></a></li>                   
                                            <?php
                                        } else {
                                            ?>
                                            <li class="feed-icon"><a href="<?php echo get_bloginfo('rss2_url'); ?>" target="_blank" title="<?php echo __('RSS', kopa_get_domain()); ?>"><span class="fa fa-rss" aria-hidden="true"></span></a></li>                    
                                            <?php
                                        }
                                    }
                                    ?>
                                    <?php
                                    foreach ($social_networks as $slug => $title):
                                        $url = get_option("kopa_theme_options_social_links_{$slug}_url", FALSE);
                                        if ($url):
                                            ?>
                                            <li class="<?php echo "{$slug}-icon"; ?>"><a href="<?php echo $url; ?>" title="<?php echo $title[1]; ?>" target="_blank"><span class="<?php echo $title[0]; ?>" aria-hidden="true"></span></a></li>
                                            <?php
                                        endif;
                                    endforeach;
                                    ?>
                                </ul>
                                <?php get_search_form(); ?>                               
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </header>
        <?php kopa_breadcrumb(); ?>
        <div id="main-content">