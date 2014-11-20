	<script type="text/javascript">
$(function(){
	clist = $("<?php echo '#componentList'; ?>").dataTable({
		"sDom": '<"H"rlTf>t<"F"ip>',
		"oTableTools": {
		"sSwfPath": "<?php echo Yii::app()->request->baseUrl; ?>/js/copy_csv_xls_pdf.swf",
			"aButtons": [
				//"print",
				{
					"sExtends": "print",
					"sButtonText": "<?php echo Yii::t('translation', 'Print')?>",
					"sMessage": '<p class="printHeader"><?php echo $dataArray["dtHeader"]; ?></p>',
					"bShowAll": false
				},
				{
					
					"sExtends": "collection",
					"sButtonText": "<?php echo Yii::t('translation', 'Save')?>",
					"aButtons" : [ {
						"sExtends": "pdf",
						oSelectorOpts: {
							page: 'current'
						},
						"sButtonText": "PDF",
						"fnClick":  function( nButton, oConfig, flash ) {
								flash.setFileName( "Component Listing_" + getTitle() + ".pdf" );
								this.fnSetText( flash,
									"title:"+ this.fnGetTitle(oConfig) +"\n"+
									"message:"+ oConfig.sPdfMessage +"\n"+
									"colWidth:"+ this.fnCalcColRatios(oConfig) +"\n"+
									"orientation:"+ oConfig.sPdfOrientation +"\n"+
									"size:"+ oConfig.sPdfSize +"\n"+
									"--/TableToolsOpts--\n" +
									this.fnGetTableData(oConfig)
								);
								}
					},
					{
						"sExtends": "csv",
						"sButtonText": "Excel (CSV)",
						"sCharSet": "utf16le",
						oSelectorOpts: {
							page: 'current'
						},
						"fnClick": function ( nButton, oConfig, oFlash ) {
						oFlash.setFileName( "Component Listing_" + getTitle() + ".csv" );
							this.fnSetText( oFlash,	"" + this.fnGetTableData(oConfig)
							);
						},
					}
					],
					"bShowAll": false
				}
			]
		},
		"bProcessing": true,
		"bStateSave": false,
		//"bServerSide": true,
		//"bDeferRender": true,
		//"sServerMethod": "POST",
		"aaData": <?php echo $dataArray['componentList']; ?>,
			//"bAutoWidth" : true,
		"aoColumns": [
			//{"mDataProp": "name",  "bVisible": true, sClass: "showDetails clickable underline", "sWidth": "20%"},
			//{"mDataProp": "description", "bVisible": true, "sWidth": "40%"},
			//{"mDataProp": "description", "bVisible": true, "sWidth": "6%"},
			//{"mDataProp": "editButton", "bVisible": true, "sWidth": "6%"},
			//{"mData": "deleteButton", "bSortable": false, "bVisible": true, "sWidth": "8%" },
			{"mDataProp": "name",  "bVisible": true, sClass: "showDetails clickable underline"},
			{"mDataProp": "description", "bVisible": true},
			{"mDataProp": "description", "bVisible": true},
			{"mDataProp": "editButton", "bVisible": true},
			{"mDataProp": "deleteButton", "bSortable": false, "bVisible": true },
			{"mDataProp": "duplicateButton", "bSortable": false, "bVisible": true },
		],
		// update the buttons stying after the table data is loaded
		"fnDrawCallback": function() {
			$('button.bdelete').button({
				icons: {primary: "ui-icon-trash"}, text: false});
			$('button.bedit').button({
				icons: {primary: "ui-icon-pencil"}, text: false});
			$('button.bcopy').button({
				icons: {primary: "ui-icon-copy"}, text: false});
		},
		"bJQueryUI": true,
		//"sPaginationType": "customListbox",
		"sPaginationType": "buttons_input",
		"iDisplayLength": 10,
		"aLengthMenu": [[10, 25, 50, 75, 100], [10, 25, 50, 75, 100]],
		"bFilter": true,
		"bSort": true,
		"bInfo": true,
		"bLengthChange": true
	});
	// click event to show component details
	$('.<?php echo "showDetails"; ?>').die('click').live('click', function() {
				var aPos = clist.fnGetPosition(this); /* Get current  row pos */
				//console.log(aPos);
				var aData = clist.fnGetData(aPos[0]); /* Get the full row     */
				//console.log(aData);
				var componentId = aData['componentId'];
		window.location.href = '<?php echo CController::createUrl("design/showComponent"); ?>' + "?compId=" + componentId;
	});

	$("#copyBox").dialog({
		autoOpen: false,
		//bgiframe: true,
		resizable: false,
		overlay: {
			backgroundColor: '#000',
			opacity: 0.5
		},
		height: 300,
		width: 350,
		modal: true,
		buttons: {
			"Duplicate Component": duplicateComponent,
			Cancel: function() {
				$(this).dialog("close");
				updateTips("");
			}
		},
		close: function() {
			$('#copyBoxForm')[ 0 ].reset();
			updateTips("");
			//allFields.removeClass( "ui-state-error" );
		}
	});

	$("#copyBoxForm").on("submit", function(event) {
		event.preventDefault();
		duplicateComponent();
	});
});

	function updateTips( t ) {
		if (t != "") {
			$(".validateTips")
			.text( t )
			.addClass( "ui-state-highlight" );
			setTimeout(function() {
				$(".validateTips").removeClass( "ui-state-highlight", 1500 );
			}, 500 );
			$('#newComponentName').addClass("ui-state-error");
		} else {
			$(".validateTips").text( t );
			$('#newComponentName').removeClass("ui-state-error");
		}
	}
	// process the duplicate function
	duplicateComponent = function() {
		if ( $('#newComponentName').val().length > 0) {
			var oldCompId = $('#componentId').val();
			var newCompName = $('#newComponentName').val();
			updateTips("");
			$("#copyBox").dialog("close");
			var opt = {'loadMsg': 'Processing duplicate component'};
			$("#listComponent").showLoading(opt);
			$.ajax({type: 'POST',
				url: <?php echo "'" . CController::createUrl('design/duplicateComponent') . "'"; ?>,
				data: {oldComponentId:oldCompId,newComponentName:newCompName},
				success: function(data){
					var checkSuccess = /successfully/i;
					if (checkSuccess.test(data)) {
						// add process message
						$("#ajaxFlashMsg").html(data);
						$("#ajaxFlashMsgWrapper").attr('class', 'flash-success').show();
					} else{
						// add process message
						$("#ajaxFlashMsg").html(data);
						$("#ajaxFlashMsgWrapper").attr('class', 'flash-error').show();
					}
					clist.fnReloadAjax("listComponents/getComponents/1");
					$("#listComponent").hideLoading();
				},
					error: function(data){
						$("#ajaxFlashMsg").html("Error occured while deleting data");
						$("#ajaxFlashMsgWrapper").attr('class', 'flash-error').show();
						//console.log("error occured while posting data" + data);
						$("#listComponent").hideLoading();
					},
						dataType: "text"
			});
		} else {
			updateTips("The value of new component name cannot be empty.");
		}
	}

	deleteConfirm = function(confirmMsg, deleteVal) {
	$('#deleteBox').html("<p>Are you sure you want to delete '" + confirmMsg + "' </p>");
	$("#deleteBox").dialog('option', 'buttons', {
		"Confirm" : function() {
			//console.log(actionVal + ":" + confirmMsg + ":" + deleteVal + ":" + msgDivId + ":" + widId);
				$(this).dialog("close");
				  var opt = {'loadMsg': 'Processing delete user'};
				$("#listComponent").showLoading(opt);
				$.ajax({type: 'POST',
					url: <?php echo "'" . CController::createUrl('design/deleteComponent') . "'"; ?>,
					data: {delId:deleteVal},
					success: function(data){
						var checkSuccess = /successfully/i;
						if (checkSuccess.test(data)) {
							// add process message
							$("#ajaxFlashMsg").html(data);
							$("#ajaxFlashMsgWrapper").attr('class', 'flash-success').show();
						} else{
							// add process message
							$("#ajaxFlashMsg").html(data);
							$("#ajaxFlashMsgWrapper").attr('class', 'flash-error').show();
						}
						clist.fnReloadAjax("listComponents/getComponents/1");
						$("#listComponent").hideLoading();
					},
						error: function(data){
							$("#ajaxFlashMsg").html("Error occured while deleting data");
							$("#ajaxFlashMsgWrapper").attr('class', 'flash-error').show();
							//console.log("error occured while posting data" + data);
							$("#listComponent").hideLoading();
						},
							dataType: "text"
				});
		},
			"Cancel" : function() {
				$(this).dialog("close");
			}
	});
}

	function duplicatePopup(oldComponentId, oldComponentName){
		$('#headerCopyBox').html("<p><?php echo Yii::t('translation', 'Please provide a new component name for copy of ')?> '" + oldComponentName + "' </p>");
		$('#componentId').val(oldComponentId);
	}
	</script>
<div id="listComponent" width="100%">
	<table id="componentList" width="100%" border="0" cellspacing="0" cellpadding="0">
		<thead>
		<tr>
			<th title = "Name">Name</th>
			<th title = "Descripton">Descripton</th>
			<th title = "Details">Details</th>
			<th title = "Edit">Edit</th>
			<th title = "Delete">Delete</th>
			<th title = "Duplicate">Duplicate</th>
		</tr>
		</thead>
		<tbody>
		</tbody>
	</table>
</div>

<div id="copyBox" title="Duplicate Component">
	<span id="headerCopyBox">Duplicate component</span>
	<p class="validateTips" style="font-size:11px;color:red"></p>

	<form id="copyBoxForm" width="100%">
		<label for="name">New component Name</label>
		<input type="text" name="newComponentName" id="newComponentName" value="" class="text ui-widget-content ui-corner-all" placeholder="New Name"/>
		<input type="hidden" name="componentId" id="componentId" value="" class="text ui-widget-content ui-corner-all"/>
		<!-- Allow form submission with keyboard without duplicating the dialog button -->
		<!--<input type="submit" tabindex="-1" style="position:absolute; top:-1000px">-->
	</form>
</div> 
