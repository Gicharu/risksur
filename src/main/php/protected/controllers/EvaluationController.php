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
		$this->render('index', array(
			//'model' => $model
		));
	}

	/**
	 * actionTest 
	 * 
	 * @access public
	 * @return void
	 */
	public function actionTest() {
		echo "testing";
	}
}
