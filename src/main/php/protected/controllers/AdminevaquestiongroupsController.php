<?php

class Adminevaquestiongroupscontroller extends RiskController {
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
		$model = new EvaQuestionGroups();
		$model->section = 'econEvaMethods';
		$model->setIsNewRecord(false);
		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);
		if (isset($_POST['EvaQuestionGroups'])) {
			$model->attributes = $_POST['EvaQuestionGroups'];
			if ($model->save()) {
				Yii::app()->user->setFlash('success', 'Association added successfully');
				$this->redirect(['index']);
			} elseif(!$model->hasErrors()) {
				Yii::app()->user->setFlash('error', 'A problem occurred while adding the association, ' .
					'please try again or contact your administrator if the problem persists');

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
		$model = $this->loadModel();
		$questionsArray = json_decode($model->questions, true);
		if(isset($questionsArray[$id])) {
			$model->questions = $questionsArray[$id];
		}
		$model->method = $id;
		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);
		if (isset($_POST['EvaQuestionGroups'])) {
			$model->attributes = $_POST['EvaQuestionGroups'];
			if ($model->save()) {
				Yii::app()->user->setFlash('success', 'Association added successfully');
				$this->redirect(['index']);
			} elseif(!$model->hasErrors()) {
				Yii::app()->user->setFlash('error', 'A problem occurred while adding the association, ' .
					'please try again or contact your administrator if the problem persists');

			}
		}

		$this->render('update', [
			'model' => $model,
		]);
	}


	/**
	 * Deletes a particular model.
	 * @param integer $id the ID of the model to be deleted
	 */
	public function actionDelete($id) {
		$model = $this->loadModel($id);
		$model->method = $id;
		$model->scenario = 'delete';
		if ($model->save()) {
			echo 'Association removed successfully';
			return;
		}
		echo 'An error occurred when removing the association';
		return;
	}

	/**
	 * Lists all models.
	 * @param $ajax bool
	 */
	public function actionIndex($ajax = false) {
		if($ajax) {
			$dataProvider = EvaQuestionGroups::model()->find('section=:section', [':section' => 'econEvaMethods']);
			echo json_encode(['aaData' => $this->getAssociationData($dataProvider->questions)]);
			return;
		}
		$this->render('index');
	}

	/**
	 * @param $questions
	 * @return array
	 */
	private function getAssociationData($questions) {
		$questionArray = json_decode($questions, true);
		$econMethods = array_keys($questionArray);
		$methodQuestions = [];
		foreach($questionArray as $questionGroup) {
			//print_r($questionArray); die;
			$methodQuestions = array_merge($methodQuestions, $questionGroup);
		}
		//print_r($methodQuestions); die;
		$questionCriteria = new CDbCriteria();
		$questionCriteria->addInCondition('evalQuestionId', $methodQuestions);
		$rsQuestions = EvaluationQuestion::model()->findAll($questionCriteria);
		$econMethodCriteria = new CDbCriteria();
		$econMethodCriteria->addInCondition('id', $econMethods);
		$rsEconMethod = EconEvaMethods::model()->findAll($econMethodCriteria);
		$associationData = [];
		foreach($rsEconMethod as $methodKey => $method) {
			//print_r($questionArray);
			//print_r($method);
			$associationData[$methodKey]['methodName'] = $method->buttonName;
			$associationData[$methodKey]['methodId'] = $method->id;
				$associationData[$methodKey]['questions'] = '<ul>';
			foreach($rsQuestions as $question) {

				if(isset(array_flip($questionArray[$method->id])[$question->evalQuestionId])) {
					$associationData[$methodKey]['questions'] .= CHtml::tag('li', [],
						$question->questionNumber . ' ' . $question->question);
				}
			}
			$associationData[$methodKey]['questions'] .= '</ul>';


		}
		return $associationData;
	}

	/**
	 * Returns the data model based on the primary key given in the GET variable.
	 * If the data model is not found, an HTTP exception will be raised.
	 * @return EvaQuestionGroups the loaded model
	 * @throws CHttpException
	 */
	public function loadModel() {
		$model = EvaQuestionGroups::model()->findByAttributes(['section' => 'econEvaMethods']);
		if ($model === null) {
			throw new CHttpException(404, 'The requested page does not exist.');
		}
		return $model;
	}

	/**
	 * Performs the AJAX validation.
	 * @param EvaQuestionGroups $model the model to be validated
	 */
	protected function performAjaxValidation($model) {
		if (isset($_POST['ajax']) && $_POST['ajax'] === 'eva-question-groups-form') {
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}
	}
}
