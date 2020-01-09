/**
 * Require-js
 *
 * @category  Webkul
 * @package   Webkul_MagicSlideShow
 * @author    Webkul
 * @copyright Copyright (c) 2010-2017 Webkul Software Private Limited (https://webkul.com)
 * @license   https://store.webkul.com/license.html
 */
var config = {
    "map": {
        "*": {
            "OwlCarousel": "Webkul_MagicSlideShow/js/owl.carousel.min",
            "WkMagicSlideShow": 'Webkul_MagicSlideShow/js/WkMagicSlideShow'
        }
    },
    "shim":{
        "Webkul_MagicSlideShow/js/owl.carousel.min": ["jquery"]
    }
};