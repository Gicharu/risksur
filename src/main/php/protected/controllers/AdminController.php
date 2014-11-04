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
	 * actionListGoals 
	 * 
	 * @access public
	 * @return void
	 */
	public function actionListGoals() {
		Yii::log("actionListGoals called", "trace", self::LOG_CAT);
		$dataArray = array();
		$dataArray['listGoals'] =  json_encode(array());
		$dataArray['dtHeader'] = "Goals List";
			// get list of surveillance designs 
			$goalData = GoalData::model()->findAll(array(
				//'select' => 'pageId, pageName',
				'condition' => 'parentId=:parentId',
				'params' => array(
					':parentId' => 0,
				),
			));
			print_r($goalData); die();
			$goalListArray = array();
			// format datatable data
			foreach ($goalData as $com) {
				$deleteButton = "";
				$editButton = "";
					$deleteButton = "<button id='deleteComponent" . $com->componentId . 
					"' type='button' class='bdelete' onclick=\"$('#deleteBox').dialog('open');" . 
					"deleteConfirm('" . $com->componentName . "', '" .
					$com->componentId . "')\">Remove</button>";
					$editButton = "<button id='editComponent" . $com->componentId . 
					"' type='button' class='bedit' onclick=\"window.location.href ='" . CController::createUrl('design/editComponent/', array(
						'compId' => $com->componentId)
					) .
					"'\">Edit</button>";
					$goalListArray[] = array (
						'componentId' =>   $com->componentId,
						'frameworkId' =>   $com->frameworkId,
						'name' => $com->componentName,
						'description' =>   $com->comments,
						'editButton' => $editButton,
						'deleteButton' => $deleteButton
					);
			}
		$dataArray['listGoals'] =  json_encode($goalListArray);
		// return ajax json data
		if (!empty($_GET['getGoals'])) {
			$jsonData = json_encode(array("aaData" =>  $goalListArray));
			echo $jsonData;
			return ;
		}
		$this->render('listGoals', array(
			//'model' => $model,
			'dataArray' => $dataArray
		));
	}
}
