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
namespace Webkul\MagicSlideShow\Controller\Adminhtml\Sliderimages;

use Webkul\MagicSlideShow\Controller\Adminhtml\Sliderimages as SliderimagesController;
use Magento\Framework\Controller\ResultFactory;
use Magento\Backend\App\Action;

/**
 * MagicSlideShow Adminhtml Sliderimages Edit Controller
 */
class Edit extends SliderimagesController
{
    /**
     * @var \Magento\MediaStorage\Model\File\UploaderFactory
     */
    protected $helper;

    /**
     * @param MagicSlideShow\Context             $context
     * @param \Webkul\MagicSlideShow\Helper\Data $helper
     */
    public function __construct(
        Action\Context $context,
        \Webkul\MagicSlideShow\Helper\Data $helper
    ) {
        $this->helper = $helper;
        parent::__construct($context);
    }

    /**
     * @return \Magento\Backend\Model\View\Result\Page
     */
    public function execute()
    {
        $params = $this->getRequest()->getParams();
        $sliderimagesModel = $this->helper->getSliderimagesModel();

        if (isset($params['id'])) {
            $sliderimagesModel->load($params['id']);
        }

        $data = $this->_objectManager->get('Magento\Backend\Model\Session')->getFormData(true);
        $sliderimagesModel['filename'] = $sliderimagesModel['link'];

        if (!empty($data)) {
            $sliderimagesModel->setData($data);
        }

        $this->_objectManager->get(
            'Magento\Framework\Registry'
        )->register('magicslideshow_sliderimages', $sliderimagesModel);

        $resultPage = $this->resultFactory->create(ResultFactory::TYPE_PAGE);
        $resultPage->getConfig()->getTitle()->prepend(__('Sliderimages'));
        $resultPage->getConfig()->getTitle()->prepend(
            $sliderimagesModel->getId() ? $sliderimagesModel->getTitle() : __('New Image')
        );

        $resultPage->addBreadcrumb(__('Manage Slider Images'), __('Manage Slider Images'));
        $content = $resultPage->getLayout()->createBlock('Webkul\MagicSlideShow\Block\Adminhtml\Sliderimages\Edit');
        $resultPage->addContent($content);

        return $resultPage;
    }
}
