<?php

	/**
	 * AttributeController 
	 * 
	 * @uses Controller
	 * @package 
	 * @version $id$
	 * @copyright Tracetracker
	 * @author Chirag Doshi <chirag@tracetracker.com> 
	 * @license Tracetracker {@link http://www.tracetracker.com}
	 */
	class AttributeController extends Controller {
		private	$configuration;
		const LOG_CAT = "ctrl.AttributeController";
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
		 * init 
		 * 
		 * @access public
		 * @return void
		 */
		public function init() {
			$this->configuration = Yii::app()->tsettings;
		}

		/**
		 * actionIndex 
		 * 
		 * @access public
		 * @return void
		 */
		public function actionIndex() {
			Yii::log("actionIndex AttributeController called", "trace", self::LOG_CAT);
			$model = new Attributes;
			$dataArray = array();
			$dataArray['dtHeader'] = "Manage Attributes"; // Set page title when printing the datatable
			$attributesList = Yii::app()->db->createCommand()
				->select('attributeId, name, description')
				->from('perfAttributes')
				->queryAll();
			$attributesListArray = array();
			// Format datatable data. Define the Edit & Delete buttons
			foreach ($attributesList as $attribute) {
					$editButton = "<button id='editAttribute" . $attribute['attributeId'] . 
					"' type='button' class='bedit' onclick=\"window.location.href ='" . CController::createUrl('attribute/editAttribute/', array(
						'attributeId' => $attribute['attributeId'])
					) . "'\">Edit</button>";
					$deleteButton = "<button id='deleteAttribute" . $attribute['attributeId'] . 
					"' type='button' class='bdelete' onclick=\"$('#deleteBox').dialog('open');" . 
					"deleteConfirm('" . $attribute['name'] . "', '" .
					$attribute['attributeId'] . "')\">Remove</button>";
				// Pack the data to be sent to the view
				$attributesListArray[] = array (
					'name' =>   $attribute['name'],
					'description' =>   $attribute['description'],
					'editButton' => $editButton,
					'deleteButton' => $deleteButton
				);
			}
			$dataArray['attributesList'] =  json_encode($attributesListArray);
			if (!empty($_GET['getAttributes'])) {
				$jsonData = json_encode(array("aaData" => $attributesListArray));
				echo $jsonData;
				return ;
			}
			$this->render('index', array(
				'model' => $model,
				'dataArray' => $dataArray
			));
		}

		/**
		 * actionAddAttribute
		 * 
		 * @access public
		 * @return void
		 */
		public function actionAddAttribute() {
			Yii::log("actionIndex AttributesController called", "trace", self::LOG_CAT);
			$model = new Attributes;
			if (isset($_POST['Attributes'])) {
				$model->attributes = $_POST['Attributes'];
				// CHECK IF NAME PROVIDED EXISTS
				$queryAttributes = Yii::app()->db->createCommand()
					->select('*')
					->from('perfAttributes')
					->where('name="' . $model['name'].'"')
					->queryAll();
				if (count($queryAttributes) > 0) {
					Yii::app()->user->setFlash('error', "The name " . $model['name'] . " is already in use. Please enter a different name.");
				} else {
					if ( $model->validate() ) {
						$model->save();
						Yii::app()->user->setFlash('success', "Attribute successfully created.");
						$this->redirect( array( 'attribute/index' ) );
					}
				}
			}
			$this->render('add', array(
				'model' => $model
			));
		}

		/**
		 * actionEditAttribute
		 * 
		 * @access public
		 * @return void
		 */
		public function actionEditAttribute() {
			Yii::log("actionEditAttribute AttributeController called", "trace", self::LOG_CAT);
			$model = new Attributes;
			$dataArray = array();
			$dataArray['formType'] = "Edit";
			if (!empty($_GET['attributeId'])) {
				// fetch the form data, search using the "attributeId" sent from the listing.
				$model = Attributes::model()->findByPk($_GET['attributeId']);
				if ($model === null) {
					Yii::app()->user->setFlash('error', Yii::t("translation", "The attribute does not exist"));
					$this->redirect(array('attribute/index'));
				}
			} else {
				Yii::app()->user->setFlash('notice', Yii::t("translation", "Please select an attribute to edit"));
				$this->redirect(array('attribute/index'));
			}
			if (isset($_POST['Attributes'])) {
				$model->attributes = $_POST['Attributes'];
				// Validate and save the data
				if ( $model->validate() ) {
					$model->update();
					Yii::app()->user->setFlash('success', Yii::t("translation", "Attribute successfully edited"));
					$this->redirect(array('index'));
				}
			}
			$this->render('edit', array(
				'model' => $model,
				'dataArray' => $dataArray
			));
		}

		/**
		 * actionDeleteAttribute 
		 * 
		 * @access public
		 * @return void
		 */
		public function actionDeleteAttribute() {
			Yii::log("actionDeleteAttribute AttributeController called", "trace", self::LOG_CAT);
			if (isset($_POST["delId"])) {
				$attributeFormModel = new AttributeFormRelation;
				$queryAttributeRelations = Yii::app()->db->createCommand()
					->select('*')
					->from('attributeFormRelation')
					->where('attributeId="' . $_POST['delId'] .'"')
					->queryAll();

				if (count($queryAttributeRelations) > 0) {
					// ATTRIBUTES WITH RELATIONS SHOULD NOT BE DELETABLE
					echo Yii::t("translation", "Cannot delete Attribute. The attribute has a relation to a form element. Delete the relation first then re-try deleting the attribute.");
				} else {
					$record = Attributes::model()->findByPk($_POST['delId']);
					if (!$record->delete()) {
						Yii::log("Error deleting Attribute: " . $_POST['delId'], "error", self::LOG_CAT);
						echo Yii::t("translation", "A problem occured when deleting the Attribute ") . $_POST['delId'] . ". Please contact the Risksur Admin";
					} else {
						echo Yii::t("translation", "The Attribute has been successfully deleted");
					}
				}
			}
		}

		/**
		 * actionSelectAttribute 
		 * 
		 * @access public
		 * @return void
		 */
		public function actionSelectAttribute() {
			Yii::log("actionSelectAttribute called", "trace", self::LOG_CAT);
			//$model = new NewDesign;
			$attributesArray = array();
			$dataArray = array();
			$attributeData = PerfAttributes::model()->findAll();
			// create array options for attribute dropdown
			foreach ($attributeData as $data) {
				$dataArray['attributeList'][$data->attributeId] = $data->name;
				$attributesArray[$data->attributeId] = $data->name;
			}

			if (!empty($_POST['attributeSelected']) && !empty($attributesArray[$_POST['attributeSelected']])) {
				Yii::app()->session->add('performanceAttribute', array(
					'id' => $_POST['attributeSelected'],
					'name' => $attributesArray[$_POST['attributeSelected']]
				));
				echo "Attribute successfully selected";
				return;
			}
				//add the surveilance design to the session
				//if (count($selectedDesign) == 1) {
					//Yii::app()->session->add('surDesign', array(
						//'id' => $_GET['designId'],
						//'name' => $selectedDesign[0]->name,
						//'goalId' => $selectedDesign[0]->goalId
					//));
				//} else {
					//Yii::app()->session->remove('surDesign');
				//}
				//print_r($selectedDesign);
				//print_r($_SESSION);

			$this->render('selectAttribute', array(
				//'model' => $model,
				'dataArray' => $dataArray
			));
		}

		/**
		 * actionAddRelation
		 * 
		 * @access public
		 * @return void
		 */
		public function actionAddRelation() {
			Yii::log("actionaddRelation AttributeController called", "trace", self::LOG_CAT);
			$formRelationModel = new AttributeFormRelation;
			$attributeModel = new Attributes;
			$surFormDetailsModel = new SurFormDetails;
			if (isset($_POST['AttributeFormRelation'])) {
				$formRelationModel->attributes = $_POST['AttributeFormRelation'];
				if ($formRelationModel->validate()) {
					$formRelationModel->save();
					Yii::app()->user->setFlash('success', "Relation successfully created.");
					$this->redirect( array( 'attribute/listRelations' ) );
				}
			}
			// QUERY FOR ALL ATTRIBUTES
			$queryAttributes = Yii::app()->db->createCommand()
				->select('attributeId, name')
				->from('perfAttributes')
				->queryAll();

			// QUERY FOR ALL SURFORM DETAILS
			$querySurformDetails = Yii::app()->db->createCommand()
				->select('subFormId, inputName')
				->from('surFormDetails')
				->queryAll();

			$attributesArray = array();
			$surformDetailsArray = array();
			// Pack data to send to view
			foreach ($queryAttributes as $key => $value) {
				$attributesArray[$value['attributeId']] = $value['name']; 
			}
			foreach ($querySurformDetails as $key => $value) {
				$surformDetailsArray[$value['subFormId']] = $value['inputName']; 
			}

			$this->render('addRelation', array(
				'attributeModel' => $attributeModel,
				'formRelationModel' => $formRelationModel,
				'surFormDetailsModel' => $surFormDetailsModel,
				'attributesArray' => $attributesArray,
				'surformDetailsArray' => $surformDetailsArray
			));
		}

		/**
		 * actionListRelations 
		 * 
		 * @access public
		 * @return void
		 */
		public function actionListRelations() {
			Yii::log("actionListRelations AttributeController called", "trace", self::LOG_CAT);
			$model = new AttributeFormRelation;
			$dataArray = array();
			$dataArray['dtHeader'] = "Manage Attribute-Form Relations"; // Set page title when printing the datatable
			$relationsList = Yii::app()->db->createCommand()
				->select('attributeId, subFormId')
				->from('attributeFormRelation')
				->queryAll();
			$relationsArray = array();
			// Format datatable data. Define the Edit & Delete buttons
			foreach ($relationsList as $key => $relation) {
				//GET THE ATTRIBUTE NAME TO BE DISPLAYED
				$queryAttributes = Yii::app()->db->createCommand()
					->select('name')
					->from('perfAttributes')
					->where('attributeId="' . $relation['attributeId'].'"')
					->queryAll();
				//GET THE SUFORM INPUTNAME TO BE DISPLAYED
				$querySurformDetails = Yii::app()->db->createCommand()
					->select('inputName')
					->from('surFormDetails')
					->where('subFormId="' . $relation['subFormId'].'"')
					->queryAll();

				$editButton = "<button id='editRelation" . $relation['attributeId'] . 
				"' type='button' class='bedit' onclick=\"window.location.href ='" . CController::createUrl('attribute/editRelation/', array(
					'attributeId' => $relation['attributeId'])
				) . "'\">Edit</button>";
				$deleteButton = "<button id='deleteRelation" . $relation['attributeId'] . 
				"' type='button' class='bdelete' onclick=\"$('#deleteBox').dialog('open');" . 
				"deleteConfirm('" . $queryAttributes[0]['name'] . " <-> " . $querySurformDetails[0]['inputName'] . "', '" .
				$relation['attributeId'] . "')\">Remove</button>";
				// Pack the data to be sent to the view
				$relationsArray[] = array (
					'Attribute' =>   $queryAttributes[0]['name'],
					'FormElement' =>   $querySurformDetails[0]['inputName'],
					'editButton' => $editButton,
					'deleteButton' => $deleteButton
				);
			}
			$dataArray['relationsList'] = json_encode($relationsArray);
			if (!empty($_GET['getRelations'])) {
				$jsonData = json_encode(array("aaData" => $relationsArray));
				echo $jsonData;
				return ;
			}
			$this->render('relationsIndex', array(
				'model' => $model,
				'dataArray' => $dataArray
			));
		}

		/**
		 * actionDeleteRelation 
		 * 
		 * @access public
		 * @return void
		 */
		public function actionDeleteRelation() {
			Yii::log("actionDeleteRelation AttributeController called", "trace", self::LOG_CAT);
			if (isset($_POST["delId"])) {
				$record = Attributes::model()->findAll($_POST['delId']);
				if (!$record->delete()) {
					Yii::log("Error deleting Attribute: " . $_POST['delId'], "error", self::LOG_CAT);
					echo Yii::t("translation", "A problem occured when deleting the Relation ") . $_POST['delId'] . ". Please contact the Risksur Admin";
				} else {
					echo Yii::t("translation", "The Relation has been successfully destroyed!");
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
			if (isset($_POST['ajax']) && $_POST['ajax'] === 'newAttribute') {
				echo CActiveForm::validate($model);
				Yii::app()->end();
			}
		}
	}
