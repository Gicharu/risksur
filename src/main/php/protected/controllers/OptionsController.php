<?php
/**
 * OptionsController
 * 
 * @uses RiskController
 * @package 
 * @version $id$
 * @copyright Tracetracker
 * @author Chirag Doshi <chirag@tracetracker.com> 
 * @license Tracetracker {@link http://www.tracetracker.com}
 */
class OptionsController extends RiskController {
	public $page;
	private	$configuration;
	private $optionsMask;
	const LOG_CAT = "ctrl.OptionsController";
	private $docName;

	/**
	 * @var string the default layout for the views. Defaults to '//layouts/column2', meaning
	 * using two-column layout. See 'protected/views/layouts/column2.php'.
	 */
	public $layout = '//layouts/column2';


	/**
	 * init 
	 * 
	 * @access public
	 * @return void
	 */
	public function init() {
		$this->configuration = Yii::app()->tsettings;
		$this->optionsMask = [
			'relationNames' => [
				1 => 'frameworkField',
				2 => 'component',
				3 => 'element'
			],
			'joinLabels' => [
				1 => ['id', 'label'],
				2 => ['subFormId', 'label'],
				3 => ['evalElementsId', 'label']
			],
			'formFieldsModels' => [
				1 => 'FrameworkFields',
				2 => 'SurFormDetails',
				3 => 'EvaluationElements'
			]
		];

	}

	public function actionHome() {
		$this->docName = 'optionsHome';
		if (isset($_POST['pageId'])) {
			SystemController::savePage('home');
		}
		$page = SystemController::getPageContent($this->docName);
		$this->render('home', ['page' => $page]);
	}

	/**
	 * actionIndex 
	 * @param $id string
	 * @param $ajax bool
	 * @return void
	 */
	public function actionIndex($id, $ajax = false) {
		Yii::log("actionIndex AdminController called", "trace", self::LOG_CAT);
		$dataArray = [];
		$dataArray['dtHeader'] = "Manage Options"; // Set page title when printing the datatable
		// Get list of options 
		// $optionsList = Options::model()->findAll(array(
		// 	'select' => 'optionId, label',
		// ));
		$dataArray['firstColumn'] = $this->optionsMask['relationNames'][$id];
		$optionsListCriteria = new CDbCriteria();
		$optionsListCriteria->select = 'optionId, label';
		$optionsListCriteria->with = $this->optionsMask['relationNames'][$id];
		$optionsList = ModelToArray::convertModelToArray(Options::model()->findAll($optionsListCriteria));
		//print_r($optionsList); die;
		$optionsListArray = [];
		// Format datatable data. Define the Edit & Delete buttons

		if ($ajax) {
			$jsonData = json_encode(["aaData" => $optionsList]);
			echo $jsonData;
			return;
		}
		$dataArray['optionsList'] =  json_encode($optionsList);
		$this->render('index', [
			'id' => $id,
			'dataArray' => $dataArray,
		]);
	}

	/**
	 * actionAddOption
	 * 
	 * @access public
	 * @return void
	 */
	public function actionAddOption($id) {
		Yii::log("actionIndex OptionsController called", "trace", self::LOG_CAT);
		$model = new Options();
		$model->setCustomScenario($id);
		if (isset($_POST['Options'])) {
			$model->attributes = $_POST['Options'];
			//print_r($model); die;
			if ($model->save()) {
				Yii::app()->user->setFlash('success', "Option successfully added.");
				$this->redirect( ['options/index/id/'. $id]);
			}
			if(!$model->hasErrors()) {
				Yii::app()->user->setFlash('error', "An error occurred while adding the option, please contact your administrator.");

			}

		}
		// add options via ajax from chosen plugin
//		if(isset($_POST['options'])) {
//			$model->setScenario($_POST['options']['scenario']);
//			unset($_POST['options']['scenario']);
//			$model->attributes = $_POST['options'];
//			if($model->save()) {
//				echo json_encode(ModelToArray::convertModelToArray($model, [$model->tableName() => 'optionId, label']));
//				return;
//			}
//			$model->unsetAttributes();
//			//print_r($model->attributeNames()); die;
//			echo json_encode(['optionId' => '']);
//			return;
//
//		}

//		echo get_class($this->optionsMask['formFieldsModels'][$id]);
		// Select all values whose inputType is ""Select"
		$formElementsCriteria = new CDbCriteria();
		$formElementsCriteria->condition = "inputType='dropdownlist'";
		//$formElementsModel = new {$this->optionsMask['formFieldsModels'][$id]};

		$fetchOptions = CActiveRecord::model($this->optionsMask['formFieldsModels'][$id])->findAll($formElementsCriteria);
		$formElements = CHtml::listData($fetchOptions, $this->optionsMask['joinLabels'][$id][0],
			$this->optionsMask['joinLabels'][$id][1]);
		//print_r($formElements); die;

		$this->render('add', [
			'model' => $model,
			'dropDownAttribute' => $this->optionsMask['relationNames'][$id] . 'Id',
			'formElements' => $formElements
		]);
	}

	/**
	 * @param $id
	 * @return array
	 */
	private function getDropDownElements($id) {
		$formElementsCriteria = new CDbCriteria();
		$formElementsCriteria->condition = "inputType='dropdownlist'";
		//$formElementsModel = new {$this->optionsMask['formFieldsModels'][$id]};

		$fetchOptions = CActiveRecord::model($this->optionsMask['formFieldsModels'][$id])
			->findAll($formElementsCriteria);
		$formElements = CHtml::listData($fetchOptions, $this->optionsMask['joinLabels'][$id][0],
			$this->optionsMask['joinLabels'][$id][1]);
		return $formElements;
	}

	/**
	 * actionEditOption
	 * @param $id
	 * @param $type string
	 * @return void
	 */
	public function actionEditOption($id, $type) {
		Yii::log("actionEditOption OptionsController called", "trace", self::LOG_CAT);
		$dataArray = [];
		// fetch the form data, search using the "optionId" sent from the listing.
		$model = Options::model()->findByPk($id);
		$formFieldType = array_flip($this->optionsMask['relationNames'])[$type];
		if ($model === null) {
			Yii::app()->user->setFlash('error', Yii::t("translation", "That option does not exist"));
			$this->redirect(['options/index/id/' . $formFieldType]);
			return;
		}

		$model->setCustomScenario($formFieldType);
		if ( isset( $_POST['Options'] ) ) {
			$model->attributes = $_POST['Options'];
			// Validate and save the data
			if ($model->save() ) {
				Yii::app()->user->setFlash('success', Yii::t("translation", "Option successfully updated"));
				$this->redirect(['options/index/id/' . $formFieldType]);
			} elseif (!$model->hasErrors()) {
				Yii::app()->user->setFlash('error', Yii::t("translation", "An error occurred while updating the" .
					" option, please contact your administrator"));

			}
		}

		// Fetch all options and send them to the view to be displayed in the dropdown

		$this->render('edit', [
			'model' => $model,
			'formElements' => $this->getDropDownElements($formFieldType),
			'dropDownAttribute' => $type . 'Id'
		]);
	}

	/**
	 * actionDeleteOption 
	 * 
	 * @access public
	 * @return void
	 */
	public function actionDeleteOption($id) {
		Yii::log("actionDeleteOption OptionsController called", "trace", self::LOG_CAT);

		$record = Options::model()->findByPk($id)->delete();
			if (!$record) {
				Yii::log("Error deleting Option: " . $id, "warning", self::LOG_CAT);

				echo Yii::t("translation", "A problem occurred when deleting the Option ");
			} else {
				echo Yii::t("translation", "The Option has been successfully deleted");
			}
	}

}

