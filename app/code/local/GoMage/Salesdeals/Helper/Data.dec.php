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

class GoMage_Salesdeals_Helper_Data extends Mage_Core_Helper_Abstract{
    
    public function getConfigData($node){
		return Mage::getStoreConfig('gomage_salesdeals/'.$node);
	}
	
	public function getAllStoreDomains(){
		
		$domains = array();
    	
    	foreach (Mage::app()->getWebsites() as $website) {
    		
    		$url = $website->getConfig('web/unsecure/base_url');
    		
    		if($domain = trim(preg_replace('/^.*?\\/\\/(.*)?\\//', '$1', $url))){
    		
    		$domains[] = $domain;
    		
    		}
    		
    		$url = $website->getConfig('web/secure/base_url');
    		
    		if($domain = trim(preg_replace('/^.*?\\/\\/(.*)?\\//', '$1', $url))){
    		
    		$domains[] = $domain;
    		
    		}
    		
    	}
    	
    	return array_unique($domains);
    	
		
	}
	
	public function getAvailabelWebsites(){
		return $this->_w();
	}
	
	public function getAvailavelWebsites(){
		return $this->_w();
	}
	
	protected function _w(){
    
        if(!Mage::getStoreConfig('gomage_activation/salesdeals/installed') || 
           (intval(Mage::getStoreConfig('gomage_activation/salesdeals/count')) > 10))
		{
			return array();
		}
		            		
		$time_to_update = 60*60*24*15;
		
		$r = Mage::getStoreConfig('gomage_activation/salesdeals/ar');
		$t = Mage::getStoreConfig('gomage_activation/salesdeals/time');
		$s = Mage::getStoreConfig('gomage_activation/salesdeals/websites');
		
		$last_check = str_replace($r, '', Mage::helper('core')->decrypt($t));
		
		$allsites = explode(',', str_replace($r, '', Mage::helper('core')->decrypt($s)));
		$allsites = array_diff($allsites, array(""));
			
		if(($last_check+$time_to_update) < time()){
			$this->a(Mage::getStoreConfig('gomage_activation/salesdeals/key'), 
			         intval(Mage::getStoreConfig('gomage_activation/salesdeals/count')),
			         implode(',', $allsites));
		}
		
		return $allsites;
		
	}
	
	public function a($k, $c = 0, $s = ''){
		
		$ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, sprintf('https://www.gomage.com/index.php/gomage_downloadable/key/check'));
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, 'key='.urlencode($k).'&sku=salesdeals&domains='.urlencode(implode(',', $this->getAllStoreDomains())).'&ver='.urlencode('1.0'));
        curl_setopt($ch, CURLOPT_TIMEOUT, 30);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
        
        $content = curl_exec($ch);
        
        $r	= Zend_Json::decode($content);
        $e = Mage::helper('core');
        if(empty($r)){
        	
        	$value1 = Mage::getStoreConfig('gomage_activation/salesdeals/ar');
        	
	        $groups = array(
	        	'salesdeals'=>array(
	        		'fields'=>array(
	        			'ar'=>array(
	        				'value'=>$value1
	        			),
	        			'websites'=>array(
	        				'value'=>(string)Mage::getStoreConfig('gomage_activation/salesdeals/websites')
	        			),
	        			'time'=>array(
	        				'value'=>(string)$e->encrypt($value1.(time()-(60*60*24*15-1800)).$value1)
	        			),
	        			'count'=>array(
	        				'value'=>$c+1)
	        		)
	        	)
        	);
        	
	        Mage::getModel('adminhtml/config_data')
	                ->setSection('gomage_activation')
	                ->setGroups($groups)
	                ->save();
        	
	        Mage::getConfig()->reinit();
            Mage::app()->reinitStores();        
	                
        	return;
        }
        
        $value1 = '';
        $value2 = '';
        
        
        
        if(isset($r['d']) && isset($r['c'])){
    		$value1 = $e->encrypt(base64_encode(Zend_Json::encode($r)));
        
        
        if (!$s) $s = Mage::getStoreConfig('gomage_activation/salesdeals/websites');
        
        $s = array_slice(explode(',', $s), 0, $r['c']);
        
        $value2 = $e->encrypt($value1.implode(',', $s).$value1);
        
        }
        $groups = array(
        	'salesdeals'=>array(
        		'fields'=>array(
        			'ar'=>array(
        				'value'=>$value1
        			),
        			'websites'=>array(
        				'value'=>(string)$value2
        			),
        			'time'=>array(
        				'value'=>(string)$e->encrypt($value1.time().$value1)
        			),
        			'installed'=>array(
        				'value'=>1
        			),
        			'count'=>array(
        				'value'=>0)
        			
        		)
        	)
        );
        
        Mage::getModel('adminhtml/config_data')
                ->setSection('gomage_activation')
                ->setGroups($groups)
                ->save();
                
        Mage::getConfig()->reinit();
        Mage::app()->reinitStores();        
        
	}
	
	public function ga(){
		return Zend_Json::decode(base64_decode(Mage::helper('core')->decrypt(Mage::getStoreConfig('gomage_activation/salesdeals/ar'))));
	}
	
	public function isGomageSalesdeals(){
	     return in_array(Mage::app()->getStore()->getWebsiteId(), $this->getAvailavelWebsites()); 	         	     
	}
	
	public function formatColor($value){
	    if ($value = preg_replace('/[^a-zA-Z0-9\s]/', '', $value)){
	       $value = '#' . $value; 	        
	    }
	    return $value;
	}
	
	public function formatFontFamily($value){
	    switch($value){
	        case 'Arial':
	               $value = 'Arial, "Nimbus Sans L", Helvetica, sans-serif'; 
	            break;
	        case 'Courier New':
	               $value = '"Courier New", "Nimbus Mono L", Courier, monospace';
	            break;
	        case 'Times New Roman':
	               $value = '"Times New Roman", "Nimbus Roman No9 L", Times, serif'; 
	            break;          
	    }
	    
	    return $value;
	}
	
	public function notify(){
    	
    	$frequency = intval(Mage::app()->loadCache('gomage_notifications_frequency')); 
    	if (!$frequency){
    		$frequency = 24;
    	}
    	$last_update = intval(Mage::app()->loadCache('gomage_notifications_last_update')); 
    	
    	if (($frequency * 60 * 60 + $last_update) > time()) {
            return false;
        }              

        $timestamp = $last_update;
        if (!$timestamp){
        	$timestamp = time();
        }
        
        try{
	        $ch = curl_init();
	        curl_setopt($ch, CURLOPT_URL, sprintf('https://www.gomage.com/index.php/gomage_notification/index/data'));
	        curl_setopt($ch, CURLOPT_POST, true);
	        curl_setopt($ch, CURLOPT_POSTFIELDS, 'sku=salesdeals&timestamp='.$timestamp.'&ver='.urlencode('1.0'));
	        curl_setopt($ch, CURLOPT_TIMEOUT, 30);
	        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
	        
	        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
	        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
	        
	        $content = curl_exec($ch);
	        
	        $result	= Zend_Json::decode($content);
	                                
	        if ($result && isset($result['frequency']) && ($result['frequency'] != $frequency)){
	        	Mage::app()->saveCache($result['frequency'], 'gomage_notifications_frequency'); 
	        }
	        
	    	if ($result && isset($result['data'])){
	        	if (!empty($result['data'])){	
	        		Mage::getModel('adminnotification/inbox')->parse($result['data']); 
	        	} 
	        }
        } catch (Exception $e){}    
        
        Mage::app()->saveCache(time(), 'gomage_notifications_last_update');
        
    }
	
	
}
