<?php
 /**
 * GoMage Sales and Deals Extension
 *
 * @category     Extension
 * @copyright    Copyright (c) 2010-2015 GoMage (http://www.gomage.com)
 * @author       GoMage
 * @license      http://www.gomage.com/license-agreement/  Single domain license
 * @terms of use http://www.gomage.com/terms-of-use
 * @version      Release: 1.2
 * @since        Class available since Release 1.0
 */
	
class GoMage_Salesdeals_Model_Adminhtml_System_Config_Source_Ticker_Digits_Font{
  
    public function toOptionArray(){
    	
    	$helper = Mage::helper('gomage_salesdeals');
    	
        return array(
            array('value'=> 'Arial', 'label' => $helper->__('Arial')),      
            array('value'=> 'Courier New', 'label' => $helper->__('Courier New')),
            array('value'=> 'Times New Roman', 'label' => $helper->__('Times New Roman')),
        );
    	
    }    

}