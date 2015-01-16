<?php
$this->menu = array(array('label' => 'Add Relation', 'url' => array('attribute/addRelation')));
?>
<script type="text/javascript">
$(function(){
	$("#bd").attr('style', '');
	slist = $("<?php echo '#relationsList'; ?>").dataTable({
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
								flash.setFileName( "Object Listing_" + getTitle() + ".pdf" );
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
						oFlash.setFileName( "Object Listing_" + getTitle() + ".csv" );
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
		"aaData": <?php echo $dataArray['relationsList']; ?>,
		"aoColumns": [
		{"mDataProp": "Attribute",  "bVisible": false },
		{"mDataProp": "FormElement",  "bVisible": true },
		//{"mDataProp": "editButton", "bSortable": false },
		{"mData": "deleteButton", "bSortable": false },
		],
		// update the buttons stying after the table data is loaded
		"fnDrawCallback": function(oSettings) {
			$('button.bdelete').button({
				icons: {primary: "ui-icon-trash"}, text: false});
			$('button.bedit').button({
				icons: {primary: "ui-icon-pencil"}, text: false});
				if ( oSettings.aiDisplay.length == 0 ) {
					return;
				}

				var nTrs = $('#relationsList tbody tr');
				var iColspan = nTrs[0].getElementsByTagName('td').length;
				var sLastGroup = "";
				for ( var i=0 ; i<nTrs.length ; i++ ) {
					var iDisplayIndex = oSettings._iDisplayStart + i;
					var sGroup = oSettings.aoData[ oSettings.aiDisplay[iDisplayIndex] ]._aData['Attribute'];
					//console.log(sGroup);
					if ( sGroup != sLastGroup ) {
						var nGroup = document.createElement( 'tr' );
						var nCell = document.createElement( 'td' );
						nCell.colSpan = iColspan;
						nCell.className = "group";
						nCell.innerHTML = sGroup;
						nGroup.appendChild( nCell );
						//console.log(nCell);
						nTrs[i].parentNode.insertBefore( nGroup, nTrs[i] );
						sLastGroup = sGroup;
					}
				}
		},
		"aaSortingFixed": [[ 0, 'asc' ]],
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
});

	deleteConfirm = function(confirmMsg, deleteVal) {
	$('#deleteBox').html("<p>Are you sure you want to delete the relation '" + confirmMsg + "' </p>");
	$("#deleteBox").dialog('option', 'buttons', {
		"Confirm" : function() {
			// console.log(confirmMsg + ":" + deleteVal);
				$(this).dialog("close");
				  var opt = {'loadMsg': 'Processing delete relation'};
				$("#listRelations").showLoading(opt);
				$.ajax({type: 'POST',
					url: <?php echo "'" . CController::createUrl('attribute/deleteRelation') . "'"; ?>,
					data: {delId:deleteVal},
					success: function(data){
						var checkSuccess = /successfully/i;
						if (checkSuccess.test(data)) {
							// add process message
							$("#ajaxFlashMsg").html(data);
							$("#ajaxFlashMsgWrapper").attr('class', 'flash-success').show();
							$("#ajaxFlashMsgWrapper").animate({opacity: 1.0}, 3000).fadeOut("slow");
						} else{
							// add process message
							$("#ajaxFlashMsg").html(data);
							$("#ajaxFlashMsgWrapper").attr('class', 'flash-error').show();
						}
						slist.fnReloadAjax("listRelations/getRelations/1");
						$("#listRelations").hideLoading();
					},
						error: function(data){
							$("#ajaxFlashMsg").html("Error occured while deleting data");
							$("#ajaxFlashMsgWrapper").attr('class', 'flash-error').show();
							//console.log("error occured while posting data" + data);
							$("#listRelations").hideLoading();
						},
							dataType: "text"
				});
		},
			"Cancel" : function() {
				$(this).dialog("close");
			}
	});
}
</script>
<div id="listRelations" width="100%">
	
	<table id="relationsList" width="100%" border="0" cellspacing="0" cellpadding="0">
		<thead>
		<tr>
			<th title = "Attribute">Attribute</th>
			<th title = "subFormId">Form Element</th>
			<!--<th title = "Edit">Edit</th>-->
			<th title = "Delete">Delete</th>
		</tr>
		</thead>
		<tbody>
		</tbody>
	</table>
</div>
