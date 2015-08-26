<script type="text/javascript">
	var slist;
$(function(){
	slist = $("#surveillanceList").dataTable({
		"sDom": '<"H"rlTf>t<"F"ip>',
		"oTableTools": {
		"sSwfPath": "<?php echo Yii::app()->request->baseUrl; ?>/js/copy_csv_xls_pdf.swf",
			"aButtons": [
				{
					"sExtends": "print",
					"sButtonText": "<?php echo Yii::t('translation', 'Print')?>",
					"sMessage": '<p class="printHeader">Surveillance Context List</p>',
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
						oFlash.setFileName( "Context List_" + getTitle() + ".csv" );
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
		"aaData": <?php echo $dataArray['surveillanceList']; ?>,
		"aoColumns": [
			{"mDataProp": "name",  "bVisible": true, sClass: "showDetails clickable underline"},
			{"mDataProp": "hazardName", "bVisible": true},
			{"mDataProp": "survObj", "bVisible": true},
			{
				"mDataProp": null,
				"bSortable": false,
				"sWidth": '5%',
				sClass: "editMethod",
				sDefaultContent: '<button title="Edit" class="bedit">Edit</button>'
			},
			{
				"mData": null,
				"bSortable": false,
				"sWidth": '5%',
				sClass: "delMethod",
				sDefaultContent: '<button title="Delete" class="bdelete">Delete</button>'
			},
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
		"aLengthMenu": [[10, 25, 50, 75, 100], [10, 25, 50, 75, 100]]
	})
		.on('click', '.editMethod .bedit', {
			operation: 'edit',
			link: '<?= $this->createUrl("update"); ?>',
			table: '#surveillanceList',
			rowIdentifier: 'frameworkId'
		}, requestHandler)
		.on('click', '.bdelete', {
			operation: 'delete',
			link: '<?= $this->createUrl("delete"); ?>',
			refreshLink: '<?= $this->createUrl("list") . '/ajax/1'; ?>',
			table: '#surveillanceList',
			rowIdentifier: 'frameworkId'
		}, requestHandler)
		.on('click', '.showDetails', {
			operation: 'view',
			link: '<?= $this->createUrl("view"); ?>',
			table: '#surveillanceList',
			rowIdentifier: 'frameworkId'
		}, requestHandler);


});

	</script>

<div id="listSurveilance" width="100%">
	
	<table id="surveillanceList" width="100%" border="0" cellspacing="0" cellpadding="0">
		<thead>
		<tr>
			<th title = "Surveillance system name">Surveillance system name</th>
			<th title = "Hazard">Hazard</th>
			<th title = "Surveillance objective">Surveillance objective</th>
			<th title = "Edit">Edit</th>
			<th title = "Delete">Delete</th>
		</tr>
		</thead>
		<tbody>
		</tbody>
	</table>
</div>
<div id="newDesignDialog" style="display:none" >
	<div id="manageDashProcess" class="loading" style="display:none;">
			<p><?php echo Yii::t("translation", "Processing...")?></p>
	</div>
	<div id="msgNewDesign"></div>
</div>
