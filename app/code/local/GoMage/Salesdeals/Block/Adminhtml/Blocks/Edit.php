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

class GoMage_Salesdeals_Block_Adminhtml_Blocks_Edit extends Mage_Adminhtml_Block_Widget_Form_Container
{
    public function __construct(){
    	
        parent::__construct();
                 
        $this->_objectId = 'id';
        $this->_blockGroup = 'gomage_salesdeals';
        $this->_controller = 'adminhtml_blocks';
        
        $this->_updateButton('save', 'label', $this->__('Save'));
        $this->_updateButton('delete', 'label', $this->__('Delete'));
		
        $this->_addButton('saveandcontinue', array(
            'label'     => $this->__('Save And Continue Edit'),
            'onclick'   => 'saveAndContinueEdit()',
            'class'     => 'save',
        ), -100);
        
        $settings = array();
        $settings['display'] = GoMage_Salesdeals_Model_Adminhtml_System_Config_Source_Display::SIDEBAR;

        if (Mage::registry('gomage_salesdeals_block')){
            $settings['display'] = Mage::registry('gomage_salesdeals_block')->getDisplay();
        }
                 
        $this->_formScripts[] = "

            function saveAndContinueEdit(){
            	
                editForm.submit($('edit_form').action+'back/edit/');
            } 

            var SalesDealsAdmin = new SalesDealsAdminSettings(" . Mage::helper('core')->jsonEncode($settings) . ");
                        
        "; 
    }
    
    public function getHeaderText(){
    	
        if( Mage::registry('gomage_salesdeals_block') && Mage::registry('gomage_salesdeals_block')->getId() ) {
            return $this->__("Edit Block %s", $this->htmlEscape(Mage::registry('gomage_salesdeals_block')->getName()));
        } else {
            return $this->__('Add Block');
        }
        
    }
}