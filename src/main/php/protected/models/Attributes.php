<?php
/**
 * Options 
 * 
 * @uses CActiveRecord
 * @package 
 * @version $id$
 * @copyright Tracetracker
 * @author Eric Thuku <eric@tracetracker.com> 
 * @license Tracetracker {@link http://www.tracetracker.com}
 * @SuppressWarnings checkUnusedVariables
 */
class Attributes extends CActiveRecord {
	//public $name, $descritption, $attributeId;
	/**
	 * @param string $className
	 * @return static
	 */
	public static function model($className = __CLASS__) {
		return parent::model($className);
	}
	/**
	 * tableName 
	 * 
	 * @access public
	 * @return string
	 */
	public function tableName() {
		return 'evaAttributes';
	}

	/**
	 * primaryKey 
	 * 
	 * @access public
	 * @return string
	 */
	public function primaryKey() {
		return 'attributeId';
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
				'name, description, attributeType',
				'required'
			),
			array(
				'name', 'unique'
			)
		);
	}

	/**
	 * relations
	 *
	 * @access public
	 * @return array
	 */
	public function relations() {
		return array(
			'attributeRelation' => array( self::HAS_MANY, 'AttributeFormRelation', 'attributeId' ),
			'evaAttributeTypes' => array( self::BELONGS_TO, 'EvaAttributeTypes', 'attributeType' )
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
			'name' => Yii::t('translation', 'Name'),
			'description' => Yii::t('translation', 'Description'),
			'attributeType' => Yii::t('translation', 'Category')
		);
	}
}
