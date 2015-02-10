<?php
/**
 * EvaluationController 
 * 
 * @uses Controller
 * @package 
 * @version $id$
 * @copyright Tracetracker
 * @author Chirag Doshi <chirag@tracetracker.com> 
 * @license Tracetracker {@link http://www.tracetracker.com}
 */
class EvaluationController extends Controller {
	const LOG_CAT = "ctrl.EvaluationController";
	public $layout = '//layouts/column2';
	/**
	 * filters 
	 * 
	 * @access public
	 * @return void
	 */
	public function filters() {
		Yii::log("filters called", "trace", self::LOG_CAT);
		return array(
			array(
				'application.filters.RbacFilter',
			),
		);
	}
	/**
	 * actionIndex 
	 * 
	 * @access public
	 * @return void
	 */
	public function actionIndex() {
		Yii::log("actionIndex EvaluationController called", "trace", self::LOG_CAT);

			$model = new EvaluationHeader;
			$dataArray = array();
			$dataArray['dtHeader'] = "Evaluation List";
			$dataArray['evalList'] = json_encode(array());

			// get list of evaluation
			$evalList = EvaluationHeader::model()->with("designFrameworks")->findAll(array(
				'condition' => 't.userId=:userId',
				'params' => array(
					':userId' => Yii::app()->user->id,
				),
			));
			//print_r($evalList); die();
			$evalListArray = array();
			// format datatable data
			foreach ($evalList as $eval) {
				$deleteButton = "";
				//if (Yii::app()->user->name != $valu['userName']) {
				$deleteButton = "<button id='deleteDesign" . $eval->evalId .
					"' type='button' class='bdelete' onclick=\"$('#deleteBox').dialog('open');" .
					"deleteConfirm('" . $eval->evaluationName . "', '" .
					$eval->evalId . "')\">Remove</button>";
				//}
				//print_r($eval->designFrameworks); die();
				$evalListArray[] = array(
					'evalId' => $eval->evalId,
					'name' => $eval->evaluationName,
					'userId' => $eval->userId,
					'description' => $eval->evaluationDescription,
					'design' => $eval->frameworkId,
					'frameworkName' => $eval->designFrameworks[0]->name,
					//'frameworkName' => $eval->frameworkId,
					'deleteButton' => $deleteButton
				);
			}
			$dataArray['evalList'] = json_encode($evalListArray);

			if (!empty($_GET['getDesigns'])) {
				$jsonData = json_encode(array("aaData" => $evalListArray));
				echo $jsonData;
				return;
			}
			$this->render('index', array(
				'model' => $model,
				'dataArray' => $dataArray
			));
	}

	/**
	 * actionEvaToolPage 
	 * 
	 * @access public
	 * @return void
	 */
	public function actionEvaPage() {
		Yii::log("actionEvaPage called", "trace", self::LOG_CAT);

		$model = DocPages::model()->findByPk("1");
		$userId = Yii::app()->user->id;

		// check if the user has roles 1 or 2 - admin roles
		$userRoles = UsersHasRoles::model()->findAll(array(
			'condition' => 't.users_id = :users_id AND (t.roles_id = :roleA OR t.roles_id = :roleB)',
			'params' => array(
				':users_id' => $userId,
				':roleA' => 1,
				':roleB' => 2
			),
		));
		$editButton = false;
		if (!empty($userRoles)) {
			$editButton = true;
		}
		$editPage = false;
		if (!empty($_GET['edit']) && $_GET['edit'] == 1) {
			$editPage = true;
		}

		$this->render('evaPage', array(
			'model' => $model,
			'editButton' => $editButton,
			'editPage' => $editPage
		));
	}

	/**
	 * actionEvaConcept 
	 * 
	 * @access public
	 * @return void
	 */
	public function actionEvaConcept() {
		Yii::log("actionEvaConcept called", "trace", self::LOG_CAT);

		$model = DocPages::model()->findByPk("2");
		$userId = Yii::app()->user->id;

		// check if the user has roles 1 or 2 - admin roles
		$userRoles = UsersHasRoles::model()->findAll(array(
			'condition' => 't.users_id = :users_id AND (t.roles_id = :roleA OR t.roles_id = :roleB)',
			'params' => array(
				':users_id' => $userId,
				':roleA' => 1,
				':roleB' => 2
			),
		));
		$editButton = false;
		if (!empty($userRoles)) {
			$editButton = true;
		}
		$editPage = false;
		if (!empty($_GET['edit']) && $_GET['edit'] == 1) {
			$editPage = true;
		}
		$this->render('evaConcept', array(
			'model' => $model,
			'editButton' => $editButton,
			'editPage' => $editPage
		));
	}

	/**
	 * actionSaveEvaPage 
	 * 
	 * @access public
	 * @return void
	 */
	public function actionSaveEvaPage() {
		Yii::log("actionSaveEvaPage called", "trace", self::LOG_CAT);
		$model = DocPages::model()->findByPk("1");
		if (isset($_POST['redactor'])) {
			$model->docData = self::clearTags($_POST['redactor']);
			$model->update();
		}
		echo json_encode(array());
	}

	/**
	 * actionSaveEvaConcept 
	 * 
	 * @access public
	 * @return void
	 */
	public function actionSaveEvaConcept() {
		Yii::log("actionSaveEvaConcept called", "trace", self::LOG_CAT);
		$model = DocPages::model()->findByPk("2");
		if (isset($_POST['redactor'])) {
			$model->docData = self::clearTags($_POST['redactor']);
			$model->update();
		}
		echo json_encode(array());
	}

	/**
	 * actionImageUpload 
	 * 
	 * @access public
	 * @return void
	 */
	public function actionImageUpload() {
		// files storage folder
		$dir = dirname(Yii::app()->request->scriptFile) . '/images/customImageUpload/';
		$_FILES['file']['type'] = strtolower($_FILES['file']['type']);

		if ($_FILES['file']['type'] == 'image/png'
		|| $_FILES['file']['type'] == 'image/jpg'
		|| $_FILES['file']['type'] == 'image/gif'
		|| $_FILES['file']['type'] == 'image/jpeg'
		|| $_FILES['file']['type'] == 'image/pjpeg') {
			// setting file's mysterious name
			$filename = md5(date('YmdHis')).'.jpg';
			$file = $dir.$filename;

			// copying
			move_uploaded_file($_FILES['file']['tmp_name'], $file);

			// displaying file
			$array = array(
				'filelink' => Yii::app()->request->baseUrl . '/images/customImageUpload/'.$filename
			);
			echo stripslashes(json_encode($array));

		}
	}

/**
 * clearTags 
 * 
 * @param mixed $str 
 * @access public
 * @return void
 */
function clearTags($str) {
	return strip_tags($str, '<code><span><div><label><a><br><p><b><i><del><strike><u><img><video><audio><iframe>' . 
	'<object><embed><param><blockquote><mark><cite><small><ul><ol><li><hr><dl><dt><dd><sup><sub>' . 
	'<big><pre><code><figure><figcaption><strong><em><table><tr><td><th><tbody><thead><tfoot><h1><h2><h3><h4><h5><h6>');
}

}
