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

	/**
	 * init
	 */
	public function init() {
		$this->frameworkId = isset(Yii::app()->session['surDesign']['id']) ?
			Yii::app()->session['surDesign']['id'] : null;
		$this->evaContextId = isset(Yii::app()->session['evaContext']['id']) ?
			Yii::app()->session['evaContext']['id'] : null;

	}

	protected function beforeAction($action) {
		$contextActions = [
			'selectEvaQuestion' => 'selectEvaQuestion',
			'evaQuestionList' => 'selectEvaQuestion',
			'evaQuestionWizard' => 'evaQuestionWizard',
			'evaAttributes' => 'evaAttributes',
			'selectCriteriaMethod' => 'selectCriteriaMethod',
			'selectEvaAttributes' => 'selectEvaAttributes',

		];
		if(isset($contextActions[$action->id]) && !isset($this->evaContextId)) {
			Yii::app()->user->setFlash('notice', 'Please select an evaluation context before you proceed');
			$this->redirect('listEvaContext');
			return true;
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
	 * @throws CHttpException
	 */
	public function actionEvaPage() {
		Yii::log("actionEvaPage called", "trace", self::LOG_CAT);
		$this->docName = 'evaPage';
		if(isset($_POST['pageId'])) {
			$this->savePage('evaPage');
		}
		$page = $this->getPageContent();
		if(empty($page)) {
			Yii::app()->user->setFlash('notice', 'This page is missing some information');
		}

		$this->render('_page', [
				'content' => $page['content'],
				'editAccess' => $page['editAccess'],
				'editMode' => $page['editMode']
			]
		);
	}


	/**
	 * @throws CHttpException
	 */
	public function actionEvaConcept() {
		Yii::log("actionEvaConcept called", "trace", self::LOG_CAT);
		$this->docName = 'evaConcepts';
		if(isset($_POST['pageId'])) {
			$this->savePage('evaConcept');
		}
		$page = $this->getPageContent();
		if(empty($page)) {
			Yii::app()->user->setFlash('notice', 'This page is missing some information');
		}
		$this->render('_page', [
				'content' => $page['content'],
				'editAccess' => $page['editAccess'],
				'editMode' => $page['editMode']
			]
		);

	}

	/**
	 * @return array
	 */
	private function getPageContent() {
		Yii::log("Function getPageContent ContextController called", "trace", self::LOG_CAT);
		$content = DocPages::model()->find("docName='$this->docName'");
		if(empty($content)) {
			return [];
		}
		$editAccess = false;
		if(Yii::app()->rbac->checkAccess('context', 'savePage')) {
			$editAccess = true;
		}
		$editMode = false;
		if(isset($_POST['page']) && DocPages::model()->count('docId=' . $_POST['page']) > 0) {
			$editMode = true;
		}
		return [
			'content' => $content,
			'editAccess' => $editAccess,
			'editMode' => $editMode
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
			if($model->update()) {
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
		$this->setPageTitle('Select evaluation question');
		$this->docName = 'evaQuestion';
		if(isset($_POST['pageId'])) {
			$this->savePage('selectEvaQuestion');
		}
		$page = $this->getPageContent();
		if(empty($page)) {
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
		$this->setPageTitle('Select evaluation question');
		if (!empty($_POST['EvaluationQuestion']['question'])) {
			$model = EvaluationHeader::model()->findByPk($this->evaContextId);
			$model->questionId = $_POST['EvaluationQuestion']['question'];
			$model->update();
			Yii::app()->session['evalQuestion'] = $_POST['EvaluationQuestion']['question'];
			//print_r(Yii::app()->session['evalQuestion']); die;
			$this->redirect('selectCriteriaMethod');
			return;
		}
		$model = new EvaluationQuestion();
		$questionsRs = $model->findAll('parentQuestion is null');
		$currentQuestion = EvaluationHeader::model()->findByPk($this->evaContextId);
		$model->question = $currentQuestion->questionId;
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
		if($group > 1) {
			$pageData['message'] = 'Please click next to select evaluation attributes to include in your evaluation';
			$pageData['link'] = $this->createUrl('selectEvaAttributes');
		}
		$this->render('selectCriteriaMethod', ['evaDetails' => $evaDetails, 'pageData' => $pageData]);
	}

	private function getQuestionGroup($groupArray) {
		$groupKey = null;
		foreach( $groupArray as $group => $questionsArray) {
			if(in_array($this->evaContextId, $questionsArray)) {
				$groupKey = $group;
				break;
			}
		}
		return $groupKey;
	}

	private function getEvaDetails() {
		$detailsCriteria = new CDbCriteria();
		$detailsCriteria->select = 'evalId, evaluationName';
		$detailsCriteria->with = ['frameworks', 'evaMethods', 'evaCriteria'];
		$model = ModelToArray::convertModelToArray(EvaluationHeader::model()
			->findByPk($this->evaContextId, $detailsCriteria));
		//print_r($model); die;
		$evaMethods = '';
		$evaCriteria = '';
		array_walk($model['evaMethods'], function($item) use (&$evaMethods) {
			$evaMethods .= $item['name'] . ',';
		});
		array_walk($model['evaCriteria'], function($item) use (&$evaCriteria) {
			$evaCriteria .= $item['name'] . ',';
		});
		$model['evaMethods'] = rtrim($evaMethods, ',');
		$model['evaCriteria'] = rtrim($evaCriteria, ',');

		$evaDetails[] = ['Evaluation Name', $model['evaluationName']];
		$evaDetails[] = ['Surveillance Name', $model['frameworks']['name']];
		$evaDetails[] = ['Surveillance components to evaluate', '']; //$evaDetailsArray;
		$evaDetails[] = ['Evaluation question', $model['question']['question']];
		$evaDetails[] = ['Evaluation criteria', $model['evaCriteria']];
		$evaDetails[] = ['Evaluation method', $model['evaMethods']];
		$evaDetails[] = ['Whether risk based approach used', '']; //$evaDetailsArray;
		return $evaDetails;
	}

	public function actionSelectEvaAttributes() {
		$evaDetails = $this->getEvaDetails();
		$this->docName = 'evaAttributes';
		if(isset($_POST['pageId'])) {
			$this->savePage('selectEvaAttributes');
		}
		$page = $this->getPageContent();
		if(!isset($page)) {
			Yii::app()->user->setFlash('notice', 'This page is missing some information');
		}
		$groups = EvaQuestionGroups::model()->find("section='evaCriteriaMethod'");
		$groupsArray = json_decode($groups->questions);
		$group = $this->getQuestionGroup($groupsArray);
		$attributesCriteria = new CDbCriteria();
		$attributesCriteria->with = ['attributeTypes', 'attribute'];
		$attributesCriteria->order = 'relevance DESC';
		$attributesCriteria->condition = "evaQuestionGroup=:group";
		$attributesCriteria->addCondition('surveillanceObj=:survObj');
		$attributesCriteria->params = [':group' => $group, ':survObj' => 1];
		$attributes = ModelToArray::convertModelToArray(EvaAttributesMatrix::model()->findAll($attributesCriteria));
		$evaluationModel = EvaluationHeader::model()->findByPk($this->evaContextId, ['select' => 'evalId, evaAttributes']);
		$evaAttributes = isset($evaluationModel->evaAttributes) ? json_decode($evaluationModel->evaAttributes): [];
		$evaluationModel->scenario = 'selectEvaAttributes';
//		var_dump($_POST); die;
		if(isset($_POST['saveEvaAttr'])) {
//			$evaluationModel->evaAttributes = json_encode($_POST['EvaluationHeader']['evaAttributes']);
				$evaluationModel->evaAttributes = isset($_POST['EvaluationHeader']) ?
					json_encode($_POST['EvaluationHeader']['evaAttributes']) : null;
				if($evaluationModel->validate() && $evaluationModel->update(['evaAttributes'])) {
					Yii::app()->user->setFlash('success', 'Evaluation attributes saved successfully');
					$this->redirect('selectEvaAssMethod');
					return;

				}
			//var_dump($_POST, $evaluationModel); die;
		}
		$this->render('selectEvaAttributes', [
				'attributes' => $attributes,
				'evaDetails' => $evaDetails,
				'page' => $page,
				'evaluationModel' => $evaluationModel
			]
		);
	}

	public function actionSelectEvaAssMethod() {
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
		// check if assessment method(s) exist
		$assessModel = EvaAssessmentMethods::model()
			->findAll(['condition' => 'evaluationId=' . $this->evaContextId]);

		foreach($evaAttributes as $key => $evaAttribute) {
			if(!isset($assessModel[$key])) {
				$assessModel[$key] = new EvaAssessmentMethods();
				$assessModel[$key]['evaAttribute'] = $evaAttribute;
				$assessModel[$key]['evaluationId'] = $this->evaContextId;

			}
			$assessModel[$key]['evaAttributeName'] = $evaAttributeMap[$evaAttribute];

		}
		if(isset($_POST['EvaAssessmentMethods'])) {
			$success = false;
			$transaction = Yii::app()->db->beginTransaction();
			try {
				for($key = 0; $key < count($assessModel); $key++) {
					$assessModel[$key]->attributes = $_POST['EvaAssessmentMethods'][$key];
					$success = $assessModel[$key]->save();

				}
				$transaction->commit();
				if($success) {
					Yii::app()->user->setFlash('success', 'Assessment method(s) saved successfully');
				}

			} catch (Exception $e) {
				$transaction->rollBack();
			}
		}
		$this->render('selectEvaAssMethod', ['assessModel' => $assessModel, 'evaAttributeMap' => $evaAttributeMap
		]);
	}

	public function actionEvaSummary() {
		$evaDetails = $this->getEvaDetails();
		$evaAssMethods = ModelToArray::convertModelToArray(EvaAssessmentMethods::model()
			->with('evaluationAttributes')
			->findAll(['select' => 'evaAttribute, methodDescription, dataAvailability']));
//		print_r($evaAssMethods); die;
		$this->render('evaSummary', [
			'evaDetails' => $evaDetails,
			'evaAssMethods' => $evaAssMethods
		]);
	}

	/**
	 * @param bool $ajax
	 */
	public function actionListEvaContext($ajax = false) {
		Yii::log("actionListEvaContext called", "trace", self::LOG_CAT);
		if($ajax) {
			$contextCriteria = new CDbCriteria();
			$contextCriteria->select = 'evaluationName, frameworkId, evaluationDescription, questionId';
			$contextCriteria->with = ['frameworks', 'question'];
			$contextCriteria->condition = 't.userId=' . Yii::app()->user->id .
				' AND t.frameworkId=' . $this->frameworkId;
			$evaContextArray = 	ModelToArray::convertModelToArray(EvaluationHeader::model()->findAll($contextCriteria));
			$evaContexts =$this->replaceNullQuestion($evaContextArray);
			//var_dump($evaContexts); die;
			echo json_encode(['aaData' => $evaContexts]);
			return;
		}
		if (is_null($this->frameworkId)) {
			Yii::log('No surveillance system selected! redirecting to context/list', 'trace', self::LOG_CAT);
			Yii::app()->user->setFlash('notice', 'Please select a surveillance system first');
			return $this->redirect(['context/list']);

		}
		$this->render('listEvaContext');
	}

	private function replaceNullQuestion($array) {
		foreach ($array as $key => $value) {
			if (is_array($array[$key])) {
				$array[$key] = $this->replaceNullQuestion($array[$key]);
			} else {
				if(is_null($array[$key])) {
					$array[$key] = '';
					if($key == 'question') {
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
			//print_r($model); die;
			//save the componentHead values
			if ($evaluationHeader->save() && $model->save($evaluationHeader->evalId)) {
//				print_r($evaluationHeader->getErrors());
//				var_dump($form); die;
//				Yii::app()->user->setFlash("notice", "The evaluation name must be unique.");
//				//return $this->redirect('addEvaContext');
//				$this->render('context', [
//					'model'     => $model,
//					'dataArray' => $dataArray,
//					'form'      => $form
//				]);
//				return;
				$evalId = $evaluationHeader->evalId;

				Yii::app()->session->add('evaContext', [
					'id'   => $evaluationHeader->evalId,
					'name' => $evaluationHeader->evaluationName,
				]);
				Yii::app()->user->setFlash('success', Yii::t("translation", "Evaluation protocol created successfully"));
				$this->redirect(['selectEvaQuestion']);
				return;
			}
			//update the session variable for design
//			$modelDesign = FrameworkContext::model()->findByPk($form->model->frameworkId);
//			if (!empty($modelDesign)) {
//				Yii::app()->session->add('surDesign', [
//					'id'   => $modelDesign->frameworkId,
//					'name' => $modelDesign->name
//					//'goalId' => $modelDesign->goalId
//				]);
//			}
			//print_r($evaluationHeader); die;
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
	 */
	public function actionSetEvaContext($id, $name) {
		Yii::app()->session->add('evaContext', [
			'id'   => $id,
			'name' => $name,
		]);
		Yii::app()->user->setFlash('success', "The Evaluation context is now $name");
		$this->redirect(['evaluation/listEvaContext']);
		return;
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
			if ($element->inputType == 'dropdownlist') {
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
