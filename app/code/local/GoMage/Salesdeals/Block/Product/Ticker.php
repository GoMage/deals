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
	
class GoMage_Salesdeals_Block_Product_Ticker extends Mage_Core_Block_Template{
    
    
    public function getDealItem(){
        if ($product = Mage::registry('current_product')){
            $items = Mage::getModel('gomage_salesdeals/item')
                                ->getCollection()
                                ->addFieldToFilter('status', 1)
                                ->addFieldToFilter('ticker', 1)
                                ->addFieldToFilter('product_id', $product->getId());
                                
            if(!$items->count()) {
                return false;
            }
    
            return $items->getFirstItem();                    
        }
        return false;
    } 
    
    protected function _toHtml()
    {       
        $item = $this->getDealItem();    
        if ($item && $item->isActive() && $item->isShowTicker()){
            $ticker = Mage::getBlockSingleton('gomage_salesdeals/ticker');
            $ticker->setPosition(null);
            $ticker->setBlock(null);
            $ticker->setItem(null);
            return $ticker->setItem($item)->toHtml();
        }     
        return "";
    }   
}