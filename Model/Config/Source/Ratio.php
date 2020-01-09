<?php
/**
 * Ratio.php
 *
 * @category  Webkul
 * @package   Webkul_MagicSlideShow
 * @author    Webkul
 * @copyright Copyright (c) 2010-2017 Webkul Software Private Limited (https://webkul.com)
 * @license   https://store.webkul.com/license.html
 */

namespace Webkul\MagicSlideShow\Model\Config\Source;

class Ratio implements \Magento\Framework\Option\ArrayInterface
{
    public function toOptionArray()
    {
        return [
            ['value' => '0', 'label' => __('Default')],
            ['value' => '1', 'label' => __('1:1')],
            ['value' => '2', 'label' => __('1:2')],
            ['value' => '3', 'label' => __('1:3')],
            ['value' => '4', 'label' => __('1:4')],
            ['value' => '5', 'label' => __('1:5')],
            ['value' => '34', 'label' => __('3:4')],
        ];
    }
}
