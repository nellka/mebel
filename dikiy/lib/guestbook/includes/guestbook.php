<?php
/****************************************************************************
 * DRBGuestbook
 * http://www.dbscripts.net/guestbook/
 * 
 * Copyright (c) 2007-2010 Don B
 ****************************************************************************/

$guestbook_fp = NULL;
$MAX_BAD_WORD_LENGTH = 255;
$MIN_COMMENTS_LENGTH = 10;
$PREVENT_URLS_IN_COMMENTS = TRUE;
$ERROR_MSG_URLS_NOT_ALLOWED = "URLs are not allowed in comments.";
$ENABLE_EMAIL_FIELD = TRUE;
$ENABLE_URL_FIELD = TRUE;
$ENABLE_COMMENT_FIELD = TRUE;
$MIN_SECONDS_BETWEEN_POSTS = 120;
$ERROR_MSG_FLOOD_DETECTED = "You are attempting to post too frequently.";
$READ_ONLY_MODE = FALSE;
$MAX_WORD_LENGTH = 40;
$ERROR_MSG_MAX_WORD_LENGTH = "You attempted to use a word that was too long.";
$MIN_POST_DELAY = 5;
$MAX_POST_DELAY = 7200;
$ERROR_MSG_MIN_DELAY_STRING = "You tried to post too quickly.";
$ERROR_MSG_MAX_DELAY_STRING = "You waited too long to post.";
$MODERATION_ENABLED = FALSE;

function guestbook_file_path() {
 	global $DATA_FOLDER;
 	return dirname(__FILE__) . '/../' . $DATA_FOLDER . "/" . "guestbook.txt";
}
 
function guestbook_open_for_read() {
 	global $guestbook_fp;
 	
 	$guestbook_fp = @fopen(guestbook_file_path(), "rb");
 	if($guestbook_fp !== FALSE) {
 		if(@flock($guestbook_fp, LOCK_SH) === FALSE) {
 			guestbook_close();
 			return FALSE;
 		}
 	} 
 	return $guestbook_fp;
}
 
function guestbook_open_for_writing() {
 	global $guestbook_fp;
 	$guestbook_fp = @fopen(guestbook_file_path(), "r+b");
 	if($guestbook_fp !== FALSE) {
 		if(@flock($guestbook_fp, LOCK_EX) === TRUE) {
 			if(@ftruncate($guestbook_fp, 0) === FALSE) {
 				guestbook_close();
 				return FALSE;
 			}
 		} else {
 			guestbook_close();
 			return FALSE;
 		}
 	}
 	return $guestbook_fp;
}
 
function guestbook_forward($forward_count) {
 	global $guestbook_fp;
 	$count = 0;
 	while($count < $forward_count && !feof($guestbook_fp)) {
 		fgets($guestbook_fp);
 		$count += 1;
 	}
 	
}

function guestbook_next_id() {
	if(guestbook_open_for_read() === FALSE) {
		return 0;
	} else {
		$entry = guestbook_next();
		guestbook_close();
		if($entry === FALSE) {
			return 0;
		} else {
			return ((int)$entry['id']) + 1;
		}
	}
}

function entry_explode($raw_entry) {
	return explode('|', trim($raw_entry));
}
 
function guestbook_next() {
 	global $guestbook_fp;

	$entry_raw = fgets($guestbook_fp);
	if(feof($guestbook_fp)) {
		return FALSE;
	} else if(empty($entry_raw)) {
		return FALSE;
	} else {
		
		$entry_components = entry_explode($entry_raw);
		$entry_components = array_map('rawurldecode', $entry_components);
		$entry_components = array_map('htmlspecialchars_default', $entry_components);
		
		$entry = @Array(
			"id" => $entry_components[0],
			"name" => $entry_components[1],
			"email" => $entry_components[2],
			"url" => $entry_components[3],
			"comments" => $entry_components[4],
			"timestamp" => $entry_components[5],
			"ipaddress" => $entry_components[6],
			"approved" => (!isset($entry_components[7]) || $entry_components[7] === 'true')
		);
		return $entry;
		
	}

}

function getIdToIdxMap($entries) {
 	$id_to_idx = @Array();
 	$ent_idx = 0;
 	foreach ($entries as $entry) {
 		$id_to_idx[ $entry[0] ] = $ent_idx;
 		$ent_idx++;
 	} 
	return $id_to_idx;
}

function guestbook_entries_action($idArray, $banip = FALSE, $action) {
 	global $dbs_error;
 	global $guestbook_fp;
 	
 	// Get raw data from file
 	if(guestbook_open_for_read() === FALSE) {	// Acquires shared lock on guestbook file
 		die("Unable to open guestbook file for reading.");
 	}
 	$raw_entries = @file(guestbook_file_path());
 	guestbook_close();	// Releases shared lock 
 	if($raw_entries === FALSE) {
 		die("Unable to get entries from guestbook.");
 	}
 	
 	// Split entries into components
 	$entries = array_map('entry_explode', $raw_entries);
 	
 	// Get mapping between indices and ids
 	$id_to_idx = getIdToIdxMap($entries);
 	
 	// Remove entries by id
 	foreach ($idArray as $id) {
 		
 		// Validate ID
 		if(!isset($id_to_idx[$id])) {
 			die("Invalid entry ID.");
 		}
 		
	 	// Get array index of entry from id
	 	$idx = $id_to_idx[$id];
	 	
	 	if($idx === 0 || !empty($idx)) {

	 		$entry_components = $entries[$idx];
			$entry_components = array_map('rawurldecode', $entry_components);
	 		
			// Handle IP ban
		 	if($banip) {
		 		
		 		// Get IP address
				if(isset($entry_components[6])) {
					$ipAddress = $entry_components[6];
					
					// If not empty and not already banned, add to ban list
					if(!empty($ipAddress) && !is_banned($ipAddress)) {
						ban_add($ipAddress);
					}
				}
				
		 	}
		 	
		 	if($action === 'delete') {

			 	// Delete entry from raw entries list
			 	unset($raw_entries[$idx]);

		 	} else if($action === 'approve' && isset($entry_components[7]) && $entry_components[7] === 'false') {

		 		// Set to approved
		 		$entry_components[7] = 'true';
		 		
		 		// Reencode and set update entries array
		 		$entry_components = array_map('rawurlencode', $entry_components);
		 		$raw_entries[$idx] = implode('|', $entry_components) . "\n";
		 		
		 	} 
		 	
	 	}

 	}
 	
 	// Create flat data for file
 	$raw_entries_flat = implode("", $raw_entries);
 	unset($raw_entries); // Free memory
 	
	if(guestbook_open_for_writing() === FALSE) {
		die("Unable to open guestbook file for writing."); 
	}
	
	// Rewrite data to file
	fputs($guestbook_fp, $raw_entries_flat);
	unset($raw_entries_flat); // Free memory
 	
 	guestbook_close();
 	
 	// Update entry count
 	set_guestbook_entries_count();
 	
}

function guestbook_validate($entry) {
 	global $MAX_NAME_LENGTH;
 	global $MAX_EMAIL_LENGTH;
 	global $MAX_URL_LENGTH;
 	global $MAX_COMMENTS_LENGTH;
 	global $MIN_COMMENTS_LENGTH;
	global $NAME_FIELD_NAME;
	global $EMAIL_FIELD_NAME;
	global $URL_FIELD_NAME;
	global $COMMENTS_FIELD_NAME;
	global $ERROR_MSG_BAD_WORD;
 	global $dbs_error;
 	
 	$dbs_error = "";
 	
 	validate_notempty($entry, "name", $NAME_FIELD_NAME);
 	global $ENABLE_COMMENT_FIELD;
 	if($ENABLE_COMMENT_FIELD === TRUE) {
 		if(validate_notempty($entry, "comments", $COMMENTS_FIELD_NAME)) {
 			validate_minlength($entry, "comments", $MIN_COMMENTS_LENGTH, $COMMENTS_FIELD_NAME);
 		}
 	} else {
 		if(isset($entry["comments"])) {
 			die("Comments field is disabled.");
 		}
 	}
 	validate_length($entry, "name", $MAX_NAME_LENGTH, $NAME_FIELD_NAME);
 	validate_notags($entry, "name", $NAME_FIELD_NAME);
 	validate_length($entry, "email", $MAX_EMAIL_LENGTH, $EMAIL_FIELD_NAME);
 	validate_email($entry, "email", $EMAIL_FIELD_NAME);
 	validate_length($entry, "url", $MAX_URL_LENGTH, $URL_FIELD_NAME);
 	validate_url($entry, "url", $URL_FIELD_NAME);
 	validate_length($entry, "comments", $MAX_COMMENTS_LENGTH, $COMMENTS_FIELD_NAME);
 	validate_notags($entry, "comments", $COMMENTS_FIELD_NAME);
 	validate_max_word_length($entry, "comments", $COMMENTS_FIELD_NAME);
 	
 	if(
 		(isset($entry["name"]) && has_bad_word($entry["name"])) 
 		|| (isset($entry["comments"]) && has_bad_word($entry["comments"]))
 		|| (isset($entry["url"]) && has_bad_word($entry["url"]))
 		|| (isset($entry["email"]) && has_bad_word($entry["email"]))
 	) {
 		$dbs_error .= htmlspecialchars_default($ERROR_MSG_BAD_WORD) . '<br />';
 	}
 	
 	global $PREVENT_URLS_IN_COMMENTS;
 	if($PREVENT_URLS_IN_COMMENTS === TRUE && isset($entry["comments"]) && has_url($entry["comments"])) {
 		global $ERROR_MSG_URLS_NOT_ALLOWED;
 		$dbs_error .= htmlspecialchars_default($ERROR_MSG_URLS_NOT_ALLOWED) . '<br />';
 	}
 	
	// Challenge-response test
 	global $CHALLENGE_ENABLED;
 	if($CHALLENGE_ENABLED === TRUE) {
 		
 		// Check entered value
 		global $CHALLENGE_FIELD_PARAM_NAME;
 		$entered_challenge_value = $entry[$CHALLENGE_FIELD_PARAM_NAME];
 		if(!isChallengeAccepted($entered_challenge_value)) {
 			
 			// Android!
 			global $ERROR_MSG_BAD_CHALLENGE_STRING;
 			$dbs_error .= htmlspecialchars_default($ERROR_MSG_BAD_CHALLENGE_STRING) . '<br />';
 			
 		}
 		
 	}

 	// Time delay test
	global $MIN_POST_DELAY;
	global $MAX_POST_DELAY;
	global $ERROR_MSG_MIN_DELAY_STRING;
	global $ERROR_MSG_MAX_DELAY_STRING;
	@session_start();
	if(!isset($_SESSION['dbs_req_time'])) {
		$dbs_error .= htmlspecialchars_default($ERROR_MSG_MAX_DELAY_STRING) . '<br />';
	} else {
 		$delay = time() - $_SESSION['dbs_req_time'];
 		if($delay < $MIN_POST_DELAY) {
 			$dbs_error .= htmlspecialchars_default($ERROR_MSG_MIN_DELAY_STRING) . '<br />';
 		} else if($delay >  $MAX_POST_DELAY) {
 			$dbs_error .= htmlspecialchars_default($ERROR_MSG_MAX_DELAY_STRING) . '<br />';
 		}
 	}
 	
 	return empty($dbs_error);
}
 
function guestbook_add($entry) {
	global $READ_ONLY_MODE;
 	global $dbs_error;
 	
 	if(guestbook_validate($entry)) {
 		
 		if($READ_ONLY_MODE === TRUE) {
 			$dbs_error = htmlspecialchars_default("This guestbook is in read-only mode.");
 			return FALSE;
 		}
 	
	 	$now = gmstrftime( time() );
	 	$ipaddress = $_SERVER['REMOTE_ADDR']; 
	 	
	 	if( is_flood_detected($ipaddress) ) {
	 		global $ERROR_MSG_FLOOD_DETECTED;
			$dbs_error = htmlspecialchars_default($ERROR_MSG_FLOOD_DETECTED); 
			return FALSE;
	 	}
	 	
	 	$entry_stripped = array_map("strip_tags", $entry);
	 	$entry_encoded = array_map("rawurlencode", $entry_stripped);
	 	
	 	// Create file if it does not exist
	 	if(!file_exists(guestbook_file_path())) {
	 		if(touch(guestbook_file_path()) === FALSE) {
	 			$dbs_error = htmlspecialchars_default("Unable to create guestbook file in data folder.");
	 			return FALSE;
	 		}
	 	}
	 	
	 	// Get existing entries
 		if(guestbook_open_for_read() === FALSE) {	// Acquires shared lock on guestbook file
 			$dbs_error = htmlspecialchars_default("Unable to open guestbook file for reading.");
 			return FALSE;
	 	}
	 	$oldContents = @file_get_contents(guestbook_file_path());
	 	guestbook_close();	// Releases shared lock
	 	if($oldContents === FALSE) {
			$dbs_error = htmlspecialchars_default("Unable to get guestbook file contents."); 
			return FALSE;
	 	}
	 	
	 	$nextId = guestbook_next_id();

		if(guestbook_open_for_writing() === FALSE) {
			$dbs_error = htmlspecialchars_default("Unable to open guestbook file for writing."); 
			return FALSE;
		}
		
		// If moderation is enabled, all posts must be approved
		global $MODERATION_ENABLED;
		$approved = ($MODERATION_ENABLED !== TRUE);

		// Write new entry
	 	global $guestbook_fp;
	 	fputs($guestbook_fp,
	 		$nextId . "|" .
	 		value_or_blank($entry_encoded, 'name') . "|" . 
	 		value_or_blank($entry_encoded, 'email') . "|" . 
	 		value_or_blank($entry_encoded, 'url') . "|" . 
	 		value_or_blank($entry_encoded, 'comments') . "|" . 
	 		$now . "|" .
	 		$ipaddress . "|" .
	 		($approved?'true':'false') . 
	 		"\n"
	 	);
	 	
	 	// Append existing entries to file
	 	fputs($guestbook_fp, $oldContents);
	 	unset($oldContents);	// Free memory
	 	guestbook_close();
	 	
	 	// Update entry count
	 	set_guestbook_entries_count();
	 	
	 	// Send notification
	 	global $ADMIN_EMAIL_ADDRESS;
	 	if(isset($ADMIN_EMAIL_ADDRESS) && !empty($ADMIN_EMAIL_ADDRESS)) {
			if(mail($ADMIN_EMAIL_ADDRESS,
				($approved?"":"PLEASE MODERATE: ") . 
				"Новая запись в гостевой книге: " . 
				value_or_blank($entry_stripped, 'name'),
				($approved?"":"Пожалуйста, подтвердите или удалите запись:\n") .
				"Имя: " . value_or_blank($entry_stripped, 'name') . "\n" .
				"E-Mail: " . value_or_blank($entry_stripped, 'email') . "\n" .
				"URL-адрес: " . value_or_blank($entry_stripped, 'url') . "\n" . 
				"Комментарии: \n" . 
				value_or_blank($entry_stripped, 'comments'),
				"MIME-Version: 1.0\r\nContent-type: text/plain; charset=UTF-8\r\nFrom: " . $ADMIN_EMAIL_ADDRESS . "\r\n"
				) !== TRUE
			) {
				$dbs_error = htmlspecialchars_default("Unable to send notification.");
				return FALSE;
			}
	 	}
	 	
	 	return TRUE;
	 	
 	}
 	
 	return FALSE;
 	
} 
 
function guestbook_close() {
 	global $guestbook_fp;
 	@flock($guestbook_fp, LOCK_UN);
 	@fclose($guestbook_fp);
}

function ban_file_path() {
 	global $DATA_FOLDER;
 	return dirname(__FILE__) . '/../' . $DATA_FOLDER . "/" . "bans.txt";
}
 
function ban_list() {
	$banlist = @file(ban_file_path());
	if($banlist !== FALSE) {
		$banlist = array_map("trim", $banlist);
	}
 	return $banlist;
}

function is_banned($ipaddress) {
	$bans = ban_list();
	if($bans !== FALSE) {
		return( array_search(trim($ipaddress), $bans) !== FALSE );
	} else {
		return FALSE;
	}
}
 
function ban_add($ipaddress) {
 	$ban_fp = @fopen(ban_file_path(), "a");
 	if($ban_fp === FALSE) {
 		die("Unable to open ban file for writing");
 	}
 	@flock($ban_fp, LOCK_EX); 
 	fputs($ban_fp, $ipaddress . "\n");
 	@flock($ban_fp, LOCK_UN);
 	@fclose($ban_fp);
}

function unban($ipAddressArray) {

 	// Remove bans by id
	$bans = ban_list();
	if($bans !== FALSE) {

		// Remove ip addresses from ban list
	 	foreach ($ipAddressArray as $ipaddress) {
	 		
			$idx = array_search(trim($ipaddress), $bans);
			if($idx !== FALSE) {
				unset($bans[$idx]);
			} else {
				die("An invalid IP address was specified.");
			}
	 		
	 	}
	 	
	 	// Create flat data for file
	 	$raw_bans_flat = implode("\n", $bans);
	 	if(!empty($raw_bans_flat)) $raw_bans_flat .= "\n"; 
	
		// Rewrite data to file 	
	 	$ban_fp = @fopen(ban_file_path(), "w");
	 	if($ban_fp === FALSE) {
	 		die("Unable to open ban file for writing.");
	 	}
		@flock($ban_fp, LOCK_EX);
		fputs($ban_fp, $raw_bans_flat);
		@flock($ban_fp, LOCK_UN);
		@fclose($ban_fp);
		
	} else {
		die("Unable to get list of current bans.");
	}

}

function bad_word_file_path() {
 	global $DATA_FOLDER;
 	return dirname(__FILE__) . '/../' . $DATA_FOLDER . "/" . "bad_words.txt";
}
 
function bad_word_list() {
	$bad_word_list = @file(bad_word_file_path());
	if($bad_word_list !== FALSE) {
		$bad_word_list = array_map("trim", $bad_word_list);
	}
 	return $bad_word_list;
}

function is_bad_word($word) {
	$bad_words = bad_word_list();
	if($bad_words !== FALSE) {
		return( array_casesearch(trim($word), $bad_words) !== FALSE );
	} else {
		return FALSE;
	}
}

function has_url($text) {
	if(preg_match('/http:|https:|ftp:/i', $text)) {
		return TRUE;
	} else {
		return FALSE;
	}
}

function has_bad_word($text) {
	$bad_words = bad_word_list();
	
    if($bad_words !== FALSE) {
	 	foreach ($bad_words as $bad_word) {
	 		/* if(preg_match('/(\b|[^A-Za-z0-9])' . $bad_word . '(\b|[^A-Za-z0-9])/i', $text)) { */
	 		 if(preg_match('/(\b|[^a-z,A-Z,0-9,а-я,А-Я,\t])' . $bad_word . '(\b|[^a-z,A-Z,0-9,а-я,А-Я,\t])/i', $text)) { 
	 			return TRUE;
	 		}
	 	}
    }
	 	
	return FALSE;
}
 
function bad_word_add($word) {
	global $MAX_BAD_WORD_LENGTH;
	if($word === NULL || strlen($word) === 0) {
		return FALSE;
	}
	if(strlen($word) > $MAX_BAD_WORD_LENGTH) {
		die("That word is too long.");
	}
	if(is_bad_word($word)) {
		return FALSE;
	}
 	$bad_word_fp = @fopen(bad_word_file_path(), "a");
 	if($bad_word_fp === FALSE) {
 		die("Unable to open bad word file for writing");
 	}
 	@flock($bad_word_fp, LOCK_EX); 
 	fputs($bad_word_fp, $word . "\n");
 	@flock($bad_word_fp, LOCK_UN);
 	@fclose($bad_word_fp);
}

function remove_bad_word($wordArray) {

 	// Remove bad_words by id
	$bad_words = bad_word_list();
	if($bad_words !== FALSE) {

		// Remove words from bad word list
	 	foreach ($wordArray as $word) {
	 		
			$idx = array_search(trim($word), $bad_words);
			if($idx !== FALSE) {
				unset($bad_words[$idx]);
			} else {
				die("An invalid bad word was specified.");
			}
	 		
	 	}
	 	
	 	// Create flat data for file
	 	$raw_bad_words_flat = implode("\n", $bad_words);
	 	if(!empty($raw_bad_words_flat)) $raw_bad_words_flat .= "\n";
	
		// Rewrite data to file 	
	 	$bad_word_fp = @fopen(bad_word_file_path(), "w");
	 	if($bad_word_fp === FALSE) {
	 		die("Unable to open bad word file for writing.");
	 	}
		@flock($bad_word_fp, LOCK_EX);
		fputs($bad_word_fp, $raw_bad_words_flat);
		@flock($bad_word_fp, LOCK_UN);
		@fclose($bad_word_fp);
		
	} else {
		die("Unable to get list of current bad words.");
	}

}

function is_flood_detected($ipaddress) {
	global $MIN_SECONDS_BETWEEN_POSTS;
	if($MIN_SECONDS_BETWEEN_POSTS <= 0) return FALSE;
 	$timestamp_threshold = time() - $MIN_SECONDS_BETWEEN_POSTS;
	$guestbookExists = (guestbook_open_for_read() !== FALSE); 	
 	if($guestbookExists) {

		// Iterate through entries that occured after flood threshold 		
 		while( ($entry = guestbook_next()) !== FALSE &&
 		intval($entry["timestamp"]) >= $timestamp_threshold) {
 			
 			if($entry["ipaddress"] === $ipaddress) {
 				guestbook_close();  
 				return TRUE; 
 			}
 			
 		}
 		
 		guestbook_close(); 
 	}
	
	return FALSE;
}

function guestbook_summary_file_path() {
 	global $DATA_FOLDER;
 	return dirname(__FILE__) . '/../' . $DATA_FOLDER . "/" . "guestbook_summary.txt";
}

$guestbook_approved_entries_count = -1;
$guestbook_total_entries_count = -1;

function get_guestbook_entries_count($approvedOnly = TRUE) {
	global $guestbook_approved_entries_count;
	global $guestbook_total_entries_count;
	
	// Has count already been loaded?
	if($guestbook_approved_entries_count < 0 || $guestbook_total_entries_count < 0) {

		// Load existing
		$summarylist = @file(guestbook_summary_file_path());
		if($summarylist !== FALSE && isset($summarylist[0]) && isset($summarylist[1])) {
			// Cache the count
			$guestbook_approved_entries_count = intval($summarylist[0]);
			$guestbook_total_entries_count = intval($summarylist[1]);
		} else {
			// Create summary and refresh counts
			set_guestbook_entries_count();
		}
		
	}
	return ($approvedOnly?$guestbook_approved_entries_count:$guestbook_total_entries_count);

}

function set_guestbook_entries_count() {
 	global $guestbook_approved_entries_count;
 	global $guestbook_total_entries_count;
 	$guestbook_approved_entries_count = 0;
 	$guestbook_total_entries_count = 0;
 	
 	// Get raw data from file
 	if(guestbook_open_for_read() === FALSE) {	// Acquires shared lock on guestbook file
 		return 0;
 	}
 	$raw_entries = @file(guestbook_file_path());
 	guestbook_close();	// Releases shared lock 
 	if($raw_entries === FALSE) {
 		return 0;
 	}
 	
 	// Split entries into components
 	$entries = array_map('entry_explode', $raw_entries);
 	
 	// Count entries
 	$approvedCount = 0;
 	$totalCount = 0;
 	foreach ($entries as $entry) {
 		if(!isset($entry[7]) || $entry[7] === 'true') $approvedCount++; // Approved entries count
 		$totalCount++; // Total entries count
 	}

	// Open/create summary file
 	$summary_fp = @fopen(guestbook_summary_file_path(), "w");
 	if($summary_fp === FALSE) {
 		die("Unable to open summary file for writing");
 	}
 	@flock($summary_fp, LOCK_EX);
 	fputs($summary_fp, $approvedCount . "\n");
 	fputs($summary_fp, $totalCount . "\n");
 	@flock($summary_fp, LOCK_UN);
 	fclose($summary_fp);
 	
 	// Update cached count
 	$guestbook_approved_entries_count = $approvedCount;
 	$guestbook_total_entries_count = $totalCount;
 	
}

?>
