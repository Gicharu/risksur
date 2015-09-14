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
	private $evaContextId;
	private $docName;
	private $objectiveId;
	private $evaQuestionId;

	/**
	 * init
	 */
	public function init() {
		$session = Yii::app()->session;
		$this->frameworkId = isset($session['surDesign']['id']) ?
			$session['surDesign']['id'] : null;
		$this->evaContextId = isset($session['evaContext']['id']) ?
			$session['evaContext']['id'] : null;
		$this->objectiveId = isset($session['surveillanceObjective']['id']) ?
			$session['surveillanceObjective']['id'] : null;
		$this->evaQuestionId = isset($session['evaContext']['questionId']) ?
			$session['evaContext']['questionId'] : null;
		//print_r($session['evaContext']);print_r($this); die;

	}

	protected function beforeAction($action) {
		$contextActions = [
			strtolower('selectEvaQuestion')    => 'selectEvaQuestion',
			strtolower('evaQuestionList')      => 'selectEvaQuestion',
			strtolower('evaQuestionWizard')    => 'evaQuestionWizard',
			strtolower('selectComponents')     => 'selectComponents',
			strtolower('selectCriteriaMethod') => 'selectCriteriaMethod',
			strtolower('selectEvaAttributes')  => 'selectEvaAttributes',
			strtolower('selectEvaAssMethod')   => 'selectEvaAssMethod',
			strtolower('selectEconEvaMethods')   => 'selectEconEvaMethods',
			strtolower('evaSummary')   => 'evaSummary',

		];
		$objectiveActions = [
			strtolower('selectCriteriaMethod') => 'selectCriteriaMethod',
			strtolower('selectEvaAttributes')  => 'selectEvaAttributes',
			strtolower('selectEvaAssMethod')   => 'selectEvaAssMethod',
		];
		$contextQuestionActions = [
			strtolower('selectEvaAttributes') => 'selectEvaAttributes'
		];
		//var_dump(isset($contextActions[$action->id]), $action->id); die;

		if (isset($objectiveActions[$action->id]) && !isset($this->objectiveId)) {
			Yii::app()->user->setFlash('notice', 'The current surveillance system does not have a surveillance objective please update it');
			$this->redirect(['context/list']);
			//return true;
		}
		if (isset($contextActions[$action->id]) && !isset($this->evaContextId)) {
			Yii::app()->user->setFlash('notice', 'Please select or create an evaluation context before proceeding');
			$this->redirect('listEvaContext');
		}
		if (isset($contextQuestionActions[$action->id]) && !isset($this->evaQuestionId)) {
			Yii::app()->user->setFlash('notice', 'Please select a question for your evaluation context before proceeding');
			$this->redirect('selectEvaQuestion');
		}
		return true;
	}


	/**
	 * actionIndex
	 * @access public
	 * @return void
	 */
	public function actionIndex() {
		Yii::log("actionIndex EvaluationController called", "trace", self::LOG_CAT);

		$model = new EvaluationHeader();
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
	 * @throws CHttpException
	 */
	public function actionEvaPage() {
		Yii::log("actionEvaPage called", "trace", self::LOG_CAT);
		$this->docName = 'evaPage';
		if (isset($_POST['pageId'])) {
			$this->savePage('evaPage');
		}
		$page = $this->getPageContent();
		if (empty($page)) {
			Yii::app()->user->setFlash('notice', 'This page is missing some information');
		}

		$this->render('_page', [
				'content'    => $page['content'],
				'editAccess' => $page['editAccess'],
				'editMode'   => $page['editMode']
			]
		);
	}


	/**
	 * @throws CHttpException
	 */
	public function actionEvaConcept() {
		Yii::log("actionEvaConcept called", "trace", self::LOG_CAT);
		$this->docName = 'evaConcepts';
		if (isset($_POST['pageId'])) {
			$this->savePage('evaConcept');
		}
		$page = $this->getPageContent();
		if (empty($page)) {
			Yii::app()->user->setFlash('notice', 'This page is missing some information');
		}
		$this->render('_page', [
				'content'    => $page['content'],
				'editAccess' => $page['editAccess'],
				'editMode'   => $page['editMode']
			]
		);

	}

	/**
	 * @return array
	 */
	private function getPageContent() {
		Yii::log("Function getPageContent ContextController called", "trace", self::LOG_CAT);
		$content = DocPages::model()->find("docName='$this->docName'");
		if (empty($content)) {
			return [];
		}
		$editAccess = false;
		if (Yii::app()->rbac->checkAccess('context', 'savePage')) {
			$editAccess = true;
		}
		$editMode = false;
		if (isset($_POST['page']) && DocPages::model()->count('docId=' . $_POST['page']) > 0) {
			$editMode = true;
		}
		return [
			'content'    => $content,
			'editAccess' => $editAccess,
			'editMode'   => $editMode
		];
	}

	/**
	 * @param $action
	 */
	private function savePage($action) {
		//var_dump($_POST); die;
		Yii::log("Function SavePage ContextController called", "trace", self::LOG_CAT);
		$model = DocPages::model()->findByPk($_POST['pageId']);
		if (isset($_POST['survContent'])) {
			$purifier = new CHtmlPurifier();
			$model->docData = $purifier->purify($_POST['survContent']);
			if ($model->update()) {
				Yii::app()->user->setFlash('success', 'The page was updated successfully');
				$this->redirect($action);
				return;
			}
		}

		Yii::app()->user->setFlash('error', 'The page was not updated successfully, contact your administrator');
		$this->redirect($action);
		return;
	}

	/**
	 * actionEvaMethods
	 */
	public function actionEvaMethods() {
		Yii::log("actionEvaMethods called", "trace", self::LOG_CAT);
		$this->setPageTitle(Yii::app()->name . ' - Economic evaluation methods');
		$dataProvider = new CActiveDataProvider('EconEvaMethods');
		//print_r($dataProvider->getData()); die;
		$this->render('evaMethods', ['dataProvider' => $dataProvider]);
	}


	/**
	 * @throws CHttpException
	 */
	public function actionSelectEvaQuestion() {
		Yii::log("actionSelectEvaQuestion called", "trace", self::LOG_CAT);
		$this->setPageTitle('Select evaluation question');
		$this->docName = 'evaQuestion';
		if (isset($_POST['pageId'])) {
			$this->savePage('selectEvaQuestion');
		}
		$page = $this->getPageContent();
		if (empty($page)) {
			Yii::app()->user->setFlash('notice', 'This page is missing some information');
		}

		$this->render('selectEvaQuestion', ['page' => $page]);
		return;
	}

	/**
	 * actionEvalQuestionList
	 * @param string $questionId
	 */
	public function actionEvalQuestionList($questionId = '') {
		Yii::log("actionEvalQuestionList called", "trace", self::LOG_CAT);
		$this->setPageTitle('Select evaluation question');
		if (!empty($_POST['EvaluationQuestion']['question'])) {
			$model = EvaluationHeader::model()->findByPk($this->evaContextId);
			$model->questionId = $_POST['EvaluationQuestion']['question'];
			$model->update();
			$session = Yii::app()->session;
			$sessionEvaParams = $session['evaContext'];
			//print_r(Yii::app()->session['evaContext']); die;
			$sessionEvaParams['questionId'] = $model->questionId;
			$session['evaContext'] = $sessionEvaParams;
			$this->redirect('selectEvaAttributes');
			return;
		}
		$model = new EvaluationQuestion();
		$questionCriteria = new CDbCriteria();
		$questionCriteria->select = "*, CAST(`questionNumber` as SIGNED) AS castedColumn";
		$questionCriteria->condition = "flag='final'";
		$questionCriteria->order = 'castedColumn ASC, questionNumber ASC';
		$questionsRs = $model->findAll($questionCriteria);
		$currentQuestion = EvaluationHeader::model()->findByPk($this->evaContextId);
		$model->question = $currentQuestion->questionId;
		$elements = ContextController::getDefaultElements();
		$elements['title'] = '<h3>Evaluation question pick list </h3>';
		$elements['elements'] = [
			'question' => [
				'type'      => 'radiolist',
				'separator' => '<br>',
				'style'     => 'width:1em;',
				'template'  => '<span class="rb">{input} {label}</span>',
				'items'     => CHtml::listData($questionsRs, 'evalQuestionId',
					function ($qOption) {
						return CHtml::encode($qOption->questionNumber . ' ' . $qOption->question);
					})
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
	 * actionEconEval
	 */
	public function actionEconEval() {
		Yii::log("actionEconEval called", "trace", self::LOG_CAT);
		if (empty(Yii::app()->session['surDesign'])) {
			Yii::app()->user->setFlash('notice', 'Please select a surveillance system before proceeding');
			$this->redirect(Yii::app()->request->getUrlReferrer());
			return;

		}
		if (empty(Yii::app()->session['evalQuestion'])) {
			Yii::app()->user->setFlash('notice', 'Please select the evaluation question before proceeding');
			$this->redirect('selectEvaQuestion');
			return;
		}

		$this->render('econEval');

	}

	/**
	 * actionGetEvaSummary
	 */
	public function actionGetEvaSummary() {
		// get list of surveillance designs
		$componentList = ComponentHead::model()->findAll([
			'select'    => 'componentName',
			'condition' => 'frameworkId=:frameworkId',
			'params'    => [
				':frameworkId' => Yii::app()->session['surDesign']['id'],
			],
		]);
		$tableData = [];
		$tableData['Active Components'] = '';
		foreach ($componentList as $component) {
			$tableData['Active Components'] .= 'Active surveillance in ' . $component['componentName'] . '<br />';
		}
		$evaQuestionId = Yii::app()->session['evalQuestion'];

		$surQuestionWithCriteria = EvaquestionHasCriteriaAndAssessment::model()
			->with('criteria', 'question')
			->findAll([
					'select'    => 't.question_Id,t.criteria_Id',
					'condition' => 'question_Id=:questionId',
					'params'    => [':questionId' => $evaQuestionId]
				]
			);
		$tableData['Evaluation Question'] = '';
		$tableData['Assessment Criteria'] = '';
		$counter = 1;
		foreach ($surQuestionWithCriteria as $questionWithCriteria) {
			$tableData['Evaluation Question'] = $questionWithCriteria->question->question;
			$tableData['Assessment Criteria'] .= $questionWithCriteria->criteria->criteria_name;
			if ($counter < count($surQuestionWithCriteria)) {
				$tableData['Assessment Criteria'] .= ' and ';
			}
			$counter++;
		}
		echo json_encode($tableData, JSON_UNESCAPED_SLASHES);
		return;

	}

	/**
	 * actionEvaQuestionWizard
	 */
	public function actionEvaQuestionWizard() {
		Yii::log("actionEvaQuestionWizard called", "trace", self::LOG_CAT);
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
//			$regExUrl = '/(http|https|ftp|ftps)\:\/\/[a-zA-Z0-9\-\.]+\.[a-zA-Z]{2,3}(\/\S*)?/';
			// Check if there is a url in the text
			$attrDescription = UtilModel::urlToLink($description->description);
//			if (preg_match($regExUrl, $description->description, $url)) {
//
//				// make the urls hyper links
//				$attrDescription = preg_replace($regExUrl, "<a href=\"{$url[0]}\" target=\"_blank\">{$url[0]}</a>",
//					$description->description);
//
//			}
			echo json_encode(['description' => "<p>$attrDescription</p>"]);
			return;
		}
		$evaAttributes = CHtml::listData(Attributes::model()
			->with('evaAttributeTypes')
			->findAll(), 'attributeId', 'name', function ($attribute) {
			return $attribute->evaAttributeTypes->name;
		}); //die;

		$tableColumns = CHtml::listData(EvaAttributeTypes::model()->findAll(), 'id', 'name');
		// Load / save page instructions
		if (isset($_POST['pageId'])) {
			SystemController::savePage($this->createUrl('evaAttributes'));
		}
		$page = SystemController::getPageContent('evaAttributesList');
		if (empty($page)) {
			Yii::app()->user->setFlash('notice', 'This page is missing some information');
		}


		$this->render('evaAttributes', [
			'tableColumns'  => $tableColumns,
			'evaAttributes' => $evaAttributes,
			'page'          => $page
		]);

	}

	public function actionSelectCriteriaMethod() {
		$evaDetails = $this->getEvaDetails();

		// get method / criteria groups
		$groups = EvaQuestionGroups::model()->find("section='evaCriteriaMethod'");
		$groupsArray = json_decode($groups->questions);
		$group = $this->getQuestionGroup($groupsArray);
		$pageData = [];
		$pageData['message'] = 'No further decisions about the evaluation methods are' .
			' required please click next to display summary of evaluation protocol';
		$pageData['link'] = $this->createUrl('evaSummary');
		if ($group > 1) {
			$pageData['message'] = 'Please click next to select evaluation attributes to include in your evaluation';
			$pageData['link'] = $this->createUrl('selectEvaAttributes');
		}
		$this->render('selectCriteriaMethod', ['evaDetails' => $evaDetails, 'pageData' => $pageData]);
	}

	private function getQuestionGroup($groupArray) {
		$groupKey = [];
		//print_r($groupArray); print_r(Yii::app()->session['evaContext']); die;
		//var_dump(Yii::app()->session['evalQuestion'], Yii::app()->session['evaContext']['questionId']); die;
		foreach ($groupArray as $group => $questionsArray) {
			if (isset(array_flip($questionsArray)[Yii::app()->session['evaContext']['questionId']])) {
				$groupKey[] = $group;
				//break;
			}
		}
		return $groupKey;
	}

	/**
	 * @return array
	 */
	private function getEvaDetails() {
		$detailsCriteria = new CDbCriteria();
		$detailsCriteria->select = 'evalId, evaluationName, components';
		$detailsCriteria->with = ['frameworks', 'evaMethods', 'evaCriteria'];
		$model = ModelToArray::convertModelToArray(EvaluationHeader::model()
			->findByPk($this->evaContextId, $detailsCriteria));
		$evaluationDataCriteria = new CDbCriteria();
		$evaluationDataCriteria->condition = "inputName='riskBasedOpts' AND data.evalId=" . $this->evaContextId;
		$evaluationDataCriteria->with = 'data';
		$evaluationDataModel = EvaluationElements::model()->find($evaluationDataCriteria);
		$evaMethods = '';
		$evaCriteria = '';
		array_walk($model['evaMethods'], function ($item) use (&$evaMethods) {
			$evaMethods .= $item['name'] . ',';
		});
		array_walk($model['evaCriteria'], function ($item) use (&$evaCriteria) {
			$evaCriteria .= $item['name'] . ',';
		});
		$model['evaMethods'] = rtrim($evaMethods, ',');
		$model['evaCriteria'] = rtrim($evaCriteria, ',');
		$components = '';
		if (isset($model['components'])) {
			$componentArray = ModelToArray::convertModelToArray(
				ComponentHead::model()->findAllByPk(json_decode($model['components'])));
			array_walk($componentArray, function ($item) use (&$components) {
				$components .= $item['componentName'] . ',';
			});
			$components = rtrim($components, ',');
		}
		$rsSurvObj = FrameworkFields::model()->with('options', 'data')->find("inputName='survObj' AND data.frameworkId="
			. $model['frameworks']['frameworkId'] . " AND data.value=options.optionId");
		//print_r($rsSurvObj); die;

		$evaDetails[] = ['Evaluation name', $model['evaluationName']];
		$evaDetails[] = ['Surveillance system name', $model['frameworks']['name']];
		$evaDetails[] = ['Surveillance components to evaluate', $components]; //$evaDetailsArray;
		$evaDetails[] = ['Surveillance objective', isset($rsSurvObj['options'][0]['label']) ?
			$rsSurvObj['options'][0]['label'] : ''];
		$evaDetails[] = ['Evaluation question', $model['question']['question']];
		$evaDetails[] = ['Evaluation criteria', $model['evaCriteria']];
		$evaDetails[] = ['Evaluation method', $model['evaMethods']];
		$evaDetails[] = ['Whether risk based approach used',
			is_null($evaluationDataModel) ? 'N/A' :
				json_decode($evaluationDataModel->options)[$evaluationDataModel->data[0]['value']]]; //$evaDetailsArray;
		return $evaDetails;
	}

	/**
	 * actionSelectComponents
	 */
	public function actionSelectComponents() {
		$this->setPageTitle('Select components');
		// check if the context supports component selection
		$rsEvaluationType = EvaluationDetails::model()->find('evalElementsId=:element AND evalId=:evaId',
			[':element' => 5, ':evaId' => $this->evaContextId]);
		if(isset($rsEvaluationType) && $rsEvaluationType->value == 0) {
			Yii::app()->user->setFlash('notice', 'The evaluation context is system based hence no components are needed');
			$this->redirect('selectEvaAttributes');

		}
		$model = new DesignForm();
		$elements = ContextController::getDefaultElements();
		$rules = [];
		$evaDetails = $this->getEvaDetails();
		$componentsCriteria = new CDbCriteria();
		$componentsCriteria->select = 'componentId, componentName';
		$componentsCriteria->condition = 'frameworkId=:framework';
		$componentsCriteria->params = [':framework' => $this->frameworkId];
		$elements['elements'] = [
			'<fieldset><legend>Select Components</legend>',
			'<p> Please select the components you would like to include in your evaluation from the components' .
			' included in this system using the table below.  If the components you want to include are not listed' .
			' in this table please go back and enter the information about your components into the ' .
			CHtml::link('add components', 'listEvaContext') . ' screen. </p>',
			'<table id="componentsDisplay" width="100%" border="0" cellspacing="0" cellpadding="0">',
			'<thead><tr></tr><th></th><th>Component Name</th><th>Target Species</th><th>Data collection point</th>' .
			'<th>Study type</th></tr></thead>',
			'<tbody></tbody>',
			'</table>',
			'</fieldset>'
		];
		$rules[] = ['components', 'required'];
		$evaModel = EvaluationHeader::model()->find('evalId=:evalId', [':evalId' => $this->evaContextId]);

		$model->setPropertyName('components');
		$elements['buttons'] = [
			'save' => [
				'label' => 'Save',
				'type'  => 'submit'
			],
			'next' => [
				'label' => 'Next',
				'type'  => 'submit'
			]
		];
		$componentsConditions = EvaQuestionGroups::model()
			->find('section=:section', [':section' => 'evaComponents'])->questions;
		$availableComponents = json_decode($componentsConditions, true);
		$requiredComponents = 1;
		if (isset(array_flip($availableComponents[2])[$this->evaQuestionId])) {
			$requiredComponents = 2;
		}
		//var_dump($availableComponents, $this->evaQuestionId); die;
		// Get number of components
		$componentNo = EvaluationDetails::model()
			->find('evalId=:evaId AND evalElementsId=:evaElement',
				[':evaId' => $this->evaContextId, ':evaElement' => 6])->value;
		$rules[] = ['components', 'type', 'type' => 'array'];
		$rules[] = ['components', 'ext.validators.ComponentNumber', 'requiredComponents' => $requiredComponents,
		                                                            'declaredComponents' => $componentNo];
		//var_dump($requiredComponents, $componentNo); die;
		$model->setRules($rules);

		$tableData = DesignController::getComponentData()['componentListArray'];
		$componentsList = json_encode($tableData);
		//print_r($model); die;
		$form = new CForm($elements, $model);
		//print_r($_POST); die;
		if ($form->submitted('save') || $form->submitted('next')) {
			if ($form->validate()) {
				$evaModel->components = json_encode($form->model->components);
//				print_r($evaModel->components); die;
				if ($evaModel->save()) {
					Yii::app()->user->setFlash('success', 'Components successfully saved');
					if (isset($_POST['next'])) {
						$this->redirect('selectEvaAttributes');
					}
				} else {
					Yii::app()->user->setFlash('error', 'An error occurred while save the components,' .
						' please try again or contact your administrator if this problem persists');

				}
			}
		}
		$selectedComponents = is_null($evaModel->components) ? [] : json_decode($evaModel->components);
		//var_dump($selectedComponents); //die;
		$this->docName = 'selectComponents';
		if (isset($_POST['pageId'])) {
			SystemController::savePage('selectComponents');
		}
		$page = SystemController::getPageContent($this->docName);
		if (!isset($page['content']->docData)) {
			Yii::app()->user->setFlash('notice', 'This page is missing some information, please contact your administrator');
		}
		$this->render('selectComponents', compact('form', 'componentsList', 'selectedComponents', 'page', 'evaDetails'));
		return;
	}

	/**
	 * actionSelectEvaAttributes
	 */
	public function actionSelectEvaAttributes() {
		$this->setPageTitle('Select Evaluation Attributes');
		$evaDetails = $this->getEvaDetails();
		$this->docName = 'evaAttributes';
		if (isset($_POST['pageId'])) {
			$this->savePage('selectEvaAttributes');
		}
		$page = $this->getPageContent();
		if (!isset($page)) {
			Yii::app()->user->setFlash('notice', 'This page is missing some information');
		}
		$groups = EvaQuestionGroups::model()->find("section='evaCriteriaMethod'");
		$groupsArray = json_decode($groups->questions);
		$group = $this->getQuestionGroup($groupsArray);
		//var_dump($group); die;
		$attributesCriteria = new CDbCriteria();
		$attributesCriteria->with = ['attributeTypes', 'attribute'];
		$attributesCriteria->order = 'relevance DESC';
		$attributesCriteria->condition = 'surveillanceObj=' . $this->objectiveId;
		$attributesCriteria->addInCondition("evaQuestionGroup", $group);
		//$attributesCriteria->params = [':survObj' => $this->objectiveId, ':group' => [$group]];
		$attributes = ModelToArray::convertModelToArray(EvaAttributesMatrix::model()->findAll($attributesCriteria));
		$evaluationModel = EvaluationHeader::model()->findByPk($this->evaContextId, ['select' => 'evalId, evaAttributes']);
		//print_r($attributes); die;
		$evaAttributes = isset($evaluationModel->evaAttributes) ? json_decode($evaluationModel->evaAttributes) : [];
		$evaluationModel->scenario = 'selectEvaAttributes';
		if (isset($_POST['saveEvaAttr'])) {
//			$evaluationModel->evaAttributes = json_encode($_POST['EvaluationHeader']['evaAttributes']);
			$evaluationModel->evaAttributes = isset($_POST['EvaluationHeader']) ?
				json_encode($_POST['EvaluationHeader']['evaAttributes']) : null;
			if ($evaluationModel->validate() && $evaluationModel->update(['evaAttributes'])) {
				Yii::app()->user->setFlash('success', 'Evaluation attributes saved successfully');
				if($_POST['saveEvaAttr'] == 'Next') {
					$this->redirect('selectEvaAssMethod');
					return;
				}

			}
			//var_dump($_POST, $evaluationModel); die;
		}
		$this->render('selectEvaAttributes', [
				'attributes'      => $attributes,
				'evaDetails'      => $evaDetails,
				'page'            => $page,
				'evaluationModel' => $evaluationModel
			]
		);
	}

	/**
	 * actionSelectEvaAssMethod
	 * @param $id mixed
	 */
	public function actionSelectEvaAssMethod($id = null) {
		$evaAttrCriteria = new CDbCriteria();
		$evaAttrCriteria->select = 'evaAttributes';
		$evaAttrCriteria->condition = 'evalId=' . $this->evaContextId;
		$evaluationAttributes = EvaluationHeader::model()
			->find($evaAttrCriteria);
		$evaAttributes = json_decode($evaluationAttributes->evaAttributes);
		// Get attribute names
		$evaAttributeMapCriteria = new CDbCriteria();
		$evaAttributeMapCriteria->select = 'attributeId, name';
		$evaAttributeMapCriteria->addInCondition('attributeId', $evaAttributes);
		$evaAttributeMap = CHtml::listData(EvaAttributes::model()->findAll($evaAttributeMapCriteria),
			'attributeId', 'name');
		$assessModel = new EvaAssessmentMethods('default');
		$assessModel->evaluationId = $this->evaContextId;
		if(isset($id)) {
			// check if assessment method(s) exist
			$assessMethods = ModelToArray::convertModelToArray(EvaAttributesAssessmentMethods::model()
				->with('evaAssessmentMethods')
				->findAll('t.evaAttribute=:attribute', [':attribute' => $id]));
			// Check if there is any custom method
			$customMethod = ModelToArray::convertModelToArray($assessModel
				->find('evaluationId=:evaId AND customAssessmentMethod IS NOT NULL',
					[':evaId' => $this->evaContextId]));
//			$response = $assessModel;
//			if(!is_null($customMethod)) {
//				$response = array_merge($assessMethods, $customMethod);
//			}
			echo json_encode(['aaData' => $assessMethods, 'customMethod' => $customMethod]);
			return;

		}
		if (isset($_POST['EvaAssessmentMethods'])) {
			//print_r($_POST); die;
			$transaction = Yii::app()->db->beginTransaction();
			try {
				$assessModel->deleteAll('evaluationId=:evalId', [':evalId' => $this->evaContextId]);
				foreach ($_POST['EvaAssessmentMethods'] as $row) {
					$assessModel->attributes = $row;
					if(isset($_POST['EvaAssessmentMethods']['customAssessmentMethod']) &&
						$_POST['EvaAssessmentMethods']['customAssessmentMethod'] != '')  {
						$assessModel->setScenario('customMethod');
						$assessModel->customAssessmentMethod = $_POST['EvaAssessmentMethods']['customAssessmentMethod'];
						//print_r($assessModel); die;
						$assessModel->save();
						$assessModel->setScenario('default');
						break;
					}
					if(isset($assessModel->assessmentMethod)) {
						$assessModel->save();
					}

				}
				if(!$assessModel->hasErrors()) {
					$transaction->commit();

					if (isset($_POST['next'])) {
						Yii::app()->user->setFlash('success', 'Assessment method(s) saved successfully');
						$this->redirect('evaSummary');
						return;
					}

				}

			} catch (Exception $e) {
				$transaction->rollBack();
				Yii::app()->user->setFlash('error', 'An error occurred while saving the assessment method(s),' .
					' please try again or contact your administrator if the problem persists');
			}
		}
		if (isset($_POST['pageId'])) {
			SystemController::savePage('selectEvaAssMethod');
		}
		$this->docName = 'evaAssMethods';
		$page = SystemController::getPageContent($this->docName);
		$this->render('selectEvaAssMethod', [
			'assessModel' => $assessModel,
			'evaAttributeMap' => $evaAttributeMap,
			'page' => $page
		]);
	}

	public function actionSelectEconEvaMethods() {
		// Get relevant questions
		$econQuestions = (array) json_decode(ModelToArray::convertModelToArray(EvaQuestionGroups::model()
			->find('section=:sec', [':sec' => 'econEvaMethods']))['questions']);
		// Group 1 ===> Cost-effectiveness analysis
		// Group 2 ===> Cost-benefit analysis
		// Group 3 ===> Cost-benefit analysis & Cost-benefit analysis
		$econMethodGroup = null;
		//echo $this->evaQuestionId; die;
		foreach($econQuestions as $groupKey => $questionGroups) {
			if(isset(array_flip($questionGroups)[$this->evaQuestionId])) {
				$econMethodGroup = $groupKey;
				break;
			}
		}
		if(!isset($econMethodGroup)) {
			Yii::app()->user->setFlash('notice', 'The evaluation question selected for this evaluation context does not' .
				'have any economic evaluation methods');
			$this->redirect('evaSummary');
		}
		// Get evaluation context model
		$evaModel = EvaluationHeader::model()->findByPk($this->evaContextId);
		if(isset($_POST['save']) || isset($_POST['next'])) {
			if(isset($_POST['EvaluationHeader'])) {
				$selectedMethods = [];
				foreach($_POST['EvaluationHeader'] as $selectedMethod) {
					$selectedMethods[] = $selectedMethod['econEvaMethods'];
				}
				$evaModel->econEvaMethods = json_encode($selectedMethods);


			} else {
				$evaModel->econEvaMethods = null;
			}
			if($evaModel->save()) {
				Yii::app()->user->setFlash('success', 'Economic evaluation method(s) saved successfully');

				if(isset($_POST['next'])) {
					$this->redirect('evaSummary');
					return;
				}
			} elseif(!$evaModel->hasErrors()) {
				Yii::app()->user->setFlash('error', 'An error occurred while saving the economic evaluation' .
					' method(s), please try again or contact your administrator if the problem persists');
			}
		}

		// Get economic evaluation methods based on the group of the question
		$rsEconMethods = EconomicMethods::model()
			->with('econMethodGroup')
			->findAll('econMethod=:econGroup', [':econGroup' => $econMethodGroup]);
		//print_r($rsEconMethods); die;
		$econMethods = json_encode(ModelToArray::convertModelToArray($rsEconMethods));

		if (isset($_POST['pageId'])) {
			SystemController::savePage('selectEconEvaMethods');
		}
		$this->docName = 'econEvaMethods';
		$page = SystemController::getPageContent($this->docName);

		$this->render('selectEconEvaMethods', [
			'page' => $page,
			'econMethods' => $econMethods,
			'evaModel' => $evaModel
		]);




	}

	/**
	 * actionEvaSummary
	 */
	public function actionEvaSummary() {
		$this->setPageTitle('Evaluation Summary');
		$evaDetails = $this->getEvaDetails();
		$evaAssMethods = ModelToArray::convertModelToArray(EvaAssessmentMethods::model()
			->with('evaluationAttributes', 'evaAttrAssMethods')
			->findAll());
		$econEvaMethods = [];
		$selectedEconEvaMethods = [];
		$rsEconMethods = ModelToArray::convertModelToArray(EvaluationHeader::model()
			->findByPk($this->evaContextId,
				['condition' => 'econEvaMethods IS NOT NULL', 'select' => 'econEvaMethods']));
		if(isset($rsEconMethods['econEvaMethods'])) {
			$selectedEconEvaMethods = json_decode($rsEconMethods['econEvaMethods']);
			$econEvaMethodsCriteria = new CDbCriteria();
			$econEvaMethodsCriteria->addInCondition('t.id', $selectedEconEvaMethods);
			$econEvaMethodsCriteria->with = 'econMethodGroup';
			$econEvaMethods = ModelToArray::convertModelToArray(EconomicMethods::model()
				->findAll($econEvaMethodsCriteria));

		}
		//print_r($econEvaMethods); die;
		$this->render('evaSummary', [
			'evaDetails'    => $evaDetails,
			'evaAssMethods' => $evaAssMethods,
			'econEvaMethods' => $econEvaMethods
		]);
	}

	/**
	 * @param bool $ajax
	 * @return void
	 */
	public function actionListEvaContext($ajax = false) {
		Yii::log("actionListEvaContext called", "trace", self::LOG_CAT);
		$this->setPageTitle('List Evaluation Contexts');
		if ($ajax) {
			$contextCriteria = new CDbCriteria();
			$contextCriteria->select = 'evaluationName, frameworkId, questionId';
			$contextCriteria->with = ['frameworks', 'question'];
			$contextCriteria->condition = 't.userId=' . Yii::app()->user->id .
				' AND t.frameworkId=' . $this->frameworkId;
			$evaContextArray = ModelToArray::convertModelToArray(EvaluationHeader::model()->findAll($contextCriteria));
			$evaContexts = $this->replaceNullQuestion($evaContextArray);
			//var_dump($evaContexts); die;
			echo json_encode(['aaData' => $evaContexts]);
			return;
		}
		if (is_null($this->frameworkId)) {
			Yii::log('No surveillance system selected! ', 'trace', self::LOG_CAT);
			Yii::app()->user->setFlash('notice', 'Please select a surveillance system above before proceeding');
			$this->redirect(['evaPage']);
			return;

		}
		$this->render('listEvaContext');
	}

	private function replaceNullQuestion($array) {
		foreach ($array as $key => $value) {
			if (is_array($array[$key])) {
				$array[$key] = $this->replaceNullQuestion($array[$key]);
			} else {
				if (is_null($array[$key])) {
					$array[$key] = '';
					if ($key == 'question') {
						$array[$key]['question'] = '';
					}
				}
			}
		}
		return $array;
	}

	/**
	 * actionAddEvaContext
	 * @access public
	 * @return void
	 */
	public function actionAddEvaContext() {
		Yii::log("actionAddEvaContext called", "trace", self::LOG_CAT);
		$this->setPageTitle('Add Evaluation Context');
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
		$model->setProperties($returnArray['dynamicDataAttributes']);
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
		if ($form->submitted('newEvaluation')) {
			$evaluationHeader = $form['evaluationHeader']->model;
			$evaluationHeader->frameworkId = Yii::app()->session['surDesign']['id'];
			$evaluationHeader->userId = Yii::app()->user->id;
			$model->setProperties($_POST['EvalForm']);
			//var_dump($model); die;
			//save the componentHead values
			if ($evaluationHeader->save() && $model->save($evaluationHeader->evalId)) {
//
				Yii::app()->session->add('evaContext', [
					'id'   => $evaluationHeader->evalId,
					'name' => $evaluationHeader->evaluationName,
				]);
				Yii::app()->user->setFlash('success', Yii::t("translation", "Evaluation protocol created successfully"));
				$this->redirect(['selectEvaQuestion']);
				return;
			} elseif(!$evaluationHeader->hasErrors() && !$model->hasErrors()) {
				Yii::app()->user->setFlash('error', Yii::t("translation", "An error occurred when creating the " .
					"evaluation, please try again or contact your administrator if the problem persists"));

			}

		}

		$this->render('context', [
			'model'     => $model,
			'dataArray' => $dataArray,
			'form'      => $form
		]);
	}

	public function actionUpdateEvaContext($id) {
		Yii::log("actionUpdateEvaContext called", "trace", self::LOG_CAT);
		$this->setPageTitle('Update Evaluation Context');
		$evaluationHeader = EvaluationHeader::model()->with('evalDetails')->find('t.evalId=:evaId', [':evaId' => $id]);
		//$this->frameworkId = Yii::app()->session['surDesign']['id'];
		$dataArray = [];
		$dataArray['formType'] = 'Update';

		$model = new EvalForm();
		//print_r(FrameworkContext::model()->getFrameworkSummary($this->frameworkId)); die;
		$returnArray = self::getElementsAndDynamicAttributes();
		$elements = $returnArray['elements'];
		$model->setRules($returnArray['rules']);
		$model->setProperties($returnArray['dynamicDataAttributes']);
		$model->setAttributeLabels($returnArray['labels']);
		//print_r($model->attributes); die;
		foreach ($model->attributes as $attributeName => $attributeVal) {
			$attributeNameAndId = explode('_', $attributeName);
			foreach ($evaluationHeader->evalDetails as $evaluationData) {
				if (isset($attributeNameAndId[1]) && $attributeNameAndId[1] == $evaluationData->evalElementsId) {
					$model->setPropertyName($attributeName, $evaluationData->value);
					if (DForm::isJson($evaluationData->value)) {
						$model->setPropertyName($attributeName, json_decode($evaluationData->value));

					}
					break;
				}

			}
		}

		$elements['buttons'] = [
			'updateEvaluation' => [
				'label' => 'Update evaluation context',
				'type'  => 'submit'
			]
		];
		// generate the elements form
		$form = new CForm($elements);
		$form['evaluationHeader']->model = $evaluationHeader;
		$form['evaContext']->model = $model;

		if ($form->submitted('updateEvaluation')) {
			//die('opop');
			$evaluationHeader = $form['evaluationHeader']->model;
			$evaluationHeader->frameworkId = Yii::app()->session['surDesign']['id'];
			$evaluationHeader->userId = Yii::app()->user->id;
			$model->setProperties($_POST['EvalForm']);
			//var_dump($model); die;
			//save the componentHead values
			if ($evaluationHeader->save() && $model->save($evaluationHeader->evalId, false)) {
//
				if (isset(Yii::app()->session['evaContext'])) {
					Yii::app()->session->add('evaContext', [
						'id'         => $evaluationHeader->evalId,
						'name'       => $evaluationHeader->evaluationName,
						'questionId' => $evaluationHeader->questionId,
					]);

				}
				Yii::app()->user->setFlash('success', Yii::t("translation", "Evaluation protocol updated successfully"));
				$this->redirect(['listEvaContext']);
				return;
			}
			Yii::app()->user->setFlash('error', Yii::t("translation", "An error occurred when updating the " .
				"evaluation context, please try again or contact your administrator if the problem persists"));

		}

		$this->render('context', [
			'model'     => $model,
			'dataArray' => $dataArray,
			'form'      => $form
		]);
	}

	/**
	 * @param $id
	 * @param $name
	 * @param $questionId
	 */
	public function actionSetEvaContext($id, $name, $questionId) {
		Yii::app()->session->add('evaContext', [
			'id'         => $id,
			'name'       => $name,
			'questionId' => $questionId,
		]);
		Yii::app()->user->setFlash('success', "You have selected the $name Evaluation");
		$this->redirect(['evaluation/listEvaContext']);
		return;
	}

	/**
	 * @internal param $frameworkId
	 * @return string
	 */
	public function actionGetSurveillanceSummary() {
		$surveillanceCriteria = new CDbCriteria();
		$surveillanceCriteria->condition = 'frameworkId=' . $this->frameworkId;
		$surveillanceRs = FrameworkFields::model()->with('data', 'options')->findAll();
		$surveillanceFields = [
			'hazardName'       => 'Hazard Name',
			'survobj'          => 'Surveillance objective',
			'geographicalArea' => 'Geographical area',
			'stateOfDisease'   => 'State of disease',
			'legalReq'         => 'Legal Requirements',
		];
//		$evaDetails[] = ['Evaluation Name', $model['evaluationName']];
		//print_r($surveillanceRs); die;
		$surveillanceSummary = [];
		$surveillanceSummary[] = ['Surveillance system name', Yii::app()->session['surDesign']['name']];
		foreach ($surveillanceRs as $surveillanceFieldKey => $surveillanceField) {
			if (isset($surveillanceFields[$surveillanceField->inputName])) {
				$surveillanceFieldKey++;
				$surveillanceKey = $surveillanceFields[$surveillanceField->inputName];
				$surveillanceSummary[$surveillanceFieldKey] = [$surveillanceKey,
					isset($surveillanceField->data[0]) ? $surveillanceField->data[0]['value'] : ''];
				//print_r($surveillanceField->data[0]);
				if (isset($surveillanceField->options[0]) && isset($surveillanceField->data[0])) {
					//die('pop');
					foreach ($surveillanceField->options as $option) {
						if (($dataValue = json_decode($surveillanceField->data[0]['value'])[0]) == $option->optionId) {
							$surveillanceSummary[$surveillanceFieldKey] =
								[$surveillanceKey, $option->label];
							break;
						}
					}
				}


			}
		}
		//print_r($surveillanceSummary); die;

		echo json_encode(["aaData" => $surveillanceSummary], JSON_UNESCAPED_SLASHES);
		return;


	}


	/**
	 * actionDeleteEval
	 * @param string $id
	 * @return void
	 */
	public function actionDeleteEval($id) {
		Yii::log("actionDeleteEval called", "trace", self::LOG_CAT);
		$record = EvaluationHeader::model()->findByPk($id);
		if (!$record->delete()) {
			Yii::log("Error deleting evaluation: $id", "warning", self::LOG_CAT);
			//echo $errorMessage;
			echo Yii::t("translation", "A problem occurred when deleting the evaluation context");
		} else {
			echo Yii::t("translation", "The Evaluation Context has been successfully deleted");
		}
		return;
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
		$elements['activeForm']['id'] = "EvalForm";
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
			$attributeId = $element->inputName . "_" . $element->evalElementsId;
			$dynamicDataAttributes[$attributeId] = '';
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
				'title'    => $element->elementMetaData,
				'data-field' => $element->evalElementsId

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
			if ($element->inputType == 'dropdownlist') {
				$items = json_decode($element->options);
				if (!isset($element->options)) {
					$items = CHtml::listData(Options::model()->findAll([
						'condition' => 'elementId=:elementId',
						'params'    => [
							':elementId' => $element->evalElementsId
						],
					]), 'optionId', 'label');
				}
				// add the dropdown items to the element
				$elements['elements']['evaContext']['elements'][$attributeId]['items'] = $items;
				$elements['elements']['evaContext']['elements'][$attributeId]['prompt'] = 'Choose one';
			}
			if($element->inputName == 'currentCost' || $element->inputName == 'budgetLimit') {

				$elements['elements']['evaContext']['elements'][$attributeId]['class'] = 'update-able';
			}
		}
		$elements['buttons'] = [
			'newEvaluation' => [
				'type'  => 'submit',
				'label' => 'Create evaluation context',
			],
		];
		$returnArray = [
			'elements'              => $elements,
			'dynamicDataAttributes' => $dynamicDataAttributes,
			'labels'                => $labels,
			'rules'                 => $rules
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
	 * actionPerformEvaluation
	 */
	public function actionPerformEvaluation() {
		$this->docName = 'performEvaluation';
		if (isset($_POST['pageId'])) {
			SystemController::savePage('performEvaluation');
		}
		$page = SystemController::getPageContent($this->docName);
		$this->render('//system/_page', [
			'content' => $page['content'],
			'editAccess' => $page['editAccess'],
			'editMode' => $page['editMode']
		]);
		return;
	}

	/**
	 * actionReport
	 */
	public function actionReport() {
		$this->docName = 'evaluationReport';
		if (isset($_POST['pageId'])) {
			SystemController::savePage('reports');
		}
		$page = SystemController::getPageContent($this->docName);
		$this->render('//system/_page', [
			'content' => $page['content'],
			'editAccess' => $page['editAccess'],
			'editMode' => $page['editMode']
		]);
		return;
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
