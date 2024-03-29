﻿jQuery(document).ready(function() {  
	jQuery('input[type=checkbox]').ezMark();  
	jQuery('select').styler();    
	
	/*Font Family Preview*/  
	jQuery(".select-fonts").each(function() { 
		var vTextFontSample = jQuery(this).prev(); 		
			vTextFontSample.css({"font-family" : jQuery(this).val()});   
	});  	  
	
	jQuery(".select-fonts").change(function(){ 		
		var vTextFontSample = jQuery(this).prev(); 		
		vTextFontSample.css({"font-family" : jQuery("option:selected",this).val()}); 		
		return false;  
	});      
		
	var vSelectSlider = jQuery(".select-slider");  
	var vSelectSliderVal = vSelectSlider.val();  
	if (vSelectSliderVal == 0) { jQuery('.no-slider-select').show();  } 
	else if  (vSelectSliderVal == 1) {	  jQuery('.flex-slider').show();  } 
	else if  (vSelectSliderVal == 2) {	  jQuery('.nivo-slider').show();  }							  
		
	jQuery(".select-slider").change(function(){ 	
		var vSliderId = jQuery('.select-slider option:selected').val();		
		if (vSliderId == 0) {		
			jQuery('.no-slider-select').show();		
			jQuery('.flex-slider').hide();		
			jQuery('.nivo-slider').hide();	
		} else if  (vSliderId == 1) {		
			jQuery('.flex-slider').show();		
			jQuery('.no-slider-select').hide();		
			jQuery('.nivo-slider').hide();	
		} else if  (vSliderId == 2) {		
			jQuery('.nivo-slider').show();		
			jQuery('.no-slider-select').hide();		
			jQuery('.flex-slider').hide();	
		}	
		return false;  
	});		    
		
	jQuery('#settings-section-0').fadeIn("slow");  
	jQuery('.form-admin-fruitful .content .menu-options ul li').click(function() {  	
		jQuery('.form-admin-fruitful .content .menu-options ul li').removeClass("current");		
		jQuery(this).addClass("current");		
		jQuery(this).css({'border-top':'1px solid #E5E5E5'});		
		jQuery(this).css({'border-bottom':'1px solid #E5E5E5'});		
		jQuery(this).prev().css({'border-bottom':'0'});		
		jQuery(this).next().css({'border-top':'0'});			
		jQuery('.form-admin-fruitful .content .settings-section').hide();	
		var index_a = jQuery(this).find('a').attr("id");		
			index_a = index_a.substr(index_a.indexOf('_') + 1);		
			jQuery('#settings-section-' + index_a).fadeIn("slow");  
	});		
	
	jQuery("#upload_bg_button").click(function() { 
		jQuery("#background_img").click(); 
	});		
	
	jQuery('#colorSelector').ColorPicker({		
		color: jQuery('#background_color').val(),		
		onShow: function (colpkr) {			
			jQuery(colpkr).fadeIn(500);			
			return false;		
		},		
		onHide: function (colpkr) {		
			jQuery(colpkr).fadeOut(500);		
			return false;		
		},		
		onChange: function (hsb, hex, rgb) {			
			jQuery('#colorSelector div').css('backgroundColor', '#' + hex);			
			jQuery('#background_color').val('#' + hex);		
		}	
		});			
	
	jQuery('#menubgcolor').ColorPicker({		
		color: jQuery('#menu_bg_color').val(),		
		onShow: function (colpkr) {			
			jQuery(colpkr).fadeIn(500);			
			return false;		
		},		
		onHide: function (colpkr) {		
			jQuery(colpkr).fadeOut(500);		
			return false;		
		},		
		onChange: function (hsb, hex, rgb) {			
			jQuery('#menubgcolor div').css('backgroundColor', '#' + hex);			
			jQuery('#menu_bg_color').val('#' + hex);		
			}
	});		
	
	jQuery('#menubntcolor').ColorPicker({		
		color: jQuery('#menu_btn_color').val(),		
		onShow: function (colpkr) {			
			jQuery(colpkr).fadeIn(500);			
			return false;		
		},		
		onHide: function (colpkr) {		
			jQuery(colpkr).fadeOut(500);		
			return false;		
		},		
		onChange: function (hsb, hex, rgb) {			
			jQuery('#menubntcolor div').css('backgroundColor', '#' + hex);			
			jQuery('#menu_btn_color').val('#' + hex);		
		}	
		});		
	jQuery('#menuboxshcolor').ColorPicker({		
			color: jQuery('#menu_boxsh_color').val(),		
			onShow: function (colpkr) {			
				jQuery(colpkr).fadeIn(500);			
				return false;		
			},		
			onHide: function (colpkr) {		
				jQuery(colpkr).fadeOut(500);		
				return false;		
			},		
			onChange: function (hsb, hex, rgb) {			
				jQuery('#menuboxshcolor div').css('backgroundColor', '#' + hex);			
				jQuery('#menu_boxsh_color').val('#' + hex);		
			}	
		});			
		
	jQuery('#menufontcolorachvr').ColorPicker({		
		color: jQuery('#menu_hover_color').val(),		
		onShow: function (colpkr) {			
			jQuery(colpkr).fadeIn(500);			
			return false;		
		},		
		onHide: function (colpkr) {		
			jQuery(colpkr).fadeOut(500);		
			return false;		
		},		
		onChange: function (hsb, hex, rgb) {			
			jQuery('#menufontcolorachvr div').css('backgroundColor', '#' + hex);			
			jQuery('#menu_hover_color').val('#' + hex);		
		}	
	});		
	
	jQuery('#menutxtshcolor').ColorPicker({		
		color: jQuery('#menu_txtsh_color').val(),		
		onShow: function (colpkr) {			
			jQuery(colpkr).fadeIn(500);			
			return false;		
		},		
		onHide: function (colpkr) {		
			jQuery(colpkr).fadeOut(500);		
			return false;		
		},		
		onChange: function (hsb, hex, rgb) {			
			jQuery('#menutxtshcolor div').css('backgroundColor', '#' + hex);			
			jQuery('#menu_txtsh_color').val('#' + hex);		
		}	
	});		
	
	jQuery('#menufontcolor').ColorPicker({		
		color: jQuery('#menu_font_color').val(),		
		onShow: function (colpkr) {			
			jQuery(colpkr).fadeIn(500);			
			return false;		
		},		
		onHide: function (colpkr) {		
			jQuery(colpkr).fadeOut(500);		
			return false;		
		},		
		onChange: function (hsb, hex, rgb) {			
			jQuery('#menufontcolor div').css('backgroundColor', '#' + hex);			
			jQuery('#menu_font_color').val('#' + hex);		
		}	
		});		 				
		
	jQuery('#form-admin-fruitful').submit(function() {	       
		var data = jQuery(this).serialize();	       
		jQuery.post(ajaxurl, data, function(response) {				
			var vRes = parseInt(jQuery.trim(response));				   				
			 if(vRes == 1) {	               
				show_message(1);	               
				t = setTimeout('fade_message()', 2000);	            
			 } else {
				show_message(2);	               
				t = setTimeout('fade_message()', 2000);	            
			 }	        
		});	        
	return false;	
	});				
	
	jQuery('#view_all_options').live("click", function() {			
		var vElemSlideOpt = jQuery('#slider_main_options');			
			vElemSlideOpt.fadeIn('slow'); 			
			jQuery(this).remove();		
	});  		
	
	jQuery(".content-close-slide").live("click", function() {			
		var vElem = jQuery(this).parent().next();			 
		if (vElem.css('display') == "none" ) { 
			vElem.fadeIn('slow'); 
		} else { 
			vElem.fadeOut('slow'); 
		}			
	});				
	
	jQuery('input[name="reset"]').live("click", function(){		
		jQuery( "#dialog:ui-dialog").dialog( "destroy" );				
		jQuery( "#dialog-confirm").dialog({ 			
			width:   400,			
			resizable: true,			
			modal: true,			
			position: "center",			
			buttons: {				
				"Reset all saved data?": function() {				
					var data = {										
						action: 	'fruitful_reset_btn',										
						type:   	'reset',										
						data: 		''									
						};														
					jQuery.post(ajaxurl, data, function(response) { });					
					jQuery( this ).dialog( "close" );					  
					setTimeout(function(){	
						location.reload(true);						
					}, 1000);  				
			},				
			Cancel: function() {					
				jQuery( this ).dialog( "close" );				
			}			
		    }			
		});		
	});							
	/*end soratble slide*/		
	
	if (jQuery("ul.slides li").size() >2) { 
		jQuery("ul.slides li .slide-content").hide("slow"); 
	}				
		jQuery(".expand_all").live("click", function()	{ 
			jQuery("ul.slides li .slide-content").show("slow"); 
		});		
		
		jQuery(".collapse_all").live("click", function()	{ 
			jQuery("ul.slides li .slide-content").hide("slow"); 
		});		
		
		jQuery("#save_options").center();		

	jQuery(window).bind('resize', function() { 
		jQuery('#save_options').center(); 
	});

});

function show_message(n) {	
	if(n == 1) { 
		jQuery('.save-options').html('<div class="icon-sc"></div><div class="text">Success data save...</div>').show(); 
	}  else { 
		jQuery('.save-options').html('<div class="icon-al"></div><div class="text">No data saved...</div>').show(); 
	}	
}	     

function fade_message() {	
	jQuery('.save-options').fadeOut(1000);	
	clearTimeout(t);
}			

jQuery.fn.center = function () {    
		var heightRatio = (
			jQuery('#form-admin-fruitful').height() != 0)  ? this.outerHeight() / jQuery('#form-admin-fruitful').height() : 1;    
			var widthRatio 	= (jQuery('#form-admin-fruitful').width() != 0)   ? this.outerWidth() / jQuery('#form-admin-fruitful').width() : 1;    
			this.css({
				position: 'fixed',        
				margin: 0,        
				top:  (50*(1-heightRatio))  + "%",        
				left: (50*(1-widthRatio))  + "%"    });    
			return this;
	}