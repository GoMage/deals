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
	
class GoMage_Salesdeals_Block_Ticker extends Mage_Core_Block_Template{
    
    protected $_block = null;
    protected $_item = null;
    protected $_position = null;
    
    public function __construct()
    {
        parent::__construct();  
        $this->setTemplate('gomage/salesdeals/ticker.phtml');                       
    }
    
    public function setPosition($position){
        $this->_position = $position;
        return $this;
    }
    
    public function getPosition(){        
        return $this->_position;
    }
    
    public function setBlock($block){
       $this->_block = $block;
       return $this; 
    }
    
    public function getBlock(){       
       return $this->_block; 
    }

    public function setItem($item){
       $this->_item = $item;
       return $this; 
    }
    
    public function getItem(){
       return $this->_item; 
    }
    
    public function getItemId(){
        if ($block = $this->getBlock()){
            return $this->getPosition() .'-'. $block->getId() .'-'. $this->getItem()->getId();
        }else{
            return 'product-ticker-' . $this->getItem()->getId();
        } 
    }
    
    public function getTickerParam($param){
        if ($block = $this->getBlock()){
            return $block->getTickerParam($this->getPosition(), $param);
        }else{
            return $this->getItem()->getData($param);
        }
    }
    
    public function getBlockParam($param){
        if ($block = $this->getBlock()){
            return $block->getParam($this->getPosition(), $param);
        }else{
            return false;
        }
    }
    
    public function getTickerCongig(){
                
        $config = array(); 
        
        $config['id'] = $this->getItemId();
        $end_date = Mage::getModel('core/date')->gmtTimestamp($this->getItem()->getEndDateTime());
        $end_date = Mage::getModel('core/date')->date('m/d/y H:i:s', $end_date);
        $config['end_date'] = Mage::getModel('core/date')->parseDateTime($end_date, 'm/d/y h:i');
        
        $config['item_id'] = $this->getItem()->getId();
        $config['block_id'] = 0;
        $config['position'] = $this->getPosition();
        if ($this->getBlock()) $config['block_id'] = $this->getBlock()->getId();
                
        return Mage::helper('core')->jsonEncode($config); 
    }
    
}