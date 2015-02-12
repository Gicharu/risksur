<?php

/**
 * EvaluationForm 
 * 
 * @uses CFormModel
 * @package 
 * @version $id$
 * @copyright Tracetracker
 * @author Chirag Doshi <chirag@tracetracker.com> 
 * @license Tracetracker {@link http://www.tracetracker.com}
 * @SuppressWarnings checkUnusedVariables
 */
class EvaluationForm extends CFormModel {
	private $_dynamicData = array();
	public $_dynamicFields = array(); 
	/**
	 * attributeNames 
	 * 
	 * @access public
	 * @return void
	 */
	public function attributeNames() {
		return array_merge(
			parent::attributeNames(),
			array_keys($this->_dynamicFields)
		);
	}

	/**
	 * __get 
	 * 
	 * @param mixed $name 
	 * @access public
	 * @return void
	 */
	public function __get($name) {
		if (!empty($this->_dynamicFields[$name])) {
			if (!empty($this->_dynamicData[$name])) {
				return $this->_dynamicData[$name];
			} else {
				return null;
			}

		} else {
			return parent::__get($name);
		}
	}

	/**
	 * __set 
	 * 
	 * @param mixed $name 
	 * @param mixed $val 
	 * @access public
	 * @return void
	 */
	public function __set($name, $val) {
		if (!empty($this->_dynamicFields[$name])) {
			$this->_dynamicData[$name] = $val;
		} else {
			parent::__set($name, $val);
		}
	}
	/**
	 * rules 
	 * 
	 * @access public
	 * @return void
	 */
	public function rules() {
		$required = array();
		foreach ($this->_dynamicFields as $attr => $val) {
			if ($val) {
				$required[] = $attr;
			}
		}
		return array(
			array(implode(', ', $required), 'required'),
		);
	}

	/**
	 * attributeLabels 
	 * 
	 * @access public
	 * @return void
	 */
	//public function attributeLabels() {
		//$attributeLabels = array();
		//foreach ($this->elements as $e) {
			//if (!empty($e->label)) {
				//$attributeLabels[$e->inputName] = $e->label;
			//}
		//}
		//return $attributeLabels;
	//}
}
