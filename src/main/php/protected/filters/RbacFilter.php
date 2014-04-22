<?php
/**
 * This filter implements core RBAC access filtering
 *
 * @author oleksiy
 */
class RbacFilter extends COutputProcessor {
	const LOG_CAT = "fil.RbacFilter";
	/**
	 * filter 
	 * 
	 * @param mixed $filterChain 
	 * @access public
	 * @return void
	 */
	public function filter($filterChain) {
		$this->preFilter($filterChain);
		return parent::filter($filterChain);
	}
	/**
	 * preFilter 
	 * 
	 * @param mixed $filterChain 
	 * @access protected
	 * @return void
	 * @throws
	 */
	protected function preFilter($filterChain) {
		// $_SESSION['roleManage'] is used instead of Yii::app()->session['roleManage'] as for some reason it is blank
		// when a user is logged in from the changePassword page.
		if (Yii::app()->user->isGuest || empty($_SESSION['roleManage'])) {
			Yii::log("User is not logged in i.e no session data, log user out", 'trace', self::LOG_CAT);
			Yii::app()->user->logout();
			Yii::app()->user->loginRequired();
			return;
		}
		//redirect to setNode if session not set for currentTix
		if (!isset(Yii::app()->session['currentTix']) && $filterChain->action->id != "setNode" && 
			$filterChain->action->id != "verify" && $filterChain->action->id != "upgrade") {
			Yii::log("Selection a page while node not selected. Redirecting to dashboard/SetNode ", 'trace', self::LOG_CAT);
			//Yii::app()->user->setFlash('notice', "Please select a node.");
			Yii::app()->controller->redirect(array('dashboard/setNode'));
		}
		if (Yii::app()->rbac->checkAccess($filterChain->controller->id, $filterChain->action->id, Yii::app()->user->id)) {
			$logMessage = "Access to " . $filterChain->controller->id . "/" . $filterChain->action->id . " for user " . Yii::app()->user->name . " granted ";
			Yii::log($logMessage, 'trace', self::LOG_CAT);
			return true;
		}
		throw new CHttpException(401, Yii::t('yii', 'You are not authorized to perform this action.'));
	}
	/**
	 * processOutput 
	 * 
	 * @param mixed $content 
	 * @access public
	 * @return void
	 */
	public function processOutput($content) {
		echo $content;
	}
}
?>
