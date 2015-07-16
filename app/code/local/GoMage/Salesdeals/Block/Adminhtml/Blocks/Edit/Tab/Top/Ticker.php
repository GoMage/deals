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

class GoMage_Salesdeals_Block_Adminhtml_Blocks_Edit_Tab_Top_Ticker extends Mage_Adminhtml_Block_Widget_Form
{
	
    protected function _prepareForm()
    {
        
        $form = new Varien_Data_Form();
        
        if(Mage::registry('gomage_salesdeals_block')){
        	$item = Mage::registry('gomage_salesdeals_block');
        }else{
        	$item = new Varien_Object();
        	$item->setData('tbt_format', 2);
        	$item->setData('tbt_day_position', 'right');
        	$item->setData('tbt_day_size', 16);
        	$item->setData('tbt_time_position', 'right');
        	$item->setData('tbt_time_size', 16);
        	$item->setData('tbt_days_text', 'dd');
        	$item->setData('tbt_hours_text', 'hh');
        	$item->setData('tbt_minutes_text', 'mm');
        	$item->setData('tbt_seconds_text', 'ss');
        	$item->setData('tbt_symbols_color', '000000');
        	$item->setData('tbt_digits_color', '000000');
        	$item->setData('tbt_digits_bg_color', 'F4FDFF');
        	$item->setData('tbt_digits_font_size', 16);
        	$item->setData('tbt_day', 1);
        	$item->setData('tbt_time', 1);
        }
        
        $this->setForm($form);
        $fieldset = $form->addFieldset('top_ticker_fieldset', array('legend' => $this->__('Top Block Ticker')));
                        
        $fieldset->addField('tbt_format', 'select',
            array(
                'name'   => 'tbt_format',
                'label'  => $this->__('Countdown Ticker Format'),
                'title'  => $this->__('Countdown Ticker Format'),                
                'values' => Mage::getModel('gomage_salesdeals/adminhtml_system_config_source_ticker_format')->toOptionArray(), 
            )
        );
        
        $fieldset->addField('tbt_day', 'select',
            array(
                'name'   => 'tbt_day',
                'label'  => $this->__('Display Day Symbols'),
                'title'  => $this->__('Display Day Symbols'),                
                'values' => Mage::getModel('adminhtml/system_config_source_yesno')->toOptionArray(), 
            )
        );
        
        $fieldset->addField('tbt_day_position', 'select',
            array(
                'name'   => 'tbt_day_position',
                'label'  => $this->__('Day Symbols Position'),
                'title'  => $this->__('Day Symbols Position'),                
                'values' => Mage::getModel('gomage_salesdeals/adminhtml_system_config_source_ticker_position')->toOptionArray(), 
            )
        );
        
        $fieldset->addField('tbt_day_size', 'text', array(
            'name'      => 'tbt_day_size',
            'label'     => $this->__('Day Symbols Size, px'),
            'title'     => $this->__('Day Symbols Size, px'),
            'class'		=> 'validate-number',                                         	         
        ));
        
        $fieldset->addField('tbt_time', 'select',
            array(
                'name'   => 'tbt_time',
                'label'  => $this->__('Display Time Symbols'),
                'title'  => $this->__('Display Time Symbols'),                
                'values' => Mage::getModel('adminhtml/system_config_source_yesno')->toOptionArray(), 
            )
        );
        
        $fieldset->addField('tbt_time_position', 'select',
            array(
                'name'   => 'tbt_time_position',
                'label'  => $this->__('Time Symbols Position'),
                'title'  => $this->__('Time Symbols Position'),                
                'values' => Mage::getModel('gomage_salesdeals/adminhtml_system_config_source_ticker_position')->toOptionArray(), 
            )
        );
        
        $fieldset->addField('tbt_time_size', 'text', array(
            'name'      => 'tbt_time_size',
            'label'     => $this->__('Time Symbols Size, px'),
            'title'     => $this->__('Time Symbols Size, px'),
            'class'		=> 'validate-number',                                         	         
        ));
        
        $fieldset->addField('tbt_days_text', 'text', array(
            'name'      => 'tbt_days_text',
            'label'     => $this->__('Days Text'),
            'title'     => $this->__('Days Text'),                                         	         
        ));
        
        $fieldset->addField('tbt_hours_text', 'text', array(
            'name'      => 'tbt_hours_text',
            'label'     => $this->__('Hours Text'),
            'title'     => $this->__('Hours Text'),                                         	         
        ));
        
        $fieldset->addField('tbt_minutes_text', 'text', array(
            'name'      => 'tbt_minutes_text',
            'label'     => $this->__('Minutes Text'),
            'title'     => $this->__('Minutes Text'),                                         	         
        ));
        
        $fieldset->addField('tbt_seconds_text', 'text', array(
            'name'      => 'tbt_seconds_text',
            'label'     => $this->__('Seconds Text'),
            'title'     => $this->__('Seconds Text'),                                         	         
        ));
        
        $fieldset->addField('tbt_symbols_color', 'text', array(
            'name'      => 'tbt_symbols_color',
            'label'     => $this->__('Symbols Color'),
            'title'     => $this->__('Symbols Color'),
            'class'		=> 'color',                                         	         
        ));
        /*
        $fieldset->addField('tbt_digits_style', 'select',
            array(
                'name'   => 'tbt_digits_style',
                'label'  => $this->__('Digits Style'),
                'title'  => $this->__('Digits Style'),                
                'values' => Mage::getModel('gomage_salesdeals/adminhtml_system_config_source_ticker_digits_style')->toOptionArray(), 
            )
        );
        */
        $fieldset->addField('tbt_digits_color', 'text', array(
            'name'      => 'tbt_digits_color',
            'label'     => $this->__('Digits Color'),
            'title'     => $this->__('Digits Color'),
            'class'		=> 'color',                                         	         
        ));
        
        $fieldset->addField('tbt_digits_bg_color', 'text', array(
            'name'      => 'tbt_digits_bg_color',
            'label'     => $this->__('Digits Background Color'),
            'title'     => $this->__('Digits Background Color'),
            'class'		=> 'color',                                         	         
        ));
        
        $fieldset->addField('tbt_digits_font_size', 'text', array(
            'name'      => 'tbt_digits_font_size',
            'label'     => $this->__('Digits Font Size, px'),
            'title'     => $this->__('Digits Font Size, px'),
            'class'		=> 'validate-number',                                         	         
        ));
        
        $fieldset->addField('tbt_digits_font', 'select',
            array(
                'name'   => 'tbt_digits_font',
                'label'  => $this->__('Digits Style'),
                'title'  => $this->__('Digits Style'),                
                'values' => Mage::getModel('gomage_salesdeals/adminhtml_system_config_source_ticker_digits_font')->toOptionArray(), 
            )
        );
        
        

        $form->setValues($item->getData());        
        
                
        return parent::_prepareForm();
        
    }
        
}