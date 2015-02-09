<?php
/****************************************************************************
 * DRBGuestbook
 * http://www.dbscripts.net/guestbook/
 * 
 * Copyright (c) 2007-2010 Don B
 ****************************************************************************/

$GUESTBOOK_URL_PATH = ".";
$DEMO_MODE = FALSE;
$SHOW_PAGE_NUMBER_NAVIGATION = FALSE;
$NAVIGATION_MAX_PAGE_NUMBERS = 10;
$DISPLAY_TIME_ZONE = "";
$PREVIOUS_TEXT = "< Prev";
$NEXT_TEXT = "Next >";
$DISPLAY_EMAIL_FIELD = TRUE;
$DISPLAY_URL_FIELD = TRUE;
$DISPLAY_COMMENT_FIELD = TRUE;
$CREDIT_LINK_REMOVAL_LICENSE = FALSE;
$ADDED_TEXT = "Your Entry has Been Added";
$PENDING_TEXT = "Your Entry Is Pending Approval";
$MODERATION_ENABLED = FALSE;
$NEW_REPLY_TEXT = 'Добавить запись';

function show_entry($entry, $idx, $showCheckbox = FALSE, $showadminfields = FALSE, $elementId = NULL) {
	global $DATE_TIME_FORMAT;
	global $NAME_FIELD_NAME;
	global $EMAIL_FIELD_NAME;
	global $URL_FIELD_NAME;
	global $COMMENTS_FIELD_NAME;
	global $ENABLE_EMAIL_FIELD;
	global $ENABLE_URL_FIELD;
	global $ENABLE_COMMENT_FIELD;

?>
<div class="entry"<?php if($elementId != NULL) { echo(" id=\"" . htmlspecialchars_default($elementId) . "\""); } ?>>
<?php
if($showCheckbox) {
?>
<p>
Выбрать: <input type="checkbox" name="id[]" value="<?php echo $entry["id"]; ?>" />
</p>

<div class="field">
<div class="label">Номер:</div>
<div class="value"><?php echo $entry["id"] ?>
<?php
	if(!$entry["approved"]) echo(' - <strong class="errorMessage">[Pending Moderation]</strong>')
?>
</div>
</div>

<?php
}
?>
<div class="field">
<div class="label"><?php echo $NAME_FIELD_NAME ?>:</div>
<div class="value"><?php echo $entry["name"] ?></div>
</div>

<?php
	global $DISPLAY_EMAIL_FIELD;
	if($ENABLE_EMAIL_FIELD === TRUE && !empty($entry["email"]) && ($showadminfields || $DISPLAY_EMAIL_FIELD) ) { 
?>

<div class="field">
<div class="label"><?php echo $EMAIL_FIELD_NAME ?>:</div>
<div class="value"><a href="mailto:<?php echo $entry["email"] ?>"><?php echo $entry["email"] ?></a></div>
</div>

<?php 
	}
	global $DISPLAY_URL_FIELD;
	if($ENABLE_URL_FIELD === TRUE && !empty($entry["url"]) && ($showadminfields || $DISPLAY_URL_FIELD) ) { 
?>

<div class="field">
<div class="label"><?php echo $URL_FIELD_NAME ?>:</div>
<div class="value"><a href="<?php echo $entry["url"] ?>" rel="nofollow"><?php echo $entry["url"] ?></a></div>
</div>

<?php 
	}
	global $DISPLAY_COMMENT_FIELD;
	if($ENABLE_COMMENT_FIELD === TRUE && !empty($entry["comments"]) && ($showadminfields || $DISPLAY_COMMENT_FIELD) ) {
?>

<div class="field">
<div class="label"><?php echo $COMMENTS_FIELD_NAME ?>:</div>
<div class="value"><?php echo str_replace(array("\r\n", "\n", "\r"), "<br />", $entry["comments"]) ?></div>
</div>

<?php 
	}
	global $DEMO_MODE;
    if($showadminfields) {
?>
<div class="field">
<div class="label">IP Адрес:</div>
<div class="value"><?php echo( ($DEMO_MODE)?'***.***.***.*** (Hidden in Demo)':htmlspecialchars_default( $entry["ipaddress"] ) ) ?></div>
</div>
<?php 
	}
	if(!empty($entry["timestamp"])) {
?>

<div class="timestamp">
<div class="value"><?php setlocale(LC_ALL, "ru_RU.UTF-8"); echo htmlspecialchars_default( strftime($DATE_TIME_FORMAT, (int)$entry["timestamp"]) ) ?></div>
</div>

<?php 
    }
	if($showCheckbox) {
?>
<div class="field">
<div class="label">Действия:</div>
<a href="index.php?<?php echo htmlspecialchars_default('id[]=' . urlencode($entry["id"]) . '&action=delete'); ?>">Удалить</a>
 | <a href="index.php?<?php echo htmlspecialchars_default('id[]=' . urlencode($entry["id"]) . '&action=delete&banip=true'); ?>">Удалить и заблокировать</a>
<?php 
		if(!$entry["approved"]) {
?>
 | <a href="index.php?<?php echo htmlspecialchars_default('id[]=' . urlencode($entry["id"]) . '&action=approve'); ?>">Approve</a>
<?php 
		}
?>
</div>
<?php 
    }
?>
</div>
<?php
    
}

function show_bans() {
	$list = ban_list();
	if($list !== FALSE) {
		foreach ($list as $bannedip) {
?>
<p>
<input type="checkbox" name="id[]" value="<?php echo htmlspecialchars_default($bannedip); ?>" /> <?php echo htmlspecialchars_default($bannedip); ?>
</p>
<?php
		}
	}
}

function show_bad_words() {
	$list = bad_word_list();
	if($list !== FALSE) {
		foreach ($list as $bad_word) {
?>
<p>
<input type="checkbox" name="id[]" value="<?php echo htmlspecialchars_default($bad_word); ?>" /> <?php echo htmlspecialchars_default($bad_word); ?>
</p>
<?php
		}
	}
}

function show_entries_start_offset() {
	if(isset($_REQUEST['offset'])) {
	 	$offset = $_REQUEST['offset'];
	 	if(!is_numeric($offset) || $offset < 0 || !preg_match('/^[0-9]+$/D', $offset)) die("Invalid offset.");
	} else {
		$offset = 0;
	}
	
	// Compare to total entry count
	$start_offset = intval($offset) + 1;
	$count = get_guestbook_entries_count(); 
	if($count < $start_offset) $start_offset = $count; 
	
	echo htmlspecialchars_default($start_offset);
}

function show_entries_end_offset() {
	global $MAX_ENTRIES_PER_PAGE;
	
	if(isset($_REQUEST['offset'])) {
	 	$offset = $_REQUEST['offset'];
	 	if(!is_numeric($offset) || $offset < 0 || !preg_match('/^[0-9]+$/D', $offset)) die("Invalid offset.");
	} else {
		$offset = 0;
	}
	
	// Compare to total entry count
	$end_offset = intval($offset) + $MAX_ENTRIES_PER_PAGE;
	$count = get_guestbook_entries_count(); 
	if($count < $end_offset) $end_offset = $count; 
	
	echo htmlspecialchars_default($end_offset);
}

function show_entries($offset = NULL, $maxcount = NULL, $showNavigaion = TRUE, $showCheckboxes = FALSE, $showadminfields = FALSE, $approvedOnly = TRUE) {
 	global $MAX_ENTRIES_PER_PAGE;
 	global $DISPLAY_TIME_ZONE;
 	
 	if($showadminfields === TRUE) $approvedOnly = FALSE;

    // Set the display time zone, if applicable
 	if(!empty($DISPLAY_TIME_ZONE)) {
 		if(function_exists("date_default_timezone_set")) {
 			@date_default_timezone_set($DISPLAY_TIME_ZONE);
 		} else {
 			putenv("TZ=" . $DISPLAY_TIME_ZONE);
 		}
 	}

    // Validate and initialize record offset
	if(!isset($offset) && isset($_REQUEST['offset'])) {
	 	$offset = $_REQUEST['offset'];
	 	if(!is_numeric($offset) || $offset < 0) die("Invalid offset.");
	} else {
		$offset = 0;
	}
	if(!isset($maxcount)) $maxcount = $MAX_ENTRIES_PER_PAGE;

	// If navigation page numbers are being used, we need 
	// the count of total entries
	global $SHOW_PAGE_NUMBER_NAVIGATION;
    if($SHOW_PAGE_NUMBER_NAVIGATION === TRUE) { 	
 		$totalEntries = get_guestbook_entries_count($approvedOnly);
    } else {
    	$totalEntries = -1;
    }
 	
 	$guestbookExists = (guestbook_open_for_read() !== FALSE);
 	
 	$count = 0;
 	if($guestbookExists) { 
 	
	 	if($offset > 0) guestbook_forward($offset);
	 	
	 	while( $count < $maxcount && ($entry = guestbook_next()) !== FALSE) {
	 		
	 		// Skip entries that are pending approval
	 		if(!$entry['approved'] && $approvedOnly) continue;
	 		
	 		// Determine element ID
	 		$elementId = NULL;
	 		if($count === 0) {
	 			if($maxcount === 1) $elementId = "onlyEntry"; else $elementId = "firstEntry"; 
	 		} else if($count === $maxcount - 1) {
	 			$elementId = "lastEntry";
	 		}
	 		
	 		show_entry($entry, $count + $offset, $showCheckboxes, $showadminfields, $elementId);
	 		
	 		$count += 1;
		}
		
 	}

	if($showNavigaion) {
		$showMaxCountInPrevNext = !$SHOW_PAGE_NUMBER_NAVIGATION;
		 	
	 	$showPrevious = ($offset > 0);
	 	$showNext = ($guestbookExists && guestbook_next() !== FALSE);
	 	
	 	echo("<div class=\"navigation\">\n");
	 	global $GUESTBOOK_URL_PATH;
	 	
	 	if($showPrevious) {
	 		global $PREVIOUS_TEXT;
	 		$previous_offset = $offset - $MAX_ENTRIES_PER_PAGE;
	 		if($previous_offset < 0) $previous_offset = 0;
	 		echo("<a href=\"" . urlencode($GUESTBOOK_URL_PATH) . "?offset={$previous_offset}\" id=\"previous\">" . htmlspecialchars_default($PREVIOUS_TEXT) . 
	 		(($showMaxCountInPrevNext)?(" " . htmlspecialchars_default($maxcount)):"") . "</a>\n");
	 	}
	 	
	 	if($SHOW_PAGE_NUMBER_NAVIGATION === TRUE && $totalEntries > $MAX_ENTRIES_PER_PAGE) {
	 		global $NAVIGATION_MAX_PAGE_NUMBERS;
	 		
	 		echo("<div class=\"pageNumberContainer\">");

			// Show page numbers	 		
	 		$pageNumberOffset = $offset - (($NAVIGATION_MAX_PAGE_NUMBERS - 1) * $MAX_ENTRIES_PER_PAGE);
	 		if($pageNumberOffset < 0) $pageNumberOffset = 0;
	 		for($pageNumberCount = 0; 
	 		    $pageNumberOffset < $totalEntries && $pageNumberCount < $NAVIGATION_MAX_PAGE_NUMBERS; 
	 			$pageNumberCount++) {

	 			$pageNumberDisplay = ($pageNumberOffset / $MAX_ENTRIES_PER_PAGE) + 1;
	 			if($pageNumberOffset != $offset) {
	 				echo("<a href=\"" . urlencode($GUESTBOOK_URL_PATH) . "?offset=" . 
	 				htmlspecialchars_default($pageNumberOffset) . "\" class=\"pageNumber\">" . 
					htmlspecialchars_default($pageNumberDisplay) . "</a>\n");
	 			} else {
	 				echo("<span class=\"pageNumber\" id=\"currentPageNumber\">" . 
	 				htmlspecialchars_default($pageNumberDisplay) . 
					"</span>\n");
	 			}
	 			$pageNumberOffset += $MAX_ENTRIES_PER_PAGE;
	 		}
	 		echo("</div>");
	 		
	 	} else {
	 	
	 		if($showPrevious && $showNext) echo " - ";
	 		
	 	}
	 	
	 	if($showNext) {
	 		global $NEXT_TEXT;
	 		$next_offset = $offset + $MAX_ENTRIES_PER_PAGE;
	 		echo("<a href=\"" . urlencode($GUESTBOOK_URL_PATH) . "?offset={$next_offset}\" id=\"next\">" . htmlspecialchars_default($NEXT_TEXT) . 
	 		(($showMaxCountInPrevNext)?(" " . htmlspecialchars_default($maxcount)):"") . "</a>\n");
	 	}
	 	
	 	echo("</div>\n");
	 	
	}
 	
 	if($guestbookExists) guestbook_close();
 	
}

function show_guestbook_url() {
	global $GUESTBOOK_URL_PATH;
	echo urlencode($GUESTBOOK_URL_PATH);
}
 
function show_guestbook_add_form($formTitle = NULL, $buttonName = NULL) {
 	global $MAX_NAME_LENGTH;
 	global $MAX_EMAIL_LENGTH;
 	global $MAX_URL_LENGTH;
	global $NAME_FIELD_NAME;
	global $EMAIL_FIELD_NAME;
	global $URL_FIELD_NAME;
	global $COMMENTS_FIELD_NAME;
	global $ADD_FORM_LEGEND;
	global $ADD_FORM_BUTTON_TEXT;
	global $CHALLENGE_STRING_LENGTH;
	global $CHALLENGE_FIELD_NAME;
	global $CHALLENGE_FIELD_PARAM_NAME;
	global $ENABLE_EMAIL_FIELD;
	global $ENABLE_URL_FIELD;
	global $ENABLE_COMMENT_FIELD;
	global $GUESTBOOK_URL_PATH;
	global $NEW_REPLY_TEXT;

	
	if(!isset($formTitle)) $formTitle = $ADD_FORM_LEGEND;
	if(!isset($buttonName)) $buttonName = $ADD_FORM_BUTTON_TEXT;

 	$ipaddress = $_SERVER['REMOTE_ADDR'];
 	if(is_banned($ipaddress)) return FALSE;
 	
	$nameValue = "";
	if(isset($_POST['name'])) $nameValue = "value=\"" . htmlspecialchars_default($_POST['name']) . "\" ";

	$emailValue = "";
	if(isset($_POST['email'])) $emailValue = "value=\"" . htmlspecialchars_default($_POST['email']) . "\" ";

	$urlValue = "";
	if(isset($_POST['url'])) $urlValue = "value=\"" . htmlspecialchars_default($_POST['url']) . "\" ";

	$commentsValue = "";
	if(isset($_POST['comments'])) $commentsValue = htmlspecialchars_default($_POST['comments']);
 	
?><br>
<div style="width: 200px; margin: auto;">
	<a id="post_new_link" href="#"><b>
		<?php echo htmlspecialchars_default($NEW_REPLY_TEXT) ?>
	</b></a>
</div>
<div id="error"><?php show_errors(); ?></div>
<form id="post_new" method="post" action="<?php echo urlencode($GUESTBOOK_URL_PATH); ?>">
<fieldset>
<?php //<legend><?_php echo htmlspecialchars_default($formTitle); ?_></legend> ?>
<p>



<label for="name"><?php echo htmlspecialchars_default($NAME_FIELD_NAME) ?>:</label>
<input type="text" name="name" id="name" maxlength="<?php echo htmlspecialchars_default($MAX_NAME_LENGTH); ?>" class="inputText" <?php echo $nameValue; ?>/>
<br />

<?php if($ENABLE_EMAIL_FIELD === TRUE) { ?>
<label for="email"><?php echo htmlspecialchars_default($EMAIL_FIELD_NAME) ?>:</label>
<input type="text" name="email" id="email" maxlength="<?php echo htmlspecialchars_default($MAX_EMAIL_LENGTH); ?>" class="inputText" <?php echo $emailValue; ?>/>
<br />
<?php } ?>
	
<?php if($ENABLE_URL_FIELD === TRUE) { ?>
<label for="url"><?php echo htmlspecialchars_default($URL_FIELD_NAME) ?>:</label>
<input type="text" name="url" id="url" maxlength="<?php echo htmlspecialchars_default($MAX_URL_LENGTH); ?>" class="inputText" <?php echo $urlValue; ?>/>
<br />
<?php } ?>

<?php if($ENABLE_COMMENT_FIELD === TRUE) { ?>
<label for="comments"><?php echo htmlspecialchars_default($COMMENTS_FIELD_NAME) ?>:</label>
<textarea name="comments" id="comments" cols="40" rows="4" class="inputTextArea">
<?php echo $commentsValue; ?>
</textarea>
<br />
<?php } ?>

<?php
	global $CHALLENGE_ENABLED;
	if($CHALLENGE_ENABLED === TRUE) {
		
		// Create the challenge string and store in the session
 		createChallengeString();
 		
?>
<label for="<?php echo htmlspecialchars_default($CHALLENGE_FIELD_PARAM_NAME); ?>"><?php echo htmlspecialchars_default($CHALLENGE_FIELD_NAME) ?>:</label>
<input type="text" name="<?php echo htmlspecialchars_default($CHALLENGE_FIELD_PARAM_NAME); ?>" id="<?php echo htmlspecialchars_default($CHALLENGE_FIELD_PARAM_NAME); ?>" maxlength="<?php echo htmlspecialchars_default($CHALLENGE_STRING_LENGTH); ?>" size="<?php echo htmlspecialchars_default($CHALLENGE_STRING_LENGTH); ?>" class="inputText" />
<img src="<?php echo urlencode($GUESTBOOK_URL_PATH); ?>?action=challengeimage" alt="Challenge Image" class="challengeImage" />
<br />
<?php
 	}
?>

</p>
<input type="hidden" name="action" value="add" />
<input type="submit" value="<?php echo htmlspecialchars_default($buttonName); ?>" class="submit" />
</fieldset>  
</form>
<?php
 	
}
 
function show_errors() {
	global $dbs_error;
	if(!empty($dbs_error)) {
		echo("<p class=\"errorMessage\">" . $dbs_error . "</p>");
	}
}

function show_entry_added_text() {
	global $MODERATION_ENABLED;
	global $ADDED_TEXT;
	global $PENDING_TEXT;
	echo htmlspecialchars_default( $MODERATION_ENABLED === TRUE ? $PENDING_TEXT : $ADDED_TEXT );
}

function show_added_entry() {
	show_entries(0, 1, FALSE, FALSE, FALSE, FALSE);
}

function show_entries_page() {

	// Send a session cookied; required for challenge-response and delay tests
	@session_start();
	
	// Store request time in session 
 	$_SESSION['dbs_req_time'] = time();
	
	include_from_template('entries.php');

}

function show_entry_count() {
	echo htmlspecialchars_default(get_guestbook_entries_count());
}
 
?>
