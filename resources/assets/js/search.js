$(document).ready(function() { // start line of all js files in all.js
  USER = new Client();
  $.ajaxSetup({
       headers: { 'X-CSRF-Token' : $('meta[name=_token]').attr('content') }
  });
    $('#checkinResult, #checkoutResult').click(function() {
        if ($('body').width() > 767) {
            $('.ui-datepicker').css('left', 'inherit');
            $('.ui-datepicker').css('right', $('body').width() / 5 - 20 + 'px');
        } else {
            $('.ui-datepicker').css('right', 'inherit');
            $('.ui-datepicker').css('left', $('body').width() / 5 - 30 + 'px');
        }
        //  traverse($('.ui-datepicker')[0]); // convert all numbers to persian

    });

    $(document.body).on('mousedown', '.pac-item', function () {
        // $('#destination').val($('input[name="destination"]').val());
        // $("#searchForm").submit();
    });

    $('.date_picker').focus(function() {
        var rect = this.getBoundingClientRect();
        console.log(rect.top + ' , ' + rect.left);
        if($('#currentRout').val().indexOf('houses/show/') != -1) {
            if($(window).width() < 990)
                var top = rect.top*5;
            else
                var top = rect.top;
          $('.ui-datepicker').css('bottom', rect.bottom+'px');
        }
           $('.ui-datepicker').css('left', rect.left+10+'px');

        // else if ($('body').width() > 767) {
        //     $('.ui-datepicker').css('left', 'inherit');
        //     $('.ui-datepicker').css('right', '43%');
        // } else {
        //     $('.ui-datepicker').css('right', 'inherit');
        //     $('.ui-datepicker').css('left', $('body').width() / 5 - 30 + 'px');
        // }
         // traverse($('.ui-datepicker')[0]); // convert all numbers to persian

    });

    var dup = {}; // duplicated params
    dup.room_type = [];
    dup.amenities = [];
    $('[tag="search"]').change(function() {
        doSearch($(this));
    });

   
    $(document.body).on("mouseenter", ".list-item", function(a) {
        // $(this).attr('marker').setAnimation(google.maps.Animation.BOUNCE);
        // $()
    });
        //    $this.onmouseover=function(){$this.attr('marker').setAnimation(google.maps.Animation.BOUNCE);};
