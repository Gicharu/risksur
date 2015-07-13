<?php

/**
 * DynamicForm
 * 
 * @uses CFormModel
 * @package 
 * @version $id$
 * @copyright Tracetracker
 * @author Chirag Doshi <chirag@tracetracker.com> 
 * @license Tracetracker {@link http://www.tracetracker.com}
 * @SuppressWarnings checkUnusedVariables
 */
class DynamicForm extends CFormModel {
	private $_dynamicData = array();
	public $_dynamicFields = [],  $_dynamicLabels = array(), $_rules = [];
	/**
	 * attributeNames 
	 * 
	 * @access public
	 * @return array
	 */
	public function attributeNames() {
		return array_merge(
			parent::attributeNames(),
			array_keys($this->_dynamicFields)
		);
	}


	/**
	 * __get
	 * @param string $name
	 * @return mixed|null|void
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
	 * @return array
	 */
	public function rules() {
		$required = array();
		$unique = array();
		$safe = [];
		foreach ($this->_rules as $key => $rule) {
			if ($rule['required']) {
				$required[] = $rule['attribute'];
			} elseif($rule == 2) {
				$unique[] = $rule['attribute'];
			} else {
				$safe[] = $rule['attribute'];
			}
		}
		return array(
			array(implode(', ', $required), 'required'),
			array(implode(', ', $safe), 'safe'),
			array(implode(', ', $unique), 'unique')

		);

	}

	/**
	 * attributeLabels 
	 * 
	 * @access public
	 * @return array
	 */
	public function attributeLabels() {
		$attributeLabels = array();
		if (!empty ($this->_dynamicLabels)) {
			$attributeLabels = $this->_dynamicLabels;
		}
		//print_r($this->_dynamicLabels); die();
		//foreach ($this->_dynamicLabels as $key => $val) {
			////if (!empty($e->label)) {
				//$attributeLabels[$key] = $val;
				////}
		//}
		return $attributeLabels;
	}

}
