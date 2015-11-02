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

class GoMage_Salesdeals_Block_Adminhtml_Blocks_Edit_Tab_Settings extends Mage_Adminhtml_Block_Widget_Form
{
	
    protected function _prepareForm()
    {
        
        $form = new Varien_Data_Form();
        
        if(Mage::registry('gomage_salesdeals_block')){
        	$item = Mage::registry('gomage_salesdeals_block');        	
        }else{
        	$item = new Varien_Object();
        	$item->setData('product_page', 1);
        }
        
        $this->setForm($form);
                               
        $fieldset_category = $form->addFieldset('category_settings', array('legend' => $this->__('Category Settings')));
                        
        
        $cat = $fieldset_category->addField('cat_applay_to', 'select',
            array(
                'name'   => 'cat_applay_to',
                'label'  => $this->__('Apply to'),                
                'values' => Mage::getModel('gomage_salesdeals/adminhtml_system_config_source_category_applayto')->toOptionArray(), 
            )
        ); 
        
        $cat->setOnchange('salesdeals_setactive(this, \'categories\', ' . GoMage_Salesdeals_Model_Adminhtml_System_Config_Source_Category_Applayto::SELECTED_CATEGORIES . ', ' . GoMage_Salesdeals_Model_Adminhtml_System_Config_Source_Category_Applayto::ALL_CATEGORIES . ')'); 

        if ($this->getRequest()->getParam('store')){
            $store_ids = array($this->getRequest()->getParam('store'));
        }else{
            $store_ids = array();
            foreach (Mage::helper('gomage_salesdeals')->getAvailavelWebsites() as $website_id){
                $website = Mage::getModel('core/website')->load($website_id);
                $store_ids = array_unique(array_merge($store_ids, $website->getStoreIds()));                                                
            }
        }        
        if(!count($store_ids)){
            $store_ids = array(Mage_Catalog_Model_Abstract::DEFAULT_STORE_ID); 
        }
        
        $fieldset_category->addField('categories', 'multiselect',
            array(
                'name'   => 'categories[]',
                'label'  => $this->__('Categories'),                
                'values' => Mage::getModel('gomage_salesdeals/adminhtml_system_config_source_category_categories')->toOptionArray($store_ids, true),
                'disabled' => (($item->getData('cat_applay_to') == GoMage_Salesdeals_Model_Adminhtml_System_Config_Source_Category_Applayto::ALL_CATEGORIES) || !$item->getData('cat_applay_to')),                  
            )
        );
        
        $fieldset_category->addField('product_page', 'select',
            array(
                'name'   => 'product_page',
                'label'  => $this->__('Display on Product Pages'),                
                'values' => Mage::getModel('adminhtml/system_config_source_yesno')->toOptionArray(),
                'note'	 => 'The Block will be showed on Product Pages of Selected Categories' 
            )
        ); 

        $fieldset_page = $form->addFieldset('page_settings', array('legend' => $this->__('Page Settings')));
        
        $page = $fieldset_page->addField('page_applay_to', 'select',
            array(
                'name'   => 'page_applay_to',
                'label'  => $this->__('Apply to'),                
                'values' => Mage::getModel('gomage_salesdeals/adminhtml_system_config_source_page_applayto')->toOptionArray(), 
            )
        );
        
        $page->setOnchange('salesdeals_setactive(this, \'pages\', ' . GoMage_Salesdeals_Model_Adminhtml_System_Config_Source_Page_Applayto::SELECTED_PAGES . ', ' . GoMage_Salesdeals_Model_Adminhtml_System_Config_Source_Page_Applayto::ALL_PAGES . ')');
        
        $fieldset_page->addField('pages', 'multiselect',
            array(
                'name'   => 'pages[]',
                'label'  => $this->__('Pages'),                
                'values' => Mage::getModel('gomage_salesdeals/adminhtml_system_config_source_page_pages')->toOptionArray(), 
                'disabled' => (($item->getData('page_applay_to') == GoMage_Salesdeals_Model_Adminhtml_System_Config_Source_Page_Applayto::ALL_PAGES) || !$item->getData('page_applay_to')),
            )
        );
        
        $fieldset_layout = $form->addFieldset('layout_settings', array('legend' => $this->__('Block Layout'), 'class'  => 'fieldset-wide'));
        
        $fieldset_layout->addField('layout', 'textarea',
            array(
                'name'   => 'layout',
                'style'  => 'height:24em;', 
                'label'  => $this->__('Block Layout'),                                 
            )
        );
      
        
        $form->setValues($item->getData());        
        
        return parent::_prepareForm();
        
    }
        
}