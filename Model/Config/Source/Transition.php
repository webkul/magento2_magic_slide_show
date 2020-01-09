<?php
/**
 * Transition.php
 *
 * @category  Webkul
 * @package   Webkul_MagicSlideShow
 * @author    Webkul
 * @copyright Copyright (c) 2010-2017 Webkul Software Private Limited (https://webkul.com)
 * @license   https://store.webkul.com/license.html
 */

namespace Webkul\MagicSlideShow\Model\Config\Source;

class Transition implements \Magento\Framework\Option\ArrayInterface
{
    public function toOptionArray()
    {
        return [
            ['value' => 'slide', 'label' => __('Slide Show')],
            ['value' => 'fade', 'label' => __('Fade In/Out')]
        ];
    }
}
