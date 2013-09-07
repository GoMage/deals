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

class GoMage_Salesdeals_Block_Adminhtml_Items_Edit_Tabs extends Mage_Adminhtml_Block_Widget_Tabs
{
    
    public function __construct(){
    	
        parent::__construct();
        $this->setId('gomage_salesdeals_tabs');
        $this->setDestElementId('edit_form');
        $this->setTitle($this->__('Manage Deals'));        
    }
    
    protected function _prepareLayout(){
         
        $this->addTab('general_section', array(
            'label'     =>  $this->__('General'),
            'title'     =>  $this->__('General'),
            'content'   =>  $this->getLayout()->createBlock('gomage_salesdeals/adminhtml_items_edit_tab_general')->toHtml(),
        ));
        
        $this->addTab('information_section', array(
            'label'     =>  $this->__('Item Information'),
            'title'     =>  $this->__('Item Information'),
            'content'   =>  $this->getLayout()->createBlock('gomage_salesdeals/adminhtml_items_edit_tab_information')->toHtml(),
        ));
        
        $this->addTab('ticker_section', array(
            'label'     =>  $this->__('Product Page Ticker'),
            'title'     =>  $this->__('Product Page Ticker'),
            'content'   =>  $this->getLayout()->createBlock('gomage_salesdeals/adminhtml_items_edit_tab_ticker')->toHtml(),
        ));
                        
        if($tabId = addslashes(htmlspecialchars($this->getRequest()->getParam('tab')))){
        	
        	$this->setActiveTab($tabId);
        }
        
        
        return parent::_beforeToHtml();
        
    }
       
}