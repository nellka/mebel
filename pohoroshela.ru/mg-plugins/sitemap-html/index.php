<?php

/*
  Plugin Name: Генератор html-карты сайта
  Description: Плагин создает карту сайта в формате HTML, карту можно вывести пр шорткоду [sitemap-html]
  Author: Daria Churkina
  Version: 1.0
 */

new SitemapHtmlGenerator;

class SitemapHtmlGenerator {
  private static $category = array();

  public function __construct() {
    mgAddShortcode('sitemap-html', array(__CLASS__, 'viewSitemap'));
  }

  /**
   * вывод html-карты сайта по шорт-коду [sitemap-html]
   */
  static function viewSitemap() {
    $sitemap = Storage::get(md5('mgPluginSitemapHtml'));
    if ($sitemap == null) {
      $pages = self::getPages();
      $catalog = self::getCatalog();
      $html = '
    <div class="sitemap-html">
     <h2 class="new-products-title">Карта сайта</h2>
    <ul class="js_listSiteMap">';
      foreach ($pages as $url => $title) {
        $partsUrl = URL::getSections($url);
        $priority = count($partsUrl);
        if (is_array($title)) {
          $html .='<li><a href="'.SITE.'/'.$url.'">'.$title[$url].
            '<ul>';
          foreach ($title as $suburl => $subtitle) {
            if ($suburl != $url) {
              $html .='<li><a href="'.SITE.'/'.$suburl.'" title="'.$subtitle.'">'.$subtitle.'</a></li>';
            }
          }
          $html .= '</ul></li>';
        } else {
          $html .='<li><a href="'.SITE.'/'.$url.'" title="'.$title.'">'.$title.'</a></li>';
          if ($url == 'catalog') {
            $html .='<ul>'.$catalog.'</ul>';
          }
        }
      }
      $sitemap = $html.'</ul></div>';
      Storage::save(md5('mgPluginSitemapHtml'), $sitemap);
    }
    return $sitemap;
  }

  /**
   * формирует массив с адресами и заголовками страниц.
   * @param type- массив с адресами и загодловками страниц
   * @return array
   */
  static function getPages() {
    $urls = array();
    $catalog = array();

    $result = DB::query('
      SELECT  * 
      FROM `'.PREFIX.'category` WHERE `invisible`=0');
    while ($row = DB::fetchAssoc($result)) {
      $catalog[] = $row;
    }
    self::$category = $catalog;

    /*
     * статические страницы сайта
     */
    $result = DB::query('
      SELECT  `parent_url`, `url`, `title`
      FROM `'.PREFIX.'page`');
    while ($row = DB::fetchAssoc($result)) {
      if ($row['url'] != 'index') {
        $urls[$row['parent_url'].$row['url']] = $row['title'];
      }
    }
    /**
     * если подключены плагины новостей и блога
     */
    $res = DB::query("SELECT *  FROM ".PREFIX."plugins WHERE folderName = 'news' and active = '1'");
    if (DB::numRows($res)) {
      $urls['news'] = 'Новости';
    }
    $res = DB::query("SELECT *  FROM ".PREFIX."plugins WHERE folderName = 'blog' and active = '1'");
    if (DB::numRows($res)) {
      $urls['blog'] = array('blog' => 'Блог');
      $result = DB::query('
       SELECT  `url`, `title`
       FROM `'.PREFIX.'blog_categories`');
      while ($row = DB::fetchAssoc($result)) {
        $urls['blog']['blog/'.$row['url']] = $row['title'];
      }
    }
    return $urls;
  }

  /**
   * формирует список категорий и подкатегорий, 
   * @param type $parent
   * @return string
   */
  static function getCatalog($parent = 0) {
    $print = '';
    $categoryArr = self::$category;
    foreach ($categoryArr as $category) {
      if (!isset($category['id'])) {
        break;
      }//если категории неceotcndetn
      if ($parent == $category['parent']) {
        $flag = false;
        foreach (self::$category as $sub_category) {
          if ($category['id'] == $sub_category['parent']) {
            $flag = true;
            break;
          }
        }
        $print.= '<li><a href="'.SITE.'/'.$category['parent_url'].$category['url'].'" title="'.$category['title'].'">'.$category['title'].'</a>';
        if ($flag) {
          $sub_menu = '
              <ul>
                [li]
              </ul>';

          $li = self::getCatalog($category['id']);
          $print .= (strlen($li) > 0 && $li != '') ? str_replace('[li]', $li, $sub_menu) : "";
          $print .= '</li>';
        } else {
          $print .= '</li>';
        }
      }
    }
    return $print;
  }

}
