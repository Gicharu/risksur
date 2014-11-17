<h4><?php echo $this->title; ?></h4>
<script type="text/javascript">
showComponentMenu = function(parentId) {
	//var dashId = $("#originalDashboardName").val();
	if(parentId !='') {
		//$("#manageDashProcess").show();
	var opt = {'loadMsg': '<?php echo Yii::t("translation", "Processing delete dashboard") ?>'};
		//$("#componentMenuWrapper").showLoading(opt);
		$.ajax({type: 'GET',
	url: <?php echo "'" . Yii::app()->controller->createUrl('design/getComponentMenu') . "'"; ?>,
		data: { parentId:parentId },
		success: function(data) {
			//console.log('Dashboard successful deleted');
			//$("#componentMenuWrapper").hideLoading();
			//console.log(data);
			$("#componentMenuWrapper").html("<div class='goalMenuComponent'>" + data + "<div>");
			$("#<?php echo $this->menuId; ?>").buttonset();

			//updateDashboardDropdown();
			//} else {
			//// add process failure message
			//$("#componentMenuWrapper").prepend('<script>$(".flash-error").animate({opacity: 1.0}, 5000).fadeOut("slow");<\/script>'
			//+ '<div class="flash-error">' + data + '</div>');
			//}
			//$("#manageDashProcess").hide();
		},
		error:function() {
			//$("#componentMenuWrapper").hideLoading();
		//var failDeleteDashboard = '<?php echo Yii::t("translation", "Failed to delete dashboard") ?>'
			//alert(failDeleteDashboard);
			console.log("error occured here");
		},
		dataType: "text"
	});
	}
}
</script>
<?php
	echo CHtml::radioButtonList($this->menuId, '', $goalParams['goalArray'], array(
		'id' => $this->menuId,
		'class' => 'buttonListMenu',
		'onclick' => 'showComponentMenu($(this).val());'
		//'separator' => ' ',
		//'template' => '<div>{input}&nbsp; {label}</div>',
		//'labelOptions' => array('style' => 'display:inline'),
		//'checkAll' => '(SELECT ALL)'
		//'options' => array()
		));

?>
