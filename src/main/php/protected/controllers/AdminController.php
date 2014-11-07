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
class AdminController extends Controller {
	public $page;
	private	$configuration;
	const LOG_CAT = "ctrl.AdminController";

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
		$dataArray['dtHeader'] = "Manage Options";
		// Get list of options 
		$optionsList = Options::model()->findAll(array(
			'select' => 'optionId, label',
		));
		$optionsListArray = array();
		// format datatable data
		foreach ($optionsList as $options) {
				$editButton = "<button id='editOption" . $options->optionId . 
				"' type='button' class='bedit' onclick=\"window.location.href ='" . CController::createUrl('option/editOption/', array(
					'designId' => $options->optionId)
				) .
				"'\">Edit</button>";
				$deleteButton = "<button id='deleteOption" . $options->optionId . 
				"' type='button' class='bdelete' onclick=\"$('#deleteBox').dialog('open');" . 
				"deleteConfirm('" . $options->label . "', '" .
				$options->optionId . "')\">Remove</button>";
					//}
			$optionsListArray[] = array (
				'label' =>   $options->label,
				'editButton' => $editButton,
				'deleteButton' => $deleteButton
			);
		}
		$dataArray['optionsList'] =  json_encode($optionsListArray);

		// if (!empty($_GET['getDesigns'])) {
		// 	$jsonData = json_encode(array("aaData" => $surveillanceListArray));
		// 	echo $jsonData;
		// 	return ;
		// }
		// // print_r($dataArray['surveillanceList']);die();
		// // fetch the goal dropdown data
		// $goalDropDown = GoalData::model()->findAll(array(
		// 	'select' => 'pageId, pageName',
		// 	'condition' => 'parentId=:parentId AND pageName<>:pageName',
		// 	'params' => array(
		// 		':parentId' => 0,
		// 		':pageName' => 'noMenu'
		// 	),
		// ));
		// // create array options for goal dropdown
		// foreach ($goalDropDown as $data) {
		// 	$dataArray['goalDropDown'][$data->pageId] = $data->pageName;
		// }
		$this->render('index', array(
			'model' => $model,
			'dataArray' => $dataArray
		));
	}

}
?>
