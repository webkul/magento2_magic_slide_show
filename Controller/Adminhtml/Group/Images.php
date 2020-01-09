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
namespace Webkul\MagicSlideShow\Controller\Adminhtml\Group;

class Images extends \Webkul\MagicSlideShow\Controller\Adminhtml\Group
{
    /**
     * @var \Magento\Backend\Model\Session
     */
    protected $_backendSession;

    /**
     * @var \Magento\Framework\Registry
     */
    protected $_registry;

    /**
     * @var \Webkul\MagicSlideShow\Model\GalleryFactory
     */
    protected $_group;

    /**
     * @var \Magento\Framework\View\Result\LayoutFactory
     */
    protected $_resultLayoutFactory;

    /**
     * @param \Magento\Backend\App\Action\Context $context
     * @param \Magento\Framework\Registry $registry
     * @param \Webkul\MagicSlideShow\Model\GroupFactory $group
     * @param \Magento\Framework\View\Result\LayoutFactory $resultLayoutFactory
     */
    public function __construct(
        \Magento\Backend\App\Action\Context $context,
        \Magento\Framework\Registry $registry,
        \Webkul\MagicSlideShow\Model\GroupFactory $group,
        \Magento\Framework\View\Result\LayoutFactory $resultLayoutFactory
    ) {
        $this->_backendSession = $context->getSession();
        $this->_registry = $registry;
        $this->_group = $group;
        $this->_resultLayoutFactory = $resultLayoutFactory;
        parent::__construct($context);
    }

    /**
     * @return \Magento\Framework\View\Result\Layout
     */
    public function execute()
    {
        $group= $this->_group->create();
        if ($this->getRequest()->getParam('id')) {
            $group->load($this->getRequest()->getParam('id'));
        }
        $data = $this->_backendSession->getFormData(true);
        if (!empty($data)) {
            $group->setData($data);
        }
        $this->_registry->register('magicslideshow_group', $group);
        $resultLayout = $this->_resultLayoutFactory->create();
        $resultLayout->getLayout()
                    ->getBlock('magicslideshow.group.edit.tab.images');
        return $resultLayout;
    }
}
