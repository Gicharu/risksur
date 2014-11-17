<?php
//error_reporting(E_ALL);
/**
 * AdminController 
 * 
 * @uses Controller
 * @package 
 * @version $id$
 * @copyright Tracetracker
 * @author Chirag Doshi <chirag@tracetracker.com> 
 * @license Tracetracker {@link http://www.tracetracker.com}
 */
class OptionsController extends Controller {
	public $page;
	private	$configuration;
	const LOG_CAT = "ctrl.OptionsController";

	/**
	 * @var string the default layout for the views. Defaults to '//layouts/column2', meaning
	 * using two-column layout. See 'protected/views/layouts/column2.php'.
	 */
	public $layout = '//layouts/column2';

	/**
	 * filters 
	 * 
	 * @access public
	 * @return void
	 */
	public function filters() {
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
		Yii::log("actionIndex AdminController called", "trace", self::LOG_CAT);
		$model = new Options;
		$dataArray = array();
		$dataArray['dtHeader'] = "Manage Options"; // Set page title when printing the datatable
		// Get list of options 
		// $optionsList = Options::model()->findAll(array(
		// 	'select' => 'optionId, label',
		// ));
		$optionsList = Yii::app()->db->createCommand()
			->select('opt.optionId, opt.label as option, sfd.label')
			->from('options opt')
			->join('surFormDetails sfd', 'sfd.subFormId = opt.elementId')
			->queryAll();
			// print_r($optionsList);die();
		$optionsListArray = array();
		// Format datatable data. Define the Edit & Delete buttons
		foreach ($optionsList as $options) {
				$editButton = "<button id='editOption" . $options['optionId'] . 
				"' type='button' class='bedit' onclick=\"window.location.href ='" . CController::createUrl('options/editOption/', array(
					'optionId' => $options['optionId'])
				) . "'\">Edit</button>";
				$deleteButton = "<button id='deleteOption" . $options['optionId'] . 
				"' type='button' class='bdelete' onclick=\"$('#deleteBox').dialog('open');" . 
				"deleteConfirm('" . $options['label'] . "', '" .
				$options['optionId'] . "')\">Remove</button>";
			// Pack the data to be sent to the view
			$optionsListArray[] = array (
				'label' =>   $options['label'],
				'option' =>   $options['option'],
				'editButton' => $editButton,
				'deleteButton' => $deleteButton
			);
		}
		$dataArray['optionsList'] =  json_encode($optionsListArray);
		if (!empty($_GET['getOptions'])) {
			$jsonData = json_encode(array("aaData" => $optionsListArray));
			echo $jsonData;
			return ;
		}
		$this->render('index', array(
			'model' => $model,
			'dataArray' => $dataArray
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
			if ( $model->validate() ) {
				$model->save();
				Yii::app()->user->setFlash('success', "Option successfully created.");
				$this->redirect( array( 'options/index' ) );
			} else {
				echo CActiveForm::validate($model);
				Yii::app()->end();
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
	public function actionEditOption() {
		Yii::log("actionEditOption OptionsController called", "trace", self::LOG_CAT);
		$model = new Options;
		$dataArray = array();
		$dataArray['formType'] = "Edit";

			if (isset($_GET['optionId'])) {
				// fetch the form data, search using the "optionId" sent from the listing.
				$model = Options::model()->findByPk($_GET['optionId']);
				$fetchElementName = Yii::app()->db->createCommand()
					->select('sfd.label')
					->from('surFormDetails sfd')
					->where('sfd.subFormId =' . $model['elementId']  )
					->queryAll();

				// Pick the selected Option's elementId. This will be displayed as the default in the dropdown
				$dataArray['elementName'] = $fetchElementName[0]['label'];
			}
		if ( isset( $_POST['Options'] ) ) {
			$model->attributes = $_POST['Options'];
			// Validate and save the data
			if ( $model->validate() ) {
				$model->update();
				Yii::app()->user->setFlash('success', Yii::t("translation", "Option successfully updated"));
				$this->redirect(array('index'));
			}
		}

		// Fetch all options and send them to the view to be displayed in the dropdown
		$fetchOptions = Yii::app()->db->createCommand()
			->select('sfd.subFormId, sfd.label')
			->from('surformdetails sfd')
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
