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

class GoMage_Salesdeals_Block_Adminhtml_Items_Edit extends Mage_Adminhtml_Block_Widget_Form_Container
{
    public function __construct(){
    	
        parent::__construct();
                 
        $this->_objectId = 'id';
        $this->_blockGroup = 'gomage_salesdeals';
        $this->_controller = 'adminhtml_items';
        
        $this->_updateButton('save', 'label', $this->__('Save'));
        $this->_updateButton('delete', 'label', $this->__('Delete'));
		
		$salesdeals = Mage::registry('gomage_salesdeals');				
		
        $this->_addButton('saveandcontinue', array(
            'label'     => $this->__('Save And Continue Edit'),
            'onclick'   => 'saveAndContinueEdit()',
            'class'     => 'save',
        ), -100);
        
        $max_deal_quantity = 0;
        
        if ($salesdeals && $salesdeals->getId()){
            
             $product = Mage::getModel('catalog/product')->load($salesdeals->getData('product_id'));
             
             if ($product->getTypeId() == Mage_Catalog_Model_Product_Type::TYPE_SIMPLE){                 
                 $max_deal_quantity = min(array($product->getStockItem()->getMaxSaleQty(), $product->getStockItem()->getQty()));
             }else{
                 $max_deal_quantity = $product->getStockItem()->getMaxSaleQty();
             }
        }
 
        $this->_formScripts[] = "

            function saveAndContinueEdit(){
            	
                editForm.submit($('edit_form').action+'back/edit/');
            }
            
            var gomage_salesdeals_validate_product_url = '".$this->getUrl('gomage_salesdeals/adminhtml_items/getProductQty')."';

            var max_deal_quantity = ".$max_deal_quantity.";
                                    
        "; 
    }
    
    public function getHeaderText(){
    	
        if( Mage::registry('gomage_salesdeals') && Mage::registry('gomage_salesdeals')->getId() ) {
            return $this->__("Edit Deal");
        } else {
            return $this->__('Add Deal');
        }
        
    }
}