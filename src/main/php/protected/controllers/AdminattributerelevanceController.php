<?php

/**
 * Created by PhpStorm.
 * User: james
 * Date: 7/31/15
 * Time: 4:04 PM
 */
class AdminattributerelevanceController extends RiskController {

	public $layout = '//layouts/column2';

	public function actionCreate() {
		$modelArray[] = new EvaAttributesMatrix();

		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);

		if (isset($_POST['EvaAttributesMatrix'])) {
			//$model = new EvaAttributesMatrix();
			$success = true;
			$transaction = Yii::app()->db->beginTransaction();
			try {
				foreach($_POST['EvaAttributesMatrix'] as $index => $row) {
					$modelArray[$index] = new EvaAttributesMatrix();
					$modelArray[$index]->unsetAttributes();
					$modelArray[$index]->attributes = $row;
					if (!$modelArray[$index]->validate()) {
						$success = false;
						break;
					}
					$modelArray[$index]->save(false);
				}
				if($success) {
					$transaction->commit();
					Yii::app()->user->setFlash('success', 'Attribute relevance saved successfully');
					$this->redirect('index');
					return;

				}
			} catch (Exception $e) {
				$transaction->rollBack();
				Yii::log($e->getMessage(), 'error', 'ctrl.Attributerelevance');
				Yii::app()->user->setFlash('error', 'An error occurred, ' .
					'please try again or contact you administrator if the problem persists');
			}

		}
		$this->menu = [
			['label' => 'List Attribute Relevance', 'url' => $this->createUrl('index')]
		];
		$this->render('create', [
			'model' => $modelArray,
		]);
	}


	/**
	 * @param $index
	 */
	public function actionAddMatrixRow($index) {
		$index++;
		$this->renderPartial('_evaMatrixAsTable', [
			'model' => new EvaAttributesMatrix(),
			'index' => $index
		], false, true);
		return;
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
				$this->redirect(['index']);
			}
		}
		$dropDownData = [];
		$survObjCriteria = new CDbCriteria();
		$survObjCriteria->with = ['options'];
		$survObjCriteria->select = 'inputName';
		$survObjCriteria->condition = "inputName='survObj' AND options.frameworkFieldId=t.id";

		$rsSurveillanceObjective = FrameworkFields::model()->find($survObjCriteria);
		$dropDownData['objectives'] = CHtml::listData($rsSurveillanceObjective->options, 'optionId', 'label');

		$rsQuestionGrp = EvaQuestionGroups::model()->find(['select' => 'questions']);
		$questionsArray = array_keys((array) json_decode($rsQuestionGrp->questions));
		$dropDownData['groups'] = array_combine($questionsArray, range(1, count($questionsArray)));

		//print_r($dropDownData['groups']); die;

		$dropDownData['attributes'] = CHtml::listData(EvaAttributes::model()->findAll(), 'attributeId', 'name');
		$this->menu = [
			['label' => 'Add Attribute Relevance', 'url' => $this->createUrl('create')],
			['label' => 'List Attribute Relevance', 'url' => $this->createUrl('index')]
		];
		$this->render('update', [
			'model' => $model,
			'dropDownData' => $dropDownData
		]);
	}

	/**
	 * Deletes a particular model.
	 * @param integer $id the ID of the model to be deleted
	 */
	public function actionDelete($id) {
		if($this->loadModel($id)->delete()) {
			echo 'Attribute relevance deleted successfully';
			return;
		}
		echo "An error occurred while deleting the attribute relevance, please contact your administrator";
		return;
	}

	/**
	 * Lists all models.
	 *
	 * @param string $ajax
	 */
	public function actionIndex($ajax = '0') {
		$model = ModelToArray::convertModelToArray(EvaAttributesMatrix::model()
			->with('objective', 'attribute')
			->findAll(), ['evaAttributes' => 'attributeId, name', 'options' => 'optionId, label']);
		if($ajax) {
			echo json_encode(['aaData' => $model]);
			return;
		}
		$this->menu = [
			['label' => 'Add Attribute', 'url' => ['adminattributerelevance/create']],
			//['label' => 'What are question groups?', 'url' => '#', 'linkOptions' => ['class' => 'qGroups']],
		];
		$this->render('index', [
			'model' => $model,
		]);
	}
	// @todo an accordion that pops up to explain the various question groups
	public function actionGetQuestionGroups(){
		//$rsQuestions = Evaqu

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