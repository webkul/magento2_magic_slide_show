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

use Magento\Backend\App\Action;

class Save extends \Magento\Backend\App\Action
{
    /**
     * @var \Webkul\MagicSlideShow\Model\GroupFactory
     */
    protected $_group;

    /**
     * @param Action\Context $context
     * @param \Webkul\MagicSlideShow\Model\groupFactory $group
     */
    public function __construct(
        Action\Context $context,
        \Webkul\MagicSlideShow\Model\GroupFactory $group
    ) {
        $this->_group = $group;
        parent::__construct($context);
    }

    /**
     * {@inheritdoc}
     */
    protected function _isAllowed()
    {
        return $this->_authorization->isAllowed('Webkul_MagicSlideShow::group');
    }

    /**
     * Save action.
     *
     * @return \Magento\Framework\Controller\ResultInterface
     */
    public function execute()
    {
        $flag = false;
        $reserveId = 0;
        $resultRedirect = $this->resultRedirectFactory->create();
        $data = $this->getRequest()->getPostValue();
       
        if (!empty($data)) {
            $model = $this->_group->create();
            $collection = $model->getCollection();
            $collection->addFieldToFilter('code', $data['code']);
            $id = $this->getRequest()->getParam('id');
            if ($data['image_ids']=='') {
                unset($data['image_ids']);
            }
            foreach ($collection as $item) {
                if ($item->getData('id')) {
                    $flag = true;
                    $reserveId = $item->getData('id');
                    break;
                }
            }
            if (!empty($data)) {
                $error = 'Group code already exist';
                if ($id) {
                    if ($id != $reserveId) {
                        if ($flag) {
                            $this->messageManager
                                ->addError(__($error));
                            $params = ['id' => $id, '_current' => true];
                            return $resultRedirect->setPath('*/*/edit', $params);
                        }
                    }
                    $model->addData($data)->setId($id)->save();
                } else {
                    if ($flag) {
                        $this->messageManager->addError(__($error));
                        return $resultRedirect->setPath('*/*/');
                    }
                    $model->setData($data)->save();
                }
            }
            $this->messageManager->addSuccess(__('Group saved successfully'));
            return $resultRedirect->setPath('*/*/');
        } else {
            $this->messageManager->addError(__('Some error occured while saving the group.'));
            return $resultRedirect->setPath('*/*/');
        }
    }
}
