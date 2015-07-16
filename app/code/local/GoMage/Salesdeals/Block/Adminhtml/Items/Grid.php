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

class GoMage_Salesdeals_Block_Adminhtml_Items_Grid extends Mage_Adminhtml_Block_Widget_Grid
{
	
    public function __construct(){
    	
        parent::__construct();
        $this->setId('gomage_salesdealsGrid');
        $this->setDefaultSort('id');
        $this->setDefaultDir('ASC');
        $this->setSaveParametersInSession(true);
        
    }
    
    protected function _prepareCollection(){    	
        $collection = Mage::getModel('gomage_salesdeals/item')->getCollection(); 

        $attribute = Mage::getModel('catalog/resource_eav_attribute');
        
        $attribute->loadByCode(Mage_Catalog_Model_Product::ENTITY, 'name');        
        
        $attributeIdField = $attribute->getIdFieldName();
        
        $attributeSelectTable = $collection->getConnection()->select()
                ->from(array('a'=>$attribute->getBackendTable()), array('entity_id', 'name'=> 'value'))
                ->where("`$attributeIdField`=?", $attribute->getId())
                ->where('`store_id`=?', Mage_Catalog_Model_Abstract::DEFAULT_STORE_ID);
        
        $collection->getSelect()->joinLeft(
            array('_product_name' => $attributeSelectTable),
            "`main_table`.`product_id`=`_product_name`.`entity_id`",
            array('name')
        );
        
        $this->setCollection($collection);
        return parent::_prepareCollection();        
    }
    
    protected function _prepareColumns(){
    	
    	$this->addColumn('id', array(
            'header'    => $this->__('ID'),
            'align'     => 'left',
            'index'     => 'id',
            'type' 	    => 'number',
            'width'     => '50px',
    	    'filter'    => false,
        ));
        
        $this->addColumn('name', array(
            'header'    => $this->__('Product Name'),
            'align'     => 'left',
            'index'     => 'name',
            'type'      => 'text', 			        
        ));
        
        $this->addColumn('deal_qty', array(
            'header'    => $this->__('Deal Qty'),
            'align'     => 'left',
            'index'     => 'deal_qty',
            'type'      => 'number',
            'width'     => '50px',
        ));
        
        $this->addColumn('bought_qty', array(
            'header'    => $this->__('Sold Qty'),
            'align'     => 'left',
            'index'     => 'bought_qty',
            'type'      => 'number',
            'width'     => '50px',
        ));
           	        
        $this->addColumn('start_date', array(
            'header'    => $this->__('Starts On'),
            'align'     => 'left',
            'index'     => 'start_date',
        	'type'      => 'date',
			'default'   => '--',
        ));

        $this->addColumn('end_date', array(
            'header'    => $this->__('Ends On'),
            'align'     => 'left',
            'index'     => 'end_date',
        	'type'      => 'date',
			'default'   => '--',
        ));
                
        $this->addColumn('status', array(
            'header'    => $this->__('Status'),
            'align'     => 'left',
            'index'     => 'status',
            'type'      => 'options',
            'width'     => '50px',
            'options'   => array(
            	0=>$this->__('Disabled'),
            	1=>$this->__('Enabled'),
            ),
            
        ));
        	    
        $this->addColumn('action', array(
            'header'    =>  $this->__('Action'),
            'width'     =>  '100px',
            'type'      =>  'action',
            'getter'    =>  'getId',
            'actions'   =>  array(
                array(
                    'caption'   =>  $this->__('Edit'),
                    'url'       =>  array('base'=> '*/*/edit'),
                    'field'     =>  'id'
                )
            ),
            'filter'    =>  false,
            'sortable'  =>  false,
            'index'     =>  'stores',
            'is_system' =>  true,
        ));
        
        return parent::_prepareColumns();
        
    }
    
    protected function _prepareMassaction(){
        
        $this->setMassactionIdField('id');
        $this->getMassactionBlock()->setFormFieldName('id');                
        $this->getMassactionBlock()->addItem('delete', array(
            'label'     =>  $this->__('Delete Item(s)'),
            'url'       =>  $this->getUrl('*/*/massDelete'),
            'confirm'   =>  $this->__('Are you sure?')
        ));
        
        
        return $this;
        
    }
    
    
    protected function _afterLoadCollection(){
        
        $this->getCollection()->walk('afterLoad');
        parent::_afterLoadCollection();
        
    }
    
    protected function _filterStoreCondition($collection, $column){
        
        if (!$value = $column->getFilter()->getValue()) {
            return;
        }
        
        $this->getCollection()->addStoreFilter($value);
        
    }
    
    public function getRowUrl($row){
        
        return $this->getUrl('*/*/edit', array('id' => $row->getId()));
        
    }
    
}