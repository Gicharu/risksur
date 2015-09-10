<?php

class DesignForm extends DForm {
	private $_rules = [];
	protected $_properties = [];
	private $_dynamicLabels = [];
	private $_propertyDataMap = [];

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

	/**
	 * @return array
	 */
	public function rules() {
		return $this->_rules;
	}

	/**
	 * @param array $names
	 */
	public function setProperties(array $names) {
		//if (empty($this->_properties)) {
		foreach ($names as $name => $value) {
			$this->_properties[$name] = $value;
		}
		//print_r($names); die;
		//}
	}

	/**
	 * @param array $properties
	 */
	public function unsetProperties(array $properties) {
		foreach($properties as $property) {
			unset($this->_properties[$property]);
		}
	}

	/**
	 * @param $name
	 * @param string $value
	 */
	public function setPropertyName($name, $value = '') {
		//$this->_properties[$name] = self::isJson($value) ? json_decode($value) : $value;
		$this->_properties[$name] = $value;
	}

	public function getFieldDataId($fieldId) {
		$fieldDataId = array_keys($this->_propertyDataMap, $fieldId);
		return empty($fieldDataId) ? null : $fieldDataId[0];
	}

	/**
	 * @param $string
	 * @return bool
	 */
	public static function isJson($string) {
		json_decode($string);
		return (json_last_error() == JSON_ERROR_NONE);
	}


	/**
	 * @param $propertyName
	 * @return mixed
	 */
	private function getFieldId($propertyName) {
		$fieldNameAndId = explode('_', $propertyName);
		return $fieldNameAndId[1];
	}

	/**
	 * @param array $rules
	 */
	public function setRules(array $rules) {
		$this->_rules = $rules;
	}

	/**
	 * @param array $labels
	 */
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
		$attributeLabels = [];
		if (!empty ($this->_dynamicLabels)) {
			$attributeLabels = $this->_dynamicLabels;
		}
		return $attributeLabels;
	}

	/**
	 * @return array
	 */
	public function attributeNames() {
		return array_merge(
			parent::attributeNames(),
			array_keys($this->_properties)
		);
	}

	public function componentNumber($value) {
		print_r($value); die;
	}
}