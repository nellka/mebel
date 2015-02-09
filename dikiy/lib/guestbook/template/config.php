<?php
/****************************************************************************
 * DRBGuestbook
 * http://www.dbscripts.net/guestbook/
 * 
 * Copyright (c) 2007-2010 Don B
 ****************************************************************************/
 
// Field min/max lengths
$MAX_NAME_LENGTH = 128;
$MAX_EMAIL_LENGTH = 256;
$MAX_URL_LENGTH = 512;
$MIN_COMMENTS_LENGTH = 5;
$MAX_COMMENTS_LENGTH = 8192;

// Field enabled status.  Set to FALSE to remove field from the sign guestbook 
// form and the current entries section.
$ENABLE_EMAIL_FIELD = TRUE;
$ENABLE_URL_FIELD = FALSE;
$ENABLE_COMMENT_FIELD = TRUE;

// Field display status.  Set to FALSE to remove field from the current 
// entries section.  Entered values will only be viewable to the guestbook 
// owner via the administration panel.  This setting is ignored if the field 
// is disabled above. 
$DISPLAY_EMAIL_FIELD = TRUE;
$DISPLAY_URL_FIELD = TRUE;
$DISPLAY_COMMENT_FIELD = TRUE;

// Template Name
//     Corresponds to the name of a subfolder under the "template" subfolder 
//     containing a valid HTML/XHTML template.
$TEMPLATE_NAME = "default";

// Site Name
//     Change this to match the name of your site.
$SITE_TITLE = "Guestbook";

// Admin login configuration
//     Change this to whatever you want the admin login to be.
$ADMIN_USERNAME = "admin";
$ADMIN_PASSWORD = "pass";

// Admin e-mail address
//     Change this to the e-mail address to send notifications to.
//     If left blank, notifications will not be sent.
$ADMIN_EMAIL_ADDRESS = ""; // !!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!

// Folder where guestbook data files will be stored 
$DATA_FOLDER = "data";

// Name of the subfolder where the administration panel is located.
// Change this if you decide to rename the admin folder.
$ADMIN_FOLDER = "admin";

// Max entries to display per page.
$MAX_ENTRIES_PER_PAGE = 10;

// Shows page numbers in the navigation controls
$SHOW_PAGE_NUMBER_NAVIGATION = TRUE;

// Date/Time format
//     Format string used for date/time display.  For format string syntax,
//     see: http://php.net/strftime
$DATE_TIME_FORMAT = "%A, %B %d %Y - %I:%M %p";

// Time Zone
//     Time Zone used for displaying times, e.g.: "America/New_York"  
//     Leave blank to use the server default.  For a list of valid values, 
//     see: http://us.php.net/timezones
$DISPLAY_TIME_ZONE = "";

// Moderation enabled.
//     Set to TRUE to require all posts to be approved before they are 
//     displayed.  Posts can be approved via the administration panel.
//     Set to FALSE to disable moderation; all posts will display immediately.
$MODERATION_ENABLED = FALSE;

// Challenge-response test for spam prevention
//     Set to FALSE if GD library is not installed/enabled
$CHALLENGE_ENABLED = FALSE;

// Minumum post delay
//     The minimum amount of time, in seconds, that must elapse between the  
//     time a user requests the page and the time that they attempt to post a 
//     new guestbook entry.  Intended as an anti-spam measure.
$MIN_POST_DELAY = 4;

// Maximum post delay
//     The maximum amount of time, in seconds, that may elapse between the  
//     time a user requests the page and the time that they attempt to post a 
//     new guestbook entry.  Intended as an anti-spam measure.
$MAX_POST_DELAY = 7200;

// Prevents URLs from appearing in comments, as an anti-spam measure
$PREVENT_URLS_IN_COMMENTS = TRUE;

// Flood protection setting; forces users to wait the specified number of 
// seconds before adding another post.  Setting this to zero effectively
// disables flood protection.
$MIN_SECONDS_BETWEEN_POSTS = 120;

// Maximum word length.  Prevents users from using extremely long words
// in their posts. 
$MAX_WORD_LENGTH = 40;

// Path to the main guestbook page.  This value will be used when 
// constructing URLs for links and forms on the guestbook page.    
// Change this value if the main guestbook file will be named something other
// than index.php. 
$GUESTBOOK_URL_PATH = "index.php";

?>