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
	
class GoMage_Salesdeals_Model_Observer{

    static public function checkK($event)
    {			
		$key = Mage::getStoreConfig('gomage_activation/salesdeals/key');			
		Mage::helper('gomage_salesdeals')->a($key);			
	}
    
	public function saveOrderItem($observer){ 

	    $orderItem = $observer->getEvent()->getItem();
        $product = $orderItem->getProduct();
        if (!$product) {
            return $this;
        }
        
        $collection = Mage::getResourceModel('gomage_salesdeals/item_collection')
                         ->addFieldToFilter('status', 1)
                         ->addFieldToFilter('product_id', $product->getId());
        foreach ($collection as $item){            
            if (!$item->isEndDate()){                
                $deal_qty = (int)$item->getData('deal_qty');
                $deal_qty = $deal_qty - (int)$orderItem->getQtyOrdered();
                $item->setData('deal_qty', max($deal_qty, 0));
                
                $bought_qty = (int)$item->getData('bought_qty');
                $bought_qty = $bought_qty + (int)$orderItem->getQtyOrdered();
                
                $item->setData('bought_qty', $bought_qty);
                
                $item->save();
            }
        }                 

        return $this; 
        
	} 

	public function loadBlock($observer){
	    $block = $observer->getEvent()->getObject();
	    if ($block->getId()){
	        $store_id = Mage::app()->getFrontController()->getRequest()->getParam('store');
	        if (!$store_id) $store_id = Mage::app()->getStore()->getId();
	        if (!$store_id) $store_id = 0;
	         
	        $collection = Mage::getModel('gomage_salesdeals/block_store')
                                ->getCollection()
                                ->addFieldToFilter('block_id', (int)$block->getId())
                                ->addFieldToFilter('store_id', $store_id);
                                
            if (!$collection->count() && $store_id){
                $collection = Mage::getModel('gomage_salesdeals/block_store')
                                ->getCollection()
                                ->addFieldToFilter('block_id', (int)$block->getId())
                                ->addFieldToFilter('store_id', 0);
            }                    
            
            if($collection->count()){
                $block_store = $collection->getFirstItem();
                $data = array_merge($block->getData(), $block_store->getData());                                
                $block->setData($data);
            }                                                                
	    }
	    return $this;
	}
	
    public function saveBlock($observer){
	    $block = $observer->getEvent()->getObject();
	    if ($block->getId()){
	        $store_id = Mage::app()->getFrontController()->getRequest()->getParam('store');	        	        
	        if (!$store_id) $store_id = 0;

	        $data = $block->getData();                      
            $data['store_id'] = $store_id;
            $data['block_id'] = $block->getId();
            unset($data['id']);
            unset($data['block_name']);
	        
	        $collection = Mage::getModel('gomage_salesdeals/block_store')
                                ->getCollection()
                                ->addFieldToFilter('block_id', (int)$block->getId())
                                ->addFieldToFilter('store_id', $store_id);
                                
            if($collection->count()){
                $block_store = $collection->getFirstItem();
                $data['block_store_id'] = $block_store->getData('block_store_id');                                
            }else{
                $block_store = Mage::getModel('gomage_salesdeals/block_store');
            }                             

            $block_store->setData($data);
            $block_store->save();
	        
	    }
	    return $this;
	}
	
	public function checkAjax(){
	    if($layout = Mage::getSingleton('core/layout')){				
			if(intval(Mage::app()->getFrontController()->getRequest()->getParam('ajax'))){
			    $navigation = Mage::getSingleton('gomage_navigation/observer');
			    if($navigation){			        			         
			        $navigation->checkAjax(); 
			    }			    
			}
	    }		
	}
	
	public function LayoutBlocks($observer){
        	
        $layout_update = array();
                        
        $blocks = Mage::getBlockSingleton('gomage_salesdeals/blocks');
        $blocks->setPosition('right');
        foreach($blocks->getBlocks() as $_block){
            $layout_update[] = $_block->getData('layout');
        }
        
        $blocks->setPosition('left');
	    foreach($blocks->getBlocks() as $_block){
            $layout_update[] = $_block->getData('layout');
        }
        
        $layout_update = array_unique($layout_update);
        $layout_update = implode('', $layout_update);
        
        if ($layout_update){ 
            $layout = $observer->getEvent()->getLayout();            
            $layout->getUpdate()->addUpdate($layout_update);
            $layout->generateXml();
        }
        	    
	}
		
}