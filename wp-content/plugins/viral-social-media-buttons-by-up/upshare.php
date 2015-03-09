<?php
/**
 * @package UP Share
 */
/*
Plugin Name: Viral Social Media Buttons by UP
Version: 1.0.3
Author: UP
Author URI: http://www.upshare.co
Description: The Viral Social Media Buttons from UP change the way sites go viral. With our responsive, cloud-based, fully customizable viral buttons, you can automatically drive more traffic to your site for free.
License: GPLv2 or later
*/

defined('SB_DS') or define('SB_DS', DIRECTORY_SEPARATOR);
class UP_ViralSharingSocial
{
	protected $_plugin_dir;
	protected $_plugin_url;
	
	public function __construct()
	{
		$this->_plugin_dir = dirname(__FILE__);
		$this->_plugin_url = get_site_url(null, '/wp-content/plugins/') . basename($this->_plugin_dir);
		$this->addActions();
		$this->addFilters();
	}
	public static function myplugin_deactivation()
	{
		delete_option('upshare_notice');
		delete_option('partner_id');
	}
	public static function myplugin_activation()
	{
		add_option('upshare_notice',"");
		add_option('partner_id',"");
	
	}
	public function addActions()
	{
		add_action('init', array($this, 'route'));
		add_action( 'wp_ajax_my_action', array($this, 'my_action_callback') );
		if( is_admin() )
		{
			add_action("admin_menu", array($this, "setup_theme_admin_menus"));
			add_action('admin_enqueue_scripts', array($this, 'addStyleScripts'), 15);
			add_action('admin_head', array($this, 'my_action_javascript'));
			
			add_action('admin_notices', array($this, 'admin_notice_message'));
			
		}
		else
		{
			add_action('wp_head' , array($this, 'addScriptCodeToHead'));
		}
	}
	public function addFilters()
	{
		if( is_admin() )
		{
					
		}
		else
		{
			add_filter('the_content', array($this, 'filter_the_content'));	
		}
	}
	public function admin_notice_message()
	{
		$json = $this->queryApi();
		//$partner_id 	= get_option("partner_id");
		$partner_id = (isset($json->partner_id) && (int)$json->partner_id > 0) ? $json->partner_id : '';
		$upshare_notice =  get_option("upshare_notice");
	
		if($partner_id == "")
		{
			if($upshare_notice == "")
			{
				echo '<div class="updated" id="upshare_notice">'.
						'<p><strong>Note</strong> - To customize the look, feel and behavior of your new viral buttons you need to create a free <a href="https://www.upshare.co/partners/wp/sign_up/" target="_blank">UP Account</a>.<br/>'.
						'<a href="https://www.upshare.co/partners/wp/sign_up/" target="_blank">Sign up here </a>  |  '.
						'<a href="" id="closeNotice" onclick="return removeNotice();">Ignore this notice</a>'.
						'</p></div>';
			}
		}
	
	}
	public function route() 
	{
		$uri 		= $_SERVER['REQUEST_URI'];
		$uri_parse 	= parse_url( $uri );
		$protocol 	= isset( $_SERVER['HTTPS'] ) ? 'https' : 'http';
		$hostname 	= $_SERVER['HTTP_HOST'];
		$url 		= "{$protocol}://{$hostname}{$uri}";
		$method 	= $_SERVER['REQUEST_METHOD'];
		$is_post 	= !!( $method == "POST" );
		parse_str( $_SERVER['QUERY_STRING'], $params );
		
		if( basename( $uri_parse['path'] ) == 'admin.php' && isset( $params['page'] ) && $params['page'] == 'signup_upshare_page' ) 
		{
			wp_redirect( "http://www.upshare.co/partners/wp/sign_up/", 301 ); exit;
		}
		
		if( $is_post && isset( $_REQUEST['_wpnonce'] ) ) 
		{
			if( wp_verify_nonce( $_REQUEST['_wpnonce'], 'UP Share Settings Page' . '_admin_options' ) ) 
			{
				//$this->_submit_admin_options();
			}
		}
	}
	public function my_action_callback()
	{
		update_option('upshare_notice',1);
		die(); // this is required to return a proper result
	}
	public function addStyleScripts()
	{
		wp_register_script( 'upshare-script', $this->_plugin_url . '/js/script.js');
		wp_enqueue_script( 'upshare-script' );
	
		wp_register_style( 'upshare-style', $this->_plugin_url . '/css/style.css');
		wp_enqueue_style( 'upshare-style' );
	}
	public function my_action_javascript()
	{
		?>
		<script type="text/javascript" >
		function removeNotice()
		{
			var ajaxurl = '<?php echo admin_url('admin-ajax.php'); ?>';
			// This does the ajax request
			jQuery.ajax({
				url: ajaxurl,
				data: 
				{
					'action': 'my_action',
				},
				success:function(data) 
				{
					// This outputs the result of the ajax request
					jQuery('#upshare_notice').hide();
					// alert("ajax works");
				},
				error: function(errorThrown)
				{
					console.log(errorThrown);
				}
			});
			return false;
		}
		</script>
		<?php
	}
	public function setup_theme_admin_menus()
	{
		add_menu_page(__('UP','menu-test'), __('UP','menu-test'), 'manage_options', 'upshare-settings-page', array($this, 'upshare_settings') , 
						plugins_url( 'viral-social-media-buttons-by-up/images/menu-icon2.png' ) );
		$json = $this->queryApi();
		//$partner_id = get_option("partner_id");
		$partner_id = (isset($json->partner_id) && (int)$json->partner_id > 0) ? $json->partner_id : '';
	
		if( $partner_id == "" ) 
		{
			add_submenu_page('upshare-settings-page', 'UPshare', 'Signup for UP', 'manage_options', 'signup_upshare_page', 
								array($this, 'upshare_sub_settings'));
		}
	}
	public function upshare_sub_settings()
	{
		wp_redirect( "http://www.upshare.co/partners/plugin/sign_up" );
		exit;
	}
	public function upshare_settings()
	{
		$partnerValue = false;
		// Check that the user is allowed to update options
		if (!current_user_can('manage_options'))
		{
			wp_die('You do not have sufficient permissions to access this page.');
		}
		$partner_id = '';
		
		if ( isset($_POST["update_settings"]) )
		{
			// Do the saving
			$partner_id = esc_attr($_POST["partner_id"]);
			update_option("partner_id", $partner_id);
			update_option('upshare_notice',1);
			?>
			<div id="message" class="updated"><?php _e('Settings saved'); ?></div>
			<?php
			$partnerValue = true;
		}
		//in case form not submitted
		//$partner_id = get_option("partner_id");
		//##call endpoint to get partner id
		$json = $this->queryApi();
		if( $json == null)
			$partner_id = '';
		else
		{
			$partner_id = (isset($json->partner_id) && (int)$json->partner_id > 0) ? $json->partner_id : '';
		}
		
		require_once $this->_plugin_dir . SB_DS . 'html' . SB_DS . 'admin' . SB_DS . 'settings.php';	
	}
	public function addScriptCodeToHead()
	{
		$json = $this->queryApi();
	
		$partner_id = (isset($json->partner_id) && (int)$json->partner_id > 0) ? $json->partner_id : null;
		
		if( $partner_id )
		{
			echo '<script src="//widget.upshare.co/up-load.js" id="UPWidget"></script>';
		}
		else
		{
			echo '<script src="//widget.upshare.co/up-load.js?mode=2" id="UPWidget"></script>';
		}
	}
	public function filter_the_content($content)
	{
		return '<div id="upinpost-header" style="clear:both"></div>'.$content . '<div id="upinpost-footer" style="clear:both"></div>';
	}
	protected function queryApi()
	{
		$parts = parse_url(site_url());
		$domain = $parts['host'];
		$url = 'http://partnerapi.upshare.co/partnersdomain/'.$domain;
		$res = wp_remote_get($url);
		if( is_wp_error($res) )
			return null;
		
		$json = json_decode($res['body']);
		return $json;
		
	}
}
new UP_ViralSharingSocial();
register_deactivation_hook(__FILE__, array('UP_ViralSharingSocial', 'myplugin_deactivation'));
register_activation_hook(__FILE__, array('UP_ViralSharingSocial', 'myplugin_activation'));
