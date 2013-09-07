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

function gsd_blocks_sort($a, $b)
{
   $a_sort = ($a->getData('sort_order') ? $a->getData('sort_order') : 1); 
   $b_sort = ($b->getData('sort_order') ? $b->getData('sort_order') : 1);
   
   if ($a_sort == $b_sort)
   {
       return ($a->getId() < $b->getId()) ? -1 : 1;
   }
   else
   {
       return ($a_sort < $b_sort) ? -1 : 1;
   }   
}
	
class GoMage_Salesdeals_Block_Blocks extends Mage_Core_Block_Template{
    
    protected $_blocks = null;
    protected $_position = null;
    
    public function __construct()
    {
        parent::__construct();  
        $this->setTemplate('gomage/salesdeals/blocks.phtml');                       
    }
    
    public function setPosition($position){
        $this->_position = $position;
        return $this;
    }
    
    public function getPosition(){        
        return $this->_position;
    }
    
    public function getBlocks(){
                
        $collection = Mage::getResourceModel('gomage_salesdeals/block_collection');
        $this->_blocks = array();
        foreach ($collection as $_block){
            $_block->load(null);                                
            if ($_block->isActive()){                    
                switch ($this->getPosition()){
                    case 'left':
                          if (($_block->getDisplay() == GoMage_Salesdeals_Model_Adminhtml_System_Config_Source_Display::SIDEBAR)
                              && $_block->getData('display_lc')){
                                $this->_blocks[] = $_block;   
                          }  
                        break;
                    case 'right':                                
                          if (($_block->getDisplay() == GoMage_Salesdeals_Model_Adminhtml_System_Config_Source_Display::SIDEBAR)
                              && $_block->getData('display_rc')){
                                $this->_blocks[] = $_block;   
                          }  
                        break;
                    case 'top':
                          if ($_block->getDisplay() == GoMage_Salesdeals_Model_Adminhtml_System_Config_Source_Display::TOPBLOCK){
                                $this->_blocks[] = $_block;   
                          }  
                        break;        
                }
            }
        }

        if (count($this->_blocks)) usort($this->_blocks, "gsd_blocks_sort");

        return $this->_blocks;
    }

    public function getPriceBlock($product, $block){
                
        if ($product->getTypeId() == Mage_Catalog_Model_Product_Type::TYPE_BUNDLE){
            $_priceblock = Mage::getBlockSingleton('bundle/catalog_product_price')
                                    ->setTemplate('bundle/catalog/product/price.phtml');
        }else{
            $_priceblock = Mage::getBlockSingleton('catalog/product_price')
                                    ->setTemplate('gomage/salesdeals/product/price.phtml');                                
            $_priceblock->setBlock($block);
            $_priceblock->setPosition($this->getPosition());
        }
                 
        $_priceblock->setProduct($product);
        
        return $_priceblock->toHtml(); 
    }
    
    
    public function getAddToCartUrl($product, $additional = array())
    {
        $additional['_ignore_category'] = true;
                
        $_modules = Mage::getConfig()->getNode('modules')->children();
        $_modulesArray = (array)$_modules;
        if(isset($_modulesArray['GoMage_Procart'])){
            
	        if (Mage::helper('gomage_procart')->isProCartEnable() &&
	            Mage::getStoreConfig('gomage_procart/qty_settings/category_page')){
	            if (!isset($additional['_query'])) {
                    $additional['_query'] = array();
                }    	           
                $additional['_query']['gpc_prod_id'] = $product->getId();                   
	        }         	        
	    }
        
        if ($product->getTypeInstance(true)->hasRequiredOptions($product)) {
            if (!isset($additional['_escape'])) {
                $additional['_escape'] = true;
            }
            if (!isset($additional['_query'])) {
                $additional['_query'] = array();
            }
            $additional['_query']['options'] = 'cart';

            return $this->getProductUrl($product, $additional);
        }
        return $this->helper('checkout/cart')->getAddUrl($product, $additional);
    }
    
    public function getProductUrl($product, $additional = array())
    {   
        $additional['_ignore_category'] = true;     
        return $product->getUrlModel()->getUrl($product, $additional);        
    } 
    
    public function getTickerBlock(){
        $ticker = Mage::getBlockSingleton('gomage_salesdeals/ticker');
        $ticker->setPosition(null);
        $ticker->setBlock(null);
        $ticker->setItem(null); 
        return $ticker;
    }
        
}