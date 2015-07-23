<?php $this->beginContent('//layouts/main'); ?>
<!--<div class="container">-->
<script type="text/javascript">
	$(function(){
		$('ul.operations').menu();

	});
</script>
<div class="span-5 last">
	<div id="sidebar">
		<?php
		$currentView = Yii::app()->controller->getAction()->getId();
		if (Yii::app()->controller->id == 'context') {
			$this->menu = [
				['label'  => Yii::t("translation", "Introduction"), 'url' => ['index'],
					'active' => strstr('index', $currentView)],
				['label'  => Yii::t("translation", "New Surveillance System"), 'url' => ['create'],
					'active' => strstr('create', $currentView)],
				['label'  => Yii::t("translation", "List Existing Systems"), 'url' => ['list'],
					'active' => strstr('list', $currentView)],
				['label'       => Yii::t("translation", "List Components"), 'url' => ['design/listComponents'],
					'itemOptions' => ['id' => 'showComponents']],
			];
		}
		// Setup Design controller side menus
		if (Yii::app()->controller->id == 'design') {

			$this->menu = array(
				array('label'       => Yii::t("translation", "Design Component"), 'url' => array('addComponent'),
					'itemOptions' => array(
						'id' => 'addComponent'
					),
					'active' => strstr('addComponent', $currentView),
				),
				array('label'  => Yii::t("translation", "Add Components"),
					'url' => array('addMultipleComponents'), 'itemOptions' => array(
					'id' => 'addMultipleComponents'
				),
					'active' => strstr('addMultipleComponents', $currentView),
				),
				array('label' => Yii::t("translation", "List Components"), 'url' => array('listComponents'),
					'itemOptions' => array(
						'id' => 'showComponents'
					),
					'active' => strstr('listComponents', $currentView),
				),
				//array('label'=>'Manage SurFormDetails', 'url'=>array('admin')),
			);
		}
		//Evaluation controller side menus

		if (Yii::app()->controller->id == 'evaluation') {
			$currentController = Yii::app()->controller->id;
			$this->menu = [
				['label' => Yii::t("translation", "Introduction to Evaluation of Surveillance "),
					'url'   => ['evaPage'],
					'items' => [
						['label' => 'The EVA Tool', 'url' => ["$currentController/evaPage"]],
						['label' => 'Evaluation Concepts', 'url' => ["$currentController/evaConcept"]],
						['label' => 'Economic Methods', 'url' =>
							["$currentController/evaMethods"]],
						['label' => 'Evaluation Attributes', 'url' => ["$currentController/evaAttributes"]]
					]
				],
				['label' => Yii::t("translation", "Describe Evaluation Context"),
				      'url'   => ["$currentController/listEvaContext"]],
				['label' => Yii::t("translation", "Select Evaluation Question"),
				      'url'   => ["$currentController/selectEvaQuestion"]],
				['label' => Yii::t("translation", "Select Evaluation Method"),
				      'url'   => ["$currentController/index"], 'items' => [
					['label' => Yii::t("translation", "Select components"),
					      'url'   => "#"],
					['label' => Yii::t("translation", "Select evaluation criteria and method"),
						  'url'   => ["$currentController/selectCriteriaMethod"]],
					['label' => Yii::t("translation", "Select evaluation attributes"),
					 'url'   => ["$currentController/selectEvaAttributes"]],
				],
				],
				['label' => Yii::t("translation", "Summary of the evaluation protocol"),
					'url' => ["$currentController/index"]],
				['label' => 'Perform the evaluation', 'url' => ["$currentController/index"]],
				['label' => 'How to report on the evaluation results', 'url' => ["$currentController/index"]]

			];
		}
		//        $this->beginWidget('zii.widgets.CPortlet', array(
		//            'title' => 'Operations',
		//        ));
		$this->beginWidget('zii.widgets.CMenu', array(
			'items'          => $this->menu,
			'activeCssClass' => 'ui-state-active',
			'htmlOptions'    => array(
//				'class' => 'operations'
				'class' => 'operations'
			),
		));
		$this->endWidget();
		?>
	</div>
	<!-- sidebar -->
</div>
<div class="span-19">
	<div id="content">
		<?php echo $content; ?>
	</div>
	<!-- content -->
</div>
<!--</div>-->
<!--</div>-->
<?php $this->endContent(); ?>
