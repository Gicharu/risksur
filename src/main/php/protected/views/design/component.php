<?php
/**
 * @var CForm $form
 */
?>
<script type="text/javascript">
	$(document).ready(function() {
		$('[title!=""]').qtip({
			content: {
				title: 'Info'
			},
			style: {
				widget: true,
				def: false
			}
		});
	});
</script>
<h3><?php echo $dataArray['formType']; ?> Component for <?php echo Yii::app()->session['surDesign']['name'];?></h3>
<div class="form">
<?= $form; ?>
</div>
