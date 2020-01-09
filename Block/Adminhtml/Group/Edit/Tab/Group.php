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

use Magento\Backend\Block\Widget\Tab\TabInterface;
use Magento\Backend\Block\Widget\Form\Generic;

class Group extends Generic implements TabInterface
{
    /**
     * Prepare form
     *
     * @return $this
     */
    protected function _prepareForm()
    {
        $model = $this->_coreRegistry->registry('magicslideshow_group');
        
        /** @var \Magento\Framework\Data\Form $form */
        $form = $this->_formFactory->create();
        $form->setHtmlIdPrefix('group_');
            $fieldset = $form->addFieldset(
                'base_fieldset',
                ['legend' => __('Group Information'), 'class' => 'fieldset-wide']
            );
        if ($model->getData('id')) {
            $groupId = $model->getData('id');
            $fieldset->addField(
                'id',
                'hidden',
                [
                    'name' => 'id'
                ]
            );
        }
            $fieldset->addField(
                'name',
                'text',
                [
                    'name' => 'name',
                    'label' => __('Group Name'),
                    'title' => __('Name'),
                    'required' => true,
                ]
            );
            $fieldset->addField(
                'code',
                'text',
                [
                    'name' => 'code',
                    'label' => __('Group Code'),
                    'title' => __('Code'),
                    'required' => true,
                ]
            );
            $fieldset->addField(
                'status',
                'select',
                [
                    'label' => __('Status'),
                    'title' => __('Status'),
                    'name' => 'status',
                    'required' => true,
                    'options' => ['1' => __('Enabled'), '0' => __('Disabled')]
                ]
            );
            $form->setValues($model->getData());
            $this->setForm($form);
            return parent::_prepareForm();
    }

    /**
     * Check permission for passed action
     *
     * @param string $resourceId
     * @return bool
     */
    protected function _isAllowedAction($resourceId)
    {
        return $this->_authorization->isAllowed($resourceId);
    }

    /**
     * Prepare label for tab
     *
     * @return \Magento\Framework\Phrase
     */
    public function getTabLabel()
    {
        return __('Group Data');
    }

    /**
     * Prepare title for tab
     *
     * @return \Magento\Framework\Phrase
     */
    public function getTabTitle()
    {
        return __('Group Data');
    }

    /**
     * {@inheritdoc}
     */
    public function canShowTab()
    {
        return true;
    }

    /**
     * {@inheritdoc}
     */
    public function isHidden()
    {
        return false;
    }
}
