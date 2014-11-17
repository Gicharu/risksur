<?php
    /* @var $this SurFormDetailsController */
    $this->menu = array(
        array('label' => 'Add Form Elements', 'url' => array('create')),
        //array('label'=>'Manage SurFormDetails', 'url'=>array('admin')),
    );
?>
<script type="text/javascript">
	var surFormDet;
	$(function () {
		$("#bd").attr('style', '');
		surFormDet = $("#surFormDetails").dataTable({
			"sDom": '<"H"rlTf>t<"F"ip>',
			"oTableTools": {
				"sSwfPath": "<?php echo Yii::app()->request->baseUrl; ?>/js/copy_csv_xls_pdf.swf",
				"aButtons": [
					{
						"sExtends": "print",
						"sButtonText": "<?php echo Yii::t('translation', 'Print')?>",
						"sMessage": '<p class="printHeader"> Surveilance Forms Details</p>',
						"bShowAll": false
					},
					{

						"sExtends": "collection",
						"sButtonText": "<?php echo Yii::t('translation', 'Save')?>",
						"aButtons": [{
							"sExtends": "pdf",
							oSelectorOpts: {
								page: 'current'
							},
							"sButtonText": "PDF",
							"fnClick": function (nButton, oConfig, flash) {
								flash.setFileName("Surveilance Forms Details_" + getTitle() + ".pdf");
								this.fnSetText(flash,
									"title:" + this.fnGetTitle(oConfig) + "\n" +
									"message:" + oConfig.sPdfMessage + "\n" +
									"colWidth:" + this.fnCalcColRatios(oConfig) + "\n" +
									"orientation:" + oConfig.sPdfOrientation + "\n" +
									"size:" + oConfig.sPdfSize + "\n" +
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
								"fnClick": function (nButton, oConfig, oFlash) {
									oFlash.setFileName("Surveilance Forms Details_" + getTitle() + ".csv");
									this.fnSetText(oFlash, "" + this.fnGetTableData(oConfig)
									);
								}
							}
						],
						"bShowAll": false
					}
				]
			},
			"bProcessing": true,
			"aaData": <?php echo json_encode($surFormsArray); ?>,
			"aoColumns": [
				{
					"mData": null, "sDefaultContent": '<button type="button" class="bedit">Edit</button>', "bSortable": false,
					"fnCreatedCell": function (nTd, sData, oData) {
						$(nTd).children().attr("onClick", "window.location='<?php echo $this->createUrl('surFormDetails/update/id'); ?>/" + oData.subFormId + "';");
					}, "sWidth": "5%"
				},
				{
					"mData": null, "sDefaultContent": '<button type="button" class="bdelete">Delete</button>', "bSortable": false,
					"fnCreatedCell": function (nTd, sData, oData) {
						$(nTd).children().attr("onClick", "deleteConfirm(" + oData.subFormId + ");");
					}, "sWidth": "5%"
				},
				{"mData": "formName", "sWidth": "8%"},
				{"mData": "inputName"},
				{"mData": "label"},
				{"mData": "inputType", "sWidth": "9%"},
				{
					"mData": "required", "fnCreatedCell": function (nTd, sData) {
					var req = "Yes";
					if (sData != "1") {
						req = "No";
					}
					$(nTd).html(req);

				}, "sWidth": "9%"
				}
			],
//            update the buttons stying after the table data is loaded
			"fnDrawCallback": function () {
				$('button.bdelete').button({
					icons: {primary: "ui-icon-trash"}, text: false
				});
				$('button.bedit').button({
					icons: {primary: "ui-icon-pencil"}, text: false
				});
			},
			"bJQueryUI": true,
			//"sPaginationType": "customListbox",
			"sPaginationType": "buttons_input",
			"iDisplayLength": 10,
			"aLengthMenu": [[10, 25, 50, 75, 100], [10, 25, 50, 75, 100]]
		});
	});
	deleteConfirm = function (sFormId) {
		//alert("here");
		$('#deleteBox').html("<p>Are you sure you want to delete this form element? </p>");
		$("#deleteBox").dialog({
			buttons: {
				Confirm: function () {
					// console.log(confirmMsg + ":" + deleteVal);
					$(this).dialog("close");
					var opt = {'loadMsg': 'Deleting form element...'};
					$("#surFormDetailsBlock").showLoading(opt);
					$.ajax({
						type: 'POST',
						url: '<?php echo $this->createUrl("surFormDetails/delete") ?>',
						data: {
							delId: sFormId
						},
						success: function (data) {
							var checkSuccess = /successfully/i;
							$("#ajaxFlashMsg").html(data);
							if (checkSuccess.test(data)) {
								// add process message
								$("#ajaxFlashMsgWrapper").attr('class', 'flash-success').show();

							} else {
								// add process message
								$("#ajaxFlashMsgWrapper").attr('class', 'flash-error').show();
							}
							surFormDet.fnReloadAjax("<?php echo $this->createUrl('surFormDetails/index', array('ajax' => true)); ?>");
							$("#surFormDetailsBlock").hideLoading();
						},
						error: function (data) {
							$("#ajaxFlashMsg").html("Error occurred while deleting data");
							$("#ajaxFlashMsgWrapper").attr('class', 'flash-error').show();
							//console.log("error occured while posting data" + data);
							$("#surFormDetailsBlock").hideLoading();
						},
						dataType: "json"
					});
				},
				Cancel: function () {
					$(this).dialog("close");
				}
			}
		});
	}
</script>
<div id="surFormDetailsBlock">

	<table id="surFormDetails" border="0" cellspacing="0" cellpadding="0" width="96%" class="display">
		<thead>
		<tr>
			<th title="Edit"></th>
			<th title="Delete"></th>
			<th title="Status">Status</th>
			<th title="Input Name">Input Name</th>
			<th title="Label">Label</th>
			<th title="Input Type">Input Type</th>
			<th title="Required">Required</th>
		</tr>
		</thead>
		<tbody>
		</tbody>
	</table>
</div>
<div id="deleteBox" title="Delete Confirmation"></div>