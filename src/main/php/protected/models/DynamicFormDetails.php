<?php

	/**
	 * DynamicFormDetails
	 *
	 * @uses CActiveForm
	 * @package
	 * @version $id$
	 * @copyright Tracetracker
	 * @author James Njoroge <james@tracetracker.com>
	 * @license Tracetracker {@link http://www.tracetracker.com}
	 * @SuppressWarnings checkUnusedVariables
	 */
	class DynamicFormDetails extends CActiveRecord {
		private $_dynamicData = array();
		public $_dynamicFields = array();
		protected  $_tableName;
		protected $_md;


		/**
		 * __construct
		 * @param string $scenario
		 * @param null $tableName
		 */
		public function __construct($scenario = 'insert', $tableName = null) {
			$this->_tableName = $tableName;
			parent::__construct($scenario);
		}

		/**
		 * Overrides default instantiation logic.
		 * Instantiates AR class by providing table name
		 * @see CActiveRecord::instantiate()
		 * @param $attributes
		 * @return CActiveRecord
		 */
		protected function instantiate($attributes) {
			return new DynamicFormDetails(null, $this->tableName());
		}
		/**
		 * Returns meta-data for this DB table
		 * @see CActiveRecord::getMetaData()
		 * @return CActiveRecordMetaData
		 */
		public function getMetaData() {
			if ($this->_md !== null) {
				return $this->_md;
			} else {
				return $this->_md = new CActiveRecordMetaData($this);
			}
		}

		/**
		 * tableName
		 * @return string
		 */
		public function tableName() {
			return $this->_tableName;
		}
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
		 * @param string $className
		 * @return mixed
		 */
		public static function model($className = __CLASS__) {
			return parent::model($className);
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
