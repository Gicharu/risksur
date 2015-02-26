<?php
/**
 * Options 
 * 
 * @uses CActiveRecord
 * @package 
 * @version $id$
 * @copyright Tracetracker
 * @author Chirag Doshi <chirag@tracetracker.com> 
 * @license Tracetracker {@link http://www.tracetracker.com}
 */
class Options extends CActiveRecord {
	/**
	 * model
	 *
	 * @param mixed $className
	 * @static
	 * @access public
	 * @return static
	 */
	public static function model($className = __CLASS__) {
		return parent::model($className);
	}
	/**
	 * tableName 
	 * 
	 * @access public
	 * @return array
	 */
	public function tableName() {
		return 'options';
	}

	/**
	 * primaryKey 
	 * 
	 * @access public
	 * @return array
	 */
	public function primaryKey() {
		return 'optionId';
	}

	/**
	 * rules 
	 * 
	 * @access public
	 * @return array
	 */
	public function rules() {
		return array(
			array(
				'label, elementId',
				'required'
			)
		);
	}

	/**
	 * attributeLabels 
	 * 
	 * @access public
	 * @return array
	 */
	public function attributeLabels() {
		return array(
			'label' => Yii::t('translation', 'Input Name'),
			'elementId' => Yii::t('translation', 'Option Name')
		);
	}

	/**
	 * @param $contextInputId
	 * @return array
	 */
	public function getContextFieldOptions($contextInputId) {
		$optionsRs = $this->findAll('frameworkfieldId=' . $contextInputId);
		$options = array();
		if(!empty($optionsRs)) {
			foreach($optionsRs as $option) {
				$options[$option->val] = $option->label;
			}
		}
		return $options;
	}
}
