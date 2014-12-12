<?php
/**
 * Виджет новых сообщений - "У вас 0 новых сообщений"
 */
class NewMessages extends CWidget
{
    public function run()
    {
        if (Yii::app()->user->isGuest) return;
        // выводим только количество новых сообщений для пользователя
        $messages = Message::model()->new()->countByAttributes(array('id_to' => Yii::app()->user->id));
        if ($messages) echo "($messages)";
        //$this->render('new_messages', array('messages' => $messages));
    }
}

