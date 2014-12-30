<script type="text/javascript">
$(function(){
	$("#attributeSelect").chosen();
});
</script>
<h3>Select Active Attribute</h3>
	<div class="row">
	<?php
		$selectedAttribute = "";
	if (!empty(Yii::app()->session['performanceAttribute']) && !empty(Yii::app()->session['performanceAttribute']['id'])) {
		$selectedAttribute = Yii::app()->session['performanceAttribute']['id'];
	}
	?>
		<?php echo CHtml::label('Select Attribute', 'attributeSelect'); ?>
		<?php echo CHtml::dropDownList('attributeSelect', $selectedAttribute, $dataArray['attributeList'], array(
			'id' => 'attributeSelect',
			'data-placeholder' => 'Select an Attribute',
			'empty' => "",
			//'onChange' => 'alert("post me")'
			'ajax' => array(
				'url' => CController::createUrl('attribute/selectAttribute'),
				'type' => 'POST',
				'data' =>  array (
					'attributeSelected' => 'js:$(this).val()',
				),
				'success' => 'function(data){
					// redirect the form if success
					var checkSuccess = /successfully/i;
					if (checkSuccess.test(data)) {
					// redirect to design/index
						window.location.href = "'. CController::createUrl("design/index") . '"
					}
				}'

				//'update' => '#divID',
			),
			//'ajax' => array(
				//'type' => 'POST', //request type
				//'url' => CController::createUrl('design/fetchComponents'), //url to call.
				////'update' => '#component', //selector to update
			//)
			)); ?>
	</div>
