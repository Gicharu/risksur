$(function() {

	// update the button to jquery button themes
    $('button, a.btn').button();
    $('input:button').button();
    $('input:submit').button();

    $('button.btoogler').button({
        icons: { primary: "ui-icon-arrowthickstop-1-n" }, text: false});
    $('button.breport').button({
        icons: { primary: "ui-icon-document" }, text: false});
    $('button.bedit').button({
        icons: { primary: "ui-icon-pencil" }, text: false});
    $('button.bdelete, a.bdelete').button({
        icons: { primary: "ui-icon-trash" }, text: false});
    $('button.binfo').button({
        icons: { primary: "ui-icon-info" }, text: false});
    $('button.bsend').button({
        icons: { primary: "ui-icon-mail-closed" }, text: false});
    $('button.bConfirm').button({
        icons: { primary: "btnUnconfirm" }, text: false});
    


    $('.dataTable-simple').dataTable({
        "bJQueryUI": true,
        "bFilter":false,
        "bInfo":false,
        "bPaginate":false,
        "bSort": false,
        "sPaginationType": "full_numbers"});

    $('.dataTable-add').dataTable({
        "bJQueryUI": true,
        "bInfo":false,
        "bPaginate":false,
        "sPaginationType": "full_numbers"});

    // jquery dialog delete confirmation

    $('#deleteBox').dialog({ 
        autoOpen: false,
        bgiframe: true,

        modal: true,
        resizable: false,
        overlay: {
            backgroundColor: '#000',
        opacity: 0.5
        }
    });

    //jquery dialog send confirmation
    $('#sendBox').dialog({ 
        autoOpen: false,
        bgiframe: true,

        modal: true,
        resizable: false,
        overlay: {
            backgroundColor: '#000',
        opacity: 0.5
        }
    });

	/*$('#copyBox').dialog({ */
	/*autoOpen: false,*/
	/*bgiframe: true,*/

	/*modal: true,*/
	/*resizable: true,*/
	/*overlay: {*/
	/*backgroundColor: '#000',*/
	/*opacity: 0.5*/
	/*}*/
	/*});*/

	$( "#btnAdminVerify" ).button({
		icons: {
			primary: "ui-icon-check"
		},
		text:false
	});

	$( "#btnUserPreferences" ).button({
		icons: {
			primary: "ui-icon-person"
		},
		text:false
	});

	$( "#btnChangeDashboard" ).button({
		icons: {
			primary: "ui-icon-note"
		},
		text:false
	});

	$( "#btnHelp" ).button({
		icons: {
			primary: "ui-icon-help"
		},
		text:false
	});

	$( "#btnUpgradeConfig" ).button({
		icons: {
		    primary: "ui-icon-arrowreturnthick-1-n"
		},
		text:false
	});

	$('#btnConfig').button({
		icons: { 
			primary: "ui-icon-wrench"
		},
		text: false
	});


	$("#closeButtonAjax").click(function(){
		$("#ajaxFlashMsgWrapper").hide();
	});

	$("#closeButtonFlash").click(function(){
		$("#flashMsgWrapper").hide();
	});



});
// function to return a timestamp to be used as part of the filename for csv files
function getTitle() {
	var d = new Date();
	var fileName = d.getFullYear() + "-" + (1+d.getMonth()) + "-" + d.getDate();
	fileName += "_" + d.getHours() + "-" + d.getMinutes() + "-" + d.getSeconds();
	return fileName;
}
// datatables reload ajax function plugin
$.fn.dataTableExt.oApi.fnReloadAjax = function ( oSettings, sNewSource, fnCallback, bStandingRedraw )
{
    if ( typeof sNewSource != 'undefined' && sNewSource != null ) {
        oSettings.sAjaxSource = sNewSource;
    }
 
    // Server-side processing should just call fnDraw
    if ( oSettings.oFeatures.bServerSide ) {
        this.fnDraw();
        return;
    }
 
    this.oApi._fnProcessingDisplay( oSettings, true );
    var that = this;
    var iStart = oSettings._iDisplayStart;
    var aData = [];
  
    this.oApi._fnServerParams( oSettings, aData );
      
    oSettings.fnServerData.call( oSettings.oInstance, oSettings.sAjaxSource, aData, function(json) {
        /* Clear the old information from the table */
        that.oApi._fnClearTable( oSettings );
          
        /* Got the data - add it to the table */
        var aData =  (oSettings.sAjaxDataProp !== "") ?
            that.oApi._fnGetObjectDataFn( oSettings.sAjaxDataProp )( json ) : json;
          
        for ( var i=0 ; i<aData.length ; i++ )
        {
            that.oApi._fnAddData( oSettings, aData[i] );
        }
          
        oSettings.aiDisplay = oSettings.aiDisplayMaster.slice();
          
        if ( typeof bStandingRedraw != 'undefined' && bStandingRedraw === true )
        {
            oSettings._iDisplayStart = iStart;
            that.fnDraw( false );
        }
        else
        {
            that.fnDraw();
        }
          
        that.oApi._fnProcessingDisplay( oSettings, false );
          
        /* Callback user function - for event handlers etc */
        if ( typeof fnCallback == 'function' && fnCallback != null )
        {
            fnCallback( oSettings );
        }
    }, oSettings );
};


// datatables piping functions
var oCache = {
	iCacheLower: -1
};

function fnSetKey( aoData, sKey, mValue )
{
	for ( var i=0, iLen=aoData.length ; i<iLen ; i++ )
	{
		if ( aoData[i].name == sKey )
		{
			aoData[i].value = mValue;
		}
	}
}

function fnGetKey( aoData, sKey )
{
	for ( var i=0, iLen=aoData.length ; i<iLen ; i++ )
	{
		if ( aoData[i].name == sKey )
		{
			return aoData[i].value;
		}
	}
	return null;
}

function fnDataTablesPipeline ( sSource, aoData, fnCallback ) {
	var iPipe = 5; /* Ajust the pipe size */
	
	var bNeedServer = false;
	var sEcho = fnGetKey(aoData, "sEcho");
	var iRequestStart = fnGetKey(aoData, "iDisplayStart");
	var iRequestLength = fnGetKey(aoData, "iDisplayLength");
	var iRequestEnd = iRequestStart + iRequestLength;
	oCache.iDisplayStart = iRequestStart;
	
	/* outside pipeline? */
	if ( oCache.iCacheLower < 0 || iRequestStart < oCache.iCacheLower || iRequestEnd > oCache.iCacheUpper )
	{
		bNeedServer = true;
	}
	
	/* sorting etc changed? */
	if ( oCache.lastRequest && !bNeedServer )
	{
		for( var i=0, iLen=aoData.length ; i<iLen ; i++ )
		{
			if ( aoData[i].name != "iDisplayStart" && aoData[i].name != "iDisplayLength" && aoData[i].name != "sEcho" )
			{
				if ( aoData[i].value != oCache.lastRequest[i].value )
				{
					bNeedServer = true;
					break;
				}
			}
		}
	}
	
	/* Store the request for checking next time around */
	oCache.lastRequest = aoData.slice();
	
	if ( bNeedServer )
	{
		if ( iRequestStart < oCache.iCacheLower )
		{
			iRequestStart = iRequestStart - (iRequestLength*(iPipe-1));
			if ( iRequestStart < 0 )
			{
				iRequestStart = 0;
			}
		}
		
		oCache.iCacheLower = iRequestStart;
		oCache.iCacheUpper = iRequestStart + (iRequestLength * iPipe);
		oCache.iDisplayLength = fnGetKey( aoData, "iDisplayLength" );
		fnSetKey( aoData, "iDisplayStart", iRequestStart );
		fnSetKey( aoData, "iDisplayLength", iRequestLength*iPipe );
		
		$.getJSON( sSource, aoData, function (json) { 
			/* Callback processing */
			oCache.lastJson = jQuery.extend(true, {}, json);
			
			if ( oCache.iCacheLower != oCache.iDisplayStart )
			{
				json.aaData.splice( 0, oCache.iDisplayStart-oCache.iCacheLower );
			}
			json.aaData.splice( oCache.iDisplayLength, json.aaData.length );
			
			fnCallback(json)
		} );
	}
	else
	{
		json = jQuery.extend(true, {}, oCache.lastJson);
		json.sEcho = sEcho; /* Update the echo for each response */
		json.aaData.splice( 0, iRequestStart-oCache.iCacheLower );
		json.aaData.splice( iRequestLength, json.aaData.length );
		fnCallback(json);
		return;
	}
}
// function to recalculate column sizes of DT instances living in tabs
function calibrateColWidth() {
				
	var table = $.fn.dataTable.fnTables(true); // true = visible tables only
	if ( table.length > 0 ) {
		$(table).dataTable().fnAdjustColumnSizing(false); // fixes all tables
	}

	var ttInstances = TableTools.fnGetMasters(); // Buttons needs resizing too
	for (i in ttInstances) {
		if (ttInstances[i].fnResizeRequired()) ttInstances[i].fnResizeButtons();
	}
}
jQuery.fn.dataTableExt.aTypes.unshift(
    function ( sData )
    {
		//autopick sType to sort with date-euro if format is "dd-mm-YYYY hh:ii:ss"
        if (sData !== null && sData.match(/([0-2][0-9]|3[0-1])\-(0[1-9]|1[0-2])\-[0-9]{4}( ([0-1][0-9]|2[0-3])(:[0-5][0-9]){2})?/))
        {
            return 'date-euro';
        }
		//autopick sType to sort with date-us if format is "mm/dd/YYYY hh:ii:ss"
        if (sData !== null && sData.match(/(0[1-9]|1[0-2])\/([0-2][0-9]|3[0-1])\/[0-9]{4}( ([0-1][0-9]|2[0-3])(:[0-5][0-9]){2})?/))
        {
            return 'date-us';
        }
        return null;
    }
);

// datatable date sorting for format "dd-mm-YYYY hh:ii:ss"  
jQuery.extend( jQuery.fn.dataTableExt.oSort, {
    "date-euro-pre": function ( a ) {
        if ($.trim(a) != '') {
            var frDatea = $.trim(a).split(' ');
            var frTimea = frDatea[1].split(':');
            var frDatea2 = frDatea[0].split('-');
            var x = (frDatea2[2] + frDatea2[1] + frDatea2[0] + frTimea[0] + frTimea[1]) * 1;
        } else {
            var x = 10000000000000; // = l'an 1000 ...
        }
         
        return x;
    },
 
    "date-euro-asc": function ( a, b ) {
        return a - b;
    },
 
    "date-euro-desc": function ( a, b ) {
        return b - a;
    }
} );

// datatable date sorting for format "mm/dd/YYYY hh:ii:ss"  
jQuery.extend( jQuery.fn.dataTableExt.oSort, {
    "date-us-pre": function ( a ) {
        if ($.trim(a) != '') {
            var frDatea = $.trim(a).split(' ');
            var frTimea = frDatea[1].split(':');
            var frDatea2 = frDatea[0].split('/');
            var x = (frDatea2[2] + frDatea2[0] + frDatea2[1] + frTimea[0] + frTimea[1]) * 1;
        } else {
            var x = 10000000000000; // = l'an 1000 ...
        }
         
        return x;
    },
 
    "date-us-asc": function ( a, b ) {
        return a - b;
    },
 
    "date-us-desc": function ( a, b ) {
        return b - a;
    }
} );


// data tables filter on return 
// to use it example: $('.dataTable').dataTable().fnFilterOnReturn();
jQuery.fn.dataTableExt.oApi.fnFilterOnReturn = function (oSettings) {
    var _that = this;
  
    this.each(function (i) {
        $.fn.dataTableExt.iApiIndex = i;
        var $this = this;
		/* this code block below is interefing with search function, commented out until further notice */
		/*var anControl = $('input', _that.fnSettings().aanFeatures.f);*/
		// fixed the interfering code with this line below
        var anControl = $(oSettings.nTableWrapper).find('div.dataTables_filter input');
        anControl.unbind('keyup').bind('keypress', function (e) {
		//alert(anControl.val());
		//console.log(_that.fnSettings().aanFeatures.f);
            if (e.which == 13) {
                $.fn.dataTableExt.iApiIndex = i;
                _that.fnFilter(anControl.val());
            }
        });
        return this;
    });
    return this;
};

// cancel datatable search filters
if ( typeof $.fn.dataTable == "function" && typeof $.fn.dataTableExt.fnVersionCheck == "function" && $.fn.dataTableExt.fnVersionCheck('1.9.2')/*older versions should work too*/ )
{
    $.fn.dataTableExt.oApi.clearSearch = function ( oSettings )
    {
 
        var table = this;
         
        //any browser, must include your own file
        //var clearSearch = $('<img src="/images/delete.png" style="vertical-align:text-bottom;cursor:pointer;" alt="Delete" title="Delete"/>');
         
        //no image file needed, css embedding must be supported by browser
        var clearSearch = $('<img title="Clear Search" alt="Clear" src="data:image/png;base64, iVBORw0KGgoAAAANSUhEUgAAABIAAAASCAYAAABWzo5XAAABUElEQVR4Xu2Tz0v6YBzHnboW7lkONzelUrb+gaJDLOjP0EPdpjjacEpZxw4G0a1DIEJ00kP3gi79B3bramGXxH4txfHdvsKeZuDtGTPoVm/4XF7Pw5sPr4cHgxAGfiJBd35bUTabDfkw/yJNV6/SwsJtLpeTJkxV1VVBXGwVS9uXUxcRxEyMZdnl+VSyUdAK64qirHEJ9oLj+RWCmGVQRWEU/OgPKpEI2YizzBKO440ghgVomhZfX94e3s1+BekCQogcRZGl6uFBu1Y/hWfndXh0XG27m0le98Ne8kbu2P9HYcMwvoBlWbjjONi3ZI8lJ7h4kwIgbf2zHm3b7gBApfgk1xyfIYtQTxxjozVAAnFgDjtPz72tXre7OTTNe4oihSgzdzKVIzeYXtJudvfLd/l8fmPCZVmWdvbKraKuXiMcecvOZDIhFHeDofjf7/fPJwL821wu37TMAAAAAElFTkSuQmCC" style="vertical-align:text-bottom;cursor:pointer;" />');
        $(clearSearch).click( function ()
                {
                      table.fnFilter('');
                });
        $(oSettings.nTableWrapper).find('div.dataTables_filter').append(clearSearch);
        $(oSettings.nTableWrapper).find('div.dataTables_filter label').css('margin-right', '-16px');//16px the image width
        $(oSettings.nTableWrapper).find('div.dataTables_filter input').css('padding-right', '16px');
    }
 
    //auto-execute, no code needs to be added
    $.fn.dataTable.models.oSettings['aoInitComplete'].push( {
        "fn": $.fn.dataTableExt.oApi.clearSearch,
        "sName": 'whatever'
    } );
}
// This function clears the dataTables displayed on the graph section
clearDataTables = function(tableIds) {
    var tableToClear = {};
    var dtObj;
    $.each(tableIds, function(tKey, tVal) {
        //console.log(tVal);
        tableToClear = $(tVal).get(0);
        //console.log(tableToClear);
        if ( $.fn.DataTable.fnIsDataTable( tableToClear ) ) {
            //console.log("Remove!!!");
            dtObj = $(tableToClear).dataTable();
            dtObj.fnClearTable();

        }
    });

};
// This function clears graphs, maps and sets the width
clearAndSetWidth = function(width, widgetId, msg) {
    msg = typeof msg === 'undefined' ? 'graph' : msg;
    $('#graphImageWrapper' + widgetId + ', #mapContainer' + widgetId).html('<p>Loading ' + msg + '...</p>').css('background-image', 'none');
    $('#graphImageWrapper' + widgetId).css({
        width : width,
        height: "400"
    });
};
var requestHandler = function(event) {
    var table = $(event.data.table).dataTable();
    var aPos;
    /* Get current  row pos */
    //if(typeof event.data.parent !== 'undefined') {
    //    aPos = table.fnGetPosition(event.target);
    //} else {
    //    aPos = table.fnGetPosition($(event.target).parent()[0]);
    //}
    aPos = table.fnGetPosition($(event.target).closest('td')[0]);
    //console.log(event.data.link);
    //return false;
    /* Get the full row     */
    //console.log(aPos); return false;
    var aData = table.fnGetData(aPos[0]);
    var rowId = aData[event.data.rowIdentifier];
    switch(event.data.operation) {
        case "edit":
            window.location.href = event.data.link +
            "/id/" + rowId;
            break;
        case 'delete':
           //console.log(rowId, event.data.link, event.data.refreshLink, table);
            deleteConfirm(rowId, event.data.link, event.data.refreshLink, table);
            break;
        case 'view':
            window.location.href = event.data.link + '/id/' + rowId;
            break;
        default:
            break;
    }

};
var deleteConfirm = function(deleteVal, delLink, reloadLink, table) {
    //console.log(deleteVal, delLink, reloadLink, table);
    $('body #deleteBox')
        .html("<p>Are you sure you want to delete this item </p>")
        .dialog('option', 'buttons', {
            "Confirm" : function() {
                $(this).dialog("close");
                var opt = {'loadMsg': 'Deleting item...'};
                $("#operationInfo").showLoading(opt);
                $.ajax({
                    type: 'GET',
                    url: delLink,
                    data: {id:deleteVal},
                    dataType: "text",
                    success: function(data){
                        var checkSuccess = /successfully/i;
                        if (checkSuccess.test(data)) {
                            // add process message
                            //$("#ajaxFlashMsg").html('');
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
                        table.fnReloadAjax(reloadLink);
                        $("#operationInfo").hideLoading();
                    },
                    error: function(data){
                        $("#ajaxFlashMsg").html("Error occurred while deleting the item");
                        $("#ajaxFlashMsgWrapper").attr('class', 'flash-error').show();
                        //console.log("error occured while posting data" + data);
                        $("#operationInfo").hideLoading();
                    }
                });
            },
            "Cancel" : function() {
                $(this).dialog("close");
            }
        });
    $("#deleteBox").dialog("open");
};




