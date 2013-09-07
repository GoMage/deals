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
	
class GoMage_Salesdeals_Model_Adminhtml_System_Config_Source_Sidebar_Style{
    
    public function toOptionArray()
    {
    	
    	$helper = Mage::helper('gomage_salesdeals');
    	
        return array(
            array('value' => 0, 'label'=>$helper->__('Style 1')),
            array('value' => 1, 'label'=>$helper->__('Style 2')),           
        );
    }

}