<?php
/**
 * AdminController
 * @uses RiskController
 * @copyright TraceTracker
 * @author Chirag Doshi <james@tracetracker.com>
 * @license TraceTracker {@link http://www.tracetracker.com}
 */
class AdminEvaController extends RiskController {
	//public $page;
	private	$configuration;
	const LOG_CAT = "ctrl.AdminEvaluationController";

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

	public function actionIndex() {
		$this->render('evaContext/index');
	}

	public function actionListEvaContext($ajax = false) {
		if($ajax) {
			$elementsArray = ModelToArray::convertModelToArray(EvaluationElements::model()->findAll());
			echo json_encode(['aaData' => $elementsArray]);
			return;
		}
		$this->menu = [
			['label' => 'Add Evaluation Context Field', 'url' => ['adminEva/AddEvaContext']]
		];
		$this->render('evaContext/list');
	}

	public function actionUpdateEvaContext($id) {
		$elementModel = EvaluationElements::model()->findByPk($id);
		if(!empty($elementModel)) {
			$form = new CForm(EvaluationElements::getFormElements(), $elementModel);
			$this->menu = [
				['label' => 'Add Evaluation Context Field', 'url' => ['adminEva/AddEvaContext']],
				['label' => 'List Evaluation Context Fields', 'url' => ['adminEva/listEvaContext']]
			];
			if($form->submitted('save') && $form->validate()) {
				$elementModel = $form->model;
				if($elementModel->save(false)) {
					Yii::app()->user->setFlash('success', 'The form field was updated successfully');
					$this->redirect(['adminEva/listEvaContext']);
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
		$this->redirect(['adminEva/listEvaContext']);
	}

	public function actionDeleteEvaContext($evaContextId) {
		Yii::log("actionDeleteEvaContext called", "trace", self::LOG_CAT);
		if(EvaMethods::model()->deleteByPk($evaContextId) > 0) {
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
