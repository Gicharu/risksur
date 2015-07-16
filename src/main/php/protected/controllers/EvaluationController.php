<?php

/**
 * EvaluationController
 * @uses RiskController
 * @package
 * @version $id$
 * @copyright Tracetracker
 * @author Chirag Doshi <chirag@tracetracker.com>
 * @license Tracetracker {@link http://www.tracetracker.com}
 */
class EvaluationController extends RiskController {
	const LOG_CAT = "ctrl.EvaluationController";
	public $layout = '//layouts/column2';
	private $frameworkId;

	/**
	 * init
	 */
	public function init() {
		$this->frameworkId = isset(Yii::app()->session['surDesign']['id']) ?
			Yii::app()->session['surDesign']['id'] : null;
	}


	/**
	 * actionIndex
	 * @access public
	 * @return void
	 */
	public function actionIndex() {
		Yii::log("actionIndex EvaluationController called", "trace", self::LOG_CAT);

		$model = new EvaluationHeader;
		$dataArray = [];
		$dataArray['dtHeader'] = "Evaluation List";
		$dataArray['evalList'] = json_encode([]);

		// get list of evaluation
		$evalList = EvaluationHeader::model()->with("designFrameworks")->findAll([
			'condition' => 't.userId=:userId',
			'params'    => [
				':userId' => Yii::app()->user->id,
			],
		]);
		//print_r($evalList); die();
		$evalListArray = [];
		// format datatable data
		foreach ($evalList as $eval) {
			$deleteButton = "";
			//if (Yii::app()->user->name != $valu['userName']) {
			$deleteButton = "<button id='deleteDesign" . $eval->evalId .
				"' type='button' class='bdelete' onclick=\"$('#deleteBox').dialog('open');" .
				"deleteConfirm('" . $eval->evaluationName . "', '" .
				$eval->evalId . "')\">Remove</button>";
			//}
			$evalListArray[] = [
				'evalId'        => $eval->evalId,
				'name'          => $eval->evaluationName,
				'userId'        => $eval->userId,
				'description'   => $eval->evaluationDescription,
				'design'        => $eval->frameworkId,
				'frameworkName' => $eval->designFrameworks->name,
				//'frameworkName' => $eval->frameworkId,
				'deleteButton'  => $deleteButton
			];
		}
		$dataArray['evalList'] = json_encode($evalListArray);

		if (!empty($_GET['getEval'])) {
			$jsonData = json_encode(["aaData" => $evalListArray]);
			echo $jsonData;
			return;
		}
		$this->render('index', [
			'model'     => $model,
			'dataArray' => $dataArray
		]);
	}

	/**
	 * actionEvaToolPage
	 * @access public
	 * @return void
	 */
	public function actionEvaPage() {
		Yii::log("actionEvaPage called", "trace", self::LOG_CAT);

		$model = DocPages::model()->findByPk("1");
		$userId = Yii::app()->user->id;

		// check if the user has roles 1 or 2 - admin roles
		$userRoles = UsersHasRoles::model()->findAll([
			'condition' => 't.users_id = :users_id AND (t.roles_id = :roleA OR t.roles_id = :roleB)',
			'params'    => [
				':users_id' => $userId,
				':roleA'    => 1,
				':roleB'    => 2
			],
		]);
		$editButton = false;
		if (!empty($userRoles)) {
			$editButton = true;
		}
		$editPage = false;
		if (!empty($_GET['edit']) && $_GET['edit'] == 1) {
			$editPage = true;
		}

		$this->render('evaPage', [
			'model'      => $model,
			'editButton' => $editButton,
			'editPage'   => $editPage
		]);
	}

	/**
	 * actionEvaConcept
	 * @access public
	 * @return void
	 */
	public function actionEvaConcept() {
		Yii::log("actionEvaConcept called", "trace", self::LOG_CAT);

		$model = DocPages::model()->findByPk("2");
		$userId = Yii::app()->user->id;

		// check if the user has roles 1 or 2 - admin roles
		$userRoles = UsersHasRoles::model()->findAll([
			'condition' => 't.users_id = :users_id AND (t.roles_id = :roleA OR t.roles_id = :roleB)',
			'params'    => [
				':users_id' => $userId,
				':roleA'    => 1,
				':roleB'    => 2
			],
		]);
		$editButton = false;
		if (!empty($userRoles)) {
			$editButton = true;
		}
		$editPage = false;
		if (!empty($_GET['edit']) && $_GET['edit'] == 1) {
			$editPage = true;
		}
		$this->render('evaConcept', [
			'model'      => $model,
			'editButton' => $editButton,
			'editPage'   => $editPage
		]);
	}

	/**
	 * actionSaveEvaPage
	 * @access public
	 * @return void
	 */
	public function actionSaveEvaPage() {
		Yii::log("actionSaveEvaPage called", "trace", self::LOG_CAT);
		$model = DocPages::model()->findByPk("1");
		if (isset($_POST['redactor'])) {
			$model->docData = self::clearTags($_POST['redactor']);
			$model->update();
		}
		echo json_encode([]);
	}

	/**
	 * actionEvaMethods
	 */
	public function actionEvaMethods() {
		Yii::log("actionEvaMethods called", "trace", self::LOG_CAT);
		$this->setPageTitle(Yii::app()->name . ' - Economic evaluation methods');
		$dataProvider = new CActiveDataProvider('EvaMethods');
		//print_r($dataProvider->getData()); die;
		$this->render('evaMethods', ['dataProvider' => $dataProvider]);
	}

	/**
	 * actionSaveEvaConcept
	 * @access public
	 * @return void
	 */
	public function actionSaveEvaConcept() {
		Yii::log("actionSaveEvaConcept called", "trace", self::LOG_CAT);
		$model = DocPages::model()->findByPk("2");
		if (isset($_POST['redactor'])) {
			$model->docData = self::clearTags($_POST['redactor']);
			$model->update();
		}
		echo json_encode([]);
	}

	/**
	 * @return string
	 */
	public function actionSelectEvaQuestion() {
		$this->setPageTitle('Select evaluation question');
		return $this->render('selectEvaQuestion');
	}

	/**
	 * actionEvalQuestionList
	 * @param string $questionId
	 */
	public function actionEvalQuestionList($questionId = '') {
		$this->setPageTitle('Select evaluation question');
		if (!empty($_POST['EvaluationQuestion']['question'])) {
			Yii::app()->session['evalQuestion'] = $_POST['EvaluationQuestion']['question'];
			//print_r(Yii::app()->session['evalQuestion']); die;
			$this->redirect('econEval');
			return;
		}
		$model = new EvaluationQuestion();
		$questionsRs = $model->findAll('parentQuestion is null');
		$elements = ContextController::getDefaultElements();
		$elements['title'] = '<h3>Evaluation question pick list </h3>';
		$elements['elements'] = [
			'question' => [
				'type'      => 'radiolist',
				'separator' => '<br>',
				//'labelOptions'=>array('style'=>'display:inline-block'),
				'style'     => 'width:1em;',
				'template'  => '<span class="rb">{input} {label}</span>',
				'items'     => CHtml::listData($questionsRs, 'evalQuestionId', 'question')
			]
		];
		$elements['buttons'] = ContextController::getButtons(["name" => "save", "label" => 'Next'],
			'evaluation/evalQuestionList');
		unset($elements['buttons']['cancel']);
		if (!empty($questionId)) {
			$model->question = $questionId;
		}
		$form = new CForm($elements, $model);
//		print_r($form['question']); die;
		$this->render('evaQuestionList', ['form' => $form]);
	}

	/**
	 * actionEvaQuestionWizard
	 */
	public function actionEvaQuestionWizard() {
		$this->setPageTitle('Evaluation question wizard');
		$model = new EvaluationQuestion();
		$elements = ContextController::getDefaultElements();
		$questionId = '';
		if (empty($_POST['EvaluationQuestion'])) {
			$questions = $model->with('evalQuestionAnswers')->findAll("flag='primary'");
			//print_r($questions[0]['evalQuestionAnswers']); die;

		} else {
			//print_r($_POST); die;
			$questionId = $_POST['EvaluationQuestion']['question'];
			$questions = $model->with('evalQuestionAnswers')->findAllByPk($questionId);
			//print_r($questions); die;
		}
		if (!empty($questions[0]->flag) && 'final' == $questions[0]->flag) {
			Yii::app()->user->setFlash('success', 'A question has been selected as per your previous choices');
			$this->redirect(['evaluation/evalQuestionList', 'questionId' => $questionId]);
		}
		$link = '';
		//var_dump($questions[0]['evalQuestionAnswers'], 'fdsf'); //die;
		foreach ($questions[0]['evalQuestionAnswers'] as $answerKey => $answer) {
			if (!empty($answer->url)) {
				$link = CHtml::link($answer->optionName, $this->createUrl($answer->url));
				//$questions[0]['evalQuestionAnswers'][$answerKey]->unsetAttributes();
			}
		}
		$elements['elements'] = [
			'<h3>' . $questions[0]->question . '</h3>',
			'question' => [
				'type'         => 'radiolist',
				'style'        => 'width:1em;',
				'labelOptions' => ['style' => 'display:inline'],
				'items'        => $model->getItems($questions[0]['evalQuestionAnswers'])
			]
		];
		if (!empty($link)) {
			array_push($elements['elements'], $link);
		}
		//print_r($questions[0]['evalQuestionAnswers']); die('pooop');
		$elements['buttons'] = [
			'back'   => [
				'type'    => 'button',
				'label'   => 'Back',
				'onClick' => 'history.go(-1)',
				//'class' => 'ui-button ui-arrowthick-1-w'
			],
			'submit' => [
				'type'  => 'submit',
				'label' => 'Next',
				//'class' => 'ui-button ui-arrowthick-1-e'

			]
		];
		$form = new CForm($elements, $model);
		$this->render('evalQuestion', compact('form'));
	}

	/**
	 * @param int $descId
	 * @return void
	 */
	public function actionEvaAttributes($descId = 0) {
		Yii::log("actionEvaAttributes called", "trace", self::LOG_CAT);
		if ($descId > 0) {
			$description = Attributes::model()->findByPk($descId, ['select' => 'description']);
			//print_r($description); die;
			// The Regular Expression filter
			$regExUrl = '/(http|https|ftp|ftps)\:\/\/[a-zA-Z0-9\-\.]+\.[a-zA-Z]{2,3}(\/\S*)?/';
			$attrDescription = $description->description;
			// Check if there is a url in the text
			if (preg_match($regExUrl, $description->description, $url)) {

				// make the urls hyper links
				$attrDescription = preg_replace($regExUrl, "<a href=\"{$url[0]}\" target=\"_blank\">{$url[0]}</a>",
					$description->description);

			}
			echo json_encode(['description' => "<p>$attrDescription</p>"]);
			return;
		}
		$evaAttributes = CHtml::listData(Attributes::model()
			->with('evaAttributeTypes')
			->findAll(), 'attributeId', 'name', function ($attribute) {
			return $attribute->evaAttributeTypes->name;
		}); //die;

		$tableColumns = CHtml::listData(EvaAttributeTypes::model()->findAll(), 'id', 'name');
		$this->render('evaAttributes', [
			'tableColumns'  => $tableColumns,
			'evaAttributes' => $evaAttributes
		]);

	}

	/**
	 * actionAddEvaContext
	 * @access public
	 * @return void
	 */
	public function actionAddEvaContext() {
		Yii::log("actionAddEvaContext called", "trace", self::LOG_CAT);
		if (is_null($this->frameworkId)) {
			Yii::log('No surveillance system selected! redirecting to context/list', 'trace', self::LOG_CAT);
			Yii::app()->user->setFlash('notice', 'Please select a surveillance system first');
			return $this->redirect(['context/list']);

		}
		$evaluationHeader = new EvaluationHeader('create');
		$evaluationDetails = new EvaluationDetails();
		//$this->frameworkId = Yii::app()->session['surDesign']['id'];
		$dataArray = [];
		$dataArray['formType'] = 'Create';

		$model = new EvalForm();
		//print_r(FrameworkContext::model()->getFrameworkSummary($this->frameworkId)); die;
		$returnArray = self::getElementsAndDynamicAttributes(["frameworkId" => $this->frameworkId]);
		$elements = $returnArray['elements'];
		$model->setRules($returnArray['rules']);
		$model->setPropertyNames($returnArray['dynamicDataAttributes']);
		$model->setAttributeLabels($returnArray['labels']);
		//$model->setPropertyName('frameworkId', $this->frameworkId);
		// generate the elements form
		$form = new CForm($elements);
		$form['evaluationHeader']->model = $evaluationHeader;
		$form['evaContext']->model = $model;
		//print_r($form->render());
		//die();
		//validate and save the evaluation data
		//print_r($form->elements['frameworkId']); die();
		//$form->elements['frameworkId']->options = [$this->frameworkId => ['selected' => true]];
		if ($form->submitted('DynamicForm') && $form->validate()) {
			$evaluationHeader->evaluationName = $form->model->evaluationName;
			$evaluationHeader->frameworkId = $form->model->frameworkId;
			$evaluationHeader->userId = Yii::app()->user->id;
			//save the componentHead values
			if (!$evaluationHeader->validate()) {
//				print_r($evaluationHeader->getErrors());
//				var_dump($form); die;
				Yii::app()->user->setFlash("notice", "The evaluation name must be unique.");
				//return $this->redirect('addEvaContext');
				$this->render('context', [
					'model'     => $model,
					'dataArray' => $dataArray,
					'form'      => $form
				]);
				return;
			}
			$evaluationHeader->save();
			$evalId = $evaluationHeader->evalId;
			// fetch the form data
			foreach ($form->model as $key => $val) {
				//ignore the attribute arrays
				if (!is_array($key) && !is_array($val)) {
					if ($key != "evaluationName" && $key != "frameworkId") {
						$evaluationDetails->setIsNewRecord(true);
						$evaluationDetails->evalDetailsId = null;
						$evaluationDetails->evalId = $evalId;
						$params = explode("-", $key);
						$evaluationDetails->evalElementsId = $params[1];
						$evaluationDetails->value = $val;
						$evaluationDetails->save();
					}
				}
			}
			//update the session variable for design
			$modelDesign = FrameworkContext::model()->findByPk($form->model->frameworkId);
			if (!empty($modelDesign)) {
				Yii::app()->session->add('surDesign', [
					'id'   => $modelDesign->frameworkId,
					'name' => $modelDesign->name
					//'goalId' => $modelDesign->goalId
				]);
			}
			//print_r($evaluationHeader); die;
			Yii::app()->session->add('evaContext', [
				'id'   => $evaluationHeader->evalId,
				'name' => $evaluationHeader->evaluationName,
			]);
			Yii::app()->user->setFlash('success', Yii::t("translation", "Evaluation successfully created"));
			$this->redirect(['addEvaContext']);
		}

		$this->render('context', [
			'model'     => $model,
			'dataArray' => $dataArray,
			'form'      => $form
		]);
	}

	/**
	 * @internal param $frameworkId
	 * @return string
	 */
	public function actionGetSurveillanceSummary() {
		$surveilanceRs = Yii::app()->db->createCommand()
			->select('ff.inputName, ffd.value')
			->from('frameworkHeader fh')
			->join('frameworkFieldData ffd', 'fh.frameworkId=ffd.frameworkId')
			->join('frameworkFields ff', 'ffd.frameworkFieldId=ff.Id')
			->where('fh.frameworkId=:id', [':id' => $this->frameworkId])
			->queryAll();

		$componentsRs = Yii::app()->db->createcommand()
			->select('ch.componentName, cd.value, sfd.inputName')
			->from('componentHead ch')
			->join('componentDetails cd', 'ch.componentId=cd.componentId')
			->join('surFormDetails sfd', 'cd.subFormId=sfd.subFormId')
			->where('ch.frameworkId=:id', [':id' => $this->frameworkId])
			->queryAll();
		$components = '<ul>';
		if (!empty($componentsRs)) {
			foreach ($componentsRs as $component) {
				$components .= '<li><b>' . $component['inputName'] . '</b>: ' .
					$component['value'] . '</li>';
			}
			//print_r($components); die;
			array_push($surveilanceRs, [
				'inputName' => 'Components',
				'value'     => $components]);

		}
		$components .= '</ul>';
		//print_r(array('inputName' => 'Component', 'value' => array_values($components))); die;
//print_r(json_encode(array("aaData" => $surveilanceRs))); die;
		echo json_encode(["aaData" => $surveilanceRs], JSON_UNESCAPED_SLASHES);
		return;


	}

	/**
	 * actionShowEval
	 * @access public
	 * @return void
	 */
	public function actionShowEval() {
		Yii::log("actionShowEval called", "trace", self::LOG_CAT);
		$model = new EvaluationHeader();
		$dataArray = [];
		if (isset($_GET['evalId'])) {
			$selectedEval = Yii::app()->db->createCommand()
				->select(' h.evalId,
						h.evaluationName,
						fh.frameworkId,
						fh.name,
						ee.label,
						ed.value'
				)
				->from('evaluationHeader h')
				->join('frameworkHeader fh', 'h.frameworkId = fh.frameworkId')
				->join('evaluationDetails ed', 'ed.evalId = h.evalId')
				->join('evalElements ee', 'ee.evalElementsId = ed.evalElementsId')
				->where('h.evalId =' . $_GET['evalId'])
				->queryAll();
			// prepare the array for the view
			foreach ($selectedEval as $dat) {
				if (empty($dataArray['selectedEval']['Evaluation Name'])) {
					$dataArray['selectedEval']['Evaluation Name'] = $dat['evaluationName'];
				}
				if (empty($dataArray['selectedEval']['Design Context'])) {
					$dataArray['selectedEval']['Design Context'] = $dat['name'];
				}
				$dataArray['selectedEval'][$dat['label']] = $dat['value'];
			}
			//$dataArray['selectedEval'] = $selectedEval[0];
			//add the surveilance design to the session
			if (count($selectedEval) >= 1) {
				Yii::app()->session->add('evaContext', [
					'id'   => $_GET['evalId'],
					'name' => $selectedEval[0]['evaluationName'],
				]);

				//update the session variable for design
				Yii::app()->session->add('surDesign', [
					'id'   => $selectedEval[0]['frameworkId'],
					'name' => $selectedEval[0]['name']
					//'goalId' => $selectedEval[0]['goalId']
				]);
			} else {
				Yii::app()->session->remove('evaContext');
			}
			//print_r($selectedEval);
			//print_r($_SESSION);
		}

		$this->render('showEval', [
			'model'     => $model,
			'dataArray' => $dataArray
		]);
	}

	/**
	 * actionDeleteEval
	 * @access public
	 * @return void
	 */
	public function actionDeleteEval() {
		Yii::log("actionDeleteEval called", "trace", self::LOG_CAT);
		if (isset($_POST["delId"])) {
			$record = EvaluationHeader::model()->findByPk($_POST['delId']);
			if (!$record->delete()) {
				Yii::log("Error deleting evaluation:" . $_POST['delId'], "warning", self::LOG_CAT);
				//echo $errorMessage;
				echo Yii::t("translation", "A problem occured when deleting an evaluation ") . $_POST['delId'];
			} else {
				echo Yii::t("translation", "The Evaluation Context ") . Yii::t("translation", " has been successfully deleted");
			}
		}
	}

	/**
	 * getElementsAndDynamicAttributes
	 * @param array $componentData
	 * @access public
	 * @return array
	 */
	public function getElementsAndDynamicAttributes($componentData = []) {
		$elements = [];
		$attributeArray = [];
		$dynamicDataAttributes = [];
		//$getFormCondition = 't.formId=:formId';
		//$getFormParams = array(':formId' => 1);
		$getForm = EvaluationElements::model()->findAll();
		//$elements['title'] = "Components Form";
		$elements['showErrorSummary'] = true;
		$elements['showErrors'] = true;
		$elements['errorSummaryHeader'] = Yii::app()->params['headerErrorSummary'];
		$elements['errorSummaryFooter'] = Yii::app()->params['footerErrorSummary'];
		$elements['activeForm']['id'] = "Dynamic";
		$elements['activeForm']['enableClientValidation'] = true;
		$elements['activeForm']['clientOptions'] = [
			'validateOnSubmit' => true,
		];
		//$elements['activeForm']['enableAjaxValidation'] = false;
		$elements['activeForm']['class'] = 'CActiveForm';
		//print_r($getForm); die();
		$evalElements = $getForm;
		$dataArray['getForm'] = $elements;
		$inputType = 'text';
		//$dynamicDataAttributes['frameworkId'] = 'frameworkId';
		//$rules[] = ['frameworkId', 'required'];
		$designData = FrameworkContext::model()->findAll([
			//'select' => 'pageId, pageName',
			'condition' => 'userId=:userId',
			'params'    => [
				':userId' => Yii::app()->user->id,
			],
		]);
		$designItems = [];
		// process the dropdown data into an array
		foreach ($designData as $params) {
			$designItems[$params->frameworkId] = $params->name;
		}
		$elements['elements'] = EvaluationHeader::getElements();
		// add the dropdown items to the element
		//$elements['elements']['frameworkId']['items'] = $designItems;
		$elements['elements']['evaContext']['type'] = 'form';
		//$elements['elements']['evaluationName']['layout'] = '{label} {input} {hint} {error}';
		$rules = [];
		$labels = [];
		foreach ($evalElements as $element) {
			//set the model attribute array
			$attributeId = $element->inputName . "-" . $element->evalElementsId;
			$dynamicDataAttributes[$attributeId] = $attributeId;
			$validation = $element->required ? 'required' : 'safe';
			$rules[] = [$attributeId, $validation];
			$highlightClass = "";
			if (isset($attributeArray[$element->evalElementsId])) {
				$highlightClass = "attributeHighlight";
			}
			$labels[$attributeId] = $element->label;
			// add the elements to the CForm array
			$elements['elements']['evaContext']['elements'][$attributeId] = [
				'label'    => $element->label,
				'required' => $element->required,
				'type'     => $element->inputType,
				'class'    => $highlightClass,
				'title' => $element->elementMetaData
			];
			// Add an image icon that will be displayed on the ui to show more info
			$button = CHtml::image('', '', [
				'id'      => 'moreInfoButton' . $element->evalElementsId,
				'style'   => 'cursor:pointer',
				'class'   => 'ui-icon ui-icon-info',
				'title'   => 'More Information',
				'onClick' => '$("#moreInfoDialog").html($("#popupData' . $element->evalElementsId . '").html());$("#moreInfoDialog").dialog("open")'
			]);
			// Add the image icon and information to the layout/ui
			if (!empty($element->moreInfo) && !empty($element->url) && !empty($element->description)) {
				$elements['elements']['evaContext']['elements'][$attributeId]['layout'] = '{label}<div class="componentImagePopup">' . $button .
					'</div>{hint} {input}' . '<div id="popupData' . $element->evalElementsId . '" style="display:none">' . $valu->moreInfo . '</div>' .
					'<div class="componentDataPopup">' . $element->description .
					' <br/> <a href=' . $element->url . ' target=_blank>' . $element->url . '</a></div> {error}';
			}

			// add the values to the form
			if (!empty($componentData[$attributeId])) {
				$elements['elements']['evaContext']['elements'][$attributeId]['value'] = $componentData[$attributeId]['value'];
			}
			// add the component name element value
			if (!empty($componentData['evaluationName'])) {
				$elements['elements']['evaContext']['elements']['evaluationName']['value'] = $componentData['evaluationName'];
			}
			// add the frameworkId element value
			if (!empty($componentData['frameworkId'])) {
				$elements['elements']['evaContext']['elements']['frameworkId']['value'] = $componentData['frameworkId'];
			}
			//add the dropdown parameters
			if ($inputType == 'dropdownlist') {
				$items = CHtml::listData(Options::model()->findAll([
					'condition' => 'elementId=:elementId',
					'params'    => [
						':elementId' => $element->evalElementsId
					],
				]), 'optionId', 'label');

				// add the dropdown items to the element
				$elements['elements']['evaContext']['elements'][$attributeId]['items'] = $items;
			}
		}
		$elements['buttons'] = [
			'newEvaluation' => [
				'type'  => 'submit',
				'label' => 'Create Evaluation',
			],
		];
		$returnArray = [
			'elements' => $elements,
			'dynamicDataAttributes' => $dynamicDataAttributes,
			'labels' => $labels,
			'rules' => $rules
		];
		return $returnArray;
	}

	/**
	 * actionImageUpload
	 * @access public
	 * @return void
	 */
	public function actionImageUpload() {
		// files storage folder
		$dir = dirname(Yii::app()->request->scriptFile) . '/images/customImageUpload/';
		$_FILES['file']['type'] = strtolower($_FILES['file']['type']);

		if ($_FILES['file']['type'] == 'image/png'
			|| $_FILES['file']['type'] == 'image/jpg'
			|| $_FILES['file']['type'] == 'image/gif'
			|| $_FILES['file']['type'] == 'image/jpeg'
			|| $_FILES['file']['type'] == 'image/pjpeg'
		) {
			// setting file's mysterious name
			$filename = md5(date('YmdHis')) . '.jpg';
			$file = $dir . $filename;

			// copying
			move_uploaded_file($_FILES['file']['tmp_name'], $file);

			// displaying file
			$array = [
				'filelink' => Yii::app()->request->baseUrl . '/images/customImageUpload/' . $filename
			];
			echo stripslashes(json_encode($array));

		}
	}

	/**
	 * clearTags
	 * @param mixed $str
	 * @access public
	 * @return string
	 */
	function clearTags($str) {
		return strip_tags($str, '<code><span><div><label><a><br><p><b><i><del><strike><u><img><video><audio><iframe>' .
			'<object><embed><param><blockquote><mark><cite><small><ul><ol><li><hr><dl><dt><dd><sup><sub><big><pre>' .
			'<code><figure><figcaption><strong><em><table><tr><td><th><tbody><thead><tfoot><h1><h2><h3><h4><h5><h6>');
	}

}
