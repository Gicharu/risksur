<h3><?php echo $dataArray['formType']; ?> Goal</h3>
<?php
if ($dataArray['formType'] == "Create") {
	$this->menu = array(array('label' => 'View Goals', 'url' => array('admin/listGoals')));
} else {
	$this->menu = array(array('label' => 'Create Goal', 'url' => array('admin/addGoal')), array('label' => 'View Goals', 'url' => array('admin/listGoals')));
}
?>
<script type="text/javascript">
	$(function() {
		$("#bd").attr('style', '');
	});
</script>
<div class="form">
<?php 
echo $form->render();
?>
</div>
