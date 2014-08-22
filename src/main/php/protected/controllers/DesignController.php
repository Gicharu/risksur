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
		$model = new NewDesign;
		$dataArray = array();
		$this->performAjaxValidation($model);

		if ( isset( $_POST['NewDesign'] ) ) {
			$model->attributes = $_POST['NewDesign'];
			$model->userId = Yii::app()->user->id;
			//$model->tool = $model->tool == '' ? null : $model->tool;
			//$model->path = $model->tool === null ? $model->path : "tools/index";
			
			//$model->setAttribute('menuOrder', $mnuResult->lastMenu + 1);
			if ( $model->validate() ) {
				$model->save();
				//Yii::app()->user->setFlash('success', "Page created successfully");
				echo "saved successfully";
				//$this->redirect( array( 'index' ) );
				return;
			} else {
				echo CActiveForm::validate($model);
				Yii::app()->end();
			}
		}
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
	 * performAjaxValidation 
	 * 
	 * @param mixed $model 
	 * @access protected
	 * @return void
	 */
	protected function performAjaxValidation($model) {
		if(isset($_POST['ajax']) && $_POST['ajax']==='newDesignForm')
		{
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}
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
				':parentId' => $postData['NewDesign']['goalId'],
			),
		));

		$data = CHtml::listData($data,'pageId','pageName');
		//print_r($data);
		foreach($data as $value => $name) {
			echo CHtml::tag('option',
			array('value'=>$value),CHtml::encode($name),true);
		}
	}
}
