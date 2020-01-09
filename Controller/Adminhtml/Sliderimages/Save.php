<?php
/**
 * Webkul Software.
 *
 * @category   Webkul
 * @package    Webkul_MagicSlideShow
 * @author     Webkul Software Private Limited
 * @copyright  Copyright (c) 2010-2017 Webkul Software Private Limited (https://webkul.com)
 * @license    https://store.webkul.com/license.html
 */
namespace Webkul\MagicSlideShow\Controller\Adminhtml\Sliderimages;

use Magento\Framework\App\Filesystem\DirectoryList;
use Magento\Backend\App\Action;

/**
 * MagicSlideShow Adminhtml Sliderimages Save Controller
 */
class Save extends \Magento\Backend\App\Action
{
    /**
     * @var \Magento\MediaStorage\Model\File\UploaderFactory
     */
    protected $_fileUploaderFactory;

    /**
     * @var \Webkul\MagicSlideShow\Helper\Data
     */
    protected $helper;

    /**
     * @param Action\Context                                   $context
     * @param \Magento\MediaStorage\Model\File\UploaderFactory $fileUploaderFactory
     * @param \Webkul\MagicSlideShow\Helper\Data                       $helper
     */
    public function __construct(
        Action\Context $context,
        \Magento\MediaStorage\Model\File\UploaderFactory $fileUploaderFactory,
        \Webkul\MagicSlideShow\Helper\Data $helper
    ) {
        $this->_fileUploaderFactory = $fileUploaderFactory;
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
     * Save action.
     *
     * @return \Magento\Framework\Controller\ResultInterface
     */
    public function execute()
    {
        $time = date('Y-m-d H:i:s');
        $resultRedirect = $this->resultRedirectFactory->create();
        $imageData = [];
        $error = 0;
        $isDelete = false;
        $msg = "";
        $data = $this->getRequest()->getParams();

        try {
            $image = $this->checkFileUpload($data);

            if (isset($image['error']) && $image['error']==1) {
                $error = 1;
                $msg = $image['msg'];
            } elseif (isset($image['image']['tmp_name'])
                && $image['image']['tmp_name'] !== ''
                && $image['image']['tmp_name'] !== null
            ) {
                $isDelete = $image['delete'];
                $result = $this->uploadImageForSlider($image['image']);

                if (isset($result['error']) && (int)$result['error']==1) {
                    $error = 1;
                    $msg = $result['msg'];
                } else {
                    $imageData = $result;
                }
            }

            if ($error == 1) {
                $this->messageManager->addError($msg);
                if (isset($data['id']) && $data['id']!==0) {
                    return $resultRedirect->setPath(
                        '*/*/edit',
                        ['id' => $data['id'], '_current' => true]
                    );
                }
                return $resultRedirect->setPath('*/*/');
            } else {
                if ($data) {
                    if ($isDelete && isset($data['filename']['value'])) {
                        $this->helper->deleteUploadedFile($isDelete, $data['filename']['value']);
                    }

                    if (!empty($imageData['filename'])) {
                        $data['filename'] = $imageData['filename'];
                    } else {
                        unset($data['filename']);
                    }

                    if (!empty($imageData['link'])) {
                        $data['link'] = $imageData['link'];
                    } else {
                        unset($data['link']);
                    }

                    $model = $this->helper->getSliderimagesModel();
                    $data['update_time'] = $time;

                    if (isset($data['id']) && $data['id']!==0) {
                        $model->addData($data)->setId($data['id'])->save();
                    } else {
                        $data['created_time'] = $time;
                        $model->setData($data)->save();
                    }
                }

                $this->messageManager->addSuccess(__('Image saved successfully.'));

                if (isset($data['id']) && $data['id']!==0) {
                    return $resultRedirect->setPath(
                        '*/*/edit',
                        ['id' => $data['id'], '_current' => true]
                    );
                }

                return $resultRedirect->setPath('*/*/');
            }
        } catch (\Exception $e) {
            $this->messageManager->addError($e->getMessage());

            if (isset($data['id']) && $data['id']!==0) {
                return $resultRedirect->setPath(
                    '*/*/edit',
                    ['id' => $data['id'], '_current' => true]
                );
            }

            return $resultRedirect->setPath('*/*/');
        }
    }

    /**
     * [checkFileUpload used to validate file]
     * @param  array $data
     * @return array
     */
    public function checkFileUpload($data)
    {
        $errors = [];
        $isDelete = false;
        if (isset($data['id']) && isset($data['filename'])) {
            if (isset($data['filename']['delete'])
                && $data['filename']['delete']==1
            ) {
                $isDelete = true;
                $image = $this->getFileUploader();

                if ($image['tmp_name']!=="") {
                    return [
                        'delete' => $isDelete,
                        'image' => $image
                    ];
                } else {
                    $errors['error'] = 1;
                    $errors['msg'] = __('Please upload an image for Slider');
                    return $errors;
                }
            }
        } else {
            $image = $this->getFileUploader();
            if ($image['tmp_name']!=="") {
                return [
                    'delete' => $isDelete,
                    'image' => $image
                ];
            } else {
                $errors['error'] = 1;
                $errors['msg'] = __('Please upload an image for Slider');
                return $errors;
            }
        }
    }

    /**
     * [getFileUploader used to get File uploader]
     * @return object
     */
    public function getFileUploader()
    {
        $uploader = $this->_fileUploaderFactory
            ->create(
                ['fileId' => 'filename']
            );
        $uploader->setAllowedExtensions(['jpg', 'jpeg', 'gif', 'png']);
        $uploader->setAllowRenameFiles(false);
        $uploader->setFilesDispersion(false);
        $image = $uploader->validateFile();

        return $image;
    }

    /**
     * [uploadImageForSlider upload images for slider on homepage]
     * @param  array $image
     * @return array
     */
    public function uploadImageForSlider($image)
    {
        $errors = [];
        $imageData = [];
        $check = getimagesize($image['tmp_name']);
        if (!$check) {
            $errors['error'] = 1;
            $errors['msg'] = __('Invalid File.');
            return $errors;
        } else {
            $splitname = explode('.', $image['name']);
            $ext=end($splitname);
            $allowedExtensions = $this->helper->getAllowedExtensions(false);
            if (in_array($ext, $allowedExtensions)) {
                $imageUploadPath = $this->_objectManager->get('Magento\Framework\Filesystem')
                    ->getDirectoryRead(DirectoryList::MEDIA)
                    ->getAbsolutePath($this->helper->getSliderImagePath());

                if (!is_dir($imageUploadPath)) {
                    mkdir($imageUploadPath, 0755, true);
                }
                $imageName = 'File-'.time().'.'.$ext;
                $uploader = $this->_fileUploaderFactory
                    ->create(
                        ['fileId' => 'filename']
                    );
                $uploader->setAllowedExtensions($allowedExtensions);
                $uploader->setAllowRenameFiles(true);
                $uploader->setFilesDispersion(false);
                $result = $uploader->save($imageUploadPath, $imageName);
                $imageData['link'] = $this->helper->getSliderImagePath().$imageName;
                $imageData['filename'] = $imageName;
                chmod($imageUploadPath.$imageName, 0644);

                if (isset($result['error'])
                    && $result['error']!==0) {
                    $errors['error'] = 1;
                    $errors['msg'] = __(
                        '%1 Image Not Uploaded',
                        $image['name']
                    );
                    return $errors;
                } else {
                    return $imageData;
                }
            } else {
                $errors['error'] = 1;
                $errors['msg'] = __(
                    'Invalid File Type. Please upload valid file type from %1',
                    implode(",", $allowedExtensions)
                );
                return $errors;
            }
        }
    }
}
