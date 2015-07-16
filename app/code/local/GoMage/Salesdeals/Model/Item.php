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

class GoMage_Salesdeals_Model_Item extends Mage_Core_Model_Abstract
{
    
    protected $_product = null; 
			
    public function _construct()
    {
        parent::_construct();
        $this->_init('gomage_salesdeals/item');
    }
    
    public function getProduct(){
        if (is_null($this->_product)){
            $this->_product = Mage::getModel('catalog/product')->load($this->getData('product_id'));
        }
        return $this->_product;
    }
    
    public function getStartDateTime(){
        if (!$this->getStartDate()) return false;
        return $this->getStartDate() . ($this->getStartTime() ? ' ' . $this->getStartTime() : '');
    }
    
    public function getEndDateTime(){
        if (!$this->getEndDate()) return false;
        return $this->getEndDate() . ($this->getEndTime() ? ' ' . $this->getEndTime() : '');
    }
       
    public function isActive()
    {   
        if (!$this->getStatus()) return false;
        				             
        if ($this->getStartDateTime() && 
            (Mage::getModel('core/date')->gmtTimestamp($this->getStartDateTime()) > Mage::getModel('core/date')->gmtTimestamp()) )
            return false;
            
        if ($this->isDialEnd()){            
            if ((bool)$this->getData('hide_prod_after_end'))
                return false;
        } 
                   
        return true;
    }
    
    public function isEndDate(){
        if (!$this->getEndDate())
            return true;
        else    
            return (Mage::getModel('core/date')->gmtTimestamp($this->getEndDateTime()) <= Mage::getModel('core/date')->gmtTimestamp());
    }
      
    public function getBoughtQty(){
        return intval($this->getData('bought_qty'));
    }
        
    public function getRemaininQty(){
        return intval($this->getData('deal_qty'));
    }

    public function isShowTicker(){
        
        if (!$this->getEndDate()) return false;
        
        if ($this->isDialEnd()){
            return !(bool)$this->getData('hide_ticker_after_end');
        }
        return true;
    }
    
    public function isDialEnd(){
        return ($this->isEndDate() || ($this->getData('deal_qty') == 0));
    }
                  
}


