<?php
/**
 * FrameworkFieldData
 *
 * @uses CActiveRecord
 * @package
 * @version $id$
 * @copyright Tracetracker
 * @author James Njoroge <james@tracetracker.com>
 * @license Tracetracker {@link http://www.tracetracker.com}
 */
class FrameworkFieldData extends CActiveRecord {

	public $id;
	public $frameworkId;
	public $frameworkFieldId;
	public $value;

	/**
	 * @return array
	 */
	public function rules() {
		return array(
			array(
				'frameworkId, frameworkFieldId, value',
				'required',
			),
			array(
				'id', 'safe'
			)
		);
	}

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
	 * @return string
	 */
	public function tableName() {
		return 'frameworkFieldData';
	}

	/**
	 * primaryKey
	 *
	 * @access public
	 * @return string
	 */
	public function primaryKey() {
		return 'id';
	}

	/**
	 * relations
	 *
	 * @access public
	 * @return array
	 */
	public function relations() {
		return array(
			'contextHeader' => array( self::BELONGS_TO, 'FrameworkHeader', 'frameworkId' )
		);
	}
}
