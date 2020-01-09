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
namespace Webkul\MagicSlideShow\Ui\Component\Listing\Columns;

use Magento\Framework\View\Element\UiComponentFactory;
use Magento\Framework\View\Element\UiComponent\ContextInterface;
use Magento\Store\Model\StoreManagerInterface;

/**
 * MagicSlideShow Ui Component Listing Columns Image
 */
class Image extends \Magento\Ui\Component\Listing\Columns\Column
{
    const NAME = 'filename';

    const ALT_FIELD = 'name';

    /**
     * @param ContextInterface $context
     * @param UiComponentFactory $uiComponentFactory
     * @param \Magento\Framework\UrlInterface $urlBuilder
     * @param StoreManagerInterface $storemanager
     * @param array $components
     * @param \Magento\Framework\ObjectManagerInterface $objectManager
     * @param array $data
     */
    public function __construct(
        ContextInterface $context,
        UiComponentFactory $uiComponentFactory,
        \Magento\Framework\UrlInterface $urlBuilder,
        StoreManagerInterface $storemanager,
        array $components = [],
        \Magento\Framework\ObjectManagerInterface $objectManager,
        array $data = []
    ) {
        parent::__construct($context, $uiComponentFactory, $components, $data);
        $this->urlBuilder = $urlBuilder;
        $this->_objectManager = $objectManager;
        $this->_storeManager = $storemanager;
        $this->editUrl ="";
    }

    /**
     * prepareDataSource
     *
     * @param array $dataSource
     * @return array
     */
    public function prepareDataSource(array $dataSource)
    {
        $mediaDirectory = $this->_storeManager
        ->getStore()
        ->getBaseUrl(
            \Magento\Framework\UrlInterface::URL_TYPE_MEDIA
        ).'magicslideshow/slider/images/';
        
        if (isset($dataSource['data']['items'])) {
            $fieldName = $this->getData('name');
            foreach ($dataSource['data']['items'] as & $item) {
                $image = $this->_objectManager->get(
                    '\Webkul\MagicSlideShow\Model\Sliderimages'
                )->load($item['entity_id']);

                $imageName = $image->getFilename();
                $imageTitle = $image->getTitle();
                $item[$fieldName . '_src'] = $mediaDirectory.$imageName;
                $item[$fieldName . '_alt'] = $this->getAlt($item) ?: $imageTitle;
                // $item[$fieldName . '_link'] = $this->urlBuilder->getUrl($this->editUrl, ['id' => $item['entity_id']]);
                $item[$fieldName . '_orig_src'] = $mediaDirectory.$imageName;
            }
        }
        return $dataSource;
    }
}
