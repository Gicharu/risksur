<?php
/**
 * Created by PhpStorm.
 * User: james
 * Date: 9/2/15
 * Time: 10:59 AM
 */

class SystemController extends RiskController {
	const LOG_CAT = 'ctrl.systemController';

	/**
	 * actionIntro
	 */
	public function actionIndex() {
		Yii::log("actionIndex called", "trace", self::LOG_CAT);
		$docName = 'survIntro';
		if(isset($_POST['pageId'])) {
			self::savePage('index');
		}
		$page = self::getPageContent($docName);
		if(empty($page)) {
			throw new CHttpException(404, 'The page requested does not exist');
		}
		$this->render('_page', [
				'content' => $page['content'],
				'editAccess' => $page['editAccess'],
				'editMode' => $page['editMode']
			]
		);

	}


	/**
	 * @param $docName
	 * @return array
	 */
	public static function getPageContent($docName) {
		Yii::log("Function getPageContent called", "trace", self::LOG_CAT);
		$content = DocPages::model()->find("docName='$docName'");
		if(empty($content)) {
			return [
				'content' => new DocPages(),
				'editAccess' => '',
				'editMode' => false
			];
		}
		$editAccess = false;
		if(Yii::app()->rbac->checkAccess('context', 'savePage')) {
			$editAccess = true;
		}
		$editMode = false;
		if(isset($_POST['page']) && DocPages::model()->count('docId=' . $_POST['page']) > 0) {
			$editMode = true;
		}
		return [
			'content' => $content,
			'editAccess' => $editAccess,
			'editMode' => $editMode
		];
	}

	/**
	 * @param $action
	 */
	public static function savePage($action) {
		//var_dump($_POST); die;
		Yii::log("Function SavePage called", "trace", self::LOG_CAT);
		$model = DocPages::model()->findByPk($_POST['pageId']);
		if (isset($_POST['survContent'])) {
			$purifier = new CHtmlPurifier();
			$model->docData = $purifier->purify($_POST['survContent']);
			if($model->update()) {
				Yii::app()->user->setFlash('success', 'The page was updated successfully');
				Yii::app()->request->redirect($action);
				return;
			}
		}

		Yii::app()->user->setFlash('error', 'The page was not updated successfully, contact your administrator');
		Yii::app()->request->redirect($action);
		return;
	}


}