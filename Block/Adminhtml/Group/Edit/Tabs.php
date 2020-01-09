<?php
/**
 * Webkul Software.
 *
 * @category  Webkul
 * @package   Webkul_MagicSlideShow
 * @author    Webkul
 * @copyright Copyright (c) 2010-2016 Webkul Software Private Limited (https://webkul.com)
 * @license   https://store.webkul.com/license.html
 */
namespace Webkul\MagicSlideShow\Block\Adminhtml\Group\Edit;

class Tabs extends \Magento\Backend\Block\Widget\Tabs
{
    /**
     * @return void
     */
    protected function _construct()
    {
        parent::_construct();
        $this->setId('group_tabs');
        $this->setDestElementId('edit_form');
        $this->setTitle(__('Group Information'));
    }

    /**
     * Prepare Layout
     *
     * @return $this
     */
    protected function _prepareLayout()
    {
        $block = 'Webkul\MagicSlideShow\Block\Adminhtml\Group\Edit\Tab\Group';
        $this->addTab(
            'group',
            [
                'label' => __('Group'),
                'content' => $this->getLayout()->createBlock($block, 'group')->toHtml(),
            ]
        );
        $this->addTab(
            'images',
            [
                'label' => __('Group Images'),
                'url' => $this->getUrl('magicslideshow/*/images', ['_current' => true]),
                'class' => 'ajax'
            ]
        );
        return parent::_prepareLayout();
    }
}
