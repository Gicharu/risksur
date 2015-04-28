<script type="text/javascript">
$(function(){
	slist = $("<?php echo '#surveillanceList'; ?>").dataTable({
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
		{"mDataProp": "description", "bVisible": true},
		{"mDataProp": "editButton", "bSortable": false, sClass: "editContext" },
		{"mData": "deleteButton", "bSortable": false, sClass: "delContext" },
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
	});

	var requestHandler = function(event) {

		var aPos;
		 /* Get current  row pos */
		if(typeof event.data.parent !== 'undefined') {
			aPos = slist.fnGetPosition(event.target);
		} else {
			aPos = slist.fnGetPosition($(event.target).parent()[0]);
		}
//		console.log(aPos);
		var aData = slist.fnGetData(aPos[0]); /* Get the full row     */
		//console.log(aData);
		var frameworkId = aData['frameworkId'];
		var name = aData['name'];
		switch(event.data.action) {
			case "edit":
				window.location.href = '<?php echo $this->createUrl("context/update"); ?>' +
				"/contextId/" + frameworkId;
				break;
			case 'delete':
				deleteConfirm(name, frameworkId);
				break;
			default:
				window.location.href = '<?php echo $this->createUrl("context/view"); ?>' +
				"/contextId/" + frameworkId;
		}

	};
	$('#surveillanceList')
		.on('click','.showDetails', { action: 'view', parent: false }, requestHandler)
		.on('click', '.editContext .bedit', { action: 'edit' }, requestHandler)
		.on('click', '.delContext', { action: 'delete' }, requestHandler);

	var deleteConfirm = function(confirmMsg, deleteVal) {
		$('body #deleteBox').html("<p>Are you sure you want to delete '" + confirmMsg + "' </p>");
		$("body #deleteBox").dialog('option', 'buttons', {
			"Confirm" : function() {
				// console.log(confirmMsg + ":" + deleteVal);
				$(this).dialog("close");
				var opt = {'loadMsg': 'Processing delete context'};
				$("#listSurveilance").showLoading(opt);
				$.ajax({type: 'POST',
					url: <?php echo "'" . $this->createUrl('context/delete') . "'"; ?>,
					data: {delId:deleteVal},
					success: function(data){
						var checkSuccess = /successfully/i;
						if (checkSuccess.test(data)) {
							// add process message
							$("#ajaxFlashMsg").html(data);
							$("#ajaxFlashMsgWrapper").attr('class', 'flash-success').show();
							$("#ajaxFlashMsgWrapper").animate({opacity: 1.0}, 3000).fadeOut("slow");
							// remove the elements of selected context
							$('#designName').hide();
							$('#addComponent').hide();
							$('#showComponents').hide();
						} else{
							// add process message
							$("#ajaxFlashMsg").html(data);
							$("#ajaxFlashMsgWrapper").attr('class', 'flash-error').show();
						}
						slist.fnReloadAjax("index/getContext/1");
						$("#listSurveilance").hideLoading();
					},
					error: function(data){
						$("#ajaxFlashMsg").html("Error occured while deleting data");
						$("#ajaxFlashMsgWrapper").attr('class', 'flash-error').show();
						//console.log("error occured while posting data" + data);
						$("#listSurveilance").hideLoading();
					},
					dataType: "text"
				});
			},
			"Cancel" : function() {
				$(this).dialog("close");
			}
		});
		$("#deleteBox").dialog("open");
	}
});

	</script>

<div id="listSurveilance" width="100%">
	
	<table id="surveillanceList" width="100%" border="0" cellspacing="0" cellpadding="0">
		<thead>
		<tr>
			<th title = "Name">Name</th>
			<th title = "Descripton">Descripton</th>
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
