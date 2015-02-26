<?php
/**
 * Controller 
 * 
 * @uses CController
 * @package 
 * @version $id$
 * @copyright Tracetracker
 * @author Chirag Doshi <chirag@tracetracker.com> 
 * @license Tracetracker {@link http://www.tracetracker.com}
 * @SuppressWarnings checkUnusedVariables 
 */
abstract class Controller extends CController {
/**
 * Controller is the customized base controller class.
 * All controller classes for this application should extend from this base class.
 */

	const LOG_CAT = "components.Controller";
	/**
	 * @var string the default layout for the controller view. Defaults to '//layouts/column1',
	 * meaning using a single column layout. See 'protected/views/layouts/column1.php'.
	 */
	public $layout = '//layouts/column1';
	/**
	 * @var array context menu items. This property will be assigned to {@link CMenu::items}.
	 */
	public $menu = array();
	/**
	 * @var array the breadcrumbs of the current page. The value of this property will
	 * be assigned to {@link CBreadcrumbs::links}. Please refer to {@link CBreadcrumbs::links}
	 * for more details on how to specify this property.
	 */
	public $breadcrumbs = array();

	/**
	 * filters
	 * @return array
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
	 * renderPartial 
	 * 
	 * @param mixed $view 
	 * @param mixed $data 
	 * @param mixed $return 
	 * @param mixed $processOutput 
	 * @access public
	 * @return void
	 */
	public function renderPartial($view, $data = NULL, $return = false, $processOutput = false) {
		Yii::log(Yii::app()->controller->id . "Controller/action" . 
			Yii::app()->controller->action->id . " done, passing to view: $view", "trace", self::LOG_CAT);
		return parent::renderPartial( $view, $data, $return, $processOutput );
	}

	/**
	 * beforeAction 
	 * 
	 * @access public
	 * @return void
	 * @param object
	 */
	/*public function beforeAction($action){
		//print_r($this); die();
		//echo $action->id; die();
	    // Check only when the user is logged in
		/*
	    if ( !Yii::app()->user->isGuest)  {
	       if ( yii::app()->user->getState('userSessionTimeout') < time() ) {
		   // timeout
		   Yii::app()->user->logout();
		   $this->redirect(array('/site/SessionTimeout'));  //
	       } else {
		   yii::app()->user->setState('userSessionTimeout', time() + Yii::app()->params['sessionTimeoutSeconds']) ;
		   return true; 
	       }
	    } else {
		return true;
	    }*/
	/*if(!Yii::app()->user->isGuest && !isset(Yii::app()->session['currentTix'])) {
		die('here');
		$this->redirect(array(
			'dashboard/selectNode'
		));
		//return true;
	    } else {
			return true;


	    }*/
	//}

}
