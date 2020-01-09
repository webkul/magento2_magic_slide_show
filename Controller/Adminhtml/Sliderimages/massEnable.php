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
 * MagicSlideShow Adminhtml Sliderimages massEnable Controller
 */
class massEnable extends \Magento\Backend\App\Action
{
    /**
     * @var \Magento\MediaStorage\Model\File\UploaderFactory $fileUploaderFactory
     */
    protected $_fileUploaderFactory;

    /**
     * @param Action\Context $context
     * @param \Magento\MediaStorage\Model\File\UploaderFactory $fileUploaderFactory
     */
    public function __construct(
        Action\Context $context,
        \Magento\MediaStorage\Model\File\UploaderFactory $fileUploaderFactory
    ) {
    
        $this->_fileUploaderFactory = $fileUploaderFactory;
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
            $image->setStatus(1);
            $image->save();
        }
        
        $this->messageManager->addSuccess(__('Status set to "enabled" successfully.'));
        $resultRedirect = $this->resultRedirectFactory->create();
        return $resultRedirect->setPath('*/*/');
    }
}
