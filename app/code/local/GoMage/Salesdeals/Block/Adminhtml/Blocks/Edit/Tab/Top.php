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

class GoMage_Salesdeals_Block_Adminhtml_Blocks_Edit_Tab_Top extends Mage_Adminhtml_Block_Widget_Form
{
	
    protected function _prepareForm()
    {
        
        $form = new Varien_Data_Form();
        
        if(Mage::registry('gomage_salesdeals_block')){
        	$item = Mage::registry('gomage_salesdeals_block');
        }else{
        	$item = new Varien_Object();
        	$item->setData('tb_count', 1);
        	$item->setData('tb_bg_color', 'F4FDFF');
        	$item->setData('tb_title', 'Today\'s Best Deals');        	
        	$item->setData('tb_title_color', 'FFFFFF');
        	$item->setData('tb_title_bg_color', '3B5998');
        	$item->setData('tb_border_size', 1);
        	$item->setData('tb_border_color', 'B9CCDD');
        	$item->setData('tb_image_width', 50);
        	$item->setData('tb_image_height', 50);
        	$item->setData('tb_ticker_text', 'Time Left To Buy');
        	$item->setData('tb_ticker_text_size', 16);        	
        	$item->setData('tb_rem_qty_text', 'Limited Quantity Available');
        	$item->setData('tb_rem_qty_text_size', 14);
        	        	
        	$item->setData('tb_prod_name', 1);
        	$item->setData('tb_image', 1);
        	$item->setData('tb_price', 1);
        	$item->setData('tb_price_name', 'Price');
        	$item->setData('tb_special_price', 1);
        	$item->setData('tb_spec_price_name', 'Special');
        	$item->setData('tb_ticker', 1);
        	$item->setData('tb_bought_qty', 1);
        	$item->setData('tb_rem_qty', 1);
        }
        
        $this->setForm($form);
        $fieldset = $form->addFieldset('top_fieldset', array('legend' => $this->__('Top Block')));
                        
        
        $fieldset->addField('tb_count', 'text', array(
            'name'      => 'tb_count',
            'label'     => $this->__('Deals per Top Block'),
            'title'     => $this->__('Deals per Top Block'),
            'class'		=> 'validate-number',                                         	         
        ));
        
        $fieldset->addField('tb_height', 'text', array(
            'name'      => 'tb_height',
            'label'     => $this->__('Block Height'),
            'title'     => $this->__('Block Height'),
            'class'		=> 'validate-number',                                         	         
        ));
        
         $fieldset->addField('tb_bg_color', 'text', array(
            'name'      => 'tb_bg_color',
            'label'     => $this->__('Block Background Color'),
            'title'     => $this->__('Block Background Color'),
            'class'		=> 'color',                                         	         
        ));
        
        $fieldset->addField('tb_title', 'text', array(
            'name'      => 'tb_title',
            'label'     => $this->__('Block Title'),
            'title'     => $this->__('Block Title'),                                                     	         
        ));
                
        $fieldset->addField('tb_title_color', 'text', array(
            'name'      => 'tb_title_color',
            'label'     => $this->__('Title Color'),
            'title'     => $this->__('Title Color'),
            'class'		=> 'color',                                         	         
        ));
        
        $fieldset->addField('tb_title_bg_color', 'text', array(
            'name'      => 'tb_title_bg_color',
            'label'     => $this->__('Title Background Color'),
            'title'     => $this->__('Title Background Color'),
            'class'		=> 'color',                                         	         
        ));

        $fieldset->addField('tb_border_size', 'text', array(
            'name'      => 'tb_border_size',
            'label'     => $this->__('Border Size, px'),
            'title'     => $this->__('Border Size, px'),
            'class'		=> 'validate-number',                                         	         
        ));
        
        $fieldset->addField('tb_border_color', 'text', array(
            'name'      => 'tb_border_color',
            'label'     => $this->__('Border Color'),
            'title'     => $this->__('Border Color'),
            'class'		=> 'color',                                         	         
        ));
        
        $fieldset->addField('tb_prod_name', 'select',
            array(
                'name'   => 'tb_prod_name',
                'label'  => $this->__('Display Product Name'),
                'title'  => $this->__('Display Product Name'),                
                'values' => Mage::getModel('adminhtml/system_config_source_yesno')->toOptionArray(), 
            )
        );
        
        $fieldset->addField('tb_image', 'select',
            array(
                'name'   => 'tb_image',
                'label'  => $this->__('Display Image'),
                'title'  => $this->__('Display Image'),                
                'values' => Mage::getModel('adminhtml/system_config_source_yesno')->toOptionArray(), 
            )
        );
        
        $fieldset->addField('tb_image_width', 'text', array(
            'name'      => 'tb_image_width',
            'label'     => $this->__('Image Width, px'),
            'title'     => $this->__('Image Width, px'),
            'class'		=> 'validate-number',                                         	         
        ));
        
        $fieldset->addField('tb_image_height', 'text', array(
            'name'      => 'tb_image_height',
            'label'     => $this->__('Image Height, px'),
            'title'     => $this->__('Image Height, px'),
            'class'		=> 'validate-number',                                         	         
        ));
        
        $fieldset->addField('tb_price', 'select',
            array(
                'name'   => 'tb_price',
                'label'  => $this->__('Display Price'),
                'title'  => $this->__('Display Price'),                
                'values' => Mage::getModel('adminhtml/system_config_source_yesno')->toOptionArray(), 
            )
        );
        
        $fieldset->addField('tb_price_name', 'text', array(
            'name'      => 'tb_price_name',
            'label'     => $this->__('Price Name'),
            'title'     => $this->__('Price Name'),                                                     	         
        ));
        
        $fieldset->addField('tb_special_price', 'select',
            array(
                'name'   => 'tb_special_price',
                'label'  => $this->__('Display Special Price'),
                'title'  => $this->__('Display Special Price'),                
                'values' => Mage::getModel('adminhtml/system_config_source_yesno')->toOptionArray(), 
            )
        );
        
        $fieldset->addField('tb_spec_price_name', 'text', array(
            'name'      => 'tb_spec_price_name',
            'label'     => $this->__('Special Price Name'),
            'title'     => $this->__('Special Price Name'),                                                     	         
        ));
        
        $fieldset->addField('tb_ticker', 'select',
            array(
                'name'   => 'tb_ticker',
                'label'  => $this->__('Display Countdown Ticker'),
                'title'  => $this->__('Display Countdown Ticker'),                
                'values' => Mage::getModel('adminhtml/system_config_source_yesno')->toOptionArray(), 
            )
        );
        
        $fieldset->addField('tb_ticker_text', 'text', array(
            'name'      => 'tb_ticker_text',
            'label'     => $this->__('Text Above the Ticker'),
            'title'     => $this->__('Text Above the Ticker'),                                                     	         
        ));
        
        $fieldset->addField('tb_ticker_text_size', 'text', array(
            'name'      => 'tb_ticker_text_size',
            'label'     => $this->__('Text Size Above the Ticker'),
            'title'     => $this->__('Text Size Above the Ticker'),                                                     	         
        ));
        
        $fieldset->addField('tb_bought_qty', 'select',
            array(
                'name'   => 'tb_bought_qty',
                'label'  => $this->__('Display Bought Qty'),
                'title'  => $this->__('Display Bought Qty'),                
                'values' => Mage::getModel('adminhtml/system_config_source_yesno')->toOptionArray(), 
            )
        );
        
        $fieldset->addField('tb_rem_qty', 'select',
            array(
                'name'   => 'tb_rem_qty',
                'label'  => $this->__('Display Remaining Qty'),
                'title'  => $this->__('Display Remaining Qty'),                
                'values' => Mage::getModel('adminhtml/system_config_source_yesno')->toOptionArray(), 
            )
        );
        
        $fieldset->addField('tb_rem_qty_text', 'text', array(
            'name'      => 'tb_rem_qty_text',
            'label'     => $this->__('Text for Remaining Qty'),
            'title'     => $this->__('Text for Remaining Qty'),                                                     	         
        ));
        
        $fieldset->addField('tb_rem_qty_text_size', 'text', array(
            'name'      => 'tb_rem_qty_text_size',
            'label'     => $this->__('Text Size for Remaining Qty'),
            'title'     => $this->__('Text Size for Remaining Qty'),                                                     	         
        ));
        

        $form->setValues($item->getData());        
        
                
        return parent::_prepareForm();
        
    }
        
}