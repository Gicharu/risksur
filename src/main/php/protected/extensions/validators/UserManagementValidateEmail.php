<?php
/**
 * 
 */
class UserManagementValidateEmail extends CValidator {

	public $pattern;
	/**
	 * Validates the attribute of the object.
	 * If there is any error, the error message is added to the object.
	 * @param CModel $object the object being validated
	 * @param string $attribute the attribute being validated
	 */
	protected function validateAttribute($object, $attribute) {
		if(!empty($object->$attribute[0])) {
			foreach ($object->$attribute as $alias) {

				if(!empty($this->pattern) && (0 === preg_match($this->pattern, $alias))) {
					$this->addError($attribute, "Email is not valid");
				}
			}
		}
	}

	/**
	 * Returns the JavaScript needed for performing client-side validation.
	 * @param CModel $object the data object being validated
	 * @param string $attribute the name of the attribute to be validated.
	 * @return string the client-side validation script.
	 * @see CActiveForm::enableClientValidation
	 */
	public function clientValidateAttribute($object, $attribute) {

		//foreach ($object->$attribute as $alias) {
		$condition = "!value.match(" . $this->pattern . ")";

		return "
			if(". $condition . " && value != '') {
				messages.push(" . CJSON::encode('Email is not valid') . ");
	}
	";
	//}
	}



}
