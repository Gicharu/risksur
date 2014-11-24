<?php

class UsersController extends Controller
{
	/**
	 * @var string the default layout for the views. Defaults to '//layouts/column2', meaning
	 * using two-column layout. See 'protected/views/layouts/column2.php'.
	 */
	public $layout='//layouts/column2';
	public $page;
	private	$configuration;
	const LOG_CAT = "ctrl.OptionsController";

	/**
	 * Creates a new model.
	 * If creation is successful, the browser will be redirected to the 'index' page.
	 */
	public function actionCreate()
	{
		$model=new Users;
		if(isset($_POST['Users']))
		{
			$model->attributes=$_POST['Users'];
			// Check for blanks
			if ($model->userName == "" || $model->email == "" || $model->password == "") {
				Yii::app()->user->setFlash('error', 'All fields must be filled in!');
				$this->render('create', array(
					'model' => $model
				));
				return;
			}
			// Check for invalid email address
			if (!filter_var($model->email, FILTER_VALIDATE_EMAIL)) {
				Yii::app()->user->setFlash('error', 'Enter a valid email address!');
				$this->render('create', array(
					'model' => $model
				));
				return;
			}
			// Check for password mismatch
			if ($model->confirmPassword !== $model->password) {
				Yii::app()->user->setFlash('error', 'Password mismatch! Re-type the password');
				$this->render('create', array(
					'model' => $model
				));
				return;
			}
			//check if user exists
			$findEmail = Users::model()->find("email = '".$model->email."'");
			if (empty($findEmail)){
				$findUsername = Users::model()->find("userName = '".$model->userName."'");
				if (empty($findUsername)) {
					if ($model->validate()) {
						if($model->save()){
							//$roles = new Roles; //add roles to users_has_roles table
							//$roles->users_id = $model->userId;
							//$roles->roles_id = "3"; // Insert roleId 3
							//$roles->save();
							Yii::app()->user->setFlash('success', "User successfully created.");
							$this->redirect(array('users/index'));
						}
					}
				} else {
					Yii::app()->user->setFlash('error', 'Username already exists!');
					$this->render('create', array(
						'model' => $model
					));
					return;
				}
			} else {
				Yii::app()->user->setFlash('error', 'Email address already exists!');
				$this->render('create', array(
					'model' => $model
				));
				return;
			}
		}
		$this->render('create',array(
			'model'=>$model,
		));
	}

	/**
	 * Updates a particular model.
	 * If update is successful, the browser will be redirected to the 'view' page.
	 * @param integer $id the ID of the model to be updated
	 */
	public function actionUpdate()
	{
		if (isset($_GET['userId'])) {
			$model=$this->loadModel($_GET['userId']);
			if(isset($_POST['Users']))
			{
				$model->attributes=$_POST['Users'];
				// Check for password mismatch
				if ($model->confirmPassword !== $model->password) {
					Yii::app()->user->setFlash('error', 'Password mismatch! Re-type the password');
					$this->render('create', array(
						'model' => $model
					));
					return;
				}
				if($model->save()) {
					Yii::app()->user->setFlash('success', Yii::t("translation", "User successfully updated"));
					$this->redirect(array('users/index'));
				}
			}
			$this->render('update',array(
				'model'=>$model,
			));
		}
		
	}

	/**
	 * Deletes a particular model.
	 * If deletion is successful, the browser will be redirected to the 'index' page.
	 * @param integer $id the ID of the model to be deleted
	 */
	public function actionDelete()
	{
		if (isset($_POST["delId"])) {
			$this->loadModel($_POST["delId"])->delete();
			echo Yii::t("translation", "The user has been successfully deleted");
		}
	}

	/**
	 * Lists all models.
	 */
	public function actionIndex()
	{
		$dataProvider=new CActiveDataProvider('Users');
		$userListArray = array();
		$dataArray = array();
		$dataArray['dtHeader'] = "Manage Users"; // Set page title when printing the datatable
		// Format datatable data. Define the Edit & Delete buttons
		foreach ($dataProvider->getData() as $user) {
			$editButton = "<button id='editOption" . $user['userId'] . 
				"' type='button' class='bedit' onclick=\"window.location.href ='" . CController::createUrl('users/update/', array(
					'userId' => $user['userId'])
				) . "'\">Edit</button>";
				$deleteButton = "<button id='deleteOption" . $user['userId'] . 
				"' type='button' class='bdelete' onclick=\"$('#deleteBox').dialog('open');" . 
				"deleteConfirm('" . $user['userName'] . "', '" .
				$user['userId'] . "')\">Remove</button>";
			// Pack the data to be sent to the view
			$userListArray[] = array (
				'username' =>   $user['userName'],
				'email' =>   $user['email'],
				'editButton' => $editButton,
				'deleteButton' => $deleteButton
			);
		}
		$dataArray['usersList'] =  json_encode($userListArray);
		if (!empty($_GET['getUsers'])) {
			$jsonData = json_encode(array("aaData" => $userListArray));
			echo $jsonData;
			return ;
		}
		$this->render('index',array(
			'dataProvider'=>$dataProvider,
			'dataArray' => $dataArray
		));
	}

	/**
	 * Returns the data model based on the primary key given in the GET variable.
	 * If the data model is not found, an HTTP exception will be raised.
	 * @param integer $id the ID of the model to be loaded
	 * @return Users the loaded model
	 * @throws CHttpException
	 */
	public function loadModel($id)
	{
		$model=Users::model()->findByPk($id);
		if($model===null)
			throw new CHttpException(404,'The requested page does not exist.');
		return $model;
	}

	/**
	 * Performs the AJAX validation.
	 * @param Users $model the model to be validated
	 */
	protected function performAjaxValidation($model)
	{
		if(isset($_POST['ajax']) && $_POST['ajax']==='users-form')
		{
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}
	}
}
