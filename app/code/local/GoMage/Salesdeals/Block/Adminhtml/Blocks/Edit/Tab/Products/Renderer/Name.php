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

class GoMage_Salesdeals_Block_Adminhtml_Blocks_Edit_Tab_Products_Renderer_Name extends Mage_Adminhtml_Block_Widget_Grid_Column_Renderer_Abstract
{    
    public function render(Varien_Object $item){
		return $item->getProduct()->getName();		
	}    
}