<?php

class AdmineconomicmethodsController extends RiskController {
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
		$model = new EconomicMethods();

		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);

		if (isset($_POST['EconomicMethods'])) {
			$model->attributes = $_POST['EconomicMethods'];
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

		if (isset($_POST['EconomicMethods'])) {
			$model->attributes = $_POST['EconomicMethods'];
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
			echo 'Economic method deleted successfully';
			return;
		}
		echo 'An error occurred when deleting the economic method';
		return;
	}

	/**
	 * Lists all models.
	 * @param $ajax bool
	 */
	public function actionIndex($ajax = false) {
		if($ajax) {
			$dataProvider = new CActiveDataProvider('EconomicMethods', [
				'criteria' => [
					'with' => ['econMethodGroup']
				]
			]);
//			print_r($dataProvider->getData()); die;
			echo json_encode(['aaData' => ModelToArray::convertModelToArray($dataProvider->getData())]);
			return;
		}
		$this->render('index');
	}


	/**
	 * Returns the data model based on the primary key given in the GET variable.
	 * If the data model is not found, an HTTP exception will be raised.
	 * @param integer $id the ID of the model to be loaded
	 * @return EconomicMethods the loaded model
	 * @throws CHttpException
	 */
	public function loadModel($id) {
		$model = EconomicMethods::model()->findByPk($id);
		if ($model === null) {
			throw new CHttpException(404, 'The requested page does not exist.');
		}
		return $model;
	}

	/**
	 * Performs the AJAX validation.
	 * @param EconomicMethods $model the model to be validated
	 */
	protected function performAjaxValidation($model) {
		if (isset($_POST['ajax']) && $_POST['ajax'] === 'economic-methods-form') {
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}
	}
}
