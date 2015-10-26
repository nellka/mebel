<?if(URL::getClearUri()=='/main'){
  	 require('template_last_2.php');
  } else {?><!DOCTYPE html>
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
                           <img src="http://pohoroshela.ru/uploads/fraza.png" border="0" style="padding: 0 20px; width: 665px;">
                        </ul>                       
                    </nav>
                     <div id="menuar"></div>
                    <ul class="js_topContacts">
                        <li>Тел. 926-567-00-08</li>
                        <li>Магазин-склад: Москва, Нижняя Сыромятническая улица, 10</li>
                    </ul>
                </div>
            </header>
          
          
          
            
            <div class="js_clear"></div>
          
          
          
            
            <article>
                <div id="js_left">
                    <?php filterCatalog();?>
                    <!-- Вывод каталога -->
                    <?php if(MG::get('controller')=="controllers_product" || MG::get('controller')=="controllers_catalog") :?>
                        <nav><?php layout('leftmenu'); ?></nav>
                    <?php  endif; ?>
                    <?php if(URL::isSection(null) || URL::getClearUri()=='/contacts' || URL::getClearUri()=='/personal' || URL::getClearUri()=='/o-nas' || URL::getClearUri()=='/enter' || URL::getClearUri()=='/registration' || URL::getClearUri()=='/forgotpass' || URL::getClearUri()=='/karta-sayta' || URL::getClearUri()=='/dostavka-i-oplata') : ?>
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
                
                
                
                
                
                <div id="js_center">
                    
                    
                    <!-- Слайдер на главной -->
                    <?php if(URL::isSection(null)): ?>
                    <img src="uploads/top-img-min.jpg" border=0>
                    <div class="slider-home">
                        <ul>
                            <li><img src="<?php echo PATH_SITE_TEMPLATE ?>/images/slider-home/1.jpg" alt="image" /></li>
                            <li><img src="<?php echo PATH_SITE_TEMPLATE ?>/images/slider-home/2.jpg" alt="image" /></li>
                            <li><img src="<?php echo PATH_SITE_TEMPLATE ?>/images/slider-home/3.jpg" alt="image" /></li>
                          
                        </ul>
                    </div>
                    <?php endif; ?><!-- /Слайдер на главной -->
                    
                    
                    <?php layout('content'); ?>
                    <?php if(URL::isSection(null)): ?>
                      <p>Платья, пожалуй, самый важный элемент женского гардероба. Они никогда не выходят из моды, всегда актуальны и подходят на любой случай. Но очень часто бывает так, что в магазинах предлагают платья, которые «не совсем то, что хотелось бы» или не подходят по цене.  Как же быть? Выход есть – сшить платье своими руками!</p>
 <p>Сшить платье самостоятельно – это не просто, но возможно. Достаточно только большого желания научиться это делать, немного времени и купить набор для шитья в магазине «Похорошела». </p>
<h2 class="js_contentTitle" style="">Как быстро сшить простое платье самой?</h2>
 <p>Для этого вам понадобится выбрать набор для начинающих с понравившейся моделью и выкройкой платья. Данный набор включает в себя все, что нужно для шитья (кроме машинки). Вы вбираете модель, заказываете ее и снимаете выкройку платья в соответствии со своим размером. Немного сноровки и терпения – вуаля – платье готово!</p>
<h2 class="js_contentTitle" style="">Что предлагает Вам магазин шитья «Похорошела»:</h2>
	<ul class="js_list" style=""><li> </li>
	<li> выкройки летних платьев</li>
<li> выкройки простых платьев для начинающих</li>
<li> выкройки деловых и офисных платьев</li>
<li> выкройки вечерних и выпускных платьев</li>
<li> выкройки коктейльных платьев</li>
<li> выкройки платьев на каждый день</li>
<li> выкройки сарафанов и многое другое.</li>
</ul>

 <p>В магазинах и на прилавках самое простое и недорогое платье стоит от 3500 руб. В нашем  магазине же Вы найдете модели и выкройки красивых, оригинальных и необычных платьев всего от 2000 руб. – и это полный набор, включая ткань! Конечно, научиться шить наряды своими руками значительно выгоднее, чем покупать готовые изделия! У нас действительно есть из чего выбрать: разнообразие тканей, фасонов, моделей – с нами Вы научитесь шить не одно платье, а разные, начиная от простых платьев до сложных модельных изделий в пол. <br>
<b>С нашими наборами шить платья самостоятельно легко и просто!</b></p>
                    <?php endif; ?>
                   
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
<?}?>