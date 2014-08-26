
	<script type="text/javascript">
$(function(){
	$("#newDesignDialog").dialog({
		autoOpen: false,
		height: 450,
		width: 450,
		show: "slide",
		title: "<?php echo Yii::t('translation', 'Create New Surveillance Design')?>",
		hide: "explode",
		buttons: { "<?php echo Yii::t('translation', 'Close')?>": function() {
				$(this).dialog("close");
			}
		}
	});

	slist = $("<?php echo '#surveilanceList'; ?>").dataTable({
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
		//"bServerSide": true,
		//"bDeferRender": true,
		//"sServerMethod": "POST",
		"aaData": <?php echo $dataArray['surveillanceList']; ?>,
		"bAutoWidth" : false,
		"aoColumns": [
			{"mDataProp": "name",  "bVisible": true, sClass: "showDetails clickable underline", "sWidth": "20%"},
			{"mDataProp": "description", "bVisible": true, "sWidth": "40%"},
			{"mDataProp": "goalName", "bVisible": true, "sWidth": "12%"},
			{"mData": "deleteButton", "bSortable": false, "bVisible": true, "sWidth": "8%" },
		],
		// update the buttons stying after the table data is loaded
		"fnDrawCallback": function() {
			$('button.bdelete').button({
				icons: {primary: "ui-icon-trash"}, text: false});
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

	$('.<?php echo "showDetails"; ?>').die('click').live('click', function() {
				var aPos = slist.fnGetPosition(this); /* Get current  row pos */
				//console.log(aPos);
				var aData = slist.fnGetData(aPos[0]); /* Get the full row     */
				//console.log(aData);
				var frameworkId = aData['frameworkId'];
		window.location.href = '<?php echo CController::createUrl("design/showDesign"); ?>' + "?designId=" + frameworkId;
	});
});
function addNewDesign() {
	var data=$("#newDesignForm").serialize();
	$.ajax({
		type: 'POST',
		url: '<?php echo Yii::app()->createAbsoluteUrl("design/index"); ?>',
		data:data,
		success:function(data){
				// reset the form if success
				var checkSuccess = /successfully/i;
				if (checkSuccess.test(data)) {
				// add process message
				$("#msgsNewDesign").html(data).attr('class', 'flash-success');
					$("form#newDesignForm")[0].reset();
					$("#newDesignDialog").dialog("close");
				}

		},
		error: function(data) { // if error occured
		console.log("Error occured.please try again");
		console.log(data);
		},
		dataType:'html'
	});
}
	</script>

<div id="listSurveilance">
	
	<table id="surveilanceList" class="tableStyle"  
		width="100%" border="0" cellspacing="0" cellpadding="0">
		<thead>
		<tr>
			<th title = "Name">Name</th>
			<th title = "Descripton">Descripton</th>
			<th title = "Goal">Goal</th>
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
<div class="form">

<?php $form = $this->beginWidget('CActiveForm', array(
	'id' => 'newDesignForm',
	'enableAjaxValidation' => true,
	'enableClientValidation' => true,
	'clientOptions' => array(
		'validateOnSubmit' => true,
		// make sure that script is not executed if errors on the form
		'afterValidate' => "js:function(form, data, hasError) {
			if(hasError) {
				return false;
				} else {
					addNewDesign();
					return true;
				}
			}"
		//'afterValidate'=>'js:processConfig(this)'
		
	),
	'htmlOptions' => array(
		// disable default submit method
		'onsubmit' => "return false;",
		// add class on the form for the scripts it must be 'configForm'
		//'class' => 'configForm',
	)
));
?>
<?php 
	echo $form->errorSummary(array(
	$model), Yii::app()->params['headerErrorSummary'], Yii::app()->params['footerErrorSummary']); 
?>

	<div class="row">
		<?php echo $form->labelEx($model, 'name'); ?>
		<?php echo $form->textField($model, 'name', array(
			'id' => 'name'
		)); ?>
		<?php echo $form->error($model, 'name', array('inputID' => "name")); ?>
	</div>	
	<div class="row">
		<?php echo $form->labelEx($model, 'description'); ?>
		<?php echo $form->textArea($model, 'description', array(
			'id' => 'description',
			'rows' => 2
		)); ?>
		<?php echo $form->error($model, 'description', array('inputID' => "description")); ?>
	</div>	
	<div class="row">
		<?php echo $form->labelEx($model, 'goalId'); ?>
		<?php echo $form->dropDownList($model, 'goalId', $dataArray['goalDropDown'], array(
			'id' => 'goalId',
			//'empty' => "Choose one",
			'ajax' => array(
				'type'=>'POST', //request type
				'url'=>CController::createUrl('design/fetchComponents'), //url to call.
				'update'=>'#component', //selector to update
			)
			)); ?>
		<?php echo $form->error($model, 'goalId', array('inputID' => "goalId")); ?>
	</div>
	<div class="row">
		<?php echo $form->labelEx($model, 'component'); ?>
		<?php echo $form->dropDownList($model, 'component', array(), array(
			'id' => 'component',
			//'empty' => "Choose one"
			)); ?>
		<?php echo $form->error($model, 'component', array('inputID' => "component")); ?>
	</div>
	<div class="row">
	<?php echo CHtml::Button(Yii::t("translation", "Create"), array(
			'id' => 'load',
			//'onclick' => "addNewDesign();",
			'type' => 'submit'
	)); ?>
	</div>
<?php
	$this->endWidget(); 
?>
</div>
</div>
