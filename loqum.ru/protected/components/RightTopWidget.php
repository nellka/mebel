<?php

class RightTopWidget extends CWidget
{
    public $anketa;


    public function init(){
        parent::init();
        if (empty($this->anketa))
            $this->anketa = Yii::app()->user->me;
        if ($this->anketa->getTop() && ($this->anketa->top_end->time_task - time()<0)) {
            $task = $this->anketa->top_end;
            Yii::log('Task '.$task->type.'|untop Anketa '.$task->id_user.'|'.Yii::app()->user->id
                .' Controller:'.$this->controller->id
                .' '.date('d.m.Y H:i:s',$task->time_task),'info','payment');
        };
//        if ($this->anketa->getPremium() && ($this->anketa->premium_end->time_task - time()<0)) {
//            $task = $this->anketa->premium_end;
//            Yii::log('Task '.$task->type.'|unpremium Anketa '.$task->id_user.'|'.Yii::app()->user->id.' '.date('d.m.Y H:i:s',$task->time_task),'info','payment');
//        };
    }

    public function run()
    {
        return;
        $this->render('rightTopWidget',array('anketa'=>$this->anketa));
    }
}