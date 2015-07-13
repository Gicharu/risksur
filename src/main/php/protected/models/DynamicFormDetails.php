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
	class DynamicFormDetails extends CFormModel {
		const LOG_CAT = 'models.DynamicFormDetails';
		public $_dynamicData = array();
		public $_dynamicFields = array();
		public $_dynamicLabels = array();
		public $_rules = [];
		protected $_md;


		/**
		 * __construct
		 * @param string $scenario
		 * @param null $tableName
		 */
		public function __construct($scenario = 'insert') {
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
			return new DynamicFormDetails(null);
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
			if (isset($this->_dynamicFields[$name])) {
				if (!empty($this->_dynamicData[$name])) {
					return $this->_dynamicData[$name];
				}
				return $this->_dynamicFields[$name];

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
			if (isset($this->_dynamicFields[$name])) {
				Yii::log("Setting $name to " . json_encode($val) . " \n", 'trace', self::LOG_CAT);
				$this->_dynamicData[$name] = is_null($val) ? '' : $val;
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
			$required = [];
			$safe = [];
			foreach ($this->_rules as $key => $rule) {
				if ($rule['required']) {
					$required[] = $rule['attribute'];
				} else {
					$safe[] = $rule['attribute'];
				}
			}
			return array(
				array(implode(', ', $required), 'required'),
				array(implode(', ', $safe), 'safe')

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
		 * @return array
		 */
		public function attributeLabels() {
			$attributeLabels = array();
			if (!empty ($this->_dynamicLabels)) {
				$attributeLabels = $this->_dynamicLabels;
			}
			return $attributeLabels;
		}


	}
