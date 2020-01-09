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
namespace Webkul\MagicSlideShow\Block\Adminhtml\Group\Edit\Tab;

use Webkul\MagicSlideShow\Model\ResourceModel\Sliderimages\CollectionFactory as SliderimagesCollection;

class Images extends \Magento\Backend\Block\Widget\Grid\Extended
{
    /**
     * Core registry
     *
     * @var \Magento\Framework\Registry
     */
    protected $_coreRegistry = null;

    /**
     * @var SliderimagesCollection
     */
    protected $_sliderImagesCollection;

    /**
     * @param \Magento\Backend\Block\Template\Context $context
     * @param \Magento\Backend\Helper\Data $backendHelper
     * @param \Magento\Framework\Registry $coreRegistry
     * @param SliderimagesCollection $sliderImagesCollection,
     * @param array $data
     */
    public function __construct(
        \Magento\Backend\Block\Template\Context $context,
        \Magento\Backend\Helper\Data $backendHelper,
        \Magento\Framework\Registry $coreRegistry,
        SliderimagesCollection $sliderImagesCollection,
        array $data = []
    ) {
        $this->_coreRegistry = $coreRegistry;
        $this->_sliderImagesCollection = $sliderImagesCollection;
        parent::__construct($context, $backendHelper, $data);
    }

    /**
     * @return void
     */
    protected function _construct()
    {
        parent::_construct();
        $this->setId('magicslideshow_group_images');
        $this->setDefaultSort('entity_id');
        $this->setUseAjax(true);
        $this->setFilterVisibility(false);
    }

    /**
     * @return Grid
     */
    protected function _prepareCollection()
    {
        $collection = $this->_sliderImagesCollection
                            ->create()
                            ->addFieldToFilter("status", "1");
        $this->setCollection($collection);
        return parent::_prepareCollection();
    }

    /**
     * @return Extended
     */
    protected function _prepareColumns()
    {
        $this->addColumn(
            'in_group',
            [
                'type' => 'checkbox',
                'name' => 'in_group',
                'values' => $this->_getSelectedImages(),
                'index' => 'id',
            ]
        );
        $this->addColumn(
            'entity_id',
            [
                'header' => __('Id'),
                'sortable' => true,
                'index' => 'entity_id',
                'header_css_class' => 'col-id',
                'column_css_class' => 'col-id'
            ]
        );

        $this->addColumn(
            'title',
            [
                'type' => '\Magento_Ui\js\grid\columns\thumbnail',
                'header' => __('Images Title'),
                'sortable' => true,
                'index' => 'title',
                'header_css_class' => 'col-id',
                'column_css_class' => 'col-id'
            ]
        );
        
        return parent::_prepareColumns();
    }
    /**
     * @return string
     */
    public function getRowUrl($row)
    {
        return "javascript:void(0)";
    }

    /**
     * @return array|null
     */
    public function getGroup()
    {
        return $this->_coreRegistry->registry('magicslideshow_group');
    }

    /**
     * @return array|null
     */
    protected function _getSelectedImages()
    {
        $images = array_keys($this->getSelectedGroupImages());
        return $images;
    }
    
    /**
     * @return array|null
     */
    public function getSelectedGroupImages()
    {
        $images = [];
        $imagesIds = $this->getGroup()->getImagesIds();
        $imagesIds = explode(",", $imagesIds);
        foreach ($imagesIds as $imagesId) {
            $images[$imagesId] = ['position' => $imagesId];
        }
        return $images;
    }

    /**
     * @return array|null
     */
    public function getImagesIds()
    {
        $imagesIds = $this->getGroup()->getImagesIds();
        return $imagesIds;
    }
}
