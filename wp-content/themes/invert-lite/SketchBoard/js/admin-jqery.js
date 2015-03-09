jQuery(document).ready(function ($) {
//Show/hide metabox, depending on element value
    jQuery(document).ready(function(){
        togglesectionboxOnFormat("frontpagesection-metabox", 'template-front-page.php');
		jQuery("#page_template").on("change",function() {
			togglesectionboxOnFormat("frontpagesection-metabox", 'template-front-page.php');
        });
    });
	
	function togglesectionboxOnFormat(metaboxId, value) {
		var title = jQuery("#page_template").val();
		if(title != value ) {
            jQuery("#" + metaboxId).slideUp("fast"); 
			}
        else { 
            jQuery("#" + metaboxId).slideDown("fast"); 
			}

    }

});
