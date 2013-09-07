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

if (class_exists('GoMage_Procart_Block_Product_List')) {
    class _GoMage_Salesdeals_Block_Form_All extends GoMage_Procart_Block_Product_List{
    
    }
}else{
    class _GoMage_Salesdeals_Block_Form_All extends Mage_Catalog_Block_Product_List{
    
    }
}
	
class GoMage_Salesdeals_Block_Form_All extends _GoMage_Salesdeals_Block_Form_All{
    
    protected $_procartproductlist = null;
    
    protected function _construct()
    {
        parent::_construct();
        $this->_prepareCategory($this->getSalesdealsProductIds());
    }
    
    protected function _getProductCollection()
    {        
       if (is_null($this->_productCollection)) {                       
            $layer = $this->getLayer();                                    
            $category = Mage::getModel('catalog/category')->load(Mage::app()->getStore()->getRootCategoryId());
            if ($category->getId()) {
                $layer->setCurrentCategory($category);
            }            
            $this->_productCollection = $layer->getProductCollection();
            $ids = $this->getSalesdealsProductIds();
            if (!count($ids)) $ids[] = 0;
            $this->_productCollection = $this->_productCollection->addIdFilter($ids);
            $this->prepareSortableFieldsByCategory($layer->getCurrentCategory());
        } 
        return $this->_productCollection;
        
    }
    
    public function getSalesdealsProductIds(){
        
        $collection = Mage::getResourceModel('gomage_salesdeals/item_collection')
                           ->addFieldToFilter('status', 1);
        
        $ids = array();        
        foreach($collection as $item){
            if ($item->isActive()){                
                $ids[] = $item->getProductId();                       
            }
        }                   
                            
        return $ids;
    }
    
    protected function _prepareCategory($ids){
        $category = Mage::getModel('catalog/category')->load(Mage::app()->getStore()->getRootCategoryId());
        if ($category->getId()) {        
            $ids = array_fill_keys($ids, 1);
            $category->setPostedProducts($ids);
            $category->save();
        }            
    }
    
    public function getProcartProductList(){
        
        if (!$this->_procartproductlist){             
             $this->_procartproductlist = array();
             $helper = Mage::helper('gomage_procart');
             
             foreach ($this->getLoadedProductCollection() as $_product){                 
                 $product = Mage::getModel('catalog/product')->load($_product->getId());                 
                 $this->_procartproductlist[$product->getId()] = $helper->getProcartProductData($product);
             }
             
        }
        
        return Mage::helper('core')->jsonEncode($this->_procartproductlist);          
    }     
       
}