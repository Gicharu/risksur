<?php
if ($event->step) {
	echo CHtml::tag('p', array(), 'Surveillance design is now complete ');
	echo CHtml::tag('p', array(), 'You have characterized the surveillance system for this design task as: ');
	$itemsToSkip = [
		'userId' => 'userId',
		'frameworkId' => 'frameworkId'
	];
echo('<table><thead><tr><th></th><th></th></tr></thead><tbody>');
	foreach ($event->data as $step => $data) {
		echo '<tr>';
		echo CHtml::tag('td', array('colspan' => 2), '<b>' . $event->sender->getStepLabel($step) . '</b>');
		echo '</tr>';
		foreach ($data as $field => $fieldData) {
			if(isset($itemsToSkip[$field])) {
				continue;
			}
			echo '<tr>';
			if(is_array($fieldData)) {
				foreach($fieldData as $fieldAttributes) {
					if(isset($fieldAttributes['frameworkFieldId'])) {
						$fieldCriteria = new CDbCriteria();
						$fieldCriteria->condition = 'id=' . $fieldAttributes['frameworkFieldId'];
						$fieldCriteria->select = 'label, inputName, inputType';
						$rsFieldName = FrameworkFields::model()->find($fieldCriteria);
						//print_r($rsFieldName); die;
						$fieldLabel = empty($rsFieldName->label) ?
							FrameworkFields::model()->generateAttributeLabel($rsFieldName->inputName) :
							$rsFieldName->label;
						$value = $fieldAttributes['value'];
						if($rsFieldName->inputType == 'checkboxlist') {
							//$value = '';
							$valueArray = json_decode($fieldAttributes['value']);
							$optionsCriteria = new CDbCriteria();
							$optionsCriteria->select = 'label';
							//$optionsCriteria->addInCondition(Options::model()->getPrimaryKey(),$valueArray);
							//$optionsCriteria->params = [':optIds' => $valueArray];
							//$optionsCriteria->condition = ''
							$rsOptions = Options::model()->findAllByPk($valueArray, $optionsCriteria);
							if(!empty($rsOptions)) {
								$opts = '';
								foreach($rsOptions as $options) {
									$opts .= $options->label . ',';
									//var_dump($opts); //die;

								}
								$value = rtrim($opts, ',');
							}
							//print_r($valueArray); //die;
							//var_dump($value); //die;
						}
						echo '<td><b>' . $fieldLabel . '</b></td>';
						echo '<td>' . $value . '</td>';
						echo '</tr>';

						//print_r($fieldAttributes); die;
						//print_r($fieldAttributes); die;
						//continue;
						//die;

					} else {
						print_r($fieldAttributes);
						die;
					}

				}

			} else {
				echo '<td><b>' . ucfirst($field) . '</b></td>';
				echo '<td>' . $fieldData . '</td>';
				echo '</tr>';

			}
		}
	}
} else {
	echo '<p>The wizard did not start</p>';
}
