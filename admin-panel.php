<?php
if ( !function_exists('add_action') ) :
  header('Status: 403 Forbidden');
  header('HTTP/1.1 403 Forbidden');
  exit();
endif;

?>

<div class="wrap">
		<div id="icon-options-general" class="icon32">
<br/>
</div>
<h2><?php echo __('Custom settings', 'wp-custom-setting'); ?></h2>
<?php echo $msg; ?>
<form method="post" action="<?php echo $_SERVER['REQUEST_URI']; ?>">

<?php
    wp_nonce_field( $this->plugin_nonce, $this->plugin_nonce . '_nonce' );
?>	

<table id="form-table-key">
  <tr>
    <th>
       <?php echo __('Key', 'wp-custom-setting'); ?>
     </th>
     <th>				 
		<?php echo __('Value', 'wp-custom-setting'); ?>
     </th>
     <th>&nbsp;
       				 
     </th>
  </tr>
<?php
if ($custom_pages == '') {
  echo $this->wp_custom_setting_html_page('', -1);
} else {
  foreach($custom_pages as $k=>$v) {  
    echo $this->wp_custom_setting_html_page($k, $v);
  }
}
?>  
</table>
<a id="morekeyval" class="moreval dashicons-before dashicons-plus-alt" href="#" rel="form-table-key"><span><?php echo __('Add', 'wp-custom-setting'); ?></span></a>

<br />
<br />

<table id="form-table-val">
  <tr>
    <th>
       <?php echo __('Key', 'wp-custom-setting'); ?>
     </th>
     <th>				 
		<?php echo __('Value', 'wp-custom-setting'); ?>
     </th>
     <th>&nbsp;
       				 
     </th>
  </tr>

<?php
if ($custom_data == '') {
  echo $this->wp_custom_setting_html_value('', '');
} else {
  foreach($custom_data as $k=>$v) {  
    echo $this->wp_custom_setting_html_value($k, $v);
  }
}
?>

</table>
<a id="morekeyval" class="moreval dashicons-before dashicons-plus-alt" href="#" rel="form-table-val"><span><?php echo __('Add', 'wp-custom-setting'); ?></span></a>


<p class="submit">
  <input id="submit" class="button button-primary" type="submit" value="<?php echo esc_attr(__('Save Changes')); ?>" name="submit">
</p>

</form>


</div>
