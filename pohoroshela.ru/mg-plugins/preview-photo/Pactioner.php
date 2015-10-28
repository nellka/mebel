<?php

/**
 * Класс Pactioner наследник стандарного Actioner
 * Предназначен для выполнения действий,  AJAX запросов плагина 
 *
 * @author Avdeev Mark <mark-avdeev@mail.ru>
 */
class Pactioner extends Actioner {

  private $iterationCount = 30; // обрабатывать по 30 штук картинок за итерацию    
  private $pluginName = 'preview-photo';

  public function start() {
    return $this->process();
  }

  public function getListImages() {
    $files = array();
    $option = MG::getSetting('preview-photo-option');
    $option = stripslashes($option);
    $options = unserialize($option);

    $realDocumentRoot = str_replace(DIRECTORY_SEPARATOR.'mg-plugins'.DIRECTORY_SEPARATOR.'preview-photo', '', dirname(__FILE__));
    $path = $realDocumentRoot.($options['source'] ? $options['source'] : DIRECTORY_SEPARATOR.'uploads'.DIRECTORY_SEPARATOR.'tempimage');

    $dirContent = scandir($path);
    foreach ($dirContent as $item) {
      if ($item[0] == '.') {
        continue;
      }
      $parts = explode(".", $item);
      $ext = end($parts);
      if (!in_array(strtolower($ext), array('jpg', 'png', 'gif'))) {
        continue;
      }
      $files[] =  rawurlencode($item);
    }
    return $files;
  }

  public function process() {
    $option = MG::getSetting('preview-photo-option');
    $option = stripslashes($option);
    $options = unserialize($option);
    $realDocumentRoot = str_replace(DIRECTORY_SEPARATOR.'mg-plugins'.DIRECTORY_SEPARATOR.'preview-photo', '', dirname(__FILE__));
    $path = $realDocumentRoot.($options['source'] ? $options['source'] : DIRECTORY_SEPARATOR.'uploads'.DIRECTORY_SEPARATOR.'tempimage');

    
    
    $process = false; // флаг запуска процесса
    $count = 1; // сколько уже обработано файлов

    $log = '';
    $files = $this->getListImages();
    if (!empty($files)) {
      $curent = $_POST['filename'] ? $_POST['filename'] : $files[0]; // название файла с которого следует начать процесс
	 
      foreach ($files as $item) {
	  
        if ($item == $curent) {
          $process = true;
        }
        if ($process && $this->iterationCount > 0) {
          
		 
          // Удаляем старый вариант картинки
          if(file_exists($realDocumentRoot.DIRECTORY_SEPARATOR.'uploads'.DIRECTORY_SEPARATOR.$item)){
            unlink($realDocumentRoot.DIRECTORY_SEPARATOR.'uploads'.DIRECTORY_SEPARATOR.$item);             
          }
          
		  $item = rawurldecode($item);
		  
		  //echo $item .'=='. $curent .'==================';
          // Создаем оригинал
          copy($path.DIRECTORY_SEPARATOR.$item, $realDocumentRoot.DIRECTORY_SEPARATOR.'uploads'.DIRECTORY_SEPARATOR.$item);
     
          // Если необходимо, накладываем водяной знак
          if ($options["watter"]=='true') { 
            $this->addWatterMark($realDocumentRoot.DIRECTORY_SEPARATOR.'uploads'.DIRECTORY_SEPARATOR.$item);    
          }
          
          $options['width70'] = $options['width70']?$options['width70']:160;
          $options['height70'] = $options['height70']?$options['height70']:140;
          $options['width30'] = $options['width30']?$options['width30']:50;
          $options['height30'] = $options['height30']?$options['height30']:40;
		  
		  
	
            
          // создаем две миниатюры
          $this->reSizeImage('70_'.$item, $realDocumentRoot.DIRECTORY_SEPARATOR.'uploads'.DIRECTORY_SEPARATOR.$item, $options['width70'], $options['height70']);
          $this->reSizeImage('30_'.$item, $realDocumentRoot.DIRECTORY_SEPARATOR.'uploads'.DIRECTORY_SEPARATOR.$item, $options['width30'], $options['height30']);
         
          $item_layout = iconv('windows-1251','UTF-8',$item);    
          $log .= "\n $count Созданы миниатюры для файла: ".$item_layout;
          $this->iterationCount--;
		
          $curent = rawurlencode($item);
		   
        }

        if ($this->iterationCount > 0) {
          $count++;
        }
      }
    }
    
    $percent100 = count($files);
    $percent = $count;
    $percent100 = $percent100?$percent100:1;
    $percent = ($percent * 100) / $percent100;

    $data = array(
      'count' => $count,
      'percent' => floor($percent),
      'filename' => $curent,
      'log' => $log,
    );

    $this->messageSucces = "Обработано ".((floor($percent) > 100) ? 100 : floor($percent))."% изображений";
    $this->data = $data;

    return true;
  }

  /**
   * Сохраняет  опции плагина
   * @return boolean
   */
  public function saveBaseOption() {
    $this->messageSucces = $this->lang['SAVE_BASE'];
    $this->messageError = $this->lang['NOT_SAVE_BASE'];
    if (!empty($_POST['data'])) {
      MG::setOption(array('option' => 'preview-photo-option', 'value' => addslashes(serialize($_POST['data']))));
    }
    return true;
  }

  /**
   * Функция для ресайза картинки
   * @param string $name имя файла без расширения
   * @param string $tmp исходный временный файл
   * @param int $widthSet заданная ширина изображения
   * @param int $heightSet заданная высота изображения
   * @paramint $koef коэффициент сжатия изображения
   * @return void
   */
  private function reSizeImage($name, $tmp, $widthSet, $heightSet, $dirUpload = 'uploads/thumbs/') {

    $fullName = explode('.', $name);
    $ext = array_pop($fullName);
    $name = implode('.', $fullName);
    list($width_orig, $height_orig) = getimagesize($tmp);

	/*
    if ($widthSet > $heightSet) {
      $ratio = $widthSet / $width_orig;
      $width = $widthSet;
      $height = $height_orig * $ratio;
    } else {
      $ratio = $heightSet / $height_orig;
      $width = $width_orig * $ratio;
      $height = $heightSet;
    }
	*/
	
	  // $ratio = $heightSet / $height_orig;
	  $width = $widthSet;
	  $height = $heightSet;
	
	  if ($width_orig > $height_orig) {
	    $ratio = $widthSet / $width_orig;
        $width = $widthSet;
		$height = $height_orig * $ratio;
		$height = $height>$heightSet?$heightSet:$height;
	  }else{
	    $ratio = $heightSet / $height_orig;
        $width = $width_orig * $ratio;
		$height = $heightSet;
		$width = $width>$widthSet?$widthSet:$width;
	  }
   

	 /* 
	  $ratio = $widthSet / $width_orig;
      $width = $widthSet;
      $height = $height_orig * $ratio;
	  */
    // ресэмплирование
    $image_p = imagecreatetruecolor($width, $height);


    imageAlphaBlending($image_p, false);
    imageSaveAlpha($image_p, true);


    // вывод
    switch ($ext) {
      case 'png':
        $image = imagecreatefrompng($tmp);
        //делаем фон изображения белым, иначе в png при прозрачных рисунках фон черный
        $black = imagecolorallocate($image, 0, 0, 0);

// Сделаем фон прозрачным
        imagecolortransparent($image, $black);

        imagealphablending($image_p, false);
        $col = imagecolorallocate($image_p, 0, 0, 0);
        imagefilledrectangle($image_p, 0, 0, $width, $height, $col);
//imagealphablending( $image_p, true );



        imagecopyresampled($image_p, $image, 0, 0, 0, 0, $width, $height, $width_orig, $height_orig);
        imagepng($image_p, $dirUpload.$name.'.'.$ext);
        break;

      case 'gif':
        $image = imagecreatefromgif($tmp);
        imagecopyresampled($image_p, $image, 0, 0, 0, 0, $width, $height, $width_orig, $height_orig);
        imagegif($image_p, $dirUpload.$name.'.'.$ext, 100);
        break;

      default:

        $image = imagecreatefromjpeg($tmp);
        imagecopyresampled($image_p, $image, 0, 0, 0, 0, $width, $height, $width_orig, $height_orig);
        //imagefilter($image_p, IMG_FILTER_BRIGHTNESS, 15); 
        imagejpeg($image_p, $dirUpload.$name.'.'.$ext, 100);
      // создаём новое изображение
    }
    imagedestroy($image_p);
    imagedestroy($image);
  }
  
   /**
   * Добавляет водяной знак к картинке
   * @param type $image - путь до картинки на сервере
   * @return boolean
   */
  public function addWatterMark($image) {
    $filename = $image;
    if (!file_exists('uploads/watermark/watermark.png')) {
      return false;
    }
    $size_format = getimagesize($image);
    $format = strtolower(substr($size_format['mime'], strpos($size_format['mime'], '/') + 1));

    // создаём водяной знак
    $watermark = imagecreatefrompng('uploads/watermark/watermark.png');
    imagealphablending($watermark, false);
    imageSaveAlpha($watermark, true);
    // получаем значения высоты и ширины водяного знака
    $watermark_width = imagesx($watermark);
    $watermark_height = imagesy($watermark);

    // создаём jpg из оригинального изображения
    $image_path = $image;



    switch ($format) {
      case 'png':
        $image = imagecreatefrompng($image_path);
        $w = imagesx($image);
        $h = imagesy($image);
        $imageTrans = imagecreatetruecolor($w, $h);
        imagealphablending($imageTrans, false);
        imageSaveAlpha($imageTrans, true);


        $col = imagecolorallocate($imageTrans, 0, 0, 0);
        imagefilledrectangle($imageTrans, 0, 0, $w, $h, $col);
        imagealphablending($imageTrans, true);


        break;
      case 'gif':
        $image = imagecreatefromgif($image_path);
        break;
      default:
        $image = imagecreatefromjpeg($image_path);
    }

    //если что-то пойдёт не так
    if ($image === false) {
      return false;
    }
    $size = getimagesize($image_path);
    // помещаем водяной знак на изображение
    $dest_x = (($size[0]) / 2) - (($watermark_width) / 2);
    $dest_y = (($size[1]) / 2) - (($watermark_height) / 2);

    imagealphablending($image, true);
    imagealphablending($watermark, true);

    imageSaveAlpha($image, true);
    // создаём новое изображение
    imagecopy($image, $watermark, $dest_x, $dest_y, 0, 0, $watermark_width, $watermark_height);

    $imageformat = 'image'.$format;
    if ($format = 'png') {
      $imageformat($image, $filename);
    } else {
      $imageformat($image, $filename, 100);
    }

    // освобождаем память
    imagedestroy($image);
    imagedestroy($watermark);
    return true;
  }

}