(function($) {
    "use strict";
    $(document).on('ready', function() {

});
    })(jQuery);
/*$(".latest-product__slider").owlCarousel({
    loop: true,
    margin: 0,
    items: 1,
    dots: false,
    nav: true,
    navText: ["<span class='fa fa-angle-left'><span/>", "<span class='fa fa-angle-right'><span/>"],
    smartSpeed: 1200,
    autoHeight: false,
    autoplay: true
});*/
/*------------------
       Single Product
   --------------------*/
$('.product__details__pic__slider img').on('click', function () {

    var imgurl = $(this).data('imgbigurl');
    var bigImg = $('.product__details__pic__item--large').attr('src');
    if (imgurl != bigImg) {
        $('.product__details__pic__item--large').attr({
            src: imgurl
        });
    }
});

/*-------------------
    Quantity change
--------------------- */
var proQty = $('.pro-qty');
proQty.prepend('<span class="dec qtybtn">-</span>');
proQty.append('<span class="inc qtybtn">+</span>');
proQty.on('click', '.qtybtn', function () {
    var $button = $(this);
    var oldValue = $button.parent().find('input').val();
    if ($button.hasClass('inc')) {
        var newVal = parseFloat(oldValue) + 1;
    } else {
        // Don't allow decrementing below zero
        if (oldValue > 0) {
            var newVal = parseFloat(oldValue) - 1;
        } else {
            newVal = 0;
        }
    }
    $button.parent().find('input').val(newVal);
});
