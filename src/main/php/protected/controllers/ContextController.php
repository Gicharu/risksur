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
	 * actionIndex
	 */
	public function actionIndex() {
		//$this->setPageTitle($this->id . 'Introduction');
		Yii::log("actionIndex ContextController called", "trace", self::LOG_CAT);
		$this->docName = 'survIndex';
		if(isset($_POST['pageId'])) {
			SystemController::savePage($this->createUrl('index'));
		}
		$page = SystemController::getPageContent($this->docName);
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
	 * actionlist
	 * @param bool $ajax
	 * @return void
	 */
	public function actionList($ajax = false) {
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
		unset(Yii::app()->session['surDesign']);
		unset(Yii::app()->session['evaContext']);
		if (count($selectedDesign) == 1) {
			Yii::app()->session->add('surDesign', [
				'id' => $contextId,
				'name' => $selectedDesign->name
			]);
			unset(Yii::app()->session['surveillanceObjective']);
			if(isset($rsSurveillanceObjective)) {
				Yii::app()->session->add('surveillanceObjective', [
					'id' => $rsSurveillanceObjective->data[0]['value'],
					'name' => $rsSurveillanceObjective->options[0]['label'],
					'fieldId' => $rsSurveillanceObjective->id
				]);

			}
			Yii::app()->user->setFlash('success', 'The surveillance system is now ' .
				Yii::app()->session['surDesign']['name']);
			if(Yii::app()->request->getUrlReferrer()) {
				//print_r(Yii::app()->session); die;
				//unset(Yii::app()->session['referrer']);
				$this->redirect(Yii::app()->request->getUrlReferrer());
				return;
			}
		} else {
			Yii::app()->session->remove('surDesign');
		}


		$this->redirect('list');
	}

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
					'onSaveDraft'=>'wizardSaveDraft',
					'onReset'=>'wizardReset'

				],
				'draftSavedUrl' => ['context/list'],
//				'saveDraftButton' => 'save',
				'resetButton' => 'reset'
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

	/**
	 * @return string
	 */
	private function getScenario() {
		return isset(Yii::app()->session['surDesign']['id']) ? 'update' : 'insert';
	}

	/**
	 * @param WizardEvent $event
	 * @return bool
	 */
	public function processSurveillance($event) {
		$fieldsCriteria = new CDbCriteria();
		$fieldsCriteria->condition = 'sectionId=' . $event->sender->getCurrentStep();
		$fieldsCriteria->order = '`order` ASC, `parentId` ASC';
		$surveillanceFieldsModel = FrameworkFields::model()->findAll($fieldsCriteria);
		$dForm = new DForm($this->getScenario());

		$surveillanceModel = new FrameworkContext();
		$elements = $this->getDefaultElements();
		if($event->sender->getCurrentStep() === 1) {
			$surveillanceModel->userId = Yii::app()->user->id;
			if($dForm->scenario == 'update') {
				$surveillanceModel = FrameworkContext::model()->findByPk(Yii::app()->session['surDesign']['id']);
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
				$elements['elements']['contextFields']['elements'][$attributeName]['title'] =
					'title';
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
			$dForm = $form['contextFields']->model;
			//print_r($form); die;
			$transaction = Yii::app()->db->beginTransaction();
			try {
				if(isset($form['context']->model)) {
					$surveillanceModel = $form['context']->model;
					$surveillanceModel->save();
					Yii::app()->session['surDesign']['id'] = $surveillanceModel->frameworkId;
				}
				//var_dump($this->surveillanceId . '   ------>tsergtretgretgerd'); die;
				if(isset($dForm)) {
					// This can be refactored later
					$dataIdArray = [];
					foreach($dForm->attributes as $attrName => $attrVal ) {
						$frameworkDataModel = new FrameworkFieldData();
						//var_dump($event->getStep()); die;
						if(is_array($attrVal)) {
							$attrVal = json_encode($attrVal);
						}
						$fieldNameAndId = explode('_', $attrName);
						$dataId = $dForm->getFieldDataId($fieldNameAndId[1]);
						//var_dump($dataId); die;

						$dataIdArray[$dataId] = $dataId;
						$frameworkDataModel->frameworkId = Yii::app()->session['surDesign']['id'];
						$frameworkDataModel->frameworkFieldId = $fieldNameAndId[1];
						$frameworkDataModel->value = $attrVal;
						//print_r($frameworkDataModel->getAttribute('value')); die;
						if(isset($dataId)) {
							$frameworkDataModel->setIsNewRecord(false);
							//$frameworkDataModel->id = $dataId;
							$frameworkDataModel->updateAll(['value' => $frameworkDataModel->value],
								'frameworkId=:framework AND frameworkFieldId=:fieldId',
								[':framework' => $frameworkDataModel->frameworkId,
								 ':fieldId' => $frameworkDataModel->frameworkFieldId]);
						} else {
							$frameworkDataModel->save();
						}


						//print_r($fieldData); die;
					}
					$transaction->commit();
				}
			} catch(Exception $e) {
				$transaction->rollback();
				Yii::log('Error saving surveillance data: ' . $e->getMessage() );
				die;
			}

//			else {
//				if($form->validate()) {
//
//					//print_r($dForm->attributes); die;
//					foreach($dForm->attributes as $attrName => $attrVal) {
//						if(!empty($attrVal)) {
//							$fieldNameAndId = explode('_', $attrName);
//							$fieldData[$fieldNameAndId[0]]['frameworkFieldId'] = $fieldNameAndId[1];
//							$val = $attrVal;
//							if(is_array($attrVal)) {
//								$val = json_encode($attrVal);
//							}
//							$fieldData[$fieldNameAndId[0]]['value'] = $val;
//							$fieldData[$fieldNameAndId[0]]['id'] = $dForm->getFieldDataId($fieldNameAndId[1]);
//
//						}
//					}
//
//				}
//			}
			//$dForm->fieldId =
			//$dataToSave = array($dForm->getAttributes());
			$dataToSave = [$fieldData];
			if($event->sender->getCurrentStep() == 1) {
				$event->sender->save($surveillanceModel->getAttributes(), 'surveillanceModel');

			}
			//print_r($event->sender); die;
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

	/**
	 * @param $event
	 */
	public function wizardStart($event) {
		$event->handled = true;
	}

	/**
	 * Raised when the wizard detects an invalid step
	 * @param WizardEvent $event
	 */
	public function wizardInvalidStep($event) {
		Yii::app()->user->setFlash('notice', $event->step.' is not a valid step in this wizard');
	}

	/**
	 * Raised when the cancel button is clicked
	 * @param $event
	 */
	public function wizardReset($event) {
		$event->sender->reset();
		$this->redirect('list');
		Yii::app()->end();
	}

	public function wizardSaveDraft($event) {
		die($event);
	}


	/**
	 * @param $event
	 */
	public function wizardFinished($event) {
//		$surveillanceDataModel = new FrameworkFieldData();
//		$frameWorkModel = new FrameworkContext();
//		$frameWorkData = $event->getData();
//		//print_r($frameWorkData['surveillanceModel']['frameworkId']); die;
//		if(isset($frameWorkData['surveillanceModel']['frameworkId'])) {
//			$frameWorkModel = FrameworkContext::model()->findByPk($frameWorkData['surveillanceModel']['frameworkId']);
//			$surveillanceDataModel->setScenario('update');
//		}
//		$frameWorkModel->attributes = $frameWorkData['surveillanceModel'];
//		//var_dump($frameWorkModel->validate()); die;
//		$transaction = Yii::app()->db->beginTransaction();
//		$dataKeys = [];
//		try {
//			if ($frameWorkModel->save()) {
//				//if(true) {
//				//print_r($frameWorkData); die;
//				unset($frameWorkData['surveillanceModel']);
//				//die;
//				foreach ($frameWorkData as $step => $formData) {
//					//print_r($formData);
//					//echo "_______________________________$step";
//					foreach ($formData as $fieldData) {
//						foreach($fieldData as $fieldName => $data) {
//							//print_r($data);
//							if (isset($data['value'])) {
//								$newRecord = is_null($data['id']) ? true : false;
//								$surveillanceDataModel->attributes = $data;
//								$surveillanceDataModel->frameworkId = $frameWorkModel->frameworkId;
//								$surveillanceDataModel->setPrimaryKey($data['id']);
//								$surveillanceDataModel->setIsNewRecord($newRecord);
//								//var_dump($surveillanceDataModel); //die;
//								$surveillanceDataModel->save();
//								if(isset($data['id'])) {
//									$dataKeys[] = $data['id'];
//								} else {
//									$dataKeys[] = $surveillanceDataModel->id;
//								}
//							} else {
//								foreach($data as $field) {
//
//									if(isset($field['value'])) {
//										$newRecord = is_null($field['id']) ? true : false;
//										$surveillanceDataModel->attributes = $field;
//										$surveillanceDataModel->frameworkId = $frameWorkModel->frameworkId;
//										$surveillanceDataModel->setPrimaryKey($field['id']);
//										$surveillanceDataModel->setIsNewRecord($newRecord);
//										$surveillanceDataModel->save();
//										if(isset($data['id'])) {
//											$dataKeys[] = $data['id'];
//										} else {
//											$dataKeys[] = $surveillanceDataModel->id;
//										}
//									}
//								}
//							}
//							//die;
//						}
//
//
//					}
//
//				}
//				//print_r($frameWorkModel); die;
//				//print_r($dataKeys);
//				$deleteCriteria = new CDbCriteria();
//				$deleteCriteria->condition = 'frameworkId=' . $frameWorkModel->frameworkId;
//				$deleteCriteria->addNotInCondition('id', $dataKeys);
//				//print_r($deleteCriteria); die;
//				$surveillanceDataModel->deleteAll($deleteCriteria);
//				$transaction->commit();
//
//			}
//		} catch (Exception $e) {
//			Yii::log($e->getMessage() . 'error when saving a surveillance system error code [' . $e->getCode() . ']',
//				'error', self::LOG_CAT);
//			$transaction->rollBack();
//			$event->sender->reset();
//			Yii::app()->end();
//			Yii::app()->user->setFlash('error', 'There was a problem saving the surveillance system, please try ' .
//				'again or contact your administrator is the problem persists');
//			$this->redirect('create');
//
//		}
		//die('hapa');
		unset(Yii::app()->session['surveillanceObjective']);
		unset(Yii::app()->session['surDesign']);
		unset(Yii::app()->session['evaContext']);
		$event->sender->reset();
//		Yii::app()->end();
		Yii::app()->user->setFlash('success', 'Surveillance system characterisation is now complete, you have' .
			' characterised this surveillance system as:');
		$this->redirect(['report', 'systemId' => Yii::app()->session['surDesign']['id']]);
	}

	/**
	 * @param null $step
	 */
	public function actionCreate($step=null) {

		unset(Yii::app()->session['surDesign']['id']);
		$this->process($step);
	}

	public function actionReport($systemId = null, $ajax = null) {
		$surveillanceReport = [];

		if(isset($ajax)) {
			if($systemId == -1) {
				echo json_encode(['aaData' => []]);
				return;
			}
			$rsSurveillance = Yii::app()->db->createCommand()
				->select('s.sectionId, s.sectionName, ff.id, ff.sectionId, ff.order AS childCount, ff.parentId, ff.label, ff.inputName, fd.frameworkFieldId, fd.value, grid.label AS parentLabel')
				->from('surveillanceSections s')
				//->join('tbl_profile p', 'u.id=p.user_id')
				->leftJoin('frameworkFields ff', 'ff.sectionId = s.sectionId')
				->leftJoin('frameworkFieldData fd', 'fd.frameworkFieldId = ff.id')
				->leftJoin('frameworkFields grid', 'grid.id = ff.parentId')

				->where('fd.frameworkId = :framework ', [':framework' => $systemId])
				->order('ff.sectionId ASC, ff.order ASC')
				->queryAll();
//			print_r($rsSurveillance); die;


			if(!isset($rsSurveillance[0])) {
				Yii::app()
					->user
					->setFlash('notice', 'The surveillance system you have selected has no data, please update it');
				$this->redirect('list');
				return;
			}
			$rsSurvHead = FrameworkContext::model()->findByPk($systemId);
			$sectionKey = 0;
			$labelCount = 0;
			$oldLabel = '';
			$surveillanceReport[200]['sectionName'] = " ";
			$surveillanceReport[200]['parentLabel'] = " ";
			$surveillanceReport[200]['labelIndex'] = $labelCount;
			$surveillanceReport[200]['field'] = "Surveillance System Name";
			$surveillanceReport[200]['data'] = $rsSurvHead->name;
			foreach($rsSurveillance as $section) {
				//foreach ($section->frameworkFields as $field) {}
				$surveillanceReport[$sectionKey]['sectionName'] = '1.' . $section['sectionId'] .
					' ' . $section['sectionName'];
				$surveillanceReport[$sectionKey]['parentLabel'] =  " ";
				$surveillanceReport[$sectionKey]['labelIndex'] =  $labelCount;

				//$surveillanceReport[$sectionKey]['parenLabelIndex'] =  $parentLabelCount;
				if(isset($section['parentLabel'])) {
					$surveillanceReport[$sectionKey]['parentLabel'] = $section['parentLabel'];

				}
				if($section['label'] == $oldLabel) {
					$surveillanceReport[$sectionKey]['labelIndex'] =  ++$labelCount;
				}
				$surveillanceReport[$sectionKey]['field'] = isset($section['label']) ?
					$section['label'] : SurveillanceSections::model()->getAttributeLabel($section['inputName']);
				//foreach ($section->survData as $fieldData) {}
				//if($field->id == $fieldData->frameworkFieldId) {}
				$surveillanceReport[$sectionKey]['data'] = $section['value'];
				if(DForm::isJson($section['value'])) {
					//print_r(json_decode($fieldData->value, true)); die;
					$optionsCriteria = new CDbCriteria();
					$optionsArray = json_decode($section['value']);
					//var_dump($optionsArray); //die;
					if(is_array($optionsArray)) {
						$optionsCriteria->addInCondition('optionId', $optionsArray);

					}
					if(is_int($optionsArray)) {
						$optionsCriteria->addCondition('optionId=:option');
						$optionsCriteria->params = [':option' => $optionsArray];
					}
					$optionsCriteria->select = 'label';

					$rsOptions = ModelToArray::convertModelToArray(Options::model()
						->findAll($optionsCriteria), ['options' => 'label']);

					$options = '';
					array_walk($rsOptions, function ($opt) use (&$options) {
						$options .= $opt['label'] . ', ';
					});
					$options = rtrim($options, ', ');
					$surveillanceReport[$sectionKey]['data'] = $options;
					//print_r($rsOptions); die;
				}

				$sectionKey++;
//				if(!isset($section['parentLabel']) || $oldParentLabel != $section['parentLabel']) {
//					$parentLabelCount = 1;
//				}
				$oldLabel = $section['label'];
			}
			echo json_encode(['aaData' => array_values($surveillanceReport)]);
			return;
			//print_r($surveillanceReport); die;
		}
		$surveillanceSystems = CHtml::listData(FrameworkContext::model()
			->findAll('userId=:user', [':user' => Yii::app()->user->id]), 'frameworkId', 'name');

		$this->render('report', ['surveillanceSystems' => $surveillanceSystems, 'sysId' => $systemId]);
		return;
	}

	/**
	 * @param null $step
	 * @param null $id
	 */
	public function actionUpdate($step = null, $id = null) {
		if (isset($id)) {
			Yii::app()->session['surDesign'] = ['id' => $id];
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
//			'save_draft' => [
//				'type' => 'submit',
//				'label' => 'Save',
//			],
			'reset' => [
				'type' => 'submit',
				'label' => 'Cancel',
				//'onclick' => "window.location='" . Yii::app()->createUrl($url) . "'"
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
			$childFields = ModelToArray::convertModelToArray(FrameworkFields::model()->with('data')->findAll($gridFieldsCriteria));
//				['frameworkFields' => 'id, inputName, label, inputType, required, multiple']);
			//print_r($childFields); die;
			$gridFieldsIds = array_map(function($item) {
				return $item['id'];
			}, $childFields);
			// get grid data
			$fieldDataCriteria = new CDbCriteria();
			$fieldDataCriteria->condition = 'frameworkId=' . Yii::app()->session['surDesign']['id'];
			$fieldDataCriteria->addInCondition('frameworkFieldId', $gridFieldsIds);
			$gridFields = FrameworkFieldData::model()->findAll($fieldDataCriteria);
			if(empty($gridFields)) {
				$dForm->setScenario('insert');
				//print_r($dForm); die;
				return self::generateGridElements($fieldId, $dForm);
			}

			$dFormGrid = [];

			foreach($childFields as $child) {
				$elementId = $child['inputName'] . '_' . $child['id'];
				$gridFieldsNames[$child['id']] = $elementId;
				$gridParams[$elementId]['id'] = $child['id'];
				$labels[$elementId] = $child['label'];
				$gridParams[$elementId]['inputType'] = $child['inputType'];
				$gridParams[$elementId]['required'] = $child['required'];
				$gridParams[$elementId]['multiple'] = $child['multiple'];
			}
			//$dFormGrid[$k] = new DForm();
			foreach($childFields as $child) {
				if(isset($child['data'][0])) {
					foreach ($child['data'] as $key => $data) {
						if(!isset($dFormGrid[$key])) {
							$dFormGrid[$key] = new DForm();
						}

						$elementId = $child['inputName'] . '_' . $child['id'];
						foreach ($gridFieldsNames as $gridElement) {
							if (empty($dFormGrid[$key]->attributes[$gridElement])) {
								//echo "new $key $gridElement \n";
								//print_r($dFormGrid[$key]);
//
								$dFormGrid[$key]->setPropertyName($gridElement);
							}
							//var_dump($dFormGrid[$key]->$gridElement);
						}

						$dFormGrid[$key]->$elementId  = $data['value'];
						if (DForm::isJson($data['value'])) {
							$dFormGrid[$key]->$elementId = json_decode($data['value']);
						}

					}
				}
			}
			$copyClass = '';
			foreach($dFormGrid as $key => $gridItems) {
				$inputs .= '<tr class="copy' . $fieldId . ' ' . $copyClass . '">';
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
				$inputs .= '<td><a class="remove ui-icon ui-icon-trash" href="#"' .
					' onclick="$(this).parent().parent().remove(); return false">remove</a></td></tr>';
				$copyClass = 'copy1';
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
