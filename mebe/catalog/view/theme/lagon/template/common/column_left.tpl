<div class="flexslider"></div>
<?php if ($modules) { ?>
<div id="column-left" class="grid_3">


  <?php foreach ($modules as $module) { ?>
  <?php echo $module; ?>
  <?php } ?>



<?php if($this->config->get('lagon_phone') != '') { ?>

	<div class="box">
    	<div class="box-heading"><span>Контакты</span></div>
        <div class="box-content">
        	<ul class="footerBoxes">
            
            	<?php if($this->config->get('lagon_address') != '') { ?>
            	<li>
                	<div class="colorBg"><img src="catalog/view/theme/lagon/image/address.png" alt="" ></div>
                    <?php echo $this->config->get('lagon_address')?>
                </li>
                <?php } ?>
                
                <?php if($this->config->get('lagon_phone') != '') { ?>
                <li>
                	<div class="colorBg"><img src="catalog/view/theme/lagon/image/phone.png" alt="" ></div>
                    <?php echo $this->config->get('lagon_phone')?> <br /><?php echo $this->config->get('lagon_phone_second')?>
                </li>
                <?php } ?>
                
                <?php if($this->config->get('lagon_email') != '') { ?>
                <li>
                	<div class="colorBg"><img src="catalog/view/theme/lagon/image/mail.png" alt="" ></div>
                    <a href="mailto:<?php echo $this->config->get('lagon_email')?>"><?php echo $this->config->get('lagon_email')?></a> <br />
                    <a href="mailto:<?php echo $this->config->get('lagon_email_second')?>"><?php echo $this->config->get('lagon_email_second')?></a>
                </li>
                <?php } ?>
                 <li>
                	<div style="background: none"  class="colorBg"><img src="catalog/view/theme/lagon/image/social-icons/vk.png" alt="" ></div>
                    <span style='line-height: 25px;'>Мы в социальных сетях</span><br>
                    <a href="http://ok.ru/group/52742313803953" target="_blank"><img src="catalog/view/theme/lagon/image/social-icons/ok.png" alt="" width="30"></a>               
                    <a href="http://vk.com/club95471972" target="_blank"><img src="catalog/view/theme/lagon/image/social-icons/vk.jpg" alt="" width="30"></a>               
                    <a href="https://www.facebook.com/groups/1483202891998500/" target="_blank"><img src="catalog/view/theme/lagon/image/social-icons/fb.png" alt="" width="30"></a>              
                    
                </li>
                
            </ul>
        </div>
    </div>

<?php } ?>
</div>
<?php } ?> 