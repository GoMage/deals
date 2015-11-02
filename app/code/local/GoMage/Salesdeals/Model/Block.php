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

class GoMage_Salesdeals_Model_Block extends Mage_Core_Model_Abstract
{    
    protected $_items = null;
    protected $_active_items = null;
			
    public function _construct()
    {
        parent::_construct();
        $this->_init('gomage_salesdeals/block');
    }
    
    protected function _afterLoad()
    {
        parent::_afterLoad();        
        Mage::dispatchEvent('gomage_salesdeals_block_load_after', $this->_getEventData());
        return $this;
    }
    
    protected function _afterSaveCommit()
    {
        parent::_afterSaveCommit();
        Mage::dispatchEvent('gomage_salesdeals_block_save_after', $this->_getEventData());
        return $this;
    }
        
    public function getItems(){
        if (is_null($this->_items)){
            $this->_items = array();            
            $items = Mage::getModel('gomage_salesdeals/block_item')
                                ->getCollection()
                                ->addFieldToFilter('block_id', (int)$this->getId())
                                ->join('gomage_salesdeals/item',
                                	   'id=item_id',	
                                	   'product_id')
                                ->setOrder('position', 'ASC');
            foreach ($items as $_item){
                $this->_items[] = Mage::getModel('gomage_salesdeals/item')->load($_item->getItemId());
            }                                                    
        }
        return $this->_items;
    }
    
    public function getItemIds(){
        $ids = array();
        foreach($this->getItems() as $_item){
            $ids[] = $_item->getId(); 
        }
        return $ids; 
    }
    
    public function getActiveItems(){
        if (is_null($this->_active_items)){
            $this->_active_items = array();
            foreach($this->getItems() as $_item){
                if ($_item->isActive()){
                    $this->_active_items[] = $_item;
                } 
            }    
        }
        
        return $this->_active_items;
    }
    
    public function isActive(){
        
        if (!$this->getStatus()) return false;
        
        $h = Mage::helper('gomage_salesdeals');
		if(!in_array(Mage::app()->getStore()->getWebsiteId(), $h->getAvailavelWebsites())) return false;

		if (!in_array(Mage::getSingleton('customer/session')->getCustomerGroupId(), explode(',', $this->getCustomerGroupIds()))) return false;
		
		
        if (($this->getPageApplayTo() == GoMage_Salesdeals_Model_Adminhtml_System_Config_Source_Page_Applayto::SELECTED_PAGES)
             && !Mage::registry('current_category') )
        {          
              if (!$this->getPages()) return false;     
              
              $pages = explode(',', $this->getPages());
              if (Mage::app()->getFrontController()->getRequest()->getRequestedRouteName() == 'cms')
              {
                  if (!in_array(Mage::getSingleton('cms/page')->getIdentifier(), $pages))
                      return false;
              }
              else 
              {
                  if (!(in_array(Mage::app()->getFrontController()->getRequest()->getRequestedRouteName(), $pages)
                      || in_array(Mage::app()->getFrontController()->getRequest()->getRequestedControllerName(), $pages)))
                      return false;
              }
                
        }

        if (($this->getCatApplayTo() == GoMage_Salesdeals_Model_Adminhtml_System_Config_Source_Category_Applayto::SELECTED_CATEGORIES)
             && Mage::registry('current_category') )
        {          
              if (!$this->getCategories()) return false;
                             
              $categories = explode(',', $this->getCategories());
              if (!in_array(Mage::registry('current_category')->getId(), $categories))
                  return false;
        }
        
        if (Mage::registry('current_product') && !$this->getData('product_page')) return false;

        if (!count($this->getActiveItems())) return false;

		return true;
    }
    
    public function getParam($position, $param){
        
         switch ($position){
            case 'left':
            case 'right':    
                  return $this->getData('sb_' . $param);
                break;
            case 'top':
                  return $this->getData('tb_' . $param);
                break;        
        }
        
    }
    
    public function getTickerParam($position, $param){
        
         switch ($position){
            case 'left':
            case 'right':    
                  return $this->getData('sbt_' . $param);
                break;
            case 'top':
                  return $this->getData('tbt_' . $param);
                break;        
        }
        
    }
    
    public function getImageUrl($product, $position, $width = 75, $height = 75)
    {
        if ($this->getParam($position, 'image_width')){
            $width = (int)$this->getParam($position, 'image_width');
        }
        
        if ($this->getParam($position, 'image_height')){
            $height = (int)$this->getParam($position, 'image_height');
        }
        
        return (string)Mage::helper('catalog/image')->init($product, 'image')->resize($width, $height);
    } 
                      
}