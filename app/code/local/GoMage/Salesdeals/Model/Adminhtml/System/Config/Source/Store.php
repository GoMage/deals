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

class GoMage_Salesdeals_Model_Adminhtml_System_Config_Source_Store extends Mage_Adminhtml_Model_System_Store
{
    protected function _loadWebsiteCollection()
    {
        $h = Mage::helper('gomage_salesdeals');  
        $_websiteCollection = array();      
        foreach ($h->getAvailavelWebsites() as $_w)
        {
            $website = Mage::getModel('core/website')->load($_w);
            if ($website->getId() == 0) continue;                            
            $_websiteCollection[$website->getId()] = $website; 
        }    
        $this->_websiteCollection = $_websiteCollection; 
        return $this;
    }
}
