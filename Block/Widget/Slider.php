<?php
/**
 * Block.php to add slider.
 *
 * @category  Webkul
 * @package   Webkul_MagicSlideShow
 * @author    Webkul
 * @copyright Copyright (c) 2010-2017 Webkul Software Private Limited (https://webkul.com)
 * @license   https://store.webkul.com/license.html
 */

namespace Webkul\MagicSlideShow\Block\Widget;

use Magento\Framework\View\Element\Template;
use Magento\Framework\App\Config\ScopeConfigInterface;
use Webkul\MagicSlideShow\Helper\Data;
use Magento\Framework\App\Filesystem\DirectoryList;

class Slider extends \Magento\Framework\View\Element\Template implements \Magento\Widget\Block\BlockInterface
{
    /**
     * $helper
     */
    protected $helper;

    /**
     * construct
     * @param MagentoFrameworkViewElementTemplateContext $context
     * @param Data                                       $helper
     * @param [type]                                     $data
     */
    public function __construct(
        \Magento\Framework\View\Element\Template\Context $context,
        \Webkul\MagicSlideShow\Model\GroupFactory $group,
        \Webkul\MagicSlideShow\Model\SliderimagesFactory $sliderimages,
        Data $helper,
        array $data = []
    ) {
        parent::__construct($context, $data);
        $this->_group = $group;
        $this->_sliderimages = $sliderimages;
        $this->helper = $helper;
    }

    /**
     * set the template file
     * @param $asset
     * @return $asseturl
     */
    public function _toHtml()
    {
        $this->setTemplate('magic_slide_show.phtml');
        return parent::_toHtml();
    }

    /**
     * getAssetUrl to include css file in phtml.
     * @param $asset
     * @return $asseturl
     */
    public function getAssetUrl($asset)
    {
        $objectManager = \Magento\Framework\App\ObjectManager::getInstance();
        $assetRepository = $objectManager->get('Magento\Framework\View\Asset\Repository');
        return $assetRepository->createAsset($asset)->getUrl();
    }

    /**
     * get total no of Images
     * @return $noOfImages
     */
    public function noOfImages()
    {
        $noOfImages = count($this->getImageDetailsUrlByIds());
        return $noOfImages;
    }

    /**
     * set Class of slider by user selected choice
     * @return class
     */
    public function setClassByEffect()
    {
        $class = "";
        if ($this->getEffect() == "slide") {
            $class = " slide";
        } else {
            $class = " fade";
        }
        return $class;
    }

    /**
     * Get Image links of Images set By Admin
     * @return array of links
     */
    public function imageLink()
    {
        $blockLinks = $this->getLinks();
        $links = [];
        $links = explode('|', $blockLinks);
        return $links;
    }

    /**
     * Get Description of Images set by Admin
     * @return array of description
     */
    public function description()
    {
        $blockDescription = $this->getDescription();
        $description = [];
        $description = explode('|', $blockDescription);
        return $description;
    }

    /**
     * Get image Ids by Group Code
     * @return array
     */
    public function getImageIdsByGroupCode()
    {
        $groupCode = $this->getData('groupCode');
        
        $collection = $this->_group->create()
                        ->getCollection()
                        ->getFirstItem();
        $imageIds = $collection->getData('image_ids');
        
        return $imageIds;
    }

    /**
     * Get Array of Image Urls of seleted Images of Group
     * @return array
     */
    public function getImageDetailsUrlByIds()
    {
        $imageIds = $this->getImageIdsByGroupCode();
        $imageUrl = [];
        $collection = $this->_sliderimages->create()
                           ->getCollection();
        $baseUrl = $this->helper->getImagesUrl();
        if ($collection->getSize()) {
            foreach ($collection as $key => $value) {
                $collection = $value;
                $imageLink = $baseUrl.$collection->getLink();
                array_push($imageUrl, $imageLink);
            }
        }
        return $imageUrl;
    }

    public function getTransitionTime()
    {
        return $this->getData('transitionTime');
    }
    
    public function getSliderWidth()
    {
        return $this->getData('sliderwidth');
    }
    
    public function getSliderHeight()
    {
        return $this->getData('sliderheight');
    }
    
    public function getItemsCount()
    {
        return $this->getData('itemsCount');
    }

    public function getGroupCode()
    {
        return $this->getData('groupCode');
    }
}
