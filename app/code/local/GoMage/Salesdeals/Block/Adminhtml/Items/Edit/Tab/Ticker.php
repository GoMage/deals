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

class GoMage_Salesdeals_Block_Adminhtml_Items_Edit_Tab_Ticker extends Mage_Adminhtml_Block_Widget_Form
{
	
    protected function _prepareForm()
    {
        
        $form = new Varien_Data_Form();
        
        if(Mage::registry('gomage_salesdeals')){
        	$item = Mage::registry('gomage_salesdeals');
        }else{
        	$item = new Varien_Object();
        	$item->setData('bg_color', 'F4FDFF');
        	$item->setData('border_size', 1);
        	$item->setData('border_color', 'B9CCDD');
        	
        	$item->setData('format', 2);
        	$item->setData('day_position', 'right');
        	$item->setData('day_size', 16);
        	$item->setData('time_position', 'right');
        	$item->setData('time_size', 16);
        	$item->setData('days_text', 'dd');
        	$item->setData('hours_text', 'hh');
        	$item->setData('minutes_text', 'mm');
        	$item->setData('seconds_text', 'ss');
        	$item->setData('symbols_color', '000000');
        	$item->setData('digits_color', '000000');
        	$item->setData('digits_bg_color', 'F4FDFF');
        	$item->setData('digits_font_size', 16);
        	$item->setData('day', 1);
        	$item->setData('time', 1);        	
        }
        
        $this->setForm($form);
        
        $fieldset = $form->addFieldset('sidebar_block_settings_fieldset', array('legend' => $this->__('Block Settings')));
        
        $fieldset->addField('bg_color', 'text', array(
            'name'      => 'bg_color',
            'label'     => $this->__('Box Background Color'),
            'title'     => $this->__('Box Background Color'),
            'class'		=> 'color',                                         	         
        ));
        
        $fieldset->addField('border_size', 'text', array(
            'name'      => 'border_size',
            'label'     => $this->__('Border Size, px'),
            'title'     => $this->__('Border Size, px'),
            'class'		=> 'validate-number',                                         	         
        ));
        
         $fieldset->addField('border_color', 'text', array(
            'name'      => 'border_color',
            'label'     => $this->__('Border Color'),
            'title'     => $this->__('Border Color'),
            'class'		=> 'color',                                         	         
        ));
        
        $fieldset = $form->addFieldset('sidebar_ticker_fieldset', array('legend' => $this->__('Product Page Ticker')));
                        
        
        $fieldset->addField('ticker', 'select',
            array(
                'name'   => 'ticker',
                'label'  => $this->__('Display Countdown Ticker'),
                'title'  => $this->__('Display Countdown Ticker'),                
                'values' => Mage::getModel('adminhtml/system_config_source_yesno')->toOptionArray(), 
            )
        );
        
        $fieldset->addField('format', 'select',
            array(
                'name'   => 'format',
                'label'  => $this->__('Countdown Ticker Format'),
                'title'  => $this->__('Countdown Ticker Format'),                
                'values' => Mage::getModel('gomage_salesdeals/adminhtml_system_config_source_ticker_format')->toOptionArray(), 
            )
        );
        
        $fieldset->addField('day', 'select',
            array(
                'name'   => 'day',
                'label'  => $this->__('Display Day Symbols'),
                'title'  => $this->__('Display Day Symbols'),                
                'values' => Mage::getModel('adminhtml/system_config_source_yesno')->toOptionArray(), 
            )
        );
        
        $fieldset->addField('day_position', 'select',
            array(
                'name'   => 'day_position',
                'label'  => $this->__('Day Symbols Position'),
                'title'  => $this->__('Day Symbols Position'),                
                'values' => Mage::getModel('gomage_salesdeals/adminhtml_system_config_source_ticker_position')->toOptionArray(), 
            )
        );
        
        $fieldset->addField('day_size', 'text', array(
            'name'      => 'day_size',
            'label'     => $this->__('Day Symbols Size, px'),
            'title'     => $this->__('Day Symbols Size, px'),
            'class'		=> 'validate-number',                                         	         
        ));
        
        $fieldset->addField('time', 'select',
            array(
                'name'   => 'time',
                'label'  => $this->__('Display Time Symbols'),
                'title'  => $this->__('Display Time Symbols'),                
                'values' => Mage::getModel('adminhtml/system_config_source_yesno')->toOptionArray(), 
            )
        );
        
        $fieldset->addField('time_position', 'select',
            array(
                'name'   => 'time_position',
                'label'  => $this->__('Time Symbols Position'),
                'title'  => $this->__('Time Symbols Position'),                
                'values' => Mage::getModel('gomage_salesdeals/adminhtml_system_config_source_ticker_position')->toOptionArray(), 
            )
        );
        
        $fieldset->addField('time_size', 'text', array(
            'name'      => 'time_size',
            'label'     => $this->__('Time Symbols Size, px'),
            'title'     => $this->__('Time Symbols Size, px'),
            'class'		=> 'validate-number',                                         	         
        ));
        
        $fieldset->addField('days_text', 'text', array(
            'name'      => 'days_text',
            'label'     => $this->__('Days Text'),
            'title'     => $this->__('Days Text'),                                         	         
        ));
        
        $fieldset->addField('hours_text', 'text', array(
            'name'      => 'hours_text',
            'label'     => $this->__('Hours Text'),
            'title'     => $this->__('Hours Text'),                                         	         
        ));
        
        $fieldset->addField('minutes_text', 'text', array(
            'name'      => 'minutes_text',
            'label'     => $this->__('Minutes Text'),
            'title'     => $this->__('Minutes Text'),                                         	         
        ));
        
        $fieldset->addField('seconds_text', 'text', array(
            'name'      => 'seconds_text',
            'label'     => $this->__('Seconds Text'),
            'title'     => $this->__('Seconds Text'),                                         	         
        ));
        
        $fieldset->addField('symbols_color', 'text', array(
            'name'      => 'symbols_color',
            'label'     => $this->__('Symbols Color'),
            'title'     => $this->__('Symbols Color'),
            'class'		=> 'color',                                         	         
        ));
        /*
        $fieldset->addField('digits_style', 'select',
            array(
                'name'   => 'digits_style',
                'label'  => $this->__('Digits Style'),
                'title'  => $this->__('Digits Style'),                
                'values' => Mage::getModel('gomage_salesdeals/adminhtml_system_config_source_ticker_digits_style')->toOptionArray(), 
            )
        );
        */
        $fieldset->addField('digits_color', 'text', array(
            'name'      => 'digits_color',
            'label'     => $this->__('Digits Color'),
            'title'     => $this->__('Digits Color'),
            'class'		=> 'color',                                         	         
        ));
        
        $fieldset->addField('digits_bg_color', 'text', array(
            'name'      => 'digits_bg_color',
            'label'     => $this->__('Digits Background Color'),
            'title'     => $this->__('Digits Background Color'),
            'class'		=> 'color',                                         	         
        ));
        
        $fieldset->addField('digits_font_size', 'text', array(
            'name'      => 'digits_font_size',
            'label'     => $this->__('Digits Font Size, px'),
            'title'     => $this->__('Digits Font Size, px'),
            'class'		=> 'validate-number',                                         	         
        ));
        
        $fieldset->addField('digits_font', 'select',
            array(
                'name'   => 'digits_font',
                'label'  => $this->__('Digits Style'),
                'title'  => $this->__('Digits Style'),                
                'values' => Mage::getModel('gomage_salesdeals/adminhtml_system_config_source_ticker_digits_font')->toOptionArray(), 
            )
        );

        $form->setValues($item->getData());        
        
                
        return parent::_prepareForm();
        
    }
        
}