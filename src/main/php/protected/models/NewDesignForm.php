<?php
/**
 * NewDesignForm 
 * 
 * @uses CFormModel
 * @package 
 * @version $id$
 * @copyright Tracetracker
 * @author Chirag Doshi <chirag@tracetracker.com> 
 * @license Tracetracker {@link http://www.tracetracker.com}
 */
class NewDesignForm extends CFormModel {
	public $name;
	public $description;
	public $goal;
	public $component;

	/**
	 * rules 
	 * 
	 * @access public
	 * @return void
	 */
	public function rules() {
		return array(
			array(
				'name, description, goal, component',
				'required'
			),
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
			'name' => Yii::t('translation', 'Design Name'),
			'description' => Yii::t('translation', 'Description of design'),
			'goal' => Yii::t('translation', 'Goal'),
			'component' => Yii::t('translation', 'Component')
		);
	}
}
