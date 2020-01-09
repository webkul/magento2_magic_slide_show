/**
 * Webkul MagicSlideShow .ls
 *
 * @category  Webkul
 * @package   Webkul_MagicSlideShow
 * @author    Webkul
 * @copyright Copyright (c) 2010-2017 Webkul Software Private Limited (https://webkul.com)
 * @license   https://store.webkul.com/license.html
 */
define([
    "jquery","OwlCarousel",
    ], function ($) {
        $(function () {
            $(".wk_main").each(function () {
                var self = $(this);
                var adminprovidedwidth = self.data('width');
                var adminprovidedratio = self.data('ratio');
                var adminprovidedheight = self.data('height');
                var itemCount = (self.data('items')) != ''?self.data('items'):1;
                var responsivewidth= self.parent().width();
                var magicSlideShow = self.parent();
                var sliderwidth = responsiveWidth(adminprovidedwidth, responsivewidth);
                var sliderheight = heightOfImage(adminprovidedwidth, adminprovidedratio, adminprovidedheight);
    
                self.find('.wk_image').css("height", sliderheight);
                self.find('.owl-carousel').css("width", sliderwidth);
                var animate = (self.data('transitioneffect') == 'fadeOut') ? '"animateOut": "fadeOut"':'"animateOut": "slideOutDown", "animateIn": "flipInX"'
                self.find(".owl-carousel").owlCarousel({
                    items:itemCount,
                    loop:true,
                    margin:10,
                    autoplay:true,
                    autoplayTimeout: self.data('transitionTime'),
                    animate
                })
            })
            
            /**
             * get responsive width
             */
            function responsiveWidth(adminprovidedwidth, responsiveWidth)
            {
                if (adminprovidedwidth>responsiveWidth) {
                    return responsiveWidth;
                } else {
                    var width = (adminprovidedwidth*100)/responsiveWidth;
                    return (width+"%");
                }
            }

            /**
             * get height of Image
             */
            function heightOfImage(width, adminprovidedratio, adminprovidedheight)
            {
                if (adminprovidedheight == '') {
                    if (adminprovidedratio == 1) {
                        return width;
                    } else if (adminprovidedratio == 2) {
                        return width/2;
                    } else if (adminprovidedratio == 3) {
                        return width/3;
                    } else if (adminprovidedratio == 4) {
                        return width/4;
                    } else if (adminprovidedratio == 5) {
                        return width/5;
                    } else if (adminprovidedratio == 34) {
                        return (width*3)/4;
                    }
                } else {
                    return adminprovidedheight;
                }
            }
            
        });
});
