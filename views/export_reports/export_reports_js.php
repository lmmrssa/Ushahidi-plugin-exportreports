<?php defined('SYSPATH') or die('No direct script access.'); ?>
<script type="text/javascript">
	$(document).ready(function() {
		
		$("a.export-button").click(function(event) {
			
			event.preventDefault();
			//
			// Get all the selected categories
			//
			var category_ids = [];
			$.each($(".fl-categories li a.selected"), function(i, item){
				itemId = item.id.substring("filter_link_cat_".length);
				// Check if category 0, "All categories" has been selected
				category_ids.push(itemId);
			});
			
			if (category_ids.length > 0)
			{
				urlParameters["c"] = category_ids;
			}
			
			
			//
			// Get the incident modes
			//
			var incidentModes = [];
			$.each($(".fl-incident-mode li a.selected"), function(i, item) {
				modeId = item.id.substring("filter_link_mode_".length);
				incidentModes.push(modeId);
			});
			
			if (incidentModes.length > 0) {
				urlParameters["mode"] = incidentModes;
			}

			
			//
			// Get the media type
			//
			var mediaTypes = [];
			$.each($(".fl-media li a.selected"), function(i, item) {
				mediaId = item.id.substring("filter_link_media_".length);
				mediaTypes.push(mediaId);
			});
			
			if (mediaTypes.length > 0) {
				urlParameters["m"] = mediaTypes;
			}

			
			// Get the verification status
			var verificationStatus = [];
			$.each($(".fl-verification li a.selected"), function(i, item) {
				statusVal = item.id.substring("filter_link_verification_".length);
				verificationStatus.push(statusVal);
			});
			if (verificationStatus.length > 0) {
				urlParameters["v"] = verificationStatus;
			}

			
			//
			// Get the Custom Form Fields
			// 
			var customFields = new Array();
			var checkBoxId = null;
			var checkBoxArray = new Array();
			$.each($("input[id^='custom_field_']"), function(i, item) {
				var cffId = item.id.substring("custom_field_".length);
				var value = $(item).val();
				var type = $(item).attr("type");
				if(type == "text")
				{
					if(value != "" && value != undefined && value != null)
					{
						customFields.push([cffId, value]);
					}
				}
				else if(type == "radio")
				{
					if($(item).attr("checked"))
					{
						customFields.push([cffId, value]);
					}
				}
				else if(type == "checkbox")
				{
					if($(item).attr("checked"))
					{
						checkBoxId = cffId;
						checkBoxArray.push(value);
					}
				}
				
				if(type != "checkbox" && checkBoxId != null)
				{
					customFields.push([checkBoxId, checkBoxArray]);
					checkBoxId = null;
					checkBoxArray = new Array();
				}
				
			});
			//incase the last field was a checkbox
			if(checkBoxId != null)
			{
				customFields.push([checkBoxId, checkBoxArray]);				
			}
			
			//now selects
			$.each($("select[id^='custom_field_']"), function(i, item) {
				var cffId = item.id.substring("custom_field_".length);
				var value = $(item).val();
				if(value != "---NOT_SELECTED---") {
					customFields.push([cffId, value]);
				}
			});
			if(customFields.length > 0) {
				urlParameters["cff"] = customFields;
			} else {
				delete urlParameters["cff"];
			}
			<?php
				// Action, allows plugins to add custom filters
				Event::run('ushahidi_action.report_js_filterReportsAction');
			?>
			// Export the reports
			exportReports($(this).attr('exptype'));
			
		});
	});

	function exportReports(exp) {
		// Check if there are any parameters
		if ($.isEmptyObject(urlParameters))
		{
			urlParameters = {show: "all"};
		}
/*		var out = new Array();
		for (key in urlParameters) {
			out.push(key + '=' + urlParameters[key]);
		}
		outparam = out.join('&'); */
		window.location.href = '<?php echo url::site().'index.php/export_reports/index/'?>'+exp+'?'+makeUrlParamStr('', urlParameters);
	}
	

	function makeUrlParamStr(str, params, arrayLevel)	 
	{
		//make sure arrayLevel is initialized
		var arrayLevelStr = "";
		if(arrayLevel != undefined)
		{
			arrayLevelStr = arrayLevel;
		}
		
		var separator = "";
		for(i in params)
		{
			//do we need to insert a separator?
			if(str.length > 0)
			{
				separator = "&";
			}
			
			//get the param
			var param = params[i];
	
			//is it an array or not
			if($.isArray(param))
			{
				if(arrayLevelStr == "")
				{
					str = makeUrlParamStr(str, param, i);
				}
				else
				{
					str = makeUrlParamStr(str, param, arrayLevelStr + "%5B" + i + "%5D");
				}
			}
			else
			{
				if(arrayLevelStr == "")
				{
					str +=  separator + i + "=" + param.toString();
				}
				else
				{
					str +=  separator + arrayLevelStr + "%5B" + i + "%5D=" + param.toString();
				}
			}
		}
		
		return str;
	}
</script>
