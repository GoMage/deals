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

class GoMage_Salesdeals_Model_Mysql4_Block extends Mage_Core_Model_Mysql4_Abstract
{
    public function _construct()
    {
        $this->_init('gomage_salesdeals/block', 'id');
    }   

    protected function _afterLoad(Mage_Core_Model_Abstract $object)
    {
        $enabled_stores = array();
        $disabled_stores = array();
        
        $status_disable = true; 
        
        $collection = Mage::getModel('gomage_salesdeals/block_store')
                                ->getCollection()
                                ->addFieldToFilter('block_id', (int)$object->getId());
                                
        foreach ($collection as $store){
            if ($store->getData('store_id') == 0){
                $status_disable = ($store->getData('status') == 0); 
            }else{
                if ($store->getData('status')){
                    $enabled_stores[] = $store->getData('store_id');
                }    
                else{
                    $disabled_stores[] = $store->getData('store_id'); 
                }     
            }        
        }
        
        $all_stores = array();        
        foreach (Mage::helper('gomage_salesdeals')->getAvailavelWebsites() as $website_id){
            $website = Mage::getModel('core/website')->load($website_id);
            $all_stores = array_unique(array_merge($all_stores, $website->getStoreIds()));                                                
        }
        
        if($status_disable){
            $all_stores = array_diff($all_stores, $enabled_stores);    
        }else{
            $all_stores = array_diff($all_stores, $disabled_stores);
        }
        
        
        
        $object->setData('store_id_arr', $all_stores);
                
        return parent::_afterLoad($object);
    }
    
}