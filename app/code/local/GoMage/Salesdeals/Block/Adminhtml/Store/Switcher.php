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

class GoMage_Salesdeals_Block_Adminhtml_Store_Switcher extends Mage_Adminhtml_Block_Store_Switcher
{
    public function getWebsites()
    {
        $websites = Mage::app()->getWebsites();
        $helper = Mage::helper('gomage_salesdeals');
        
        foreach ($websites as $websiteId => $website){            
            if (!in_array($websiteId, $helper->getAvailavelWebsites())){
                unset($websites[$websiteId]);
            }
        }
        
        return $websites;
    }

}
