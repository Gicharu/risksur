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
		$dataArray['dtHeader'] = "Surveillence design List";
		$dataArray['surveillanceList'] =  json_encode(array());
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

		// get list of surveillance designs 
		$surveillanceList = NewDesign::model()->with("goal")->findAll(array(
			//'select' => 'pageId, pageName',
			'condition' => 'userId=:userId',
			'params' => array(
				':userId' => Yii::app()->user->id,
			),
		));
		$surveillanceListArray = array();
		// format datatable data
		foreach ($surveillanceList as $sur) {
				$deleteButton = "";
				//if (Yii::app()->user->name != $valu['userName']) {
					$deleteButton = "<button id='deleteDesign" . $sur->frameworkId . 
					"' type='button' class='bdelete' onclick=\"$('#deleteBox').dialog('open');" . 
					"deleteConfirm('" . $sur->frameworkId . "', '" .
					$sur->name . "')\">Remove</button>";
						//}
			$surveillanceListArray[] = array (
				'frameworkId' =>   $sur->frameworkId,
				'name' =>   $sur->name,
				'userId' =>   $sur->userId,
				'description' =>   $sur->description,
				'goalId' =>   $sur->goalId,
				'goalName' =>   $sur->goal->pageName,
				'deleteButton' => $deleteButton
			);
		}
		$dataArray['surveillanceList'] =  json_encode($surveillanceListArray);
		//print_r($dataArray['surveillanceList']);
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
	 * actionShowDesign 
	 * 
	 * @access public
	 * @return void
	 */
	public function actionShowDesign() {
		Yii::log("actionShowDesign DesignController called", "trace", self::LOG_CAT);
		$model = new NewDesign;
		$dataArray = array();
		if (isset($_GET['designId'])) {
			$selectedDesign = NewDesign::model()->with("goal")->findAll(array(
				//'select' => 'pageId, pageName',
				'condition' => 'frameworkId=:frameworkId AND userId=:userId',
				'params' => array(
					':frameworkId' => $_GET['designId'],
					':userId' => Yii::app()->user->id,
				),
			));
			$dataArray['selectedDesign'] = $selectedDesign;
			//add the surveilance design to the session
			if (count($selectedDesign) == 1) {
				Yii::app()->session->add('surDesign', array('id' => $_GET['designId'], 'name' => $selectedDesign[0]->name));
			} else {
				Yii::app()->session->remove('surDesign');
			}
			//print_r($selectedDesign);
			//print_r($_SESSION);
		}

		$this->render('showDesign', array(
			'model' => $model,
			'dataArray' => $dataArray
		));
	}

	public function actionAddComponent() {
		Yii::log("actionAddComponent DesignController called", "trace", self::LOG_CAT);
		$modelDesign = new NewDesign;
		$dataArray = array();
		if (!empty(Yii::app()->session['surDesign'])) {
			$getForm = SurForm::model()->with("surFormHead")->findAll(array(
				//'select' => 'pageId, pageName',
				'condition' => 't.formId=:formId',
				'params' => array(
					':formId' => Yii::app()->session['surDesign']['id'],
				),
			));
			//$dataArray['getForm'] = $getForm;
			$elements = array();
			//$elements['title'] = "Components Form";
			$elements['showErrorSummary'] = true;
			$elements['activeForm']['id'] = "ComponentsForm";
			$elements['activeForm']['enableClientValidation'] = true;
			//$elements['activeForm']['enableAjaxValidation'] = false;
			$elements['activeForm']['class'] = 'CActiveForm';
			$components = $getForm[0]->surFormHead;
			$dataArray['getForm'] = $components;
			$dynamicDataAttributes = array();
			$inputType = 'text';
			foreach ($components as $valu) {
				//set the model attribute array
				$dynamicDataAttributes[$valu->inputName] = 1;
				//update the element type
				if ($valu->inputType == 'int') {
					$inputType = 'text';
				} else if ($valu->inputType == 'select') {
					$inputType = 'dropdownlist';
				} else {
					$inputType = 'text';
				}
				// add the elements to the CForm array
				$elements['elements'][$valu->inputName] = array(
					'label' => $valu->label,
					'required' => $valu->required,
					'type' =>  $inputType,
				);
				//add the dropdown parameters
				if ($inputType == 'dropdownlist') {
					$data = Options::model()->findAll(array(
						'condition' => 'elementId=:elementId',
						'params' => array(
							':elementId' => $valu->subFormId
						),
					));
					$items = array();
					// process the dropdown data into an array
					foreach ($data as $params) {
						$items[$params->optionId] = $params->label;
					}
					// add the dropdown items to the element
					$elements['elements'][$valu->inputName]['items'] = $items; 
				}
			}
			$elements['buttons'] = array(
				'newComponent'=>array(
					'type'=>'submit',
					'label'=>'Create Component',
				),
			);
			$model = new ComponentsForm;
			$model->_dynamicFields = $dynamicDataAttributes;
			$form = new CForm($elements, $model);
			//print_r($form);die();
			//if($form->submitted('ComponentsForm')) {
				////$form->loadData();
				//if($model->validate()) {
					//echo "what da";
				//}
				////$this->redirect(...);
				////print_r($form); die();
			//}
			if ($form->submitted('ComponentsForm') && $form->validate()) {
				print_r($form); die();
				$account = $form['Account']->model;
				$email = $form['Email']->model;
				if ($account->save(false)) {
					$email->id = $account->id;
					$email->save(false);
					$this->redirect(array('thankyou'));
				}
			}
		}

		$this->render('component', array(
			'model' => $model,
			'dataArray' => $dataArray,
			'form' => $form
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
