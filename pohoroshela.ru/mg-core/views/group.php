<?php
/**
 *  Файл представления Group - выводит сгенерированную движком информацию на странице сайта с новинками, рекомендуемыми и товарами распродажи.
 *  В этом  файле доступны следующие данные:
 *   <code>
 * 'items' => $items['catalogItems'],
 *    $data['items'] => Массив товаров
 *    $data['titeCategory'] => Название открытой категории
 *    $data['pager'] => html верстка  для навигации страниц
 *    $data['meta_title'] => Значение meta тега для страницы
 *    $data['meta_keywords'] => Значение meta_keywords тега для страницы
 *    $data['meta_desc'] => Значение meta_desc тега для страницы
 *    $data['currency'] => Текущая валюта магазина
 *    $data['actionButton'] => тип кнопки в миникарточке товара
 *   </code>
 *
 *   Получить подробную информацию о каждом элементе массива $data, можно вставив следующую строку кода в верстку файла.
 *   <code>
 *    <php viewData($data['items']); ?>
 *   </code>
 *
 *   Вывести содержание элементов массива $data, можно вставив следующую строку кода в верстку файла.
 *   <code>
 *    <php echo $data['items']; ?>
 *   </code>
 *
 *   <b>Внимание!</b> Файл предназначен только для форматированного вывода данных на страницу магазина. Категорически не рекомендуется выполнять в нем запросы к БД сайта или реализовывать сложую программную логику логику.
 *   @author Авдеев Марк <mark-avdeev@mail.ru>
 *   @package moguta.cms
 *   @subpackage Views
 */
// Установка значений в метатеги title, keywords, description.
mgSEO($data);
?>

<?php mgAddMeta('<script type="text/javascript" src="'.SCRIPT.'jquery.bxslider.min.js"></script>'); ?>

<script>
$(document).ready(function() {   
  //Слайдер новинок на главной странице
   $('.m-p-products-slider-start').bxSlider({
    minSlides: 4,
    maxSlides: 4,
    slideWidth: 222,
    slideMargin: 15,
    moveSlides: 1,
    pager: false,
    auto: false,
    pause: 6000,
    useCSS: false
  }); 
});
</script>

<h1 class="new-products-title <?php echo $data['class_title'] ?>" ><?php echo $data['titeCategory'] ?></h1>
<div class="products-wrapper" style="padding: 0px;">        
  <?php
  if (!empty($data['items']))
    foreach ($data['items'] as $item):
      ?>

      <div class="product-wrapper">
        <div class="product-image">
          <?php
          echo $item['recommend'] ? '<span class="sticker-recommend"></span>' : '';
          echo $item['new'] ? '<span class="sticker-new"></span>' : '';
          ?>
          <a href="<?php echo $item["link"] ?>">
            <?php echo mgImageProduct($item); ?> 
          </a>
        </div>
        <div class="product-name">
          <a href="<?php echo $item["link"] ?>"><?php echo $item["title"] ?></a>
        </div>
        <span class="product-price"><?php echo priceFormat($item["price"]) ?> <?php echo $data['currency']; ?></span>
        <!--Кнопка, кототорая меняет свое значение с "В корзину" на "Подробнее"-->
        <?php echo $item['buyButton']; ?>
      </div>

    <?php endforeach; ?>

  <div class="clear"></div>
  <?php echo $data['pager']; ?>
  <!-- / Верстка каталога -->
</div>

<!-- Все группы -->

<?php if (!empty($data['newProducts'])): ?>

  <div class="m-p-products">
    <h2 class="m-p-new-products-title"><a href="<?php echo SITE; ?>/group?type=latest" class="text-decoration-none">Новинки</a></h2>
    <div class="m-p-products-slider">
      <div class="<?php echo count($data['newProducts']) > 3 ? "m-p-products-slider-start" : "" ?>">
        <?php foreach ($data['newProducts'] as $item): ?>
          <div class="product-wrapper"  style="padding: 0px;">
            <div class="product-image">
              <?php
              echo $item['recommend'] ? '<span class="sticker-recommend"></span>' : '';
              echo $item['new'] ? '<span class="sticker-new"></span>' : '';
              ?>
              <a href="<?php echo $item["link"] ?>">
                 <?php echo mgImageProduct($item); ?> 
              </a>
            </div>

            <div class="product-name">
              <a href="<?php echo $item["link"] ?>"><?php echo $item["title"] ?></a>
            </div>

            <span class="product-price"><?php echo priceFormat($item["price"]) ?> <?php echo $data['currency']; ?></span>
            <!--Кнопка, кототорая меняет свое значение с "В корзину" на "Подробнее"-->
            <?php echo $item[$data['actionButton']] ?>
          </div>
        <?php endforeach; ?>
      </div>
    </div>
    <div class="clear"></div>
  </div>
<?php endif; ?>

<?php if (!empty($data['recommendProducts'])): ?>
  <div class="m-p-recommended-products">
    <h2 class="m-p-recommended-products-title"><a href="<?php echo SITE; ?>/group?type=recommend" class="text-decoration-none">Рекомендуемые товары</a></h2>
    <div class="m-p-products-slider">
      <div class="<?php echo count($data['recommendProducts']) > 3 ? "m-p-products-slider-start" : "" ?>">
        <?php foreach ($data['recommendProducts'] as $item): ?>

          <div class="product-wrapper">
            <div class="product-image">
              <?php
              echo $item['recommend'] ? '<span class="sticker-recommend"></span>' : '';
              echo $item['new'] ? '<span class="sticker-new"></span>' : '';
              ?>
              <a href="<?php echo $item["link"] ?>">
                <?php echo mgImageProduct($item); ?> 
              </a>
            </div>

            <div class="product-name">
              <a href="<?php echo $item["link"] ?>"><?php echo $item["title"] ?></a>
            </div>

            <span class="product-price"><?php echo priceFormat($item["price"]) ?> <?php echo $data['currency']; ?></span>
            <!--Кнопка, кототорая меняет свое значение с "В корзину" на "Подробнее"-->
            <?php echo $item[$data['actionButton']] ?>
          </div>
        <?php endforeach; ?>
      </div>
    </div>
    <div class="clear"></div>
  </div>
<?php endif; ?>

<?php if (!empty($data['saleProducts'])): ?>
  <div class="m-p-products">
    <h2 class="m-p-sale-products-title"><a href="<?php echo SITE; ?>/group?type=sale" class="text-decoration-none">Распродажа</a></h2>
    <div class="m-p-products-slider">
      <div class="<?php echo count($data['saleProducts']) > 3 ? "m-p-products-slider-start" : "" ?>">
        <?php foreach ($data['saleProducts'] as $item): ?>
          <div class="product-wrapper">
            <div class="product-image">
              <?php
              echo $item['recommend'] ? '<span class="sticker-recommend"></span>' : '';
              echo $item['new'] ? '<span class="sticker-new"></span>' : '';
              ?>
              <a href="<?php echo $item["link"] ?>">
                <?php echo mgImageProduct($item); ?> 
              </a>
            </div>

            <div class="product-name">
              <a href="<?php echo $item["link"] ?>"><?php echo $item["title"] ?></a>
            </div>

            <span class="product-price"><?php echo priceFormat($item["price"]) ?> <?php echo $data['currency']; ?></span>
            <!--Кнопка, кототорая меняет свое значение с "В корзину" на "Подробнее"-->
            <?php echo $item[$data['actionButton']] ?>
          </div>
        <?php endforeach; ?>
      </div>
    </div>
    <div class="clear"></div>
  </div>
<?php endif; ?>
