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
	
class GoMage_Salesdeals_Model_Adminhtml_System_Config_Source_Category_Applayto{

    
    const ALL_CATEGORIES = 1;
    const SELECTED_CATEGORIES = 2;
            
    /**
     * Options getter
     *
     * @return array
     */
    public function toOptionArray()
    {
    	
    	$helper = Mage::helper('gomage_salesdeals');
    	
        return array(
            array('value' => self::ALL_CATEGORIES, 'label'=>$helper->__('All Categories')),
            array('value' => self::SELECTED_CATEGORIES, 'label'=>$helper->__('Selected Categories')),           
        );
    }

}