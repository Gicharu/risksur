<?php

/**
 * ContextController
 *
 * @package
 * @author    James Njoroge <james@tracetracker.com>
 * @copyright Tracetracker
 * @version   $id$
 * @uses      Controller
 * @license   Tracetracker {@link http://www.tracetracker.com}
 */
class ContextController extends Controller {
	const LOG_CAT = 'ctrl.ContextController';
	// use 2 column layout
	public $layout = '//layouts/column2';

	/**
	 * actionIndex
	 *
	 * @access public
	 * @return void
	 */
	public function actionIndex() {
		Yii::log("actionIndex ContextController called", "trace", self::LOG_CAT);
		$dataArray = array();
		$dataArray['dtHeader'] = "Surveillance design List";
		$dataArray['surveillanceList'] = json_encode(array());
		//$this->performAjaxValidation($model);

		// get list of surveillance designs
		$surveillanceList = FrameworkContext::model()->findAll(array(
			//'select' => 'pageId, pageName',
			'condition' => 'userId=:userId',
			'params' => array(
				':userId' => Yii::app()->user->id,
			),
		));
		$surveillanceListArray = array();
		// format datatable data
		foreach ($surveillanceList as $sur) {
			$deleteButton = "";
			//if (Yii::app()->user->name != $valu['userName']) {
			$editButton = "<button id='editComponent" . $sur->frameworkId .
				"' type='button' class='bedit' onclick=\"window.location.href ='" .
				$this->createUrl('context/edit/', array(
						'contextId' => $sur->frameworkId
					)
				) .
				"'\">Edit</button>";
			$deleteButton = "<button id='deleteContext" . $sur->frameworkId .
				"' type='button' class='bdelete' onclick=\"$('#deleteBox').dialog('open');" .
				"deleteConfirm('" . $sur->name . "', '" .
				$sur->frameworkId . "')\">Remove</button>";
			//}
			$surveillanceListArray[] = array(
				'frameworkId' => $sur->frameworkId,
				'name' => $sur->name,
				'userId' => $sur->userId,
				'description' => $sur->description,
				'editButton' => $editButton,
				'deleteButton' => $deleteButton
			);
		}
		$dataArray['surveillanceList'] = json_encode($surveillanceListArray);

		if (!empty($_GET['getContext'])) {
			$jsonData = json_encode(array("aaData" => $surveillanceListArray));
			echo $jsonData;
			return;
		}
	}


	/**
	 * actionlist
	 *
	 * @access public
	 * @return void
	 */
	public function actionlist() {
		Yii::log("actionContextList ContextController called", "trace", self::LOG_CAT);
		$model = new FrameworkContext();
		$dataArray = array();
		$dataArray['dtHeader'] = "Surveillance design List";
		$dataArray['surveillanceList'] = json_encode(array());
		$this->performAjaxValidation($model);

		if (isset($_POST['FrameworkContext'])) {
			$model->attributes = $_POST['FrameworkContext'];
			$model->userId = Yii::app()->user->id;
			//$model->tool = $model->tool == '' ? null : $model->tool;
			//$model->path = $model->tool === null ? $model->path : "tools/index";

			//$model->setAttribute('menuOrder', $mnuResult->lastMenu + 1);
			if ($model->validate()) {
				$model->save();
				//Yii::app()->user->setFlash('success', "Page created successfully");
				echo "saved successfully";
				//$this->redirect( array( 'index' ) );
				return;
			} else {
				echo CActiveForm::validate($model);
				Yii::app()->end();
			}
		}

		// get list of surveillance designs
		$surveillanceList = FrameworkContext::model()->findAll(array(
			//'select' => 'pageId, pageName',
			'condition' => 'userId=:userId',
			'params' => array(
				':userId' => Yii::app()->user->id,
			),
		));
		$surveillanceListArray = array();
		// format datatable data
		foreach ($surveillanceList as $sur) {
			//if (Yii::app()->user->name != $valu['userName']) {
			$editButton = '<button type="button" class="bedit">Edit</button>';
			$deleteButton = '<button type="button" class="bdelete">Remove</button>';
			//}
			$surveillanceListArray[] = array(
				'frameworkId' => $sur->frameworkId,
				'name' => $sur->name,
				'userId' => $sur->userId,
				'description' => $sur->description,
				'editButton' => $editButton,
				'deleteButton' => $deleteButton
			);
		}
		$dataArray['surveillanceList'] = json_encode($surveillanceListArray);

		if (!empty($_GET['getDesigns'])) {
			$jsonData = json_encode(array("aaData" => $surveillanceListArray));
			echo $jsonData;
			return;
		}

		$this->render('list', array(
			'model' => $model,
			'dataArray' => $dataArray
		));
	}

	/**
	 * actionView
	 *
	 * @access public
	 * @return void
	 */
	public function actionView() {
		Yii::log("actionView ContextController called", "trace", self::LOG_CAT);
		$model = new FrameworkContext();
		$dataArray = array();
		if (isset($_GET['contextId'])) {
			$selectedDesign = FrameworkContext::model()->findAll(array(
				//'select' => 'pageId, pageName',
				'condition' => 'frameworkId=:frameworkId AND userId=:userId',
				'params' => array(
					':frameworkId' => $_GET['contextId'],
					':userId' => Yii::app()->user->id,
				),
			));
			$dataArray['selectedDesign'] = $selectedDesign;
			//add the surveillance context to the session
			if (count($selectedDesign) == 1) {
				Yii::app()->session->add('surDesign', array(
					'id' => $_GET['contextId'],
					'name' => $selectedDesign[0]->name
				));
			} else {
				Yii::app()->session->remove('surDesign');
			}

		}

		$this->render('view', array(
			'model' => $model,
			'dataArray' => $dataArray
		));
	}

	/**
	 * actionCreate
	 *
	 * @access public
	 * @return void
	 */
//		public function actionCreate() {
//			Yii::log("actionCreate ContextController called", "trace", self::LOG_CAT);
//			$context = new FrameworkContext();
//			$dForm = new DynamicFormDetails('create', 'frameworkFields');
//			$dynamicLabels = array();
//
//			$elements = self::getDefaultElements(false);
//			$elements['elements']['context']['elements'] = self::getElements($context, array('name', 'description'));
//
//			$elements['buttons'] = self::getButtons(array(
//				'name' => 'createContext',
//				'label' => 'Create'
//			));
//			$errorArray = array(
//				'showErrors' => true,
//				'showErrorSummary' => true,
//				'errorSummaryHeader' => Yii::app()->params['headerErrorSummary'],
//				'errorSummaryFooter' => Yii::app()->params['footerErrorSummary'],
//			);
//
//			$elements['elements']['context']['type'] = 'form';
//			$elements['elements']['contextFields']['type'] = 'form';
//			$elements['elements']['context'] = array_merge($elements['elements']['context'], $errorArray);
//			$elements['elements']['contextFields'] = array_merge($elements['elements']['contextFields'], $errorArray);
//			$contextFields = $dForm->findAll();
//			$dynamicDataAttributes = array();
//			foreach ($contextFields as $field) {
//				$dynamicDataAttributes[$field->inputName . '-' . $field->id] = $field->inputName;
//				$dynamicLabels[$field->inputName . '-' . $field->id] = isset($field->label) ? $field->label : $dForm->generateAttributeLabel($field->inputName);
//				$elements['elements']['contextFields']['elements'][$field->inputName . '-' . $field->id] = array(
//					'label' => isset($field->label) ? $field->label : $dForm->generateAttributeLabel($field->inputName),
//					'required' => $field->required,
//					'type' => $field->inputType
//				);
//				if ($field->inputType == 'dropdownlist') {
//					$elements['elements']['contextFields']['elements'][$field->inputName . '-' . $field->id]['items'] =
//						Options::model()->getContextFieldOptions($field->id);
//				}
//				//$modelData[$field->inputName . '-' . $field->id] = $field->value;
//			}
////			print_r($elements); die;
//			$dForm->_dynamicFields = $dynamicDataAttributes;
//			$dForm->_dynamicLabels = $dynamicLabels;
//			$form = new CForm($elements);
//			$form['context']->model = $context;
//			$form['contextFields']->model = $dForm;
//			if ($form->submitted('createContext')) {
//				$form->loadData();
//				$frameworkFieldDataModel = new FrameworkFieldData();
//				$context->userId = Yii::app()->user->id;
//				if ($context->save(false)) {
//					$frameworkFieldData = array();
//					foreach ($_POST['DynamicFormDetails'] as $inputName => $inputVal) {
//						$inputNameArray = explode('-', $inputName);
//						$frameworkFieldData[] = array(
//							'id' => null,
//							'frameworkId' => $context->primaryKey,
//							'frameworkFieldId' => $inputNameArray[1],
//							'value' => $inputVal
//						);
//					}
//					$command = FrameworkFieldData::model()
//						->getDbConnection()
//						->getSchema()
//						->getCommandBuilder()
//						->createMultipleInsertCommand($frameworkFieldDataModel->tableName(), $frameworkFieldData);
//					if ($command->execute()) {
//						Yii::app()->user->setFlash('success', 'Surveillance context updated successfully');
//					}
//					$this->redirect('list');
//					return;
//
//				}
//
//				Yii::app()->user->setFlash('error', 'A problem occurred while creating the surveillance context, ' .
//					'please try again or contact the administrator if this persists');
//
//			}
//			$this->render('create', array('form' => $form));
//
//		}

	/**
	 * @return array
	 */
	public function behaviors() {

		return array(
			'wizard' => array(
				'class' => 'application.extensions.WizardBehavior.WizardBehavior',
				'steps' => self::getSteps(),
				'events' => array(
					'onProcessStep' => 'processSurveillance',
					'onStart' => 'wizardStart',
					'onFinished'=>'wizardFinished',
					'onInvalidStep'=>'wizardInvalidStep',
					'onSaveDraft'=>'wizardSaveDraft'

				)
			)
		);
	}

	/**
	 * @return array
	 */
	private function getSteps() {
		$steps = array();
		$stepsArray = SurveillanceSections::model()
			->findAll();
		foreach($stepsArray as $step) {
			$steps[$step->sectionId] = $step->sectionName;
		}
		return $steps;
	}
	public function processSurveillance($event) {
		$fieldsCriteria = new CDbCriteria();
		$fieldsCriteria->condition = 'sectionId=' . $event->sender->getCurrentStep();
		$fieldsCriteria->order = '`order` ASC, `parentId` ASC';
		$surveillanceFieldsModel = FrameworkFields::model()->findAll($fieldsCriteria);
		$dForm = new DForm('insert');
//		print_r($_POST);
//		die;

		$elements = self::getDefaultElements();
		if($event->sender->getCurrentStep() === 1) {
			$surveillanceModel = new FrameworkContext();
			$surveillanceModel->userId = Yii::app()->user->id;
			$elements['elements']['context']['elements'] = self::getElements($surveillanceModel, array('name', 'description'));

		}

		$elements['buttons'] = self::getButtons(array(
			'name' => 'next',
			'label' => 'Next'
		));
		$errorArray = array(
			'showErrors' => true,
			'showErrorSummary' => true,
			'errorSummaryHeader' => Yii::app()->params['headerErrorSummary'],
			'errorSummaryFooter' => Yii::app()->params['footerErrorSummary'],
		);

		$elements['elements']['context']['type'] = 'form';
		//$elements['elements']['contextFields']['elements'] = self::getDefaultElements();
		$elements['elements']['contextFields']['type'] = 'form';
//		$elements['elements']['context'] = array_merge($elements['elements']['context'], $errorArray);
//		$elements['elements']['contextFields'] = array_merge($elements['elements']['contextFields'], $errorArray);
		//$contextFields = $dForm->findAll();
		$dynamicDataRules = array();
		$childCounter = 0;
		$childCount = 0;
		$parentFieldId = 0;
		//print_r($elements); die;
		$gridFieldIds = [];
		foreach ($surveillanceFieldsModel as $field) {
			//if(!is_null($parentFieldId) &&
			if($field->inputType == 'label') {
				if($field->childCount > 0) {
					$childCount = $field->childCount;
					$parentFieldId = $field->id;
					$childCounter++;
					$elements['elements']['contextFields']['elements'][] = '<fieldset><legend>' .
						$field->label . '</legend>';
				} else {
					$elements['elements']['contextFields']['elements'][] = CHtml::label($field->label, false);

				}
				continue;
			}
			if($field->inputType == 'grid') {
				$elements['elements']['contextFields']['elements'][] = '<div class="row">';
				$elements['elements']['contextFields']['elements'][] = "<fieldset><legend> $field->label </legend>";
				$elements['elements']['contextFields']['elements'][] = self::generateGridElements($field->id, $dForm);
				$elements['elements']['contextFields']['elements'][] = '</fieldset>';
				$elements['elements']['contextFields']['elements'][] = '</div>';
				$gridFieldIds[] = $field->id;
			}
			if($field->gridField) {
				continue;
			}
			$attributeName = $field->inputName . '_' . $field->id;
			$dForm->setPropertyName($attributeName); //$field->inputName;
//			$dForm->$attributeName = ''; //$field->inputName;
			$validation = $field->required ? 'required' : 'safe';
			$dynamicDataRules[] = [$attributeName, $validation];
			$dForm->setAttributeLabels([$attributeName => isset($field->label) ? $field->label :
				$dForm->generateAttributeLabel($field->inputName)]);
			$elements['elements']['contextFields']['elements'][$attributeName] = array(
				'label'    => isset($field->label) ? $field->label : $dForm->generateAttributeLabel($field->inputName),
				'required' => $field->required,
				'type'     => $field->inputType,
				'hint' => $field->description
			);
			if ($field->inputType == 'dropdownlist') {
				$elements['elements']['contextFields']['elements'][$attributeName]['items'] =
					Options::model()->getContextFieldOptions($field->id);
			}
			if ($field->inputType == 'checkboxlist') {
				$elements['elements']['contextFields']['elements'][$attributeName]['items'] =
					Options::model()->getContextFieldOptions($field->id);
				$elements['elements']['contextFields']['elements'][$attributeName]['class'] =
					'checkboxlist';
				$elements['elements']['contextFields']['elements'][] = '<div class="clear"></div>';
			}
			if(isset($field->parentId) && $field->parentId == $parentFieldId) {
				if ($childCount != $childCounter) {
					//echo $childCounter . '======>' . $childCount . '<br>';
					$childCounter++;
				} else {
					$elements['elements']['contextFields']['elements'][] = '</fieldset>';
				}
			}
		}
		//var_dump($elements['elements']['contextFields']);

		//$dForm->setPropertyNames($dynamicDataAttributes);
		//$dForm->setAttributeLabels($dynamicLabels);
		$dForm->setRules($dynamicDataRules);
//		print_r($elements); die;
//		var_dump($dForm->getAttributes());
//		die;
		$form = new CForm($elements);
		if($event->sender->getCurrentStep() == 1) {
			$form['context']->model = $surveillanceModel;
		}
		$form['contextFields']->model = $dForm;
		$fieldData = [];
		//$form->loadData();
		if ($form->submitted('next')) {
			if(isset($_POST['DForm'][0])) {
				//print_r($dForm->attributes); die;
				// This can be refactored later
				foreach($_POST['DForm'] as $row => $rowData ) {
						//print_r($rowData);
					foreach($rowData as $attrName => $attrVal) {
						if(!empty($attrVal)) {
							if(is_array($attrVal)) {
								$attrVal = json_encode($attrVal);
							}
							$fieldNameAndId = explode('_', $attrName);
							$fieldData[$row][$attrName]['frameworkFieldId'] = $fieldNameAndId[1];
							$fieldData[$row][$attrName]['value'] = $attrVal;

						}
					}
					//print_r($fieldData); die;
				}
			} else {
				if($form->validate()) {

					//print_r($dForm->attributes); die;
					foreach($dForm->attributes as $attrName => $attrVal) {
						if(!empty($attrVal)) {
							$fieldNameAndId = explode('_', $attrName);
							$fieldData[$fieldNameAndId[0]]['frameworkFieldId'] = $fieldNameAndId[1];
							$val = $attrVal;
							if(is_array($attrVal)) {
								$val = json_encode($attrVal);
							}
							$fieldData[$fieldNameAndId[0]]['value'] = $val;
						}
					}

				}
			}
			//$dForm->fieldId =
			//$dataToSave = array($dForm->getAttributes());
			$dataToSave = [$fieldData];
			if($event->sender->getCurrentStep() == 1) {
				$event->sender->save($surveillanceModel->getAttributes(), 'surveillanceModel');

			}
			//print_r($dForm); die;
			$event->sender->save($dataToSave);
			//print_r($_SESSION['Wizard.steps']); die;
			$event->handled = true;
			return true;
		} else {
			//print_r($gridFieldIds); die;
			$sectionCriteria = new CDbCriteria();
			$sectionCriteria->select = 'description';
			$sectionCriteria->condition = 'sectionId=' . $event->sender->getCurrentStep();
			$sectionInfo = SurveillanceSections::model()->find($sectionCriteria);
			//print_r($sectionInfo->description); die();
//			$this->render($event->step, compact('form'));
			$this->render('create', compact('form', 'event', 'sectionInfo', 'gridFieldIds'));

		}

	}

	public function wizardStart($event) {
		$event->handled = true;
	}

	/**
	 * Raised when the wizard detects an invalid step
	 * @param WizardEvent The event
	 */
	public function wizardInvalidStep($event) {
		Yii::app()->getUser()->setFlash('notice', $event->step.' is not a vaild step in this wizard');
	}
	public function wizardFinished($event) {
		$surveillanceDataModel = new FrameworkFieldData();
		$frameWorkModel = new FrameworkContext();
		$frameWorkData = $event->getData();
		$frameWorkModel->attributes = $frameWorkData['surveillanceModel'];
		$transaction = Yii::app()->db->beginTransaction();
		try {
			if ($frameWorkModel->save()) {
				//if(true) {
				//print_r($frameWorkData); die;
				unset($frameWorkData['surveillanceModel']);
				//die;
				foreach ($frameWorkData as $step => $formData) {
					//print_r($formData);
					//echo "_______________________________$step";
					foreach ($formData as $fieldData) {
						foreach($fieldData as $fieldName => $data) {
							//print_r($data);
							if (isset($data['value'])) {
								$surveillanceDataModel->setIsNewRecord(true);
								$surveillanceDataModel->attributes = $data;
								$surveillanceDataModel->frameworkId = $frameWorkModel->frameworkId;
								$surveillanceDataModel->id = null;
								//var_dump($surveillanceDataModel); die;
								$surveillanceDataModel->save();
							} else {
								foreach($data as $field) {

									if(isset($field['value'])) {
										//print_r($field); die;
										$surveillanceDataModel->setIsNewRecord(true);
										$surveillanceDataModel->attributes = $field;
										$surveillanceDataModel->frameworkId = $frameWorkModel->frameworkId;
										$surveillanceDataModel->id = null;
										$surveillanceDataModel->save();

									}
								}
							}
							//die;
						}


					}

				}
				//var_dump($surveillanceDataModel); die;
				$transaction->commit();
			}
		} catch (Exception $e) {
			$transaction->rollBack();
			Yii::log($e->getMessage() . 'error when saving a surveillance system error code [' . $e->getCode() . ']',
				'error', self::LOG_CAT);
			$event->sender->reset();
			Yii::app()->end();
			Yii::app()->user->setFlash('error', 'There was a problem saving the surveillance system, please try ' .
				'again or contact your administrator is the problem persists');
			$this->redirect('create');

		}
		//die('hapa');

		$this->render('finished', compact('event'));
		$event->sender->reset();
		Yii::app()->end();
	}

	public function actionCreate($step=null) {
		$this->process($step);
	}

	public function generateOverviewTable($event) {

		echo '<table id="survTable"><thead><tr><th></th><th></th></tr></thead><tbody>';
		//print_r($event->data); die;
		echo '<tr>';
		echo '<td>Name</td>';
		echo '<td>' .  $event->data['surveillanceModel']['name'] . '</td>';
		echo '<tr>';
		echo '<tr>';
		echo '<td>Description</td>';
		echo '<td>' .  $event->data['surveillanceModel']['description'] . '</td>';
		echo '</tr>';
		$surveillanceCriteria = new CDbCriteria();
		$surveillanceCriteria->order = 'frameworkFields.sectionId ASC, frameworkFields.order ASC';
		$rsSurveillance = SurveillanceSections::model()->with('survData', 'frameworkFields')->findAll($surveillanceCriteria);
		//print_r($rsSurveillance); die;
		foreach ($rsSurveillance as $surveillanceData) {
			echo '<tr>';
			echo CHtml::tag('td', array('colspan' => 2), '<b>' . $surveillanceData->sectionName . '</b>');
			echo '</tr>';
			foreach ($surveillanceData->frameworkFields as $field) {
				if($field->inputType == 'label' || $field->inputType == 'grid') {
					echo '<tr>';
					echo CHtml::tag('td', array('colspan' => 2), '<b>' . $field->label . '</b>');
					echo '</tr>';
					continue;
				}
				echo '<tr>';
				echo '<td>';
				echo isset($field->label) ?
					$field->label : FrameworkFields::model()->generateAttributeLabel($field->inputName);
				echo '</td>';
				foreach($surveillanceData->survData as $data) {
					$dataValue = '';
					if(isset($data->frameworkFieldId) && $data->frameworkFieldId == $field->id) {
						$dataValue = $data->value;

						if($field->inputType == 'checkboxlist' || $field->inputType == 'dropdownlist') {
							$opts = '';
							$optionsRs = Options::model()->findAllByPk(json_decode($data->value), '', ['select' => 'label']);
							foreach($optionsRs as $optionValue) {
								$opts .= $optionValue->label . ', ';
							}
							$dataValue = rtrim($opts, ", ");
							//print_r($dataValue); die;
						}
						echo '<td>';
						echo $dataValue;
						echo '</td>';
					}

				}

			}
			echo '</tr>';
		}
		echo '</table>';
		//die;
	}

	/**
	 * @param $string
	 * @return bool
	 */
	public static function isJson($string) {
		json_decode($string);
		return (json_last_error() == JSON_ERROR_NONE);
	}

	/**
	 * actionUpdate
	 *
	 * @access public
	 * @return void
	 */
	public function actionUpdate() {
		Yii::log("actionUpdate ContextController called", "trace", self::LOG_CAT);
		//$model = new FrameworkContext();
		$dForm = new DynamicForm('update');
		$dynamicLabels = array();

		//print_r($_POST); die;
//			$dataArray = array();
//			$dataArray['formType'] = "Edit";
		if (isset($_GET['contextId'])) {
			//fetch the form data
			$model = FrameworkContext::model()->findByPk($_GET['contextId']);
			//print_r($model); die;
			if (!$model->frameworkId) {
				Yii::app()->user->setFlash('error', Yii::t("translation", "The selected system does not exist"));
				$this->redirect(array('context/list'));
				return;
			}
		} else {
			Yii::app()->user->setFlash('error', Yii::t("translation", "Please select a surveillance system before you attempt to update it"));
			$this->redirect(array('context/list'));
		}

		$frameworkFieldData = FrameworkFieldData::model()->findAll('frameworkId=' . $_GET['contextId']);
		$frameworkFieldDataModel = new FrameworkFieldData();
		$contextFields = $frameworkFieldDataModel->findAll();
		$elements = self::getDefaultElements();
		$elements['elements']['context']['elements'] = self::getElements($model, array('name', 'description'));
		//$contextForm = new CForm($modelElements, $model);
		$modelData = array();
		$dynamicDataAttributes = array();
		$elements['elements']['context']['type'] = 'form';
		$elements['elements']['contextFields']['type'] = 'form';
		$fieldDataMap = array();
		foreach ($contextFields as $field) {
			$dynamicDataAttributes[$field->inputName . '-' . $field->id] = 1;
			$dynamicLabels[$field->inputName . '-' . $field->id] = isset($field->label) ? $field->label : $dForm->generateAttributeLabel($field->inputName);
			$elements['elements']['contextFields']['elements'][$field->inputName . '-' . $field->id] = array(
				'label' => isset($field->label) ? $field->label : $dForm->generateAttributeLabel($field->inputName),
				'required' => $field->required,
				'type' => $field->inputType
			);
			if ($field->inputType == 'dropdownlist') {
				$elements['elements']['contextFields']['elements'][$field->inputName . '-' . $field->id]['items'] =
					Options::model()->getContextFieldOptions($field->id);
			}
			foreach ($frameworkFieldData as $fieldValue) {
				if ($fieldValue->frameworkFieldId == $field->id) {

					$modelData[$field->inputName . '-' . $field->id] = $fieldValue->value;
					$fieldDataMap[$field->id] = $fieldValue->id;

				}
				//print_r($fieldValue); die;
			}
		}
		$elements['buttons'] = array(
			'updateContext' => array(
				'type' => 'submit',
				'label' => 'Update Context',
			),
			'cancel' => array(
				'type' => 'button',
				'label' => 'Cancel',
				'onclick' => "window.location='" . $this->createUrl('list') . "'"
			)
		);
		//$model = new DynamicForm();
		$dForm->_dynamicFields = $dynamicDataAttributes;
		$dForm->_dynamicLabels = $dynamicLabels;
		$dForm->attributes = $modelData;
		$form = new CForm($elements);
		$form['context']->model = $model;
		$form['contextFields']->model = $dForm;

		//var_dump($form->validate()); die('here');
		if ($form->submitted('updateContext')) {
			$context = $form['context']->model;
			$context->userId = Yii::app()->user->id;
			$error = false;
			//print_r($_POST['DynamicFormDetails']); die;
			if ($context->save()) {
				foreach ($_POST['DynamicFormDetails'] as $inputName => $inputVal) {
					$inputNameArray = explode('-', $inputName);
					$fieldId = null;
					if (!empty($fieldDataMap[$inputNameArray[1]])) {
						$fieldId = $fieldDataMap[$inputNameArray[1]];
						$attributes = array(
							'id' => $fieldId,
							'frameworkId' => $context->primaryKey,
							'frameworkFieldId' => $inputNameArray[1],
							'value' => $inputVal
						);
						$frameworkFieldDataModel->updateByPk($fieldId, $attributes);

					} else {
						$operation = 'save';
						$attributes = array(
							'id' => $fieldId,
							'frameworkId' => $context->primaryKey,
							'frameworkFieldId' => $inputNameArray[1],
							'value' => $inputVal
						);
						$frameworkFieldDataModel->attributes = $attributes;
						$frameworkFieldDataModel->setIsNewRecord(true);
						$frameworkFieldDataModel->save();

					}
					//print_r($dataModel); die;
					//var_dump($newRecord, $fieldId, $fieldDataMap, $inputNameArray, $frameworkFieldDataModel); die;
//						if (!$frameworkFieldDataModel->$operation()) {
//							Yii::app()->user->setFlash('error', 'A problem occurred while updating the surveillance context, ' .
//								'please try again or contact the administrator if this persists');
//							$error = true;
//							break;
//						}
				}

				if (!$error) {
					Yii::app()->user->setFlash('success', 'Surveillance context updated successfully');
					$this->redirect(array('context/list'));
					return;
				}
				//$frameworkFieldDataModel->setIsNewRecord(true);
				//$frameworkFieldDataModel->setAttributes($frameworkFieldData);


			}
			Yii::app()->user->setFlash('error', 'A problem occurred while updating the surveillance context, ' .
				'please try again or contact the administrator if this persists');

		}

		$this->render('update', array(
			'form' => $form
		));
	}


	/**
	 * actionDelete
	 *
	 * @access public
	 * @return void
	 */
	public function actionDelete() {
		Yii::log("actionDelete ContextController called", "trace", self::LOG_CAT);
		if (isset($_POST["delId"])) {
			$record = FrameworkContext::model()->findByPk($_POST['delId']);
			if (!$record->delete()) {
				Yii::log("Error deleting context: " . $_POST['delId'], "warning", self::LOG_CAT);
				//echo $errorMessage;
				echo Yii::t("translation", "A problem occurred when deleting the system ") . $_POST['delId'];
			} else {
				// remove the default selected design from session
				unset($_SESSION['surDesign']);
				echo Yii::t("translation", "The system ") . Yii::t("translation", " has been successfully deleted");
			}
		}
	}

	/**
	 * @param CActiveRecord $model
	 * @param array $attributes
	 * @return array
	 */
	public static function getElements($model, $attributes = array()) {
		$modelAttributes = $model->getAttributes();
		$modelElements = array();
		foreach ($modelAttributes as $attrName => $attrVal) {

			if (!empty($attributes)) {
				foreach ($attributes as $attr) {
					if ($attrName === $attr) {
						$modelElements[$attr] = array(
							'label' => $model->getAttributeLabel($attr),
							'required' => $model->isAttributeRequired($attr),
							'type' => 'text'
						);


					}

				}
				continue;
			}

			$modelElements[$attrName] = array(
				'label' => $model->getAttributeLabel($attrName),
				'required' => $model->isAttributeRequired($attrName),
				'type' => 'text'
			);

//			if ($field->inputType == 'dropdownlist') {
//				$elements['elements']['contextFields']['elements'][$field->inputName . '-' . $field->id]['items'] =
//					Options::model()->getContextFieldOptions($field->id);
//			}

		}
		return $modelElements;
	}

	/**
	 * getDefaultElements
	 *
	 * @param mixed $errorDisplay
	 * @static
	 * @access public
	 * @return array
	 */
	public static function getDefaultElements($errorDisplay = true) {
		$errorParams = array(
			'showErrorSummary' => true,
			'showErrors' => true,
			'errorSummaryHeader' => Yii::app()->params['headerErrorSummary'],
			'errorSummaryFooter' => Yii::app()->params['footerErrorSummary'],
		);
		$defaultParams = array(
			'activeForm' => array(
				'id' => 'DForm',
				'class' => 'CActiveForm',
				'enableClientValidation' => true,
				'clientOptions' => array(
					'validateOnSubmit' => true,
				)
			)
		);
		return $errorDisplay ? array_merge($errorParams, $defaultParams) : $defaultParams;
	}

	/**
	 * getButtons
	 *
	 * @param array $buttonName
	 * @param string $url
	 * @static
	 * @access public
	 * @return array
	 */
	public static function getButtons($buttonName = array("name" => "save", "label" => "Save"), $url = 'context/list') {
		return array(
			$buttonName['name'] => array(
				'type' => 'submit',
				'label' => $buttonName['label'],
			),
			'cancel' => array(
				'type' => 'button',
				'label' => 'Cancel',
				'onclick' => "window.location='" . Yii::app()->createUrl($url) . "'"
			)
		);
	}

	/**
	 * performAjaxValidation
	 *
	 * @param mixed $model
	 * @access protected
	 * @return void
	 */
	protected function performAjaxValidation($model) {
		if (isset($_POST['ajax']) && $_POST['ajax'] === 'newDesignForm') {
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}
	}

	/**
	 * @param $fieldId
	 * @param $dForm
	 * @return string
	 */
	private function generateGridElements($fieldId, &$dForm) {
		//$model = new DynamicFormDetails('insert', 'frameworkFieldData');
		// get grid fields
		$gridFieldsCriteria  = new CDbCriteria();
		$gridFieldsCriteria->condition = 'parentId=' . $fieldId;
		$gridFieldsCriteria->order = '`order` ASC';
		$gridFields = FrameworkFields::model()->findAll($gridFieldsCriteria);
		//print_r($gridFields); //die;
		$inputs = '<tr class="copy' . $fieldId . '">';
		$labels = [];
		$properties = [];
		$rules = [];
		//for ($i = 0; $i < $multipleRowsToShow; $i++) {
		foreach($gridFields as $field) {
			//$el = new CFormInputElement()
			$attribute = $field->inputName . '_' . $field->id;
			$dForm->setpropertyName($attribute);
			//$model->setAttribute($attribute, $field->inputName);
//			$dForm->_dynamicLabels[$attribute] = isset($field->label) ?
//				$field->label : $dForm->generateAttributeLabel($field->inputName);
			$labels[$attribute] = isset($field->label) ?
				$field->label : $dForm->generateAttributeLabel($field->inputName);
			$validation = $field->required ? 'required' : 'safe';
			$rules[] = [$attribute, $validation];
			$i = 0;
			$inputs .= '<td>';
			switch($field->inputType) {
				case 'text':
					$inputs .= CHtml::activeTextField($dForm, "[$i]$attribute");
					$inputs .= CHtml::error($dForm, "[$i]$attribute");
					break;
				case 'dropdownlist':
					$options = [];
					if($field->multiple) {
						$options['multiple'] = true;
					}
					$inputs .= CHtml::activeDropDownList($dForm, "[$i]$attribute",
						Options::model()->getContextFieldOptions($field->id), $options);
					$inputs .= CHtml::error($dForm, "[$i]$attribute");
					break;
			}
			$inputs .= '</td>';

			//$elements['elements'][] = '</td>';

		}
		$dForm->setRules($rules);
		$dForm->setAttributeLabels($labels);
		//print_r(array_values($labels));
		$inputs .= '<td></td></tr>';
		$tableHeader = '<th>' . implode('</th><th>', array_values($labels));
		$table = '<table class="jgTabular"><thead><tr>' . $tableHeader . '<th></th></tr></thead>';
		$table .= '<tbody>' . $inputs . '</tbody>';
		$table .= '</table>';
		$table .= CHtml::htmlButton('<span class="ui-icon ui-icon-plusthick"></span>Add new row', [
			'id' => 'copyLink-' . $fieldId,
			'rel' => '.copy' . $fieldId
		]);
		return $table;



	}

}
