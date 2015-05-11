<?php $this->beginContent('//layouts/main'); ?>
<!--<div class="container">-->
<div class="span-5 last">
	<div id="sidebar">
		<?php
		$currentView = Yii::app()->controller->getAction()->getId();
		if (Yii::app()->controller->id == 'context') {
			$this->menu = array(
				array('label'  => Yii::t("translation", "New Surveillance System"), 'url' => array('create'),
				      'active' => strstr('create', $currentView)),
				array('label'  => Yii::t("translation", "List Existing Systems"), 'url' => array('list'),
				      'active' => strstr('list', $currentView)),
				array('label'       => Yii::t("translation", "List Components"), 'url' => array('design/listComponents'),
				      'itemOptions' => array(
					      'id' => 'showComponents'
				      )),
			);
		}
		// Setup Design controller side menus
		if (Yii::app()->controller->id == 'design') {

			$this->menu = array(
				array('label'       => Yii::t("translation", "Add Component"), 'url' => array('addComponent'),
				      'itemOptions' => array(
					      'id' => 'addComponent'
				      ),
				      'active'      => strstr('addComponent', $currentView),
				),
				array('label'  => Yii::t("translation", "Add Multiple Components"),
				      'url'    => array('addMultipleComponents'), 'itemOptions' => array(
					'id' => 'addMultipleComponents'
				),
				      'active' => strstr('addMultipleComponents', $currentView),
				),
				array('label'       => Yii::t("translation", "List Components"), 'url' => array('listComponents'),
				      'itemOptions' => array(
					      'id' => 'showComponents'
				      ),
				      'active'      => strstr('listComponents', $currentView),
				),
				//array('label'=>'Manage SurFormDetails', 'url'=>array('admin')),
			);
		}
		//Evaluation controller side menus

		if (Yii::app()->controller->id == 'evaluation') {
			$currentController = Yii::app()->controller->id;
			$this->menu = array(
				array('label' => Yii::t("translation", "Introduction to Evaluation of Surveillance "),
				      'url'   => array('evaPage'),
				      'items' => array(
					      array('label' => 'The EVA Tool', 'url' => array("$currentController/evaPage")),
					      array('label' => 'Evaluation Concepts', 'url' => array("$currentController/evaConcept")),
					      array('label' => 'Economic Evaluation methods', 'url' =>
						      array("$currentController/evaMethods")),
					      array('label' => 'Evaluation attributes', 'url' => array("$currentController/evaAttributes"))
				      )
				),
				array('label' => Yii::t("translation", "Describe Evaluation Context"),
				      'url'   => array("$currentController/addEvaContext")),
				array('label' => Yii::t("translation", "Select Evaluation Question"),
				      'url'   => array("$currentController/selectEvaQuestion")),
				array('label' => Yii::t("translation", "Evaluation attributes and economic criteria"),
				      'url'   => array("$currentController/index"), 'items' => array(
					array('label' => Yii::t("translation", "Economic evaluation"),
					      'url'   => array("$currentController/index")),
					array('label' => Yii::t("translation", "Epidemiological assessment"),
					      'url'   => array("$currentController/index")),
					array('label' => 'Final list of attributes', 'url' => array("$currentController/index"))
				),
				),

				array('label' => Yii::t("translation", "Summary and Report"),
				      'url'   => array("$currentController/index")),
			);
		}
		//        $this->beginWidget('zii.widgets.CPortlet', array(
		//            'title' => 'Operations',
		//        ));
		$this->beginWidget('zii.widgets.CMenu', array(
			'items'          => $this->menu,
			'activeCssClass' => 'active',
			'htmlOptions'    => array(
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
