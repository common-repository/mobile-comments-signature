<?php
/*
Plugin Name: Mobile Comments Signature
Plugin URI: http://blogingenuity.com/2009/06/01/mobile-comments-signature-a-plugin/
Description: Detects comments made from a mobile browser and appends a signature notification.
Author: Adam Sechrest
Version: 1.0
Author URI: http://blogingenuity.com
*/

/*  Copyright 2009 Adam Sechrest  (email : admin@blogingenuity.com)

    This program is free software; you can redistribute it and/or modify
    it under the terms of the GNU General Public License as published by
    the Free Software Foundation; either version 2 of the License, or
    (at your option) any later version.

    This program is distributed in the hope that it will be useful,
    but WITHOUT ANY WARRANTY; without even the implied warranty of
    MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
    GNU General Public License for more details.

    You should have received a copy of the GNU General Public License
    along with this program; if not, write to the Free Software
    Foundation, Inc., 51 Franklin St, Fifth Floor, Boston, MA  02110-1301  USA
*/

/*
 *		TO DO LIST
 *	* Convert to external CSS file
 *	* Add more dynamic CSS options - User-defined background color, etc.
 *	* Add option to change HEX color of separator line
 *	* 
 *	*
 *	*
 *
 */

// For security, prevent from loading PHP file directly
if(!empty($_SERVER['SCRIPT_FILENAME']) && 'mobile-comments-signature.php' == basename($_SERVER['SCRIPT_FILENAME'])) die ('Please do not load this page directly. Thanks!');

/*
 *  MAIN FUNCTION
 *  Sets variables, pulls comment agent, detects if mobile, appends comment signature text
 *
 *  @PARAM string $content
 *  @RETURN mixed $content
 *
 */
function mobilesig ($content) {

	// Global variables
	global $comment;							//WP global that holds the comment text

	// Variables
	$is_mobile = false;							//Is a mobile user agent?
	$do_append = get_option('mobsig_append'); 				//Options page selection used as on/off switch
	$text_content = get_option('mobsig_text');				//Signature text for comments posted from mobile
	$mobilesig_comment_agent = strtolower($comment->comment_agent);		//Determine comment user agent and store as lowercase
	$op = strtolower($_SERVER['HTTP_X_OPERAMINI_PHONE']);			//Detect if Opera Mini, store as lowercase
	$ac = strtolower($_SERVER['HTTP_ACCEPT']);				//To detect if MIME type for some WAP mobile browsers, store as lowercase

	// Check if user has test option selected, if so, set debug to true
	if(get_option('mobsig_test'))
		$debug = true;
	else
		$debug = false;		

	//Fake a mobile user agent for live site testing purposes. Notice "SONY" in the string below.
	if ($debug) {$mobilesig_comment_agent = strtolower('lkjasdlkjfoiuef netpanas SONY ttt DDD ff');}
	
	//MOBILE BROWSER DETECTION SCRIPT
	// "!==" OPERATOR TAKES PRECENDENCE. See http://www.php.net/manual/en/language.operators.comparison.php
	//EVALUATES TO TRUE OR FALSE (1+ OR 0) AND ASSIGNS TO $is_mobile
	//Adapted from script by Russell Beattie @ http://www.russellbeattie.com/blog/mobile-browser-detection-in-php (found by t31os)
	$is_mobile = strpos($ac, 'application/vnd.wap.xhtml+xml') !== false 
	        || $op != '' 
	        || strpos($mobilesig_comment_agent, 'sony') !== false  
	        || strpos($mobilesig_comment_agent, 'symbian') !== false  
	        || strpos($mobilesig_comment_agent, 'nokia') !== false  
	        || strpos($mobilesig_comment_agent, 'samsung') !== false  
	        || strpos($mobilesig_comment_agent, 'mobile') !== false 
	        || strpos($mobilesig_comment_agent, 'windows ce') !== false 
	        || strpos($mobilesig_comment_agent, 'epoc') !== false 
	        || strpos($mobilesig_comment_agent, 'opera mini') !== false 
	        || strpos($mobilesig_comment_agent, 'nitro') !== false 
	        || strpos($mobilesig_comment_agent, 'j2me') !== false 
	        || strpos($mobilesig_comment_agent, 'midp-') !== false 
	        || strpos($mobilesig_comment_agent, 'cldc-') !== false 
	        || strpos($mobilesig_comment_agent, 'netfront') !== false 
	        || strpos($mobilesig_comment_agent, 'mot') !== false 
	        || strpos($mobilesig_comment_agent, 'up.browser') !== false 
	        || strpos($mobilesig_comment_agent, 'up.link') !== false 
	        || strpos($mobilesig_comment_agent, 'audiovox') !== false 
	        || strpos($mobilesig_comment_agent, 'blackberry') !== false 
	        || strpos($mobilesig_comment_agent, 'ericsson,') !== false 
	        || strpos($mobilesig_comment_agent, 'panasonic') !== false 
	        || strpos($mobilesig_comment_agent, 'philips') !== false 
	        || strpos($mobilesig_comment_agent, 'sanyo') !== false 
	        || strpos($mobilesig_comment_agent, 'sharp') !== false 
	        || strpos($mobilesig_comment_agent, 'sie-') !== false 
	        || strpos($mobilesig_comment_agent, 'portalmmm') !== false 
	        || strpos($mobilesig_comment_agent, 'blazer') !== false 
	        || strpos($mobilesig_comment_agent, 'avantgo') !== false 
	        || strpos($mobilesig_comment_agent, 'danger') !== false 
	        || strpos($mobilesig_comment_agent, 'palm') !== false 
	        || strpos($mobilesig_comment_agent, 'series60') !== false 
	        || strpos($mobilesig_comment_agent, 'palmsource') !== false 
	        || strpos($mobilesig_comment_agent, 'pocketpc') !== false 
	        || strpos($mobilesig_comment_agent, 'smartphone') !== false 
	        || strpos($mobilesig_comment_agent, 'rover') !== false 
	        || strpos($mobilesig_comment_agent, 'ipaq') !== false 
	        || strpos($mobilesig_comment_agent, 'au-mic,') !== false 
	        || strpos($mobilesig_comment_agent, 'alcatel') !== false 
	        || strpos($mobilesig_comment_agent, 'ericy') !== false 
	        || strpos($mobilesig_comment_agent, 'up.link') !== false 
	        || strpos($mobilesig_comment_agent, 'vodafone/') !== false 
	        || strpos($mobilesig_comment_agent, 'wap1.') !== false 
	        || strpos($mobilesig_comment_agent, 'wap2.') !== false;
	
	
	//If we detect a mobile agent and user has option selected to append comment signature, then do so.  Else return comment text unaltered.
	if ($is_mobile && get_option('mobsig_append')) {
		return $content . '<p style="border-top: 1px solid #000; margin: 30px 0 0 0; padding: 2px 0 0 0; text-align: ' . get_option('mobsig_align') . ';"><small>' . $text_content . '</small></p>';
	}
	else {
		return $content;
	}
} //end function mobilesig

/*
 *  ADD OPTIONS MENU
 *  Displays sub-menu under Settings if user is of user level 8 or higher
 *
 */
function mobilesig_options_menu() {
	if (function_exists('current_user_can')) {
		if (!current_user_can('manage_options')) return;
	} else {
		global $user_level;
		get_currentuserinfo();
		if ($user_level < 8) return;
	}
	if (function_exists('add_options_page')) {
		add_options_page('Mobile Comment Signature', 'MobileSig', 8, __FILE__, 'mobilesig_options_page');
	}
}


/*
 *  ADD OPTIONS PAGE
 *
 */
function mobilesig_options_page () {
	
		
	$mobilesig_version = '1.0';
	
	// If user presses submit button, update options
	// Note: update_option() function creates the option if it does not exist
	if(isset($_POST['mobsig_submit'])) {
		update_option('mobsig_append', $_POST['mobsig_append']);		//Append signature?
		update_option('mobsig_text', $_POST['mobsig_text']);			//Changed text?
		update_option('mobsig_test', $_POST['mobsig_test']);			//Test on live site?
		update_option('mobsig_align', $_POST['mobsig_align']);			//Align left/center/right?
		update_option('mobsig_separate', $_POST['mobsig_separate']);		//Separate from comment text by a line?
		$mobsig_updated = true;							//Have options been updated?
	}
		
?>

	<div class="wrap">
		<form id="options_form" method="post" action="">
    			<?php if($mobsig_updated == true) print '<div id="message" class="updated fade"><p>Options Saved!</p></div>'; ?>
    			<h2>Mobile Comment Signature v<?php echo $mobilesig_version; ?> - Options</h2><hr/>
			<div id="options_page_content">
			<div id="author" style="float:right; border:1px solid #000; background:white; width:165px; height: 190px; margin:20px 5px 0 0; padding:5px;">
				<span style="border-bottom:1px solid #eee; font-weight:bold;">
					<small>Mobile Comment Signature</small>
				</span>
				<p style="line-height:1em;"><small>This plugin was developed by Adam Sechrest @ <a href="http://blogingenuity.com">Blog Ingenuity.</a></small></p>
				<p style="line-height:1em;"><small>For questions, comments, feature requests, and bug reports, please visit <a href="http://blogingenuity.com/2009/06/01/mobile-comments-signature-a-plugin/">the plugin page</a>.</small></p>
				<p style="line-height:1em;"><small>If you found this plugin useful, please consider <a href="https://www.paypal.com/cgi-bin/webscr?cmd=_donations&business=sechrest%2eadam%40gmail%2ecom&lc=US&item_name=Blog%20Ingenuity&currency_code=USD&bn=PP%2dDonationsBF%3abtn_donate_SM%2egif%3aNonHosted">donating.</a></small></p>
			</div>
   				<table width="400" cellspacing="15">
   					<tr>
   				        	<td align="left">
   				        		<label for="mobsig_append"><strong>Append text to comments?</strong></label>
   				        	</td>
   				                <td align="right"> 
                         				<input type="checkbox" id="mobsig_append" name="mobsig_append" value="1"<?php if(get_option('mobsig_append')) echo ' checked="checked"'; ?>/> 
                         			</td>
                         		</tr>
                         		<br/>
                         		<tr>
                         			<td align="left">
                         				<label for="mobsig_separate"><strong>Separate signature from comment text with a line?</strong></label><br/>
                         			</td>
                         			<td align="right">
                         				<input type="checkbox" id="mobsig_separate" name="mobsig_separate" value="1"<?php if(get_option('mobsig_separate')) echo ' checked="checked"'; ?>/>
                         			</td>
                         		</tr>
                         		<br/>
                         		<tr>
                         			<td align="left">
                         				<label for="mobsig_test"><strong>Test comment signature?</strong></label><br/>
                         				<small>(Will simulate a mobile and append signature text to all comments for live site testing.)</small>
                         			</td>
                         			<td align="right">
                         				<input type="checkbox" id="mobsig_test" name="mobsig_test" value="1"<?php if(get_option('mobsig_test')) echo ' checked="checked"'; ?>/>
                         			</td>
                         		</tr>
                         		<br/>
                         		<tr>
                         			<td align="left">
                         				<label for="mobsig_align"><strong>Align signature text:</strong></label>
                         			<td>
                         			<td align="left">
                         				<select name="mobsig_align" id="mobsig_align" style="width:125px;">
								<option value="left"<?php if(get_option('mobsig_align') == 'left' || get_option('mobsig_align') == "") { echo ' selected="selected"';} ?>>Left (default)</option>
								<option value="center"<?php if(get_option('mobsig_align') == 'center') { echo ' selected="selected"';} ?>>Center</option>
								<option value="right"<?php if(get_option('mobsig_align') == 'right') { echo ' selected="selected"';} ?>>Right</option>
							</select>
                         			</td>
                         		
                         		</tr>
                         	</table>
                         	<br/>
                        </div><br/><br/>
                       	<div>
				<label for="mobsig_text"><strong>Text entered into the box below will be appended to comments made from a mobile phone:</strong></label>                        				
				<p><input type="text" id="mobsig_text" name="mobsig_text" size="100" maxlength="100" value="<?php echo get_option('mobsig_text'); ?>"></p>
                        	<p><small>Note: Light HTML may be used, such as &lt;em&gt;, &lt;strong&gt;, and &lt;strike&gt;. Do not forget to close your tags.</small></p>
                        </div><br/><br/>
                        <div>
                        	<h3>Preview:</h3>
				<div style="border: 2px solid #000; width:450px; padding:5px; overflow:hidden;">
				<div style="float: right;"><?php echo get_avatar(1,$size='55',$default='<path_to_url>'); ?></div>
				<p><em>Comment content...</em></p>
				<p><em>Comment content...</em></p>
				<p><em>Comment content...</em></p>
				<p style="<?php if(get_option('mobsig_separate') && get_option('mobsig_append')) echo 'border-top: 1px solid #000; '; ?>margin: 20px 0 0 0; padding: 2px 0 0 0; text-align: <?php echo get_option('mobsig_align'); ?>;"><small><?php if(get_option('mobsig_append')) echo get_option('mobsig_text'); ?></small></p><br/>	
                        </div>
                        <div class="submit"><input type="submit" name="mobsig_submit" id="mobsig_submit" value="Update Options &raquo;" /></div>
		</form>  
	</div>  

<?php } //end function mobilesig_options_page

/*
 * ADD FILTERS AND ACTIONS
 *
 */
// Add filter to comments
add_filter('comment_text', 'mobilesig');

// Add the admin menu
add_action('admin_menu', 'mobilesig_options_menu');

?>