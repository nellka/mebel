<?php
class StatHelper
{

    private static $_bots = array('bot', 'yandex', 'google', 'rambler', 'yahoo', 'msnbot');
    private static $_se_options = array(
        'yandex' => array('param' => 'text', 'id' => 1),
        'google' => array('param' => 'q', 'id' => 2),
        'rambler' => array('param' => 'query', 'id' => 3),
        'yahoo' => array('param' => 'query', 'id' => 4),
        'mail.ru' => array('param' => 'q', 'id' => 4),
    );

    public static function restat(){
        echo 1;
        $reader = Yii::app()->db->createCommand('SELECT id_sess, referer,searchtext FROM  {{stat_sessions}} WHERE referer <> \'\' ORDER BY id_sess ASC ')->query();
        //$reader = Yii::app()->db->createCommand('SELECT id_sess, referer,searchtext FROM  tbl_stat_sessions WHERE searchtext = \'M \' AND referer <> \'\' ORDER BY id_sess DESC ')->query();
        $updcmd = Yii::app()->db->createCommand('UPDATE {{stat_sessions}} set searchtext = :searchtext WHERE id_sess=:id_sess ');
        foreach ($reader as $data) {
            //echo print_r ($data); //$data->id_sess;

            $cur_SE = -1;
            $url = parse_url($data['referer']);
            parse_str($url['query'], $vars);
            foreach (self::$_se_options as $k => $v)
                if (preg_match("#$k#i", $url['host']))
                    $cur_SE = $k;

//            echo $cur_SE;

            if ($cur_SE!=-1) { // парсим поисковую фразу
                $paramname = self::$_se_options[$cur_SE]['param'];
                $s = $vars[$paramname];
                if (strpos($url['query'], '%D0') === false)
                    //$s = iconv( "cp1251","UTF-8", $s); // ни один вариант ICONV не сработал.
                    $s = mb_convert_encoding($s,"UTF-8","windows-1251");
//                die ($s);
                $s = strtoupper($cur_SE{0}) . ' ' . $s;
            } else {
                $s = '';
            }
            $updcmd->execute(array(':searchtext'=>$s,':id_sess'=>$data['id_sess']));

//            die($data['id_sess']);
        }
        echo 2;
    }

    public static function stat_save()
    {
        if (!Yii::app()->user->isGuest)
            return;

        $agent = addslashes(isset($_SERVER['HTTP_USER_AGENT']) ? $_SERVER['HTTP_USER_AGENT'] : '');
        if (!empty($agent)) foreach (self::$_bots as $k) if (preg_match("#$k#i", $agent)) $bot = $k;

        $ip = $_SERVER["REMOTE_ADDR"];
        $banip = false;
        if (!isset ($bot) && !$banip) {

            $time = time();
            $id_sess = Yii::app()->session->getSessionID();
            $uri = $_SERVER['REQUEST_URI'];

            if (null == Yii::app()->session->itemAt('id_stat')) { // новый юзер
                // проверка на БОТливость

                $referer = addslashes(isset($_SERVER['HTTP_REFERER']) ? $_SERVER['HTTP_REFERER'] : '');
                $xforwarded = addslashes(isset($_SERVER['HTTP_X_FORWARDED_FOR']) ? $_SERVER['HTTP_X_FORWARDED_FOR'] : '');

                if ($referer) {
                    $url = parse_url($referer);
                    parse_str($url['query'], $vars);
                    foreach (self::$_se_options as $k => $v)
                        if (preg_match("#$k#i", $url['host']))
                            $cur_SE = $k;
                }

                if (isset ($cur_SE)) { // парсим поисковую фразу
                    $paramname = self::$_se_options[$cur_SE]['param'];
                    $s = $vars[$paramname];
//                    if (strpos($url['query'], '%D0') !== false)
//                        $s = iconv("UTF-8", "cp1251", $s);
                    $s = strtoupper($cur_SE{0}) . ' ' . $s;
                } else {
                    $s = '';
                }

                $site = Yii::app()->name == 'loqum.ru' ? '' : 'so'; //substr(Yii::app()->name,0,2)
                Yii::app()->db->createCommand("insert into {{stat_sessions}} set phpsessid = :id_sess, ip = :ip,
                    timestamp = :timestamp, site = :site, referer = :referer, agent = :agent, searchtext = :searchtext")
                    ->execute(array(':id_sess' => $id_sess, ':ip' => $ip, ':timestamp' => $time,
                    ':site'=>$site,':referer' => $referer, ':agent' => $agent, ':searchtext' => $s));
                Yii::app()->session->add('id_stat', Yii::app()->db->getLastInsertID());
            }
//            echo Yii::app()->session->itemAt('id_stat'); die();
            Yii::app()->db->createCommand("insert into {{stat_hits}} set id_sess=:id_sess,
                timestamp = :timestamp, page=:page")
                ->execute(array(':id_sess' => Yii::app()->session->itemAt('id_stat'),
                ':timestamp' => $time, ':page' => $uri));
        }

    }
    public static function getCleanHost(){
        return preg_replace('#^www\.#','',$_SERVER['HTTP_HOST']);
    }
}