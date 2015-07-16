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

$installer = $this;

$installer->startSetup();

$installer->run("CREATE TABLE `{$this->getTable('gomage_salesdeals_entity')}` (
  `id` int(11) NOT NULL AUTO_INCREMENT,  
  `status` smallint(1) NOT NULL DEFAULT '0',
  `start_date` date DEFAULT NULL,
  `start_time` time DEFAULT NULL,
  `end_date` date DEFAULT NULL,      
  `end_time` time DEFAULT NULL,
  `product_id` int(11) NOT NULL default '0',
  `deal_qty` int(11) NOT NULL default '0',
  `bought_qty` int(11) NOT NULL default '0',
  `hide_prod_after_end` smallint(1) NOT NULL DEFAULT '0',	
  `hide_ticker_after_end` smallint(1) NOT NULL DEFAULT '0',
  `display_end_message` smallint(1) NOT NULL DEFAULT '0',
  `end_message` text,     
  `bg_color` varchar(10) NOT NULL default '',
  `border_size` int(3) NOT NULL default '0',
  `border_color` varchar(10) NOT NULL default '',  
  `ticker` smallint(1) NOT NULL DEFAULT '0',
  `format` int(3) NOT NULL default '0',
  `day` smallint(1) NOT NULL DEFAULT '0',
  `day_position` varchar(10) NOT NULL DEFAULT '',
  `day_size` int(5) NOT NULL default '0',  
  `time` smallint(1) NOT NULL DEFAULT '0',
  `time_position` varchar(10) NOT NULL DEFAULT '',
  `time_size` int(5) NOT NULL default '0',
  `days_text` varchar(255) NOT NULL default '',
  `hours_text` varchar(255) NOT NULL default '',
  `minutes_text` varchar(255) NOT NULL default '',
  `seconds_text` varchar(255) NOT NULL default '',
  `symbols_color` varchar(10) NOT NULL default '',
  `digits_style` int(3) NOT NULL default '0',
  `digits_color` varchar(10) NOT NULL default '',
  `digits_bg_color` varchar(10) NOT NULL default '',
  `digits_font_size` int(5) NOT NULL default '0',
  `digits_font` varchar(100) NOT NULL default '',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=1;");

$installer->run("CREATE TABLE `{$this->getTable('gomage_salesdeals_block')}` (
  `id` int(11) NOT NULL AUTO_INCREMENT,  
  `block_name` varchar(255) NOT NULL default '',     
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=1;");


$installer->run("CREATE TABLE `{$this->getTable('gomage_salesdeals_block_store')}` (
  `block_store_id` int(11) NOT NULL AUTO_INCREMENT, 		
  `block_id` int(11) NOT NULL DEFAULT '0',
  `store_id` int(11) NOT NULL DEFAULT '0',	 
  
  `status` smallint(1) NOT NULL DEFAULT '0',
  `display` int(3) NOT NULL default '0',
  `display_lc` smallint(1) NOT NULL DEFAULT '0',
  `display_rc` smallint(1) NOT NULL DEFAULT '0',    
  `customer_group_ids` varchar(255) NOT NULL default '',
  `sort_order` int(5) NOT NULL default '0', 
  
  `sb_style` int(3) NOT NULL default '0',
  `sb_count` int(3) NOT NULL default '3',
  `sb_bg_color` varchar(10) NOT NULL default '',
  `sb_title` varchar(255) NOT NULL default '',
  `sb_title_color` varchar(10) NOT NULL default '',
  `sb_title_bg_color` varchar(10) NOT NULL default '',
  `sb_border_size` int(3) NOT NULL default '0',
  `sb_border_color` varchar(10) NOT NULL default '',
  `sb_prod_name` smallint(1) NOT NULL DEFAULT '0',
  `sb_image` smallint(1) NOT NULL DEFAULT '0',
  `sb_image_width` int(5) NOT NULL DEFAULT '0',
  `sb_image_height` int(5) NOT NULL DEFAULT '0',
  `sb_price` smallint(1) NOT NULL DEFAULT '0',
  `sb_price_name` varchar(255) NOT NULL default '',
  `sb_special_price` smallint(1) NOT NULL DEFAULT '0',
  `sb_spec_price_name` varchar(255) NOT NULL default '',
  `sb_ticker` smallint(1) NOT NULL DEFAULT '0',
  `sb_ticker_text` varchar(255) NOT NULL default '',
  `sb_ticker_text_size` int(3) NOT NULL default '0',
  `sb_bought_qty` smallint(1) NOT NULL DEFAULT '0',
  `sb_rem_qty` smallint(1) NOT NULL DEFAULT '0',
  `sb_rem_qty_text` varchar(255) NOT NULL default '',
  `sb_rem_qty_text_size` int(3) NOT NULL default '0',
  
  `sbt_format` int(3) NOT NULL default '0',
  `sbt_day` smallint(1) NOT NULL DEFAULT '0',
  `sbt_day_position` varchar(10) NOT NULL DEFAULT '',
  `sbt_day_size` int(5) NOT NULL default '0',  
  `sbt_time` smallint(1) NOT NULL DEFAULT '0',
  `sbt_time_position` varchar(10) NOT NULL DEFAULT '',
  `sbt_time_size` int(5) NOT NULL default '0',
  `sbt_days_text` varchar(255) NOT NULL default '',
  `sbt_hours_text` varchar(255) NOT NULL default '',
  `sbt_minutes_text` varchar(255) NOT NULL default '',
  `sbt_seconds_text` varchar(255) NOT NULL default '',
  `sbt_symbols_color` varchar(10) NOT NULL default '',
  `sbt_digits_style` int(3) NOT NULL default '0',
  `sbt_digits_color` varchar(10) NOT NULL default '',
  `sbt_digits_bg_color` varchar(10) NOT NULL default '',
  `sbt_digits_font_size` int(5) NOT NULL default '0',
  `sbt_digits_font` varchar(100) NOT NULL default '',
  
  `tb_count` int(3) NOT NULL default '3',
  `tb_height` int(5) NOT NULL default '0',
  `tb_bg_color` varchar(10) NOT NULL default '',
  `tb_title` varchar(255) NOT NULL default '',
  `tb_title_color` varchar(10) NOT NULL default '',
  `tb_title_bg_color` varchar(10) NOT NULL default '',
  `tb_border_size` int(3) NOT NULL default '0',
  `tb_border_color` varchar(10) NOT NULL default '',
  `tb_prod_name` smallint(1) NOT NULL DEFAULT '0',
  `tb_image` smallint(1) NOT NULL DEFAULT '0',
  `tb_image_width` int(5) NOT NULL DEFAULT '0',
  `tb_image_height` int(5) NOT NULL DEFAULT '0',
  `tb_price` smallint(1) NOT NULL DEFAULT '0',
  `tb_price_name` varchar(255) NOT NULL default '',
  `tb_special_price` smallint(1) NOT NULL DEFAULT '0',
  `tb_spec_price_name` varchar(255) NOT NULL default '',
  `tb_ticker` smallint(1) NOT NULL DEFAULT '0',
  `tb_ticker_text` varchar(255) NOT NULL default '',
  `tb_ticker_text_size` int(3) NOT NULL default '0',
  `tb_bought_qty` smallint(1) NOT NULL DEFAULT '0',
  `tb_rem_qty` smallint(1) NOT NULL DEFAULT '0',
  `tb_rem_qty_text` varchar(255) NOT NULL default '',
  `tb_rem_qty_text_size` int(3) NOT NULL default '0',
  
  `tbt_format` int(3) NOT NULL default '0',
  `tbt_day` smallint(1) NOT NULL DEFAULT '0',
  `tbt_day_position` varchar(10) NOT NULL DEFAULT '',
  `tbt_day_size` int(5) NOT NULL default '0',  
  `tbt_time` smallint(1) NOT NULL DEFAULT '0',
  `tbt_time_position` varchar(10) NOT NULL DEFAULT '',
  `tbt_time_size` int(5) NOT NULL default '0',
  `tbt_days_text` varchar(255) NOT NULL default '',
  `tbt_hours_text` varchar(255) NOT NULL default '',
  `tbt_minutes_text` varchar(255) NOT NULL default '',
  `tbt_seconds_text` varchar(255) NOT NULL default '',
  `tbt_symbols_color` varchar(10) NOT NULL default '',
  `tbt_digits_style` int(3) NOT NULL default '0',
  `tbt_digits_color` varchar(10) NOT NULL default '',
  `tbt_digits_bg_color` varchar(10) NOT NULL default '',
  `tbt_digits_font_size` int(5) NOT NULL default '0',
  `tbt_digits_font` varchar(100) NOT NULL default '',
  
  `cat_applay_to` smallint(1) DEFAULT NULL,
  `categories` text,
  `product_page` smallint(1) DEFAULT NULL,
  `page_applay_to` smallint(1) DEFAULT NULL,
  `pages` text,
  `layout` text,

  PRIMARY KEY (`block_store_id`),
  UNIQUE KEY `block_store` (`store_id`,`block_id`),
  KEY `store_id` (`store_id`),
  KEY `block_id` (`block_id`),  
  CONSTRAINT `gomage_salesdeals_block_store_fk` FOREIGN KEY (`block_id`) REFERENCES `{$this->getTable('gomage_salesdeals_block')}` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=1;");


$installer->run("CREATE TABLE `{$this->getTable('gomage_salesdeals_block_entity')}` (
	 item_id int(11) NOT NULL default '0',
     block_id int(11) NOT NULL default '0',
     position int(5) NOT NULL default '0',
     PRIMARY KEY (`item_id`,`block_id`),
 	 KEY `block_id` (`block_id`),
  	 KEY `item_id` (`item_id`),
  	 CONSTRAINT `gomage_salesdeals_block_entity_fk` FOREIGN KEY (`block_id`) REFERENCES `{$this->getTable('gomage_salesdeals_block')}` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  	 CONSTRAINT `gomage_salesdeals_block_entity_fk1` FOREIGN KEY (`item_id`) REFERENCES `{$this->getTable('gomage_salesdeals_entity')}` (`id`) ON DELETE CASCADE ON UPDATE CASCADE  	 
) ENGINE=InnoDB;");

$installer->endSetup(); 