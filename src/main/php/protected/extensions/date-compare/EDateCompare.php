<?php

/**
 * DateCompare Validation Extension
 *
 * Validator to compare two dates, works similarly to CCompareValidator.
 *
 * @copyright © Digitick <www.digitick.net> 2012
 * @license GNU Lesser General Public License v3.0
 * @author Ianaré Sévi
 */
class EDateCompare extends CValidator {
	/**
	 * @var string the name of the attribute to be compared with
	 */
	public $compareAttribute;

	/**
	 * @var string a constant date to be compared with
	 */
	public $compareValue;

	/**
	 * @var boolean whether the attribute value can be null or empty. Defaults to false.
	 * If this is true, it means the attribute is considered valid when it is empty.
	 */
	public $allowEmpty = false;

	/**
	 * @var string the date format used to compare the values.
	 */
	public $dateFormat = 'd-m-Y';

	/**
	 * @var boolean whether this validation rule should be skipped when there is already a validation
	 * error for the current attribute. Defaults to true.
	 */
	public $skipOnError = true;

	/**
	 * @var string the operator for comparison. Defaults to '='.
	 * The followings are valid operators:
	 * <ul>
	 * <li>'=' or '==': validates to see if the two values are equal.</li>
	 * <li>'!=': validates to see if the two values are NOT equal.</li>
	 * <li>'>': validates to see if the value being validated is greater than the value being compared with.</li>
	 * <li>'>=': validates to see if the value being validated is greater than or equal to the value being compared with.</li>
	 * <li>'<': validates to see if the value being validated is less than the value being compared with.</li>
	 * <li>'<=': validates to see if the value being validated is less than or equal to the value being compared with.</li>
	 * </ul>
	 */
	public $operator = '=';

	/**
	 * validateAttribute 
	 * 
	 * @param mixed $object 
	 * @param mixed $attribute 
	 * @access protected
	 * @throws exception
	 * @return void
	 */
	protected function validateAttribute($object, $attribute) {
		$value = $object->$attribute;

		if ($this->allowEmpty && $this->isEmpty($value)) {
			return;
		}

		if ($this->compareValue !== null) {
			$compareTo = $compareValue = $this->compareValue;
		} else {
			$compareAttribute = $this->compareAttribute === null ? $attribute . '_repeat' : $this->compareAttribute;
			$compareValue = $object->$compareAttribute;
			$compareTo = $object->getAttributeLabel($compareAttribute);
		}
		$compareDate = DateTime::createFromFormat($this->dateFormat, $compareValue);
		$date = DateTime::createFromFormat($this->dateFormat, $value);

		// make sure we have two dates
		if ($date instanceof DateTime && $compareDate instanceof DateTime) {
			$diff = ((integer) $date->diff($compareDate)->format('%r%a%H%I%S')) * -1;
		} else {
			return; // Perhaps not the best way of handling this. Possibly add an error message.
		}

		switch ($this->operator) {
			case '=':
			case '==':
				if ($diff != 0) {
					$message = $this->message !== null ? $this->message : Yii::t('yii', '{attribute} must be repeated exactly.');
					$this->addError($object, $attribute, $message, array('{compareAttribute}' => $compareTo));
				}
				break;
			case '!=':
				if ($diff == 0) {
					$message = $this->message !== null ? $this->message : Yii::t('yii', '{attribute} must not be equal to "{compareValue}".');
					$this->addError($object, $attribute, $message, array('{compareAttribute}' => $compareTo, '{compareValue}' => $compareValue));
				}
				break;
			case '>':
				if ($diff <= 0) {
					$message = $this->message !== null ? $this->message : Yii::t('yii', '{attribute} must be greater than "{compareValue}".');
					$this->addError($object, $attribute, $message, array('{compareAttribute}' => $compareTo, '{compareValue}' => $compareValue));
				}
				break;
			case '>=':
				if ($diff < 0) {
					$message = $this->message !== null ? $this->message : Yii::t('yii', '{attribute} must be greater than or equal to "{compareValue}".');
					$this->addError($object, $attribute, $message, array('{compareAttribute}' => $compareTo, '{compareValue}' => $compareValue));
				}
				break;
			case '<':
				if ($diff >= 0) {
					$message = $this->message !== null ? $this->message : Yii::t('yii', '{attribute} must be less than "{compareValue}".');
					$this->addError($object, $attribute, $message, array('{compareAttribute}' => $compareTo, '{compareValue}' => $compareValue));
				}
				break;
			case '<=':
				if ($diff > 0) {
					$message = $this->message !== null ? $this->message : Yii::t('yii', '{attribute} must be less than or equal to "{compareValue}".');
					$this->addError($object, $attribute, $message, array('{compareAttribute}' => $compareTo, '{compareValue}' => $compareValue));
				}
				break;
			default:
				throw new CException(Yii::t('yii', 'Invalid operator "{operator}".', array('{operator}' => $this->operator)));
		}
	}

	/**
	 * clientValidateAttribute 
	 * 
	 * @param mixed $object 
	 * @param mixed $attribute 
	 * @access public
	 * @throws exception
	 * @return void
	 */
	public function clientValidateAttribute($object, $attribute) {
		$widgetId = $_GET['id'];
		if ($this->compareValue !== null) {
			$compareTo = $this->compareValue;
			$compareValue = CJSON::encode($this->compareValue);
		} else {
			$compareAttribute = $this->compareAttribute === null ? $attribute . '_repeat' : $this->compareAttribute;
			// add js to get the time element of the compare date 1
$compareJs = <<<END
	var dateVal = $('#$compareAttribute$widgetId').val();
	var myDateArray = dateVal.split("-");
	var d = new Date(myDateArray[2],myDateArray[1]-1,myDateArray[0]); 
	var timeCompare = d.getTime();
END;
			$compareValue = "timeCompare";
			$compareTo = $object->getAttributeLabel($compareAttribute);
		}

			// add js to get the time element of the compare date 2
$compareFrom = <<<END
	var compareFromArray = value.split("-");
	var dateCompareFrom = new Date(compareFromArray[2],compareFromArray[1]-1,compareFromArray[0]); 
	var timeCompareFrom = dateCompareFrom.getTime();
END;
		$message = $this->message;
		$jsDate = 'timeCompareFrom';

		switch ($this->operator) {
			case '=':
			case '==':
				if ($message === null) {
					$message = Yii::t('yii', '{attribute} must be repeated exactly.');
					$condition = "{$jsDate}!={$compareValue}";
				}
				break;
			case '!=':
				if ($message === null) {
					$message = Yii::t('yii', '{attribute} must not be equal to "{compareValue}".');
					$condition = "{$jsDate}=={$compareValue}";
				}
				break;
			case '>':
				if ($message === null) {
					$message = Yii::t('yii', '{attribute} must be greater than "{compareValue}".');
					$condition = "{$jsDate}<={$compareValue}";
				}
				break;
			case '>=':
				if ($message === null) {
					$message = Yii::t('yii', '{attribute} must be greater than or equal to "{compareValue}".');
					$condition = "{$jsDate}<{$compareValue}";
				}
				break;
			case '<':
				if ($message === null) {
					$message = Yii::t('yii', '{attribute} must be less than "{compareValue}".');
					$condition = "{$jsDate}>={$compareValue}";
				}
				break;
			case '<=':
				if ($message === null) {
					$message = Yii::t('yii', '{attribute} must be less than or equal to "{compareValue}".');
					$condition = "{$jsDate}>{$compareValue}";
				}
				break;
			default:
				throw new CException(Yii::t('yii', 'Invalid operator "{operator}".', array('{operator}' => $this->operator)));
		}

		$message = strtr($message, array(
			'{attribute}' => $object->getAttributeLabel($attribute),
			'{compareValue}' => $compareTo,
				));
// add the js to the page
		return $compareJs . $compareFrom ."

if(" . ($this->allowEmpty ? "$.trim(value)!='' && " : '') . $condition . ") {
	messages.push(" . CJSON::encode($message) . ");
}
";
	}

}
