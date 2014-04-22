<?php
/**
 * UserForm 
 * 
 * @uses CFormModel
 * @package 
 * @version $id$
 * @copyright Tracetracker
 * @author Eric Thuku <eric@tracetracker.com> 
 * @license Tracetracker {@link http://www.tracetracker.com}
 * @SuppressWarnings checkUnusedVariables
 */
class UpgradeForm extends CFormModel {
	public $nodes;
	/**
	 * rules 
	 * 
	 * @access public
	 * @return void
	 */
	public function rules() {
		return array(
			array(
				'nodes',
				'required'
			),
		);
	}
}
