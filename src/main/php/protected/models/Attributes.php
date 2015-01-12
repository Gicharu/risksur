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
 */
class Attributes extends CActiveRecord {
	/**
	 * model 
	 * 
	 * @param mixed $className 
	 * @static
	 * @access public
	 * @return void
	 */
	public static function model($className = __CLASS__) {
		return parent::model($className);
	}
	/**
	 * tableName 
	 * 
	 * @access public
	 * @return void
	 */
	public function tableName() {
		return 'perfAttributes';
	}

	/**
	 * primaryKey 
	 * 
	 * @access public
	 * @return void
	 */
	public function primaryKey() {
		return 'attributeId';
	}

	/**
	 * rules 
	 * 
	 * @access public
	 * @return void
	 */
	public function rules() {
		return array(
			array(
				'name, description',
				'required'
			)
		);
	}

	/**
	 * attributeLabels 
	 * 
	 * @access public
	 * @return void
	 */
	public function attributeLabels() {
		return array(
			'name' => Yii::t('translation', 'Name'),
			'description' => Yii::t('translation', 'Description')
		);
	}
}
