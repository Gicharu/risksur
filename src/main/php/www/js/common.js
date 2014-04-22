/*
 * Common jQuery scripts 
 */

jQuery(document).ready(function(){

	// external links
	$(function() {
		$('a[rel*=external]').click( function() {
				window.open(this.href);
				return false;
		});
	});	
	
	// show and hide
	$('.tpanel .toggle').click(function() {
			$(this).next().toggle();
			return false;
	}).next().hide();
	
	// checkbox dynamics
	$('.cpanel :checkbox:not(:checked)').siblings('.cpanelContent').hide();
	$('.cpanel :checkbox').click(function(){
	$('.cpanelContent', $(this).parents('div:first')).css('display', this.checked ? 'block':'none');
});
	// select dynamics
	$('.spanel select option[value="-1"]:not(:selected)').parents('select').siblings('.spanelContent').hide();
	$('.spanel select').change(function(){
		$('.spanelContent', $(this).parents('div:first')).css('display', $(this).val()=='-1' ? 'inline':'none');
	});
	// radio dynamics
	$('.rpanel :radio:not(:checked)').siblings('.rpanelContent').hide();
	$('.rpanel :radio').click(function(){
		$('.rpanelContent', $(this).parents('div:first')).css('display', this.checked ? 'inline':'none');
		$('.rpanel :radio:not(:checked)').siblings('.rpanelContent').hide();
	});
	// help dialog
	$(".openhelp").click(function () { 
		var targetUrl = $(this).attr("href");
		$("#help-dialog").dialog({
			open : function(){
				$("#help-dialog").text("");
				$("#help-dialog").load(targetUrl);
			}
		});
		$("#help-dialog").dialog("open");
		return false;
	});
	// clear form
	$(".clearform").click(function () {
		$(this).parents('form:first').find('.cpanelContent').css('display','none');
		$(this).parents('form:first').find('.rpanelContent').css('display','none');
		$(this).parents('form:first').find(':input').each(function() {
			switch(this.type) {
				case 'password':
				case 'select-multiple':
				case 'select-one':
				case 'text':
				case 'textarea':
				case 'hidden':
					$(this).val('');
				break;
				case 'radio':
					$(this).filter('[value=0]').attr('checked', true);
				break;	
				case 'checkbox':
					this.checked = false;
			}
		});		
	});
	/* Function to validate org mappings */
	validateOrgMappings = function(element, event) {
		var error = false;
		$('.errorMapping').hide();
		for(var i = 1; i <= 5; i++) {
			var errorMessage1 = '<div class="errorMapping errorMessage">Org mapping must not be empty or contain special characters</div>';
				if (typeof $('#txtmapping'+element+'-'+i+'').val() !== 'undefined') {
					if($('#txtmapping'+element+'-'+i+'').hasClass('mappingError')) {
						$('#txtmapping'+element+'-'+i+'').removeClass('mappingError');
					}
					//we allow spaces, letters, norweighian characters, numbers
					if(!$('#txtmapping'+element+'-'+i+'').val().match(/^[a-zA-Z0-9æøåÆØÅ\s]+$/) || $.trim($('#txtmapping'+element+'-'+i+'').val()).length < 1) {
						$(errorMessage1).insertAfter('.mapping-'+i+'').show();
						$('#txtmapping'+element+'-'+i+'').addClass('mappingError');
						error = true;
					}
				}
		}
		if(error) {
			event.preventDefault();
		}
	};
	// validate vocabulary and attributes function
	validateVocabularyList = function(element, event) {
		$('div' ).remove('#vocError' + element);
		for(var i = 1; i <= 5; i++) {
			var vocErrorMsg = '<div id="vocError' + element + '" class="errorMessage"> Vocabulary should not contain spaces</div>';
			var attrErrorMsg = '<div id="vocError' + element + '" class="errorMessage"> Attribute should not contain spaces</div>';
			var elementId = '#vocList' + element + '-' + i;
			var attrId = '#vocAttr' + element + '-' + i;
			$(elementId).removeClass('errorMessage');
			$(attrId).removeClass('errorMessage');

			if (typeof($(elementId).val()) === 'undefined' || typeof($(attrId).val()) === 'undefined') {
				return true;
			}
			
			// we do not allow spaces
			var vocText = $(elementId).val();
			var attrText = $(attrId).val();

			if(vocText.length >= 1) {
				if(!vocText.match(/^[\S]*$/)) {
					$(vocErrorMsg).insertAfter('.vocDiv-' + i).show();
					$(elementId).addClass('errorMessage');
					event.preventDefault();

				}
				
			}
			if(attrText.length >= 1) {
				// console.log(attrText);
				if(!attrText.match(/^[\S]*$/)) {
					$(attrErrorMsg).insertAfter('.vocDiv-' + i).show();
					$(attrId).addClass('errorMessage');
					event.preventDefault();

				}
				
			}
		}
		return true;

	}
});