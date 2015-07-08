(function (a) {
    a.fn.endlessScroll = function (b) {
        var c = {bottomPixels:400, fireOnce:true, fireDelay:0, contentTarget:"", callback:function () {
            return true
        }, resetCounter:function () {
            return false
        }, ceaseFire:function () {
            return false
        }, intervalFrequency:250};
        var b = a.extend({}, c, b), d = false, e = 0, f = false, g = this, h = a(".endless_scroll_inner_wrap", this), i;
        a(this).scroll(function () {
            f = true;
            g = this
        });
        setInterval(function () {
            if (f) {
                f = false;
                if (b.ceaseFire.apply(g, [e]) === true) {
                    return
                }
                if (g == document || g == window) {
                    if (b.contentTarget != "" && a(b.contentTarget).length) {
                        i = a(b.contentTarget).offset().top + a(b.contentTarget).height() - a(window).height() <= a(window).scrollTop() + b.bottomPixels
                    } else {
                        i = a(document).height() - a(window).height() <= a(window).scrollTop() + b.bottomPixels
                    }
                } else {
                    if (h.length == 0) {
                        h = a(g).wrapInner('<div class="endless_scroll_inner_wrap" />').find(".endless_scroll_inner_wrap")
                    }
                    i = h.length > 0 && h.height() - a(g).height() <= a(g).scrollTop() + b.bottomPixels
                }
                if (i && (b.fireOnce == false || b.fireOnce == true && d != true)) {
                    if (b.resetCounter.apply(g) === true) {
                        e = 0
                    }
                    d = true;
                    e++;
                    if (a.isFunction(b.beforeLoad)) {
                        b.beforeLoad.apply(g, [e])
                    }
                    b.callback.apply(g, [e, function () {
                        if (b.fireDelay !== false || b.fireDelay !== 0) {
                            setTimeout(function () {
                                d = false
                            }, b.fireDelay)
                        } else {
                            d = false
                        }
                    }])
                }
            }
        }, b.intervalFrequency)
    }
})(jQuery);

var product_total = 12;
var current_page = 1;
var text_showing = "text_showing";
var text_loading = "text_loading";

$(".el-p").hide();
$(".el-d").show();

$(window).endlessScroll({contentTarget:"#el-s", bottomPixels:400, fireOnce:false, callback:function (a, b) {
    $("#filterpro_page").val(++current_page);
    doFilter(false, false, true);
}, ceaseFire:function (a) {
    if (current_page >= Math.ceil(product_total / $("#filterpro_limit").val())) {
        return true
    }
    return false
}});
