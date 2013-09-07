Validation.add('gomage-salesdeals-validate-prod-qty', 'Please enter valid Deal Quantity.',		
function(v) {	
	var result = (Validation.get('IsEmpty').test(v)
					|| (!isNaN(parseNumber(v)) && !/^\s+$/.test(parseNumber(v))))
					&& (parseNumber(v) <= parseNumber(max_deal_quantity)); 
	
	if (!result && parseNumber($('product_id').value) > 0){		
		alert('Max Deal Quantity is ' + parseNumber(max_deal_quantity));
		return false;
	}else{
		return true;
	}			
		
});

function salesdeals_setactive(control, element_id, endbled_value, disabled_value)
{
	if (control.value == endbled_value)
	{
		$(element_id).enable();
	}	
	if (control.value == disabled_value)
	{
		$(element_id).selectedIndex = -1;
		$(element_id).disable();
	}	
}

function salesdeals_validate_qty(control){  

	var product_id = $(control).value;
	
	if (!product_id) {
		max_deal_quantity = 0;
		return false;
	}
	
	params = {product_id: product_id}; 
		
	var request = new Ajax.Request(gomage_salesdeals_validate_product_url,
	{
	    method:'GET',
	    parameters:params,
	    onSuccess: function(transport){
			
			var response = eval('('+(transport.responseText || false)+')');			 	    		    		    		
			max_deal_quantity = response.qty; 	    			      
	    }
	});			
}

document.observe("dom:loaded", function() {
	SalesDealsAdmin.setDisplayType(SalesDealsAdmin.display);
});

SalesDealsAdminSettings = Class.create({
	
	display: null,
	
	initialize:function(data){
		this.display = data.display;
	},
	
	setDisplayType: function(display_type){		
		this.display = display_type;		
		switch (parseInt(this.display))
		{		
			case 1:				
				$$('a[name="sidebar_section"]')[0].up('li').show();
				$$('a[name="sidebar_ticker_section"]')[0].up('li').show();
				$('display_lc').up('tr').show();
				$('display_rc').up('tr').show();
				
				$$('a[name="top_section"]')[0].up('li').hide();
				$$('a[name="top_ticker_section"]')[0].up('li').hide();				
			break;
			case 2:
				$$('a[name="sidebar_section"]')[0].up('li').hide();
				$$('a[name="sidebar_ticker_section"]')[0].up('li').hide();
				$('display_lc').up('tr').hide();
				$('display_rc').up('tr').hide();
				
				$$('a[name="top_section"]')[0].up('li').show();
				$$('a[name="top_ticker_section"]')[0].up('li').show();
			break;
		}		
		$('display').up('td').up('tr').hide();
	}
});

var blockItems = $H({});

function registerBlockItem(grid, element, checked){	
    if(checked){
        if(element.positionElement){
            element.positionElement.disabled = false;
            blockItems.set(element.value, (element.positionElement.value ? element.positionElement.value : 0));
        }
    }
    else{
        if(element.positionElement){
            element.positionElement.disabled = true;
        }
        blockItems.unset(element.value);
    }
    $('in_block_items').value = blockItems.toQueryString();
    grid.reloadParams = {'selected_items[]':blockItems.keys()};
}

function positionChange(event){
    var element = Event.element(event);
    if(element && element.checkboxElement && element.checkboxElement.checked){
        blockItems.set(element.checkboxElement.value, (element.value ? element.value : 0));
        $('in_block_items').value = blockItems.toQueryString();
    }
}

var tabIndex = 1000;
function BlockItemRowInit(grid, row){
    var checkbox = $(row).getElementsByClassName('checkbox')[0];
    var position = $(row).getElementsByClassName('input-text')[0];
    if(checkbox && position){
        checkbox.positionElement = position;
        position.checkboxElement = checkbox;
        position.disabled = !checkbox.checked;
        position.tabIndex = tabIndex++;
        Event.observe(position,'keyup',positionChange);
        if (checkbox.checked){
        	blockItems.set(checkbox.value, (position.value ? position.value : 0));
        	$('in_block_items').value = blockItems.toQueryString();
        	grid.reloadParams = {'selected_items[]':blockItems.keys()};
        }
    }
}

function BlockItemRowClick(grid, event){
    var trElement = Event.findElement(event, 'tr');
    var isInput   = Event.element(event).tagName == 'INPUT';
    if(trElement){
        var checkbox = Element.getElementsBySelector(trElement, 'input');
        if(checkbox[0]){
            var checked = isInput ? checkbox[0].checked : !checkbox[0].checked;
            salesdeals_items_gridJsObject.setCheckboxChecked(checkbox[0], checked);
        }
    }
}