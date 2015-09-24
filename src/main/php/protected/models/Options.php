<?php
/**
 * Options 
 * 
 * @uses CActiveRecord
 * @package 
 * @version $id$
 * @copyright TraceTracker
 * @author Chirag Doshi <chirag@tracetracker.com> 
 * @license Tracetracker {@link http://www.tracetracker.com}
 */
class Options extends CActiveRecord {


	/**
	 * @return array relational rules.
	 */
	public function relations() {
		// NOTE: you may need to adjust the relation name and the related
		// class name for the relations automatically generated below.
		return [
			'element'        => [self::BELONGS_TO, 'EvaluationElements', 'elementId',
				'joinType' => 'INNER JOIN'],
			'component'      => [self::BELONGS_TO, 'ComponentDetails', 'componentId',
				'joinType' => 'INNER JOIN'],
			'frameworkField' => [self::BELONGS_TO, 'FrameworkFields', 'frameworkFieldId',
				'joinType' => 'INNER JOIN',
				'select' => 'label, id'
			],
		];
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
		return [
			[
				'label',
				'required'
			],
			[
				'frameworkFieldId',
				'required', 'on' => 'addFrameworkField'
			],
			[
				'componentId',
				'required', 'on' => 'addComponentField'
			],
			[
				'elementId',
				'required', 'on' => 'addElementField'
			]
		];
	}

/**
* @return array customized attribute labels (name=>label)
*/
	public function attributeLabels() {
		return [
			'optionId'         => 'Option',
			'frameworkFieldId' => 'Framework Field',
			'componentId'      => 'Component',
			'elementId'        => 'Element',
			'val'              => 'Val',
			'label'            => 'Label',
		];
	}

	/**
	 * @param $contextInputId
	 * @return array
	 */
	public function getContextFieldOptions($contextInputId) {
		$optionsRs = $this->findAll('frameworkFieldId=' . $contextInputId);
		$options = [];
		if(!empty($optionsRs)) {
			foreach($optionsRs as $option) {
				if(isset($option->value)) {
					$options[$option->value] = $option->label;

				} else {
					$options[$option->optionId] = $option->label;

				}
			}
		}
		return $options;
	}
}
