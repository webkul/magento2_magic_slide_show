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
namespace Webkul\MagicSlideShow\Block\Adminhtml\Sliderimages;

/**
 * Adminhtml MagicSlideShow Sliderimages Edit
 */
class Edit extends \Magento\Backend\Block\Widget\Form\Container
{
    /**
     * Core registry
     *
     * @var \Magento\Framework\Registry
     */
    protected $_coreRegistry = null;

    /**
     * [__construct]
     * @param \Magento\Backend\Block\Widget\Context $context
     * @param \Magento\Framework\Registry           $registry
     * @param array                                 $data
     */
    public function __construct(
        \Magento\Backend\Block\Widget\Context $context,
        \Magento\Framework\Registry $registry,
        array $data = []
    ) {
        $this->_coreRegistry = $registry;
        parent::__construct($context, $data);
    }

    /**
     * Initialize MagicSlideShow Images Edit Block
     *
     * @return void
     */
    protected function _construct()
    {
        $this->_objectId = 'image_id';
        $this->_blockGroup = 'Webkul_MagicSlideShow';
        $this->_controller = 'adminhtml_sliderimages';
        parent::_construct();
        if ($this->_isAllowedAction('Webkul_MagicSlideShow::sliderimages')) {
            $this->buttonList->update('save', 'label', __('Save Image'));
        } else {
            $this->buttonList->remove('save');
        }
    }

    /**
     * Retrieve text for header element depending on loaded image
     *
     * @return \Magento\Framework\Phrase
     */
    public function getHeaderText()
    {
        if ($this->_coreRegistry->registry('magicslideshow_sliderimages')->getId()) {
            $title = $this->_coreRegistry->registry('magicslideshow_sliderimages')->getTitle();
            $title = $this->escapeHtml($title);
            return __("Edit Image '%'", $title);
        } else {
            return __('New Image');
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
