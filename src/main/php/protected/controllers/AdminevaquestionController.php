<?php

class AdminevaquestionController extends RiskController {
	/**
	 * @var string the default layout for the views. Defaults to '//layouts/column2', meaning
	 * using two-column layout. See 'protected/views/layouts/column2.php'.
	 */
	public $layout = '//layouts/column2';

	/**
	 * Creates a new model.
	 * If creation is successful, the browser will be redirected to the 'view' page.
	 */
//	public function actionCreate() {
//		$model = new EvaluationQuestion;
//
//		// Uncomment the following line if AJAX validation is needed
//		// $this->performAjaxValidation($model);
//
//		if (isset($_POST['EvaluationQuestion'])) {
//			$model->attributes = $_POST['EvaluationQuestion'];
//			if ($model->save()) {
//				$this->redirect(['view', 'id' => $model->evalQuestionId]);
//			}
//		}
//
//		$this->render('create', [
//			'model' => $model,
//		]);
//	}

	/**
	 * Updates a particular model.
	 * If update is successful, the browser will be redirected to the 'view' page.
	 * @param integer $id the ID of the model to be updated
	 */
	public function actionUpdate($id) {
		$model = $this->loadModel($id);

		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);

		if (isset($_POST['EvaluationQuestion'])) {
			$model->attributes = $_POST['EvaluationQuestion'];
			if ($model->save()) {
				$this->redirect(['view', 'id' => $model->evalQuestionId]);
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
		$this->loadModel($id)->delete();

		// if AJAX request (triggered by deletion via admin grid view), we should not redirect the browser
		if (!isset($_GET['ajax'])) {
			$this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : ['admin']);
		}
	}

	/**
	 * Lists all models.
	 */
	public function actionIndex() {
		$dataProvider = new CActiveDataProvider('EvaluationQuestion');
		$this->render('index', [
			'dataProvider' => $dataProvider,
		]);
	}

	/**
	 * Returns the data model based on the primary key given in the GET variable.
	 * If the data model is not found, an HTTP exception will be raised.
	 * @param integer $id the ID of the model to be loaded
	 * @return EvaluationQuestion the loaded model
	 * @throws CHttpException
	 */
	public function loadModel($id) {
		$model = EvaluationQuestion::model()->findByPk($id);
		if ($model === null) {
			throw new CHttpException(404, 'The requested page does not exist.');
		}
		return $model;
	}

	/**
	 * Performs the AJAX validation.
	 * @param EvaluationQuestion $model the model to be validated
	 */
	protected function performAjaxValidation($model) {
		if (isset($_POST['ajax']) && $_POST['ajax'] === 'evaluation-question-form') {
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}
	}
}
