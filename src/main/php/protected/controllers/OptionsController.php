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
	const LOG_CAT = "ctrl.OptionsController";

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
	}

	/**
	 * actionIndex 
	 * 
	 * @access public
	 * @return void
	 */
	public function actionIndex($id) {
		Yii::log("actionIndex AdminController called", "trace", self::LOG_CAT);
		$model = new Options;
		$dataArray = [];
		$dataArray['dtHeader'] = "Manage Options"; // Set page title when printing the datatable
		// Get list of options 
		// $optionsList = Options::model()->findAll(array(
		// 	'select' => 'optionId, label',
		// ));
		$optionsMask = [
			'relationNames' => [
				0 => 'frameworkField',
				1 => 'component',
				2 => 'element'
			],
			'joinLabels' => [
				0 => 'label',
				1 => 'label',
				2 => 'label'
			]
		];
		$dataArray['optsCategory'] = $optionsMask['relationNames'][0] . '.' . $optionsMask['joinLabels'][0];
		$optionsListCriteria = new CDbCriteria();
		$optionsListCriteria->select = 'optionId, label';
		$optionsListCriteria->with = $optionsMask['relationNames'][$id];
		$optionsList = ModelToArray::convertModelToArray(Options::model()->findAll($optionsListCriteria));
		//print_r($optionsList); die;
		$optionsListArray = array();
		// Format datatable data. Define the Edit & Delete buttons

		$dataArray['optionsList'] =  json_encode($optionsList);
		if (!empty($_GET['getOptions'])) {
			$jsonData = json_encode(array("aaData" => $optionsListArray));
			echo $jsonData;
			return;
		}
		$this->render('index', array(
			'model' => $model,
			'dataArray' => $dataArray,
		));
	}

	/**
	 * actionAddOption
	 * 
	 * @access public
	 * @return void
	 */
	public function actionAddOption() {
		Yii::log("actionIndex OptionsController called", "trace", self::LOG_CAT);
		$model = new Options;
		if (isset($_POST['Options'])) {
			$model->attributes = $_POST['Options'];
			if ($model->validate()) {
				$model->save();
				Yii::app()->user->setFlash('success', "Option successfully created.");
				$this->redirect( array( 'options/index' ) );
			}
		}
		// Select all values whose inputType is ""Select"
		$fetchOptions = Yii::app()->db->createCommand()
			->select('sfd.subFormId, sfd.label')
			->from('surFormDetails sfd')
			->where('sfd.inputType ="select"')
			->queryAll();

		$surformdetailsArray = array();
		// Pack data to send to view
		foreach ($fetchOptions as $key => $value) {
			$surformdetailsArray[$value['subFormId']] = $value['label']; 
		}

		$this->render('add', array(
			'model' => $model,
			'surformdetailsArray' => $surformdetailsArray
		));
	}

	/**
	 * actionEditOption
	 * 
	 * @access public
	 * @return void
	 */
	public function actionEditOption($id) {
		Yii::log("actionEditOption OptionsController called", "trace", self::LOG_CAT);
		$model = new Options();
		$dataArray = [];
		$dataArray['formType'] = "Edit";

		if (empty($id)) {
			Yii::app()->user->setFlash('notice', Yii::t("translation", "Please select an option to edit"));
			$this->redirect(['options/index']);
			return;
		}
		// fetch the form data, search using the "optionId" sent from the listing.
		$model = Options::model()->findByPk($id);
		if ($model === null) {
			Yii::app()->user->setFlash('error', Yii::t("translation", "The option does not exist"));
			$this->redirect(['options/index']);
			return;
		}
		$fetchElementName = Yii::app()->db->createCommand()
			->select('sfd.label')
			->from('surFormDetails sfd')
			->where('sfd.subFormId =' . $model['elementId']  )
			->queryAll();

		// Pick the selected Option's elementId. This will be displayed as the default in the dropdown
		$dataArray['elementName'] = $fetchElementName[0]['label'];
		if ( isset( $_POST['Options'] ) ) {
			$model->attributes = $_POST['Options'];
			// Validate and save the data
			if ( $model->validate() ) {
				$model->update();
				Yii::app()->user->setFlash('success', Yii::t("translation", "Option successfully updated"));
				$this->redirect(['index']);
			}
		}

		// Fetch all options and send them to the view to be displayed in the dropdown
		$fetchOptions = Yii::app()->db->createCommand()
			->select('sfd.subFormId, sfd.label')
			->from('surFormDetails sfd')
			->where('sfd.inputType ="select"')
			->queryAll();

		$surformdetailsArray = array();
		foreach ($fetchOptions as $key => $value) {
			$surformdetailsArray[$value['subFormId']] = $value['label']; 
		}
		$this->render('edit', array(
			'model' => $model,
			'dataArray' => $dataArray,
			'surformdetailsArray' => $surformdetailsArray
		));
	}

	/**
	 * actionDeleteOption 
	 * 
	 * @access public
	 * @return void
	 */
	public function actionDeleteOption() {
		Yii::log("actionDeleteOption OptionsController called", "trace", self::LOG_CAT);
		if (isset($_POST["delId"])) {
				$record = Options::model()->findByPk($_POST['delId']);
			if (!$record->delete()) {
				$errorMessage = "Error No:" . ldap_errno($ds) . "Error:" . ldap_error($ds);
				Yii::log("Error deleting Option: " . $errorMessage, "warning", self::LOG_CAT);
				echo Yii::t("translation", "A problem occured when deleting the Option ") . $_POST['delId'];
			} else {
				echo Yii::t("translation", "The Option has been successfully deleted");
			}
		}
	}

}
?>
