<?php
/**
 * Created by PhpStorm.
 * User: james
 * Date: 5/12/15
 * Time: 10:33 AM
 */
$this->menu = array(array('label' => 'Add Economic Evaluation Method', 'url' => array('admin/addEvaMethod')), );
?>

<script type="text/javascript">
	var evaMethods;
	var requestHandler = function(event) {
		var aPos;
		/* Get current  row pos */
		if(typeof event.data.parent !== 'undefined') {
			aPos = evaMethods.fnGetPosition(event.target);
		} else {
			aPos = evaMethods.fnGetPosition($(event.target).parent()[0]);
		}
//		console.log(aPos);
		var aData = evaMethods.fnGetData(aPos[0]); /* Get the full row     */
		//console.log(aData);
		var evaMethodId = aData['id'];
		var name = aData['buttonName'];
		switch(event.data.action) {
			case "edit":
				window.location.href = '<?php echo $this->createUrl("updateEvaMethod"); ?>' +
				"/id/" + evaMethodId;
				break;
			case 'delete':
				deleteConfirm(name, evaMethodId);
				break;
			default:
				break;
		}

	};
	var deleteConfirm = function(confirmMsg, deleteVal) {
		$('body #deleteBox')
			.html("<p>Are you sure you want to delete '" + confirmMsg + "' </p>")
			.dialog('option', 'buttons', {
				"Confirm" : function() {
					// console.log(confirmMsg + ":" + deleteVal);
					$(this).dialog("close");
					var opt = {'loadMsg': 'Deleting economic evaluation method...'};
					$("#listEvaMethods").showLoading(opt);
					$.ajax({
						type: 'GET',
						url: '<?= $this->createUrl("admin/deleteEvaMethod") ?>',
						data: {evaMethodId:deleteVal},
						success: function(data){
							var checkSuccess = /successfully/i;
							if (checkSuccess.test(data)) {
								// add process message
								$("#ajaxFlashMsg").html('');
								$("#ajaxFlashMsg").html(data);
								$("#ajaxFlashMsgWrapper")
									.attr('class', 'flash-success')
									.show()
									.animate({opacity: 1.0}, 3000).fadeOut("slow");
							} else {
								// add process message
								$("#ajaxFlashMsg").html(data);
								$("#ajaxFlashMsgWrapper").attr('class', 'flash-error').show();
							}
							evaMethods.fnReloadAjax('<?= $this->createUrl("admin/listEvaMethods/ajax/1"); ?>');
							$("#listEvaMethods").hideLoading();
						},
						error: function(data){
							$("#ajaxFlashMsg").html("Error occurred while deleting data");
							$("#ajaxFlashMsgWrapper").attr('class', 'flash-error').show();
							//console.log("error occured while posting data" + data);
							$("#listSurveilance").hideLoading();
						},
						dataType: "text"
					});
				},
				"Cancel" : function() {
					$(this).dialog("close");
				}
			});
		$("#deleteBox").dialog("open");
	};
	$(function() {
		evaMethods = $("#evaMethods").dataTable({
			"sDom": '<"H"rlf>t<"F"ip>',
			"sAjaxSource": "<?= $this->createUrl('admin/listEvaMethods/ajax/1'); ?>",
			"aoColumns": [
				{"mDataProp": "buttonName" },
				{"mDataProp": "link" },
				{"mDataProp": "description" },
				{"mDataProp": null, "bSortable": false, sClass: "editMethod", sDefaultContent: '<button title="Edit" class="bedit">Edit</button>' },
				{"mData": null, "bSortable": false, sClass: "delMethod", sDefaultContent: '<button title="Delete" class="bdelete">Delete</button>' }
			],
			// update the buttons stying after the table data is loaded
			"fnDrawCallback": function() {
				$('button.bdelete').button({
					icons: {primary: "ui-icon-trash"}, text: false});
				$('button.bedit').button({
					icons: {primary: "ui-icon-pencil"}, text: false});
			},
			"bJQueryUI": true,
			//"sPaginationType": "customListbox",
			"sPaginationType": "buttons_input",
			"iDisplayLength": 10,
			"aLengthMenu": [[10, 25, 50, 75, 100], [10, 25, 50, 75, 100]],
			"bFilter": true,
			"bSort": true,
			"bInfo": true,
			"bLengthChange": true
		}).on('click', '.editMethod .bedit', { action: 'edit' }, requestHandler)
			.on('click', '.delMethod', { action: 'delete' }, requestHandler);

	});
</script>
<div id="listEvaMethods" width="100%">

	<table id="evaMethods" width="100%" class="display">
		<thead>
		<tr>
			<th title = "Label">Button Label</th>
			<th title = "Link">Method link</th>
			<th title = "Descripton">Descripton</th>
			<th title = "Edit"></th>
			<th title = "Delete"></th>
		</tr>
		</thead>
		<tbody>
		</tbody>
	</table>
</div>