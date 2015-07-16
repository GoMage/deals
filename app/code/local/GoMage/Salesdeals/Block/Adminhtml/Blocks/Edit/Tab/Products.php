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

class GoMage_Salesdeals_Block_Adminhtml_Blocks_Edit_Tab_Products extends Mage_Adminhtml_Block_Widget_Grid
{

    public function __construct()
    {
        parent::__construct();
        $this->setId('salesdeals_items_grid');
        $this->setDefaultSort('id');
        $this->setUseAjax(true);
        $this->setCheckboxCheckCallback('registerBlockItem');
        $this->setRowInitCallback('BlockItemRowInit');
        $this->setRowClickCallback('BlockItemRowClick');
    }

    protected function _addColumnFilterToCollection($column)
    {
        if ($column->getId() == 'in_block') {
            $itemIds = $this->_getSelectedItems();
            if (empty($itemIds)) {
                $itemIds = 0;
            }
            if ($column->getFilter()->getValue()) {
                $this->getCollection()->addFieldToFilter('id', array('in'=>$itemIds));
            }
            elseif(!empty($itemIds)) {
                $this->getCollection()->addFieldToFilter('id', array('nin'=>$itemIds));
            }
        }
        else {
            parent::_addColumnFilterToCollection($column);
        }
        return $this;
    }

    protected function _prepareCollection()
    {
        if (Mage::registry('gomage_salesdeals_block') && Mage::registry('gomage_salesdeals_block')->getId()) {
            $this->setDefaultFilter(array('in_block'=>1));
        }
        
        $collection = Mage::getModel('gomage_salesdeals/item')->getCollection()
                      ->join('catalog/product',
                             'entity_id=product_id',
                			 array('*'))
            		  ->joinleft('gomage_salesdeals/block_item',                        
                                 'item_id=id and block_id=' . (int)$this->getRequest()->getParam('id', 0),
            		             array('position' => 'position'));
        			
        $this->setCollection($collection);
        
        return parent::_prepareCollection();
    }

    protected function _prepareColumns()
    {
        $this->addColumn('in_block', array(
            'header_css_class' => 'a-center',
            'type'      => 'checkbox',
            'name'      => 'in_block',
            'values'    => $this->_getSelectedItems(),
            'align'     => 'center',
            'index'     => 'id',
            'use_index' => true,
        ));
        
        $this->addColumn('entity_id', array(
            'header'    => Mage::helper('catalog')->__('ID'),
            'sortable'  => true,
            'width'     => '60',
            'index'     => 'entity_id'
        ));
        $this->addColumn('name', array(
            'header'    => Mage::helper('catalog')->__('Name'),
            'index'     => 'name',
            'filter'    =>  false,
            'sortable'  =>  false,
            'renderer'  => 'GoMage_Salesdeals_Block_Adminhtml_Blocks_Edit_Tab_Products_Renderer_Name',
        
        ));
        $this->addColumn('sku', array(
            'header'    => Mage::helper('catalog')->__('SKU'),
            'width'     => '80',
            'index'     => 'sku'
        ));
        $this->addColumn('deal_qty', array(
            'header'    => $this->__('Deal Qty'),
        	'type'      => 'number',
            'width'     => '80',
            'index'     => 'deal_qty'
        ));
        $this->addColumn('price', array(
            'header'    => Mage::helper('catalog')->__('Price'),
            'type'      => 'text',
        	'width'     => '80',                        
            'filter'    =>  false,
            'sortable'  =>  false,
        	'renderer'  => 'GoMage_Salesdeals_Block_Adminhtml_Blocks_Edit_Tab_Products_Renderer_Price',
        ));
        $this->addColumn('special_price', array(
            'header'    => Mage::helper('catalog')->__('Special Price'),
            'type'      => 'text',
            'width'     => '80',                        
            'filter'    =>  false,
            'sortable'  =>  false,
            'renderer'  => 'GoMage_Salesdeals_Block_Adminhtml_Blocks_Edit_Tab_Products_Renderer_Specialprice',
        ));
        $this->addColumn('position', array(
            'header'    => Mage::helper('catalog')->__('Position'),
            'width'     => '1',
            'type'      => 'number',
            'index'     => 'position',
            'editable'  => true
        ));
        
        return parent::_prepareColumns();
    }

    public function getGridUrl()
    {
        return $this->getUrl('*/*/grid', array('_current'=>true));
    }

    protected function _getSelectedItems()
    {
        $products = $this->getRequest()->getPost('selected_items');
        if (is_null($products)) {
            if (Mage::registry('gomage_salesdeals_block') && Mage::registry('gomage_salesdeals_block')->getId()){
                $products = Mage::registry('gomage_salesdeals_block')->getItemIds();
            }else{
                $products = array();
            }    
        }
        return $products;
    }

}