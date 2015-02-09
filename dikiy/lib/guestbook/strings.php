<?php
/****************************************************************************
 * DRBGuestbook
 *
 * LANG cfg also in inclides/views.php
 ****************************************************************************/

// Field names
$NAME_FIELD_NAME = 'Имя';
$EMAIL_FIELD_NAME = 'E-Mail';
$URL_FIELD_NAME = 'Сайт';
$COMMENTS_FIELD_NAME = 'Комментарии';
$CHALLENGE_FIELD_NAME = "Введите код";

// Navigation text
$PREVIOUS_TEXT = "< Пред.";
$NEXT_TEXT = "След. >";

// Form text
$ADD_FORM_LEGEND = 'Оставить Запись';
$ADD_FORM_BUTTON_TEXT = 'Добавить';

// Displayed after an entry is submitted
$ADDED_TEXT = "Ваша запись была добавлена";
$PENDING_TEXT = "Ваша запись была отправлена";

// Error text
// The %s directive is a placeholder for the field name and length.
// Use argument swapping if you need to change the order; 
// See http://us.php.net/sprintf for more details.
$ERROR_MSG_BAD_WORD = 'Ошибка в поле комментарии: ссылки / ненормативная лексика запрещены.';
$ERROR_MSG_MAX_LENGTH = 'Поле %s имеет лимит в %s знаков.';
$ERROR_MSG_MIN_LENGTH = 'Поле %s слишком короткое.';
$ERROR_MSG_REQUIRED = 'Поле %s является обязательным.';
$ERROR_MSG_EMAIL = 'Поле %s имеет неправильный формат.';
$ERROR_MSG_URL_INVALID = 'Поле %s имеет неправильный формат.';
$ERROR_MSG_URL_BAD_PROTOCOL = 'Разрешены только HTTP ссылки.';
$ERROR_MSG_TAGS_NOT_ALLOWED = 'HTML запрещен.';
$ERROR_MSG_BAD_CHALLENGE_STRING = "Неправильный код подтверждения.";
$ERROR_MSG_URLS_NOT_ALLOWED = "Ссылки в комментариях запрещены.";
$ERROR_MSG_FLOOD_DETECTED = "Слишком много отправленных сообщений за последние 5 минут.";
$ERROR_MSG_MAX_WORD_LENGTH = "Ошибка в поле 'Комментарии'.";
$ERROR_MSG_MIN_DELAY_STRING = "Слишком много отправленных сообщений за последние 5 минут.";
$ERROR_MSG_MAX_DELAY_STRING = "Таймаут страницы.";

/* 
// Field names
$NAME_FIELD_NAME = 'Name';
$EMAIL_FIELD_NAME = 'E-Mail Address';
$URL_FIELD_NAME = 'Website URL';
$COMMENTS_FIELD_NAME = 'Comments';
$CHALLENGE_FIELD_NAME = "Enter Code";

// Navigation text
$PREVIOUS_TEXT = "< Prev";
$NEXT_TEXT = "Next >";

// Form text
$ADD_FORM_LEGEND = 'Sign Guestbook';
$ADD_FORM_BUTTON_TEXT = 'Add';

// Displayed after an entry is submitted
$ADDED_TEXT = "Your Entry Has Been Added";
$PENDING_TEXT = "Your Entry Is Pending Approval";

// Error text
// The %s directive is a placeholder for the field name and length.
// Use argument swapping if you need to change the order; 
// See http://us.php.net/sprintf for more details.
$ERROR_MSG_BAD_WORD = 'You entered a bad word.';
$ERROR_MSG_MAX_LENGTH = 'The %s field cannot accept values over %s characters in length.';
$ERROR_MSG_MIN_LENGTH = 'The %s field cannot accept values less than %s characters in length.';
$ERROR_MSG_REQUIRED = 'The %s field is required.';
$ERROR_MSG_EMAIL = 'The %s entered is not valid.';
$ERROR_MSG_URL_INVALID = 'The %s entered is not valid.';
$ERROR_MSG_URL_BAD_PROTOCOL = 'Only HTTP URLs are valid.';
$ERROR_MSG_TAGS_NOT_ALLOWED = 'HTML is not allowed.';
$ERROR_MSG_BAD_CHALLENGE_STRING = "The code was not correct.";
$ERROR_MSG_URLS_NOT_ALLOWED = "URLs are not allowed in comments.";
$ERROR_MSG_FLOOD_DETECTED = "You are attempting to post too frequently.";
$ERROR_MSG_MAX_WORD_LENGTH = "You attempted to use a word that was too long.";
$ERROR_MSG_MIN_DELAY_STRING = "You tried to post too quickly.";
$ERROR_MSG_MAX_DELAY_STRING = "You waited too long to post.";
 */
?>
