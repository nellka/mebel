<?php

/**
 * Класс для экспорта товаров из каталога сайта на Yandex.Market.
 *
 * @author Авдеев Марк <mark-avdeev@mail.ru>
 * @package moguta.cms
 * @subpackage Libraries
 */
class YML {

  public function __construct() {
    
  }

  /**
   * Выгружает содержание всего каталога в CSV файл
   * @return array
   */
  public function exportToYml($listProductId=array()) {
    
    header("Content-Type: application/force-download");
    header("Content-Type: application/octet-stream;");
    header("Content-Type: application/download");
    header("Content-Disposition: attachment;filename=data.xml");
    header("Content-Transfer-Encoding: binary ");
    
    $currencyShopIso = MG::getSetting('currencyShopIso');
    $currencyRate = MG::getSetting('currencyRate');   
    $currencyRate  = $currencyRate[$currencyShopIso];


    $nXML = '<?xml version="1.0" encoding="windows-1251"?>
<!DOCTYPE yml_catalog SYSTEM "shops.dtd">';
    $xml = new XMLWriter();

    $xml->openMemory();
    $xml->setIndent(true);

    $xml->startElement("yml_catalog");
    $xml->writeAttribute("date", date("Y-m-d h:m"));
    $xml->startElement("shop");
    $xml->writeElement("name", MG::getSetting("sitename"));
    $xml->writeElement("company", 'Компания '.MG::getSetting("sitename"));
    $xml->writeElement("url", SITE);
    $xml->startElement("currencies");
    $xml->startElement("currency");
    $xml->writeAttribute("id", $currencyShopIso);
    $xml->writeAttribute("rate", $currencyRate);
    $xml->endElement(); //currency                 
    $xml->endElement(); //currencies


    $xml->startElement("categories");
    // получаем id категорий и id их родителей
    $sql = '
      SELECT id, parent, title 
      FROM `'.PREFIX.'category`             
      ORDER BY id';
    
    $res = DB::query($sql);
    while ($row = DB::fetchAssoc($res)) {
      $xml->startElement("category");
      $xml->writeAttribute("id", $row['id']);
      if ($row['parent'] > 0) {
        $xml->writeAttribute("parentId", $row['parent']);
      }
      $xml->text($row['title']);
      $xml->endElement();  //category
    }
    $xml->endElement(); //categories
    $costDelivery = "0";
    $sql = 'SELECT `cost` FROM `'.PREFIX.'delivery` WHERE `ymarket` = 1';
    $res = DB::query($sql);
    while ($row = DB::fetchAssoc($res)) {
    $costDelivery = $row['cost'];
    }
    if ($costDelivery == 0) {
      $costDelivery = "0";
    }
    $xml->writeElement("local_delivery_cost", $costDelivery);

    $xml->startElement("offers");
   
    $where = ' 1=1';
    if(YML_ONLY_AVAILABLE == '1'){
      $where = ' p.count <> 0 ';
    }
    if(!empty($listProductId)){
      $where = ' p.id IN ('.DB::quote(implode(',',$listProductId),1).')';
    }   
    
    $sql = '
      SELECT
        c.title as category_title,
        CONCAT(c.parent_url,c.url) as category_url,
        p.url as product_url,
        p.*, rate,(p.price_course + p.price_course * (IFNULL(rate,0))) as `price_course` 
      FROM `'.PREFIX.'product` p
      LEFT JOIN `'.PREFIX.'category` c
        ON c.id = p.cat_id
      WHERE '.$where.'
      ORDER BY c.id
    ';

    $res = DB::query($sql);
    $currencyShopIso = MG::getSetting('currencyShopIso');
    while ($row = DB::fetchAssoc($res)) {
      if ($row['price'] > 0 && $row['activity']==1) {
        $row['currency_iso'] = $row['currency_iso']?$row['currency_iso']:$currencyShopIso;
        $available = $row['count'] == 0 ? "false" : "true";
        $xml->startElement("offer");
        $xml->writeAttribute("id", $row['id']);
        $xml->writeAttribute("available", $available);
        $xml->writeElement("url", SITE.'/'.$row['category_url'].'/'.$row['url']);
        $xml->writeElement("price", $row['price_course']);
        $xml->writeElement("currencyId", $currencyShopIso);
        $xml->writeElement("categoryId", $row['cat_id']);
        $arrayImages = explode("|", $row['image_url']);
        if (!empty($arrayImages)) {
          $row['image_url'] = $arrayImages[0];
        }
        $xml->writeElement("picture", SITE.'/uploads/'.urlencode($row['image_url']));
        $xml->writeElement("local_delivery_cost", $costDelivery);
        $xml->writeElement("name", $row['title']);
        $xml->writeElement("description", MG::textMore($row['description'], 500));
        $xml->writeElement("sales_notes", $row['yml_sales_notes']);     
        $xml->writeElement("manufacturer_warranty", "true");

        $xml->endElement();
      }
    }

    $xml->endElement(); //offers

    $xml->endElement(); //shop
    $xml->endElement(); //yml_catalog
    $nXML .= $xml->outputMemory();
    $nXML = mb_convert_encoding($nXML, "WINDOWS-1251", "UTF-8");
    
    if(empty($listProductId)){
      echo $nXML;
      exit;
    } else{
      $date = date('m_d_Y_h_i_s');
      file_put_contents('data_yml_'.$date.'.xml', $nXML);
      $msg = 'data_yml_'.$date.'.xml';
    }
    return $msg;  
  }
  
  /**
   * открывает запрошенный файл и отдает его в браузер с нужными заголовками
   * позволяет скачать указанный файл из панели управления в режиме аякс.
   * @return array
   */
  public function downloadYml($filename) {
    $documentroot = str_replace(DIRECTORY_SEPARATOR.'mg-core'.DIRECTORY_SEPARATOR.'lib','',dirname(__FILE__)).DIRECTORY_SEPARATOR; 
    if(is_file($documentroot.DIRECTORY_SEPARATOR.$filename)){
      header("Content-Type: application/force-download");
      header("Content-Type: application/octet-stream;");
      header("Content-Type: application/download");
      header("Content-Disposition: attachment;filename=".$filename);
      header("Content-Transfer-Encoding: binary ");   
      echo file_get_contents($filename);
      exit;      
    } 
    return false;    
  }

}

