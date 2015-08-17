<div class="clearfix"></div>

<?php /*if($this->config->get('lagon_twitter') != '') { ?>
<div class="grid_4">
	<div class="box">
    	<div class="box-heading"><span><?php echo $text_twitter; ?></span></div>
        <div class="box-content">
        	<div class="tweet"></div>
			<script>
                jQuery(function($){
                    $(".tweet").tweet({
						modpath: 'catalog/view/javascript/jquery/twitter/',
                        username: "<?php echo $this->config->get('lagon_twitter')?>",
                        avatar_size: 32,
                        count: 3,
                        loading_text: "loading tweets..."
                    });
                });
            </script>
        </div>
    </div>
</div>
<?php }*/ ?>
<?php /*if($this->config->get('lagon_facebook') != '') { ?>
<div class="grid_4">
	<div class="box">
    	<div class="box-heading"><span><?php echo $text_facebook; ?></span></div>
        <div class="box-content">
            <iframe src="//www.facebook.com/plugins/likebox.php?href=http%3A%2F%2Fwww.facebook.com%2F<?php echo $this->config->get('lagon_facebook')?>&amp;width=292&amp;height=258&amp;show_faces=true&amp;colorscheme=light&amp;stream=false&amp;border_color=%23fff&amp;header=false" scrolling="no" frameborder="0" style="border:none; overflow:hidden; width:100%; height:152px;" allowTransparency="true"></iframe>
        </div>
    </div>
</div>
<?php }*/ ?>
<footer>
<div class="grid_12" style="box-shadow: 0px 0px 20px #BDBDBD;background: #fff;">
	<div class="box">
    	<div class="box-content">
        <?php if ($informations) { ?>
        <div class="column">
            <div class="box-heading">
                <span><?php echo $text_information; ?></span>
           </div>
        <div class="box-category">
            <ul>
              <?php foreach ($informations as $information) { ?>
              <li><a href="<?php echo $information['href']; ?>"><?php echo $information['title']; ?></a></li>
              <?php } ?>
            </ul>
        </div>
        </div>
        <?php } ?>
        <div class="column">
        <div class="box-heading">
                <span><?php echo $text_service; ?></span>
           </div>
        <div class="box-category">
            <ul>
              <li><a href="<?php echo $contact; ?>"><?php echo $text_contact; ?></a></li>
              <li><a href="<?php echo $return; ?>"><?php echo $text_return; ?></a></li>
              <li><a href="<?php echo $sitemap; ?>"><?php echo $text_sitemap; ?></a></li>
            </ul>
        </div>
        </div>
        <div class="column">
        <div class="box-heading">
                <span><?php echo $text_extra; ?></span>
           </div>
        <div class="box-category">
            <ul>
              <li><a href="<?php echo $manufacturer; ?>"><?php echo $text_manufacturer; ?></a></li>
              <li><a href="<?php echo $voucher; ?>"><?php echo $text_voucher; ?></a></li>
              <li><a href="<?php echo $affiliate; ?>"><?php echo $text_affiliate; ?></a></li>
              <li><a href="<?php echo $special; ?>"><?php echo $text_special; ?></a></li>
            </ul>
        </div>
        </div>
        <div class="column">
        <div class="box-heading">
                <span><?php echo $text_account; ?></span>
           </div>
        <div class="box-category">
            <ul>
              <li><a href="<?php echo $account; ?>"><?php echo $text_account; ?></a></li>
              <li><a href="<?php echo $order; ?>"><?php echo $text_order; ?></a></li>
              <li><a href="<?php echo $wishlist; ?>"><?php echo $text_wishlist; ?></a></li>
              <li><a href="<?php echo $newsletter; ?>"><?php echo $text_newsletter; ?></a></li>
            </ul>
        </div>
        </div>
        <div class="clearfix"></div>
        
        <div id="powered">
        	<div class="poweredby"><!-- Yandex.Metrika informer --><a href="https://metrika.yandex.ru/stat/?id=31322343&amp;from=informer" target="_blank" rel="nofollow"><img src="//mc.yandex.ru/informer/31322343/3_1_FFFFFFFF_FFF0F5FF_0_pageviews" style="width:88px; height:31px; border:0;" alt="Яндекс.Метрика" title="Яндекс.Метрика: данные за сегодня (просмотры, визиты и уникальные посетители)" /></a><!-- /Yandex.Metrika informer --><!-- Yandex.Metrika counter --><script type="text/javascript">(function (d, w, c) { (w[c] = w[c] || []).push(function() { try { w.yaCounter31322343 = new Ya.Metrika({id:31322343, clickmap:true, trackHash:true}); } catch(e) { } }); var n = d.getElementsByTagName("script")[0], s = d.createElement("script"), f = function () { n.parentNode.insertBefore(s, n); }; s.type = "text/javascript"; s.async = true; s.src = (d.location.protocol == "https:" ? "https:" : "http:") + "//mc.yandex.ru/metrika/watch.js"; if (w.opera == "[object Opera]") { d.addEventListener("DOMContentLoaded", f, false); } else { f(); } })(document, window, "yandex_metrika_callbacks");</script><noscript><div><img src="//mc.yandex.ru/watch/31322343" style="position:absolute; left:-9999px;" alt="" /></div></noscript><!-- /Yandex.Metrika counter -->
        	Мебельный Интернет-Магазин Рублефф © 2015</div>
            <ul class="paymentIcons">
            	
            	<li>
                    <img src="catalog/view/theme/lagon/image/payment-icons/american-express.png" alt="">
                </li>
                
                <li>
                    <img src="catalog/view/theme/lagon/image/payment-icons/cashu.png" alt="">
                </li>
                
                <li>
                    <img src="catalog/view/theme/lagon/image/payment-icons/mastercard.png" alt="">
                </li>
                
                <li>
                    <img src="catalog/view/theme/lagon/image/payment-icons/world-pay.png" alt="">
                </li>
                
                <li>
                    <img src="catalog/view/theme/lagon/image/payment-icons/visa.png" alt="">
                </li>
                
                <li>
                    <img src="catalog/view/theme/lagon/image/payment-icons/visa-electron.png" alt="">
                </li>
                
                <li>
                    <img src="catalog/view/theme/lagon/image/payment-icons/paypal.png" alt="">
                </li>
                 
                <li>
                    <a href="http://ok.ru/group/52742313803953" target="_blank"><img src="catalog/view/theme/lagon/image/social-icons/ok.png" alt="" width="30"></a>
                </li>
                 
                <li>
                    <a href="http://vk.com/club95471972" target="_blank"><img src="catalog/view/theme/lagon/image/social-icons/v.png" alt="" width="30"></a>
                </li>
                 
                <li>
                    <a href="https://www.facebook.com/groups/1483202891998500/" target="_blank"><img src="catalog/view/theme/lagon/image/social-icons/fb.png" alt="" width="30"></a>
                </li>


            </ul>
        </div>
        
        </div>
	</div>
</div>


</footer>



</div>
</body></html>