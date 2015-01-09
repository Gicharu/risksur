<h3><?php echo $dataArray['formType']; ?> Component for <?php echo Yii::app()->session['surDesign']['name'];?></h3>
<div class="form">
<script type="text/javascript">
	$(document).ready(function() {
		$("#moreInfoDialog").dialog({
			autoOpen: false,
			width: 900,
			height: 400,
			show: "slide",
			hide: "clip",
			modal: true,
			buttons: {
				<?php echo _("Close");?>: function() {
					$(this).dialog("close");
				}
			}
		});
	});
</script>
<div id="moreInfoDialog" title="More Information">Very Much Information</div>
<?php
	echo $form->render();
?>
</div>
