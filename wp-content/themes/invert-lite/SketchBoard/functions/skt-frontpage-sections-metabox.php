<?php


/*-----------------------------------------------------------------------------------*/
/*	Add Frontpage Section Metaboxes
/*-----------------------------------------------------------------------------------*/
// Add metabox
add_action('admin_init', 'invert_frontpagesection_metabox');
function invert_frontpagesection_metabox(){
	add_meta_box('frontpagesection-metabox', 'Home Page Template Sections', 'invert_frontpagesection_metabox_callback', 'page', 'normal', 'high');
}

// Metabox callback
function invert_frontpagesection_metabox_callback() { 
	global $post;
	$fraturedbox = get_post_meta( $post->ID,'_skt_freaturedboxsection_metabox',true );
	$ctameta = get_post_meta( $post->ID,'_skt_calltoaction_metabox',true );
	$parallaxeffectmeta = get_post_meta( $post->ID,'_skt_parallaxeffect_metabox',true );
	$clientlogometa = get_post_meta( $post->ID,'_skt_clientlogo_metabox',true );
    wp_nonce_field( 'my_meta_box_nonce', 'meta_box_nonce' );
?>

<table>
  <tr>
    <td>
		<h4><?php _e('Featured Box Section','invert');?></h4>
	</td>
	<td>
		<div class="inputbox">
			 <label for="skt_freaturedboxsection_metabox1"><input type="radio" name="_skt_freaturedboxsection_metabox" id="skt_freaturedboxsection_metabox1" value="1" checked="checked"  <?php checked(1, $fraturedbox); ?> /><?php _e('Enable &nbsp;&nbsp;&nbsp;&nbsp;','invert') ?></label>
			 <label for="skt_freaturedboxsection_metabox2"><input type="radio" name="_skt_freaturedboxsection_metabox" id="skt_freaturedboxsection_metabox2" value="0" <?php checked(0, $fraturedbox); ?> /><?php _e('Disable','invert') ?></label>
		</div>
	</td>
   </tr>

	
  <tr>
    <td>
		<h4><?php _e('Call to Action Section','invert');?></h4>
	</td>
	<td>
		<div class="inputbox">
			<label for="skt_calltoaction_metabox1"><input type="radio" name="_skt_calltoaction_metabox" id="skt_calltoaction_metabox1" value="1" checked="checked"  <?php checked(1, $ctameta); ?> /><?php _e('Enable &nbsp;&nbsp;&nbsp;&nbsp;','invert') ?></label>
			<label for="skt_calltoaction_metabox2"><input type="radio" name="_skt_calltoaction_metabox" id="skt_calltoaction_metabox2" value="0" <?php checked(0, $ctameta); ?>/><?php _e('Disable','invert') ?></label>
		</div>
	</td>
   </tr>
	
  <tr>
    <td>
		<h4><?php _e('Content Box with Parallax Effect Section','invert');?></h4>
	</td>
	<td>
		<div class="inputbox">
			<label for="skt_parallaxeffect_metabox1"><input type="radio" name="_skt_parallaxeffect_metabox" id="skt_parallaxeffect_metabox1" value="1" checked="checked"  <?php checked(1, $parallaxeffectmeta); ?> /><?php _e('Enable &nbsp;&nbsp;&nbsp;&nbsp;','invert') ?></label>
			<label for="skt_parallaxeffect_metabox2"><input type="radio" name="_skt_parallaxeffect_metabox" id="skt_parallaxeffect_metabox2" value="0" <?php checked(0, $parallaxeffectmeta); ?> /><?php _e('Disable','invert') ?></label>
		</div>
	</td>
   </tr>
	
   <tr>
    <td>
		<h4><?php _e('Client Logo Section','invert');?></h4>
	</td>
	<td>
		<div class="inputbox">
			<label for="skt_clientlogo_metabox1"><input type="radio" name="_skt_clientlogo_metabox" id="skt_clientlogo_metabox1" value="1" checked="checked"  <?php checked(1, $clientlogometa); ?> /><?php _e('Enable &nbsp;&nbsp;&nbsp;&nbsp;','invert') ?></label>
			<label for="skt_clientlogo_metabox2"><input type="radio" name="_skt_clientlogo_metabox" id="skt_clientlogo_metabox2" value="0" <?php checked(0, $clientlogometa); ?> /><?php _e('Disable','invert') ?></label>
		</div>
	</td>
   </tr>	
</table>	

<?php } 

// Action when save post
add_action('save_post', 'invert_admin_save_frontpagesection');
/* When the post is saved, saves our custom data */
function invert_admin_save_frontpagesection( $post_id ) {

  // verify if this is an auto save routine. 
  // If it is our form has not been submitted, so we dont want to do anything
  if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) 
      return;
  // verify this came from the our screen and with proper authorization,
  // because save_post can be triggered at other times
  // Check permissions
  if(isset($_POST['post_type'])){
  if ( 'page' == $_POST['post_type'] ) 
  {
    if ( !current_user_can( 'edit_page', $post_id ) )
        return;
  }
  }
  else
  {
    if ( !current_user_can( 'edit_post', $post_id ) )
        return;
  }
  // OK, we're authenticated: we need to find and save the data
	if(isset($_POST['_skt_freaturedboxsection_metabox'])){ $skt_freaturedboxsection_metabox = $_POST['_skt_freaturedboxsection_metabox']; }
	if(isset($_POST['_skt_calltoaction_metabox'])){ $skt_calltoaction_metabox = $_POST['_skt_calltoaction_metabox']; }
	if(isset($_POST['_skt_parallaxeffect_metabox'])){ $skt_parallaxeffect_metabox = $_POST['_skt_parallaxeffect_metabox']; }
	if(isset($_POST['_skt_clientlogo_metabox'])){ $skt_clientlogo_metabox = $_POST['_skt_clientlogo_metabox']; }
	global $post;
	if(isset($skt_freaturedboxsection_metabox)){ update_post_meta($post->ID, '_skt_freaturedboxsection_metabox', $skt_freaturedboxsection_metabox); }
	if(isset($skt_calltoaction_metabox)){ update_post_meta($post->ID, '_skt_calltoaction_metabox', $skt_calltoaction_metabox); }
	if(isset($skt_parallaxeffect_metabox)){ update_post_meta($post->ID, '_skt_parallaxeffect_metabox', $skt_parallaxeffect_metabox); }
	if(isset($skt_clientlogo_metabox)){ update_post_meta($post->ID, '_skt_clientlogo_metabox', $skt_clientlogo_metabox); }

  // Do something with $mydata 
  // probably using add_post_meta(), update_post_meta(), or 
  // a custom table (see Further Reading section below)
}
?>