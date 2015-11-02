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
	
class GoMage_Salesdeals_Model_Adminhtml_System_Config_Source_Page_Applayto{

    
    const ALL_PAGES = 1;
    const SELECTED_PAGES = 2;
            
    /**
     * Options getter
     *
     * @return array
     */
    public function toOptionArray()
    {
    	
    	$helper = Mage::helper('gomage_salesdeals');
    	
        return array(
            array('value' => self::ALL_PAGES, 'label'=>$helper->__('All Pages')),
            array('value' => self::SELECTED_PAGES, 'label'=>$helper->__('Selected Pages')),           
        );
    }

}