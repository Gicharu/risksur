<?php
	/**
	 * SurveillanceContextController
	 *
	 * @package
	 * @author    James Njoroge <james@tracetracker.com>
	 * @copyright Tracetracker
	 * @version   $id$
	 * @uses      Controller
	 * @license   Tracetracker {@link http://www.tracetracker.com}
	 */

	class ContextController extends Controller{
		const LOG_CAT = 'ctrl.ContextController';
		// use 2 column layout
		public $layout = '//layouts/column2';

		/**
		 * filters
		 * @return array
		 */
//		public function filters() {
//			Yii::log("filters called", "trace", self::LOG_CAT);
//			return array(
//				array(
//					'application.filters.RbacFilter',
//				),
//			);
//		}
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
		 * actionList
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
				$editButton = "<button id='editComponent" . $sur->frameworkId .
					"' type='button' class='bedit' onclick=\"window.location.href ='" .
					$this->createUrl('context/update/', array(
							'contextId' => $sur->frameworkId
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
		 * actionShowDesign
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

		public function actionCreate() {
			Yii::log("actionCreate ContextController called", "trace", self::LOG_CAT);
			$context = new FrameworkContext();
			$elements = self::getDefaultElements();
			$elements['elements'] = self::getElements($context, array('name', 'description'));
			$elements['buttons'] = self::getButtons(array(
				'name' => 'createContext',
				'label' => 'Create'
			));
			$form = new CForm($elements, $context);
			if($form->submitted('createContext')) {
				$form->loadData();
				$context->userId = Yii::app()->user->id;
				if($context->save()) {
					Yii::app()->user->setFlash('success', 'Surveillance framework created successfully');
					$this->redirect('list');
					return;

				}

//				$context->userId = Yii::app()->user->id;
				Yii::app()->user->setFlash('error', 'A problem occurred while creating the surveillance context, ' .
					'please try again or contact the administrator if this persists');

			}
			$this->render('create', array('form' => $form));

		}


		public function actionUpdate() {
			Yii::log("actionUpdate ContextController called", "trace", self::LOG_CAT);
			$model = new FrameworkContext();
			$dForm = new DynamicFormDetails('update', 'frameworkFields');
			//print_r($_POST); die;
			$dataArray = array();
			$dataArray['formType'] = "Edit";
			if (isset($_GET['contextId'])) {
				//fetch the form data
				$model = FrameworkContext::model()->findByPk($_GET['contextId']);
				if ($model === null) {
					Yii::app()->user->setFlash('error', Yii::t("translation", "The selected context does not exist"));
					$this->redirect(array('context/list'));
					return;
				}
			} else {
				Yii::app()->user->setFlash('error', Yii::t("translation", "Please select a context before you attempt to update it"));
				$this->redirect(array('context/list'));
			}

			$contextFields = $dForm->findAll('frameworkId=' . $_GET['contextId']);
			$elements = self::getDefaultElements();
			$elements['elements']['context']['elements'] = self::getElements($model, array('name', 'description'));

			//$contextForm = new CForm($modelElements, $model);
			$modelData = array();
			$dynamicDataAttributes = array();
			$elements['elements']['context']['type'] = 'form';
			$elements['elements']['contextDetails']['type'] = 'form';
			foreach($contextFields as $field) {
				$dynamicDataAttributes[$field->inputName . '-' . $field->id] = 1;
				$elements['elements']['contextDetails']['elements'][$field->inputName . '-' . $field->id] = array(
					'label' => $field->inputName,
					'required' => $field->required,
					'type' => $field->inputType
				);
				if($field->inputType == 'dropdownlist') {
					$elements['elements']['contextDetails']['elements'][$field->inputName . '-' . $field->id]['items'] =
						Options::model()->getContextFieldOptions($field->id);
				}
				$modelData[$field->inputName . '-' . $field->id] = $field->value;
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
			$dForm->attributes = $modelData;
			$form = new CForm($elements);
			$form['context']->model = $model;
			$form['contextDetails']->model = $dForm;

			//print_r($form); die('here');
			if ($form->submitted('updateContext') && $form->validate()) {
				$context = $form['context']->model;
				$context->userId = Yii::app()->user->id;
				if($context->save(false)) {
					foreach($_POST['DynamicFormDetails'] as $inputName => $inputVal) {
						$attributes = array(
							'value' => $inputVal,
						);

						if ($dForm->updateByPk(substr($inputName, -1), $attributes)) {
							Yii::app()->user->setFlash('success', 'Surveillance context updated successfully');
						} else {
							Yii::app()->user->setFlash('error', 'A problem occurred while updating the surveillance context, ' .
								'please try again or contact the administrator if this persists');
							break;

						}
					}

				} else {
					Yii::app()->user->setFlash('error', 'A problem occurred while updating the surveillance context, ' .
						'please try again or contact the administrator if this persists');

				}
				$this->redirect('list');
				return;
			}

			$this->render('update', array(
				'form' => $form
			));
		}


		public function actionDelete() {
			Yii::log("actionDelete ContextController called", "trace", self::LOG_CAT);
			if (isset($_POST["delId"])) {
				$record = FrameworkContext::model()->findByPk($_POST['delId']);
				if (!$record->delete()) {
					Yii::log("Error deleting context: " . $_POST['delId'], "warning", self::LOG_CAT);
					//echo $errorMessage;
					echo Yii::t("translation", "A problem occurred when deleting the context ") . $_POST['delId'];
				} else {
					// remove the default selected design from session
					unset($_SESSION['surDesign']);
					echo Yii::t("translation", "The context ") . Yii::t("translation", " has been successfully deleted");
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
			foreach($modelAttributes as $attrName => $attrVal) {

				if(!empty($attributes)) {
					foreach($attributes as $attr) {
						if($attrName === $attr) {
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

			}
			return $modelElements;
		}

		public static function getDefaultElements() {
			return array(
				'showErrorSummary' => true,
				'showErrors' => true,
				'errorSummaryHeader' => Yii::app()->params['headerErrorSummary'],
				'errorSummaryFooter' => Yii::app()->params['footerErrorSummary'],
				'activeForm' => array(
					'class' => 'CActiveForm',
					'enableClientValidation' => true,
					'clientOptions' => array(
						'validateOnSubmit' => true,
					)
				)
			);
		}

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
		 * @param $model
		 */
		protected function performAjaxValidation($model) {
			if (isset($_POST['ajax']) && $_POST['ajax'] === 'newDesignForm') {
				echo CActiveForm::validate($model);
				Yii::app()->end();
			}
		}

	}