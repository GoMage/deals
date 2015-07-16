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

class GoMage_Salesdeals_Block_Adminhtml_Blocks_Edit_Tab_Sidebar_Ticker extends Mage_Adminhtml_Block_Widget_Form
{
	
    protected function _prepareForm()
    {
        
        $form = new Varien_Data_Form();
        
        if(Mage::registry('gomage_salesdeals_block')){
        	$item = Mage::registry('gomage_salesdeals_block');
        }else{
        	$item = new Varien_Object();
        	$item->setData('sbt_format', 2);
        	$item->setData('sbt_day_position', 'right');
        	$item->setData('sbt_day_size', 16);
        	$item->setData('sbt_time_position', 'right');
        	$item->setData('sbt_time_size', 16);
        	$item->setData('sbt_days_text', 'dd');
        	$item->setData('sbt_hours_text', 'hh');
        	$item->setData('sbt_minutes_text', 'mm');
        	$item->setData('sbt_seconds_text', 'ss');
        	$item->setData('sbt_symbols_color', '000000');
        	$item->setData('sbt_digits_color', '000000');
        	$item->setData('sbt_digits_bg_color', 'F4FDFF');
        	$item->setData('sbt_digits_font_size', 16);
        	$item->setData('sbt_day', 1);
        	$item->setData('sbt_time', 1);        	
        }
        
        $this->setForm($form);
        $fieldset = $form->addFieldset('sidebar_ticker_fieldset', array('legend' => $this->__('Sidebar Block Ticker')));
                        
        
        $fieldset->addField('sbt_format', 'select',
            array(
                'name'   => 'sbt_format',
                'label'  => $this->__('Countdown Ticker Format'),
                'title'  => $this->__('Countdown Ticker Format'),                
                'values' => Mage::getModel('gomage_salesdeals/adminhtml_system_config_source_ticker_format')->toOptionArray(), 
            )
        );
        
        $fieldset->addField('sbt_day', 'select',
            array(
                'name'   => 'sbt_day',
                'label'  => $this->__('Display Day Symbols'),
                'title'  => $this->__('Display Day Symbols'),                
                'values' => Mage::getModel('adminhtml/system_config_source_yesno')->toOptionArray(), 
            )
        );
        
        $fieldset->addField('sbt_day_position', 'select',
            array(
                'name'   => 'sbt_day_position',
                'label'  => $this->__('Day Symbols Position'),
                'title'  => $this->__('Day Symbols Position'),                
                'values' => Mage::getModel('gomage_salesdeals/adminhtml_system_config_source_ticker_position')->toOptionArray(), 
            )
        );
        
        $fieldset->addField('sbt_day_size', 'text', array(
            'name'      => 'sbt_day_size',
            'label'     => $this->__('Day Symbols Size, px'),
            'title'     => $this->__('Day Symbols Size, px'),
            'class'		=> 'validate-number',                                         	         
        ));
        
        $fieldset->addField('sbt_time', 'select',
            array(
                'name'   => 'sbt_time',
                'label'  => $this->__('Display Time Symbols'),
                'title'  => $this->__('Display Time Symbols'),                
                'values' => Mage::getModel('adminhtml/system_config_source_yesno')->toOptionArray(), 
            )
        );
        
        $fieldset->addField('sbt_time_position', 'select',
            array(
                'name'   => 'sbt_time_position',
                'label'  => $this->__('Time Symbols Position'),
                'title'  => $this->__('Time Symbols Position'),                
                'values' => Mage::getModel('gomage_salesdeals/adminhtml_system_config_source_ticker_position')->toOptionArray(), 
            )
        );
        
        $fieldset->addField('sbt_time_size', 'text', array(
            'name'      => 'sbt_time_size',
            'label'     => $this->__('Time Symbols Size, px'),
            'title'     => $this->__('Time Symbols Size, px'),
            'class'		=> 'validate-number',                                         	         
        ));
        
        $fieldset->addField('sbt_days_text', 'text', array(
            'name'      => 'sbt_days_text',
            'label'     => $this->__('Days Text'),
            'title'     => $this->__('Days Text'),                                         	         
        ));
        
        $fieldset->addField('sbt_hours_text', 'text', array(
            'name'      => 'sbt_hours_text',
            'label'     => $this->__('Hours Text'),
            'title'     => $this->__('Hours Text'),                                         	         
        ));
        
        $fieldset->addField('sbt_minutes_text', 'text', array(
            'name'      => 'sbt_minutes_text',
            'label'     => $this->__('Minutes Text'),
            'title'     => $this->__('Minutes Text'),                                         	         
        ));
        
        $fieldset->addField('sbt_seconds_text', 'text', array(
            'name'      => 'sbt_seconds_text',
            'label'     => $this->__('Seconds Text'),
            'title'     => $this->__('Seconds Text'),                                         	         
        ));
        
        $fieldset->addField('sbt_symbols_color', 'text', array(
            'name'      => 'sbt_symbols_color',
            'label'     => $this->__('Symbols Color'),
            'title'     => $this->__('Symbols Color'),
            'class'		=> 'color',                                         	         
        ));
        /*
        $fieldset->addField('sbt_digits_style', 'select',
            array(
                'name'   => 'sbt_digits_style',
                'label'  => $this->__('Digits Style'),
                'title'  => $this->__('Digits Style'),                
                'values' => Mage::getModel('gomage_salesdeals/adminhtml_system_config_source_ticker_digits_style')->toOptionArray(), 
            )
        );
        */
        $fieldset->addField('sbt_digits_color', 'text', array(
            'name'      => 'sbt_digits_color',
            'label'     => $this->__('Digits Color'),
            'title'     => $this->__('Digits Color'),
            'class'		=> 'color',                                         	         
        ));
        
        $fieldset->addField('sbt_digits_bg_color', 'text', array(
            'name'      => 'sbt_digits_bg_color',
            'label'     => $this->__('Digits Background Color'),
            'title'     => $this->__('Digits Background Color'),
            'class'		=> 'color',                                         	         
        ));
        
        $fieldset->addField('sbt_digits_font_size', 'text', array(
            'name'      => 'sbt_digits_font_size',
            'label'     => $this->__('Digits Font Size, px'),
            'title'     => $this->__('Digits Font Size, px'),
            'class'		=> 'validate-number',                                         	         
        ));
        
        $fieldset->addField('sbt_digits_font', 'select',
            array(
                'name'   => 'sbt_digits_font',
                'label'  => $this->__('Digits Style'),
                'title'  => $this->__('Digits Style'),                
                'values' => Mage::getModel('gomage_salesdeals/adminhtml_system_config_source_ticker_digits_font')->toOptionArray(), 
            )
        );

        $form->setValues($item->getData());        
        
                
        return parent::_prepareForm();
        
    }
        
}