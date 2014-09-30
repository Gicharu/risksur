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
			{"mData": "deleteButton", "bSortable": false, "bVisible": true },
		],
		// update the buttons stying after the table data is loaded
		"fnDrawCallback": function() {
			$('button.bdelete').button({
				icons: {primary: "ui-icon-trash"}, text: false});
			$('button.bedit').button({
				icons: {primary: "ui-icon-pencil"}, text: false});
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
});
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
		</tr>
		</thead>
		<tbody>
		</tbody>
	</table>
</div>
