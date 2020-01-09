<?php

/**
 * Widget.xml
 *
 * @category  Webkul
 * @package   Webkul_MagicSlideShow
 * @author    Webkul
 * @copyright Copyright (c) 2010-2017 Webkul Software Private Limited (https://webkul.com)
 * @license   https://store.webkul.com/license.html
 */


 namespace Webkul\MagicSlideShow\Block\Adminhtml;

 use Magento\Backend\Block\Template;
 use Magento\Framework\Data\Form\Element\AbstractElement;
 use Magento\Framework\Data\Form\Element\Renderer\RendererInterface;

class SliderHeight extends Template implements RendererInterface
{
    /**
     * @var AbstractElement
     */
    protected $element;

    /**
     * @var string
     */
    protected $_template = 'Webkul_MagicSlideShow::height.phtml';

    public function render(AbstractElement $element)
    {
        $this->element = $element;
        return $this->toHtml();
    }

    public function getElement()
    {
        return $this->element;
    }
}
