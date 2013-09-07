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

class GoMage_Salesdeals_IndexController extends Mage_Core_Controller_Front_Action
{
    public function indexAction(){    	
        $this->loadLayout();        
        $this->renderLayout();   
    }
    
    public function tickerrefreshAction(){
        
        $result = array();
        
        $block = null;
        $position = null; 
        if ($this->getRequest()->getParam('position')){
            $position = $this->getRequest()->getParam('position');
        }
        if ($block_id = $this->getRequest()->getParam('block_id')){
            $block = Mage::getModel('gomage_salesdeals/block')->load($block_id);            
        }        
        $item = Mage::getModel('gomage_salesdeals/item')->load($this->getRequest()->getParam('item_id'));

        $ticker = Mage::getBlockSingleton('gomage_salesdeals/ticker')                		           
        		           ->setItem($item)
        		           ->setBlock($block)
        		           ->setPosition($position); 
        
        $result['html'] = $ticker->toHtml();
        $result['id'] = 'salesdeals-ticker-' . $ticker->getItemId();
                
        if(!$item->isActive() && $position){
            $result['remove_item'] = 'sd-item-' . $position . '-' . $item->getId(); 
        }
        if($block && !$block->isActive()){
            $result['remove_block'] = 'gomage-sd-' . $position . '-' . $block->getId(); 
        }
        
        $this->getResponse()->setBody(Mage::helper('core')->jsonEncode($result));
    }
}
