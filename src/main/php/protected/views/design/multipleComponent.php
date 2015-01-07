<?php
	echo $formHeader->renderBegin();
	//echo $form->errorSummary();
	$headerTd = "";
	$cols = count($formHeader->getElements()) + 1;
	foreach ($formHeader->getElements() as $element) {
		$headerTd .= "<td>" . CHtml::label($element->label, false) . "</td>";
	}
?>
<div class="form">
	<?php $this->widget('ext.widgets.tabularinput.XTabularInput', array(
		'models' => $modelArray,
		'form' => $form,
		'elements' => $elements,
		'containerTagName' => 'table',
		'headerTagName' => 'thead',
		'header' =>'
			<tr>' . $headerTd . '
				<td></td>
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

