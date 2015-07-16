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
	
class GoMage_Salesdeals_Model_Adminhtml_System_Config_Source_Page_Pages{

    
    const CART = 'cart';
    const CHECKOUT = 'checkout';
    const ACCOUNT = 'customer';
            
    /**
     * Options getter
     *
     * @return array
     */
    public function toOptionArray()
    {
    	
    	$helper = Mage::helper('gomage_salesdeals');
    	
        $options = array(
                    array('value' => 0, 'label'=>''),
                    array('value' => self::CART, 'label'=>$helper->__('Cart Page')),
                    array('value' => self::CHECKOUT, 'label'=>$helper->__('Checkout Page')),           
                    array('value' => self::ACCOUNT, 'label'=>$helper->__('Account Page')),
                );
        $collection = Mage::getResourceModel('cms/page_collection')->toOptionArray();

        return array_merge($options, $collection);         
    }

}