<?php
/**
 * WebUser 
 * 
 * @package  
 * @author    Chirag Doshi <chirag@tracetracker.com> 
 * @copyright Tracetracker
 * @version   $id$
 * @uses      CWebUser
 * @license   Tracetracker {@link http://www.tracetracker.com}
 * @throws 	  Exception
 */
class WebUser extends CWebUser {
	/**
	 * updateAuthStatus 
	 * 
	 * @access public
	 * @return void
	 */
	public function updateAuthStatus() {
		if (!$this->isGuest) {
			parent::updateAuthStatus();
			$timeOut = Yii::app()->getSession()->getTimeout();
			if ($this->isGuest) {
				Yii::app()->session->destroy();
			}
		}
	}
	/**
	 * loginRequired 
	 * 
	 * @access public
	 * @return void
	 * @throws exception
	 */
	public function loginRequired() {
		//$homeUrl = Yii::app()->homeUrl;
		$app = Yii::app();
		$request = $app->getRequest();
		if (!$request->getIsAjaxRequest()) {
			$this->setReturnUrl($request->getUrl());
		} elseif (isset($this->loginRequiredAjaxResponse)) {
			echo $this->loginRequiredAjaxResponse;
			Yii::app()->end();
		}
		if (($url = $this->loginUrl) !== null) {
			if (is_array($url)) {
				$route = isset($url[0]) ? $url[0] : $app->defaultController;
				$url = $app->createUrl($route, array_splice($url, 1));
			}
			$request->redirect($url . "/inactive/1");
		} else {
			throw new CHttpException(403, Yii::t('yii', 'Login Required'));
		}
	}
}
