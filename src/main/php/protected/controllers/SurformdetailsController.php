<?php

	/**
	 * DesignController
	 *
	 * @package
	 * @author    James Njoroge <james@tracetracker.com>
	 * @copyright Tracetracker
	 * @version   $id$
	 * @uses      RiskController
	 * @license   Tracetracker {@link http://www.tracetracker.com}
	 */
	class SurformdetailsController extends RiskController {
		/**
		 * @var string the default layout for the views. Defaults to '//layouts/column2', meaning
		 * using two-column layout. See 'protected/views/layouts/column2.php'.
		 */
		public $layout = '//layouts/column2';


		/**
		 * actionCreate 
		 * 
		 * Creates a new model.
		 * If creation is successful, the browser will be redirected to the 'index' page.
		 * @access public
		 * @return void
		 */
		public function actionCreate() {
			$model = new SurFormDetails;

			// Uncomment the following line if AJAX validation is needed
			// $this->performAjaxValidation($model);

			if (isset($_POST['SurFormDetails'])) {
				$model->attributes = $_POST['SurFormDetails'];
				// Make the form to be active by default.
				$model->formId = 1;
				Yii::app()->user->setFlash("success", "Form element added successfully");
				if ($model->save()) {
					$this->redirect(array('index'));
					return;
				}
			}

			$this->render('create', array('model' => $model,));
		}


		/**
		 * actionUpdate 
		 * 
		 * @access public
		 * @return void
		 * @throws CHttpException
		 */
		public function actionUpdate() {
			if (empty($_GET['id'])) {
				Yii::app()->user->setFlash('error', Yii::t("translation", "Please select a form element to edit"));
				$this->redirect(array('surformdetails/index'));
			}
			$id = $_GET['id'];
			$model = $this->loadModel($id);

			// Uncomment the following line if AJAX validation is needed
			// $this->performAjaxValidation($model);

			if (isset($_POST['SurFormDetails'])) {
				$model->attributes = $_POST['SurFormDetails'];
				if ($model->save()) {
					$this->redirect(array('index'));
					return;
				}
			}

			$this->render('update', array('model' => $model, ));
		}

		/**
		 * actionDelete 
		 * 
		 * @access public
		 * @return void
		 * @throws CHttpException
		 */
		public function actionDelete() {
			if (empty($_POST['delId'])) {
				throw new CHttpException(400, "The requested form element cannot be found");
			}
			$id = $_POST['delId'];
			$this->loadModel($id)->delete();
			echo json_encode(array("Form element successfully deleted"));
			return;
			// if AJAX request (triggered by deletion via admin grid view), we should not redirect the browser
			//if (!isset($_GET['ajax'])) $this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array('admin'));
		}

		/**
		 * actionIndex 
		 * 
		 * Lists all models.
		 * @access public
		 * @return void
		 */
		public function actionIndex() {
//        $this->layout = '//layouts/column1';
			$surForms = SurFormDetails::model()->with('surFormElements')->findAll();
			$surFormsArray = array();
			if (!empty($surForms)) {
				foreach ($surForms as $surFormKey => $surForm) {
					$surFormsArray[$surFormKey] = $surForm->getAttributes();
					// resolve the formId using the surForm table
					$relations = $surForm->getRelated('surFormElements');
					$surFormsArray[$surFormKey]['formName'] = '';
					if (!empty($relations)) {
						$surFormsArray[$surFormKey]['formName'] = $relations->formName;
					}
				}
			}
			//print_r($surFormsArray);
			//die();
			if (isset($_GET['ajax'])) {
				echo json_encode(array("aaData" => $surFormsArray));
				return;
			}
			$this->render('index', array('surFormsArray' => $surFormsArray, ));
		}


		/**
		 * actionGetInputTypeOpts 
		 * 
		 * @access public
		 * @return void
		 */
		public function actionGetInputTypeOpts() {
			$optArray = array();
			if (!empty($_GET['subFormId'])) {
				$subFormId = $_GET['subFormId'];
				$options = Options::model()->findAll(array("condition" => "elementId = $subFormId", 'select' => 'val, label'));
				if (!empty($options)) {
					foreach ($options as $opt) {
						$optArray[] = $opt->getAttributes();
					}
				}
			}
			echo json_encode(array("aaData" => $optArray));
			return;

		}


		/**
		 * Returns the data model based on the primary key given in the GET variable.
		 * If the data model is not found, an HTTP exception will be raised.
		 * @param integer $id the ID of the model to be loaded
		 * @return SurFormDetails the loaded model
		 * @throws CHttpException
		 */
		public function loadModel($id) {
			$model = SurFormDetails::model()->findByPk($id);
			if ($model === null) {
				Yii::app()->user->setFlash('error', Yii::t("translation", "The form element does not exist"));
				$this->redirect(array('surformdetails/index'));
			}
			return $model;
		}

		/**
		 * performAjaxValidation 
		 * 
		 * Performs the AJAX validation.
		 * @param SurFormDetails $model the model to be validated
		 * @access protected
		 * @return void
		 */
		protected function performAjaxValidation($model) {
			if (isset($_POST['ajax']) && $_POST['ajax'] === 'sur-form-details-form') {
				echo CActiveForm::validate($model);
				Yii::app()->end();
			}
		}
	}
