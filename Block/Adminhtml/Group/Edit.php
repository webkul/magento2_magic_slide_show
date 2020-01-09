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
namespace Webkul\MagicSlideShow\Block\Adminhtml\Group;

class Edit extends \Magento\Backend\Block\Widget\Form\Container
{
    /**
     * Initialize MagicSlideShow Group Edit Block
     *
     * @return void
     */
    protected function _construct()
    {
        $this->_objectId = 'group_id';
        $this->_blockGroup = 'Webkul_MagicSlideShow';
        $this->_controller = 'adminhtml_group';
        parent::_construct();
        if ($this->_isAllowedAction('Webkul_MagicSlideShow::group')) {
            $this->buttonList->update('save', 'label', __('Save Group'));
        } else {
            $this->buttonList->remove('save');
        }
    }

    /**
     * Retrieve text for header element depending on loaded Group
     *
     * @return \Magento\Framework\Phrase
     */
    public function getHeaderText()
    {
        if ($this->_coreRegistry->registry('magicslideshow_group')->getId()) {
            $title = $this->_coreRegistry->registry('magicslideshow_group')->getTitle();
            $title = $this->escapeHtml($title);
            return __("Edit Group '%'", $title);
        } else {
            return __('New Group');
        }
    }

    /**
     * Check permission for passed action
     *
     * @param string $resourceId
     * @return bool
     */
    protected function _isAllowedAction($resourceId)
    {
        return $this->_authorization->isAllowed($resourceId);
    }
}
