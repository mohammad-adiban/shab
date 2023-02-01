$('input#destination').on('change', function() {
	if($('#currentRout').val() != 'search') {
		var rSize = 100;
		var lSize = 93;
			    if($(window).width() < 990) {
			    	// rSize = 150;
			    	// lSize = 143;
			    }
	    $('#header-search-checkin, #header-search-checkout').datepicker();
		$('.h-search-settings').show();
	    // if (getCookie('lang') == 'fa')
	    //     $('.ui-datepicker').css('right', rSize+'1px');
	    // else
	    //     $('.ui-datepicker').css('left', lSize+'93px');

	}
});

$('input[name="checkin"], input[name="checkin_lg"]').on('change', function () {
	setTimeout(function() {
		if($('input[name="checkin_lg"]').length > 0)
			var rect = document.getElementsByName("checkout_lg")[0].getBoundingClientRect();
		else
			var rect = document.getElementsByName("checkout")[0].getBoundingClientRect();
	$('.ui-datepicker').css('left', rect.left+10+'px');
		if($('input[name="checkin_lg"]').length > 0)
			$('input[name="checkout_lg"]').focus().focus();
		else
			$('input[name="checkout"]').focus();

	}, 200);
	//$('input[name="checkout"]').focus();

})

$(document).mouseup(function (e){
    var container = $(".h-search-settings");
    if (!container.is(e.target) // if the target of the click isn't the container...
        && container.has(e.target).length === 0) // ... nor a descendant of the container
    {
	//	if(e.target.className.indexOf('ui-state-default') == -1)
      //  container.hide();
    }
});