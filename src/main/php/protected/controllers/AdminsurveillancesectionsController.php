<?php

/**
 * Created by PhpStorm.
 * User: james
 * Date: 10/1/15
 * Time: 9:53 AM
 */
class AdminsurveillancesectionsController extends RiskController {

	public $menu = [];
	public $layout='//layouts/column2';

	/**
	 * @param $id
	 * @throws CHttpException
	 */
	public function actionUpdate($id) {
		$model = $this->loadModel($id);

		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);
		$formElements = [
			'title' => 'Update ' . $model->sectionName . ' description',
			'elements' => [
				'<label>Section Name</label><span>' . $model->sectionName . '</span>',
				'description' => [
					'type' => 'textarea'
				]
			],
			'buttons' => [
				'save' => [
					'type' => 'submit',
					'label' => 'Save'
				]
			]
		];
		$form = new CForm($formElements, $model);
		if ($form->submitted('save') && $form->validate()) {

			if ($model->save()) {
				Yii::app()->user->setFlash('success', 'Surveillance section description updated successfully');
				$this->redirect(['index']);
			}
			Yii::app()->user->setFlash('error', 'Surveillance section description not updated successfully,' .
				' please contact your administrator');
		}

		$this->render('update', [
			'model' => $model,
			'form' => $form
		]);
	}


	/**
	 * @param bool $ajax
	 */
	public function actionIndex($ajax = false) {
		if($ajax) {
			$dataProvider = new CActiveDataProvider('SurveillanceSections',
				[
					'criteria' => [
						'condition' => "tool='surveillance'",
						'select' => 'sectionId, sectionName, description'
					]
				]);
			echo CJSON::encode(['aaData' => $dataProvider->getData()]);
			return;

		}
		$this->render('index');
	}

	public function loadModel($id) {
		$model = SurveillanceSections::model()->findByPk($id);
		if ($model === null) {
			throw new CHttpException(404, 'The requested page does not exist.');
		}
		return $model;
	}

	public function actionHome() {
		$this->render('home');
	}
}