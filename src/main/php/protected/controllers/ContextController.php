<?php

/**
 * ContextController
 *
 * @package
 * @author    James Njoroge <james@tracetracker.com>
 * @copyright Tracetracker
 * @version   $id$
 * @uses      RiskController
 * @license   Tracetracker {@link http://www.tracetracker.com}
 */
class ContextController extends RiskController {
	const LOG_CAT = 'ctrl.ContextController';
	// use 2 column layout
	public $layout = '//layouts/column2';
	public $surveillanceId;
	public $docName = 'survIndex';


	/**
	 * @param $action CAction
	 * @return bool
	 */
	public function beforeAction($action) {
		$this->setPageTitle('Surveillance - ' . $action->getId());
		return true;

	}

	/**
	 * actionIntro
	 */
	public function actionIntro() {
		Yii::log("actionIntro ContextController called", "trace", self::LOG_CAT);
		$this->docName = 'survIntro';
		if(isset($_POST['pageId'])) {
			$this->savePage('intro');
		}
		$page = $this->getPageContent();
		if(empty($page)) {
			throw new CHttpException(404, 'The page requested does not exist');
		}
		$this->render('intro', [
				'content' => $page['content'],
				'editAccess' => $page['editAccess'],
				'editMode' => $page['editMode']
			]
		);

	}

	/**
	 * actionIndex
	 */
	public function actionIndex() {
		//$this->setPageTitle($this->id . 'Introduction');
		Yii::log("actionIndex ContextController called", "trace", self::LOG_CAT);
		$this->docName = 'survIndex';
		if(isset($_POST['pageId'])) {
			$this->savePage('index');
		}
		$page = $this->getPageContent();
		if(empty($page)) {
			throw new CHttpException(404, 'The page requested does not exist');
		}
		$this->render('index', [
				'content' => $page['content'],
				'editAccess' => $page['editAccess'],
				'editMode' => $page['editMode']
			]
		);
	}

	/**
	 * @return array
	 */
	private function getPageContent() {
		Yii::log("Function getPageContent ContextController called", "trace", self::LOG_CAT);
		$content = DocPages::model()->find("docName='$this->docName'");
		if(empty($content)) {
			return [];
		}
		$editAccess = false;
		if(Yii::app()->rbac->checkAccess('context', 'savePage')) {
			$editAccess = true;
		}
		$editMode = false;
		if(isset($_POST['page']) && DocPages::model()->count('docId=' . $_POST['page']) > 0) {
			$editMode = true;
		}
		return [
			'content' => $content,
			'editAccess' => $editAccess,
			'editMode' => $editMode
		];
	}

	/**
	 * @param $action
	 */
	private function savePage($action) {
		//var_dump($_POST); die;
		Yii::log("Function SavePage ContextController called", "trace", self::LOG_CAT);
		$model = DocPages::model()->findByPk($_POST['pageId']);
		if (isset($_POST['survContent'])) {
			$purifier = new CHtmlPurifier();
			$model->docData = $purifier->purify($_POST['survContent']);
			if($model->update()) {
				Yii::app()->user->setFlash('success', 'The page was updated successfully');
				$this->redirect($action);
				return;
			}
		}

		Yii::app()->user->setFlash('error', 'The page was not updated successfully, contact your administrator');
		$this->redirect($action);
		return;
	}

//	public function actionIndex() {
//		Yii::log("actionIndex ContextController called", "trace", self::LOG_CAT);
//		$dataArray = array();
//		$dataArray['dtHeader'] = "Surveillance design List";
//		$dataArray['surveillanceList'] = json_encode(array());
//		//$this->performAjaxValidation($model);
//
//		// get list of surveillance designs
//		$surveillanceList = FrameworkContext::model()->findAll(array(
//			//'select' => 'pageId, pageName',
//			'condition' => 'userId=:userId',
//			'params' => array(
//				':userId' => Yii::app()->user->id,
//			),
//		));
//		$surveillanceListArray = array();
//		// format datatable data
//		foreach ($surveillanceList as $sur) {
//			$deleteButton = "";
//			//if (Yii::app()->user->name != $valu['userName']) {
//			$editButton = "<button id='editComponent" . $sur->frameworkId .
//				"' type='button' class='bedit' onclick=\"window.location.href ='" .
//				$this->createUrl('context/edit/', array(
//						'contextId' => $sur->frameworkId
//					)
//				) .
//				"'\">Edit</button>";
//			$deleteButton = "<button id='deleteContext" . $sur->frameworkId .
//				"' type='button' class='bdelete' onclick=\"$('#deleteBox').dialog('open');" .
//				"deleteConfirm('" . $sur->name . "', '" .
//				$sur->frameworkId . "')\">Remove</button>";
//			//}
//			$surveillanceListArray[] = array(
//				'frameworkId' => $sur->frameworkId,
//				'name' => $sur->name,
//				'userId' => $sur->userId,
//				'description' => $sur->description,
//				'editButton' => $editButton,
//				'deleteButton' => $deleteButton
//			);
//		}
//		$dataArray['surveillanceList'] = json_encode($surveillanceListArray);
//
//		if (!empty($_GET['getContext'])) {
//			$jsonData = json_encode(array("aaData" => $surveillanceListArray));
//			echo $jsonData;
//			return;
//		}
//	}


	/**
	 * actionlist
	 *
	 * @access public
	 * @return void
	 */
	public function actionlist($ajax = false) {
		Yii::log("actionContextList ContextController called", "trace", self::LOG_CAT);
		$model = new FrameworkContext();
		$dataArray = [];
		$dataArray['dtHeader'] = "Surveillance design List";
		$dataArray['surveillanceList'] = json_encode([]);
		$this->performAjaxValidation($model);
		Yii::app()->session->add('referrer', Yii::app()->request->urlReferrer);

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
		$surveillanceList = FrameworkContext::model()->with('fields', 'data')->findAll([
			//'select' => 'pageId, pageName',
			'condition' => 'userId=:userId',
			'params' => [
				':userId' => Yii::app()->user->id,
			],
		]);
		//print_r($surveillanceList); die;
		$surveillanceListArray = [];
		// format datatable data
		foreach ($surveillanceList as $sur) {
			//if (Yii::app()->user->name != $valu['userName']) {
			$editButton = '<button type="button" class="bedit">Edit</button>';
			$deleteButton = '<button type="button" class="bdelete">Remove</button>';
			//}
			$surveillanceListArray[$sur->frameworkId] = [
				'frameworkId' => $sur->frameworkId,
				'name' => $sur->name,
				'hazardName' => '',
				'survObj' => '',
				'editButton' => $editButton,
				'deleteButton' => $deleteButton
			];
			//print_r($surveillanceListArray);
			if(isset($sur->fields[0])) {
				foreach($sur->fields as $field) {
					if($field->inputName == 'hazardName' || $field->inputName == 'survObj') {
						foreach($sur->data as $data) {
							if($data->frameworkFieldId == $field->id) {
								if($field->inputType == 'radiolist') {

									$surveillanceListArray[$sur->frameworkId][$field->inputName] = Options::model()
										->findByPk($data->value)->label;
									break;
								}
								$surveillanceListArray[$sur->frameworkId][$field->inputName] = $data->value;
								break;
							}
						}

					}
				}
			}
		}
		//print_r(json_encode(array_values($surveillanceListArray))); die;

		$dataArray['surveillanceList'] = json_encode(array_values($surveillanceListArray));

		if ($ajax) {
			$jsonData = json_encode(["aaData" => array_values($surveillanceListArray)]);
			echo $jsonData;
			return;
		}

		$this->render('list', [
			'model' => $model,
			'dataArray' => $dataArray
		]);
	}

	/**
	 * actionView
	 *
	 * @access public
	 * @return void
	 */
	public function actionView($id) {
		Yii::log("actionView ContextController called", "trace", self::LOG_CAT);
		$dataArray = [];
			$contextId = $id;
			$selectedDesign = FrameworkContext::model()->find([
				//'select' => 'pageId, pageName',
				'condition' => 'frameworkId=:frameworkId AND userId=:userId',
				'params' => [
					':frameworkId' => $contextId,
					':userId' => Yii::app()->user->id,
				],
			]);
			$survObjCriteria = new CDbCriteria();
			$survObjCriteria->with = ['data', 'options'];
			$survObjCriteria->select = 'inputName';
			$survObjCriteria->condition = "inputName='survObj' AND data.frameworkId=" . $contextId .
				" AND options.optionId=data.value";

			$rsSurveillanceObjective = FrameworkFields::model()->find($survObjCriteria);
			$dataArray['selectedDesign'] = $selectedDesign;
			//add the surveillance context to the session
			if (count($selectedDesign) == 1) {
				Yii::app()->session->add('surDesign', [
					'id' => $contextId,
					'name' => $selectedDesign->name
				]);
				if(isset($rsSurveillanceObjective)) {
					Yii::app()->session->add('surveillanceObjective', [
						'id' => $rsSurveillanceObjective->data[0]['value'],
						'name' => $rsSurveillanceObjective->options[0]['label'],
						'fieldId' => $rsSurveillanceObjective->id
					]);

				}
				Yii::app()->user->setFlash('success', 'The surveillance system is now ' .
					Yii::app()->session['surDesign']['name']);
				if(isset(Yii::app()->session['referrer']) && false != parse_url(Yii::app()->session['referrer'])) {
					//unset(Yii::app()->session['referrer']);
					$this->redirect(Yii::app()->session['referrer']);
					return;
				}
			} else {
				Yii::app()->session->remove('surDesign');
			}


		$this->redirect(['context/index']);
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

		return [
			'wizard' => [
				'class' => 'application.extensions.WizardBehavior.WizardBehavior',
				'steps' => self::getSteps(),
				'events' => [
					'onProcessStep' => 'processSurveillance',
					'onStart' => 'wizardStart',
					'onFinished'=>'wizardFinished',
					'onInvalidStep'=>'wizardInvalidStep',
					'onSaveDraft'=>'wizardSaveDraft'

				]
			]
		];
	}

	/**
	 * @return array
	 */
	private function getSteps() {
		$steps = [];
		$stepsArray = SurveillanceSections::model()
			->findAll("tool='surveillance'");
		foreach($stepsArray as $step) {
			$steps[$step->sectionId] = $step->sectionName;
		}
		return $steps;
	}
	private function getScenario() {
		return isset(Yii::app()->session['surveillanceId']) ? 'update' : 'insert';
	}
	public function processSurveillance($event) {
		$fieldsCriteria = new CDbCriteria();
		$fieldsCriteria->condition = 'sectionId=' . $event->sender->getCurrentStep();
		$fieldsCriteria->order = '`order` ASC, `parentId` ASC';
		$surveillanceFieldsModel = FrameworkFields::model()->findAll($fieldsCriteria);
		$dForm = new DForm($this->getScenario());

		$elements = $this->getDefaultElements();
		if($event->sender->getCurrentStep() === 1) {
			$surveillanceModel = new FrameworkContext();
			$surveillanceModel->userId = Yii::app()->user->id;
			if($dForm->scenario == 'update') {
				$surveillanceModel = FrameworkContext::model()->findByPk(Yii::app()->session['surveillanceId']);
			}
			$elements['elements']['context']['elements'] = self::getElements($surveillanceModel,
				['name']);
			$elements['elements']['contextFields']['elements'][] = '<div class="surHeading">' .
			'1.' . $event->sender->getCurrentStep() . ' ' .  $event->sender->getStepLabel() . '</div>';

		}

		$elements['buttons'] = self::getButtons([
			'name' => 'next',
			'label' => 'Next'
		]);

		$elements['elements']['context']['type'] = 'form';
		//$elements['elements']['contextFields']['elements'] = self::getDefaultElements();
		$elements['elements']['contextFields']['type'] = 'form';
//		$elements['elements']['context'] = array_merge($elements['elements']['context'], $errorArray);
//		$elements['elements']['contextFields'] = array_merge($elements['elements']['contextFields'], $errorArray);
		//$contextFields = $dForm->findAll();
		$dynamicDataRules = [];
		$childCounter = 0;
		$childCount = 0;
		$parentFieldId = 0;
		//print_r($elements); die;
		$gridFieldIds = [];
		$specialInputs = array_flip(['checkboxlist', 'radiolist', 'dropdownlist']);
		foreach ($surveillanceFieldsModel as $field) {
			//if(!is_null($parentFieldId) &&
			$elements['elements']['contextFields']['elements'][] = '<div class="row">';
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

				continue;
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
			$elements['elements']['contextFields']['elements'][$attributeName] = [
				'label'    => isset($field->label) ? $field->label : $dForm->generateAttributeLabel($field->inputName),
				'required' => $field->required,
				'type'     => $field->inputType,
				'hint' => UtilModel::urlToLink($field->description),
				'data-field' => $field->id,
				'layout' => '{label} {hint} {input} {error}'
			];
			if ($field->inputType == 'dropdownlist') {
				$elements['elements']['contextFields']['elements'][$attributeName]['items'] =
					Options::model()->getContextFieldOptions($field->id);
				$elements['elements']['contextFields']['elements'][$attributeName]['prompt'] = 'Choose one';
			}
			if($field->inputType == 'radiolist') {
				$elements['elements']['contextFields']['elements'][$attributeName]['separator'] = '<br>';
				//'labelOptions'=>array('style'=>'display:inline-block'),
				$elements['elements']['contextFields']['elements'][$attributeName]['style'] = 'width:1em;';
				$elements['elements']['contextFields']['elements'][$attributeName]['template']  =
					'<span class="radiolist">{input} {label}</span>';
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
			if(isset($specialInputs[$field->inputType]) && empty($field->label)) {
				$elements['elements']['contextFields']['elements'][$attributeName]['label'] = '';
			}

			if(isset($field->parentId) && $field->parentId == $parentFieldId) {
				if ($childCount != $childCounter) {
					//echo $childCounter . '======>' . $childCount . '<br>';
					$childCounter++;
				} else {
					$elements['elements']['contextFields']['elements'][] = '</fieldset>';
				}
			}
			$elements['elements']['contextFields']['elements'][] = '</div>';

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
		//print_r($form); die;
		$fieldData = [];
		//$form->loadData();
		if ($form->submitted('next')) {
			//print_r($_POST['DForm']); die;
			if(isset($_POST['DForm'][0])) {
				// This can be refactored later
				$dataIdArray = [];
				foreach($_POST['DForm'] as $row => $rowData ) {
						//print_r($rowData);
					foreach($rowData as $attrName => $attrVal) {
						if(!empty($attrVal)) {
							if(is_array($attrVal)) {
								$attrVal = json_encode($attrVal);
							}
							$fieldNameAndId = explode('_', $attrName);
							$dataId = $dForm->getFieldDataId($fieldNameAndId[1]);
							if(isset($dataId) && isset($dataIdArray[$dataId])) {
								$dataId = null;
							}
							$dataIdArray[$dataId] = $dataId;
							$fieldData[$row][$attrName]['frameworkFieldId'] = $fieldNameAndId[1];
							$fieldData[$row][$attrName]['value'] = $attrVal;
							$fieldData[$row][$attrName]['id'] = $dataId;

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
							$fieldData[$fieldNameAndId[0]]['id'] = $dForm->getFieldDataId($fieldNameAndId[1]);

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
		Yii::app()->user->setFlash('notice', $event->step.' is not a valid step in this wizard');
	}


	/**
	 * @param $event
	 */
	public function wizardFinished($event) {
		$surveillanceDataModel = new FrameworkFieldData();
		$frameWorkModel = new FrameworkContext();
		if(isset(Yii::app()->session['surveillanceId'])) {
			$frameWorkModel = FrameworkContext::model()->findByPk(Yii::app()->session['surveillanceId']);
			$surveillanceDataModel->setScenario('update');
		}
		$frameWorkData = $event->getData();
		$frameWorkModel->attributes = $frameWorkData['surveillanceModel'];
		$transaction = Yii::app()->db->beginTransaction();
		$dataKeys = [];
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
								$newRecord = is_null($data['id']) ? true : false;
								$surveillanceDataModel->attributes = $data;
								$surveillanceDataModel->frameworkId = $frameWorkModel->frameworkId;
								$surveillanceDataModel->setPrimaryKey($data['id']);
								$surveillanceDataModel->setIsNewRecord($newRecord);
								//var_dump($surveillanceDataModel); //die;
								$surveillanceDataModel->save();
								if(isset($data['id'])) {
									$dataKeys[] = $data['id'];
								} else {
									$dataKeys[] = $surveillanceDataModel->id;
								}
							} else {
								foreach($data as $field) {

									if(isset($field['value'])) {
										$newRecord = is_null($field['id']) ? true : false;
										$surveillanceDataModel->attributes = $field;
										$surveillanceDataModel->frameworkId = $frameWorkModel->frameworkId;
										$surveillanceDataModel->setPrimaryKey($field['id']);
										$surveillanceDataModel->setIsNewRecord($newRecord);
										$surveillanceDataModel->save();
										if(isset($data['id'])) {
											$dataKeys[] = $data['id'];
										} else {
											$dataKeys[] = $surveillanceDataModel->id;
										}
									}
								}
							}
							//die;
						}


					}

				}
				$deleteCriteria = new CDbCriteria();
				$deleteCriteria->addNotInCondition('id', $dataKeys);
				$surveillanceDataModel->deleteAll($deleteCriteria);
				//var_dump($surveillanceDataModel); die;
				$transaction->commit();
				//die;
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
		unset(Yii::app()->session['surveillanceId']);
		$this->process($step);
	}

	public function generateOverviewTable($event) {

		echo '<table id="survTable" width="100%" border="0" cellspacing="0" cellpadding="0">' .
			'<thead><tr><th></th><th></th></tr></thead><tbody>';
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
			echo CHtml::tag('td', ['colspan' => 2], '<b>' . $surveillanceData->sectionName . '</b>');
			echo '</tr>';
			foreach ($surveillanceData->frameworkFields as $field) {
				if($field->inputType == 'label' || $field->inputType == 'grid') {
					echo '<tr>';
					echo CHtml::tag('td', ['colspan' => 2], '<b>' . $field->label . '</b>');
					echo '</tr>';
					continue;
				}
				echo '<tr>';
				echo '<td>';
				echo isset($field->label) ?
					$field->label : FrameworkFields::model()->generateAttributeLabel($field->inputName);
				echo '</td>';
				foreach($surveillanceData->survData as $data) {
					if(isset($data->frameworkFieldId) && $data->frameworkFieldId == $field->id) {
						$dataValue = $data->value;

						if($field->inputType == 'checkboxlist' || $field->inputType == 'dropdownlist' ||
							$field->inputType == 'radiolist') {
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
	 * @param null $step
	 * @param null $id
	 */
	public function actionUpdate($step = null, $id = null) {
	if (isset($id)) {
		Yii::app()->session['surveillanceId'] = $id;
		}
		$this->process($step);
	}


	/**
	 * @param $id
	 */
	public function actionDelete($id) {
		Yii::log("actionDelete ContextController called", "trace", self::LOG_CAT);
		$record = FrameworkContext::model()->findByPk($id);
		if (!$record->delete()) {
			Yii::log("Error deleting context: " . $id, "warning", self::LOG_CAT);
			//echo $errorMessage;
			echo Yii::t("translation", "A problem occurred when deleting the surveillance system ");
		} else {
			// remove the default selected design from session
			unset($_SESSION['surDesign']);
			echo Yii::t("translation", "The surveillance system ") .
				Yii::t("translation", " has been successfully deleted");
		}
		return;
	}

	/**
	 * @param CActiveRecord $model
	 * @param array $attributes
	 * @return array
	 */
	public static function getElements($model, $attributes = []) {
		$modelAttributes = $model->getAttributes();
		$modelElements = [];
		foreach ($modelAttributes as $attrName => $attrVal) {

			if (!empty($attributes)) {
				foreach ($attributes as $attr) {
					if ($attrName === $attr) {
						$modelElements[$attr] = [
							'label' => $model->getAttributeLabel($attr),
							'required' => $model->isAttributeRequired($attr),
							'type' => 'text'
						];


					}

				}
				continue;
			}

			$modelElements[$attrName] = [
				'label' => $model->getAttributeLabel($attrName),
				'required' => $model->isAttributeRequired($attrName),
				'type' => 'text'
			];

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
		$errorParams = [
			'showErrorSummary' => true,
			'showErrors' => true,
			'errorSummaryHeader' => Yii::app()->params['headerErrorSummary'],
			'errorSummaryFooter' => Yii::app()->params['footerErrorSummary'],
		];
		$defaultParams = [
			'activeForm' => [
				'id' => 'DForm',
				'class' => 'CActiveForm',
				'enableClientValidation' => true,
				'clientOptions' => [
					'validateOnSubmit' => true,
				]
			]
		];
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
	public static function getButtons($buttonName = ["name" => "save", "label" => "Save"], $url = 'context/list') {
		return [
			$buttonName['name'] => [
				'type' => 'submit',
				'label' => $buttonName['label'],
			],
			'cancel' => [
				'type' => 'button',
				'label' => 'Cancel',
				'onclick' => "window.location='" . Yii::app()->createUrl($url) . "'"
			]
		];
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
		$gridFieldsNames = [];
		$labels = [];
		$properties = [];
		$rules = [];
		$inputs = '';
		if($dForm->getScenario() == 'insert') {
			$gridFields =  FrameworkFields::model()->findAll($gridFieldsCriteria);
			$inputs .= '<tr class="copy' . $fieldId . '">';

			foreach($gridFields as $field) {
				//$el = new CFormInputElement()
				$attribute = $field->inputName . '_' . $field->id;
				$dForm->setpropertyName($attribute);
//			continue;
				//$model->setAttribute($attribute, $field->inputName);
//			$dForm->_dynamicLabels[$attribute] = isset($field->label) ?
//				$field->label : $dForm->generateAttributeLabel($field->inputName);
				$labels[$attribute] = isset($field->label) ?
					$field->label : $dForm->generateAttributeLabel($field->inputName);
				$validation = $field->required ? 'required' : 'safe';
				$rules[] = [$attribute, $validation];
				$i = 0;
				//print_r($dForm); die;
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
			$inputs .= '<td></td></tr>';



		} else {
			// get id's of fields that belong to the grid
			//$gridFieldsCriteria->select = 'id';
			$childFields = ModelToArray::convertModelToArray(FrameworkFields::model()->findAll($gridFieldsCriteria),
				['frameworkFields' => 'id, inputName, label, inputType, required, multiple']);
			$gridFieldsIds = array_map(function($item) {
				return $item['id'];
			}, $childFields);
			// get grid data
			$fieldDataCriteria = new CDbCriteria();
			$fieldDataCriteria->addInCondition('frameworkFieldId', $gridFieldsIds);
			$gridFields = FrameworkFieldData::model()->with('frameworkFields')->findAll($fieldDataCriteria);
			if(empty($gridFields)) {
				$dForm->setScenario('insert');
				//print_r($dForm); die;
				return self::generateGridElements($fieldId, $dForm);
			}
//				print_r($childFields); die;
			foreach($childFields as $child) {
				$gridFieldsNames[$child['id']] = $child['inputName'] . '_' . $child['id'];
				$gridParams[$child['inputName'] . '_' . $child['id']]['id'] = $child['id'];
				$labels[$child['inputName'] . '_' . $child['id']] = $child['label'];
				$gridParams[$child['inputName'] . '_' . $child['id']]['inputType'] = $child['inputType'];
				$gridParams[$child['inputName'] . '_' . $child['id']]['required'] = $child['required'];
				$gridParams[$child['inputName'] . '_' . $child['id']]['multiple'] = $child['multiple'];
			}
			//$gridFields =  FrameworkFields::model()->findAll($gridFieldsCriteria);

			$k = 0;
			$dFormGrid = [];
			$dFormGrid[$k] = new DForm();
			foreach($gridFields as $gridFieldData) {

				if(count($gridFieldsIds) == count($dFormGrid[$k]->attributes)) {
					$k++;
					$dFormGrid[$k] = new DForm();
				}
				//echo $gridFieldsNames[$gridFieldData->frameworkFieldId];
				$dFormGrid[$k]->setPropertyName($gridFieldsNames[$gridFieldData->frameworkFieldId],
					$gridFieldData->value);
				if(DForm::isJson($gridFieldData->value)) {
					$dFormGrid[$k]->setPropertyName($gridFieldsNames[$gridFieldData->frameworkFieldId],
						json_decode($gridFieldData->value));

				}
				$cols[$gridFieldData->frameworkFieldId] = $gridFieldData->frameworkFieldId;
			}
			//$inputs = '';
			foreach($dFormGrid as $key => $gridItems) {
				$inputs .= '<tr class="copy' . $fieldId . '">';
				foreach($gridItems->attributeNames() as $attr) {
				//var_dump($gridItems[$attr]); die;
					$inputs .= '<td>';
					switch($gridParams[$attr]['inputType']) {
						case 'text':
							$inputs .= CHtml::activeTextField($gridItems, "[$key]$attr");
							$inputs .= CHtml::error($gridItems, "[$key]$attr");
							break;
						case 'dropdownlist':
							$options = [];
							if($gridParams[$attr]['multiple']) {
								$options['multiple'] = true;
							}
							$inputs .= CHtml::activeDropDownList($gridItems, "[$key]$attr",
								Options::model()->getContextFieldOptions($gridParams[$attr]['id']), $options);
							$inputs .= CHtml::error($gridItems, "[$key]$attr");
							break;
					}
					$inputs .= '</td>';
				}
				$inputs .= '</tr>';
			}
			//echo $inputs; die;

		}
		//var_dump($data, $cols); die('lklk');
		//die;
		$dForm->setRules($rules);
		$dForm->setAttributeLabels($labels);
		//print_r(array_values($labels));
		$tableHeader = '<th>' . implode('</th><th>', array_values($labels));
		$table = '<table class="jgTabular"><thead><tr>' . $tableHeader . '<th></th></tr></thead>';
		$table .= '<tbody>' . $inputs . '</tbody>';
		$table .= '</table>';
		$table .= CHtml::htmlButton('<span class="ui-icon ui-icon-plusthick"></span>Add new row', [
			'id' => 'copyLink-' . $fieldId,
			'rel' => '.copy' . $fieldId
		]);
//		if($fieldId == 37) {
//			print_r($table); //die('pop');
//		}
		return $table;



	}

}
