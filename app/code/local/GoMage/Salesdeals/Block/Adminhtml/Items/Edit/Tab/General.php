<?php
 /**
 * GoMage Sales and Deals Extension
 *
 * @category     Extension
 * @copyright    Copyright (c) 2010-2011 GoMage (http://www.gomage.com)
 * @author       GoMage
 * @license      http://www.gomage.com/license-agreement/  Single domain license
 * @terms of use http://www.gomage.com/terms-of-use
 * @version      Release: 1.0
 * @since        Class available since Release 1.0
 */

class GoMage_Salesdeals_Block_Adminhtml_Items_Edit_Tab_General extends Mage_Adminhtml_Block_Widget_Form
{
	
    protected function _prepareForm()
    {
        
        $form = new Varien_Data_Form();
        
        if(Mage::registry('gomage_salesdeals')){
        	$item = Mage::registry('gomage_salesdeals');
        }else{
        	$item = new Varien_Object();
        }
        
        if ($item->getData('start_time')){
            $item->setData('start_time', implode(',', explode(':', $item->getData('start_time'))));
        }
        if ($item->getData('end_time')){
            $item->setData('end_time', implode(',', explode(':', $item->getData('end_time'))));
        }
        
        $this->setForm($form);
        $fieldset = $form->addFieldset('general_fieldset', array('legend' => $this->__('General')));
                        
        $fieldset->addField('status', 'select',
            array(
                'name'   => 'status',
                'label'  => $this->__('Status'),                
                'values' => Mage::getModel('adminhtml/system_config_source_enabledisable')->toOptionArray(), 
            )
        );
                
        $outputFormat = Mage::app()->getLocale()->getDateFormat(Mage_Core_Model_Locale::FORMAT_TYPE_SHORT); 
        
        $fieldset->addField('start_date', 'date', array(
            'label'     => $this->__('Start Date'),
            'name'      => 'start_date', 
            'time'      => false, 
            'format'    => $outputFormat,
            'image'     => $this->getSkinUrl('images/grid-cal.gif'),            
        ));
        
        $fieldset->addField('start_time', 'time', array(
            'label'     => $this->__('Start Time'),
            'name'      => 'start_time',                                                  
        ));
        
        $fieldset->addField('end_date', 'date', array(
            'label'     => $this->__('End Date'),
            'name'      => 'end_date',
            'time'      => false,  
            'format'    => $outputFormat,
            'image'     => $this->getSkinUrl('images/grid-cal.gif'),            
        ));
        
        $fieldset->addField('end_time', 'time', array(
            'label'     => $this->__('End Time'),
            'name'      => 'end_time',                                                  
        ));
        
        $form->setValues($item->getData());        
        
        return parent::_prepareForm();
        
    }
        
}