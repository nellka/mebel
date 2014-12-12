<? if ($messages>0) { ?>
У вас <?php echo CHtml::link($messages.' новых',array('/anketa/messages', 'id'=>$messages[0]->id_from)) ?>
сообщений
<? } else {
echo CHtml::link('Новых сообщений нет',array('/anketa/messages', 'id'=>$messages[0]->id_from));
 } ?>