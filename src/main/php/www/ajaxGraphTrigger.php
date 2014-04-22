<script type="text/javascript">
var minMax;
$(function() {
	(function(window, undefined){
		// Bind to StateChange Event
		History.Adapter.bind(window,'statechange',function(){ // Note: We are using statechange instead of popstate
		var State = History.getState(); // Note: We are using History.getState() 1instead of event.state
		var stateData = State.data;
		var currentIndex = History.getCurrentIndex();
		var internal = (History.getState().data._index == (currentIndex - 1));
		if (!internal) {
			$("#<?php echo $widgetId; ?>").showLoading();
			$.ajax({
			url: <?php echo "'" . CController::createUrl('dashboard/ajaxGraphRefresh') . "'"; ?>,
			data:State.data.params,
			type:"POST",
			dataType:"html",
			success:function(response) {
				$('#<?php echo $graphDivWrapperId . $widgetId; ?>').html(response);
				$("#<?php echo $widgetId; ?>").hideLoading();
			},
			error:function() {
				$("#<?php echo $widgetId; ?>").hideLoading();
				//alert('Failed request data from ajax page');
			}
			});
		}

	});

	})(window);

	refreshLocalGraph<?php echo $widgetId; ?> = function(obj, typeOfGraph, historyTrue) {
		//console.log("hostoryValue" + historyTrue);
		if (typeof historyTrue == 'undefined') {
			// console.log("undefined here");
			var focusHref = $(obj).attr('focusChange');
			//if (typeof $(obj).attr('data-epc') !== 'undefined') {
			var focusId = $(obj).attr('data-epc');
			widgetIdValue = "<?php echo $widgetId; ?>";
			var widgetWidth = $("#" + widgetIdValue).width();
			widgetWidth = Math.round(widgetWidth - <?php echo Yii::app()->params->other['graphWidthOffset']; ?>);
			// assign the widgetWidth value to the data paramaters
			// dataParam.graphWidth = widgetWidth;
			//} else {
			//var focusId = "GAN";
			//}
			
			var focusIdNode = $(obj).attr('data-node');
			var areaId = $(obj).attr('id');
			var dataParam = {widgetId:"<?php echo $widgetId; ?>", epcId:epcValId<?php echo $widgetId; ?>, 
			focusEpc: focusId, focusUrl: focusHref, 
			graphType: typeOfGraph, areaId: areaId, focusNode: focusIdNode, graphWidth: widgetWidth  };
			History.pushState({_index: History.getCurrentIndex(), params: dataParam}, "Story - Dashboard");
		} else {
			//console.log("history refresh graph");
			dataParam = obj;
			widgetIdValue = obj.widgetId;
		}
		var originalOrigin = $(obj).attr('data-origin');
		// console.log(originalOrigin);
		dataParam.originalOrigin = originalOrigin;
		$("#" + widgetIdValue).showLoading();
		//get the width of the widget and less 40 for padding and margins
		var widgetWidth = $("#" + widgetIdValue).width();
		widgetWidth = Math.round(widgetWidth - <?php echo Yii::app()->params->other['graphWidthOffset']; ?>);
		// assign the widgetWidth value to the data paramaters
		dataParam.graphWidth = widgetWidth;
		// console.log('local graph '+widgetWidth);

			
		$.ajax({
			url: <?php echo "'" . CController::createUrl('dashboard/ajaxGraphRefresh') . "'"; ?>,
			data: dataParam,
			type:"POST",
			dataType:"html",
			success:function(response) {
				$('#<?php echo $graphDivWrapperId; ?>' + widgetIdValue).html(response);
				$("#" + widgetIdValue).hideLoading();
			},
			error:function() {
			$("#" + widgetIdValue).hideLoading();
				//alert('Failed request data from ajax page');
			}
		});
	}
	// change focus of local graph
	$('#<?php echo $graphDivWrapperId . $widgetId; ?>').on('click', 'map[name="imagemap-<?php echo $widgetId . "local"; ?>"] area', function(e) {
		refreshLocalGraph<?php echo $widgetId; ?>(this, "local");
	});
	// change focus of batch graph
	$('#<?php echo $graphDivWrapperId . $widgetId; ?>').on('click', 'map[name="imagemap-<?php echo $widgetId . "batch"; ?>"] area', function(e) {
		// console.log($('#originalOrigin<?php echo $widgetId; ?>').val());
		// $(this).attr('data-origin', $('#originalOrigin<?php echo $widgetId; ?>').val());
		refreshLocalGraph<?php echo $widgetId; ?>(this, "batch");
	});

	changeFocusTd<?php echo $widgetId; ?> = function(origin, focus, typeOfGraph, focusNode, originalOrigin) {
		//var focusHref = $(obj).attr('focusChange');
		//var focusId = $(obj).attr('data-localid');
		//var locId = $(obj).attr('data-localid');
		var focusNodeDefault = $(this).attr("data-node");
		var changeType = 'origin';
		//setting default values for the parameters causes errors on chrome :P
		// console.log(focusNode.length);
		focusNode = typeof focusNode !== 'undefined' ? focusNode : "<?php echo Yii::app()->session['selectedNodeId']; ?>";
		// focusNode = focusNode.length === 0 ? "<?php echo Yii::app()->session['selectedNodeId']; ?>" : focusNode;
		// console.log(focusNode);
		// highlight = typeof highlight !== 'undefined' ? highlight : false;
			if (focusNode.length !== 0 && focusNode != "<?php echo Yii::app()->session['selectedNodeId']; ?>") {
				focus ="TradeUnitId[ID=" +  focus  + ", global=yes, gan=" + focusNode + "]";
				changeType = 'focus';
			}
			if(coloring = 'true') {
				changeType = 'origin';
			}
			// if(highlight == undefined) {
			// 	highlight = false;
			// }
			// console.log(highlight);
			$("#<?php echo $widgetId; ?>").showLoading();
			//get the width of the widget and less 40 for padding and margins
			var widgetWidth = $("#<?php echo $widgetId; ?>").width();
			//var widgetData = dashboard.getWidget("<?php //echo $widgetId; ?>");
			widgetWidth = Math.round(widgetWidth - <?php echo Yii::app()->params->other['graphWidthOffset']; ?>);
			//console.log('change focus '+widgetWidth);
			// remove the graph image, because of getting out of screen when widget set to un maximized mode
			$('#graphContainer<?php echo $widgetId; ?>local').empty();
			$('#graphContainer<?php echo $widgetId; ?>batch').empty();

			var paramObj = {widgetId:"<?php echo $widgetId; ?>",
			epcId:origin, focusEpc: focus, graphType: typeOfGraph, graphWidth: widgetWidth, focusNode: focusNode  };
			History.pushState({_index: History.getCurrentIndex(), params: paramObj}, "Story - Dashboard");
			orginalOrigin = typeof(originalOrigin) === 'undefined' ? '' : originalOrigin;
			
		$.ajax({
			url: <?php echo "'" . CController::createUrl('dashboard/ajaxGraphRefresh') . "'"; ?>,
			data:{ 
				widgetId:"<?php echo $widgetId; ?>", 
				epcId:origin, focusEpc: focus, 
				graphType: typeOfGraph, 
				graphWidth: widgetWidth, 
				focusNode: focusNode, 
				originalOrigin: originalOrigin,
				changeType: changeType 
			},
			type:"POST",
			dataType:"html",
			success:function(response) {
				$('#<?php echo $graphDivWrapperId . $widgetId; ?>').html(response);
				$("#<?php echo $widgetId; ?>").hideLoading();
			},
			error:function() {
			$("#<?php echo $widgetId; ?>").hideLoading();
				//alert('Failed request data from ajax page');
			}
		});
	}
	// change focus local graph from transformations
	$('td.<?php echo "changeFocus" .  $widgetId; ?>').die('click').live('click', function(e) {
		//console.log(this);
		//console.log($(this).text());
		var tdEpc = $(this).text(); //.replace(/ /g,"+");
		var graphType = $(this).attr("graphType");
		var graphOrigin = $(this).attr("graphOrigin");
		var focusNode = $(this).attr("data-node");
		//console.log("change focus:" + focusNode);
		var widget = dashboard.getWidget("<?php echo $widgetId; ?>");
		if (tdEpc != "") {
		// move the focus to the top of the widget
		var position = $("#<?php echo $widgetId; ?>").position();
		scroll(0,position.top);
			//var areaObj = $('map[name="imagemap-<?php echo $widgetId;?>' + graphType + '"] area[data-localid="' + tdEpc +'"]');
		//console.log(areaObj);
		changeFocusTd<?php echo $widgetId; ?>(graphOrigin, tdEpc , graphType, focusNode);
		}
	});

	changeOriginGraph<?php echo $widgetId; ?> = function(graphTypeVal, newOrigin, focusNode, highlight, originalOrigin){
		//var focusHref = $(this).attr('focusChange');
		//var focusId = $(this).attr('data-localid');
		//setting default values for the parameters causes errors on chrome :P
		var focusNodeDefault = $(this).attr("data-node");
		focusNode = typeof focusNode !== 'undefined' ? focusNode : focusNodeDefault;
		highlight = typeof highlight !== 'undefined' ? highlight : false;
		originalOrigin = typeof(originalOrigin) === 'undefined' ? '' : originalOrigin;
		orginalOrigin = $(this).attr('data-origin');
		// console.log(originalOrigin + '---->' + highlight);
		var widget = dashboard.getWidget("<?php echo $widgetId; ?>");

		$("#<?php echo $widgetId; ?>").showLoading();
		//get the width of the widget and less 40 for padding and margins
		var widgetWidth = $("#<?php echo $widgetId; ?>").width();
		widgetWidth = Math.round(widgetWidth - <?php echo Yii::app()->params->other['graphWidthOffset']; ?>);
		//console.log('change origin '+widgetWidth);
		var paramObj = {widgetId:"<?php echo $widgetId; ?>", epcId: newOrigin, graphType: graphTypeVal, graphWidth: widgetWidth };
		History.pushState({_index: History.getCurrentIndex(), params: paramObj}, "Story - Dashboard");
		$.ajax({
			url: <?php echo "'" . CController::createUrl('dashboard/ajaxGraphRefresh') . "'"; ?>,
			data:{widgetId:"<?php echo $widgetId; ?>", 
				epcId: newOrigin, 
				graphType: graphTypeVal, 
				graphWidth: widgetWidth,
				focusNode: focusNode, 
				highlight: highlight, 
				originalOrigin: originalOrigin
			},
			type:"POST",
			dataType:"html",
			success:function(response){
				$('#<?php echo $graphDivWrapperId . $widgetId; ?>').html(response);
				$("#<?php echo $widgetId; ?>").hideLoading();
			},
			error:function(){
				$("#<?php echo $widgetId; ?>").hideLoading();
				//alert('Failed request data from ajax page');
			}
		});
	};
	
});
</script>
