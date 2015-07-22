<?php
/**
 * Created by PhpStorm.
 * User: james
 * Date: 7/15/15
 * Time: 12:31 PM
 */

class EvalForm extends DForm {

	/**
	 * @param $name
	 * @param string $value
	 */
	public function setPropertyName($name, $value = '') {
		//$this->_properties[$name] = self::isJson($value) ? json_decode($value) : $value;
		$this->_properties[$name] = $value;
	}

	/**
	 * @param $evalId
	 * @return bool
	 */
	public function save($evalId) {
		// fetch the form data
		$evaElements = [];
		foreach ($this->_properties as $attrNameAndId => $attrVal) {

			$attrParams = explode("_", $attrNameAndId);
			$evaElements['evalId'] = $evalId;
			$evaElements['evalElementsId'] = $attrParams[1];
			$evaElements['value'] = is_array($attrVal) ? json_encode($attrVal): $attrVal;

		}
		$model = new EvaluationDetails();
		$model->attributes = $evaElements;
		return $model->save();


	}
}