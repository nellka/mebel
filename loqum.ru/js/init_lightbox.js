lightboxconfig =
{
            imageLoading   : "/js/lightbox/images/lightbox-ico-loading.gif"
            ,imageBtnClose : "/js/lightbox/images/lightbox-btn-close.gif"
            ,imageBtnPrev  : "/js/lightbox/images/lightbox-btn-prev.gif"
            ,imageBtnNext  : "/js/lightbox/images/lightbox-blank.gif"
            ,imageBlank    : "/js/lightbox/images/lightbox-blank.gif"
			,txtImage: 'Фото'
			,txtOf: 'из'
			,text: {
				image: "Фото",
				of: "из"
			}
			,auto_resize:true

        };
    $(function() {
        $("#photos a, .photos a, a[rel=lightbox]").lightBox(lightboxconfig);
    });

