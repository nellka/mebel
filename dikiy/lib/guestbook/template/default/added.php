<?php include_from_template('header.php'); ?>

<h2><?php show_entry_added_text(); ?></h2>

<script>
setTimeout(function(){ location.replace("index.php"); }, 5000);

</script>


<?php show_added_entry(); ?>
<p>
<a href="<?php show_guestbook_url(); ?>"><h2><-- Назад</h2></a>
</p>

<?php include_from_template('footer.php'); ?>