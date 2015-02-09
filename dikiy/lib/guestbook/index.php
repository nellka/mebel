<?php
/****************************************************************************
 * DRBGuestbook
 * http://www.dbscripts.net/guestbook/
 * 
 * This file is the controller script for DRBGuestbook.
 * 
 * IMPORTANT: Do not output any content directly from this file; doing so
 * may break the components of this script that need to send HTTP headers 
 * and binary content.  Customizations to the HTML should only be made via the 
 * files in the "themes" folder.  Also, do not copy and paste the contents 
 * of this script into the middle of another script; it probably won't work
 * for the reasons stated above.
 * 
 * Copyright (c) 2007-2010 Don B
 ****************************************************************************/

 
$base_url = "./";
require_once(dirname(__FILE__) . '/includes/utils.php');
require_once(dirname(__FILE__) . '/includes/challenge.php');
require_once(dirname(__FILE__) . '/includes/guestbook.php');
require_once(dirname(__FILE__) . '/includes/views.php');
require_once(dirname(__FILE__) . '/config.php');
require_once(dirname(__FILE__) . '/strings.php');

// Confirm that application is fully installed
confirm_install();

// Handle actions
if(isset( $_GET["action"] )) {
	
	$action = $_GET["action"];
	
	switch($action) {
		
		case "challengeimage":
			outputChallengeImage();
			break;
		
		default:
			die("Invalid request.");
			break;
		
	}
	
} else if(isset( $_POST["action"] )) {
	
	$action = $_POST["action"];
	
	switch($action) {
		
		case "add":
		
			// Undo magic_quotes
			if(get_magic_quotes_gpc()) {
				$_POST = stripslashes_recursive($_POST);
			}
		
			if(!is_banned($_SERVER['REMOTE_ADDR']) && guestbook_add($_POST)) {
				include_from_template('added.php');
			} else {
				show_entries_page();
			}
			break;
			
		default:
			
			show_entries_page();
			break;
		
	}
	
} else {

	show_entries_page();
	
}

?>
