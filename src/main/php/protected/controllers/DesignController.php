<?php
/**
 * DesignController 
 * 
 * @package  
 * @author    Chirag Doshi <chirag@tracetracker.com> 
 * @copyright Tracetracker
 * @version   $id$
 * @uses      Controller
 * @license   Tracetracker {@link http://www.tracetracker.com}
 */
class DesignController extends Controller {
	const LOG_CAT = "ctrl.DesignController";
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
			) ,
		);
	}
	/**
	 * actionIndex 
	 * 
	 * @access public
	 * @return void
	 */
	public function actionIndex() {
		Yii::log("actionIndex DesignController called", "trace", self::LOG_CAT);
		$model = new NewDesignForm;
		$dataArray = array();

		// fetch the goal dropdown data
		$goalDropDown = GoalData::model()->findAll(array(
			'select' => 'pageId, pageName',
			'condition' => 'parentId=:parentId AND pageName<>:pageName',
			'params' => array(
				':parentId' => 0,
				':pageName' => 'noMenu'
			),
		));
		// create array options for goal dropdown
		foreach ($goalDropDown as $data) {
			$dataArray['goalDropDown'][$data->pageId] = $data->pageName;
		}
		$this->render('index', array(
			'model' => $model,
			'dataArray' => $dataArray
		));
	}
	/**
	 * actionGetComponentMenu 
	 * 
	 * @access public
	 * @return void
	 */
	public function actionGetComponentMenu() {
		if (!empty($_GET['parentId'])) {
			$this->renderPartial('componentMenu', array(
				'parentId' => $_GET['parentId']
			) , false, true);
		}
	}

	/**
	 * actionFetchComponents 
	 * 
	 * @access public
	 * @return void
	 */
	public function actionFetchComponents() {
		Yii::log("actionFetchComponents DesignController called", "trace", self::LOG_CAT);

		$postData = $_POST;
		$data = GoalData::model()->findAll(array(
			'select' => 'pageId, pageName',
			'condition' => 'parentId=:parentId',
			'params' => array(
				':parentId' => $postData['NewDesignForm']['goal'],
			),
		));

		$data = CHtml::listData($data,'pageId','pageName');
		//print_r($data);
		foreach($data as $value => $name) {
			echo CHtml::tag('option',
			array('value'=>$value),CHtml::encode($name),true);
		}
	}

	public function actionAddNewDesign() {
		Yii::log("actionAddNewDesign DesignController called", "trace", self::LOG_CAT);
		// code...
	}
}
