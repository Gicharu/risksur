<?php

class DForm extends CFormModel {
	private $_rules = array();
	protected $_properties = array();
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
	 * @param $name
	 * @param string $value
	 */
	public function setPropertyName($name, $value = '') {
		//$this->_properties[$name] = self::isJson($value) ? json_decode($value) : $value;
		$this->_properties[$name] = $value;
		if($this->scenario == 'update' && $this->_properties[$name] == '') {
			$frameworkDataCriteria = new CDbCriteria();
			$frameworkDataCriteria->select = 'id, frameworkId, frameworkFieldId, value';
			$frameworkDataCriteria->condition = 'frameworkId=' . Yii::app()->session['surDesign']['id'];
			$fieldId = self::getFieldId($name);
			$frameworkDataCriteria->addCondition('frameworkFieldId=' . $fieldId);
			$rsFrameworkData = FrameworkFieldData::model()->findAll($frameworkDataCriteria);
			//print_r($rsFrameworkData); die;
			foreach($rsFrameworkData as $propertyData) {
				if($propertyData->frameworkFieldId == $fieldId) {
					if(count($rsFrameworkData) == 1) {
						$this->_properties[$name] = $propertyData->value;
					} else {
						$this->_properties[$name][] = $propertyData->value;
					}
					$this->_propertyDataMap[$propertyData->id] = $fieldId;
					if(self::isJson($propertyData->value)) {
						$this->_properties[$name] = json_decode($propertyData->value);
					}
				}
			}
		}
	}

	public function getFieldDataId($fieldId) {
		$fieldDataId = array_keys($this->_propertyDataMap, $fieldId);
		return isset($fieldDataId[0]) ? $fieldDataId[0] : null;
	}

	/**
	 * @param $string
	 * @return bool
	 */
	public static function isJson($string) {
		if(!empty($string)) {
			json_decode($string);
			return (json_last_error() == JSON_ERROR_NONE);
		}
		return false;
	}


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
		$attributeLabels = array();
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
}