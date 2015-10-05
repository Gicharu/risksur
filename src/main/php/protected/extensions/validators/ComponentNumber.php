<?php
/**
 * Created by PhpStorm.
 * User: james
 * Date: 9/4/15
 * Time: 9:56 AM
 */

class ComponentNumber extends CValidator {
	public $requiredComponents;
	public $declaredComponents;
	protected function validateAttribute($object, $attribute) {
		$value = $object->$attribute;

		if(count($value) < $this->requiredComponents) {
			$this->addError($object, $attribute,
				"The evaluation question selected dictates that $this->requiredComponents or more components must be selected");
		}
		//print_r(count($value)); die;
//		if($this->declaredComponents > 0 && count($value) < $this->declaredComponents) {
		if(count($value) != $this->declaredComponents) {
			$this->addError($object, $attribute,
				"This evaluation context must have $this->declaredComponents components," .
				" please change your selection or amend the context form");
		}

	}


}