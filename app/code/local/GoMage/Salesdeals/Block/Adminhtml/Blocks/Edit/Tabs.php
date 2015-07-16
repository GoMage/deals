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

class GoMage_Salesdeals_Block_Adminhtml_Blocks_Edit_Tabs extends Mage_Adminhtml_Block_Widget_Tabs
{
    
    public function __construct(){
    	
        parent::__construct();
        $this->setId('gomage_salesdeals_tabs');
        $this->setDestElementId('edit_form');
        $this->setTitle($this->__('Manage Deal Block'));
        
    }
    
    protected function _prepareLayout(){
         
        $this->addTab('general_section', array(
            'label'     =>  $this->__('General'),
            'title'     =>  $this->__('General'),
            'content'   =>  $this->getLayout()->createBlock('gomage_salesdeals/adminhtml_blocks_edit_tab_general')->toHtml(),
        ));
        
        $this->addTab('sidebar_section', array(
            'label'     =>  $this->__('Sidebar Block'),
            'title'     =>  $this->__('Sidebar Block'),
            'content'   =>  $this->getLayout()->createBlock('gomage_salesdeals/adminhtml_blocks_edit_tab_sidebar')->toHtml(),
        ));
                
        $this->addTab('sidebar_ticker_section', array(
            'label'     =>  $this->__('Sidebar Block Ticker'),
            'title'     =>  $this->__('Sidebar Block Ticker'),
            'content'   =>  $this->getLayout()->createBlock('gomage_salesdeals/adminhtml_blocks_edit_tab_sidebar_ticker')->toHtml(),
        ));
                
        $this->addTab('top_section', array(
            'label'     =>  $this->__('Top Block'),
            'title'     =>  $this->__('Top Block'),
            'content'   =>  $this->getLayout()->createBlock('gomage_salesdeals/adminhtml_blocks_edit_tab_top')->toHtml(),
        ));
        
        $this->addTab('top_ticker_section', array(
            'label'     =>  $this->__('Top Block Ticker'),
            'title'     =>  $this->__('Top Block Ticker'),
            'content'   =>  $this->getLayout()->createBlock('gomage_salesdeals/adminhtml_blocks_edit_tab_top_ticker')->toHtml(),
        ));
        
        $this->addTab('settings_section', array(
            'label'     =>  $this->__('Display Settings'),
            'title'     =>  $this->__('Display Settings'),
            'content'   =>  $this->getLayout()->createBlock('gomage_salesdeals/adminhtml_blocks_edit_tab_settings')->toHtml(),
        ));
        
        $this->addTab('products_section', array(
            'label'     =>  $this->__('Block Deals'),
            'title'     =>  $this->__('Block Deals'),
            'content'   =>  $this->getLayout()->createBlock('gomage_salesdeals/adminhtml_blocks_edit_tab_products')->toHtml(),
        ));
        
        if($tabId = addslashes(htmlspecialchars($this->getRequest()->getParam('tab')))){
        	
        	$this->setActiveTab($tabId);
        }
        
        
        return parent::_beforeToHtml();
        
    }
       
}