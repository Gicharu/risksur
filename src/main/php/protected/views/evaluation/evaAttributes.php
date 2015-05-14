<?php
/**
 * Created by PhpStorm.
 * User: james
 * Date: 5/13/15
 * Time: 12:41 PM
 */
?>
<script type="text/javascript">
	$(function() {
		$('#attrDesc').dialog({
			autoOpen: false,
			modal: true,
			width: 500,
			buttons: {
				Close: function() {
					$(this).dialog('close');
				}
			},
			show: {
				effect: "highlight",
				duration: 1000
			},
			hide: {
				effect: "explode",
				duration: 1000
			}
		});

		$('.attrib').button()
			.on('click', function() {
				//alert($(this).data('attributeid'));
				$.ajax({
					type: 'GET',
					url: '<?= $this->createUrl("evaluation/evaAttributes") ?>',
					data: { descId: $(this).data('attributeid') },
					dataType: "json",
					success: function(data){
						if(data.description == '') {
							this.error();
						}
						$('#attrDesc').html(data.description)
							.dialog('open');
					},
					error: function(data){
						$('#attrDesc').html('No description available')
							.dialog('open');
					}
				});
			});
	});
</script>
<div id="attrDesc" title="Evaluation attribute description"></div>
<div id="attributesContainer">
	<?php
	foreach($evaAttributes as $attrType => $attribs) {
		//print_r($attribs); die;
		echo '<div class="attrHead"><span class="header">' . $attrType . '</span>';
		foreach($attribs as $attrId => $attrName) {
			echo '<button class="attrib" data-attributeid="' . $attrId . '">' . $attrName . '</button>';
		}
		echo '</div>';
	}
	?>

</div>