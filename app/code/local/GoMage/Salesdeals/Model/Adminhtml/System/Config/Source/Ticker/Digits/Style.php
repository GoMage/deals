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
	
class GoMage_Salesdeals_Model_Adminhtml_System_Config_Source_Ticker_Digits_Style{

    public function toOptionArray(){
    	
    	$helper = Mage::helper('gomage_salesdeals');
    	
        return array(
            array('value'=> 0, 'label' => $helper->__('Apple')),        	            
            array('value'=> 1, 'label' => $helper->__('Default')),
        );
    	
    }   

    public function toOptionHash(){
    	
    	$helper = Mage::helper('gomage_salesdeals');
    	
        return array(
            0 => $helper->__('Apple'),                        
            1 => $helper->__('Default'),
        );
    }

}