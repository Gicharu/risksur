<?php

class SurFormDetailsController extends Controller {
    /**
     * @var string the default layout for the views. Defaults to '//layouts/column2', meaning
     * using two-column layout. See 'protected/views/layouts/column2.php'.
     */
    public $layout = '//layouts/column2';

    /**
     * @return array
     */
    public function filters() {
        Yii::log("filters called", "trace", self::LOG_CAT);
        return array(array('application.filters.RbacFilter',),);
    }

    /**
     * Creates a new model.
     * If creation is successful, the browser will be redirected to the 'index' page.
     */
    public function actionCreate() {
        $model = new SurFormDetails;

        // Uncomment the following line if AJAX validation is needed
        // $this->performAjaxValidation($model);

        if (isset($_POST['SurFormDetails'])) {
            $model->attributes = $_POST['SurFormDetails'];
            Yii::app()->user->setFlash("success", "Form element added successfully");
            if ($model->save()) {
                $this->redirect(array('index'));
                return;
            }
        }

        $this->render('create', array('model' => $model,));
    }


    /**
     * @throws CHttpException
     */
    public function actionUpdate() {
        if (empty($_GET['id'])) {
            throw new CHttpException(404, "The requested surveilance form cannot be found");
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

        $this->render('update', array('model' => $model,));
    }

    /**
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
     * Lists all models.
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
        $this->render('index', array('surFormsArray' => $surFormsArray,));
    }


    /**
     * @return Void
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
        if ($model === null) throw new CHttpException(404, 'The requested page does not exist.');
        return $model;
    }

    /**
     * Performs the AJAX validation.
     * @param SurFormDetails $model the model to be validated
     */
    protected function performAjaxValidation($model) {
        if (isset($_POST['ajax']) && $_POST['ajax'] === 'sur-form-details-form') {
            echo CActiveForm::validate($model);
            Yii::app()->end();
        }
    }
}
