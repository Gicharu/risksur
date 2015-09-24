<?php

/**
 * AttributeController
 * @uses RiskController
 * @package
 * @version $id$
 * @copyright Tracetracker
 * @author Chirag Doshi <chirag@tracetracker.com>
 * @license Tracetracker {@link http://www.tracetracker.com}
 */
class AttributeController extends RiskController {
	private $configuration;
	const LOG_CAT = "ctrl.AttributeController";
	//Use layout
	public $layout = '//layouts/column2';

	/**
	 * init
	 * @access public
	 * @return void
	 */
	public function init() {
		$this->configuration = Yii::app()->tsettings;
	}

	/**
	 * actionIndex
	 * @var $ajax bool
	 * @return void
	 */
	public function actionIndex($ajax = false) {
		Yii::log("actionIndex AttributeController called", "trace", self::LOG_CAT);
		$dataArray = array();
		$dataArray['dtHeader'] = "Manage Attributes"; // Set page title when printing the datatable
		$attributesList = ModelToArray::convertModelToArray(EvaAttributes::model()
			->with('attributeTypes')
			->findAll(['select' => 'attributeId, name, description, attributeType']));
		// Format datatable data. Define the Edit & Delete buttons

		$dataArray['attributesList'] = json_encode($attributesList);
		if ($ajax) {
			echo json_encode(["aaData" => $attributesList]);
			return;
		}
		$this->render('index', array(
			'dataArray' => $dataArray
		));
	}

	/**
	 * actionAddAttribute
	 * @access public
	 * @return void
	 */
	public function actionAddAttribute() {
		Yii::log("actionIndex AttributesController called", "trace", self::LOG_CAT);
		$model = new EvaAttributes('create');
		if (isset($_POST['Attributes'])) {
			$model->attributes = $_POST['Attributes'];
			if (isset($_POST['ajax']) && $_POST['ajax'] == 'newAttribute') {
				echo CActiveForm::validate($model);
				Yii::app()->end();
			}
			if ($model->validate()) {
				$model->save(false);
				Yii::app()->user->setFlash('success', "Attribute successfully created.");
				$this->redirect(array('attribute/index'));
			}
		}
		$this->render('add', array(
			'model' => $model
		));
	}

	/**
	 * actionEditAttribute
	 * @access public
	 * @return void
	 */
	public function actionEditAttribute($id) {
		Yii::log("actionEditAttribute AttributeController called", "trace", self::LOG_CAT);
		// fetch the form data, search using the "attributeId" sent from the listing.
		$model = EvaAttributes::model()->findByPk($id);
		if ($model === null) {
			Yii::app()->user->setFlash('error', Yii::t("translation", "The attribute does not exist"));
			$this->redirect(['attribute/index']);
			return;
		}

		if (isset($_POST['Attributes'])) {
			$model->attributes = $_POST['Attributes'];
			if (isset($_POST['ajax']) && $_POST['ajax'] == 'newAttribute') {
				echo CActiveForm::validate($model);
				Yii::app()->end();
			}
			// Validate and save the data
			if ($model->validate()) {
				$model->update();
				Yii::app()->user->setFlash('success', Yii::t("translation", "Attribute successfully edited"));
				$this->redirect(['index']);
			}
		}
		$this->render('edit', [
			'model' => $model
		]);
	}

	/**
	 * actionDeleteAttribute
	 * @var $id string
	 * @return void
	 */
	public function actionDeleteAttribute($id) {
		Yii::log("actionDeleteAttribute AttributeController called", "trace", self::LOG_CAT);

		$queryAttributeRelations = AttributeFormRelation::model()->findAll('attributeId=' . $id);

		if (count($queryAttributeRelations) > 0) {
			// ATTRIBUTES WITH RELATIONS SHOULD NOT BE DELETABLE
			echo Yii::t("translation", "Cannot delete Attribute. The attribute has a relation to a form element." .
				" Delete the relation first then try deleting the attribute.");
		} else {
			$record = EvaAttributes::model()->findByPk($id);
			if (!$record->delete()) {
				Yii::log("Error deleting Attribute: " . $id, "error", self::LOG_CAT);
				echo Yii::t("translation", "A problem occurred when deleting the Attribute ") . $id .
					". Please contact your Administrator";
			} else {
				echo Yii::t("translation", "The Attribute has been successfully deleted");
			}
		}
		return;
	}

	/**
	 * actionSelectAttribute
	 * @param $id mixed
	 * @access public
	 * @return array
	 */
	public static function actionSelectAttribute($id = null) {
		Yii::log("actionSelectAttribute called", "trace", self::LOG_CAT);
		//$model = new NewDesign;
		$attributesArray = array();
		$dataArray = array();
		$attributeData = EvaAttributes::model()->findAll();
		// create array options for attribute dropdown
		foreach ($attributeData as $data) {
			$dataArray['attributeList'][$data->attributeId] = $data->name;
			$attributesArray[$data->attributeId] = $data->name;
		}

		if (isset($attributesArray[$id])) {
			Yii::app()->session->add('performanceAttribute', array(
				'id'   => $id,
				'name' => $attributesArray[$id]
			));
			Yii::app()->user->setFlash('success', "Attribute successfully selected");
			Yii::app()->request->redirect(Yii::app()->request->getUrlReferrer());
		}
		return $attributesArray;
	}

	/**
	 * actionAddRelation
	 * @access public
	 * @return void
	 */
	public function actionAddRelation() {
		Yii::log("actionaddRelation AttributeController called", "trace", self::LOG_CAT);
		$formRelationModel = new AttributeFormRelation();
		$attributeModel = new EvaAttributes();
		$surFormDetailsModel = new SurFormDetails();
		if (isset($_POST['AttributeFormRelation'])) {
			$formRelationModel->attributes = $_POST['AttributeFormRelation'];
			if ($formRelationModel->validate()) {
				$formRelationModel->save();
				Yii::app()->user->setFlash('success', "Relation successfully created.");
				$this->redirect(array('attribute/listRelations'));
			}
		}
		// QUERY FOR ALL ATTRIBUTES
		$queryAttributes = $attributeModel->findAll(array('select' => 'attributeId, name'));

		// QUERY FOR ALL SURFORM DETAILS
		$querySurformDetails = $surFormDetailsModel->findAll(array('select' => 'subFormId, inputName'));


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
			'attributeModel'      => $attributeModel,
			'formRelationModel'   => $formRelationModel,
			'surFormDetailsModel' => $surFormDetailsModel,
			'attributesArray'     => $attributesArray,
			'surformDetailsArray' => $surformDetailsArray
		));
	}

	/**
	 * actionListRelations
	 * @access public
	 * @return void
	 */
	public function actionListRelations() {
		Yii::log("actionListRelations AttributeController called", "trace", self::LOG_CAT);
		$model = new AttributeFormRelation();
		$dataArray = array();
		$dataArray['dtHeader'] = "Manage Attribute-Form Relations"; // Set page title when printing the datatable
		$relationsList = $model->with(['attributes', 'subForm'])->findAll(['select' => 'attributeId, subFormId']);
		$relationsArray = [];
		// Format datatable data. Define the Edit & Delete buttons
		foreach ($relationsList as $key => $relation) {
			//get the attribute name to be displayed
		//print_r($relation); die;
			//$queryAttributes = EvaAttributes::model()->findAll('attributeId="' . $relation['attributeId'] . '"');

			//get the suform input name to be displayed
			//$querySurformDetails = SurFormDetails::model()->findAll('subFormId="' . $relation['subFormId'] . '"');

			$deleteButton = "<button id='deleteRelation" . $relation->attributeId .
				"' type='button' class='bdelete' onclick=\"$('#deleteBox').dialog('open');" .
				"deleteConfirm('" . $relation->attributes->name . " <-> " . $relation->subForm->inputName . "', '" .
				$relation['attributeId'] . "," . $relation['subFormId'] . "')\">Remove</button>";
			// Pack the data to be sent to the view
			$relationsArray[] = array(
				'Attribute'    => $relation->attributes->name,
				'FormElement'  => $relation->subForm->inputName,
				//'editButton' => $editButton,
				'deleteButton' => $deleteButton
			);
		}
		$dataArray['relationsList'] = json_encode($relationsArray);
		if (!empty($_GET['getRelations'])) {
			$jsonData = json_encode(array("aaData" => $relationsArray));
			echo $jsonData;
			return;
		}
		$this->render('relationsIndex', array(
			'model'     => $model,
			'dataArray' => $dataArray
		));
	}

	/**
	 * actionDeleteRelation
	 * @access public
	 * @return void
	 */
	public function actionDeleteRelation() {
		Yii::log("actionDeleteRelation AttributeController called", "trace", self::LOG_CAT);
		if (isset($_POST["delId"])) {
			// get the id value comma separated
			$ids = explode(",", $_POST['delId']);
			//$_POST['delId']
			$record = AttributeFormRelation::model()->findByAttributes(array(
				'attributeId' => $ids[0],
				'subFormId'   => $ids[1]
			));
			//print_r($record); die();
			if (!$record->delete()) {
				Yii::log("Error deleting Attribute: " . $_POST['delId'], "error", self::LOG_CAT);
				echo Yii::t("translation", "A problem occured when deleting the Relation ") . $_POST['delId'] .
					". Please contact your administrator";
				return;
			}
			echo Yii::t("translation", "The Relation has been successfully removed!");
			return;
		}
	}


	/**
	 * performAjaxValidation
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
