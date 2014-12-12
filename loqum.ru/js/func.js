$(document).ready(function(){   
    jQuery('input[placeholder], textarea[placeholder]').placeholder();

    //$('.sel-block').jqTransform();
    $('select').jqTransSelect();

    var galleries = $('.ad-gallery').adGallery({ update_window_hash:false,loader_image:"/js/lightbox/images/lightbox-ico-loading.gif" });

    $('div.ad-image-wrapper').on('click','img', function(event){
        $('a.ad-active').click();
//        var imgSrc = $(this).prop('src');
//        $('div#gallery img').each(function(key,elem){
//            if($(elem).prop('src') == imgSrc)
//                $(elem).css('border','solid 1px red');
//        });
        //}css('border','solid 2px red').parent().click();
    });

 });