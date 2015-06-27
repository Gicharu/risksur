<?php

class DForm extends CFormModel {
	private $_rules = array();
	private $_properties = array();
	private $_dynamicLabels = [];
	private $_propertyData = [];

	public function __set($name, $value) {
		if (isset($this->_properties[$name])) {
			$this->_properties[$name] = $value;
		} else {
			parent::__set($name, $value);
		}
	}

	public function __get($name) {
		if (isset($this->_properties[$name])) {
			return $this->_properties[$name];
		} else {
			return parent::__get($name);
		}
	}

	public function rules() {
		return $this->_rules;
	}

	/**
	 * @param array $names
	 */
	public function setPropertyNames(array $names) {
		//if (empty($this->_properties)) {
			foreach ($names as $name)
				$this->_properties[$name] = '';
		//}
	}

	public function setPropertyName($name) {
		$this->_properties[$name] = '';

	}

	public function setRules(array $rules) {
		$this->_rules = $rules;
	}

	public function setAttributeLabels(array $labels) {
		foreach($labels as $attributeName => $label) {
			$this->_dynamicLabels[$attributeName] = $label;
		}
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
		return $attributeLabels;
	}

	public function attributeNames() {
		return array_merge(
			parent::attributeNames(),
			array_keys($this->_properties)
		);
	}
}