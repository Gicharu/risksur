<?php

/**
 * Created by PhpStorm.
 * User: james
 * Date: 8/14/15
 * Time: 1:20 PM
 */
class CFormTabular extends CForm {
	/**
	 * @var boolean the key to fetch when the form is used for tabular input
	 */
	private $_key;
	private $_model;
	private $_elements;
	private $_buttons;
	private $_activeForm;
	/**
	 * Constructor.
	 * @param mixed $parent the direct parent of this form. This could be either a {@link CBaseController}
	 * @param mixed $config the configuration for this form. It can be a configuration array
	 * @param CModel $model the model object associated with this form. If it is null,
	 * @param mixed $key
	 */
	public function __construct($config, $model, $parent = null, $key = null) {
		$this->_key = $key;
		parent::__construct($config, $model, $parent);
	}

	/**
	 * The only difference here is to check if the form is used for tabular input.
	 * If it is load attributes from the appropriate index from the submitted data
	 */
	public function loadData() {
		if ($this->_model !== null) {
			$class = get_class($this->_model);
			if (strcasecmp($this->getRoot()->method, 'get') && isset($_POST[$class])) {
				if ($this->isTabular()) {
					$this->_model->setAttributes($_POST[$class][$this->_key]);
				} else {
					$this->_model->setAttributes($_POST[$class]);
				}
			} elseif (isset($_GET[$class])) {
				if ($this->isTabular()) {
					$this->_model->setAttributes($_GET[$class][$this->_key]);
				} else {
					$this->_model->setAttributes($_GET[$class]);
				}
			}
		}
		foreach ($this->getElements() as $element) {
			if ($element instanceof self) {
				$element->loadData();
			}
		}
	}

	/**
	 * Checks if the form is used for tabular input
	 * @return true if this form is used for tabular input, false if not
	 */
	public function isTabular() {
		return isset($this->_key);
	}

	/**
	 * Only one line is changed from CForm to render a valid class when
	 * using tabular inputs. The line is marked.
	 */
	public function renderElement($element) {

		if (is_string($element)) {

			if (($e = $this[$element]) === null && ($e = $this->getButtons()->itemAt($element)) === null) {
				return $element;
			} else {
				$element = $e;
			}
		}
		if ($element->getVisible() || $this->getModel()->isAttributeSafe(substr($element->name, 3))) {

			if ($element instanceof CFormInputElement) {
				//print_r($element->name); die;
				if ($element->type === 'hidden') {
					return "<div style=\"visibility:hidden\">\n" . $element->render() . "</div>\n";
				} else {
					//print_r($element); die;
					$elementName = $element->name;
					return '<div class="row field_' . strtolower(preg_replace('/(\[\w*\])?\[(\w*)\]/', '_$2', CHtml::resolveName($element->getParent()->getModel(), $elementName))) . "\">\n" . $element->render() . "</div>\n"; // This line is the change
				}
			} elseif ($element instanceof CFormButtonElement) {
				return $element->render() . "\n";
			} else {
				return $element->render();
			}
		}
		return '';
	}


	public function isAttributeRequired($attribute) {
		return parent::isAttributeRequired(preg_replace('/(\[\w+\])?(\w+)/', '$2', $attribute));
	}
	public function isAttributeSafe($attribute) {
		return parent::isAttributeSafe(preg_replace('/(\[\w+\])?(\w+)/', '$2', $attribute));
	}


}