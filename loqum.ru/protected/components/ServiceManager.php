<?php
/**
 * Класс для связки услуг, цен с контроллером.
 * В дальнейшем услуги-цены - в AR(?),
 * @see ProfileController::actionOrderService
 */
class ServiceManager
{
    /**
     *
     * @var array
     *
    case 4:
    $transaction->amount =  -150;
    $transaction->description = 'ПРЕМИУМ 2 недели';
    break;
    case 5:
    $transaction->amount =  -250;
    $transaction->description = 'ПРЕМИУМ на 30 дней';
     *
     */
    const SERVICE_UP = 1;
    const SERVICE_PREMIUM_SMALL = 4;
    const SERVICE_PREMIUM_BIG = 5;
    const SERVICE_PREMIUM_3DAYS = 6;
    const TIME_RISE = 1371809386;
    const TIME_RISE2 = 1378488178;

    public static $prices = array(1 => 100, 4 => 150, 5 => 250, 6=>100); //1 => 150, 2 => 250, 3 => 400,
    public static $pricesCharge = array(4 => 300, 5 => 500, 6 => 100);
    public static $timesRise = array(
        1 => 1371809386,
        2 => 1378488178,
    );
    /** @see ProfileController::checkUnBadStatus Добавил Service-премиум? Поправь checkUnBadStatus */
    public static $pricesRise = array(
        1 => array(4 => 280, 5 => 475, 6 => 190),
        2 => array(self::SERVICE_PREMIUM_SMALL => 670, self::SERVICE_PREMIUM_BIG => 1020, 6 => 280),
    );
    public static $pricesChargeRise = array(
        1 => array(4 => 400, 5 => 600, 6 => 200),
        2 => array(self::SERVICE_PREMIUM_SMALL => 850, self::SERVICE_PREMIUM_BIG => 1350, 6 => 300),
    );

    public static function getPrice($serviceId) {
        if (!isset (self::$prices[$serviceId]))
            throw new CHttpException('404',"услуга не найдена");
        if (!Yii::app()->user->isGuest && Yii::app()->user->me->first_visit < self::TIME_RISE) {
            return self::$prices[$serviceId];
        } else if (!Yii::app()->user->isGuest && Yii::app()->user->me->first_visit < self::TIME_RISE2) {
            return self::$pricesRise[1][$serviceId];
        } else {
            return self::$pricesRise[2][$serviceId];
        }
    }

    public static function getPriceCharge($serviceId){
        if (!isset (self::$pricesRise[1][$serviceId]))
            throw new CHttpException('404',"услуга не найдена");
        if (!Yii::app()->user->isGuest && Yii::app()->user->me->first_visit < self::TIME_RISE) {
            return self::$pricesCharge[$serviceId];
        } else if (!Yii::app()->user->isGuest && Yii::app()->user->me->first_visit < self::TIME_RISE2) {
            return self::$pricesChargeRise[1][$serviceId];
        } else {
            return self::$pricesChargeRise[2][$serviceId];
        }
    }

}
