    $(document.body).on("mouseenter", ".btn-roomtype", function(a) {
        $(this).parent().find('.tooltip').addClass("visible")
    })
        .on("mouseleave", ".btn-roomtype", function() {
            $(this).parent().find('.tooltip').removeClass("visible")
        })
        .on("click", ".btn-roomtype", function(e) {
            var group = $(this).attr('group');
            $('.btn-group').find('button[group=' + group + '], select[group=' + group + ']').each(function() {
                $(this).removeClass('lys-select-highlight');
            });

            $(this).addClass('lys-select-highlight');
        });

    $('.other-room-type').change(function() {
        var group = $(this).attr('group');
        $('.btn-group').find('button[group=' + group + '], select[group=' + group + ']').each(function() {
            $(this).removeClass('lys-select-highlight');
        });
        $(this).addClass('lys-select-highlight');
    });

$('.btn-roomtype').on('click', function() {
    $('input[name="type"]').val($(this).attr('name'));
});


var imagesCount = 0;
var imgId = 0;

// if($('#currentRout').val().indexOf('houses/edit/') > -1 ) {
//     imgId = $('#imgId').val();

//     $('.btn-roomtype[name="'+$('input[name="type"]').val()+'"]').addClass('lys-select-highlight');

// }

$(document.body).on("change", ".add-image", function(a) {

        var maxImageWidth = 1300,
            minImageWidth = 400,
            maxImageHeight = 800,
            minImageHeight = 300;

        var val = $(this).val();
        var $this = $(this);

    switch (val.substring(val.lastIndexOf('.') + 1).toLowerCase()) {
            case 'jpg':
            case 'jpeg':
                var files = !!this.files ? this.files : [];
                if (!files.length || !window.FileReader) return;
                if (/^image/.test(files[0].type)) {

                    var reader = new FileReader();
                    reader.readAsDataURL(files[0]);
                    reader.onloadend = function(response) {

                        var img1 = $('<img src =' + this.result + ' />');
                        /*
                        if (img1.get(0).naturalWidth > maxImageWidth || img1.get(0).naturalHeight > maxImageHeight) {
                            alert('سایز تصویر نمی تواند از ۱۲۸۰ در ۷۲۰ پیکسل بیشتر باشد.');
                            control = $this;
                            control.replaceWith(control = control.clone(true));
                        }
                        */
                        var res = this.result
                        setTimeout(
                          function() 
                          {
                            if (img1.get(0).naturalWidth < minImageWidth || img1.get(0).naturalHeight < minImageHeight) {
                            alert('سایز تصویر نمی تواند از ۴۰۰ در ۳۰۰ پیکسل کمتر باشد.');
                            control = $this;
                            control.replaceWith(control = control.clone(true));                            
                        }
                        else {
                            imagesCount++;
                            imgId++;
                            $this.after('<input type="file" name="images[]" class="add-image empty img-'+(imgId + 1)+'" style="display: none">');
                            $this.removeClass('empty');

                            $('.house-images').append('<div class="col-xs-6 image-sec mg-top-4" img-num="'+imgId+'"><img src="" id="'+imgId+'" class="image"><div class="delete-image" id="'+imgId+'"><i id="'+imgId+'" class="fa fa-remove pointer"></i></div></div>');
                            $('.image#'+imgId).attr('src', res);

                        }
                          }, 400);
                        
                    }
                }
                break;
                default: 
                    alert('فرمت تصویر باید jpeg باشد.');
                break;
        }

    // var input = this;

    // if (input.files && input.files[0]) {
    //     var reader = new FileReader();

    //     reader.onload = function (e) {
    //         $('.image#'+imgId).attr('src', e.target.result);
    //     }

    //     reader.readAsDataURL(input.files[0]);
    // }
});


$('.plus-btn').on('click', function() {
    $('.add-image.empty').click();
});


$('.info-l').on('mouseenter', function() {
        $(this).find('small').css('width', ($(this).find('small').text().length * 6)+'px').fadeIn(500);
    }).on('mouseleave', function() {
        $(this).find('small').fadeOut(500);

});

var deletedImages = [];
$(document.body).on("click", ".delete-image i", function(a) {
    var imageNum = this.id;
    imagesCount--;
    if($('#currentRout').val().indexOf('houses/edit/') != -1) {
        deletedImages.push($(this).attr('img-id'));
        $('input[name="deleted_images"]').val(deletedImages);
    }

    $('.image-sec[img-num="'+imageNum+'"]').remove();
    $('.img-'+(imageNum)).remove();
    if($('.add-image').length == 0)
        $('.plus-btn').after('<input type="file" name="images[]" class="add-image empty img-'+(imgId)+'" style="display: none">');
});

    $('.newroom-form').submit(function() {
        var isFormValidated = true;
        var requiredFields = ['type', 'title', 'about', 'description', 'city',
                                'province', 'address', 'longitude', 'latitude', 'land_area', 'building_area'];
        for(var i=0; i<requiredFields.length; i++) {
            $input = $('[name="'+requiredFields[i]+'"]');
            if($input.val() == '') {
                if($input.attr('name') == 'type')
                    $('.btn-roomtype').addClass('error-input');
                else if($input.attr('name') == 'latitude' || $input.attr('name') == 'longitude') {
                    $('.error-map').remove();
                    $('.gmap').after('<div class="error-map col-xs-12 text-center">* لطفا موقعیت خانه را بر روی نقشه مشخص نمایید.</div>');
                }
                else
                    $input.addClass('error-input');

                isFormValidated = false;
            }
            else {
                if($input.attr('name') == 'type')
                    $('.btn-roomtype').removeClass('error-input');
                else if($input.attr('name') == 'latitude' || $input.attr('name') == 'longitude')
                    $('.error-map').remove();

                else
                    $input.removeClass('error-input');
            }

        }

        if($('input[type="file"]').length <= 1 && $("#currentRout").val() != "houses/edit/{id}") {
                isFormValidated = false;
                $('.plus-btn').addClass('error-input');
        }
        else {
            $('.plus-btn').removeClass('error-input');

        }

        if(isFormValidated) {
            $('input.empty').remove();
            $('.error-text').remove();
            return true;

        }
        else {
            $('.error-text').remove();
            $('button[type="submit"]').parent().after('<div class="error-text col-xs-12 text-center">* لطفا موارد اجباری مشخص شده را کامل کنید.</div>');
            return false;
        }
    });

 if(document.getElementById('price-slider1') != null) {
    var slider = document.getElementById('price-slider1');
    var value = $('#currentRout').val().indexOf('houses/edit/') > -1 ? $('input[name="min_price"]').val() : 250;

    noUiSlider.create(slider, {
        start: [value],
        step: 5,
        range: {
            'min': 10,
            'max': 2000
        }
    });
    slider.noUiSlider.on('update', function(values, handle) {
        var value = values[handle].split('.')[0];
        if (!handle) {
            $("input[name='min_price']").val(value);

            var currency = ' هزار تومان';
            if(value > 999) {
                value = value/1000;
                currency = ' میلیون تومان';
            }
            $("#min-price").text(value + currency);
            traverse($("#min-price")[0]);
        }
    });
}
 if(document.getElementById('price-slider2') != null) {
    var slider = document.getElementById('price-slider2');
    var value = $('#currentRout').val().indexOf('houses/edit/') > -1 ? $('input[name="median_price"]').val() : 350;

    noUiSlider.create(slider, {
        start: [value],
        step: 5,
        range: {
            'min': 10,
            'max': 2000
        }
    });
    slider.noUiSlider.on('update', function(values, handle) {
        var value = values[handle].split('.')[0];
        if (!handle) {
            $("input[name='median_price']").val(value);

            var currency = ' هزار تومان';
            if(value > 999) {
                value = value/1000;
                currency = ' میلیون تومان';
            }
            $("#median-price").text(value + currency);
            traverse($("#median-price")[0]);
        }
    });
}
 if(document.getElementById('price-slider3') != null) {
    var slider = document.getElementById('price-slider3');
    var value = $('#currentRout').val().indexOf('houses/edit/') > -1 ? $('input[name="max_price"]').val() : 550;

    noUiSlider.create(slider, {
        start: [value],
        step: 5,
        range: {
            'min': 10,
            'max': 2000
        }
    });
    slider.noUiSlider.on('update', function(values, handle) {
        var value = values[handle].split('.')[0];
        if (!handle) {
            $("input[name='max_price']").val(value);

            var currency = ' هزار تومان';
            if(value > 999) {
                value = value/1000;
                currency = ' میلیون تومان';
            }
            $("#max-price").text(value + currency);
            traverse($("#max-price")[0]);
        }
    });
}

    var map;
    markersArray = [];

    function clearOverlays() {
        for (var i = 0; i < markersArray.length - 1; i++) {
            markersArray[i].setMap(null);
        }
    }

    function initialize() {
        if($('#currentRout').val().indexOf('houses/edit/') > -1) {
            var myLatlng = new google.maps.LatLng($('#lat').val(), $('#lng').val() );
        }
        else
            var myLatlng = new google.maps.LatLng(35.76752801, 51.37678955);
        var myOptions = {
            zoom: 5,
            center: myLatlng,
            mapTypeId: google.maps.MapTypeId.ROADMAP
        }
        map = new google.maps.Map(document.getElementById("gmap"), myOptions);
        if($('#currentRout').val().indexOf('houses/edit/') > -1 ) {
            var marker = new google.maps.Marker({
                position: new google.maps.LatLng($('#lat').val(),  $('#lng').val() ),
                map: map
            });
            markersArray.push(marker);
            clearOverlays();
        }
        google.maps.event.addListener(map, "click", function(event) {
            var clickLat = event.latLng.lat();
            var clickLon = event.latLng.lng();
            document.getElementById('lat').value = clickLat;
            document.getElementById('lng').value = clickLon;

            var marker = new google.maps.Marker({
                position: new google.maps.LatLng(clickLat, clickLon),
                map: map
            });

            markersArray.push(marker);
            clearOverlays();
        });
    }
    window.onload = function() {

         if(document.getElementById('gmap') != null) {
              initialize()
         }
    };