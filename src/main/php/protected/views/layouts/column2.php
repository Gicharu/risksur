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
					'active' => strstr('list', $currentView)]
//				['label'       => Yii::t("translation", "List Components"), 'url' => ['design/listComponents'],
//					'itemOptions' => ['id' => 'showComponents']],
			];
		}
		// Setup Design controller side menus
		if (Yii::app()->controller->id == 'design') {

			$this->menu = [
				['label'       => Yii::t("translation", "Introduction"), 'url' => ['index'],
					'itemOptions' => [
						'id' => 'index'
					],
					'active' => strstr('index', $currentView),
				],
				['label'  => Yii::t("translation", "Add Components"),
					'url' => ['addMultipleComponents'], 'itemOptions' => [
					'id' => 'addMultipleComponents'
				],
					'active' => strstr('addMultipleComponents', $currentView),
				],
				['label' => Yii::t("translation", "List Components"), 'url' => ['listComponents'],
					'itemOptions' => [
						'id' => 'showComponents'
					],
					'active' => strstr('listComponents', $currentView),
					'items' => [
						['label' => Yii::t("translation", "Add details"),
						 'url'   => ['getDesignElements']],
					]
				],
				['label'=>'Reports', 'url'=> ['reports']],
			];
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
				['label' => Yii::t("translation", "Select Evaluation Methods"),
				      'url'   => "#", 'items' => [
					['label' => Yii::t("translation", "Select components"),
					      'url'   => ["$currentController/selectComponents"]],
					['label' => Yii::t("translation", "Select attributes"),
						  'url'   => ["$currentController/selectEvaAttributes"]],
					['label' => Yii::t("translation", "Select assessment methods"),
					 'url'   => ["$currentController/selectEvaAssMethod"]],
					['label' => Yii::t("translation", "Select economic methods"),
					 'url'   => ["$currentController/selectEconEvaMethods"]],
				],
				],
				['label' => Yii::t("translation", "Summary of the evaluation protocol"),
					'url' => ["$currentController/evaSummary"]],
				['label' => 'Perform the evaluation', 'url' => ["$currentController/performEvaluation"]],
				['label' => 'How to report on the evaluation results', 'url' => ["$currentController/report"]]

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
