<?php $this->beginContent('//layouts/main'); ?>
<!--<div class="container">-->
<div class="span-5 last">
	<div id="sidebar">
		<?php
			// Setup Design controller side menus
			if (Yii::app()->controller->id == 'design') {
				if (empty(Yii::app()->session['surDesign'])) {	
					$this->menu = array(
						array('label' => Yii::t("translation", "New Surveillance Design"), 'url' => array('createDesign')),
						array('label' => Yii::t("translation", "List Existing Designs"), 'url' => array('index')),
					);
				} else {
					$this->menu = array(
						array('label' => Yii::t("translation", "New Surveillance Design"), 'url' => array('createDesign')),
						array('label' => Yii::t("translation", "List Existing Designs"), 'url' => array('index')),
						array('label' => Yii::t("translation", "Add Component"), 'url' => array('addComponent'), 'itemOptions' => array (
							'id' => 'addComponent'
							)
						),
						array('label' => Yii::t("translation", "Add Multiple Components"), 'url' => array('addMultipleComponents'), 'itemOptions' => array ( 
							'id' => 'addMultipleComponents'
							)
						),
						array('label' => Yii::t("translation", "List Components"), 'url' => array('listComponents'), 'itemOptions' => array ( 
							'id' => 'showComponents'
							)
						),
						//array('label'=>'Manage SurFormDetails', 'url'=>array('admin')),
					);
				}
			}
			//Evaluation controller side menus

			if (Yii::app()->controller->id == 'evaluation') {
				$this->menu = array(
					array('label' => Yii::t("translation", "Introduction to Evaluation of Surveillance "), 'url' => array('createDesign'),
						'items' => array(
							array('label' => 'The EVA Tool', 'url' => array('index')), 
							array('label' => 'Evaluation Concepts', 'url' => array('index'))
						)
					),
					array('label' => Yii::t("translation", "Describe Evaluation Context"), 'url' => array('index')),
					array('label' => Yii::t("translation", "Select Evaluation Question"), 'url' => array('index')),
					array('label' => Yii::t("translation", "Assessment Criteria"), 'url' => array('index')),
					array('label' => Yii::t("translation", "Economic Assessment"), 'url' => array('index')),
					array('label' => Yii::t("translation", "Evaluation Attributes"), 'url' => array('index'),
						'items' => array(
							array('label' => 'Methods of Assessment', 'url' => array('index')), 
							array('label' => 'Final list of attributes', 'url' => array('index'))
						)
					),
					array('label' => Yii::t("translation", "Summary and Reports"), 'url' => array('index'),
					),
				);
			}
//        $this->beginWidget('zii.widgets.CPortlet', array(
//            'title' => 'Operations',
//        ));
		$this->beginWidget('zii.widgets.CMenu', array(
			'items' => $this->menu,
			//'itemCssClass' => 'ui-button ui-widget ui-state-default ui-corner-all ui-button-text-only',
			'htmlOptions' => array(
				'class' => 'operations'
			),
		));
		$this->endWidget();
		?>
	</div><!-- sidebar -->
</div>
	<div class="span-19">
		<div id="content">
			<?php echo $content; ?>
		</div><!-- content -->
	</div>
<!--</div>-->
<!--</div>-->
<?php $this->endContent(); ?>
