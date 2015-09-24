<?php

/**
 * DesignController
 * @package
 * @author    Chirag Doshi <chirag@tracetracker.com>
 * @copyright Tracetracker
 * @version   $id$
 * @uses      RiskController
 * @license   Tracetracker {@link http://www.tracetracker.com}
 */
class DesignController extends RiskController {
	const LOG_CAT = "ctrl.DesignController";
	//Use layout
	public $layout = '//layouts/column2';
	public $docName;
	public $displayItems = [];

	public function init() {
		$this->displayItems = [
			'otherTargetSpecies' => ['name' => 'targetSpecies', 'type' => 'field'],
			'otherSurveillanceObj' => ['name' => Yii::app()->session['surveillanceObjective']['name'], 'type' => 'string'],
			'otherTargetSector' => ['name' => 'targetSector', 'type' => 'field']
		];
	}


	/**
	 * actionIndex
	 */
	public function actionIndex() {
		//$this->setPageTitle($this->id . 'Introduction');
		Yii::log("actionIndex DesignController called", "trace", self::LOG_CAT);
		$this->docName = 'desIndex';
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
		Yii::log("Function getPageContent DesignController called", "trace", self::LOG_CAT);
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
		Yii::log("Function SavePage DesignController called", "trace", self::LOG_CAT);
		$model = DocPages::model()->findByPk($_POST['pageId']);
		if (isset($_POST['desContent'])) {
			$purifier = new CHtmlPurifier();
			$model->docData = $purifier->purify($_POST['desContent']);
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
	/**
	 * actionShowComponent
	 * @access public
	 * @return void
	 */
	public function actionShowComponent() {
		Yii::log("actionShowComponent DesignController called", "trace", self::LOG_CAT);
		$dataArray = [];
		$dataArray['selectedComponent'] = [];
		//fetch the components data
		if (!empty ($_GET['compId'])) {
			$fetchComponentData = Yii::app()->db->createCommand()
				->select('cd.componentDetailId,
					cd.componentId, 
					cd.subFormId, 
					cd.value, 
					sd.inputName, 
					sd.label, 
					sd.inputType, 
					ch.componentName,
					o.label as optionValue'
				)
				->from('componentDetails cd')
				->join('surFormDetails sd', 'sd.subFormId = cd.subFormId')
				->join('componentHead ch', 'ch.componentId = cd.componentId')
				->leftjoin('options o', 'o.optionId = cd.value')
				->where('cd.componentId =' . $_GET['compId'])
				->queryAll();
			//print_r($fetchComponentData);die();
			//arrange data in array
			foreach ($fetchComponentData as $dat) {
				if ($dat['inputType'] == "select") {
					// show option value if the data is for a dropdown
					$dataArray['selectedComponent'][$dat['label']] = $dat['optionValue'];
				} else {
					$dataArray['selectedComponent'][$dat['label']] = $dat['value'];
				}
				// add the component name to the array as well but just once
				if (empty($dataArray['selectedComponent']['Component Name'])) {
					$dataArray['selectedComponent']['Component Name'] = $dat['componentName'];
				}
			}
		}

		$this->render('showComponent', [
			//'model' => $model,
			'dataArray' => $dataArray
		]);
	}

//		/**
//		 * actionCreateDesign
//		 *
//		 * @access public
//		 * @return void
//		 */
//		public function actionCreateDesign() {
//			Yii::log("actionCreateDesign DesignController called", "trace", self::LOG_CAT);
//			$model = new NewDesign;
//			$dataArray = array();
//			$dataArray['formType'] = "Create";
//			$this->performAjaxValidation($model);
//
//			if (isset($_POST['NewDesign'])) {
//				$model->attributes = $_POST['NewDesign'];
//				$model->userId = Yii::app()->user->id;
//
//				//validate and save the design
//				if ($model->validate("create")) {
//					$model->save(false);
//					Yii::app()->session->add('surDesign', array(
//						'id' => $model->frameworkId,
//						'name' => $model->name,
//						'goalId' => $model->goalId
//					));
//					Yii::app()->user->setFlash('success', Yii::t("translation", "Design successfully created"));
//					$this->redirect(array('index'));
//				}
//			}
//			// fetch the goal dropdown data
//			$goalDropDown = GoalData::model()->findAll(array(
//				'select' => 'pageId, pageName',
//				'condition' => 'parentId=:parentId AND pageName<>:pageName',
//				'params' => array(
//					':parentId' => 0,
//					':pageName' => 'noMenu'
//				),
//			));
//			// create array options for goal dropdown
//			foreach ($goalDropDown as $data) {
//				$dataArray['goalDropDown'][$data->pageId] = $data->pageName;
//			}
//			$this->render('createDesign', array(
//				'model' => $model,
//				'dataArray' => $dataArray
//			));
//		}

	/**
	 * actionAddComponent
	 * @access public
	 * @return void
	 */
	public function actionAddComponent() {
		Yii::log("actionAddComponent DesignController called", "trace", self::LOG_CAT);

		$dataArray = [];
		$dataArray['formType'] = 'Create';
		//$attributeArray = array();
//			print_r(Yii::app()->session['surDesign']); die('here');
		if (!empty(Yii::app()->session['surDesign'])) {
			$returnArray = self::getElementsAndDynamicAttributes();
			$elements = $returnArray['elements'];
			$model = new DesignForm('create');
			$model->setProperties($returnArray['dynamicDataAttributes']);
			$model->setAttributeLabels($returnArray['dynamicLabels']);
			$model->setRules($returnArray['dynamicRules']);
			//var_dump($model); die;
			// generate the components form
			$form = new CForm($elements, $model);
			if(Yii::app()->getRequest()->getIsAjaxRequest()) {
				echo CActiveForm::validate( [ $model]);
				Yii::app()->end();
			}
			//validate and save the component data
			if ($form->submitted('DesignForm') && $form->validate()) {
				$component = new ComponentHead;
				$componentDetails = new ComponentDetails();
				//var_dump($form->model); die();
				$component->componentName = $form->model->componentName;
				$component->frameworkId = Yii::app()->session['surDesign']['id'];
				//save the componentHead values
				$component->save();
				$componentId = $component->componentId;
				$form->model->unsetProperties(['componentName']);
				// fetch the form data
				$transaction = Yii::app()->db->beginTransaction();
				try {
					foreach ($form->model as $key => $val) {
						$componentDetails->unsetAttributes();
						$componentDetails->setIsNewRecord(true);
						$componentDetails->componentDetailId = null;
						$componentDetails->componentId = $componentId;
						$params = explode("_", $key);

						//var_dump($form, $key, $val, $params); die;
						$componentDetails->subFormId = $params[1];
						$componentDetails->value = $val;
						$componentDetails->save();
					}
					$transaction->commit();
					Yii::app()->user->setFlash('success', Yii::t("translation", "Component successfully created"));
					$this->redirect(['getDesignElements']);
					return;
				} catch (Exception $e) {
					$transaction->rollBack();
					Yii::app()->user->setFlash('error', Yii::t("translation", "A problem occurred when saving the" .
						" component, please try again or contact your administrator if the problem persists"));

				}
			}
//				print_r($model);
//			print_r($form['componentName']); die('here');
			//print_r($form->render()); die('here');

			$this->render('component', [
				//'model'     => $model,
				'dataArray' => $dataArray,
				'form'      => $form
			]);
			return;
		}
		Yii::app()->user->setFlash('notice', Yii::t("translation", "Please select a surveillance system first"));
		$this->redirect(['context/list']);
		return;

	}

	/**
	 * actionAddMultipleComponents
	 * @access public
	 * @return void
	 */
	public function actionAddMultipleComponents() {
		Yii::log("actionAddMultipleComponents DesignController called", "trace", self::LOG_CAT);
		$component = new ComponentHead;
		$componentDetails = new ComponentDetails;
		//$currentDesignId = Yii::app()->session['surDesign']['id']; // Current selected design
		$settings = Yii::app()->tsettings;
		$risksurSettings = $settings->getSettings();
		$multipleRowsToShow = $risksurSettings->multipleComponentsRows;
		//$errorMessage = "";
		$errorStatus = "";

		$dataArray = [];
		$dataArray['formType'] = 'Create';
		$attributeArray = [];
		if (!empty(Yii::app()->session['surDesign'])) {
			$returnArray = self::getElementsAndDynamicAttributes([], true);
			//var_dump($returnArray); die;
			$elements = $returnArray['elements'];
			$model = new DesignForm();
			$model->setProperties($returnArray['dynamicDataAttributes']);
			$model->setAttributeLabels($returnArray['dynamicLabels']);
			$model->setRules($returnArray['dynamicRules']);

			// generate the components form
			$form = new CForm($elements, $model);
			$formHeader = new CForm($elements, $model);
			// ajax request to add a new row
			if ($form->submitted('DesignForm')) {
				//print_r($form->model); die;
				//$items=$this->getItemsToUpdate();
				if (isset($_POST['DesignForm'])) {
					$valid = true;
					foreach ($_POST['DesignForm'] as $i => $item) {
						$data = new DesignForm();
						$data->setProperties($returnArray['dynamicDataAttributes']);

						// generate the components form

						if (isset($_POST['DesignForm'][$i])) {
//									$data->attributes = $item; //$_POST['ComponentsForm'][$i];
							$data->setAttributes($item, false); //$_POST['ComponentsForm'][$i];
							$valid = $data->validate() && $valid;
							//add the models with attributes to the model array
							$postedModelArray[] = $data;
						}
					}
					//	die;
					if ($valid) { // all items are valid
						//print_r($form->getModel()); die();
						foreach ($_POST['DesignForm'] as $i => $item) {
							$data = new DesignForm();
							$data->setProperties($returnArray['dynamicDataAttributes']);
							//$data->attributes = $item;
							$data->setAttributes($item, false);

							$component->setIsNewRecord(true);
							$component->componentId = null;
							$component->componentName = $val = $data->componentName;
							$component->frameworkId = Yii::app()->session['surDesign']['id'];
							//save the componentHead values
							//var_dump($data); die;
							$component->save();
							$componentId = $component->componentId;
							// fetch the form data
							foreach ($item as $key => $val) {
								//ignore the attribute arrays
								if (!is_array($key) && !is_array($val)) {
									if ($key != "componentName") {
										$componentDetails->setIsNewRecord(true);
										$componentDetails->componentDetailId = null;
										$componentDetails->componentId = $componentId;
										$params = explode("_", $key);
										$componentDetails->subFormId = $params[1];
										$componentDetails->value = $val;
										$componentDetails->save();
									}
								}
							}
						}
						Yii::app()->user->setFlash('success', Yii::t("translation", "Components successfully created"));

						$this->redirect(['getDesignElements']);
					}
				}
			}
			// check if there was a post and the muliple forms are invalid
			$modelArray = [];
			for ($i = 0; $i < $multipleRowsToShow; $i++) {
				// number of model records to show by default on the view
				$modelArray[] = $model;
			}
			if (isset($_POST['DesignForm']) && !$valid) {
				$modelArray = $postedModelArray;
			}

			if (Yii::app()->request->isAjaxRequest && isset($_GET['index'])) {
				$this->renderPartial('_tabularInputAsTable', [
					'errorStatus' => $errorStatus,
					//'multipleRowsToShow' => $multipleRowsToShow,
					'elements'    => $elements,
					'dataArray'   => $dataArray,
					'model'       => $model,
					'form'        => $form,
					'index'       => $_GET['index']
				]);
				return;
			}
			//var_dump($formHeader->getElements()); die;
			$this->render('multipleComponent', [
				'errorStatus' => $errorStatus,
				//'multipleRowsToShow' => $multipleRowsToShow,
				'elements'    => $elements,
				'dataArray'   => $dataArray,
				'modelArray'  => $modelArray,
				'form'        => $form,
				'formHeader'  => $formHeader
			]);
			return;
		}
		Yii::app()->user->setFlash('notice', Yii::t("translation", "Please select a surveillance system first"));
		$this->redirect(['design/listComponents']);
		return;
	}

	public function actionEditMultipleComponents() {
		if (!empty(Yii::app()->session['surDesign'])) {
//			$getFormCondition = "tool=:design AND sectionNumber=:sectNo";
//			$getFormParams = [
//				':design'     => 'design AND showOnMultiForm=:showOnMulti',
//				':sectNo'     => '2.0',
//				'showOnMulti' => 1
//			];
			if(isset($_POST['DesignForm'])) {
				if(self::saveUpdatedComponents()) {
					Yii::app()->user->setFlash('success', 'Components successfully updated');
					$this->redirect('listComponents');
					return;
				}
				Yii::app()->user->setFlash('error', 'An error occurred while saving the components,' .
					' please try again or contact your administrator if this problem persists');

			}
			// Get components belonging to the selected surveillance system
			$componentCriteria = new CDbCriteria();
			$componentCriteria->with = ['compDetails', 'compData' => [
				'condition' => 'showOnMultiForm=:showOnMulti',
				'params' => [':showOnMulti' => 1]
			]
			];
			$componentCriteria->condition = 'frameworkId=:framework';
			$componentCriteria->params = [':framework' => Yii::app()->session['surDesign']['id']];
			$components = ComponentHead::model()->findAll($componentCriteria);
			if(is_null($components)) {
				Yii::app()->user->setFlash('notice', 'You need to create a component before you attempt to edit it');
				$this->redirect('listComponents');
				return;
			}
			$modelArray = [];
			$elements = ContextController::getDefaultElements();
			$tableHeader = '';
			foreach($components as $componentKey => $component) {
				$labels = [];
				$rules = [];
				$attributes = [];
				$componentInputName = 'componentName_' . $component->componentId;
				//$elements['elements'][$componentKey]['elements']['type'] = 'form';
				$elements['elements'][$componentKey]['elements'][$componentInputName] = [
					'label'    => 'Component Name',
					'required' => 1,
					'type'     => 'text'
				];
				$attributes[$componentInputName] = $component->componentName;
				$rules[] = [$componentInputName, 'required'];
				$labels[$componentInputName] = 'Component Name';
				foreach($component->compData as $componentElement) {
					$elementInputName = $componentElement->inputName . '_' . $componentElement->subFormId;
					$elements['elements'][$componentKey]['elements'][$elementInputName] = [
						'label'    => $componentElement->label,
						//'required' => 1,
						'type'     => $componentElement->inputType
					];
					if (!empty($componentElement->description)) {
						$elements['elements'][$componentKey]['elements'][$elementInputName]['title'] = UtilModel::urlToLink($componentElement->description);
					}
					$attributes[$elementInputName] = '';
					$rules[] = [$elementInputName, $componentElement->required ? 'required' : 'safe'];
					$labels[$elementInputName] = $componentElement->label;
					if($componentElement->inputType == 'dropdownlist') {
						$elements['elements'][$componentKey]['elements'][$elementInputName]['items'] = CHtml::listData(
							Options::model()
								->findAll('componentId=:component', [':component' => $componentElement->subFormId]),
							'optionId', 'label'
						);
					}
					foreach($component->compDetails as $componentData) {
						if($componentElement->subFormId == $componentData->subFormId) {
							$attributes[$elementInputName] = $componentData->value;
							break;
						}
					}
				}
				$modelArray[$componentKey] = new DesignForm();
				$modelArray[$componentKey]->setProperties($attributes);
				$modelArray[$componentKey]->setRules($rules);
				$modelArray[$componentKey]->setAttributeLabels($labels);
				if(empty($tableHeader)) {
					$tableHeader = '<td>' . implode('</td><td>', $labels) . '</td>';
				}

			}

			$this->render('editMultipleComponents', [
				'tableHeader' => $tableHeader,
				'elements'    => $elements,
				//'dataArray'   => $dataArray,
				'modelArray'  => $modelArray,
				//'form'        => $form,
				//'formHeader'  => $formHeader
			]);
			return;

		}
		Yii::app()->user->setFlash('notice', Yii::t("translation", "Please select a surveillance system first"));
		$this->redirect(['listComponents']);
		return;
	}

	private function saveUpdatedComponents() {
		$transaction = Yii::app()->db->beginTransaction();
		try {
			foreach($_POST['DesignForm'] as $component) {
				foreach($component as $elementKey => $elementData) {
					$elementParts = explode('_', $elementKey);
					echo $elementKey;// die;
					$compHead = new ComponentHead();
					if($elementParts[0] == 'componentName') {
						$compHead->componentName = $elementData;
						$compHead->componentId = $elementParts[1];
						$compHead->setIsNewRecord(false);
						$compHead->save();
						//print_r($compHead->componentId); die('lklkl');
					}
					$compDetails = ComponentDetails::model()->findAll('componentId=' . $elementParts[1]);
					foreach($compDetails as $componentData) {
						if($componentData->subFormId == $elementParts[1]) {
							$componentData->value = $elementData;
							$componentData->save();
							break;
						}
					}

				}
			}
			$transaction->commit();
			return true;
		} catch( Exception $e) {
			$transaction->rollBack();
			Yii::log('Error while updating component ' . $e->getMessage());
			return false;
		}
	}

	public function actionReports($system = null) {
		$systemDropdown = CHtml::listData(FrameworkContext::model()
				->findAll('userId=:userId', [':userId' => Yii::app()->user->id]), 'frameworkId', 'name');

//		$model = new DesignForm();
//		$model->setPropertyName('systemSelect', '');
//		$model->setAttributeLabels(['systemsSelect' => 'Surveillance system']);
//		$model->setRules([['systemSelect', 'required']]);
//		$form = new CForm($elements, $model);
		$reportData = [];
		if($system !== null) {

			$rsFramework = FrameworkContext::model()
				->with(['fields' => [ 'condition' => "inputName='hazardName' OR inputName='survObj'"]])
				->findByPk($system);
			if($rsFramework !== null) {
				$reportData[] = ['Surveillance system', $rsFramework->name, 'Surveillance System'];
				$specialInputTypes = array_flip(['dropdownlist', 'checkboxlist', 'radiolist']);
				foreach($rsFramework->fields as $surField) {
					foreach($rsFramework->data as $surData) {
						if($surData->frameworkFieldId == $surField->id) {
							$fieldValue = $surData->value;
							$fieldLabel = 'Hazard name';
							if(isset($specialInputTypes[$surField->inputType])) {
								$fieldLabel = 'Surveillance objective';
								$fieldValue = Options::model()->findByPk($surData->value, ['select' => 'optionId, label'])->label;
							}
							$reportData[] = [$fieldLabel, $fieldValue, 'Surveillance System'];
							break;
						}
					}
				}
				$rsDesign = ComponentHead::model()
					->with('compData', 'compDetails')
					->findAll('frameworkId=:framework', [':framework' => $system]);
				if($rsDesign !== null) {
					foreach($rsDesign as $design) {
						$reportData[] = ['Component name', $design->componentName, $design->componentName];
						foreach($design->compData as $designField) {
							foreach($design->compDetails as $designData) {
								if($designField->subFormId == $designData->subFormId) {
									$fieldValue = $designData->value;
									$fieldLabel = isset($designField->label) ?
										$designField->label : ComponentHead::model()->generateAttributeLabel($designField->inputName);
									if(isset($specialInputTypes[$designField->inputType])) {
//										$fieldLabel = 'Surveillance objective';
										$option = Options::model()->findByPk($designData->value, ['select' => 'optionId, label']);
										//print_r($option); echo "\n";
										$fieldValue = isset($option) ? $option->label : '';
									}
									$reportData[] = [$fieldLabel, $fieldValue, $design->componentName];
									break;
								}

							}
						}
					}
				}

			}
			echo json_encode(['aaData' => $reportData], JSON_PRETTY_PRINT);
			return;
		}
		$this->render('reports', ['systemDropdown' => $systemDropdown]);
	}


	public function actionGetDesignData($componentId, $componentName) {
		$rsDesignData = SurveillanceSections::model()
			->with('designFields', 'designData')
//			->findAll("designData.componentId=$componentId OR designData.componentId is NULL");
			->findAll("tool='design'");
		//print_r($rsDesignData); die;
		$model = new DesignForm();
		$sectionTwo =[];
		$elements = ContextController::getDefaultElements();
		$elements['activeForm']['id'] = 'DesignForm';
		$elements['showErrors'] = false;
		$properties = [];
		$properties['propertyNames'] = [];
		preg_match('/(\[\w*\])?\[(\w*)\]/', $componentName, $matches);
		$indexString = $matches[1];

		foreach($rsDesignData as $section) {
			if($section->sectionNumber == '2.0') {
				foreach($section->designFields as $sectionField) {
					$sectionTwo[$sectionField->inputName] = $sectionField;
					foreach($section->designData as $sectionData) {
						if($sectionData->subFormId == $sectionField->subFormId &&
							$componentId == $sectionData->componentId) {
							//print_r($sectionField); die;
							$sectionTwo[$sectionField->inputName]->value = $sectionData->value;
						}
					}
				}

				continue;
			}

			if(isset($section->designFields[0])) {
				//print_r($section); die;
				foreach($section->designFields as $designField) {
					$fieldName = "$indexString" . $designField->inputName . '_' . $designField->subFormId;
					$property = $designField->inputName . '_' . $designField->subFormId;
					$properties['propertyNames'][$property] = '';
					if(isset(CFormInputElement::$coreTypes[$designField->inputType])) {
						$properties['propertyLabels'][$fieldName] = $designField->label;
						$properties['rules'][] = [$fieldName, $designField->required ? 'required' : 'safe'];
					}
					if ($designField->inputType == 'label') {
						$elements['elements'][] = CHtml::tag('div', ['class' => 'surHeading'], $designField->label);
						continue;
					}
					if (isset($this->displayItems[$designField->inputName])) {
						switch ($this->displayItems[$designField->inputName]['type']) {
							case 'field':
								$elements['elements'][] = CHtml::tag('span', ['class' => $designField->inputName],
									$sectionTwo[$this->displayItems[$designField->inputName]['name']]->label .
									': ' . $sectionTwo[$this->displayItems[$designField->inputName]['name']]->value);
								break;
							case 'string':
								$elements['elements'][] = CHtml::tag('span', [],
									$this->displayItems[$designField->inputName]['name']);
								break;

						}
					}
					$elements['elements'][$fieldName] = [
						'label'    => $designField->label,
						'required' => $designField->required,
						'type'     => $designField->inputType,
					];
					foreach($section->designData as $fieldData) {

						if($designField->subFormId == $fieldData->subFormId &&
							$componentId == $fieldData->componentId) {
							$properties['propertyNames'][$property] = $fieldData->value;

						}
					}
				}
			}
		}
		$model->setProperties($properties['propertyNames']);
		$model->setAttributeLabels($properties['propertyLabels']);
		$model->setRules($properties['rules']);
		$form = new CFormTabular($elements, $model, null, trim($indexString, '[, ]'));
//		print_r($form->render()); die;
//		print_r($elements); die;
		echo json_encode(['formData' => $form->renderElements(), 'index' => $indexString]);
		return;

	}

	public function actionGetDesignElements() {
		$designSectionsCriteria = new CDbCriteria();
		$designSectionsCriteria->condition = "tool='design'";
		$rsDesignSections = SurveillanceSections::model()->with('designFields')->findAll($designSectionsCriteria);
		//print_r($rsDesignSections); die;
		$elements = ContextController::getDefaultElements();
		$elements['activeForm']['id'] = 'DesignForm';
		$properties = [];
		$elements['elements'][] = CHtml::tag('div', ['class' => 'accStyle'], false, false);

		$randomIds = [];
		foreach($rsDesignSections as $sectionKey => $section) {
			if($section->sectionNumber == '2.0') {
//				foreach($section->designFields as $sectionField) {
//					$sectionTwo[$sectionField->inputName] = $sectionField;
//				}

				continue;
			}
			if($section->sectionNumber * 10 % 10 == 0) {
				$elements['elements'][] = CHtml::tag('h3', [], $section->sectionNumber . ' ' . $section->sectionName);
				$randomId = rand(0, 100);
				$randomIds[] = $randomId;
				$elements['elements'][] = CHtml::tag('div', [], $section->description, false);
				$elements['elements'][] = CHtml::tag('p', [], false);
				$elements['elements'][] = CHtml::link('Add component', '#', [
					'id' => 'copyLink-' . $randomId,
					'class' => ' btn',
					'rel' => '.desCopy' . $randomId
				]);
				$elements['elements'][] = CHtml::tag('fieldset', ['class' => 'desCopy' . $randomId], false, false);

				$elements['elements']['[0]component'] = [
					'label'    => 'Component Name',
					'type'     => 'dropdownlist',
					'class'     => 'componentList',
					'items' => CHtml::listData(ComponentHead::model()->findAll('frameworkId=' .
						Yii::app()->session['surDesign']['id']), 'componentId', 'componentName'),
					'prompt' => 'Select component'
				];
				$properties['propertyNames']['component'] = '';
				$properties['propertyLabels']['component'] = 'Component Name';
				$properties['rules'][] = ['component', 'required'];


			}
			//print_r($displayItems); die;


			//if($section->sectionNumber * 10 % 10 == 0 && $sectionNo !=) {
				$elements['elements'][] = CHtml::closeTag('fieldset');
				$elements['elements'][] = CHtml::closeTag('div');
			//}


		}
		$elements['elements'][] = CHtml::closeTag('div');
		$elements['buttons'] = [
			'save' => [
				'label' => 'Save',
				'type' => 'submit',
			]
		];

		$model = new DesignForm();
		$model->setProperties($properties['propertyNames']);
		$model->setAttributeLabels($properties['propertyLabels']);
		$model->setRules($properties['rules']);
		$form = new CFormTabular($elements, $model, null, 0);
		if($form->submitted('save')) {
			if(self::saveComponents()) {
				Yii::app()->user->setFlash('success', 'Component data saved successfully');
			} else {
				Yii::app()->user->setFlash('error', 'An error occurred while saving the component data, ' .
					'please try again or contact your administrator if the problem persists');
			}
		}
		//print_r($model);
		//echo $form->render(); die;
		$this->render('framework', compact('form', 'randomIds'));
	}

	private function saveComponents() {

		$subFormIds = [];
		$componentId = null;
		$transaction = Yii::app()->db->beginTransaction();
		try{
			foreach($_POST['DesignForm'] as $componentData) {
				//print_r($_POST); die;
				foreach($componentData as $element => $value) {
					if($element == 'component') {
						$componentId = $value;
						continue;
					}
					$elementArray = explode('_', $element);
					$model = new ComponentDetails();
					$model->unsetAttributes();
					$model->componentId = $componentId;
					$model->subFormId = $elementArray[1];
					$model->value = $value;
					$existCriteria = new CDbCriteria();
					$existCriteria->condition = 'componentId=' . $model->componentId;
					$existCriteria->addCondition('subFormId=' . $model->subFormId);
					$existCriteria->select = 'componentDetailId';
					//print_r(ComponentDetails::model()->find($existCriteria)); die;
					$rsDataExists = ComponentDetails::model()->find($existCriteria);
					$model->componentDetailId = isset($rsDataExists->componentDetailId) ?
						$rsDataExists->componentDetailId : null;
					$model->setIsNewRecord(isset($model->componentDetailId) ? false : true);
					$subFormIds[] = $model->subFormId;
					//print_r($model); die;
					$model->save();
				}
//				$deleteCriteria = new CDbCriteria();
//				$deleteCriteria->condition = 'componentId=' . $model->componentId;
//				$deleteCriteria->addNotInCondition('subFormId=' . $model->subFormId);
//				ComponentDetails::model()->deleteAll($deleteCriteria);
			}
			$transaction->commit();
			return true;
		} catch(Exception $e) {
			$transaction->rollBack();
			return false;
		}
	}

	/**
	 * actionAddNewMultiRow
	 * @access public
	 * @return void
	 * @throws exception
	 */
	public function actionAddNewMultiRow() {
		if (Yii::app()->request->isAjaxRequest && isset($_GET['index'])) {
			$this->getController()->renderPartial($this->viewName, [
				'model' => $this->getModel(),
				'index' => $_GET['index']
			]);
		} else {
			throw new CHttpException(400, 'Invalid request. Please do not repeat this request again.');
		}
	}


	/**
	 * getElementsAndDynamicAttributes
	 * @param array $componentData
	 * @param bool $multiForm
	 * @return array
	 */
	private function getElementsAndDynamicAttributes($componentData = [], $multiForm = false) {
		$elements = [];
		$attributeArray = [];
		$dynamicDataAttributes = [];
		$dynamicLabels = [];
		$dynamicRules = [];
		if (!empty(Yii::app()->session['surDesign'])) {
			$getFormCondition = "tool=:design AND sectionNumber=:sectNo";
			$getFormParams = [
				':design' => 'design',
				':sectNo' => '2.0'
			];
			// show only the elements where showOnMultiForm = true for multi form layout
			if ($multiForm) {
				$getFormCondition .= ' AND showOnMultiForm=:showOnMulti';
				$getFormParams['showOnMulti'] = 1;
			}
			$getForm = SurveillanceSections::model()->with('designFields')->find([
				//'select' => 'pageId, pageName',
				'condition' => $getFormCondition,
				'params'    => $getFormParams
			]);
//			if (!empty(Yii::app()->session['performanceAttribute'])) {
//				$attributeList = AttributeFormRelation::model()->findAll([
//					'condition' => 'attributeId=:attributeId',
//					'params'    => [
//						':attributeId' => Yii::app()->session['performanceAttribute']['id'],
//					],
//				]);
//				foreach ($attributeList as $attrs) {
//					$attributeArray[$attrs->subFormId] = $attrs->subFormId;
//				}
//			}
			$elements['title'] = "Components Form";
			$elements['showErrorSummary'] = true;
			$elements['showErrors'] = true;
			$elements['errorSummaryHeader'] = Yii::app()->params['headerErrorSummary'];
			$elements['errorSummaryFooter'] = Yii::app()->params['footerErrorSummary'];

			$elements['activeForm'] =
				[
					'id' => "DesignForm",
					'class' => 'CActiveForm',
					'enableClientValidation' => true,
					'enableAjaxValidation' => true,
					'clientOptions' => [
						'validateOnSubmit' => true,
					]
			];
			//print_r($getForm); die();
			$components = $getForm->designFields;
			$dataArray['getForm'] = $components;
			// add componentName form element
			$dynamicDataAttributes['componentName'] = '';
			$dynamicLabels['componentName'] = "Component Name";
			//$elements['elements']['type'] = 'form';
			$elements['elements']['componentName'] = [
				'label'    => "Component Name",
				'required' => true,
				'type'     => 'text',
			];
			$dynamicRules[] = ['componentName','required'];

			// hide the label for multiple form layout
			$elements['elements']['componentName']['layout'] = '{label} {input} {hint} {error}';
			if ($multiForm) {
				$elements['elements']['componentName']['layout'] = '{input} {hint} {error}';
			}
			foreach ($components as $valu) {
				$attributeId = $valu->inputName . "_" . $valu->subFormId;
				$dynamicRules[] = [$attributeId, $valu->required ? 'required' : 'safe'];
				//set the model attribute array
				$dynamicDataAttributes[$attributeId] = '';
				$dynamicLabels[$attributeId] = $valu->label;

				$hightlightClass = "";
				if (isset($attributeArray[$valu->subFormId])) {
					$hightlightClass = "attributeHighlight";
				}
				// add the elements to the CForm array
				$elements['elements'][$attributeId] = [
					'label'    => $valu->label,
					'required' => $valu->required,
					'type'     => $valu->inputType,
					'class'    => $hightlightClass,
					'data-field' => $valu->subFormId
				];
				// hide the label for multiple form layout
				if ($multiForm) {
					$elements['elements'][$attributeId]['layout'] = '{input} {hint} {error}';
				}
				if (!empty($valu->description)) {
					$elements['elements'][$attributeId]['title'] = UtilModel::urlToLink($valu->description);
				}

				// add the values to the form
				//if (!empty($componentData[$attributeId])) {
				//$elements['elements'][$attributeId]['value'] = $componentData[$attributeId]['value'];
				//}
				// add the component name element value
				//if (!empty($componentData['componentName'])) {
				//$elements['elements']['componentName']['value'] = $componentData['componentName'];
				//}
				//add the dropdown parameters
				if ($valu->inputType == 'dropdownlist') {

					// add the dropdown items to the element
					$elements['elements'][$attributeId]['items'] = CHtml::listData(Options::model()->findAll([
						'condition' => 'componentId=:componentId',
						'params'    => [
							':componentId' => $valu->subFormId
						],
					]), 'optionId', 'label');
					$elements['elements'][$attributeId]['prompt'] = 'Select one';
				}
			}
			$elements['buttons'] = [
				'newComponent' => [
					'type'  => 'submit',
					'label' => 'Create Component',
				],
			];
		}
		$returnArray = [
			'elements' => $elements,
			'dynamicDataAttributes' => $dynamicDataAttributes,
			'dynamicLabels' => $dynamicLabels,
			'dynamicRules' => $dynamicRules
		];
		return $returnArray;
	}

	/**
	 * actionEditComponent
	 * @access public
	 * @return void
	 */
	public function actionEditComponent() {
		Yii::log("actionEditComponent DesignController called", "trace", self::LOG_CAT);
		$component = new ComponentHead;
		$componentDetails = new ComponentDetails;
		$dataArray = [];
		$dataArray['formType'] = 'Edit';
		$model = new DesignForm();
		$attributeArray = [];
		if (empty($_GET['id'])) {
			Yii::app()->user->setFlash('error', Yii::t("translation", "Please select a component to edit"));
			$this->redirect(['design/listComponents']);
		}
		if (!empty(Yii::app()->session['surDesign'])) {
			//fetch the form data
			$fetchComponentData = Yii::app()->db->createCommand()
				->select('cd.componentDetailId, cd.componentId, cd.subFormId, cd.value, sd.inputName,
				sd.inputType,ch.componentName, op.optionId, op.label')
				->from('componentDetails cd')
				->join('surFormDetails sd', 'sd.subFormId = cd.subFormId')
				->join('componentHead ch', 'ch.componentId = cd.componentId')
				->leftJoin('options op', 'op.componentId = sd.subFormId')
				->where('cd.componentId =' . $_GET['id'])
				->queryAll();
			//print_r($fetchComponentData);
			//arrange data in array
			$componentData = [];

			$returnArray = self::getElementsAndDynamicAttributes();
			$returnArray['elements']['buttons'] = [
				'updateComponent' => [
					'type'  => 'submit',
					'label' => 'Update component',
				],
			];
			$elements = $returnArray['elements'];
			//$model = new ComponentsForm;
			$model->setProperties($returnArray['dynamicDataAttributes']);
			$model->setAttributeLabels($returnArray['dynamicLabels']);
			$model->setRules($returnArray['dynamicRules']);

			// update the model with the data values and add id
			foreach ($fetchComponentData as $dat) {
				$compKey = $dat['inputName'] . "_" . $dat['subFormId'];
				$componentData[$compKey] = [
					'value' => $dat['value'],
					'id'    => $dat['componentDetailId']
				];
				$model->{$compKey} = $dat['value'];
				// add the component name to the array as well but just once
				if (empty($componentData['componentName'])) {
					$componentData['componentName'] = $dat['componentName'];
					$model->componentName = $dat['componentName'];
				}
			}
			//var_dump($model, $fetchComponentData); die;

			// generate the components form
			$form = new CForm($elements, $model);
			if(Yii::app()->getRequest()->getIsAjaxRequest()) {
				echo CActiveForm::validate( [$model]);
				Yii::app()->end();
			}
			//validate and save the component data
			if ($form->submitted('DesignForm') && $form->validate()) {
				//print_r($form->getModel()); die();
				$component->setIsNewRecord(false);
				$component->componentName = $form->model->componentName;
				$component->frameworkId = Yii::app()->session['surDesign']['id'];
				$component->componentId = $_GET['id'];
				//save the componentHead values
				$component->save();
				$form->model->unsetProperties(['componentName']);
				//var_dump($form->model); die;
				$componentId = $_GET['id'];
				// fetch the form data
				foreach ($form->model as $key => $val) {
					$componentDetails = new ComponentDetails();
					// record found edit record
					if (!empty($componentData[$key])) {
						$componentDetails->setIsNewRecord(false);
						$componentDetails->componentDetailId = $componentData[$key]['id'];
						$componentDetails->componentId = $componentId;
						$componentDetails->value = $val;
						$componentDetails->save(false);
						// record not found add new record
					} else {
						$componentDetails->setIsNewRecord(true);
						$componentDetails->componentDetailId = null;
						$componentDetails->componentId = $componentId;
						$params = explode("_", $key);
						$componentDetails->subFormId = $params[1];
						$componentDetails->value = $val;
						$componentDetails->save();

					}
				}
				Yii::app()->user->setFlash('success', Yii::t("translation", "Component successfully updated"));
				$this->redirect(['getDesignElements']);
			}
			$this->render('component', [
				'model'     => $model,
				'dataArray' => $dataArray,
				'form'      => $form
			]);
		}
	}


	/**
	 * actionListComponents
	 * @access public
	 * @return void
	 */
	public function actionListComponents($getComponents = null) {
		Yii::log("actionListComponents DesignController called", "trace", self::LOG_CAT);
		//$model = new ComponentHead;
		$dataArray = [];
		$dataArray['componentList'] = json_encode([]);
		$dataArray['dtHeader'] = "Components List";
		$componentListArray = [];
		$formDetailsArray = [];

		if (!empty(Yii::app()->session['surDesign'])) {
			$componentData = self::getComponentData();
			$componentListArray = $componentData['componentListArray'];
			$formDetailsArray = $componentData['formDetailsArray'];
		}

		//print_r($componentListArray); die();

		$dataArray['componentList'] = json_encode($componentListArray);
		// return ajax json data
		if (isset($getComponents)) {
			$jsonData = json_encode(["aaData" => $componentListArray]);
			echo $jsonData;
			return;
		}
		$surveillanceSystems = CHtml::listData(FrameworkContext::model()->findAll([
			'condition' => 'userId=:userId',
			'select' => 'frameworkId, name',
			'params' => [
				':userId' => Yii::app()->user->id
			]
		]), 'frameworkId', 'name');
		$this->render('componentList', [
			//'model' => $model,
			'dataArray'    => $dataArray,
			'columnsArray' => $formDetailsArray,
			'surveillanceSystems' => $surveillanceSystems
		]);
	}


	public static function getComponentData($componentsOnly = false) {
		$componentListArray = [];
		$formDetailsArray = [];
		// get list of surveillance designs
		$componentList = ComponentHead::model()->with("compDetails")->findAll([
			//'select' => 'pageId, pageName',
			'condition' => 'frameworkId=:frameworkId',
			'params'    => [
				':frameworkId' => Yii::app()->session['surDesign']['id'],
			],
		]);
		$formDetails = SurFormDetails::model()->findAll([
			//'select' => 'pageId, pageName',
			'condition' => 'showOnComponentList=:showOnList',
			'params'    => [
				':showOnList' => true,
			],
		]);
		$selectOptions = CHtml::listData(Options::model()->findAll([
			'condition' => 'componentId IS NOT NULL'
		]), 'optionId', 'label');


		//print_r($selectOptions); die;

		// format dataTable data
		$count = 0;
		foreach ($componentList as $com) {
			$componentListArray[$count] = [
				'componentId'  => $com->componentId,
				'frameworkId'  => $com->frameworkId,
				'name'          => $com->componentName,
				'targetSpecies' => '',
				'targetSector' => '',
				'dataColPoint' => '',
				'diseaseType'  => '',
				'sampleType'   => '',
				'studyType'   => '',
			];
			foreach ($formDetails as $formInput) {
				$formDetailsArray[$formInput->inputName] = $formInput->label;
				foreach ($com->compDetails as $data) {
					//$subDetails[$data->inputName] = $data->value;
					if($formInput->subFormId == $data->subFormId) {
						$componentListArray[$count][$formInput->inputName] = $data->value;
						if ($formInput->inputType == "dropdownlist" && isset($selectOptions[$data->value])) {
							$componentListArray[$count][$formInput->inputName] = $selectOptions[$data->value];
						}

					}

				}
			}
			$count++;

		}
		return $componentsOnly ? $componentListArray : [
			'componentListArray' => $componentListArray,
			'formDetailsArray' => $formDetailsArray
		];
	}

	/**
	 * actionDeleteComponent
	 * @access public
	 * @return void
	 */
	public function actionDeleteComponent() {
		Yii::log("actionDeleteComponent called", "trace", self::LOG_CAT);
		if (isset($_GET["id"])) {
			$record = ComponentHead::model()->findByPk($_GET['id']);
			if (!$record->delete()) {
				Yii::log("Error Deleing user:" . $_GET['id'], "warning", self::LOG_CAT);
				//echo $errorMessage;
				echo Yii::t("translation", "A problem occured when deleting the component") ;
			} else {
				echo Yii::t("translation", "The component has been successfully deleted");
			}
		}
		return;
	}

	/**
	 * actionDuplicateComponent
	 * @access public
	 * @return void
	 */
	public function actionDuplicateComponent() {
		Yii::log("actionDuplicateComponent called", "trace", self::LOG_CAT);
		if (isset($_POST["oldComponentId"]) && $_POST['newComponentName']) {
			$component = new ComponentHead;
			$componentDetails = new ComponentDetails;
			$record = ComponentHead::model()->with("compDetails")->findByPk($_POST['oldComponentId']);
			$component->componentName = $_POST['newComponentName'];
			$component->frameworkId = isset($_POST['oldComponentId']) ?
				$_POST['oldComponentId']: Yii::app()->session['surDesign']['id'];
			//save the componentHead values
			$component->save();
			$componentId = $component->componentId;
			// fetch the old component details data and save as new components
			foreach ($record->compDetails as $val) {
				$details = $val->attributes;
				$componentDetails->setIsNewRecord(true);
				$componentDetails->componentDetailId = null;
				$componentDetails->componentId = $componentId;
				$componentDetails->subFormId = $details['subFormId'];
				$componentDetails->value = $details['value'];
				$componentDetails->save();
				//echo $key . "=>" . $val ."<br>";
				//print_r($details['subFormId']);
			}
			echo Yii::t("translation", "Component successfully duplicated");
		} else {
			Yii::log("Error duplicating component id:" . $_POST['oldComponentId'], "warning", self::LOG_CAT);
			echo Yii::t("translation", "A problem occurred when duplicating the component ");
		}
		return;
	}

	/**
	 * performAjaxValidation
	 * @param mixed $model
	 * @access protected
	 * @return void
	 */
	protected function performAjaxValidation($model) {
		if (isset($_POST['ajax']) && $_POST['ajax'] === 'DesignForm') {
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}
	}

	/**
	 * actionGetComponentMenu
	 * @access public
	 * @return void
	 */
	public function actionGetComponentMenu() {
		if (!empty($_GET['parentId'])) {
			$this->renderPartial('componentMenu', [
				'parentId' => $_GET['parentId']
			], false, true);
		}
	}

	/**
	 * actionFetchComponents
	 * @access public
	 * @return void
	 */
	public function actionFetchComponents() {
		Yii::log("actionFetchComponents DesignController called", "trace", self::LOG_CAT);

		$postData = $_POST;
		$data = GoalData::model()->findAll([
			'select'    => 'pageId, pageName',
			'condition' => 'parentId=:parentId',
			'params'    => [
				':parentId' => $postData['FrameworkContext']['goalId'],
			],
		]);

		$data = CHtml::listData($data, 'pageId', 'pageName');
		//print_r($data);
		foreach ($data as $value => $name) {
			echo CHtml::tag('option',
				['value' => $value], CHtml::encode($name), true);
		}
	}
}
