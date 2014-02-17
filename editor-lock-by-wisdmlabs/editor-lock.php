<?php
/*
  Plugin Name: Wordpress Editor Lock
  Plugin URI:  http://wordpress.org/extend/plugins/editor-lock-by-wisdmlabs/
  Description: Editor Lock is a plugin which allows WordPress administrator, selectively restrict other administrator users from accessing the WordPress theme and plugin editors.
  Author: WisdmLabs, Thane, India
  Author URI:http://wisdmlabs.com
  License: GPLv2 or later
  Version: 1.5
  Network: true
 */
/**
 * The plugin methods will not be changed until a new release of wordpress.
 * @api
 * @author WisdmLabs, Thane, India
 * @copyright 2012-2013 WisdmLabs
 * @license GPL
 * @license http://opensource.org/licenses/gpl-license.php GNU Public License
 */

 function is_wisdm_editor_lock_plugin_screen() {  
       if ($_GET['page'] == 'editor-lock-by-wisdmlabs/editor-lock.php' && is_admin()) {
          return true;  
       } else {  
          return false;  
       }  
}

add_action('admin_enqueue_scripts', 'wisdm_editor_lock_plugin_scripts');

function wisdm_editor_lock_plugin_scripts()
{
   if(is_wisdm_editor_lock_plugin_screen())
    wp_enqueue_style('wdm_editor_lock_css', plugins_url('style.css', __FILE__));
}

global $wisdm_current_logged_in_user_id;

add_action('init', 'user_id_of_logged_in_user');
function user_id_of_logged_in_user()
{
  global $wisdm_current_logged_in_user_id;
  $wisdm_current_logged_in_user_id = get_current_user_id();
  global $elbw_itr;
  
  
  /**
  * Function to add a new option name, 'elbw_locked_users' to the options database table.  
  * @return string Assigns a blank string to variable 'elbw_locked_users' 
  */
  add_option('elbw_locked_users');
  add_option('elbw_maintain_logs');
  // Code to remove the names from the Block List starts here -->
  
  $elbw_message = '';
  $matched = array();
  foreach ($_POST as $key => $value)
  {
      $elbw_message .= $key . ' ' . $value . '    ';
  }
  $elbw_demo_array = explode(',', get_option('elbw_locked_users'));
  
  foreach ($elbw_demo_array as $elbw_paramName)
  {
      if (!empty($elbw_paramName))
      {
	  $elbw_assignit = str_replace(' ', '', $elbw_paramName) . '_x';
	  $elbw_pos = strpos($elbw_message, $elbw_assignit);
  
	  if ($elbw_pos !== FALSE)
	  {
	      $elbw_message = '';
	      $elbw_replace_string = get_option('elbw_locked_users');
	      $elbw_temp_string = ',' . $elbw_paramName;
	      $elbw_cutomized = str_replace($elbw_temp_string, '', $elbw_replace_string);
	      delete_option('elbw_locked_users');
	      add_option('elbw_locked_users', $elbw_cutomized);
	      preg_match('/[0-9]*[^\(\x20\)]/', $elbw_paramName, $matched);
	      $str1 = 'User ' . '<strong>' . get_user_meta($matched[0], 'nickname', true) . '</strong>';
	      $str2 = ' was <strong> removed </strong> from blocklist by ';
	      $str3 = '<strong>' . get_user_meta(get_current_user_id(), 'nickname', true) . '</strong>';
	      update_option('elbw_maintain_logs', date('l jS \of F Y h:i:s A') . '  UTC  ---' . ' <strong>   Info : </strong> ' . $str1 . $str2 . $str3 . ',' . get_option('elbw_maintain_logs'));
	      //echo get_option( 'elbw_maintain_logs' );
	  }
	  $elbw_assignit = '';
      }
  }
  //Code to remove the names from the Block List ends here -->
  
  /**
  * This function adds a user in the block list    
  * @param string $_POST['elbw_submit']  It is a value obtained from the form
  * @return string Adds a username into the database option 'elbw_locked_users'
  */
  if (isset($_POST['elbw_delete_logs']) && $_POST['elbw_delete_logs'] = 'Clear Logs')
  {
      delete_option('elbw_maintain_logs');
      add_option('elbw_maintain_logs');
  }
  
  
  
  if (isset($_POST['elbw_submit']) && $_POST['elbw_submit'] == 'Block')
  {
      $elbw_itr = $_POST['elbw_getadmins'];
      if ($elbw_itr != 1 && $elbw_itr != 'none')
      {
	  $elbw_user_info = '(' . $elbw_itr . ')';
  
	  if (strpos(get_option('elbw_locked_users'), $elbw_user_info) === FALSE)
	  {
	      update_option('elbw_locked_users', get_option('elbw_locked_users') . ',' . $elbw_user_info);
	      $str1 = 'User ' . '<strong>' . get_user_meta($elbw_itr, 'nickname', true) . '</strong>';
	      $str2 = ' was <strong> added </strong> to blocklist by ';
	      $str3 = '<strong>' . get_user_meta(get_current_user_id(), 'nickname', true) . '</strong>';
	      update_option('elbw_maintain_logs', date('l jS \of F Y h:i:s A') . '  UTC  ---' . ' <strong>   Info : </strong> ' . $str1 . $str2 . $str3 . ',' . get_option('elbw_maintain_logs'));
	  }
      }
  }
}

function selfURL()
{
    $s = empty($_SERVER["HTTPS"]) ? '' : ($_SERVER["HTTPS"] == "on") ? "s" : "";
    $protocol = strleft(strtolower($_SERVER["SERVER_PROTOCOL"]), "/") . $s;
    $port = ($_SERVER["SERVER_PORT"] == "80") ? "" : (":" . $_SERVER["SERVER_PORT"]);
    return $protocol . "://" . $_SERVER['SERVER_NAME'] . $port . $_SERVER['REQUEST_URI'];
}

function strleft($s1, $s2)
{
    return substr($s1, 0, strpos($s1, $s2));
}


/**
 * These hooks defines that while deactivating or uninstalling the plugin, database option 'elbw_locked_users' should be deleted.
 */
register_uninstall_hook(__FILE__, 'elbw_deactivate');

/**
 * Hook for Hiding Plugin Editor and Theme Editor 
 */
add_action('admin_menu', 'elbw_my_remove_menu_elements', 102);
add_action('admin_init', 'elbw_my_remove_menu_elements', 102);
add_action('delete_user', 'elbw_cannot_delete');

/**
 * This Function Creates a Setting Menu
 */
add_action('admin_menu', 'elbw_baw_create_menu');

/**
 * Function to be called while deactivating or uninstalling the plugin. It would Delete the 'elbw_locked_users' option from the database.
 */
function elbw_deactivate()
{
    delete_option('elbw_locked_users');
    delete_option('elbw_maintain_logs');
}

// Function to Remove Editing Access from the selected Administrators STARTS here -->
function elbw_my_remove_menu_elements()
{
    global $wisdm_current_logged_in_user_id;
    //$elbw_current_user = wp_get_current_user();
    $elbw_temp = '(' . $wisdm_current_logged_in_user_id . ')';
    if (strpos(get_option('elbw_locked_users'), $elbw_temp) !== FALSE)
    {
	remove_submenu_page('plugins.php', 'plugin-editor.php');
	remove_submenu_page('themes.php', 'theme-editor.php');
	//add_action( 'edit_user_profile', 'elbw_cannot_delete' );
	$elbw_pages = array('theme-editor.php', 'plugin-editor.php');
	foreach ($elbw_pages as $elbw_page)
	{
	    if (strpos($_SERVER['PHP_SELF'], $elbw_page))
	    {
		$str1 = 'User ' . '<strong>' . get_user_meta(get_current_user_id(), 'nickname', true) . '</strong>';
		$str2 = ' tried to access the following forbidden page :  <a href="' . selfURL() . '"> <strong>' . selfURL() . '</strong> </a>';
		update_option('elbw_maintain_logs', date('l jS \of F Y h:i:s A') . '  UTC  ---' . ' <strong>   Alert : </strong> ' . $str1 . $str2 . ',' . get_option('elbw_maintain_logs'));
		wp_die(__('Page disabled by the administrator. </br> </br> This activity has been logged!'));
	    }
	}
	add_action('delete_user', 'elbw_cannot_delete');
	add_filter('plugin_action_links', 'elbw_disable_plugin_deactivation', 10, 4);
    }
}

// Function to Remove Editing Access from the selected Administrators ENDS here -->

/**
 * This function prevents the user in the blocklist from deleting any other user
 * @return string Die Message
 */
function elbw_cannot_delete()
{
    $check_if_admin = '&user=1&';
    $check_if_admin = strpos(selfURL(), $check_if_admin);
    if ($check_if_admin !== FALSE)
    {
	$str1 = 'User ' . '<strong>' . get_user_meta(get_current_user_id(), 'nickname', true) . '</strong>';
	$str2 = ' tried to delete the Main Administrator :  <strong>' . get_user_meta(1, 'nickname', true) . '</strong>';
	update_option('elbw_maintain_logs', date('l jS \of F Y h:i:s A') . '  UTC  ---' . ' <strong>   Alert : </strong> ' . $str1 . $str2 . ',' . get_option('elbw_maintain_logs'));
	wp_die(__('Sorry! You are not allowed to delete <strong> ' . get_user_meta(1, 'nickname', true) . ' </strong> </br>' . 'This activity has been logged!'));
    }
}

/**
 * This function disables 'Deactivate' Link for the blocked users 
 */
function elbw_disable_plugin_deactivation($actions, $plugin_file)
{

    // Remove deactivate link for  plugin
    if (array_key_exists('deactivate', $actions) && in_array($plugin_file, array('editor-lock-by-wisdmlabs/editor-lock.php')))
	unset($actions['deactivate']);
    return $actions;
}


function block_newly_created_user($user_id)
{
    global $wisdm_current_logged_in_user_id;
    //$elbw_current_user = wp_get_current_user();
    $elbw_temp = '(' . $wisdm_current_logged_in_user_id . ')';
    $elbw_temp = strpos(get_option('elbw_locked_users'), $elbw_temp);
    global $wpdb;
    if ($elbw_temp !== FALSE)
    {
	$elbw_user_info = '(' . $user_id . ')';
	if (strpos(get_option('elbw_locked_users'), $elbw_user_info) === FALSE)
	{
	    update_option('elbw_locked_users', get_option('elbw_locked_users') . ',' . $elbw_user_info);
	    $str1 = 'User ' . '<strong>' . get_user_meta($user_id, 'nickname', true) . '</strong>';
	    $str2 = ' was <strong> created </strong> by blocklisted Admin ';
	    $str3 = '<strong>' . get_user_meta(get_current_user_id(), 'nickname', true) . '</strong>. Therefore this new user is automatically blocked from accessing editors.';
	    update_option('elbw_maintain_logs', date('l jS \of F Y h:i:s A') . '  UTC  ---' . ' <strong>   Info : </strong> ' . $str1 . $str2 . $str3 . ',' . get_option('elbw_maintain_logs'));
	}
    }
    
}
add_action( 'user_register', 'block_newly_created_user');
/**
 * Function to create a settings page for the users who are not blocked
 */
function elbw_baw_create_menu()
{
    //$elbw_current_user = wp_get_current_user();
    global $wisdm_current_logged_in_user_id;
    $elbw_temp = '(' . $wisdm_current_logged_in_user_id . ')';

    $elbw_temp = strpos(get_option('elbw_locked_users'), $elbw_temp);


    if ($elbw_temp === FALSE)
    {
	$myicon = plugins_url() . "/editor-lock-by-wisdmlabs/images/icon.png";
	//create new top-level menu
	add_menu_page('Editor Lock Settings', 'Editor Lock', 'administrator', __FILE__, 'elbw_baw_settings_page', $myicon);

	//call register settings function
	add_action('admin_menu', 'elbw_register_mysettings');
    }
}

/**
 * This function register the settings
 */
function elbw_register_mysettings()
{
    register_setting('elbw_baw-settings-group', 'elbw_locked_users');
}

//Editor Lock Settings Page STARTS Here -->

function elbw_baw_settings_page()
{
    global $wpdb;
    $elbw_array_of_admins = array();
    global $elbw_fetch_database;
    global $wpdb;
    $elbw_fetch_database = $wpdb->get_var("SELECT * FROM `{$wpdb->prefix}usermeta` ORDER BY `user_id` DESC", 1);
    while ($elbw_fetch_database >= 2)
    {
	$elbw_search_admins = get_user_meta($elbw_fetch_database, "{$wpdb->prefix}user_level", true);
	if ($elbw_search_admins == 10)
	{
	    $elbw_array_of_admins[] = $elbw_fetch_database;
	}
	$elbw_fetch_database = $elbw_fetch_database - 1;
    }
    ?> 
<!--wrap starts here-->
    <div class="wrap wdm_leftwrap">
      
	 <h3 class="hndle" style="cursor: default"><span>WordPress Editor Lock Settings</span></h3>
	 <div class="inside">
        <form method='post' action="" id="wdm-editor-lock-settings-form">
    	<table class="form-table" WIDTH="100%">
	 <tbody>
	    <tr>
    	      <th style="width: 53%;">
    		Select the Administrator user to be blocked from accessing the editors :
	      </th>
	      <td>
	      <select name='elbw_getadmins' id="admindropdown">
	       <option value="none">None</option>
			<?php
			//Displaying All Administrators in the Drop-Down List
			foreach ($elbw_array_of_admins as $elbw_get_user_name)
			{
			    if ($elbw_get_user_name != get_current_user_id())
			    {
			      if (strpos(get_option('elbw_locked_users', ''), '('.$elbw_get_user_name.')') === false) { ?>
	    		    <option value='<?php echo $elbw_get_user_name; ?>'>
				    <?php echo get_user_meta($elbw_get_user_name, 'nickname', true); ?>
	    		    </option> 
			    <?php }}
			}
			?>
    		</select> 
    		<span class='submit'> <input class='wdm-block-button' onclick="if(document.getElementById('admindropdown').value != 'none') return confirm('Are you sure you want to block this user from accessing Plugin-Editor and Theme-Editor?'); else return false;" type='submit' name='elbw_submit' value= 'Block' /> </span>
    	    </td>
	    </tr>
	  <?php
	  $elbw_temp_array = array_filter(explode(',', get_option('elbw_locked_users', '')));
	  if(!empty($elbw_temp_array))
	  {
	    foreach($elbw_temp_array as $single_elbw_element)
	    {
		  preg_match('/[0-9]*[^\(\x20\)]/', $single_elbw_element, $temporary_array);
		  if(get_user_by('id', $temporary_array[0]) == false)
		  {
			$key = array_search($single_elbw_element, $elbw_temp_array);
			unset($elbw_temp_array[$key]);
			update_option('elbw_locked_users', implode(",", $elbw_temp_array));
		  }
	    }
	  }
	  if(!empty($elbw_temp_array))
	  {?>
    	   <tr>
	    <th>
    		List of blocked users :
    	    </th>
	   </tr>
	   <tr>
	    <td colspan="2">
	       <?php
		    /**
		     * Displaying the list of Blocked Users
		     */
		    $matched = array();
		   //print_r($elbw_temp_array); ?>
		  <ul style="position: relative" class="blockedpeople">
		     <?php
		    foreach ($elbw_temp_array as $elbw_paramName)
		    {
			if (!empty($elbw_paramName))
			{
			    preg_match('/[0-9]*[^\(\x20\)]/', $elbw_paramName, $matched);
			    ?>
			  
			   <li id="blockedlist">
			    <?php $blockedusername = get_user_meta($matched[0], 'nickname', true); if(!empty($blockedusername))
			    {
			      echo $blockedusername; ?>
			      <input class="wdm-unblock-blocked-user" type='image' onclick="return confirm('Are you sure you want to allow this user to access Plugin-Editor and Theme-Editor?');" name='<?php echo str_replace(' ', '', $elbw_paramName); ?>' src='<?php echo plugins_url('/images/cross.gif', __FILE__)?>'/>
			      <div class="div1" style="display: none;"></div>
		     <?php } ?>
			   </li>
			 
	    		
			<?php }
		    } ?>
		    </ul>

	    </td>
	   </tr>
	   <?php
	   } ?>
	 </tbody>
	</table>
        </form>
      </div> <!--inside ends-->
    </div> <!--wrap ends here-->
    <?php
	    $plugin_data  = get_plugin_data(__FILE__);
	    $plugin_name = $plugin_data['Name'];
	    $wdm_plugin_slug = 'editor-lock-by-wisdmlabs';
      
	    include_once('wisdm_sidebar/wisdm_sidebar.php');
	    edit_lock_sidebar($plugin_name, $wdm_plugin_slug);
      ?>
    
    <!--script for tool tip-->
    <script>
jQuery(document).ready(function($){
 jQuery('.wdm-unblock-blocked-user').hover(
function(){
  jQuery(this).parent('li').find(".div1").fadeIn();
 },
 function(){
  jQuery(this).parent('li').find(".div1").fadeOut();
 })
});
</script>
    <!--script for tool tip ends-->
    
      <?php
      $elbw_temp_array = explode(',', get_option('elbw_maintain_logs'));
      $elbw_temp_array = array_filter(array_slice($elbw_temp_array, 0, 20));
      if (!empty($elbw_temp_array))
      { ?>
      <div class="wdm-recent-activities">
    	<h3 id="title-recent-activities">Recent Activities : </h3>
	    <?php
	    foreach ($elbw_temp_array as $elbw_paramName)
	    {
		  if (strpos($elbw_paramName, 'Alert :') !== FALSE)
		  {
		    ?> <div class="wdm-alertlink" style=""> <?php echo $elbw_paramName; ?> </div> <?php
		  }
		  else
		  {
		    ?> <div class="wdm-activities-info"> <?php echo $elbw_paramName; ?> </div> <?php
		  }
	    } ?> 
        </div>
	 <?php if (get_current_user_id() == 1)
	 { ?>
	    <div style="margin-top:2%; margin-bottom: 3%;">
	       <form method="post">
		  <span>
		     <input  class="button-primary" onclick="return confirm('Are you sure that you want to delete logs ?');" type='submit' name='elbw_delete_logs' value= 'Clear Logs' />
		  </span>
	       </form>
	    </div> <?php
	 }
      }
      
}////Editor Lock Settings Page ENDS Here -->

function editor_lock_appeal_notice()
{
    if((isset($_REQUEST['page']) && $_REQUEST['page'] == 'editor-lock-by-wisdmlabs/editor-lock.php') && (!empty($_POST)))
    {
	$wdm_plugin_slug = 'editor-lock-by-wisdmlabs';
    
	?>
    
	<div class="wdm_appeal_text" style="background-color:#FFE698;padding:10px;margin-right:10px;">
	    <strong>An Appeal:</strong>
	    We strive hard to bring you useful, high quality plugins for FREE and to provide prompt responses to all your support queries.
	    If you are happy with our work, please consider making a good faith donation, here -
	    <a href="https://www.paypal.com/cgi-bin/webscr?cmd=_donations&business=info%40wisdmlabs%2ecom&lc=US&item_name=WisdmLabs%20Plugin%20Donation&no_note=0&currency_code=USD&bn=PP%2dDonationsBF%3abtn_donateCC_LG%2egif%3aNonHostedGuest" target="_blank"> Donate now</a> 
	    and do post an encouraging review, here - <a href="http://wordpress.org/support/view/plugin-reviews/<?php echo $wdm_plugin_slug; ?>" target="_blank"> Review this plugin</a>.
	</div>
    
	<?php
    }
}
add_action('admin_notices', 'editor_lock_appeal_notice');
?>