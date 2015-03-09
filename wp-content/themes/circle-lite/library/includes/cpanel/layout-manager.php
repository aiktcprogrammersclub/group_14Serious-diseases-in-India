<?php
global $KOPA_LAYOUT;
global $KOPA_SIDEBAR_POSITIONS;
global $KOPA_TEMPLATE_HIERARCHY;
global $KOPA_SETTING;
global $KOPA_SIDEBARS;

wp_nonce_field("load_layout_setting", "nonce_id");
wp_nonce_field("save_layout_setting", "nonce_id_save");

?>
<div id="kopa-admin-wrapper" class="theme-option clearfix">
    <div id="kopa-theme-options-menu" class="clearfix">
        <?php $url = admin_url('themes.php?page=kopa_cpanel_theme_options'); ?>
        <a href="<?php echo $url; ?>" class="btn btn-info"><?php _e('Theme Options', kopa_get_domain()); ?></a>
        <a href="<?php echo "$url&screen=sidebar-manager"; ?>" class="btn btn-info"><?php _e('Sidebar Manager', kopa_get_domain()); ?></a>
        <a href="<?php echo "$url&screen=layout-manager"; ?>" class="btn btn-success"><?php _e('Layout Manager', kopa_get_domain()); ?></a>
    </div>
    
    <div id="kopa-loading-gif"></div>
    <input type="hidden" id="kopa_template_id" value="home">
    <?php
    if ($KOPA_TEMPLATE_HIERARCHY) {
        echo '<div class="kopa-nav list-container">
                <ul class="tabs clearfix">';
        foreach ($KOPA_TEMPLATE_HIERARCHY as $kopa_template_key => $kopa_template_value) {
            if ($kopa_template_key === 'home')
                $_active = "class='active'";
            else {
                $_active = '';
            }
            echo '<li ' . $_active . '><span title="' . $kopa_template_key . '" onclick="load_layout_setting(jQuery(this))">' . $kopa_template_value['title'] . '</span></li>';
        }
        echo '</ul><!--tabs--->
             </div><!--kopa-nav-->';
    }
    ?>
    <div class="kopa-content">
        <div class="kopa-page-header clearfix">
            <div class="pull-left">
                <h4><?php echo KopaIcon::getIcon('fa fa-cog', 'i'); ?>Layout And Sidebar Manager</h4>
            </div>
            <div class="pull-right">
                <div class="kopa-copyrights">
                    <span><?php _e('Visit author URL:', kopa_get_domain()); ?></span><a href="<?php echo KOPA_URL;?>"><?php echo KOPA_URL;?></a>
                </div><!--="kopa-copyrights-->
            </div>
        </div><!--kopa-page-header-->
        <div class="tab-container">
            <div class="kopa-content-box tab-content kopa-content-main-box" id="home">
                <div class="kopa-actions clearfix">
                    <div class="kopa-button">
                        <span class="btn btn-primary" onclick="save_layout_setting(jQuery(this))"><?php echo KopaIcon::getIcon('fa fa-check', 'i'); ?>Save</span>
                    </div>
                </div><!--kopa-actions-->
                <div class="kopa-box-head">                    
                    <?php echo KopaIcon::getIcon('fa fa-hand-o-right', 'i'); ?>
                    <span class="kopa-section-title">Home</span>
                </div><!--kopa-box-head-->
                <div class="kopa-box-body row-fluid clearfix"> 
                    <div class="kopa-layout-box pull-left">
                        <div class="kopa-select-layout-box kopa-element-box">
                            <span class="kopa-component-title"><?php _e('Select the layout: ', kopa_get_domain()); ?></span>
                            <select class="kopa-layout-select"  onchange="show_onchange(jQuery(this));" autocomplete="off">
                                <?php
                                foreach ($KOPA_TEMPLATE_HIERARCHY['home']['layout'] as $keys => $value) {
                                    echo '<option value="' . $value . '"';
                                    if($value === $KOPA_SETTING['home']['layout_id']){
                                            echo 'selected="selected"';
                                        }
                                    echo '>' . $KOPA_LAYOUT[$value]['title'] . '</option>';
                                }
                                ?>
                            </select>                          
                        </div><!--kopa-select-layout-box-->
                        <?php
                        foreach ($KOPA_TEMPLATE_HIERARCHY['home']['layout'] as $keys => $value) {
                            foreach ($KOPA_LAYOUT as $layout_key => $layout_value) {
                                if ($layout_key == $value) {
                                    ?>
                                    <div class="<?php echo 'kopa-sidebar-box-wrapper sidebar-position-' . $layout_key; ?>">
                                        <?php
                                        foreach ($layout_value['positions'] as $postion_key => $postion_id) {
                                            ?>
                                            <div class="kopa-sidebar-box kopa-element-box">
                                                <span class="kopa-component-title"><?php echo $KOPA_SIDEBAR_POSITIONS[$postion_id]['title']; ?></span>                                               
                                                <label class="kopa-label">Select sidebars</label>
                                                <?php
                                                echo '<select class="kopa-sidebar-select" autocomplete="off">';
                                                foreach ($KOPA_SIDEBARS as $sidebar_list_key => $sidebar_list_value) {
                                                    $__selected_sidebar = '';
                                                    if($layout_key === $KOPA_SETTING['home']['layout_id']){
                                                        if($sidebar_list_key === $KOPA_SETTING['home']['sidebars'][$postion_key]){
                                                             $__selected_sidebar = 'selected="selected"';
                                                        }
                                                    }
                                                    echo '<option value="'.$sidebar_list_key.'" ' . $__selected_sidebar . '>' . $sidebar_list_value . '</option>';
                                                    $__selected_sidebar = '';
                                                }
                                                echo '</select>';
                                                ?>
                                            </div><!--kopa-sidebar-box-->
                                        <?php } ?>
                                    </div><!--kopa-sidebar-box-wrapper-->
                                    <?php
                                }
                            }
                        }
                        ?>
                    </div><!--kopa-layout-box-->
                    <div class="kopa-thumbnails-box pull-right">
                        <?php
                        foreach ($KOPA_TEMPLATE_HIERARCHY['home']['layout'] as $thumbnails_key => $thumbnails_value) {
                            ?>
                            <image class="responsive-img <?php echo ' kopa-cpanel-thumbnails kopa-cpanel-thumbnails-' . $thumbnails_value; ?>" src="<?php echo KOPA_CPANEL_IMAGE_DIR . $KOPA_LAYOUT[$thumbnails_value]['thumbnails']; ?>" class="img-polaroid" alt="">
                            <?php
                        }
                        ?>
                    </div><!--kopa-thumbnails-box-->
                </div><!--kopa-box-body-->
                <div class="kopa-actions kopa-bottom-action-bar clearfix">
                    <div class="kopa-button">
                        <span class="btn btn-primary" onclick="save_layout_setting(jQuery(this))"><?php echo KopaIcon::getIcon('fa fa-check', 'i'); ?>Save</span>
                    </div>
                </div>

            </div><!--kopa-content-box-->
        </div><!--tab-container-->
    </div><!--kopa-content-->
</div><!--kopa-admin-wrapper-->