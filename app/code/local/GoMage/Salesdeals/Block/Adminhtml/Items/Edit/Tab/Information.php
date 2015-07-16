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

class GoMage_Salesdeals_Block_Adminhtml_Items_Edit_Tab_Information extends Mage_Adminhtml_Block_Widget_Form
{
	
    protected function _prepareForm()
    {
        
        $form = new Varien_Data_Form();
        
        if(Mage::registry('gomage_salesdeals')){
        	$item = Mage::registry('gomage_salesdeals');
        }else{
        	$item = new Varien_Object();
        	$item->setData('hide_prod_after_end', 1);        	
        }
        
        $this->setForm($form);
        $fieldset = $form->addFieldset('information_fieldset', array('legend' => $this->__('Item Information')));
                        
        
        $values = array();
        $collection = Mage::getModel('catalog/product')->getCollection();
        $collection->addAttributeToSelect('name')->setOrder('name', 'ASC');; 
        
        $values[] = array('value'=> '', 'label' => Mage::helper('gomage_salesdeals')->__('-- Please Select --'));
        
        foreach ($collection as $product){
            $values[] = array('value'=> $product->getId(), 'label' => $product->getName().' ('.$product->getId().')');
        }
        
        $product_select = $fieldset->addField('product_id', 'select', array(
            'label'     => $this->__('Product'),
            'required'  => true,
            'name'      => 'product_id',
            'values'    => $values,            
        ));  
        
        $product_select->setOnchange('salesdeals_validate_qty(this)');

        $fieldset->addField('deal_qty', 'text', array(
            'name'      => 'deal_qty',
            'label'     => $this->__('Deal Quantity'),
            'title'     => $this->__('Deal Quantity'), 
            'class'		=> 'gomage-salesdeals-validate-prod-qty'                            	
        ));
        
        $fieldset->addField('hide_prod_after_end', 'select',
            array(
                'name'   => 'hide_prod_after_end',
                'label'  => $this->__('Hide Product after Deal Ends'),                
                'values' => Mage::getModel('adminhtml/system_config_source_yesno')->toOptionArray(),
                'note'	 => 'Product won\'t be showed in Block after deal ends.' 
            )
        );
        
        $fieldset->addField('hide_ticker_after_end', 'select',
            array(
                'name'   => 'hide_ticker_after_end',
                'label'  => $this->__('Hide Ticker after Deal Ends'),                
                'values' => Mage::getModel('adminhtml/system_config_source_yesno')->toOptionArray(), 
            )
        );
        
        $fieldset->addField('display_end_message', 'select',
            array(
                'name'   => 'display_end_message',
                'label'  => $this->__('Display End Deal Message'),                
                'values' => Mage::getModel('adminhtml/system_config_source_yesno')->toOptionArray(), 
            )
        );
        
        $fieldset->addField('end_message', 'textarea',
            array(
                'name'   => 'end_message',
                'label'  => $this->__('End Deal Message'),                                 
            )
        );
        
        
        
        $form->setValues($item->getData());        
        
        return parent::_prepareForm();
        
    }
        
}