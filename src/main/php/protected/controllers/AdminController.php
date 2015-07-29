<?php
//error_reporting(E_ALL);
/**
 * AdminController 
 * 
 * @uses RiskController
 * @package 
 * @version $id$
 * @copyright Tracetracker
 * @author Chirag Doshi <chirag@tracetracker.com> 
 * @license Tracetracker {@link http://www.tracetracker.com}
 */
class AdminController extends RiskController {
	//public $page;
	private	$configuration;
	const LOG_CAT = "ctrl.AdminController";

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
		$elements['errorSummaryHeader'] = Yii::app()->params['headerErrorSummary'];
		$elements['errorSummaryFooter'] = Yii::app()->params['footerErrorSummary'];
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
			'newGoal' => array(
				'type' => 'submit',
				'label' => 'Create Goal',
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
			if ($model === null) {
				Yii::app()->user->setFlash('error', Yii::t("translation", "The goal does not exist"));
				$this->redirect(array('admin/listGoals'));
			}
			$elements['showErrorSummary'] = true;
			$elements['errorSummaryHeader'] = Yii::app()->params['headerErrorSummary'];
			$elements['errorSummaryFooter'] = Yii::app()->params['footerErrorSummary'];
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
				'newGoal' => array(
					'type' => 'submit',
					'label' => 'Edit Goal',
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
		} else {
			Yii::app()->user->setFlash('error', Yii::t("translation", "Please select a goal to edit"));
			$this->redirect(array('admin/listGoals'));
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
			return;
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

	/**
	 * @param bool $ajax
	 * @return void
	 */
	public function actionListEvaMethods($ajax = false) {
		Yii::log("actionListEvaMethods called", "trace", self::LOG_CAT);
		$this->setPageTitle(Yii::app()->name . ' - List Evaluation Methods');
		$dataProvider = new CActiveDataProvider('EvaMethods');
		//print_r(ModelToArray::convertModelToArray($dataProvider->getData())); die;
		if($ajax) {
			$data = array('aaData' => ModelToArray::convertModelToArray($dataProvider->getData()));
			echo json_encode($data, JSON_UNESCAPED_SLASHES);
			return;
		}
		$this->render('evaMethods/list', array('dataProvider' => $dataProvider));
	}

	/**
	 * @param $evaMethodId
	 */
	public function actionDeleteEvaMethod($evaMethodId) {
		Yii::log("actionDeleteEvaMethod called", "trace", self::LOG_CAT);
		if(EvaMethods::model()->deleteByPk($evaMethodId) > 0) {
			echo 'Economic evaluation method successfully deleted';
			return;
		}
			echo 'An error occurred when deleting the economic evaluation method, ' .
				'please try again or contact your administrator if the problem persists';
		return;

	}

	/**
	 * actionAddEvaMethod
	 */
	public function actionAddEvaMethod() {
		Yii::log("actionAddEvaMethod called", "trace", self::LOG_CAT);
		$config = self::getEvaMethodsFormConfig();
		$buttonParam = array('name' => 'add', 'label' => 'Add');
		$config['buttons'] = ContextController::getButtons($buttonParam, 'admin/listEvaMethods');
		unset($config['buttons']['cancel']);
		$model = new EvaMethods();
		$form = new CForm($config, $model);
		if($form->submitted('add') && $form->validate()) {
			$model = $form->model;
			if($model->save(false)) {
				Yii::app()->user->setFlash('success', 'Economic evaluation method add successfully');
				$this->redirect(array('admin/listEvaMethods'));
			}
			Yii::app()->user->setFlash('error',
				'An error occurred while saving, please try again or contact your administrator if the problem persists');
		}
		//var_dump($model, $form); die;
		$this->render('evaMethods/add', array('form' => $form));

	}

	/**
	 * @param $id
	 * @return void
	 */
	public function actionUpdateEvaMethod($id) {
		Yii::log("actionUpdateEvaMethod called", "trace", self::LOG_CAT);
		$config = self::getEvaMethodsFormConfig();
		$buttonParam = array('name' => 'update', 'label' => 'Update');
		$config['buttons'] = ContextController::getButtons($buttonParam, 'admin/listEvaMethods');
		$model = EvaMethods::model()->findByPk($id);
		if(is_null($model)) {
			Yii::app()->user->setFlash('notice', 'That economic evaluation method does not exist.');
			$this->redirect(array('admin/listEvaMethods'));
			return;
		}
		unset($config['buttons']['cancel']);
		$form = new CForm($config, $model);
		if($form->submitted('update') && $form->validate()) {
			$model = $form->model;
			if($model->save(false)) {
				Yii::app()->user->setFlash('success', 'Economic evaluation method updated successfully');
				$this->redirect(array('admin/listEvaMethods'));
			}
			Yii::app()->user->setFlash('error',
				'An error occurred while updating, please try again or contact ' .
				'your administrator if the problem persists');
		}
		$this->render('evaMethods/update', array('form' => $form));

	}

	/**
	 * @return array
	 */
	private function getEvaMethodsFormConfig() {
		$elements = ContextController::getDefaultElements();
		$elements['elements'] = array(
			'buttonName' => array(
				'type' => 'text'
			),
			'link' => array(
				'type' => 'text'
			),
			'description' => array(
				'type' => 'text'
			)
		);
		return $elements;
	}
}
