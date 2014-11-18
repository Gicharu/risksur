<h3><?php echo $dataArray['formType']; ?> Goal</h3>
<?php
$this->menu = array(array('label' => 'Create Goal', 'url' => array('admin/addGoal')),);
$this->menu = array(array('label' => 'View Goal', 'url' => array('admin/listGoals')),);
?>
<div class="form">
<?php 
echo $form->render();
?>
</div>
