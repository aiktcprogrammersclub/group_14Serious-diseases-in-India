<?php global $invert_shortname; ?>
<?php  $fraturedbox = get_post_meta( $post->ID,'_skt_freaturedboxsection_metabox',true );
if($fraturedbox == '1'){ ?>
<div id="featured-box" class="skt-section">
  <div class="container">
	<div class="mid-box-mid row-fluid"> 
		<!-- Featured Box 1 -->
		<div class="mid-box span4"  >	  
			<div class="skt-iconbox iconbox-top">			
				<div class="iconbox-icon skt-animated small-to-large skt-viewport">			
					<?php if(sketch_get_option($invert_shortname.'_fb1_first_part_image')) { ?>
					<a href="<?php if(sketch_get_option($invert_shortname."_fb1_first_part_link")) { echo esc_url(sketch_get_option($invert_shortname."_fb1_first_part_link")); } ?>" title="FB-first">
						<img class="skin-bg" src="<?php  echo sketch_get_option($invert_shortname.'_fb1_first_part_image','invert'); ?>" alt="boximg"/>
					</a>				
					<?php 
					} 
					else { ?><i class="fa fa-group"></i><?php  } ?>		    
				</div>			
				<div class="iconbox-content">				
					<h4><?php if(sketch_get_option($invert_shortname."_fb1_first_part_heading")) { echo sketch_get_option($invert_shortname."_fb1_first_part_heading"); } ?></h4>				
					<p><?php if(sketch_get_option($invert_shortname."_fb1_first_part_content")) { echo sketch_get_option($invert_shortname."_fb1_first_part_content"); } ?></p>			
				</div>			
				<div class="clearfix"></div>	  
			</div>
		</div>

		<!-- Featured Box 2 -->
		<div class="mid-box span4" >
			<div class="skt-iconbox iconbox-top">			
				<div class="iconbox-icon skt-animated small-to-large skt-viewport">			
					<?php if(sketch_get_option($invert_shortname.'_fb2_second_part_image')) { ?>					
					<a href="<?php if(sketch_get_option($invert_shortname."_fb2_second_part_link")) { echo esc_url(sketch_get_option($invert_shortname."_fb2_second_part_link")); } ?>" title="FB-second">
						<img class="skin-bg" src="<?php  echo sketch_get_option($invert_shortname.'_fb2_second_part_image','invert'); ?>" alt="boximg"/>
					</a>				
					<?php } else { ?><i class="fa fa-shield"></i><?php  } ?>			
				</div>			
				<div class="iconbox-content">				
					<h4><?php if(sketch_get_option($invert_shortname."_fb2_second_part_heading")) { echo sketch_get_option($invert_shortname."_fb2_second_part_heading"); } ?></h4>				
					<p><?php if(sketch_get_option($invert_shortname."_fb2_second_part_content")) { echo sketch_get_option($invert_shortname."_fb2_second_part_content"); } ?></p>			
				</div>			
				<div class="clearfix"></div>		
			</div>
		</div>
		
		<!-- Featured Box 3 -->
		<div class="mid-box span4" >
			<div class="skt-iconbox iconbox-top">			
				<div class="iconbox-icon skt-animated small-to-large skt-viewport">			
					<?php if(sketch_get_option($invert_shortname.'_fb3_third_part_image')) { ?>					
					<a href="<?php if(sketch_get_option($invert_shortname."_fb3_third_part_link")) { echo esc_url(sketch_get_option($invert_shortname."_fb3_third_part_link")); } ?>" title="FB-third">
						<img class="skin-bg" src="<?php  echo sketch_get_option($invert_shortname.'_fb3_third_part_image','invert'); ?>" alt="boximg"/>
					</a>				
					<?php } else { ?><i class="fa fa-desktop"></i><?php } ?>			
				</div>			
				<div class="iconbox-content">				
					<h4><?php if(sketch_get_option($invert_shortname."_fb3_third_part_heading")) { echo sketch_get_option($invert_shortname."_fb3_third_part_heading"); } ?></h4>				
					<p><?php if(sketch_get_option($invert_shortname."_fb3_third_part_content")) { echo sketch_get_option($invert_shortname."_fb3_third_part_content"); } ?></p>			
				</div>			
				<div class="clearfix"></div>		
			</div>
		</div>
		<div class="clear"></div>
	</div>
  </div>
</div>
<?php }?>