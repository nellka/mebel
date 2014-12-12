function TrimStr(s) {
  s = s.replace( /^\s+/g, '');
  return s.replace( /\s+$/g, '');
}

function set2biglightbox() {
        $(".simplebig:eq(0) .photos a, .simplebig:eq(0) .bigimg a").lightBox({
            imageLoading   : "/js/lightbox/images/lightbox-ico-loading.gif"
            ,imageBtnClose : "/js/lightbox/images/lightbox-btn-close.gif"
            ,imageBtnPrev  : "/js/lightbox/images/lightbox-btn-prev.gif"
            ,imageBtnNext  : "/js/lightbox/images/lightbox-btn-next.gif"
            ,imageBlank    : "/js/lightbox/images/lightbox-blank.gif"
			,txtImage: 'Фото'
			,txtOf: 'из'
			,text: {
				image: "Фото",
				of: "из"
			}
			,auto_resize:true

        });
		
        $(".simplebig:eq(1) .photos a, .simplebig:eq(1) .bigimg a").lightBox({
            imageLoading   : "/js/lightbox/images/lightbox-ico-loading.gif"
            ,imageBtnClose : "/js/lightbox/images/lightbox-btn-close.gif"
            ,imageBtnPrev  : "/js/lightbox/images/lightbox-btn-prev.gif"
            ,imageBtnNext  : "/js/lightbox/images/lightbox-btn-next.gif"
            ,imageBlank    : "/js/lightbox/images/lightbox-blank.gif"
			,txtImage: 'Фото'
			,txtOf: 'из'
			,text: {
				image: "Фото",
				of: "из"
			}
			,auto_resize:true

        });		

}