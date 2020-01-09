<?php
/**
 * Webkul Software.
 *
 * @category  Webkul
 * @package   Webkul_MagicSlideShow
 * @author    Webkul
 * @copyright Copyright (c) 2010-2017 Webkul Software Private Limited (https://webkul.com)
 * @license   https://store.webkul.com/license.html
 */
namespace Webkul\MagicSlideShow\Block\Adminhtml\Sliderimages\Edit;

/**
 * Adminhtml MagicSlideShow Sliderimages Edit Tab
 */
class Tabs extends \Magento\Backend\Block\Widget\Tabs
{
    /**
     * @return void
     */
    protected function _construct()
    {
        parent::_construct();
        $this->setId('sliderimages_tabs');
        $this->setDestElementId('edit_form');
        $this->setTitle(__('Slider Images Information'));
    }
}
