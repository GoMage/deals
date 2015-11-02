/**
 * GoMage Sales and Deals Extension
 *
 * @category     Extension
 * @copyright    Copyright (c) 2010-2015 GoMage (http://www.gomage.com)
 * @author       GoMage
 * @license      http://www.gomage.com/license-agreement/  Single domain license
 * @terms of use http://www.gomage.com/terms-of-use
 * @version      Release: 1.2
 * @since        Available since Release 1.0
 */

var GomageSalesdealsTickers = {};
var gsd_time_offcet = undefined;

document.observe("dom:loaded", function() {
	if (!Prototype.Browser.IE){
		GomageSalesdealsTickersTick();	
	}
});


if (Prototype.Browser.IE) {
	document.onreadystatechange = GomageSalesdealsTickersTick;
}

function GomageSalesdealsTickersTick() { 
	
	if (gsd_time_offcet === undefined){
		var now = new Date();	
		var gsd_time = new Date(gds_current_time[0],
								 parseInt(gds_current_time[1])-1,
								 gds_current_time[2],
								 gds_current_time[3],
								 gds_current_time[4],
								 gds_current_time[5]);		
		gsd_time_offcet = now.getTime() - gsd_time.getTime();
	}
	
	for(var key in GomageSalesdealsTickers){
		if (GomageSalesdealsTickers.hasOwnProperty(key)){
		    var ticker = GomageSalesdealsTickers[key];
		    ticker.tick();
		}
	} 

    Timer = setTimeout("GomageSalesdealsTickersTick()",1000);         
}


GomageSalesdealsTicker = Class.create();
GomageSalesdealsTicker.prototype = {
		
		config: null,
		end_date: null,
		enabled: null,
		
		initialize: function(config){
			this.config = config;
			
			this.end_date = new Date(this.config.end_date[0],
									 parseInt(this.config.end_date[1])-1,
									 this.config.end_date[2],
									 this.config.end_date[3],
									 this.config.end_date[4],
									 this.config.end_date[5]);
			this.enabled = true;
			
			GomageSalesdealsTickers[this.config.id] = this;

			
		},
		
		tick: function(id){
			
			if (!this.enabled){
				return;
			}
			
			now = new Date(); 	        	     	         
	        razn = this.end_date.getTime() - now.getTime() + gsd_time_offcet;
	        
	        if (razn < 0){
	        	if ($('salesdeals-ticker-day-' + this.config.id))
	        		$('salesdeals-ticker-day-' + this.config.id).innerHTML = '0';
	        	if ($('salesdeals-ticker-hour-' + this.config.id))
	        		$('salesdeals-ticker-hour-' + this.config.id).innerHTML = this.formatTime(0);
	        	if ($('salesdeals-ticker-min-' + this.config.id))
	        		$('salesdeals-ticker-min-' + this.config.id).innerHTML =  this.formatTime(0);
	        	if ($('salesdeals-ticker-sec-' + this.config.id))
	        		$('salesdeals-ticker-sec-' + this.config.id).innerHTML = this.formatTime(0);
		        this.enabled = false;
		        return;
	        }
	        	
	        x = razn/1000; 
	        
	        $('salesdeals-ticker-day-' + this.config.id).innerHTML = Math.floor(x/60/60/24);
	        $('salesdeals-ticker-hour-' + this.config.id).innerHTML = this.formatTime(Math.floor(x/60/60 - Math.floor(x/60/60/24)*24)); 
	        $('salesdeals-ticker-min-' + this.config.id).innerHTML =  this.formatTime(Math.floor((x/60/60 - Math.floor(x/60/60))*60)); 
	        x = (((x/60/60 - Math.floor(x/60/60))*60) - Math.floor((x/60/60 - Math.floor(x/60/60))*60))*60; 
	        $('salesdeals-ticker-sec-' + this.config.id).innerHTML = this.formatTime(Math.floor(x)); 
	         
	        
	        if (Math.floor(razn/1000) <= 0){
	        	this.enabled = false;
	        	delete GomageSalesdealsTickers[this.config.id];
	        	refreshTicker(this);
	        } 
		},
		
		formatTime: function(value){
			return (value < 10 ? '0' + value : value);			
		}
}

function refreshTicker(ticker){
	
	var params = {
			id: ticker.config.id,
			item_id: ticker.config.item_id,	
			block_id: ticker.config.block_id,
			position: ticker.config.position	
	};

	var request = new Ajax.Request(gomage_sales_deals_refresh,
	{
	    method:'post',
	    parameters:params,
	    onSuccess:function(transport){
	    	
	    	var response = eval('('+(transport.responseText || false)+')');
	    	
	    	if (response.remove_item){
	    		$(response.remove_item).remove();
		    	if(response.remove_block){
		    		$$('div.' + response.remove_block)[0].remove();
		    		return;
		    	}
		    	return;
	    	}
	    	
	    	var js_scripts = response.html.extractScripts();
	    	var content = response.html.stripScripts();	    	
	    	var element = $(response.id);
	        
	        if (typeof(element) == 'undefined'){
	        	return;
	        }
	        
	        if (content && content.toElement){	        	
	        	content = content.toElement();	        	
	        }else if (!Object.isElement(content)) {	        	
	          content = Object.toHTML(content);	          
	          var tempElement = document.createElement('div');	        
	          tempElement.innerHTML = content;
	          
	          var re = new RegExp('\\b' + response.id + '\\b');
	          var els = tempElement.getElementsByTagName("*");
	          for(var i=0,j=els.length; i<j; i++){
		          if(re.test(els[i].id)) content = els[i];
		      } 	          
	        }	        
	        element.parentNode.replaceChild(content, element);
	    							
			for (var i=0; i< js_scripts.length; i++){																
		        if (typeof(js_scripts[i]) != 'undefined'){        	        	
		        	SalsesDealsglobalEval(js_scripts[i]);                	
		        }
			}    
	    		    	
	      
	    },
	    onFailure: function(){	    	
	    }
	});
}

var SalsesDealsglobalEval = function LightcheckoutglobalEval(src){
    if (window.execScript) {
        window.execScript(src);
        return;
    }
    var fn = function() {
        window.eval.call(window,src);
    };
    fn();
};