<?php

/**
 * Контроллер: Сompare
 *
 * Класс Controllers_Сompare создает таблицу сравнения строковых характеристик товаров.
 * - выводит добавленные к сравнению карточки товаров;
 * - в зависимости от настроек разделяет товары на категории;
 *
 * @author Авдеев Марк <mark-avdeev@mail.ru>
 * @package moguta.cms
 * @subpackage Controller
 */
class Controllers_Compare extends BaseController {

  /**
   * Определяет поведение при изменении и удаление данных в корзине,
   * а так же выводит список позиций к заказу.
   * @return void
   */
  public function __construct() {

    $productModel = new Models_Product();
    if (isset($_GET['delCompareProductId'])) {
      foreach ($_SESSION['compareList'] as $key => $category) {
        unset($_SESSION['compareList'][$key][$_GET['delCompareProductId']]);
      }

      foreach ($_SESSION['compareList'] as $key => $category) {
        if (empty($category)) {
          unset($_SESSION['compareList'][$key]);
        }
      }
    }
    if (isset($_GET['delCompare'])) {
      unset($_SESSION['compareList']);
    }


    if (isset($_GET['inCompareProductId'])) {

      $prodData = $productModel->getProduct($_GET['inCompareProductId']);
      if ($prodData) {
        if ($prodData['cat_id'] >= 0) {
          $_GET['viewCategory'] === $prodData['cat_id'];
          $_SESSION['compareList'][$prodData['cat_id']][$_GET['inCompareProductId']] = $_GET['inCompareProductId'];
          }
        }
      }

    // Если не задана категория, то выводим товары из первой.
    if (!isset($_GET['viewCategory'])) {
      if (!empty($_SESSION['compareList'])) {
        $idCategory = array_keys($_SESSION['compareList']);
        $_GET['viewCategory'] = $idCategory[0];
      }
    }

    $error = '';
    if (MG::getSetting('compareCategory') != 'true') {
      $listCatId[] = $_GET['viewCategory'];
    } else {
      foreach ($_SESSION['compareList'] as $idCat => $idsProd) {
        $listCatId[] = $idCat;
      }
    }

    $info = $this->getInfoProducts($listCatId);

    if (!empty($info)) {
      $catalogItems = $info['catalogItems'];
    } else {
      $error = "Нет товаров для сравнения в этой категории";
    }

    $arrCategory = MG::get('category')->getArrayCategory();

    $catIds = array(0);
    $arrCategoryTitle = array();
    if (!empty($_SESSION['compareList'])) {
      $catIds = array();
      foreach ($_SESSION['compareList'] as $catId => $v) {

        if ($catId > 0) {
          $arrCategoryTitle[$catId] = $arrCategory[$catId]['title'];
        }
        if ($catId === 0) {
          $arrCategoryTitle[$catId] = 'Каталог';
        }
        $catIds[] = $catId;
      }
    }

    $moreThanThree = '';
    if (count($catalogItems) > 3) {
      $moreThanThree = 'more-than-three';
    }

    $_SESSION['compareCount'] = 0;
    if (!empty($_SESSION['compareList'])) {
      foreach ($_SESSION['compareList'] as $category) {
        $_SESSION['compareCount'] += count($category);
      }
    }

    if (isset($_GET['updateCompare'])) {
      $array = array('count' => $_SESSION['compareCount']);
      echo json_encode($array);
      exit();
    }

    // Получаем все характеристики для текущей категории и вложенных в нее,
    // а также характеристики выводимые для всех категорий.
    
    $catIds = implode(',', $catIds);
    $sql = "
      SELECT * FROM `".PREFIX."property` as pp
      LEFT JOIN `".PREFIX."category_user_property` as cp
         ON  pp.id = cp.property_id
      WHERE cp.category_id IN (".DB::quote($catIds, true).") and pp.filter = 1
        ORDER BY pp.sort DESC
    ";

    $res = DB::query($sql);
    while ($row = DB::fetchAssoc($res)) {
      $property[$row['name']] = $row['description'];
    }

    $this->data = array(
      'error' => $error,
      'compareList' => $_SESSION['compareList'],
      'catalogItems' => $catalogItems,
      'arrCategoryTitle' => $arrCategoryTitle,
      'moreThanThree' => $moreThanThree,
      'meta_title' => 'Список сравнения товаров',
      'meta_keywords' => !empty($model->currentCategory['meta_keywords'])?$model->currentCategory['meta_keywords']:"сравнение,сравнить",
      'meta_desc' => !empty($model->currentCategory['meta_desc'])?$model->currentCategory['meta_desc']:"Список сравнения товаров",
      'property' => $property
    );
  }

  /**
   * Получает информацию о каждом товаре.
   * @param array $viewCategoryId - массив id категорий.
   */
  public function getInfoProducts($viewCategoryId) {

    if (empty($viewCategoryId)) {
      return false;
    }

    $listProductsArray = array();
    $countProduct = 0;
    
    foreach ($viewCategoryId as $k => $id) {
      $listProductsIdTemp = $_SESSION['compareList'][$id];
      $countProduct += count($_SESSION['compareList'][$id]);
      $listProductsArray = array_merge($listProductsArray, $listProductsIdTemp);
    }
    
    $listProductsId = implode(',', $listProductsArray);
    $catalogModel = new Models_Catalog();
    $productModel = new Models_Product();

    if (!empty($listProductsId)) {
      $arrProduct = $catalogModel->getListByUserFilter(
        $countProduct, ' p.id IN ('.DB::quote($listProductsId, true).')'
      );
    }

    $currencyRate = MG::getSetting('currencyRate');
    $currencyShopIso = MG::getSetting('currencyShopIso');
    $currencyShopIso = MG::getSetting('currencyShopIso');

    foreach ($arrProduct['catalogItems'] as &$product) {

      $blockVariants = $productModel->getBlockVariants($product['id']);
      $blockedProp = $productModel->noPrintProperty();
      
      $propertyFormData = $productModel->createPropertyForm($param = array(
        'id' => $product['id'],
        'maxCount' => $product['count'],
        'productUserFields' => $product['thisUserFields'],
        'action' => "/catalog",
        'method' => "POST",
        'ajax' => true,
        'blockedProp' => $blockedProp,
        'noneAmount' => false,
        'titleBtn' => MG::getSetting('buttonBuyName'),
        'blockVariants' => $blockVariants,
        'printStrProp' => 'false',
        'printCompareButton' => 'false',
        'currency_iso' => $product['currency_iso'],
      ));

      if ($product['count'] < 0) {
        $product['count'] = "много";
      };

      $product['price']+=$propertyFormData['marginPrice'];
      $product['currency_iso'] = $product['currency_iso']?$product['currency_iso']:$currencyShopIso;
      $product['currency'] = MG::getSetting('currency');
      $product['old_price'] = $product['old_price'] * $currencyRate[$product['currency_iso']];
      $product['old_price'] = $product['old_price']?MG::priceCourse($product['old_price']):0;
      $product['price'] = MG::priceCourse($product['price_course'], true, true);
      $product['propertyForm'] = $propertyFormData['html'];
      $product['propertyNodummy'] = $propertyFormData['propertyNodummy'];
      $product['stringsProperties'] = $propertyFormData['stringsProperties'];
      $product['image_url'] = explode('|', $product['image_url']);
      $product['image_url'] = $product['image_url'][0];
    }

    return array('catalogItems' => $arrProduct['catalogItems']);
  }

}
