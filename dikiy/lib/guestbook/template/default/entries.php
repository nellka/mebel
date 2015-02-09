<?php include_from_template('header.php'); ?>

<?php show_guestbook_add_form(); ?>

<?php show_entries(); ?>

<p class="entryCount">
<b>Просмотр записей <?php show_entries_start_offset(); ?> - <?php show_entries_end_offset(); ?> 
(Всего записей: <?php show_entry_count(); ?></b>)
</p>

<?php include_from_template('footer.php'); ?>