<?php
//print_r($columnsArray); die;
?>
<script type="text/javascript">
$(function(){
	clist = $('#componentList').dataTable({
		"sDom": '<"H"rlTf>t<"F"ip>',
		"oTableTools": {
		"sSwfPath": "<?php echo Yii::app()->request->baseUrl; ?>/js/copy_csv_xls_pdf.swf",
			"aButtons": [
				//"print",
//				{
//					"sExtends": "print",
//					"sButtonText": "<?php //echo Yii::t('translation', 'Print')?>//",
//					"sMessage": '<p class="printHeader"><?php //echo $dataArray["dtHeader"]; ?>//</p>',
//					"bShowAll": false
//
//				},
				{
					
					"sExtends": "collection",
					"sButtonText": "<?php echo Yii::t('translation', 'Save')?>",
					"aButtons" : [ {
						"sExtends": "pdf",
						oSelectorOpts: {
							page: 'current'
						},
						"mColumns": 'visible',
						"sButtonText": "PDF",
						"fnClick":  function( nButton, oConfig, flash ) {
							flash.setFileName( "Component Listing_" + getTitle() + ".pdf" );
							var compTable = $(this.dom.table).dataTable();
							var compSettings = compTable.fnSettings();
							var	compTableCols = compSettings.aoColumns.length;
							compSettings.aoColumns[(compTableCols - 1)].bVisible = false;
							compSettings.aoColumns[(compTableCols - 2)].bVisible = false;
							//console.log(compSettings.aoColumns[5].bVisible, oConfig);
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
						"mColumns": "visible",
						"fnClick": function ( nButton, oConfig, oFlash ) {
						oFlash.setFileName( "Component Listing_" + getTitle() + ".csv" );
							var compTable = $(this.dom.table).dataTable();
							var compSettings = compTable.fnSettings();
							var	compTableCols = compSettings.aoColumns.length;
							compSettings.aoColumns[(compTableCols - 1)].bVisible = false;
							compSettings.aoColumns[(compTableCols - 2)].bVisible = false;
							this.fnSetText( oFlash,	"" + this.fnGetTableData(oConfig)
							);
						}
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

			{"mDataProp": "name", sClass: "showDetails clickable underline"},
			<?php 
				foreach ($columnsArray as $key => $val) {
					echo '{"mDataProp": "' . $key . '"},';
				}
			?>
//			{
//				"mDataProp": null,
//				"bSortable": false,
//				"sWidth": '5%',
//				"sDefaultContent": '<button class="bcopy">Duplicate</button>'
//			},
			{
				"mDataProp": null,
				"bSortable": false,
				"sWidth": '5%',
				"sDefaultContent": '<button class="bedit">Edit</button>'
			},
			{
				"mDataProp": null,
				"bSortable": false,
				"sWidth": '5%',
				"sDefaultContent": '<button class="bdelete">Delete</button>'
			}
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
		"sPaginationType": "buttons_input"
		//"iDisplayLength": 10,

	})
		.on('click', '.bcopy', function() {
			console.log('open');
			$('#copyBox').dialog('open');
		})
		.on('click', '.bdelete', {
			operation: 'delete',
			link: '<?= $this->createUrl("deleteComponent"); ?>',
			refreshLink: '<?= $this->createUrl("listComponents") . '/getComponents/1'; ?>',
			table: '#componentList',
			rowIdentifier: 'componentId'
		}, requestHandler)
		.on('click', '.bedit', {
			operation: 'edit',
			link: '<?= $this->createUrl("editComponent"); ?>',
			table: '#componentList',
			rowIdentifier: 'componentId'
		}, requestHandler);
	// click event to show component details
	$('.showDetails').on('click', function() {
		var aPos = clist.fnGetPosiion(this); /* Get current  row pos */
		//console.log(aPos);
		var aData = clist.fnGetData(aPos[0]); /* Get the full row     */
		//console.log(aData);
		var componentId = aData['componentId'];
		window.location.href = '<?= $this->createUrl("showComponent"); ?>' + "/compId/" + componentId;
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
			var oldCompId = $('#surSystem').val();

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
	};

	function duplicatePopup(oldComponentId, oldComponentName){
		$('#headerCopyBox').html("<p><?php echo Yii::t('translation', 'Please provide a new component name for copy of ')?> '" + oldComponentName + "' </p>");
		$('#componentId').val(oldComponentId);
	}
	</script>
<div id="listComponent">
	<?= CHtml::link('Edit multiple components', 'editMultipleComponents', ['class' => 'btn']); ?>
	<table id="componentList" width="100%" border="0" cellspacing="0" cellpadding="0">
		<thead>
		<tr>
			<th title = "Name">Name</th>
			<?php 
				foreach ($columnsArray as $val) {
					echo '<th title = "' . $val . '">' . $val . '</th>';
				}
			?>
<!--			<th title = "Duplicate">Duplicate</th>-->
			<th title = "Edit">Edit</th>
			<th title = "Delete">Delete</th>
		</tr>
		</thead>
		<tbody>
		</tbody>
	</table>
</div>

<div id="copyBox" title="Duplicate Component">
	<span id="headerCopyBox">Duplicate component</span>
	<p class="validateTips" style="font-size:11px;color:red"></p>
	<form id="copyBoxForm">
		<div class="row">

			<label for="surSystem">Surveillance system</label>
			<?= CHtml::dropDownList('surSystem', '', $surveillanceSystems); ?>
		</div>
		<div class="row">

			<label for="newCompoentName">New component Name</label>
			<?= CHtml::textField('newComponentName', '', [
				'id' => 'newComponentName',
				'class' => 'text ui-widget-content ui-corner-all',
				'placeholder' => 'New name'

			]);
			?>
		</div>

		<input type="hidden" name="componentId" id="componentId" value="" class="text ui-widget-content ui-corner-all"/>
		<!-- Allow form submission with keyboard without duplicating the dialog button -->
		<!--<input type="submit" tabindex="-1" style="position:absolute; top:-1000px">-->
	</form>
</div> 
