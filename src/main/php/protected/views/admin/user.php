<?php
$this->breadcrumbs = array(
	'Manage TIX Users',
);
//echo Yii::app()->getBaseUrl(true);

?>	
	<div class="pageHeader"> User List</div><div><?php echo CHtml::htmlButton('Add New User', array(
		'submit' => array(
			'admin/add/'
		),
		'class' => 'btnAddUser',
		'type' => 'button'
	)); ?></div>

<table id="dataTable" width="100%" border="0" cellspacing="0" cellpadding="0">
<thead>
	<tr>
		<th>Organization</th>
		<th>Username</th>
		<th class="btnEditHead" width="10%">Edit </th>
		<th class="btnEditHead" width="10%"> Delete </th>
		<th class="btnEditHead" width="10%"> Send</th>
	</tr>
</thead>

<tbody>
<?php //print_r($credentials);
?>
<?php foreach ($credentials as $credents) { ?>
<tr>
	<td><?php echo $credents['Organization']; ?></td>
	<td><?php echo $credents['givenName']; ?></td>
	<td class="btnEdit">
<?php echo CHtml::htmlButton('Edit', array(
	'onClick' => "$('#editId').attr('value', '" . $credents['givenName'] . "');$('form#editPages').submit();",
	'class' => 'bedit',
	'type' => 'button'
)); ?>
		</td>
			<td class="btnDelete"><?php echo CHtml::htmlButton('Delete', array(
				'onClick' => "$('#delPageId').attr('value', '" . $credents['dn'] . "');" + 
						"$('#deleteBox').dialog('open'); deleteConfirm('deletePages','" . $credents['givenName'] . "')",
				'class' => 'bdelete',
				'type' => 'button'
			)); ?>

		</td>
			<td class="btnSend"><?php echo CHtml::htmlButton('Send', array(
				'onClick' => "$('#sendId').attr('value', '" . $credents['givenName'] . "'); " +  
					"$('#sendBox').dialog('open'); sendConfirm('sendPass','" . $credents['givenName'] . "')",
				'class' => 'bsend',
				'type' => 'button'
			)); ?>
	</td>

</tr>
<?php
}
?>
</tbody>
</table>
	<form name="deletePages" action="delete" method="post" id="deletePages">
		<input type="hidden" name="delPageId" id="delPageId"/>
		<input type="hidden" name="delRow" id="delRow" value="1"/>
	</form>
	<form name="editPages" action="edit" method="post" id="editPages">
		<input type="hidden" name="editId" id="editId"/>
		<input type="hidden" name="editRow" id="editRow" value="1"/>
	</form>
	<form name="sendPass" action="send" method="post" id="sendPass">
		<input type="hidden" name="sendId" id="sendId"/>
	</form> 

