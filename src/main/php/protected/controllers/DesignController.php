<?php

	/**
	 * DesignController
	 *
	 * @package
	 * @author    Chirag Doshi <chirag@tracetracker.com>
	 * @copyright Tracetracker
	 * @version   $id$
	 * @uses      Controller
	 * @license   Tracetracker {@link http://www.tracetracker.com}
	 */
	class DesignController extends Controller {
		const LOG_CAT = "ctrl.DesignController";
		//Use layout 
		public $layout = '//layouts/column2';

		/**
		 * filters
		 *
		 * @access public
		 * @return void
		 */
		public function filters() {
			Yii::log("filters called", "trace", self::LOG_CAT);
			return array(
				array(
					'application.filters.RbacFilter',
				),
			);
		}

		/**
		 * actionIndex
		 *
		 * @access public
		 * @return void
		 */
		public function actionIndex() {
			Yii::log("actionIndex DesignController called", "trace", self::LOG_CAT);
			$model = new NewDesign;
			$dataArray = array();
			$dataArray['dtHeader'] = "Surveillance design List";
			$dataArray['surveillanceList'] = json_encode(array());
			$this->performAjaxValidation($model);

			if (isset($_POST['NewDesign'])) {
				$model->attributes = $_POST['NewDesign'];
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
			$surveillanceList = NewDesign::model()->with("goal")->findAll(array(
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
					CController::createUrl('design/editDesign/', array(
							'designId' => $sur->frameworkId
						)
					) .
					"'\">Edit</button>";
				$deleteButton = "<button id='deleteDesign" . $sur->frameworkId .
					"' type='button' class='bdelete' onclick=\"$('#deleteBox').dialog('open');" .
					"deleteConfirm('" . $sur->name . "', '" .
					$sur->frameworkId . "')\">Remove</button>";
				//}
				$surveillanceListArray[] = array(
					'frameworkId' => $sur->frameworkId,
					'name' => $sur->name,
					'userId' => $sur->userId,
					'description' => $sur->description,
					'goalId' => $sur->goalId,
					'goalName' => $sur->goal->pageName,
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
			// print_r($dataArray['surveillanceList']);die();
			// fetch the goal dropdown data
			$goalDropDown = GoalData::model()->findAll(array(
				'select' => 'pageId, pageName',
				'condition' => 'parentId=:parentId AND pageName<>:pageName',
				'params' => array(
					':parentId' => 0,
					':pageName' => 'noMenu'
				),
			));
			// create array options for goal dropdown
			foreach ($goalDropDown as $data) {
				$dataArray['goalDropDown'][$data->pageId] = $data->pageName;
			}
			$this->render('index', array(
				'model' => $model,
				'dataArray' => $dataArray
			));
		}

		/**
		 * actionShowDesign
		 *
		 * @access public
		 * @return void
		 */
		public function actionShowDesign() {
			Yii::log("actionShowDesign DesignController called", "trace", self::LOG_CAT);
			$model = new NewDesign;
			$dataArray = array();
			if (isset($_GET['designId'])) {
				$selectedDesign = NewDesign::model()->with("goal")->findAll(array(
					//'select' => 'pageId, pageName',
					'condition' => 'frameworkId=:frameworkId AND userId=:userId',
					'params' => array(
						':frameworkId' => $_GET['designId'],
						':userId' => Yii::app()->user->id,
					),
				));
				$dataArray['selectedDesign'] = $selectedDesign;
				//add the surveilance design to the session
				if (count($selectedDesign) == 1) {
					Yii::app()->session->add('surDesign', array(
						'id' => $_GET['designId'],
						'name' => $selectedDesign[0]->name,
						'goalId' => $selectedDesign[0]->goalId
					));
				} else {
					Yii::app()->session->remove('surDesign');
				}
				//print_r($selectedDesign);
				//print_r($_SESSION);
			}

			$this->render('showDesign', array(
				'model' => $model,
				'dataArray' => $dataArray
			));
		}

		/**
		 * actionShowComponent
		 *
		 * @access public
		 * @return void
		 */
		public function actionShowComponent() {
			Yii::log("actionShowComponent DesignController called", "trace", self::LOG_CAT);
			$dataArray = array();
			$dataArray['selectedComponent'] = array();
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
					};
					// add the component name to the array as well but just once
					if (empty($dataArray['selectedComponent']['Component Name'])) {
						$dataArray['selectedComponent']['Component Name'] = $dat['componentName'];
					}
				}
			}

			$this->render('showComponent', array(
				//'model' => $model,
				'dataArray' => $dataArray
			));
		}

		/**
		 * actionCreateDesign
		 *
		 * @access public
		 * @return void
		 */
		public function actionCreateDesign() {
			Yii::log("actionCreateDesign DesignController called", "trace", self::LOG_CAT);
			$model = new NewDesign;
			$dataArray = array();
			$dataArray['formType'] = "Create";
			$this->performAjaxValidation($model);

			if (isset($_POST['NewDesign'])) {
				$model->attributes = $_POST['NewDesign'];
				$model->userId = Yii::app()->user->id;

				//validate and save the design
				if ($model->validate("create")) {
					$model->save(false);
					Yii::app()->session->add('surDesign', array(
						'id' => $model->frameworkId,
						'name' => $model->name,
						'goalId' => $model->goalId
					));
					Yii::app()->user->setFlash('success', Yii::t("translation", "Design successfully created"));
					$this->redirect(array('index'));
				}
			}
			// fetch the goal dropdown data
			$goalDropDown = GoalData::model()->findAll(array(
				'select' => 'pageId, pageName',
				'condition' => 'parentId=:parentId AND pageName<>:pageName',
				'params' => array(
					':parentId' => 0,
					':pageName' => 'noMenu'
				),
			));
			// create array options for goal dropdown
			foreach ($goalDropDown as $data) {
				$dataArray['goalDropDown'][$data->pageId] = $data->pageName;
			}
			$this->render('createDesign', array(
				'model' => $model,
				'dataArray' => $dataArray
			));
		}

		/**
		 * actionAddComponent
		 *
		 * @access public
		 * @return void
		 */
		public function actionAddComponent() {
			Yii::log("actionAddComponent DesignController called", "trace", self::LOG_CAT);
			$component = new ComponentHead;
			$componentDetails = new ComponentDetails;
			$dataArray = array();
			$dataArray['formType'] = 'Create';
			//$attributeArray = array();
			//print_r(Yii::app()->session['surDesign']);
			if (!empty(Yii::app()->session['surDesign'])) {
				$returnArray = self::getElementsAndDynamicAttributes();
				$elements = $returnArray['elements'];
				$model = new ComponentsForm;
				$model->_dynamicFields = $returnArray['dynamicDataAttributes'];
				// generate the components form
				$form = new CForm($elements, $model);
				//validate and save the component data
				if ($form->submitted('ComponentsForm') && $form->validate()) {
					//print_r($form->getModel()); die();
					$component->componentName = $val = $form->model->componentName;
					$component->frameworkId = Yii::app()->session['surDesign']['id'];
					//save the componentHead values
					$component->save();
					$componentId = $component->componentId;
					// fetch the form data
					foreach ($form->model as $key => $val) {
						//ignore the attribute arrays
						if (!is_array($key) && !is_array($val)) {
							if ($key != "componentName") {
								$componentDetails->setIsNewRecord(true);
								$componentDetails->componentDetailId = null;
								$componentDetails->componentId = $componentId;
								$params = explode("-", $key);
								$componentDetails->subFormId = $params[1];
								$componentDetails->value = $val;
								$componentDetails->save();
							}
						}
					}
					Yii::app()->user->setFlash('success', Yii::t("translation", "Component successfully created"));
					$this->redirect(array('listComponents'));
				}
			}

			$this->render('component', array(
				'model' => $model,
				'dataArray' => $dataArray,
				'form' => $form
			));
		}

		/**
		 * actionAddMultipleComponents
		 *
		 * @access public
		 * @return void
		 */
		public function actionAddMultipleComponents() {
			Yii::log("actionAddMultipleComponents DesignController called", "trace", self::LOG_CAT);
			$component = new ComponentHead;
			$componentDetails = new ComponentDetails;
			$currentDesignId = Yii::app()->session['surDesign']['id']; // Current selected design
			$settings = Yii::app()->tsettings;
			$risksurSettings = $settings->getSettings();
			$multipleRowsToShow = $risksurSettings->multipleComponentsRows;
			$errorMessage = "";
			$errorStatus = "";

			$dataArray = array();
			$dataArray['formType'] = 'Create';
			$attributeArray = array();
			if (!empty(Yii::app()->session['surDesign'])) {
				$returnArray = self::getElementsAndDynamicAttributes(array(), true);
				$elements = $returnArray['elements'];
				$model = new ComponentsForm;
				$model->_dynamicFields = $returnArray['dynamicDataAttributes'];

				// generate the components form
				$form = new CForm($elements, $model);
				$formHeader = new CForm($elements, $model);
				// Select all values whose inputType is "Select"
				$fetchOptions = Yii::app()->db->createCommand()
					->select('sfd.subFormId, sfd.label')
					->from('surFormDetails sfd')
					->where('sfd.inputType ="select"')
					->queryAll();
				// ajax request to add a new row
					if ($form->submitted('ComponentsForm')) {
						//$items=$this->getItemsToUpdate();
						if(isset($_POST['ComponentsForm'])) {
							$valid = true;
							foreach($_POST['ComponentsForm'] as $i => $item) {
								$data = new ComponentsForm;
								$data->_dynamicFields = $returnArray['dynamicDataAttributes'];
								// generate the components form
								if(isset($_POST['ComponentsForm'][$i])) {
									$data->attributes = $item; //$_POST['ComponentsForm'][$i];
									$valid = $data->validate() && $valid;
									//add the models withe attributes to the model array
									$postedModelArray[] = $data;
								}
							}
							if($valid) { // all items are valid
								//print_r($form->getModel()); die();
								foreach($_POST['ComponentsForm'] as $i => $item) {
									$data = new ComponentsForm;
									$data->_dynamicFields = $returnArray['dynamicDataAttributes'];
									$data->attributes = $item;
									//print_r($item); die();

									$component->setIsNewRecord(true);
									$component->componentId = null;
									$component->componentName = $val = $data->componentName;
									$component->frameworkId = Yii::app()->session['surDesign']['id'];
									//save the componentHead values
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
												$params = explode("-", $key);
												$componentDetails->subFormId = $params[1];
												$componentDetails->value = $val;
												$componentDetails->save();
											}
										}
									}
								}
								Yii::app()->user->setFlash('success', Yii::t("translation", "Components successfully created"));

								$this->redirect(array('listComponents'));
							}
						}
					}
					// check if there was a post and the muliple forms are invalid
					if (isset($_POST['ComponentsForm']) && !$valid) {
						$modelArray = $postedModelArray; 
					} else {
						// number of model records to show by default on the view
						for ($i=0; $i < $multipleRowsToShow; $i++) {
							$modelArray[] = $model;
						}
					}

					if(Yii::app()->request->isAjaxRequest && isset($_GET['index'])) {
						$modelArray = array($model);
						$this->renderPartial('_tabularInputAsTable', array(
							'errorStatus' => $errorStatus,
							//'multipleRowsToShow' => $multipleRowsToShow,
							'elements' => $elements,
							'dataArray' => $dataArray,
							'model' => $model,
							'form' => $form,
							'index' => $_GET['index']
						));
						return;
					}
					//$modelArray = array($model, $model);
				$form = new CForm($elements, $model);
				$this->render('multipleComponent', array(
					'errorStatus' => $errorStatus,
					//'multipleRowsToShow' => $multipleRowsToShow,
					'elements' => $elements,
					'dataArray' => $dataArray,
					'modelArray' => $modelArray,
					'form' => $form,
					'formHeader' => $formHeader
				));
			}
		}

		/**
		 * actionAddNewMultiRow 
		 * 
		 * @access public
		 * @return void
		 */
		public function actionAddNewMultiRow() {
			if(Yii::app()->request->isAjaxRequest && isset($_GET['index'])) {
				$this->getController()->renderPartial($this->viewName, array(
					'model'=>$this->getModel(),
					'index'=>$_GET['index']
				));
			} else {
				throw new CHttpException(400,'Invalid request. Please do not repeat this request again.');
			}
		}

		/**
		 * getElementsAndDynamicAttributes 
		 * 
		 * @access public
		 * @return void
		 */
		public function getElementsAndDynamicAttributes($componentData = array(), $muliForm = false) {
			$elements = array();
			$attributeArray = array();
			$dynamicDataAttributes = array();
			if (!empty(Yii::app()->session['surDesign'])) {
					$getFormCondition = 't.formId=:formId';
					$getFormParams = array(':formId' => 1);
					// show only the elements where showOnMultiForm = true for multi form layout
					if ($muliForm) {
						$getFormCondition = 't.formId=:formId  and surFormHead.showOnMultiForm=:showOnMulti';
						$getFormParams = array(':formId' => 1, 'showOnMulti' => 1);
					}
					$getForm = SurForm::model()->with("surFormHead")->findAll(array(
						//'select' => 'pageId, pageName',
						'condition' => $getFormCondition,
						'params' => $getFormParams
					));
					if (!empty(Yii::app()->session['performanceAttribute'])) {
						$attributeList = AttributeFormRelation::model()->findAll(array(
							'condition' => 'attributeId=:attributeId',
							'params' => array(
								':attributeId' => Yii::app()->session['performanceAttribute']['id'],
							),
						));
						foreach ($attributeList as $attrs) {
							$attributeArray[$attrs->subFormId] = $attrs->subFormId;
						}
					}
				//$elements['title'] = "Components Form";
				$elements['showErrorSummary'] = true;
				if (!$muliForm) {
					$elements['showErrors'] = true;
				}
				$elements['activeForm']['id'] = "ComponentsForm";
				$elements['activeForm']['enableClientValidation'] = true;
				//$elements['activeForm']['enableAjaxValidation'] = false;
				$elements['activeForm']['class'] = 'CActiveForm';
				//print_r($getForm); die();
				$components = $getForm[0]->surFormHead;
				$dataArray['getForm'] = $components;
				$inputType = 'text';
				// add componentName form element
				$dynamicDataAttributes['componentName'] = 1;
				$elements['elements']['componentName'] = array(
					'label' => "Component Name",
					'required' => true,
					'type' => 'text',
				);
				// hide the label for multiple form layout
				if($muliForm) {
					$elements['elements']['componentName']['layout'] = '{input} {hint} {error}';
				} else {
					$elements['elements']['componentName']['layout'] = '{label} {input} {hint} {error}';
				}
				foreach ($components as $valu) {
					//set the model attribute array
					$dynamicDataAttributes[$valu->inputName . "-" . $valu->subFormId] = 1;
					//update the element type
					if ($valu->inputType == 'int') {
						$inputType = 'text';
					} else {
						if ($valu->inputType == 'select') {
							$inputType = 'dropdownlist';
						} else {
							$inputType = 'text';
						}
					}

					$hightlightClass = "";
					if (isset($attributeArray[$valu->subFormId])) {
						$hightlightClass = "attributeHighlight";
					}
					$attributeId = $valu->inputName . "-" . $valu->subFormId;
					// add the elements to the CForm array
					$elements['elements'][$attributeId] = array(
						'label' => $valu->label,
						'required' => $valu->required,
						'type' => $inputType,
						'class' => $hightlightClass
					);
					// hide the label for multiple form layout
					if($muliForm) {
						$elements['elements'][$attributeId]['layout'] = '{input} {hint} {error}';
					} else {
						// Add an image icon that will be displayed on the ui to show more infor
						$button = CHtml::image('','',array(
								'id' => 'moreInfoButton' . $valu->subFormId,
								'style' => 'cursor:pointer',
								'class' => 'ui-icon ui-icon-info',
								'title' => 'More Information',
								'onClick' => '$("#moreInfoDialog").html($("#popupData' . $valu->subFormId . '").html());$("#moreInfoDialog").dialog("open")'
								));
						// Add the image icon and information to the layout/ui
						if (!empty($valu->moreInfo) && !empty($valu->url) && !empty($valu->description)) {
							$elements['elements'][$attributeId]['layout'] = '{label}<div class="componentImagePopup">' . $button . 
							'</div>{hint} {input} {error}' . '<div id="popupData' . $valu->subFormId .'" style="display:none">'. $valu->moreInfo.'</div>' . 
							'<div class="componentDataPopup">' . $valu->description . 
								' <br/> <a href=' . $valu->url . ' target=_blank>' . $valu->url . '</a></div>';
						}
					}

					// add the values to the form
					if (!empty($componentData[$attributeId])) {
						$elements['elements'][$attributeId]['value'] = $componentData[$attributeId]['value'];
					}
					// add the component name element value
					if (!empty($componentData['componentName'])) {
						$elements['elements']['componentName']['value'] = $componentData['componentName'];
					}
					//add the dropdown parameters
					if ($inputType == 'dropdownlist') {
						$data = Options::model()->findAll(array(
							'condition' => 'elementId=:elementId',
							'params' => array(
								':elementId' => $valu->subFormId
							),
						));
						$items = array();
						// process the dropdown data into an array
						foreach ($data as $params) {
							$items[$params->optionId] = $params->label;
						}
						// add the dropdown items to the element
						$elements['elements'][$valu->inputName . "-" . $valu->subFormId]['items'] = $items;
					}
				}
				$elements['buttons'] = array(
					'newComponent' => array(
						'type' => 'submit',
						'label' => 'Create Component',
					),
				);
			}
			$returnArray = array('elements' => $elements, 'dynamicDataAttributes' => $dynamicDataAttributes);
			return $returnArray;
		}

		/**
		 * actionEditComponent
		 *
		 * @access public
		 * @return void
		 */
		public function actionEditComponent() {
			Yii::log("actionEditComponent DesignController called", "trace", self::LOG_CAT);
			$component = new ComponentHead;
			$componentDetails = new ComponentDetails;
			$dataArray = array();
			$dataArray['formType'] = 'Edit';
			$model = new ComponentsForm;
			$attributeArray = array();
			if (empty($_GET['compId'])) {
				Yii::app()->user->setFlash('error', Yii::t("translation", "Please select a component to edit"));
				$this->redirect(array('design/listComponents'));
			}
			if (!empty(Yii::app()->session['surDesign']) && !empty($_GET['compId'])) {
				//fetch the form data
				$fetchComponentData = Yii::app()->db->createCommand()
					->select('cd.componentDetailId, cd.componentId, cd.subFormId, cd.value, sd.inputName, sd.inputType,ch.componentName')
					->from('componentDetails cd')
					->join('surFormDetails sd', 'sd.subFormId = cd.subFormId')
					->join('componentHead ch', 'ch.componentId = cd.componentId')
					->where('cd.componentId =' . $_GET['compId'])
					->queryAll();
				//print_r($fetchComponentData);
				//arrange data in array
				$componentData = array();
				foreach ($fetchComponentData as $dat) {
					$componentData[$dat['inputName'] . "-" . $dat['subFormId']] = array(
						'value' => $dat['value'],
						'id' => $dat['componentDetailId']
					);
					// add the component name to the array as well but just once
					if (empty($componentData['componentName'])) {
						$componentData['componentName'] = $dat['componentName'];
					}
				}

				$returnArray = self::getElementsAndDynamicAttributes($componentData);
				$elements = $returnArray['elements'];
				$model = new ComponentsForm;
				$model->_dynamicFields = $returnArray['dynamicDataAttributes'];

				// generate the components form
				$form = new CForm($elements, $model);

				//validate and save the component data
				if ($form->submitted('ComponentsForm') && $form->validate()) {
					//print_r($form->getModel()); die();
					$component->setIsNewRecord(false);
					$component->componentName = $form->model->componentName;
					$component->frameworkId = Yii::app()->session['surDesign']['id'];
					$component->componentId = $_GET['compId'];
					//save the componentHead values
					$component->save();
					//$componentId = $component->componentId;
					$componentId = $_GET['compId'];
					// fetch the form data
					foreach ($form->model as $key => $val) {
						//ignore the attribute arrays
						if (!is_array($key) && !is_array($val)) {
							if ($key != "componentName") {
								$componentDetails = new ComponentDetails;
								$componentDetails->setIsNewRecord(false);
								$componentDetails->componentDetailId = $componentData[$key]['id'];
								$componentDetails->componentId = $componentId;
								//$params = explode("-", $key);
								//$componentDetails->subFormId = $params[1];
								$componentDetails->value = $val;
								$componentDetails->save(false);
							}
						}
					}
					Yii::app()->user->setFlash('success', Yii::t("translation", "Component successfully updated"));
					$this->redirect(array('listComponents'));
				}
			}
			$this->render('component', array(
				'model' => $model,
				'dataArray' => $dataArray,
				'form' => $form
			));
		}

		/**
		 * actionEditDesign
		 *
		 * @access public
		 * @return void
		 */
		public function actionEditDesign() {
			Yii::log("actionEditDesign DesignController called", "trace", self::LOG_CAT);
			$model = new NewDesign;
			$dataArray = array();
			$dataArray['formType'] = "Edit";

			if (isset($_GET['designId'])) {
				//fetch the form data
				$model = NewDesign::model()->findByPk($_GET['designId']);
				if ($model === null) {
					Yii::app()->user->setFlash('error', Yii::t("translation", "The design does not exist"));
					$this->redirect(array('design/index'));
				}
			} else {
				Yii::app()->user->setFlash('error', Yii::t("translation", "Please select a design to edit"));
				$this->redirect(array('design/index'));
			}
			//$this->performAjaxValidation($model);
			if (isset($_POST['NewDesign'])) {
				$model->attributes = $_POST['NewDesign'];
				$model->userId = Yii::app()->user->id;
				$model->frameworkId = $_GET['designId'];
				//print_r($model); die();

				//validate and save the design
				if ($model->validate()) {
					$model->update();
					Yii::app()->session->add('surDesign', array(
						'id' => $model->frameworkId,
						'name' => $model->name,
						'goalId' => $model->goalId
					));
					Yii::app()->user->setFlash('success', Yii::t("translation", "Design successfully updated"));
					$this->redirect(array('index'));
				}
			}
			// fetch the goal dropdown data
			$goalDropDown = GoalData::model()->findAll(array(
				'select' => 'pageId, pageName',
				'condition' => 'parentId=:parentId AND pageName<>:pageName',
				'params' => array(
					':parentId' => 0,
					':pageName' => 'noMenu'
				),
			));
			// create array options for goal dropdown
			foreach ($goalDropDown as $data) {
				$dataArray['goalDropDown'][$data->pageId] = $data->pageName;
			}

			$this->render('createDesign', array(
				'model' => $model,
				'dataArray' => $dataArray
			));
		}


		/**
		 * actionListComponents
		 *
		 * @access public
		 * @return void
		 */
		public function actionListComponents() {
			Yii::log("actionListComponents DesignController called", "trace", self::LOG_CAT);
			//$model = new ComponentHead;
			$dataArray = array();
			$dataArray['componentList'] = json_encode(array());
			$dataArray['dtHeader'] = "Components List";
			if (!empty(Yii::app()->session['surDesign'])) {
				// get list of surveillance designs
				$componentList = ComponentHead::model()->with("compDetails")->findAll(array(
					//'select' => 'pageId, pageName',
					'condition' => 'frameworkId=:frameworkId',
					'params' => array(
						':frameworkId' => Yii::app()->session['surDesign']['id'],
					),
				));

				$formDetails = SurFormDetails::model()->findAll(array(
					//'select' => 'pageId, pageName',
					'condition' => 'formId=:formId  and showOnComponentList=:showOnList',
					'params' => array(
						// ':formId' => Yii::app()->session['surDesign']['goalId'],
						// Make the form active.
						':formId' => 1,
						':showOnList' => true,
					),
				));
				$selectOptions = Options::model()->findAll();
				$optionsArray = array();
				// process the selecte options data into an array
				foreach ($selectOptions as $params) {
					$optionsArray[$params->optionId] = $params->label;
				}
				$formDetailsArray = array();
				$selectElements = array();
				foreach ($formDetails as $data) {
					$formDetailsArray[$data->subFormId] = $data->label;
					if($data->inputType == "select") {
						$selectElement[$data->subFormId] = $data->subFormId;
					}
				}
				//print_r($componentList); die();
				$componentListArray = array();
				// format datatable data
				$count = 0;
				foreach ($componentList as $com) {
					//print_r($com->compDetails); die();
					$deleteButton = "";
					$editButton = "";
					$deleteButton = "<button id='deleteComponent" . $com->componentId .
						"' type='button' class='bdelete' onclick=\"$('#deleteBox').dialog('open');" .
						"deleteConfirm('" . $com->componentName . "', '" .
						$com->componentId . "')\">Remove</button>";
					$editButton = "<button id='editComponent" . $com->componentId .
						"' type='button' class='bedit' onclick=\"window.location.href ='" .
						CController::createUrl('design/editComponent/', array(
								'compId' => $com->componentId
							)
						) .
						"'\">Edit</button>";
					$duplicateButton = "<button id='duplicateComponent" . $com->componentId .
						"' type='button' class='bcopy' onclick=\"$('#copyBox').dialog('open');" .
						"duplicatePopup('" . $com->componentId . "', '" .
						$com->componentName . "')\">Duplicate</button>";
					$componentListArray[$count] = array(
						'componentId' => $com->componentId,
						'frameworkId' => $com->frameworkId,
						'name' => $com->componentName,
						//'description' => $com->comments,
						'editButton' => $editButton,
						'deleteButton' => $deleteButton,
						'duplicateButton' => $duplicateButton,
					);
					$subDetails = array();
					foreach ($com->compDetails as $data) {
						$subDetails[$data->subFormId] = $data->value;
					}
					foreach ($formDetailsArray as $key => $val) {
						$columnVal = "";
						if(!empty($subDetails[$key])) {
							$columnVal = $subDetails[$key];
							if(!empty($selectElement[$key]) && !empty($optionsArray[$subDetails[$key]])) {
								$columnVal = $optionsArray[$subDetails[$key]];
							}
						}
						$componentListArray[$count][$key] = $columnVal;
					}
					$count ++;

				}
			}
			$dataArray['componentList'] = json_encode($componentListArray);
			// return ajax json data
			if (!empty($_GET['getComponents'])) {
				$jsonData = json_encode(array("aaData" => $componentListArray));
				echo $jsonData;
				return;
			}
			$this->render('componentList', array(
				//'model' => $model,
				'dataArray' => $dataArray,
				'columnsArray' => $formDetailsArray
			));
		}

		/**
		 * actionDeleteComponent
		 *
		 * @access public
		 * @return void
		 */
		public function actionDeleteComponent() {
			Yii::log("actionDeleteComponent called", "trace", self::LOG_CAT);
			if (isset($_POST["delId"])) {
				$record = ComponentHead::model()->findByPk($_POST['delId']);
				if (!$record->delete()) {
					Yii::log("Error Deleing user:" . $_POST['delId'], "warning", self::LOG_CAT);
					//echo $errorMessage;
					echo Yii::t("translation", "A problem occured when deleting a component ") . $_POST['delId'];
				} else {
					echo Yii::t("translation", "The component ") . Yii::t("translation", " has been successfully deleted");
				}
			}
		}

		/**
		 * actionDuplicateComponent 
		 * 
		 * @access public
		 * @return void
		 */
		public function actionDuplicateComponent() {
			Yii::log("actionDuplicateComponent called", "trace", self::LOG_CAT);
			$component = new ComponentHead;
			$componentDetails = new ComponentDetails;
			if (isset($_POST["oldComponentId"]) && $_POST['newComponentName']) {
				$record = ComponentHead::model()->with("compDetails")->findByPk($_POST['oldComponentId']);
					$component->componentName =  $_POST['newComponentName'];
					$component->frameworkId = Yii::app()->session['surDesign']['id'];
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
				echo Yii::t("translation", "A problem occured when duplicating the component ");
			}
		}

		/**
		 * actionDeleteDesign
		 *
		 * @access public
		 * @return void
		 */
		public function actionDeleteDesign() {
			Yii::log("actionDeleteDesign DesignController called", "trace", self::LOG_CAT);
			if (isset($_POST["delId"])) {
				$record = NewDesign::model()->findByPk($_POST['delId']);
				if (!$record->delete()) {
					Yii::log("Error deleting design: " . $_POST['delId'], "warning", self::LOG_CAT);
					//echo $errorMessage;
					echo Yii::t("translation", "A problem occured when deleting the design ") . $_POST['delId'];
				} else {
					// remove the default selected design from session
					unset($_SESSION['surDesign']);
					echo Yii::t("translation", "The design ") . Yii::t("translation", " has been successfully deleted");
				}
			}
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
		 * actionGetComponentMenu
		 *
		 * @access public
		 * @return void
		 */
		public function actionGetComponentMenu() {
			if (!empty($_GET['parentId'])) {
				$this->renderPartial('componentMenu', array(
					'parentId' => $_GET['parentId']
				), false, true);
			}
		}

		/**
		 * actionFetchComponents
		 *
		 * @access public
		 * @return void
		 */
		public function actionFetchComponents() {
			Yii::log("actionFetchComponents DesignController called", "trace", self::LOG_CAT);

			$postData = $_POST;
			$data = GoalData::model()->findAll(array(
				'select' => 'pageId, pageName',
				'condition' => 'parentId=:parentId',
				'params' => array(
					':parentId' => $postData['NewDesign']['goalId'],
				),
			));

			$data = CHtml::listData($data, 'pageId', 'pageName');
			//print_r($data);
			foreach ($data as $value => $name) {
				echo CHtml::tag('option',
					array('value' => $value), CHtml::encode($name), true);
			}
		}
	}
