<h3>Create Components for <?php echo Yii::app()->session['surDesign']['name'];?></h3>
<?php
	echo $formHeader->renderBegin();
	//echo $form->errorSummary();
	$headerTd = "";
	$cols = count($formHeader->getElements()) + 1;
	foreach ($formHeader->getElements() as $element) {
		$headerTd .= "<td>" . CHtml::label($element->label, false) . "</td>";
	}

$headerTd .= "<td width='3%'>" . CHtml::htmlButton(Yii::t('translation', 'Copy First Row'), array(
		'onClick' =><<<END
js:var rowIndex = 0; 
var data = $(".tabular-input-container tr").eq(rowIndex).find("input[type=text],textarea,select").serializeArray(); 
$(".tabular-input-container tr").each(function (a) {
	if (a != rowIndex) { 
		$(this).find("input[type=text],textarea,select").each(function(i, element) {
			// don't copy the component name, first element
			if(i != 0) {
				// set the value to the first row element value
				$(this).val(data[i]['value']);
			}
		});
	}
});
END
,
		'title' =>'Copy First Row',
		'type' => 'button',
		'id' => 'copyRow'
	)
) . "</td>";


?>
<script type="text/javascript">
$(function() {
	$("#copyRow").button({
		icons: {
			primary: "ui-icon-copy"
		},
		text:false
	});
});
</script>
<div class="form">
	<?php $this->widget('ext.widgets.tabularinput.XTabularInput', array(
		'models' => $modelArray,
		'form' => $form,
		'elements' => $elements,
		'containerTagName' => 'table',
		'headerTagName' => 'thead',
		'header' =>'
			<tr>' . $headerTd . '
			</tr>
		',
		'inputContainerTagName' => 'tbody',
		'inputTagName' => 'tr',
		'inputView' => '_tabularInputAsTable',
		'inputUrl' => $this->createUrl('design/addMultipleComponents'),
		'addTemplate' => '<tbody><tr><td colspan="' . $cols .'">{link}</td></tr></tbody>',
		'addLabel' => Yii::t('ui','Add new row'),
		'addHtmlOptions' => array('class' => 'addNewButton'),
		'removeTemplate' => '<td>{link}</td>',
		'removeLabel' => Yii::t('ui','&nbsp&nbsp'),
		'removeHtmlOptions' => array('class' => 'trashIcon')
	));	?>
</div>
<?php
	echo $formHeader->renderButtons();
	echo $formHeader->renderEnd();
?>
