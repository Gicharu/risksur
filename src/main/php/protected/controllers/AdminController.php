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
	 * actionAddGoal 
	 * 
	 * @access public
	 * @return void
	 */
	public function actionAddGoal() {
		Yii::log("actionAddGoal called", "trace", self::LOG_CAT);
		$dataArray = array();
		$dataArray['formType'] = 'Create';
		$model = new GoalData;
		$elements = array();
		//$elements['title'] = "Components Form";
		$elements['showErrorSummary'] = true;
		$elements['activeForm']['id'] = "GoalDataForm";
		$elements['activeForm']['enableClientValidation'] = true;
		//$elements['activeForm']['enableAjaxValidation'] = false;
		$elements['activeForm']['class'] = 'CActiveForm';
		//print_r($getForm); die();
		$elements['elements']['pageName'] = array(
			'label' => "Goal Name",
			'required' => true,
			'type' =>  'text',
		);
		$elements['buttons'] = array(
			'newGoal'=>array(
				'type'=>'submit',
				'label'=>'Create Goal',
			),
		);
		//$model->_dynamicFields = $dynamicDataAttributes;
		// generate the components form
		$form = new CForm($elements, $model);
		//validate and save the goal data
		if ($form->submitted('GoalData') && $model->validate("create")) {
			$model->attributes = $form;
			$model->path = "";
			$model->target = "";
			$model->parentId = 0;
			$model->save();
			Yii::app()->user->setFlash('success', Yii::t("translation", "Goal successfully created"));
			$this->redirect(array('listGoals'));
		}

		$this->render('goal', array(
			'model' => $model,
			'dataArray' => $dataArray,
			'form' => $form
		));
	}
	/**
	 * actionEditGoal 
	 * 
	 * @access public
	 * @return void
	 */
	public function actionEditGoal() {
		Yii::log("actionEditGoal called", "trace", self::LOG_CAT);
		$dataArray = array();
		$dataArray['formType'] = 'Edit';
		$model = new GoalData;
		$elements = array();

		if (!empty($_GET['goalId'])) {
			$model = GoalData::model()->findByPk($_GET['goalId']);
			$elements['showErrorSummary'] = true;
			$elements['activeForm']['id'] = "GoalDataForm";
			$elements['activeForm']['enableClientValidation'] = true;
			//$elements['activeForm']['enableAjaxValidation'] = false;
			$elements['activeForm']['class'] = 'CActiveForm';
			//print_r($getForm); die();
			$elements['elements']['pageName'] = array(
				'label' => "Goal Name",
				'required' => true,
				'type' =>  'text',
			);
			$elements['buttons'] = array(
				'newGoal'=>array(
					'type'=>'submit',
					'label'=>'Edit Goal',
				),
			);
			//$model->_dynamicFields = $dynamicDataAttributes;
			// generate the components form
			$form = new CForm($elements, $model);
			//validate and save the goal data
			if ($form->submitted('GoalData') && $model->validate()) {
				$model->attributes = $form;
				$model->pageId = $_GET['goalId'];
				$model->update();
				Yii::app()->user->setFlash('success', Yii::t("translation", "Goal successfully updated"));
				$this->redirect(array('listGoals'));
			}
		}
		$this->render('goal', array(
			'model' => $model,
			'dataArray' => $dataArray,
			'form' => $form
		));
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
			// get list of goals and ignore noMenu 
			$goalData = GoalData::model()->findAll(array(
				'select' => 'pageId, pageName',
				'condition' => 'parentId=:parentId AND pageName<>:pageName',
				'params' => array(
					':parentId' => 0,
					':pageName' => 'noMenu'
				),
			));
			//print_r($goalData); die();
			$goalListArray = array();
			// format datatable data
			foreach ($goalData as $data) {
				$deleteButton = "";
				$editButton = "";
					$deleteButton = "<button id='deleteGoal" . $data->pageId . 
					"' type='button' class='bdelete' onclick=\"$('#deleteBox').dialog('open');" . 
					"deleteConfirm('" . $data->pageName . "', '" .
					$data->pageId . "')\">Remove</button>";
					$editButton = "<button id='editGoal" . $data->pageId . 
					"' type='button' class='bedit' onclick=\"window.location.href ='" . CController::createUrl('admin/editGoal/', array(
						'goalId' => $data->pageId)
					) .
					"'\">Edit</button>";
					$goalListArray[] = array (
						'goalId' =>   $data->pageId,
						'name' => $data->pageName,
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

	/**
	 * actionDeleteGoal 
	 * 
	 * @access public
	 * @return void
	 */
	public function actionDeleteGoal() {
		Yii::log("actionDeleteGoal called", "trace", self::LOG_CAT);
		if (isset($_POST["delId"])) {
				$record = GoalData::model()->findByPk($_POST['delId']);
			if (!$record->delete()) {
				Yii::log("Error deleting goal: " . $_POST['delId'], "warning", self::LOG_CAT);
				//echo $errorMessage;
				echo Yii::t("translation", "A problem occured when deleting the goal ") . $_POST['delId'];
			} else {
				echo Yii::t("translation", "The goal ") . Yii::t("translation", " has been successfully deleted");
			}
		}
	}
}
