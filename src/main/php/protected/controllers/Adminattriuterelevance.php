<?php

/**
 * Created by PhpStorm.
 * User: james
 * Date: 7/31/15
 * Time: 4:04 PM
 */
class Adminattriuterelevance extends RiskController {

	public function actionCreate() {
		$model = new EvaAttributesMatrix;

		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);

		if (isset($_POST['EvaAttributesMatrix'])) {
			$model->attributes = $_POST['EvaAttributesMatrix'];
			if ($model->save()) {
				$this->redirect(['view', 'id' => $model->id]);
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

		if (isset($_POST['EvaAttributesMatrix'])) {
			$model->attributes = $_POST['EvaAttributesMatrix'];
			if ($model->save()) {
				$this->redirect(['view', 'id' => $model->id]);
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
		$model = new CActiveDataProvider('EvaAttributesMatrix');
		$this->render('index', [
			'dataProvider' => $dataProvider,
		]);
	}


	/**
	 * Returns the data model based on the primary key given in the GET variable.
	 * If the data model is not found, an HTTP exception will be raised.
	 * @param integer $id the ID of the model to be loaded
	 * @return EvaAttributesMatrix the loaded model
	 * @throws CHttpException
	 */
	public function loadModel($id) {
		$model = EvaAttributesMatrix::model()->findByPk($id);
		if ($model === null) {
			throw new CHttpException(404, 'The requested page does not exist.');
		}
		return $model;
	}

	/**
	 * Performs the AJAX validation.
	 * @param EvaAttributesMatrix $model the model to be validated
	 */
	protected function performAjaxValidation($model) {
		if (isset($_POST['ajax']) && $_POST['ajax'] === 'eva-attributes-matrix-form') {
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}
	}

}