<?php
/**
 * Helper to add slider.
 *
 * @category  Webkul
 * @package   Webkul_MagicSlideShow
 * @author    Webkul
 * @copyright Copyright (c) 2010-2017 Webkul Software Private Limited (https://webkul.com)
 * @license   https://store.webkul.com/license.html
 */

namespace Webkul\MagicSlideShow\Helper;

use Magento\Catalog\Block\Product\Context;
use Magento\Store\Model\StoreManagerInterface;
use Magento\Widget\Model\ResourceModel\Widget;
use Magento\Framework\Filesystem\Driver;
use Magento\Framework\App\Filesystem\DirectoryList;

class Data extends \Magento\Framework\App\Helper\AbstractHelper
{
    /**
     * $storeManager
     */
    protected $storeManager;

    /**
     * $context
     */
    protected $context;

    /**
     * $directoryList
     */
    protected $directoryList;

    /**
     * $widget
     */
    protected $widget;

    /**
     * $driver
     */
    protected $driver;

    /**
     * [__construct description]
     * @param MagentoFrameworkAppHelperContext           $context
     * @param MagentoFrameworkAppFilesystemDirectoryList $directorylist
     * @param MagentoWidgetModelResourceModelWidget      $widget
     * @param WebkulMagicSlideShowBlockWidgetSlider      $slider
     * @param MagentoFrameworkFilesystemDriverFile       $file
     * @param StoreManagerInterface                      $storeManager
     */
    public function __construct(
        \Magento\Framework\App\Helper\Context $context,
        \Magento\Framework\App\Filesystem\DirectoryList $directorylist,
        \Magento\Widget\Model\ResourceModel\Widget $widget,
        \Magento\Framework\Filesystem\Driver\File $file,
        StoreManagerInterface $storeManager
    ) {
        parent::__construct($context);
        $this->storeManager = $storeManager;
        $this->directoryList = $directorylist;
        $this->widget = $widget;
        $this->driver = $file;
    }

    /**
     * getDiectoryPath
     * @return directory path of media
     */
    public function getDiectoryPath()
    {
        $objectManager =$this->directoryList->getPath('media');
        return $objectManager;
    }

    /**
     * getImageDir
     * @return directory path where image is stored]
     */
    public function getImageDir()
    {
        $baseDir = $this->getDiectoryPath();
        $dir = $baseDir.'/MagicSlideShow/images/';
        return $dir;
    }

    /**
     * getImagesUrl
     * @return baseUrl of images
     */
    public function getImagesUrl()
    {
        $baseUrl = $this->storeManager->getStore()->getBaseUrl(\Magento\Framework\UrlInterface::URL_TYPE_MEDIA);
        return $baseUrl;
    }

    /**
     * getFileDriver
     * @return object
     */
    public function getFileDriver()
    {
        return $this->driver;
    }

    /**
     * getAllowedExtensions used to get allowed extension for image
     * @param  boolean $flag
     * @return array
     */
    public function getAllowedExtensions($flag)
    {
        if ($flag) {
            return ['\'gif\'','\'png\'','\'jpg\'','\'jpeg\''];
        } else {
            return ['gif','png','jpg','jpeg'];
        }
    }

    /**
     * getSliderimagesModel
     * @return object
     */
    public function getSliderimagesModel()
    {
        $objectManager = \Magento\Framework\App\ObjectManager::getInstance();
        return $objectManager->create('Webkul\MagicSlideShow\Model\Sliderimages');
    }

    /**
     * getSliderImagePath get upload path for agorae slider images
     * @return string
     */
    public function getSliderImagePath()
    {
        return 'magicslideshow/slider/images/';
    }

    /**
     * deleteUploadedFile deletes uploaded file
     * @param  boolean $delete
     * @param  string $data
     * @return void
     */
    public function deleteUploadedFile($delete, $data)
    {
        if ($delete) {
            $file = $this->getFileDriver();
            $objectManager = \Magento\Framework\App\ObjectManager::getInstance();
            $mediaPath = $objectManager->get('Magento\Framework\Filesystem')
                ->getDirectoryRead(DirectoryList::MEDIA)
                ->getAbsolutePath();
            
            $deletePath = $mediaPath.$data;
            if ($file->isExists($deletePath)) {
                $file->deleteFile($deletePath);
            }
        }
    }
}
