<?php
/**
 * Cart product add after Observer
 *
 * @category  Webkul
 * @package   Webkul_MagicSlideShow
 * @author    Webkul
 * @copyright Copyright (c) 2010-2017 Webkul Software Private Limited (https://webkul.com)
 * @license   https://store.webkul.com/license.html
 */

namespace Webkul\MagicSlideShow\Observer;

use Magento\Framework\Event\ObserverInterface;
use \Magento\Framework\Message\ManagerInterface;
use Magento\Checkout\Model\Session as CheckoutSession;

class Grid implements ObserverInterface
{
    /**
     * @var \Webkul\Quotesystem\Helper\Data
     */
    protected $_helper;
    /**
     * @var \Magento\Framework\Message\ManagerInterface
     */
    protected $_messageManager;

    /**
     * @param Data             $helper
     * @param ManagerInterface $messageManager
     */

    public function __construct(
        CheckoutSession $checkoutSession,
        ManagerInterface $messageManager
    ) {
        $this->_checkoutSession = $checkoutSession;
        $this->_messageManager = $messageManager;
    }
    /**
     * cart product add after event
     *
     * @param \Magento\Framework\Event\Observer $observer
     */
    public function execute(\Magento\Framework\Event\Observer $observer)
    {
        try {
            $grid = $observer->getData('grid');
            $grid->getColumnSet()->setSortable($grid->getSortable());
            $grid->setChild(
                'save_button',
                $grid->getLayout()->createBlock(
                    \Magento\Backend\Block\Widget\Button::class
                )->setData(
                    [
                        'label' => __('Save'),
                        'onclick' => $grid->getJsObjectName() . '.dosave()',
                        'class' => 'action-secondary',
                    ]
                )->setDataAttribute(['action' => 'grid-filter-apply'])
            );
        } catch (\Exception $e) {
            print_r($e->getMessage());
        }
    }
    public function _prepareSaveButtons()
    {
        $grid->setChild(
            'save_button',
            $grid->getLayout()->createBlock(
                \Magento\Backend\Block\Widget\Button::class
            )->setData(
                [
                    'label' => __('Save'),
                    'onclick' => $grid->getJsObjectName() . '.dosave()',
                    'class' => 'action-primary',
                ]
            )->setDataAttribute(['action' => 'grid-filter-apply'])
        );
    }
}
