$(document).ready( function () {
	$("#post_new fieldset").hide();
	$("#post_new_link").click( function() {
		$("#post_new fieldset").toggle("fade", 500);
		$("#post_new_link").hide()
	});
});	
