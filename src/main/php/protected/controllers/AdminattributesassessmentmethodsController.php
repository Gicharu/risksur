<?php

class AdminAttributesAssessmentMethodsController extends RiskController {
	/**
	 * @var string the default layout for the views. Defaults to '//layouts/column2', meaning
	 * using two-column layout. See 'protected/views/layouts/column2.php'.
	 */
	public $layout = '//layouts/column2';


	/**
	 * Creates a new model.
	 * If creation is successful, the browser will be redirected to the 'view' page.
	 */
	public function actionCreate() {
		$model = new EvaAttributesAssessmentMethods;
		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);

		if (isset($_POST['EvaAttributesAssessmentMethods'])) {
			$model->attributes = $_POST['EvaAttributesAssessmentMethods'];
			if ($model->save()) {
				$this->redirect(['index']);
			}
		}

		$this->render('create', [
			'model' => $model,
		]);
	}

	/**
	 * Updates a particular model.
	 * If update is successful, the browser will be redirected to the 'view' page.
	 * @param integer $id the ID of the model to be updated
	 */
	public function actionUpdate($id) {
		$model = $this->loadModel($id);

		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);

		if (isset($_POST['EvaAttributesAssessmentMethods'])) {
			$model->attributes = $_POST['EvaAttributesAssessmentMethods'];
			if ($model->save()) {
				$this->redirect(['index']);
			}
		}

		$this->render('update', [
			'model' => $model,
		]);

	}

	/**
	 * Deletes a particular model.
	 * If deletion is successful, the browser will be redirected to the 'admin' page.
	 * @param integer $id the ID of the model to be deleted
	 */
	public function actionDelete($id) {

		if ($this->loadModel($id)->delete()) {
			echo 'Evaluation assessment method deleted successfully';
			return;
		}
		echo 'An error occurred when deleting the evaluation assessment method';
		return;
	}

	/**
	 * Lists all models.
	 * @param $ajax bool
	 */
	public function actionIndex($ajax = false) {
		if($ajax) {
			$dataProvider = new CActiveDataProvider('EvaAttributesAssessmentMethods', [
				'criteria' => [
					'with' => ['evaAttributes']
				]
			]);
			//print_r(ModelToArray::convertModelToArray($dataProvider->getData())); die;
			echo json_encode(['aaData' => ModelToArray::convertModelToArray($dataProvider->getData())]);
			return;
		}
		$this->render('index');
	}

	/**
	 * @return array
	 */
	public static function getEvaAttributes() {
		return CHtml::listData(EvaAttributes::model()
			->findAll(['select' => 'attributeId, name']), 'attributeId', 'name');
	}


	/**
	 * Returns the data model based on the primary key given in the GET variable.
	 * If the data model is not found, an HTTP exception will be raised.
	 * @param integer $id the ID of the model to be loaded
	 * @return EvaAttributesAssessmentMethods the loaded model
	 * @throws CHttpException
	 */
	public function loadModel($id) {
		$model = EvaAttributesAssessmentMethods::model()->findByPk($id);
		if ($model === null) {
			throw new CHttpException(404, 'The requested page does not exist.');
		}
		return $model;
	}

	/**
	 * Performs the AJAX validation.
	 * @param EvaAttributesAssessmentMethods $model the model to be validated
	 */
	protected function performAjaxValidation($model) {
		if (isset($_POST['ajax']) && $_POST['ajax'] === 'eva-attributes-assessment-methods-form') {
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}
	}
}
