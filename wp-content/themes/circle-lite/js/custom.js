/*!
 * Kopa custom js (http://kopatheme.com)
 * Copyright 2014 Kopasoft.
 * Licensed under GNU General Public License v3
 */

/* =========================================================
 Google font loader
 ============================================================ */
WebFont.load({
    google: {
        families: ['Rokkitt:400,700', 'Open+Sans:400,300,400italic,300italic,600,600italic,700,800,800italic,700italic']
    }
});
/* =========================================================
 Sharing Buttons
 ============================================================ */
jQuery(window).load(function() {
    if (jQuery('.share_block').length === 1) {
        jQuery.ajax({
            type: 'POST',
            url: kopa_front_variable.ajax.url,
            dataType: 'html',
            async: true,
            data: {
                action: 'kopa_sharing_button',
                wpnonce: jQuery('#kopa_sharing_button_wpnonce').val(),
                pid: kopa_front_variable.template.post_id
            },
            beforeSend: function(XMLHttpRequest, settings) {
            },
            complete: function(XMLHttpRequest, textStatus) {
            },
            success: function(data) {
                if (data.length > 0) {
                    jQuery('.share_block').html(data).show();
                } else {
                    jQuery('.share_block').remove();
                }
            },
            error: function(XMLHttpRequest, textStatus, errorThrown) {
            }
        });
    }
});
/* =========================================================
 Flickr Feed
 ============================================================ */
jQuery(document).ready(function() {
    var flickrs = jQuery('.flickr-wrap');
    if (flickrs.length > 0) {
        jQuery.each(flickrs, function() {
            var ID = jQuery(this).find('.flickr_id').val();
            var limit = parseInt(jQuery(this).find('.flickr_limit').val());
            jQuery(this).jflickrfeed({
                limit: limit,
                qstrings: {
                    id: ID
                },
                itemTemplate:
                        '<li class="flickr-badge-image">' +
                        '<a target="_blank" href="{{link}}" title="{{title}}">' +
                        '<img src="{{image_s}}" alt="{{title}}"/>' +
                        '</a>' +
                        '</li>'
            }, function(data) {
            });
        });
    }
});
/* =========================================================
 Like Button
 ============================================================ */
function kopa_like_button_click(obj, pid) {
    if (!obj.hasClass('inprocess')) {
        var status = obj.hasClass('kopa_like_button_enable') ? 'enable' : 'disable';

        var icon = obj.find('span').first();
        var icon_class = icon.attr('class');

        jQuery.ajax({
            type: 'POST',
            url: kopa_front_variable.ajax.url,
            dataType: 'json',
            async: true,
            data: {
                action: 'kopa_change_like_status',
                wpnonce: jQuery('#kopa_change_like_status_wpnonce').val(),
                pid: pid,
                status: status
            },
            beforeSend: function(XMLHttpRequest, settings) {
                obj.addClass('inprocess');
                icon.attr('class', 'fa fa-refresh entry-icon');
            },
            complete: function(XMLHttpRequest, textStatus) {
                icon.attr('class', icon_class);
            },
            success: function(data) {
                obj.parent().find('.kopa_like_count').html(data.total);
                obj.removeClass('kopa_like_button_' + status);
                obj.addClass('kopa_like_button_' + data.status);
                obj.removeClass('inprocess');
            },
            error: function(XMLHttpRequest, textStatus, errorThrown) {
            }
        });
    }
    return false;
}
/* =========================================================
 Set view count (post, page)
 ============================================================ */
jQuery(document).ready(function() {
    if (kopa_front_variable.template.post_id > 0) {
        jQuery.ajax({
            type: 'POST',
            url: kopa_front_variable.ajax.url,
            dataType: 'json',
            async: true,
            timeout: 5000,
            data: {
                action: 'kopa_set_view_count',
                wpnonce: jQuery('#kopa_set_view_count_wpnonce').val(),
                post_id: kopa_front_variable.template.post_id
            },
            beforeSend: function(XMLHttpRequest, settings) {
            },
            complete: function(XMLHttpRequest, textStatus) {
            },
            success: function(data) {
            },
            error: function(XMLHttpRequest, textStatus, errorThrown) {
            }
        });
    }
});

/* =========================================================
 Mobile menu
 ============================================================ */
jQuery(document).ready(function() {
    jQuery('#mobile-menu > span').click(function() {
        var mobile_menu = jQuery('#toggle-view-menu');
        if (mobile_menu.is(':hidden')) {
            mobile_menu.slideDown('300');
            jQuery(this).children('span').html('-');
        } else {
            mobile_menu.slideUp('300');
            jQuery(this).children('span').html('+');
        }
        jQuery(this).toggleClass('active');
    });
    jQuery('#toggle-view-menu li').click(function() {
        var text = jQuery(this).children('div.menu-panel');
        if (text.is(':hidden')) {
            text.slideDown('300');
            jQuery(this).children('span').html('-');
        } else {
            text.slideUp('300');
            jQuery(this).children('span').html('+');
        }
    });
});
/* =========================================================
 Home page slider
 ============================================================ */
jQuery(function() {
    var eislider = jQuery('.ei-slider'),
            sliderAnimation = eislider.data('animation'),
            sliderAutoplay = eislider.data('autoplay') ? true : false,
            sliderSlidershowInterval = eislider.data('slideshow_interval'),
            sliderSpeed = eislider.data('speed'),
            sliderTitlesFactor = eislider.data('titlesfactor'),
            sliderTitleSpeed = eislider.data('titlespeed');
    if (eislider.length > 0) {        
        jQuery.each(eislider, function() {
            jQuery(this).eislideshow({
                animation: sliderAnimation,
                autoplay: sliderAutoplay,
                slideshow_interval: sliderSlidershowInterval,
                speed: sliderSpeed,
                titlesFactor: sliderTitlesFactor,
                titlespeed: sliderTitleSpeed
            });
        });
    }
});
jQuery(document).ready(function() {
    init_image_effect();
});
jQuery(window).resize(function() {
    init_image_effect();
});
function init_image_effect() {
    var view_p_w = jQuery(window).width();
    var pp_w = 500;
    var pp_h = 344;
    if (view_p_w <= 479) {
        pp_w = '120%';
        pp_h = '100%';
    }
    else if (view_p_w >= 480 && view_p_w <= 599) {
        pp_w = '100%';
        pp_h = '170%';
    }
    jQuery("a[rel^='prettyPhoto']").prettyPhoto({
        show_title: false,
        deeplinking: false,
        social_tools: false,
        default_width: pp_w,
        default_height: pp_h
    });
}
jQuery(document).ready(function() {
    jQuery('.gallery-eislider-preview').each(function() {
        var $this = jQuery(this),
                $imageHover = $this.find('.hover-effect');
        $this.css({
            width: $imageHover.length * 63
        })
    });
});

/* =========================================================
 Fix css
 ============================================================ */
jQuery(document).ready(function() {
    jQuery(".list-container-1 ul li:last-child").css("margin-right", 0);
    jQuery("#sidebar .widget ul li:last-child").css("margin-bottom", 0);
    jQuery(".pagination ul > li:last-child").css("margin-right", 0);
    jQuery("#main-col .widget .older-post li:last-child").css("margin-bottom", 0);
    jQuery("#sidebar .widget .list-container-2 ul li:last-child").css({"margin-right": 0, "width": 100});
    jQuery("#sidebar .widget .tab-content-2 ul li:last-child").css({"border-bottom": "none", "padding-bottom": 0});
    jQuery("#bottom-sidebar ul li:last-child").css({"border-bottom": "none", "padding-bottom": 0, "margin-bottom": 0});
    jQuery(".article-list li:last-child").css({"border-bottom": "none", "padding-bottom": 0, "margin-bottom": 40});
    jQuery(".kp-cat-2 .article-list li:last-child").css("margin-bottom", 10);
    jQuery("#main-col .widget-area-5 .widget ul li:last-child").css({"border-bottom": "none", "padding-bottom": 0, "margin-bottom": 0});
    jQuery(".kp-filter ul.ss-links li:last-child a").css("border-bottom", 'none');
    jQuery(".isotop-header #filters li:last-child a").css("border-bottom", 'none');
    jQuery(".sidebar .widget ul li:last-child").css({"border-bottom": "none", "padding-bottom": 0, "margin-bottom": 0});
    jQuery(".widget-area-2 .widget_archive ul li:last-child").css({"border-bottom": "none", "padding-bottom": 0, "margin-bottom": 0});
    jQuery(".widget-area-2 .widget_categories ul li:last-child").css({"border-bottom": "none", "padding-bottom": 0, "margin-bottom": 0});
    jQuery(".widget-area-2 .widget_recent_comments ul li:last-child").css({"border-bottom": "none", "padding-bottom": 0, "margin-bottom": 0});
    jQuery(".widget-area-2 .widget_recent_entries ul li:last-child").css({"border-bottom": "none", "padding-bottom": 0, "margin-bottom": 0});
    jQuery(".widget-area-2 .widget_rss ul li:last-child").css({"border-bottom": "none", "padding-bottom": 0, "margin-bottom": 0});
    jQuery(".widget-area-2 .widget_pages ul li:last-child").css({"border-bottom": "none", "padding-bottom": 0, "margin-bottom": 0});
    jQuery(".widget-area-2 .widget_meta ul li:last-child").css({"border-bottom": "none", "padding-bottom": 0, "margin-bottom": 0});
    jQuery(".widget-area-2 .widget_nav_menu ul li:last-child").css({"border-bottom": "none", "padding-bottom": 0, "margin-bottom": 0});
    jQuery(".widget-area-3 .widget_archive ul li:last-child").css({"border-bottom": "none", "padding-bottom": 0, "margin-bottom": 0});
    jQuery(".widget-area-3 .widget_categories ul li:last-child").css({"border-bottom": "none", "padding-bottom": 0, "margin-bottom": 0});
    jQuery(".widget-area-3 .widget_recent_comments ul li:last-child").css({"border-bottom": "none", "padding-bottom": 0, "margin-bottom": 0});
    jQuery(".widget-area-3 .widget_recent_entries ul li:last-child").css({"border-bottom": "none", "padding-bottom": 0, "margin-bottom": 0});
    jQuery(".widget-area-3 .widget_rss ul li:last-child").css({"border-bottom": "none", "padding-bottom": 0, "margin-bottom": 0});
    jQuery(".widget-area-3 .widget_pages ul li:last-child").css({"border-bottom": "none", "padding-bottom": 0, "margin-bottom": 0});
    jQuery(".widget-area-3 .widget_meta ul li:last-child").css({"border-bottom": "none", "padding-bottom": 0, "margin-bottom": 0});
    jQuery(".widget-area-3 .widget_nav_menu ul li:last-child").css({"border-bottom": "none", "padding-bottom": 0, "margin-bottom": 0});
    jQuery(".widget-area-4 .widget_archive ul li:last-child").css({"border-bottom": "none", "padding-bottom": 0, "margin-bottom": 0});
    jQuery(".widget-area-4 .widget_categories ul li:last-child").css({"border-bottom": "none", "padding-bottom": 0, "margin-bottom": 0});
    jQuery(".widget-area-4 .widget_recent_comments ul li:last-child").css({"border-bottom": "none", "padding-bottom": 0, "margin-bottom": 0});
    jQuery(".widget-area-4 .widget_recent_entries ul li:last-child").css({"border-bottom": "none", "padding-bottom": 0, "margin-bottom": 0});
    jQuery(".widget-area-4 .widget_rss ul li:last-child").css({"border-bottom": "none", "padding-bottom": 0, "margin-bottom": 0});
    jQuery(".widget-area-4 .widget_pages ul li:last-child").css({"border-bottom": "none", "padding-bottom": 0, "margin-bottom": 0});
    jQuery(".widget-area-4 .widget_meta ul li:last-child").css({"border-bottom": "none", "padding-bottom": 0, "margin-bottom": 0});
    jQuery(".widget-area-4 .widget_nav_menu ul li:last-child").css({"border-bottom": "none", "padding-bottom": 0, "margin-bottom": 0});
    jQuery(".widget-area-5 .widget_archive ul li:last-child").css({"border-bottom": "none", "padding-bottom": 0, "margin-bottom": 0});
    jQuery(".widget-area-5 .widget_categories ul li:last-child").css({"border-bottom": "none", "padding-bottom": 0, "margin-bottom": 0});
    jQuery(".widget-area-5 .widget_recent_comments ul li:last-child").css({"border-bottom": "none", "padding-bottom": 0, "margin-bottom": 0});
    jQuery(".widget-area-5 .widget_recent_entries ul li:last-child").css({"border-bottom": "none", "padding-bottom": 0, "margin-bottom": 0});
    jQuery(".widget-area-5 .widget_rss ul li:last-child").css({"border-bottom": "none", "padding-bottom": 0, "margin-bottom": 0});
    jQuery(".widget-area-5 .widget_pages ul li:last-child").css({"border-bottom": "none", "padding-bottom": 0, "margin-bottom": 0});
    jQuery(".widget-area-5 .widget_meta ul li:last-child").css({"border-bottom": "none", "padding-bottom": 0, "margin-bottom": 0});
    jQuery(".widget-area-5 .widget_nav_menu ul li:last-child").css({"border-bottom": "none", "padding-bottom": 0, "margin-bottom": 0});
    jQuery(".widget-area-1 .entry-item:last-child").css({"border-bottom": "none", "padding-bottom": 0, "margin-bottom": 0});
    jQuery(".widget-area-10 .entry-item:last-child").css({"border-bottom": "none", "padding-bottom": 0, "margin-bottom": 0});
});
/* =========================================================
 Tabs
 ============================================================ */
jQuery(document).ready(function() {
    if (jQuery(".tab-content-1").length > 0) {
        //Default Action Product Tab
        jQuery(".tab-content-1").hide(); //Hide all content
        jQuery("ul.tabs-1 li:first").addClass("active").show(); //Activate first tab
        jQuery(".tab-content-1:first").show(); //Show first tab content
        //On Click Event Product Tab
        jQuery("ul.tabs-1 li").click(function() {
            jQuery("ul.tabs-1 li").removeClass("active"); //Remove any "active" class
            jQuery(this).addClass("active"); //Add "active" class to selected tab
            jQuery(".tab-content-1").hide(); //Hide all tab content
            var activeTab = jQuery(this).find("a").attr("href"); //Find the rel attribute value to identify the active tab + content
            jQuery(activeTab).fadeIn(); //Fade in the active content            
            return false;
        });
    }
    if (jQuery(".tab-content-2").length > 0) {
        //Default Action Product Tab
        jQuery(".tab-content-2").hide(); //Hide all content
        jQuery("ul.tabs-2 li:first").addClass("active").show(); //Activate first tab
        jQuery(".tab-content-2:first").show(); //Show first tab content
        //On Click Event Product Tab
        jQuery("ul.tabs-2 li").click(function() {
            jQuery("ul.tabs-2 li").removeClass("active"); //Remove any "active" class
            jQuery(this).addClass("active"); //Add "active" class to selected tab
            jQuery(".tab-content-2").hide(); //Hide all tab content
            var activeTab = jQuery(this).find("a").attr("href"); //Find the rel attribute value to identify the active tab + content
            jQuery(activeTab).fadeIn(); //Fade in the active content
            return false;
        });
    }
    if (jQuery(".tab-content-3").length > 0) {
        //Default Action Product Tab
        jQuery(".tab-content-3").hide(); //Hide all content
        jQuery("ul.tabs-3 li:first").addClass("active").show(); //Activate first tab
        jQuery(".tab-content-3:first").show(); //Show first tab content
        //On Click Event Product Tab
        jQuery("ul.tabs-3 li").click(function() {
            jQuery("ul.tabs-3 li").removeClass("active"); //Remove any "active" class
            jQuery(this).addClass("active"); //Add "active" class to selected tab
            jQuery(".tab-content-3").hide(); //Hide all tab content
            var activeTab = jQuery(this).find("a").attr("href"); //Find the rel attribute value to identify the active tab + content
            jQuery(activeTab).fadeIn(); //Fade in the active content
            return false;
        });
    }
    if (jQuery(".about-tab-content").length > 0) {
        //Default Action Product Tab
        jQuery(".about-tab-content").hide(); //Hide all content
        jQuery("ul.about-tabs li:first").addClass("active").show(); //Activate first tab
        jQuery(".about-tab-content:first").show(); //Show first tab content
        //On Click Event Product Tab
        jQuery("ul.about-tabs li").click(function() {
            jQuery("ul.about-tabs li").removeClass("active"); //Remove any "active" class
            jQuery(this).addClass("active"); //Add "active" class to selected tab
            jQuery(".about-tab-content").hide(); //Hide all tab content
            var activeTab = jQuery(this).find("a").attr("href"); //Find the rel attribute value to identify the active tab + content
            jQuery(activeTab).fadeIn(); //Fade in the active content
            return false;
        });
    }
});
/* =========================================================
 Toggle Boxes
 ============================================================ */
jQuery(document).ready(function() {
    jQuery('#toggle-view li').click(function(event) {
        var text = jQuery(this).children('div.panel');
        if (text.is(':hidden')) {
            jQuery(this).addClass('active');
            text.slideDown('300');
            jQuery(this).children('span').html('-');
        } else {
            jQuery(this).removeClass('active');
            text.slideUp('300');
            jQuery(this).children('span').html('+');
        }
    });
});
/* =========================================================
 ToolTip
 ============================================================ */
jQuery(window).load(function() {
    jQuery('.kp-tooltip').tooltip('hide');
});
/* =========================================================
 Scroll to top
 ============================================================ */
jQuery(document).ready(function() {
    // hide #back-top first
    jQuery("#back-top").hide();
    // fade in #back-top
    jQuery(function() {
        jQuery(window).scroll(function() {
            if (jQuery(this).scrollTop() > 200) {
                jQuery('#back-top').fadeIn();
            } else {
                jQuery('#back-top').fadeOut();
            }
        });
        // scroll body to 0px on click
        jQuery('#back-top a').click(function() {
            jQuery('body,html').animate({
                scrollTop: 0
            }, 800);
            return false;
        });
    });
});
/* =========================================================
 Accordion
 ========================================================= */
jQuery(document).ready(function() {
    (function() {
        var acc_wrapper = jQuery('.acc-wrapper');
        if (acc_wrapper.length > 0)
        {
            jQuery('.acc-wrapper .accordion-container').hide();
            jQuery.each(acc_wrapper, function(index, item) {
                jQuery(this).find(jQuery('.accordion-title')).first().addClass('active').next().show();
            });
            jQuery('.accordion-title').on('click', function(e) {
                if (jQuery(this).next().is(':hidden')) {
                    jQuery(this).parent().find(jQuery('.active')).removeClass('active').next().slideUp(300);
                    jQuery(this).toggleClass('active').next().slideDown(300);
                }
                e.preventDefault();
            });
        }
    })();
});
/* =========================================================
 Carousel
 ============================================================ */
jQuery(window).load(function() {
    if (jQuery("#related-widget").length > 0) {
        jQuery('#related-widget').carouFredSel({
            responsive: true,
            prev: '#prev-1',
            next: '#next-1',
            width: '100%',
            scroll: 1,
            auto: false,
            items: {
                width: 245,
                height: 'auto',
                visible: {
                    min: 1,
                    max: 3
                }
            }
        });
    }
    jQuery('.kopa_widget_articlelist_carousel').each(function() {
        var jQuery_this = jQuery(this),
                prevID = jQuery_this.data('prev-id'),
                nextID = jQuery_this.data('next-id'),
                paginationID = jQuery_this.data('pagination-id');
        jQuery_this.carouFredSel({
            responsive: true,
            prev: '#' + prevID,
            next: '#' + nextID,
            pagination: "#" + paginationID,
            width: '100%',
            scroll: 1,
            auto: false,
            items: {
                width: 250,
                height: 'auto',
                visible: {
                    min: 1,
                    max: 3
                }
            }
        });
    });

});
/* =========================================================
 Flex slider
 ============================================================ */
jQuery(window).load(function() {
    jQuery('.blogpost-slider').flexslider({
        animation: "slide",
        start: function(slider) {
            jQuery('.flexslider').removeClass('loading');
        }
    });
    jQuery('.kp-single-carousel').flexslider({
        animation: "slide",
        controlNav: false,
        animationLoop: false,
        slideshow: false,
        itemWidth: 195,
        itemMargin: 5,
        asNavFor: '.kp-single-slider'
    });
    jQuery('.kp-single-slider').flexslider({
        animation: "slide",
        controlNav: false,
        animationLoop: false,
        slideshow: false,
        sync: ".kp-single-carousel",
        start: function(slider) {
            jQuery('body').removeClass('loading');
        }
    });
});
/* ============================================================
 Load more gallery
 ============================================================ */
function more_gallery(obj) {
    var more_photo = jQuery(obj).parent().find(".more-panel");
    if (jQuery(obj).hasClass('arrow-up')) {
        more_photo.slideUp('300');
        jQuery(obj).removeClass('arrow-up');
    } else {
        more_photo.slideDown('300');
        jQuery(obj).addClass('arrow-up');
    }
}

/*==============================================================================
 * after load Ajax
 =============================================================================*/
jQuery(document).ajaxComplete(function() {
    jQuery("a[rel^='prettyPhoto']").prettyPhoto();
    jQuery('.blogpost-slider').flexslider({
        animation: "slide",
        start: function(slider) {
            jQuery('.flexslider').removeClass('loading');
        }
    });
});
/*==============================================================================
 * Sequence Slider
 =============================================================================*/
jQuery(document).ready(function() {
    jQuery('.sequence-slider').each(function() {
        var $this = jQuery(this),
                $sequence = $this.find('.sequence'),
                sequenceAutoPlay = $sequence.data('autoplay'),
                sequenceAutoPlayDelay = $sequence.data('slideshow_interval'),
                $sequenceNav = $this.find('.sequence-nav');
        var options = {
            autoPlay: sequenceAutoPlay,
            autoPlayDelay: sequenceAutoPlayDelay,
            fallback: {
                theme: 'slide',
                speed: 500
            },
            nextButton: true,
            prevButton: true,
            animateStartingFrameIn: true,
            preloader: true,
            pauseOnHover: true,
            preloadTheseFrames: [1]
        };
        var sequence = $sequence.sequence(options).data("sequence");
        sequence.afterLoaded = function() {
            $sequenceNav.fadeIn(100);
            $sequenceNav.find("li:nth-child(" + (sequence.settings.startingFrameID) + ") img").addClass("active");
        };
        sequence.beforeNextFrameAnimatesIn = function() {
            $sequenceNav.find("li:not(:nth-child(" + (sequence.nextFrameID) + ")) img").removeClass("active");
            $sequenceNav.find("li:nth-child(" + (sequence.nextFrameID) + ") img").addClass("active");
        };
        $sequenceNav.find("li").click(function() {
            jQuery(this).children("img").removeClass("active").children("img").addClass("active");
            sequence.nextFrameID = jQuery(this).index() + 1;
            sequence.goTo(sequence.nextFrameID);
        });
    });
});
