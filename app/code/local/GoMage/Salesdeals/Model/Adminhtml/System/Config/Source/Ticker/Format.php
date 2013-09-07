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
	
class GoMage_Salesdeals_Model_Adminhtml_System_Config_Source_Ticker_Format{

    public function toOptionArray(){
    	
    	$helper = Mage::helper('gomage_salesdeals');
    	
        return array(
            array('value'=> 0, 'label' => $helper->__('dd hh mm ss')),        	
            array('value'=> 1, 'label' => $helper->__('dd hh:mm:ss')),
            array('value'=> 2, 'label' => $helper->__('dd:hh:mm:ss')),
            array('value'=> 3, 'label' => $helper->__('dd:hh:mm')),
            array('value'=> 4, 'label' => $helper->__('dd hh:mm')),
            array('value'=> 5, 'label' => $helper->__('hh:mm:ss')),
        );
    	
    }
    
    public function toOptionHash(){
    	
    	$helper = Mage::helper('gomage_salesdeals');
    	
        return array(
            0 => $helper->__('dd hh mm ss'),            
            1 => $helper->__('dd hh:mm:ss'),
            2 => $helper->__('dd:hh:mm:ss'),
            3 => $helper->__('dd:hh:mm'),
            4 => $helper->__('dd hh:mm'),
            5 => $helper->__('hh:mm:ss'),
        );
    }

}