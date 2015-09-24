<?php
/**
 * @var $this AttributeController
 * @var $dataArray array
 */
$this->menu = [
	['label' => 'Add Attribute', 'url' => ['attribute/addAttribute']],
	['label' => 'Add Relation', 'url' => ['attribute/addRelation']],
	['label' => 'List Relation', 'url' => ['attribute/listRelations']]
];
?>
<script type="text/javascript">
$(function(){
	$("#bd").attr('style', '');
	$("#attributesList").dataTable({
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
								flash.setFileName( "Attributes_List_" + getTitle() + ".pdf" );
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
						oFlash.setFileName( "Attributes_List_" + getTitle() + ".csv" );
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
		"aaData": <?php echo $dataArray['attributesList']; ?>,
		"aoColumns": [
		{"mData": "attributeTypes.name"  },
		{"mData": "name"},
		{"mData": "description" },
		{"mData": null, "bSortable": false,
			"sDefaultContent": '<button title="Edit" class="bedit">Edit</button>' },
		{"mData": null, "bSortable": false,
			"sDefaultContent": '<button title="Delete" class="bdelete">Delete</button>' }
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
	})
		.on('click', '.bedit', {
			operation: 'edit',
			link: '<?= $this->createUrl("editAttribute"); ?>',
			table: '#attributesList',
			rowIdentifier: 'attributeId'
		}, requestHandler)
		.on('click', '.bdelete', {
			operation: 'delete',
			link: '<?= $this->createUrl("deleteAttribute"); ?>',
			refreshLink: '<?= $this->createUrl("index") . '/ajax/1'; ?>',
			table: '#attributesList',
			rowIdentifier: 'attributeId'
		}, requestHandler)
		.rowGrouping();
});

</script>
<div id="listAttributes">
	
	<table id="attributesList" width="100%" border="0" cellspacing="0" cellpadding="0">
		<thead>
		<tr>
			<th title = "Type">Type</th>
			<th title = "Name">Name</th>
			<th title = "Name">Description</th>
			<th title = "Edit"></th>
			<th title = "Delete"></th>
		</tr>
		</thead>
		<tbody>
		</tbody>
	</table>
</div>
