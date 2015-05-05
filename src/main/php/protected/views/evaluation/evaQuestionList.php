<?php
/**
 * Created by PhpStorm.
 * User: james
 * Date: 5/5/15
 * Time: 2:36 PM
 */
?>
<script type="text/javascript">
	$(document).ready(function() {
		$(".rb:even").each(function(){
			$(this).addClass('even');
		});
		$(".rb:odd").each(function(){
			$(this).addClass('odd');
		});
	});
</script>
<div class="form">
<?= $form->render(); ?>

</div>
