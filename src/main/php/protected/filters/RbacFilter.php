<?php
/**
 * RbacFilter
 *
 * @copyright Tracetracker
 * @version   $id$
 * @uses      COutputProcessor
 * @license   Tracetracker {@link http://www.tracetracker.com}
 * @author    James Njoroge <james@tracetracker.com>
 * @package
 */


class RbacFilter extends COutputProcessor {

	const LOG_CAT = 'filters.RbacFilter';

	/**
	 *
	 *
	 * @param unknown $filterChain
	 * @return unknown
	 */
	public function filter($filterChain) {
		$this->preFilter($filterChain);
		return parent::filter($filterChain);
	}


	/**
	 *
	 *
	 * @param unknown $filterChain
	 * @return unknown
	 */
	protected function preFilter($filterChain) {
		if (Yii::app()->user->isGuest) {
			Yii::app()->user->loginRequired();
		}
		if (Yii::app()->rbac->checkAccess($filterChain->controller->id, $filterChain->action->id, Yii::app()->user->id)) {
			// print_r($filterChain); die();
			Yii::log("Access to " . $filterChain->controller->id . "/" . $filterChain->action->id . " for username " . Yii::app()->user->name .
				" granted with permission '" . $filterChain->controller->pageTitle . "'", 'trace', self::LOG_CAT); // "' [ID:" . $p['id'] . "]"
			return true;
		}

		throw new CHttpException(401, Yii::t('yii', 'You are not authorized to perform this action.'));
	}


	/**
	 *
	 *
	 * @param unknown $content
	 */
	public function processOutput($content) {
		echo $content;
	}


}


?>
