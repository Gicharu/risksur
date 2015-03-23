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
	public $_dynamicFields = array(); 
	public $_dynamicLabels = array();
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
		foreach ($this->_dynamicFields as $attr => $val) {
			if ($val === 1) {
				$required[] = $attr;
			}
			if ($val === 2) {
				$required[] = $attr;
				$unique[] = $attr;
			}

		}
		$rules[] = array(implode(', ', $required), 'required');
		$rules[] = array(implode(', ', $unique), 'unique');
		//print_r(array_filter($rules)); die;
		return array_filter($rules);
	}

	/**
	 * attributeLabels 
	 * 
	 * @access public
	 * @return void
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
