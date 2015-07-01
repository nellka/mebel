<!DOCTYPE html>
<html>
    <head>
    <!--[if IE]>
<script src="http://html5shiv.googlecode.com/svn/trunk/html5.js"></script>
<![endif]-->
     <!--[if IE]>
    <style type="text/css">
        .wrapper {
           
        }
    </style>
    <![endif]-->

        <link href='http://fonts.googleapis.com/css?family=Roboto:400,500italic,500,400italic,700,700italic&subset=latin,cyrillic' rel='stylesheet' type='text/css'>
        <?php mgMeta(); ?>
        <script type="text/javascript" src="<?php echo PATH_SITE_TEMPLATE ?>/js/accordion-menu.js"></script>
        <script type="text/javascript" src="<?php echo PATH_SITE_TEMPLATE ?>/js/script.js"></script>

      <meta name="cmsmagazine" content="ad87e298e2ca0058ae4ccec6adcb0192" />
    </head>

    <body>
<!-- Yandex.Metrika counter -->
<script type="text/javascript">
(function (d, w, c) {
    (w[c] = w[c] || []).push(function() {
        try {
            w.yaCounter30636067 = new Ya.Metrika({id:30636067,
                    webvisor:true,
                    clickmap:true,
                    trackLinks:true,
                    accurateTrackBounce:true});
        } catch(e) { }
    });

    var n = d.getElementsByTagName("script")[0],
        s = d.createElement("script"),
        f = function () { n.parentNode.insertBefore(s, n); };
    s.type = "text/javascript";
    s.async = true;
    s.src = (d.location.protocol == "https:" ? "https:" : "http:") + "//mc.yandex.ru/metrika/watch.js";

    if (w.opera == "[object Opera]") {
        d.addEventListener("DOMContentLoaded", f, false);
    } else { f(); }
})(document, window, "yandex_metrika_callbacks");
</script>
<noscript><div><img src="//mc.yandex.ru/watch/30636067" style="position:absolute; left:-9999px;" alt="" /></div></noscript>
<!-- /Yandex.Metrika counter -->
        <div class="mg-layer" style="display: none"></div>
        
        <div class="wrapper">

            <header>
                <div class="js_container">
                    <a class="js_logo" href="<?php echo SITE ?>"><?php echo mgLogo(); ?></a>
                    <?php layout('cart'); ?>
                    <?php if($thisUser = $data['thisUser']){ /* ?> <div class="auth"><a href="<?php echo SITE?>/personal"> <?php echo empty($thisUser->name)?$thisUser->email:$thisUser->name ?></a>, <a href="<?php echo SITE?>/enter?logout=1">выйти</a> </div><?php 
                    } else { ?> <div class="auth" id="js_login">Кабинет</div> <?php*/ }; ?>
                    <nav><?php layout('topmenu'); ?></nav>
                    <nav class="js_topCategory">
                        <ul>                        
                           <li><a href="/nabory-dlya-shitya-platev">Наборы для шитья</a></li>
                    <li><a href="/uroki-shitya">Уроки шитья</a></li>
                    <li><a href="/golossariy">Голоссарий</a></li>
                    <li><a href="/contacts">Контакты</a></li>
                    <!-- <img src="http://pohoroshela.ru/uploads/fraza.png" border="0" style="padding: 0 20px; width: 665px;">-->
                        </ul>                       
                    </nav>
                     <div id="menuar"></div>
                    <ul class="js_topContacts">
                        <li>Тел. 926-567-00-08</li>
                       <!-- <li>Магазин-склад: Москва, Нижняя Сыромятническая улица, 10</li>-->
                    </ul>
                </div>
            </header>        
          
            
          <div class="js_clear"></div>
          <?php if(URL::isSection(null)){ ?>
                <img border="0" style="" src="mg-templates/pohoroshela/images/top1.jpg">
          <?php } ?>
            
           <article>    
            <?php if(!URL::isSection(null)){ ?>        
                <div id="js_left">
                    <?php filterCatalog();?>
                    <!-- Вывод каталога -->
                    <?php if(MG::get('controller')=="controllers_product" || MG::get('controller')=="controllers_catalog") :?>
                        <nav><?php layout('leftmenu'); ?></nav>
                    <?php  endif; ?>
                    <?php if(URL::isSection(null) 
                    || URL::getClearUri()=='/contacts' 
                    || URL::getClearUri()=='/kurerskaya-dostavka-po-gorodam-rossii' 
                    || URL::getClearUri()=='/oplata' 
                    || URL::getClearUri()=='/personal' 
                    || URL::getClearUri()=='/o-nas' 
                    || URL::getClearUri()=='/enter' 
                    || URL::getClearUri()=='/registration'
                     || URL::getClearUri()=='/forgotpass' || URL::getClearUri()=='/karta-sayta' || URL::getClearUri()=='/dostavka-i-oplata') : ?>
                        <nav><?php layout('leftmenu'); ?></nav>
                    <?php  endif; ?>
                    <?php $type = URL::getQueryParametr('type'); 
                    if(URL::isSection('group') && ($type == 'recommend' || $type == 'latest')) :?>
                        <nav><?php layout('leftmenu'); ?></nav>
                    <?php endif; ?><!-- /Вывод каталога -->               
                    <!-- Вывод меню "Уроки шитья" -->
                    <?php if(URL::isSection('uroki-shitya') 
                             || URL::isSection('uroki-shitya/oborudovanie-dlya-shitya/shveynye-mashinki') 
                             || URL::isSection('uroki-shitya/oborudovanie-dlya-shitya/tkani') 
                             || URL::isSection('uroki-shitya/oborudovanie-dlya-shitya/niti-i-shveynye-prinadlejnosti') 
                             || URL::isSection('uroki-shitya/oborudovanie-dlya-shitya/vykroyki') 
                             || URL::isSection('uroki-shitya/oborudovanie-dlya-shitya/kak-snyat-merki') 
                             || URL::isSection('uroki-shitya/oborudovanie-dlya-shitya/stabilizatory-poverhnostey') 
                             || URL::isSection('uroki-shitya/osnovnye-tehniki-shitya') 
                             || URL::isSection('uroki-shitya/izgotovlenie-detaley-izdeliy') 
                             || URL::isSection('uroki-shitya/uroki-poshiva-gotovyh-izdeliy-ot-i-do') ) :?>         
                  
                  
                  <ul class="js_pro-accordion-menu js_uroki">
                        <li><a href="<?php echo SITE?>/uroki-shitya">Оборудование для шитья</a>
                            <ul class="submenu">
                                <li><a href="<?php echo SITE?>/uroki-shitya/oborudovanie-dlya-shitya/shveynye-mashinki">Швейные машинки</a></li>
                                <li><a href="<?php echo SITE?>/uroki-shitya/oborudovanie-dlya-shitya/tkani">Ткани</a></li>
                                <li><a href="<?php echo SITE?>/uroki-shitya/oborudovanie-dlya-shitya/niti-i-shveynye-prinadlejnosti">Нити и швейные принадлежности</a></li>
                                <li><a href="<?php echo SITE?>/uroki-shitya/oborudovanie-dlya-shitya/vykroyki">Выкройки</a></li>
                                <li><a href="<?php echo SITE?>/uroki-shitya/oborudovanie-dlya-shitya/kak-snyat-merki">Как снять мерки</a></li>
                                <li><a href="<?php echo SITE?>/uroki-shitya/oborudovanie-dlya-shitya/stabilizatory-poverhnostey">Стабилизаторы поверхностей</a></li>
                            </ul>
                        </li>
                        <li><a href="<?php echo SITE?>/uroki-shitya/osnovnye-tehniki-shitya">Основные техники шитья</a></li>
                        <li><a href="<?php echo SITE?>/uroki-shitya/izgotovlenie-detaley-izdeliy">Изготовление деталей изделий</a></li>
                        <li><a href="<?php echo SITE?>/uroki-shitya/uroki-poshiva-gotovyh-izdeliy-ot-i-do">Уроки пошива готовых изделий от и до</a></li>
                    </ul>           
                  <?php endif; ?><!-- /Вывод меню "Уроки шитья" -->                  
                  <!-- Вывод меню "Голоссарий" -->
                  <?php if(URL::isSection('golossariy') 
                             || URL::isSection('golossariy/osnovnye-tehniki-shitya') 
                             || URL::isSection('golossariy/izgotovlenie-delaley-izdeliy') ) :?>                            
                       <ul class="js_pro-accordion-menu js_golossariyMenu">
                            <li><a href="<?php echo SITE?>/golossariy">Оборудование для шитья</a></li>
                            <li><a href="<?php echo SITE?>/golossariy/osnovnye-tehniki-shitya">Основные техники шитья</a></li>
                            <li><a href="<?php echo SITE?>/golossariy/izgotovlenie-delaley-izdeliy">Изготовление деталей изделий</a></li>
                        </ul>                  
                  <?php endif; ?><!-- /Вывод меню "Голоссарий" -->                   
                  <!-- Блок товаров в левой колонке -->
                    <?php if(URL::isSection('cart') || URL::isSection('order') ) :?>                   
                    
                  
                  	<div class="product-wrapper js_productLeftBlock">
                        <a href="/nabory-dlya-shitya-platev/nabory-vysokoy-slojnosti/nabor-dlya-shitya-goluboe-plate">
                            <div class="product-stickers">
                                <span class="sticker-new"></span>
                                <span class="sticker-recommend"></span>
                            </div>
                            <div class="product-image">                            
                                <img src="<?php echo PATH_SITE_TEMPLATE ?>/images/product/1.jpg" alt="image">
                            </div>
                            <div class="product-name">НАБОР ДЛЯ ШИТЬЯ "ГОЛУБОЕ ПЛАТЬЕ"</div>
                            <div class="product-price">1 141,78 руб.</div>
                          <span class="js_addToCart">Купить</span>
                        </a>
                    </div>                     
                    <div class="product-wrapper js_productLeftBlock">
                        <a href="/nabory-dlya-shitya-platev/nabory-vysokoy-slojnosti/nabor-dlya-shitya-goluboe-plate">
                            <div class="product-stickers">
                                <span class="sticker-new"></span>
                                <!--<span class="sticker-recommend"></span>-->
                            </div>
                            <div class="product-image">                            
                                <img src="<?php echo PATH_SITE_TEMPLATE ?>/images/product/1.jpg" alt="image">
                            </div>
                            <div class="product-name">НАБОР ДЛЯ ШИТЬЯ "ГОЛУБОЕ ПЛАТЬЕ"</div>
                            <div class="product-price">1 141,78 руб.</div>
                          <span class="js_addToCart">Купить</span>
                        </a>
                    </div>                      
                  
                  
                    <?php endif; ?><!-- /Блок товаров в левой колонке -->              
                </div><!-- end #js_left -->
                <?php } else {?>
                      <div style="width:960px;text-align:center"> 
                    <!--  <div class="top1"> 
  <div><div class="txt"><b>Мечтаете сшить себе платье или юбку? У Вас периодически возникает желание что-то творить и созидать?</b> <br>
Мечтаете своими руками сшить платье, юбку, брюки, но боитесь?! А вдруг не получится или испортите ткань? Или после покупки швейной машинки, скажите: “Зачем купила не попробовав шить!! <br>
Мы предлагаем Вам просто пошить выбрав простую модель! В итоге в 8 часов у Вас на руках будет готовое изделие, а в зависимости от сложности кроя возможно и не одно! <br>
Мы предлагаем Вам на выбор ткань. Ее Вы сможете выбрать на сайте. Благодаря красоте ткани Вы сможете сшить простое по крою изделие, но которое будет выглядеть красиво и  изыскано, а Вы в нем неповторимы!</div></div>
    <div class="top1_right"><div class="txt" style=""><h1>Схема работы сайта &ndash;Как самостоятельно составить комплект для ШИТЬЯ:</h1>
     1)	Выбираете сложность пошива<br>
2)	Выбираете модель для шитья (с фото)<br>
3)	Мы подобрали подходящие для данной модели ткани  - Вы выбираете!<br>
4)	Мы подобрали подходящую для данной модели фурнитуру  - Вы выбираете!<br>
5)	Добавляете если необходимо ткань для пробного пошива.<br>
6)	ПОЛУЧАЕТЕ БЕСПЛАТНО ВЫКРОЙКУ данной модели <br>
7)	ПОЛУЧАЕТЕ БЕСПЛАТНО инструкцию по номерам для данной модели
       </div>
   <input type="button" value="ЖМИ">
  </div>   
  </div>-->
                <?}?>                 
                <div id="js_center">
                    
                    
                    <!-- Слайдер на главной -->
                    <?php if(URL::isSection(null)): ?>
                    
                 <div style="" class="topb">
                    <!--   <div class="h">Новый вид шитья - ШИТЬЕ ПО НОМЕРАМ!</div>
					<div class="sublogo">Хотите научиться шить? Не знаете с чего начать?<br>
					Шейте с нами просто и быстро!!!<br>
					<font class="txt">Закажите набор для шитья и получите:</font>
					</div>
					<img border="0" src="uploads/mainp/logo_sub.jpg" style=""> 
					-->
                        <img border="0" src="uploads/mainp/logo-1-min.jpg" style="">       
                    <div>
                    <div class="c1" style="width: 155px;">
                     <div class="c1inn" style="">
                     <img border="0" style="" src="uploads/mainp/tkani-m-min.jpg">
                      Ткань
                      </div> 
                    </div> 
                    
                    <div style="" class="c1_p c1">     
                    </div>
                    <div style="width: 130px;" class="c1">
                     <div class="c1inn">
                     <img border="0" src="uploads/mainp/pugov-min.jpg" style="">
                      Пуговицы
                     </div>
                    </div>
                    <div class="c1_p c1">     
                    </div>
                    <div style="width: 135px;" class="c1">
                      <div class="c1inn">
                     <img border="0" src="uploads/mainp/molnii-min.jpg" style="">
                      Молнии
                        </div>
                    </div>
                    <div class="c1_p c1">     
                    </div>
                    <div style="width: 90px;" class="c1">
                     <div class="c1inn">
                     <img border="0" src="uploads/mainp/vikroika-min.jpg" style="">
                     Выкройка
                       </div>
                    </div>
                    </div>
                    <div class="js_clear"></div>
                   <div class="topb">
                     <div style="float: left; line-height: 200px; font-size: 60px; padding: 20px 30px 0px 100px;">=</div>
                      <img border="0" style="float: left;padding: 20px 0 0 0" src="uploads/mainp/k-min.jpg">
                      <div style="" class="podarok">Готовый <br> комлект <br>для шитья <br>своими руками</div>
                    </div>
                    
                    <img border="0" src="uploads/mainp/logo-2-min.jpg" style="padding: 35px;">
                    <div class="topb2" style="">
    <div style="" class="i1_n n">1</div>
    <img border="0" src="uploads/mainp/girl-min.jpg" style="top: 0px; left: 52px;">
    <div class="i1_t" style="">Разработали <br>стильные модели <br>для самостоятельного <br>шитья</div>
    <div class="i1_p p"></div>
    
    <div class="i2_n n">2</div>
    <img border="0" src="uploads/mainp/tkan-min.jpg" style="top: 110px; left: 450px;">
    <div style="" class="i2_t">Подобрали <br> для них ткани</div>
    <div class="i2_p p"></div>
    
    <div class="i3_n n">3</div>
    <img border="0" src="uploads/mainp/vikroika2-min.jpg" style="top: 318px; left: 35px;">
    <div class="i3_t" style="">Спроектировали<br>выкройки по<br>российским<br>лекалам</div>
    <div class="i3_p p"></div>
    
    <div class="i4_n n">4</div>
    <img border="0" src="uploads/mainp/pugov2-min.jpg" style="top: 440px; left: 410px;">
    <div class="i4_t" style="">Дополнили<br>необходимой фурнитурой</div>
    <div class="i4_p p"></div>
    
    <div class="i5_n n">5</div>
    <div class="i5_t" style="">Написали<br>инструкцию по<br>пошиву к<br>каждой модели</div>
  </div>
                     </div>
     

                  <!--  <div class="slider-home">
                        <ul>
                            <li><img src="<?php echo PATH_SITE_TEMPLATE ?>/images/slider-home/1.jpg" alt="image" /></li>
                            <li><img src="<?php echo PATH_SITE_TEMPLATE ?>/images/slider-home/2.jpg" alt="image" /></li>
                            <li><img src="<?php echo PATH_SITE_TEMPLATE ?>/images/slider-home/3.jpg" alt="image" /></li>
                          
                        </ul>
                    </div>-->
                    <?php endif; ?><!-- /Слайдер на главной -->
                   <?php if(URL::isSection(null)){ ?>
                   </div>
                   <?}?>
                    
                    <?php layout('content'); ?>
                </div>
            </article>
            
            
            
        </div>
        
        <div class="js_clear"></div>

        <footer>
            <div class="js_container">
                <!-- Подписка на рассылку -->               
                <div id="js_subscription">
                    <div id="outer_alignment">
                        <form class="sr-box" method="post" action="https://smartresponder.ru/subscribe.html" target="_blank" name="SR_form_1_58">
                            <ul class="sr-box-list">
                                <li class="js_text">НЕ ПРОПУСТИ НОВИНКИ! <br />
                                    <span>Подписаться на рассылку (Вы сможете отказаться <br /> от рассылки в любое время)</span></li>
                                <!--<li class="sr-1_58">
                                    <label class="remove_labels"></label>
                                    <input type="text" name="field_name_first" value="Ваше имя:">
                                </li>-->
                                <li class="sr-1_58">
                                    <label class="remove_labels"></label>
                                    <input type="text" name="field_email" class="sr-required" value="введите Ваш e-mail">
                                    <input type="submit" name="subscribe" value="Подписаться">
                                </li>
                            </ul>
                            <input type="hidden" name="uid" value="674649">
                            <input type="hidden" name="tid" value="0"><input type="hidden" name="lang" value="ru">
                            <input type="hidden" name="did[]" value="813978">
                            <input name="script_url_1_58" type="hidden" value="https://imgs.smartresponder.ru/on/068ee348492b3d48ea476cbf19c04e80266fdcaa/1_58">
                        </form>
                    </div>
                </div><!-- /Подписка на рассылку --> 
              
              
              <!--
                <ul class="js_socialLinks">
                    <li><a href="#" target="_blank">Одноклассники</a></li>
                    <li><a href="#" target="_blank">Фейсбук</a></li>
                    <li><a href="#" target="_blank">Вконтакте</a></li>
                </ul>
                -->
              
              
                <ul class="js_contacts">
                    <li>(926) 567-00-08 Мегафон</li>
                    <li>График: Пн-Вс 9:00-21:00</li>
                    <li><a href="mailto:info@pohoroshela.ru">info@pohoroshela.ru</a></li>
                </ul>
               
              
              
                <ul class="js_footerMenu">
                    <li><a href="/nabory-dlya-shitya-platev">Наборы для шитья</a></li>
                    <!--<li><a href="/uroki-shitya">Уроки шитья</a></li>
                    <li><a href="/golossariy">Голоссарий</a></li>-->
                    <li><a href="/contacts">Контакты</a></li>
                </ul>
                
              
              
                <div class="js_footerBlockMenu">
                  
                    <ul>
                        <li><a href="<?php echo SITE ?>">Главная</a></li>
                        <li><a href="/karta-sayta">Карта сайта</a></li>
                        <li><a href="/contacts">Контакты</a></li>
                    </ul>
                    
                  
                    <ul class="js_noTextDecoration">
                        <li><a href="/catalog">Каталог</a></li>
                        <li><a href="/nabory-dlya-shitya-platev">Наборы для шитья платьев</a></li>
                        <li><a href="/nabory-dlya-shitya-bluzok">Наборы для шитья блузок</a></li>
                        <!--<li><a href="/nabory-dlya-shitya-topov">Наборы для шитья топов</a></li>-->
                    </ul>
                    
                  
                    <ul class="js_noTextDecoration">
                        <li>&nbsp;</li>
                        <!--<li><a href="/nabory-dlya-shitya-kombinezonov">Наборы для шитья комбинезонов</a></li>-->
                        <li><a href="/nabory-dlya-shitya-bryuk-short">Наборы для шитья брюк, шорт</a></li>
                        
                      <li><a href="/nabory-dlya-shitya-yubok">Наборы для шитья юбок</a></li>

                        <!--<li><a href="/nabory-dlya-shitya-pidjakov">Наборы для шитья пиджаков</a></li>-->
                    </ul>
                    
                  
                    <ul>
                        <!--<li><a href="/dostavka-i-oplata">Доставка и оплата</a></li>-->
                        <li><a href="/group?type=latest">Новинки</a></li>
                        <li><a href="/group?type=recommend">Самые продаваемые</a></li>
                        <?php if($thisUser = $data['thisUser']): ?><li><a href="/personal">Личный кабинет</a></li><?php endif; ?>
                    </ul>
                  
                </div>
            </div>
        </footer>
      
        <div id="js_informer">
          	<i class="uk-icon-info-circle"></i>
          	<?php layout('widget'); ?>
      	</div>
                    
        <!--SING IN-->
        <div id="js_login" class="js_modal">
            <div class="js_modalDialog">
                <a class="js_close">X</a>
                <h3>Войти в кабинет</h3>
                <?php echo !empty($data[ 'msgError'])?$data[ 'msgError']: '' ?>
                <form action="<?php echo SITE ?>/enter" method="POST">
                    <ul class="form-list">
                        <li>
                            <input placeholder="Email*" type="text" name="email" value="<?php echo !empty($_POST['email'])?$_POST['email']:'' ?>">
                        </li>
                        <li>
                            <input placeholder="Пароль*" type="password" name="pass">
                        </li>
                    </ul>
                    <button type="submit" class="enter-btn default-btn uk-button">Войти</button> <a href="<?php echo SITE ?>/registration" class="create-account-btn">Зарегистрироваться</a>
                </form><a href="<?php echo SITE ?>/forgotpass" class="forgot-link">Забыли пароль?</a>
            </div>
        </div><!--/SING IN-->
      
     
      
    </body>
</html>