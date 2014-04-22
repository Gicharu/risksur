
$.fn.dataTableExt.oPagination.customListbox = {
    /*
     * Function: oPagination.listbox.fnInit
     * Purpose:  Initalise dom elements required for pagination with listbox input
     * Returns:  -
     * Inputs:   object:oSettings - dataTables settings object
     *             node:nPaging - the DIV which contains this pagination control
     *             function:fnCallbackDraw - draw function which must be called on update
     */
    "fnInit": function (oSettings, nPaging, fnCallbackDraw) {
        var nInput = document.createElement('select');
        nInput.className = "pagination_select";
        var nPrevNext = document.createElement( 'span' );
        var nPage = document.createElement('span');
        var nOf = document.createElement('span');
        nOf.className = "paginate_of";
        nPage.className = "paginate_page";
        if (oSettings.sTableId !== '') {
            nPaging.setAttribute('id', oSettings.sTableId + '_paginate');
        }
        nInput.style.display = "inline";
        nPage.innerHTML = "&nbsp; Page ";

        if ( !oSettings.bJUI )
        {
        	nPrevious = document.createElement( 'div' );
        	nNext = document.createElement( 'div' );
        }
        else
        {
        	nPrevious = document.createElement( 'a' );
        	nNext = document.createElement( 'a' );

        	nNextInner = document.createElement('span');
        	nNextInner.className = oSettings.oClasses.sPageJUINext;
        	nNext.appendChild( nNextInner );

        	nPreviousInner = document.createElement('span');
        	nPreviousInner.className = oSettings.oClasses.sPageJUIPrev;
        	nPrevious.appendChild( nPreviousInner );
        }
        nPrevious.className = oSettings.oClasses.sPagePrevDisabled;
		nNext.className = oSettings.oClasses.sPageNextDisabled;

		nPrevious.title = oSettings.oLanguage.oPaginate.sPrevious;
		nNext.title = oSettings.oLanguage.oPaginate.sNext;

		nPaging.appendChild( nPrevious );
		nPaging.appendChild( nNext );
		
		$(nPrevious).bind( 'click.DT', function() {
		if ( oSettings.oApi._fnPageChange( oSettings, "previous" ) )
		{
			/* Only draw when the page has actually changed */
			fnCallbackDraw( oSettings );
		}
		} );

		$(nNext).bind( 'click.DT', function() {
		if ( oSettings.oApi._fnPageChange( oSettings, "next" ) )
		{
			fnCallbackDraw( oSettings );
		}
		} );

		/* Take the brutal approach to cancelling text selection */
		//$(nPrevious).bind( 'selectstart.DT', function () { return false; } );
		//$(nNext).bind( 'selectstart.DT', function () { return false; } );

		/* ID the first elements only */
		if ( oSettings.sTableId !== '' && typeof oSettings.aanFeatures.p == "undefined" )
		{
			nPaging.setAttribute( 'id', oSettings.sTableId+'_paginate' );
			nPrevious.setAttribute( 'id', oSettings.sTableId+'_previous' );
			nNext.setAttribute( 'id', oSettings.sTableId+'_next' );
		}

        nPaging.appendChild(nPage);
        nPaging.appendChild(nInput);
        nPaging.appendChild(nOf);
        nPaging.appendChild(nPrevNext);

        $(nInput).change(function (e) { // Set DataTables page property and redraw the grid on listbox change event.
            window.scroll(0,0); //scroll to top of page
            if (this.value === "" || this.value.match(/[^0-9]/)) { /* Nothing entered or non-numeric character */
                return;
            }
            var iNewStart = oSettings._iDisplayLength * (this.value - 1);
            if (iNewStart > oSettings.fnRecordsDisplay()) { /* Display overrun */
                oSettings._iDisplayStart = (Math.ceil((oSettings.fnRecordsDisplay() - 1) / oSettings._iDisplayLength) - 1) * oSettings._iDisplayLength;
                fnCallbackDraw(oSettings);
                return;
            }
            oSettings._iDisplayStart = iNewStart;
            fnCallbackDraw(oSettings);
        }); 

        $(nPrevNext).keyup( function (e) {

			if ( e.which == 38 || e.which == 39 )
		{
			this.value++;
		}
			else if ( (e.which == 37 || e.which == 40) && this.value > 1 )
		{
			this.value--;
		}

		if ( this.value == "" || this.value.match(/[^0-9]/) )
		{
			/* Nothing entered or non-numeric character */
			return;
		}

		var iNewStart = oSettings._iDisplayLength * (this.value - 1);
		if ( iNewStart > oSettings.fnRecordsDisplay() )
		{
			/* Display overrun */
			oSettings._iDisplayStart = (Math.ceil((oSettings.fnRecordsDisplay()-1) /
						oSettings._iDisplayLength)-1) * oSettings._iDisplayLength;
			fnCallbackDraw( oSettings );
			return;
		}

		oSettings._iDisplayStart = iNewStart;
		fnCallbackDraw( oSettings );
		} );


        /* Take the brutal approach to cancelling text selection */
        $('span', nPaging).bind('mousedown', function () {
            return false;
        });
        $('span', nPaging).bind('selectstart', function () {
            return false;
        });
    },
      
    /*
     * Function: oPagination.listbox.fnUpdate
     * Purpose:  Update the listbox element
     * Returns:  -
     * Inputs:   object:oSettings - dataTables settings object
     *             function:fnCallbackDraw - draw function which must be called on update
     */
    "fnUpdate": function (oSettings, fnCallbackDraw) {
        if (!oSettings.aanFeatures.p) {
            return;
        }
        var iPages = Math.ceil((oSettings.fnRecordsDisplay()) / oSettings._iDisplayLength);
        var iCurrentPage = Math.ceil(oSettings._iDisplayStart / oSettings._iDisplayLength) + 1; /* Loop over each instance of the pager */
        var an = oSettings.aanFeatures.p;
        for (var i = 0, iLen = an.length; i < iLen; i++) {
            var spans = an[i].getElementsByTagName('span');
            var inputs = an[i].getElementsByTagName('select');
            var elSel = inputs[0];
            if(elSel.options.length != iPages) {
                elSel.options.length = 0; //clear the listbox contents
                for (var j = 0; j < iPages; j++) { //add the pages
                    var oOption = document.createElement('option');
                    oOption.text = j + 1;
                    oOption.value = j + 1;
                    try {
                        elSel.add(oOption, null); // standards compliant; doesn't work in IE
                    } catch (ex) {
                        elSel.add(oOption); // IE only
                    }
                }
                spans[3].innerHTML = "&nbsp; of &nbsp;" + iPages;
            }
            if ( an[i].childNodes.length !== 0 )
			{
				an[i].childNodes[0].className = 
					( oSettings._iDisplayStart === 0 ) ? 
					oSettings.oClasses.sPagePrevDisabled : oSettings.oClasses.sPagePrevEnabled;

				an[i].childNodes[1].className = 
					( oSettings.fnDisplayEnd() == oSettings.fnRecordsDisplay() ) ? 
					oSettings.oClasses.sPageNextDisabled : oSettings.oClasses.sPageNextEnabled;
			}
          elSel.value = iCurrentPage;
        }
    }
};