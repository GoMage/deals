<?php
 /**
 * GoMage Sales and Deals Extension
 *
 * @category     Extension
 * @copyright    Copyright (c) 2010-2015 GoMage (http://www.gomage.com)
 * @author       GoMage
 * @license      http://www.gomage.com/license-agreement/  Single domain license
 * @terms of use http://www.gomage.com/terms-of-use
 * @version      Release: 1.1
 * @since        Class available since Release 1.0
 */

class GoMage_Salesdeals_Block_Adminhtml_Blocks_Edit_Tab_General extends Mage_Adminhtml_Block_Widget_Form
{
	
    protected function _prepareForm()
    {
        
        $form = new Varien_Data_Form();
        
        if(Mage::registry('gomage_salesdeals_block')){
        	$item = Mage::registry('gomage_salesdeals_block');
        }else{
        	$item = new Varien_Object();
        }
        
        $item->setData('display', 1); //hide top block option
        
        $this->setForm($form);
        $fieldset = $form->addFieldset('general_fieldset', array('legend' => $this->__('General')));
                        
        $fieldset->addField('status', 'select',
            array(
                'name'   => 'status',
                'label'  => $this->__('Status'),                
                'values' => Mage::getModel('adminhtml/system_config_source_enabledisable')->toOptionArray(), 
            )
        );
                
        $fieldset->addField('block_name', 'text', array(
            'name'      => 'block_name',
            'label'     => $this->__('Block Name'),
            'title'     => $this->__('Block Name'),
            'note'		=> $this->__('For internal use'),  
            'required'  => true,                                       	
        ));
        
        $display = $fieldset->addField('display', 'select',
            array(
                'name'   => 'display',
                'label'  => $this->__('Display'),                
                'values' => Mage::getModel('gomage_salesdeals/adminhtml_system_config_source_display')->toOptionArray(), 
            )
        );        
        $display->setOnchange('SalesDealsAdmin.setDisplayType(this.value);'); 
        
        $fieldset->addField('display_lc', 'select',
            array(
                'name'   => 'display_lc',
                'label'  => $this->__('Display in Left Column'),                
                'values' => Mage::getModel('adminhtml/system_config_source_yesno')->toOptionArray(), 
            )
        );
        
        $fieldset->addField('display_rc', 'select',
            array(
                'name'   => 'display_rc',
                'label'  => $this->__('Display in Right Column'),                
                'values' => Mage::getModel('adminhtml/system_config_source_yesno')->toOptionArray(), 
            )
        );
        
        $customerGroups = Mage::getResourceModel('customer/group_collection')
                            ->load()->toOptionArray(); 
        
        $fieldset->addField('customer_group_ids', 'multiselect', array(
            'name'      => 'customer_group_ids[]',
            'label'     => Mage::helper('catalogrule')->__('Customer Groups'),
            'title'     => Mage::helper('catalogrule')->__('Customer Groups'),
            'required'  => true,
            'values'    => $customerGroups,
        ));
        
         $fieldset->addField('sort_order', 'text', array(
            'name'      => 'sort_order',
            'label'     => $this->__('Sort Order'),
            'title'     => $this->__('Sort Order'),                                                     	
        ));
        
        $fieldset->addField('in_block_items', 'hidden', array(
            'name'      => 'in_block_items',                                    
        ));
                
        $form->setValues($item->getData());        
        
        return parent::_prepareForm();
        
    }
        
}