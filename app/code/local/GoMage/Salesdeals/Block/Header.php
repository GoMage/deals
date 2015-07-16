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
	
class GoMage_Salesdeals_Block_Header extends Mage_Core_Block_Template{
    
    protected $_blocks = null;
    
    public function __construct()
    {
        parent::__construct();

        if(Mage::helper('gomage_salesdeals')->isGomageSalesdeals()){
            $this->setTemplate('gomage/salesdeals/header/styles.phtml');
        }
        
    }
    
    public function getBlocks(){
        
        if (is_null($this->_blocks)){
            $collection = Mage::getResourceModel('gomage_salesdeals/block_collection');
            
            foreach ($collection as $_block){
                $_block->load(null);                                
                if ($_block->isActive()){                    
                   $this->_blocks[] = $_block;                                 
                }
            }                   
        }

        return $this->_blocks;
    }
    
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
    
    public function getCurrentTime(){
        $current_date = Mage::getModel('core/date')->date('m/d/y H:i:s', Mage::getModel('core/date')->gmttimestamp());
        $current_date = Mage::getModel('core/date')->parseDateTime($current_date, 'm/d/y h:i');
        return Mage::helper('core')->jsonEncode($current_date);
    }
     
}