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
		$('html, body').animate({ scrollTop: $('#DForm input[type="radio"]:checked').offset().top }, 500);
		$('input[type="radio"]:checked', '#DForm').parent().css('border', '5px #FA9D00 solid');
	});
</script>
<div class="form">
<?= $form->render(); ?>

</div>
