<?php

	/**
	 * AttributeController 
	 * 
	 * @uses Controller
	 * @package 
	 * @version $id$
	 * @copyright Tracetracker
	 * @author Chirag Doshi <chirag@tracetracker.com> 
	 * @license Tracetracker {@link http://www.tracetracker.com}
	 */
	class AttributeController extends Controller {
		const LOG_CAT = "ctrl.AttributeController";
		//Use layout 
		public $layout = '//layouts/column2';

		/**
		 * filters
		 *
		 * @access public
		 * @return void
		 */
		public function filters() {
			Yii::log("filters called", "trace", self::LOG_CAT);
			return array(
				array(
					'application.filters.RbacFilter',
				),
			);
		}

		/**
		 * actionSelectAttribute 
		 * 
		 * @access public
		 * @return void
		 */
		public function actionSelectAttribute() {
			Yii::log("actionSelectAttribute called", "trace", self::LOG_CAT);
			//$model = new NewDesign;
			$attributesArray = array();
			$dataArray = array();
			$attributeData = PerfAttributes::model()->findAll();
			// create array options for attribute dropdown
			foreach ($attributeData as $data) {
				$dataArray['attributeList'][$data->attributeId] = $data->name;
				$attributesArray[$data->attributeId] = $data->name;
			}

			if (!empty($_POST['attributeSelected']) && !empty($attributesArray[$_POST['attributeSelected']])) {
				Yii::app()->session->add('performanceAttribute', array(
					'id' => $_POST['attributeSelected'],
					'name' => $attributesArray[$_POST['attributeSelected']]
				));
				echo "Attribute successfully selected";
				return;
			}
				//add the surveilance design to the session
				//if (count($selectedDesign) == 1) {
					//Yii::app()->session->add('surDesign', array(
						//'id' => $_GET['designId'],
						//'name' => $selectedDesign[0]->name,
						//'goalId' => $selectedDesign[0]->goalId
					//));
				//} else {
					//Yii::app()->session->remove('surDesign');
				//}
				//print_r($selectedDesign);
				//print_r($_SESSION);

			$this->render('selectAttribute', array(
				//'model' => $model,
				'dataArray' => $dataArray
			));
		}
	}
