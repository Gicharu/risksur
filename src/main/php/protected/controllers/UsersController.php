<?php

/**
 * UsersController 
 * 
 * @uses Controller
 * @package 
 * @version $id$
 * @copyright Tracetracker
 * @license Tracetracker {@link http://www.tracetracker.com}
 */
class UsersController extends Controller {
	/**
	 * @var string the default layout for the views. Defaults to '//layouts/column2', meaning
	 * using two-column layout. See 'protected/views/layouts/column2.php'.
	 */
	public $layout = '//layouts/column2';
	public $page;
	private	$configuration;
	const LOG_CAT = "ctrl.OptionsController";

	/**
	 * filters
	 *
	 * @access public
	 * @return void
	 */
	public function filters() {
		return array(
			array(
				'application.filters.RbacFilter',
			),
		);
	}
	/**
	 * Creates a new model.
	 * If creation is successful, the browser will be redirected to the 'index' page.
	 */
	public function actionCreateUser()
	{
		Yii::log("actionCreate called", "trace", self::LOG_CAT);
		$cancelLink = $this->createUrl('site/login');
		$model = new Users;
		if(isset($_POST['Users'])) {
			$model->attributes=$_POST['Users'];
			$model->roles = $_POST['Users']['roles'];
			// Check for blanks
			if ($model->userName == "" || $model->email == "" || $model->roles == "") {
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
			//check if user exists
			$findEmail = Users::model()->find("email = '".$model->email."'");
			if (empty($findEmail)) {
				$findUsername = Users::model()->find("userName = '".$model->userName."'");
				if (empty($findUsername)) {
					if ($model->validate()) {
						if($model->save() && $model->saveRoles($model->userId, "create")){
							// send the user the email link:
							$toMailName = $model->userName;
							$email = $model->email;
							// construct data and set expiry to 24 hrs
							$resetEncrypt = base64_encode($email . ",resetTrue,". (strtotime(date("H:i:s")) + 86400));
							$passwordUrl = "http://" . $_SERVER["HTTP_HOST"] . Yii::app()->request->baseUrl . "/index.php/site/changepassword?data=$resetEncrypt" . 
								"&redirect_uri=" . $cancelLink;
							$mail = new TTMailer();
							$subject = Yii::t('translation', 'User created');
							$altBody = Yii::t('translation', 'To view the message, please use an HTML compatible email viewer!');
							$message = Yii::t('translation', 'Dear ') . $toMailName . ',<br /><br />' .
							Yii::t('translation', 'your user account has been created, please visit ');
							$message .= '<a href="' . $passwordUrl . '">' . $passwordUrl . '</a>' .
							Yii::t('translation', ' to activate it and set a new password. ') .
							'<p></p>' . Yii::t('translation', 'This message was automatically generated.') . '<br />' .
							Yii::t('translation', ' If you think it was sent incorrectly, ') .
							Yii::t('translation', 'please contact your administrator.');
							//if mail is not sent successfully issue appropriate message
							if (!$mail->ttSendMail($subject, $altBody, $message, $email, $toMailName)) {
								Yii::log("Error in sending the password to the user", "error", self::LOG_CAT);
								$msg = Yii::t('translation', "Error in sending the password to the user");
								return $msg;
							}
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
		$this->render('create', array(
			'model' => $model,
		));
	}

	/**
	 * Updates a particular model.
	 * If update is successful, the browser will be redirected to the 'view' page.
	 * @param integer $id the ID of the model to be updated
	 */
	public function actionUpdateUser() {
		Yii::log("actionUpdate called", "trace", self::LOG_CAT);
		if (isset($_GET['userId'])) {
			$model = Users::model()->findByAttributes(array( 'userId' => $_GET['userId'] ));
			$role = UsersHasRoles::model()->findByAttributes(array( 'users_id' => $_GET['userId'] ));
			$model->roles = $role->roles_id;
			if(isset($_POST['Users'])) {
				$model->attributes=$_POST['Users'];
				$model->roles = $_POST['Users']['roles'];
				if($model->update() && $model->saveRoles($_GET['userId'], 'update')) {
					Yii::app()->user->setFlash('success', Yii::t("translation", "User successfully updated"));
					$this->redirect(array('users/index'));
				}
			}
			$this->render('update', array(
				'model'=>$model,
			));
		}
		
	}

	/**
	 * Deletes a particular model.
	 * If deletion is successful, the browser will be redirected to the 'index' page.
	 * @param integer $id the ID of the model to be deleted
	 */
	public function actionDeleteUser() {
		Yii::log("actionDelete called", "trace", self::LOG_CAT);
		if (isset($_POST["delId"])) {
			$this->loadModel($_POST["delId"])->delete();
			echo Yii::t("translation", "The user has been successfully deleted");
		}
	}

	/**
	 * Lists all models.
	 */
	public function actionIndex() {
		$dataProvider = new CActiveDataProvider('Users');
		$userListArray = array();
		$dataArray = array();
		$dataArray['dtHeader'] = "Manage Users"; // Set page title when printing the datatable
		// Format datatable data. Define the Edit & Delete buttons
		foreach ($dataProvider->getData() as $user) {
			$editButton = "<button id='editOption" . $user['userId'] . 
				"' type='button' class='bedit' onclick=\"window.location.href ='" . CController::createUrl('users/updateUser/', array(
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
		$this->render('index', array(
			'dataProvider' => $dataProvider,
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
	public function loadModel($id) {
		$model=Users::model()->findByPk($id);
		if($model === null)
			throw new CHttpException(404, 'The requested page does not exist.');
		return $model;
	}
}