<?php
/**
 * Временный класс
 */
class TmpHelper {
    const OCOLOR_RED=0xEE1C25;
    const OCOLOR_BLUE=0x00ADEF;

    static $positions = array(
        'lt' => array(
            'red' => array('x' => 12, 'y' => 12,'color'=>self::OCOLOR_RED),
            'blue' => array('x' => 11, 'y' => 3,'color'=>self::OCOLOR_BLUE),
        ),
        'rb' => array(
            'red' => array('x' => -67, 'y' => -17,'color'=>self::OCOLOR_RED),
            'blue' => array('x' => -75, 'y' => -17,'color'=>self::OCOLOR_BLUE),
        ),
    );

    static $wmpositions = array(
        'lt'=>array('x'=>0,'y'=>0),
        'rb'=>array('x'=>-107,'y'=>-29),
    );


    /**
     * Вычисляет расстояние между двумя цветами
     * @static
     * @param $color1 цвет в RGB
     * @param $color2
     */
    public static function colorMeasure($color1,$color2){
        $r1 = ($color1 >> 16) & 0xFF;
        $g1 = ($color1 >> 8) & 0xFF;
        $b1 = $color1 & 0xFF;

        $r2 = ($color2 >> 16) & 0xFF;
        $g2 = ($color2 >> 8) & 0xFF;
        $b2 = $color2 & 0xFF;

        $d1 = (abs($r1-$r2)+abs($g1-$g2)+abs($b1-$b2));
        //$d2 = (pow($r1-$r2,2)+pow($g1-$g2,2)+pow($b1-$b2,2));
        //echo " /$d1 $d2/ ";
        return $d1;
    }

    public static function  colorSimilar($color1,$color2){
//        if ($color1==$color2)
//            return true;
        if (self::colorMeasure($color1,$color2)<50)
            return true;
        return false;
    }

    /**
     * @static
     * @param $img resource
     * @param $imginfo array
     */
    public static function getLogoPosition($img,$imginfo){
        list ($w,$h)=$imginfo;
        $ds = array();
        foreach (self::$positions as $pos=>$colorcheck) {
            foreach ($colorcheck as $coltxt => $coord) {
                if ($coord['x'] < 0) $coord['x'] = $w + $coord['x'];
                if ($coord['y'] < 0) $coord['y'] = $h + $coord['y'];
                $color = imagecolorat($img, $coord['x'], $coord['y']);
//                echo "({$coord['x']}, {$coord['y']})";
//                echo "| $pos " . dechex($color);
                $ds[$pos][$coltxt] = self::colorMeasure($color,$coord['color']);
            }
        }

        // $ds2[$color][$position]
        $ds2 = CArray::rotate($ds);
        $mincolord = array();$counts = array();
        foreach($ds2 as $col => $poss){
            $min = 1024; $key = 0;
            foreach ($poss as $pos=>$d){
                if ($min>$d) {
                    $key = $pos;
                    $min = $d;
                }
            }
            $mincolord[$col]['pos'] = $key;
            $mincolord[$col]['d'] = $min;
            $counts[$key]=0;
        }

        // minimal color distance
        foreach ($mincolord as $col=>$data){
            if ($data['d']<100)
                $counts[$data['pos']]++;
        }

//        return $counts;

        foreach ($counts as $k=>$v){
            if ($v==2) return $k; // ==count($mincolord)
        }

        if (array_sum($counts)==0)
            return false;

        return $counts;
    }

    public static function addLogo($filename){
        if (!is_file($filename))
            return false;
        $watermark = imagecreatefromjpeg(Yii::getPathOfAlias('webroot').'/images/watermark.jpg');
        $wm = array('w'=>107,'h'=>25);
        $imginfo = getimagesize($filename);
        $img = imagecreatefromjpeg($filename);
        $poss = 'rb';
        $coord = TmpHelper::$wmpositions[$poss];
        list ($w,$h)=$imginfo;
        if ($coord['x'] < 0) $coord['x'] = $w + $coord['x'];
        if ($coord['y'] < 0) $coord['y'] = $h + $coord['y'];
        imagecopy($img, $watermark, $coord['x'], $coord['y'], 0, 0, $wm['w'], $wm['h']);
        imagejpeg ($img,  $filename,100);
    }

}