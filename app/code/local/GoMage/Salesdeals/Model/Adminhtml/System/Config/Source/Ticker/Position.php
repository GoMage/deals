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
	
class GoMage_Salesdeals_Model_Adminhtml_System_Config_Source_Ticker_Position{

    const LEFT = 'left';
    const RIGHT = 'right';
    const TOP = 'top';
    const BOTTOM = 'bottom';
      
    public function toOptionArray()
    {
    	
    	$helper = Mage::helper('gomage_salesdeals');
    	
        return array(
            array('value' => self::LEFT, 'label'=>$helper->__('Left')),
            array('value' => self::RIGHT, 'label'=>$helper->__('Right')),
            array('value' => self::TOP, 'label'=>$helper->__('Top')),
            array('value' => self::BOTTOM, 'label'=>$helper->__('Bottom')),                        
        );
    }

}