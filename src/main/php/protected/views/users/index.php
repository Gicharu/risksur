<?php
$this->breadcrumbs = array(
	'Users',
);
$this->menu = array(
	array('label' => 'Add User', 'url' => array('createUser')),
);
?>
<h1>Users</h1>
<script type="text/javascript">
$(function(){
	$("#bd").attr('style', '');
	slist = $("<?php echo '#usersList'; ?>").dataTable({
		"sDom": '<"H"rlTf>t<"F"ip>',
		"oTableTools": {
		"sSwfPath": "<?php echo Yii::app()->request->baseUrl; ?>/js/copy_csv_xls_pdf.swf",
			"aButtons": [
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
		"aaData": <?php echo $dataArray['usersList']; ?>,
		"aoColumns": [
		{"mData": "username"},
		{"mData": "email"},
		{"mData": "editButton", "bSortable": false },
		{"mData": "deleteButton", "bSortable": false },
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
});

	deleteConfirm = function(confirmMsg, deleteVal) {
	$('#deleteBox').html("<p>Are you sure you want to delete '" + confirmMsg + "' </p>");
	$("#deleteBox").dialog('option', 'buttons', {
		"Confirm" : function() {
			// console.log(confirmMsg + ":" + deleteVal);
				$(this).dialog("close");
				  var opt = {'loadMsg': 'Processing delete option'};
				$("#listOptions").showLoading(opt);
				$.ajax({type: 'POST',
					url: <?php echo "'" . CController::createUrl('users/deleteUser') . "'"; ?>,
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
						slist.fnReloadAjax("index/getUsers/1");
						$("#listOptions").hideLoading();
					},
						error: function(data){
							$("#ajaxFlashMsg").html("Error occured while deleting data");
							$("#ajaxFlashMsgWrapper").attr('class', 'flash-error').show();
							$("#listOptions").hideLoading();
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
<div id="listOptions" width="100%">
	<table id="usersList" width="100%" border="0" cellspacing="0" cellpadding="0">
		<thead>
		<tr>
			<th title = "Name">Username</th>
			<th title = "Name">Email</th>
			<th title = "Edit">Edit</th>
			<th title = "Delete">Delete</th>
		</tr>
		</thead>
		<tbody>
		</tbody>
	</table>
</div>
