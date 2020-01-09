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

use Magento\Framework\App\Filesystem\DirectoryList;
use Magento\Backend\App\Action;
use Magento\TestFramework\ErrorLog\Logger;

/**
 * MagicSlideShow Adminhtml Sliderimages massDelete Controller
 */
class massDelete extends \Magento\Backend\App\Action
{
    /**
     * @var \Webkul\MagicSlideShow\Helper\Data
     */
    protected $helper;

    /**
     * @param Action\Context             $context
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
     * {@inheritdoc}
     */
    protected function _isAllowed()
    {
        return $this->_authorization->isAllowed('Webkul_MagicSlideShow::sliderimages');
    }

    /**
     * @return \Magento\Framework\Controller\ResultInterface
     */
    public function execute()
    {

        $sliderimagesModel = $this->_objectManager->create('Webkul\MagicSlideShow\Model\Sliderimages');
        $model = $this->_objectManager->create('Magento\Ui\Component\MassAction\Filter');
        $collection = $model->getCollection($sliderimagesModel->getCollection());

        foreach ($collection as $image) {
            $this->helper->deleteUploadedFile(true, $image['link']);
            $image->delete();
        }
        
        $this->messageManager->addSuccess(__('Image(s) deleted successfully.'));
        $resultRedirect = $this->resultRedirectFactory->create();
        return $resultRedirect->setPath('*/*/');
    }
}
