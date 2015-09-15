<?php
/**
 * AdminevaController
 * @uses RiskController
 * @copyright TraceTracker
 * @author Chirag Doshi <james@tracetracker.com>
 * @license TraceTracker {@link http://www.tracetracker.com}
 */
class AdminevaController extends RiskController {
	//public $page;
	private	$configuration;
	const LOG_CAT = "ctrl.adminevaController";

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
		$this->setPageTitle('Manage evaluation tool');
	}

	public function actionIndex() {
		$this->render('index');
	}

	/**
	 * @param bool $ajax
	 */
	public function actionListEvaContext($ajax = false) {
		if($ajax) {
			$elementsArray = ModelToArray::convertModelToArray(EvaluationElements::model()->findAll());
			echo json_encode(['aaData' => $elementsArray]);
			return;
		}
		$this->menu = [
			['label' => 'Add Evaluation Context Field', 'url' => ['admineva/AddEvaContext']]
		];
		$this->render('evaContext/list');
	}

	public function actionAddEvaContext() {
		$elementModel = new EvaluationElements('insert');
		$form = new CForm(EvaluationElements::getFormElements(), $elementModel);
		$this->menu = [
			['label' => 'List Evaluation Context Fields', 'url' => ['admineva/listEvaContext']]
		];
		if($form->submitted('save') && $form->validate()) {
			$elementModel = $form->model;
			//print_r($elementModel); die;
			if($elementModel->save(false)) {
				Yii::app()->user->setFlash('success', 'The form field was created successfully');
				$this->redirect(['admineva/listEvaContext']);
				return;
			}
			Yii::app()->user->setFlash('error', 'The form field was not created successfully, please' .
				'try again or contact your administrator if the problem persists');
		}
		$this->render('evaContext/_form', [
			'form' => $form
		]);
	}

	/**
	 * @param $id
	 */
	public function actionUpdateEvaContext($id) {
		$elementModel = EvaluationElements::model()->findByPk($id);
		if(!empty($elementModel)) {
			$form = new CForm(EvaluationElements::getFormElements(), $elementModel);
			$this->menu = [
				['label' => 'Add Evaluation Context Field', 'url' => ['admineva/AddEvaContext']],
				['label' => 'List Evaluation Context Fields', 'url' => ['admineva/listEvaContext']]
			];
			if($form->submitted('save') && $form->validate()) {
				$elementModel = $form->model;
				if($elementModel->save(false)) {
					Yii::app()->user->setFlash('success', 'The form field was updated successfully');
					$this->redirect(['admineva/listEvaContext']);
					return;
				}
				Yii::app()->user->setFlash('error', 'The form field was not updated successfully, please' .
					'try again or contact your administrator if the problem persists');
			}
			$this->render('evaContext/_form', [
				'form' => $form
			]);
			return;
		}
		Yii::app()->user->setFlash('error', 'The selected item does not exist or has been deleted');
		$this->redirect(['admineva/listEvaContext']);
	}

	/**
	 * @param $id
	 */
	public function actionDeleteEvaContext($id) {
		Yii::log("actionDeleteEvaContext called", "trace", self::LOG_CAT);
		if(EvaluationElements::model()->deleteByPk($id) > 0) {
			echo 'Form field successfully deleted';
			return;
		}
		echo 'An error occurred when deleting the form field, ' .
			'please try again or contact your administrator if the problem persists';
		return;

	}

	/**
	 * @param bool $ajax
	 * @return void
	 */
	public function actionListEvaMethods($ajax = false) {
		Yii::log("actionListEvaMethods called", "trace", self::LOG_CAT);
		$this->setPageTitle(Yii::app()->name . ' - List Evaluation Methods');
		$dataProvider = new CActiveDataProvider('EconEvaMethods');
		//print_r(ModelToArray::convertModelToArray($dataProvider->getData())); die;
		if($ajax) {
			$data = ['aaData' => ModelToArray::convertModelToArray($dataProvider->getData())];
			echo json_encode($data, JSON_UNESCAPED_SLASHES);
			return;
		}
		$this->render('evaMethods/list', ['dataProvider' => $dataProvider]);
	}

	/**
	 * @param $id
	 */
	public function actionDeleteEvaMethod($id) {
		Yii::log("actionDeleteEvaMethod called", "trace", self::LOG_CAT);
		if(EconEvaMethods::model()->deleteByPk($id) > 0) {
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
		$buttonParam = ['name' => 'add', 'label' => 'Add'];
		$config['buttons'] = ContextController::getButtons($buttonParam, 'admin/listEvaMethods');
		unset($config['buttons']['cancel']);
		$model = new EconEvaMethods();
		$form = new CForm($config, $model);
		if($form->submitted('add') && $form->validate()) {
			$model = $form->model;
			if($model->save(false)) {
				Yii::app()->user->setFlash('success', 'Economic evaluation method add successfully');
				$this->redirect(['admineva/listEvaMethods']);
			}
			Yii::app()->user->setFlash('error',
				'An error occurred while saving, please try again or contact your administrator if the problem persists');
		}
		//var_dump($model, $form); die;
		$this->render('evaMethods/add', ['form' => $form]);

	}

	/**
	 * @param $id
	 * @return void
	 */
	public function actionUpdateEvaMethod($id) {
		Yii::log("actionUpdateEvaMethod called", "trace", self::LOG_CAT);
		$config = self::getEvaMethodsFormConfig();
		$buttonParam = ['name' => 'update', 'label' => 'Update'];
		$config['buttons'] = ContextController::getButtons($buttonParam, 'admin/listEvaMethods');
		$model = EconEvaMethods::model()->findByPk($id);
		if(is_null($model)) {
			Yii::app()->user->setFlash('notice', 'That economic evaluation method does not exist.');
			$this->redirect(['admineva/listEvaMethods']);
			return;
		}
		unset($config['buttons']['cancel']);
		$form = new CForm($config, $model);
		if($form->submitted('update') && $form->validate()) {
			$model = $form->model;
			if($model->save(false)) {
				Yii::app()->user->setFlash('success', 'Economic evaluation method updated successfully');
				$this->redirect(['admineva/listEvaMethods']);
			}
			Yii::app()->user->setFlash('error',
				'An error occurred while updating, please try again or contact ' .
				'your administrator if the problem persists');
		}
		$this->render('evaMethods/update', ['form' => $form]);

	}

	/**
	 * @return array
	 */
	private function getEvaMethodsFormConfig() {
		$elements = ContextController::getDefaultElements();
		$elements['elements'] = [
			'buttonName' => [
				'type' => 'text'
			],
			'link' => [
				'type' => 'text'
			],
			'description' => [
				'type' => 'text'
			]
		];
		return $elements;
	}
}
