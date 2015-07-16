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

class GoMage_Salesdeals_Model_Mysql4_Block_Collection extends Mage_Core_Model_Mysql4_Collection_Abstract
{
    public function _construct()
    {
        parent::_construct();
        $this->_init('gomage_salesdeals/block');
    }  
    
    public function addStoreFilter($store)
    {
        if ($store instanceof Mage_Core_Model_Store) {
            $store = array($store->getId());
        }	    
        $this->getSelect()->join(
            array('_block_store' => $this->getTable('gomage_salesdeals/block_store')),
            "`main_table`.`id`=`_block_store`.`block_id` 
             and `_block_store`.`store_id` = " . (int)$store,
            array('store_id_arr' => 'store_id')
        );
           
        return $this;
    }
    
    public function addStatusFilter($value)
    {       
        $store_id = Mage_Catalog_Model_Abstract::DEFAULT_STORE_ID;
        
        $filter = $this->getRequest()->getParam('filter');
        if (is_string($filter)) {
            $data = Mage::helper('adminhtml')->prepareFilterString($filter);
            if (isset($data['store_id_arr'])){
                $store_id = $data['store_id_arr'];
            }
        }
        elseif ($filter && is_array($filter)) {
            if (isset($filter['store_id_arr'])){
                $store_id = $filter['store_id_arr'];
            }
        }    
         	    
        $this->getSelect()->join(
            array('_block_status' => $this->getTable('gomage_salesdeals/block_store')),
            "`main_table`.`id`=`_block_status`.`block_id` 
             and `_block_status`.`store_id` = " . $store_id . "   
             and `_block_status`.`status` = " . (int)$value,
            array('status' => 'status')
        );   
                
        return $this;
    }
    
    public function getRequest()
    {
        $controller = Mage::app()->getFrontController();
        if ($controller) {
            $this->_request = $controller->getRequest();
        } else {
            throw new Exception(Mage::helper('core')->__("Can't retrieve request object"));
        }
        return $this->_request;
    }

}    
        