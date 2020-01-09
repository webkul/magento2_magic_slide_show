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

use Webkul\MagicSlideShow\Controller\Adminhtml\Group as GroupController;
use Magento\Framework\Controller\ResultFactory;

class Edit extends GroupController
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
     * @var \Webkul\MagicSlideShow\Model\GroupFactory
     */
    protected $_group;

    /**
     * @param \Magento\Backend\App\Action\Context $context
     * @param \Magento\Framework\Registry $registry
     * @param \Webkul\MagicSlideShow\Model\GroupFactory $group
     */
    public function __construct(
        \Magento\Backend\App\Action\Context $context,
        \Magento\Framework\Registry $registry,
        \Webkul\MagicSlideShow\Model\GroupFactory $group
    ) {
        $this->_backendSession = $context->getSession();
        $this->_registry = $registry;
        $this->_group = $group;
        parent::__construct($context);
    }

    /**
     * @return \Magento\Backend\Model\View\Result\Page
     */
    public function execute()
    {
        $id = $this->getRequest()->getParam('id');
        $group = $this->_group->create();
        if ($this->getRequest()->getParam('id')) {
            $group->load($this->getRequest()->getParam('id'));
        }
        $data = $this->_backendSession->getFormData(true);
        if (!empty($data)) {
            $group->setData($data);
        }
        $this->_registry->register('magicslideshow_group', $group);
        $resultPage = $this->resultFactory->create(ResultFactory::TYPE_PAGE);
        $resultPage->getConfig()->getTitle()->prepend(__('Group'));
        $resultPage->getConfig()->getTitle()->prepend(
            $group->getId() ? $group->getTitle() : __('New Group')
        );
        $block = 'Webkul\MagicSlideShow\Block\Adminhtml\Group\Edit';
        $content = $resultPage->getLayout()->createBlock($block);
        $resultPage->addContent($content);
        $block = 'Webkul\MagicSlideShow\Block\Adminhtml\Group\Edit\Tabs';
        $left = $resultPage->getLayout()->createBlock($block);
        $resultPage->addLeft($left);
        return $resultPage;
    }
}
