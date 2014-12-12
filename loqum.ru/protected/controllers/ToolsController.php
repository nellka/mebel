<?php
class ToolsController extends Controller
{
    public function actionSendNotify(){
        $this->sendNotify();
    }

    public function beforeAction(){
        return true;
    }

    /**
     * отправка уведомления о непрочтённых и неуведомлённых сообщениях
     * нефейковым пользователям
     * через час (3600 c) после отправки сообщения
     *
     * Галочки Работают раздельно. Т.е. пользователь может получать как оба уведомления, так и только
    часть.

    Письмо отправляем через 3 часа после получения сообщений, если пользователь за это
    время не заходил.
     * # поправить на через 15 минут.
    Если сообщений не было, но были просмотры – через сутки.

    Если не было ни того, ни того – ничего не отправляй.
    UPDATE `anketa` SET last_visit = UNIX_TIMESTAMP()-3600*33 WHERE 4933233 = id
    UPDATE message set viewed = 0, notified = 0 where id = 4034;
    UPDATE stat_viewed set  notified = 0 WHERE 15645 = id
     */
    public function sendNotify(){
        $id = 0;
        $cmds = array();
        $visitors_count = $new_messages = 0;

        $qMsg = '
SELECT id_to,count(m.id) as cnt FROM `message` m
INNER JOIN anketa a ON id_to = a.id
WHERE m.notified=0 and m.viewed = 0 and m.deleted = 0 AND (m.id_to >  	503778 )
AND a.n_msg = 1 AND a.isdeleted = 0 AND a.last_visit < UNIX_TIMESTAMP()- 15*60
GROUP BY id_to
ORDER BY id_to DESC
LIMIT 0,1
'; //ORDER BY 4933233 <> id_to
        $qMsgUpd = 'UPDATE message SET notified = :time1 WHERE id_to = :id_user AND datestamp < :time';
        $qVwdUpd = 'UPDATE stat_viewed SET notified = :time1 WHERE id_viewed=:id_user AND datestamp < :time';

        $msgCmd = Yii::app()->db->createCommand($qMsg);

        $msgRes = $msgCmd->queryRow();
        //$msgRes = false;

        if ($msgRes ) {
            $id = $msgRes['id_to'];
            $new_messages = $msgRes['cnt'];
            $where = ' AND a.id = '.$id; // если есть msg все просмотры юзера подсчитываем
            print_r ($msgRes);
            $cmds[] = Yii::app()->db->createCommand($qMsgUpd);
        } else $where = 'AND a.last_visit < UNIX_TIMESTAMP()-3600*24'; // иначе - только старше суток

        $qVwd = '
SELECT id_viewed, count(vw.id) as `cnt` FROM `stat_viewed` vw FORCE INDEX (viewed_notified) LEFT JOIN
anketa a ON a.id = vw.id_viewed AND a.isdeleted=0
WHERE notified = 0 AND (id_viewed > 503778)
 AND a.n_vwd = 1 AND vw.`datestamp` > a.last_visit  '
. $where        .' GROUP BY id_viewed
LIMIT 0,1';
echo "*"; //ORDER BY !(4933233 = id_viewed)

        $vwdCmd = Yii::app()->db->createCommand($qVwd);
        if ($vwdRes = $vwdCmd->queryRow()) {
            $id = $vwdRes['id_viewed'];
            $visitors_count = $vwdRes['cnt'];
            print_r ($vwdRes);
            $cmds[] = Yii::app()->db->createCommand($qVwdUpd);
        }
        echo "~~";
        echo $id;
//        die();

        if (!empty ($id)) {
            header('Refresh: 70');
            $stat = compact('new_messages', 'visitors_count');
            //if (($id !=4932797) && ($id != 4933233)) die('test not id');
            if (!$anketa = Anketa::model()->findByPk($id)) {
                Yii::log('Anketa for notifying not found '.$id,CLogger::LEVEL_ERROR,'notify');
                die ('!anketa');
            }
            $email = Yii::app()->email;
            $email->view = 'notify_activity';
            $email->viewVars = compact('anketa','stat');
            $email->subject = 'Уведомление с '.$anketa->last_site;
            $email->from = 'noreply@'.$anketa->last_site; //Yii::app()->params['noreplyEmail'];
            $email->to = $anketa->email;
//            $email->bcc = 'ilevchunets@gmail.com';//,petr@penzev.ru
            $email->send();

            $params = array(':id_user'=>$id,':time'=>time(),':time1'=>time());
            foreach ($cmds as $cmd) {
                $cmd->execute($params);
            }
            echo '0k';
        }
    }

    public function actionRefreshOnline(){
        Anketa::updateOnline();
    }

    public function actionTest1(){

/*
+,4932981
,4932995
,4933005
,4933036



,4932994
,4933021
,4933049
,4933048
+,4933112


,4933050
,4933045
,4933034
,4933025

*/
        //$models = Anketa::model()->findAll('id BETWEEN 4932795 AND 4932947');
        $models = array();
        $time = time();
        foreach ($models as $model) {
            //$model->setTop(1);
            $model->last_visit = $time - rand(1600, 3600 * 48*30);
            $model->isinactive = 1;
            //$model->setTaskTimer('untop',7*24*3600);
            $model->saveAttributes(array('last_visit', 'isinactive'));
            echo $model->id, ' ';
        }
    }

    public function actionUntop($id = 0){
        $id = (int)$id;
        if ($anketa = Anketa::model()->findByPk($id)) {
        $anketa->setTop(0);
//        print_r ($anketa->attributes);
        $anketa->savePriority();
            echo 1;
        }
    }

    public function actionCheckTop(){

        if ($task = Task::model()->delayed()->find()) {
            $task->goTask();
            Yii::log('Task '.$task->type.' Anketa '.$task->id_user.' '.date('d.m.Y H:i:s',$task->time_task),'info','payment');
        } else echo ';';



    }

}
/*

ALTER TABLE `anketa` ADD `balance` INT NOT NULL DEFAULT '0' AFTER `last_notify` ,
ADD `priority` INT NOT NULL DEFAULT '0' AFTER `balance` ,
ADD `options` VARCHAR( 1000 ) NOT NULL AFTER `priority` ;
ALTER TABLE `anketa` ADD `flags` INT UNSIGNED NOT NULL AFTER `options` ;


CREATE TABLE `btransaction` (
 `id` bigint(20) NOT NULL AUTO_INCREMENT,
 `id_user` bigint(20) NOT NULL,
 `id_operation` int(11) NOT NULL,
 `amount` int(11) NOT NULL,
 `amount_real` int(11) NOT NULL,
 `time_start` int(11) NOT NULL,
 `time_end` int(11) NOT NULL,
 `src` varchar(10) DEFAULT NULL,
 `info` varchar(1022) DEFAULT NULL,
 `status` tinyint(4) NOT NULL,
 PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
ALTER TABLE `btransaction` ADD `description` VARCHAR( 250 ) NOT NULL AFTER `info` ;

CREATE TABLE `order` (
 `id` bigint(20) NOT NULL AUTO_INCREMENT,
 `id_user` bigint(20) NOT NULL,
 `id_service` int(11) NOT NULL,
 `amount` int(11) NOT NULL,
 `amount_real` int(11) NOT NULL,
 `time_start` int(11) NOT NULL,
 `time_end` int(11) NOT NULL,
 `src` varchar(10) DEFAULT NULL,
 `info` varchar(1022) DEFAULT NULL,
 `status` tinyint(4) NOT NULL,
 PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;


CREATE TABLE `task` (
 `id` bigint(20) NOT NULL AUTO_INCREMENT,
 `id_user` bigint(20) NOT NULL,
 `type` varchar(55) NOT NULL,
 `time_task` int(11) NOT NULL,
 `data` varchar(500) NOT NULL,
 `status` tinyint(1) NOT NULL DEFAULT '1',
 PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

INSERT INTO `task` (id_user, type,time_task,data,status)
VALUES (:id_user,:type,:time_task+UNIX_TIMESTAMP(),:data,:status)
ON DUPLICATE KEY UPDATE
SET time_task = time_task + :time_task,status=:status;

ALTER TABLE `task` ADD UNIQUE (
`id_user` ,
`type`
);

-- проверка  priority < чем оплата подъёма анкеты
SELECT *
FROM `btransaction` bt
INNER JOIN anketa a ON a.id = bt.id_USER
WHERE bt.amount = -100
AND a.priority < bt.time_start
LIMIT 0 , 30


--
UPDATE anketa_tm1 set priority = 1e10 + first_visit;
SELECT * FROM btransaction b INNER JOIN anketa_tm1 a on a.id = b.id_user WHERE b.description = 'Поднятие анкеты'
UPDATE anketa_tm1 set

1364547134 	4933047
1365239330 	4933447
1365286642 	4934720
UPDATE anketa_tm1 a,
(SELECT max(b.time_start) as max_time,id_user FROM btransaction b INNER JOIN anketa_tm1 a on a.id = b.id_user
WHERE b.description = 'Поднятие анкеты'
GROUP by id_user) b
set a.priority = b.max_time + 1e10 where a.id = b.id_user

--
UPDATE `anketa` SET trial_end = UNIX_TIMESTAMP()+36*3600
UPDATE anketa set contact_count = if(gender = 1,15,25)

UPDATE anketa a,
(SELECT id_user, FLOOR(SUM(amount_real)/10) as sum FROM `btransaction`
GROUP by id_user) b
set a.contact_count = a.contact_count + b.sum
WHERE a.id = b.id_user


-- добавляем индексы
-- message id_from , id_to - были
-- payment id_user - нужная
-- anketa genter location age


-- поиск по ingerprint

-- или SELECT b.id
SELECT * FROM `anketa_fingerprint` a
INNER JOIN anketa_fingerprint b
ON a.accept = b.accept AND a.user_agent = b.user_agent AND a.plugins = b.plugins
WHERE a.id_anketa = 4937930;

UPDATE anketa SET last_site = REPLACE( last_site, 'www.', '' ) ;


-- статистика по баблу:
-- премы за месяц
SELECT SUM( amount ) FROM `btransaction`
WHERE amount <0
AND time_start BETWEEN UNIX_TIMESTAMP( '2013-11-01' ) AND UNIX_TIMESTAMP( '2013-12-01' )
AND description LIKE 'Прем%'
-- топы за месяц
SELECT SUM( amount ) FROM `btransaction`
WHERE amount <0
AND time_start BETWEEN UNIX_TIMESTAMP( '2013-11-01' ) AND UNIX_TIMESTAMP( '2013-12-01' )
AND description LIKE 'Топ%'
-- поднятие за месяц
SELECT SUM( amount ) FROM `btransaction`
WHERE amount <0
AND time_start BETWEEN UNIX_TIMESTAMP( '2013-11-01' ) AND UNIX_TIMESTAMP( '2013-12-01' )
AND description LIKE 'Подн%'
*/