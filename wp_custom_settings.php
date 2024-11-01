<?php
/*
Plugin Name: WP Custom Settings
Plugin URI: 
Description: Define additional settings
Version: 1.0
Author: Sevy29
Author URI: 
*/


if ( !function_exists('add_action') ) :
	header('Status: 403 Forbidden');
	header('HTTP/1.1 403 Forbidden');
	exit();
endif;




class wp_custom_setting {
	
  var $dir;
  var $path;
  var $plugin_nonce;

  function __construct() {
  
    $this->dir = dirname( plugin_basename(__FILE__) );
	$this->path = plugins_url();
	$this->plugin_nonce = 'wpcustomsetting';

	load_plugin_textdomain( 'wp-custom-setting', false, $this->dir . '/languages/' );

    add_action( 'admin_menu', array(&$this, 'wp_custom_option_tab') ); 

	//load css
	add_action( 'admin_head', array($this, 'wp_custom_setting_css') );

	//load js
	add_action( 'admin_enqueue_scripts', array($this, 'wp_custom_setting_js') );

  }



  function wp_custom_setting_js() {
	wp_register_script('wp_custom_setting-admin', $this->path . '/' . $this->dir . '/js/admin.js', array(), '1.0');
	wp_enqueue_script('wp_custom_setting-admin');
  }


  function wp_custom_setting_css() {
	echo '<link rel="stylesheet" type="text/css" media="all" href="' . $this->path . '/' . $this->dir .'/css/admin.css" />' . "\n";
  }


  function wp_custom_option_tab() {
  	add_options_page( __( 'Custom options', 'wp-custom-setting' ), __( 'Custom options', 'wp-custom-setting' ), 'manage_options', 'custom_options_setting', array($this, 'wp_custom_setting_panel'));
  }


  function wp_custom_setting_panel() {
	  

	if (isset($_POST[$this->plugin_nonce . '_nonce'])) {

	  if ( !wp_verify_nonce( $_POST[$this->plugin_nonce . '_nonce'], $this->plugin_nonce ) ) {
		return;
	  }
	

	  if (isset($_POST['key'])) {
	  
		$key = $_POST['key'];
		$val = $_POST['val'];
		$keyAsso = array();
		
		foreach($key as $i => $n) {
		  if ($n != '') {
			$keyAsso[$n] = $val[$i]; 
		  }
		}
	  
		if (count($keyAsso) == 0) {
		  $keyAsso = '';
		}
	  
		update_option('custom_pages', maybe_serialize($keyAsso));
	  
	  }
	  
	  
	  if (isset($_POST['key2'])) {
	  
	    
	  
		$key = $_POST['key2'];
		$val = $_POST['val2'];
		$keyAsso = array();
		
		foreach($key as $i => $n) {
		  if ($n != '') {
			$keyAsso[$n] = $val[$i]; 
		  }
		}
	  
		if (count($keyAsso) == 0) {
		  $keyAsso = '';
		}
				
		update_option('custom_data', maybe_serialize($keyAsso));
	  
	  }
	  
	  
	  update_option('custom_version', date('YmdHis'));
	
	  $msg = '<div id="message" class="updated below-h2"><p>' . __('Custom Options successffully updated','wp-custom-setting') . '</p></div>';	  

	}
	
	$custom_pages = maybe_unserialize(get_option('custom_pages'));
	$custom_data = maybe_unserialize(get_option('custom_data'));

	include_once( 'admin-panel.php' );
	
  }




  function wp_custom_setting_html_page($k, $v) {
	
	return '
	  <tr class="tr_clone">
		<td>
		   <input name="key[]" type="text" value="' . trim(esc_attr($k)) . '" class="regular-text" />
		 </td>
		 <td>				 
		   <select name="val[]">
			 <option value=""></option>
			 ' . apply_filters( 'cpt_dropdown', walk_page_dropdown_tree( get_pages(array("depth" => 0)), "0", array("depth" => 0, "child_of" => 0,"selected" => $v ) ) ) . '
		   </select>
		 </td>
		 <td>				 
			<a class="lesskeyval dashicons-before dashicons-dismiss" href="#"><span>' . __('Delete', 'wp-custom-setting') . '</span></a>
		 </td>
	  </tr>
	';

  }


  function wp_custom_setting_html_value($k, $v) {
	
	return '
	  <tr class="tr_clone">
		<td>
		   <input name="key2[]" type="text" value="' . trim(esc_attr($k)) . '" class="regular-text" />
		 </td>
		 <td>				 
		   <input name="val2[]" type="text" value="' . trim(esc_attr($v)) . '" class="regular-text" />
		 </td>
		 <td>				 
			<a class="lesskeyval dashicons-before dashicons-dismiss" href="#"><span>' . __('Delete', 'wp-custom-setting') . '</span></a>
		 </td>
	  </tr>
	';

  }



	
}

$wp_custom_setting = new wp_custom_setting();


function sevy_wcs_custom_HeaderVersion() {
  return get_option('custom_version');	
}

function sevy_wcs_custom_ArrayKey() {
  return maybe_unserialize(get_option('custom_pages'));
}


function sevy_wcs_custom_ListKey($key) {
  $arrayKey = sevy_wcs_custom_ArrayKey();
  return @$arrayKey[(string) $key];
}


function sevy_wcs_custom_ListKeyReverse($id) {
  $arrayKey = array_flip(sevy_wcs_custom_ArrayKey());  
  return @$arrayKey[$id];
}




function sevy_wcs_custom_ArrayData() {
  return maybe_unserialize(get_option('custom_data'));
}

function sevy_wcs_custom_ListData($key) {
  $arrayKey = sevy_wcs_custom_ArrayData();
  return @$arrayKey[(string) $key];
}

function sevy_wcs_custom_ListDataReverse($id) {
  $arrayKey = array_flip(sevy_wcs_custom_ArrayData());  
  return @$arrayKey[$id];
}

?>