$(document).ready(function () {
    current_route = $('#currentRout').val();
    var main_image;
    house_id = 0;
    remove_main_img = false;
    isInit = true;
    var map_obj = {
        latitude: 35.7011398,
        longitude: 51.3892971
    };

    // set initial height
    $(function () {
        var initial_height = $("#rules").outerHeight();
        var min_height = $(".steps").outerHeight();
        if (initial_height < min_height) {
            initial_height = min_height;
            $("#rules").outerHeight(initial_height);
            $("#btn-rules").css({
                "bottom": "2em",
                "position": "absolute",
                "right": "50%",
                "-webkit-transform": "translateX(50%)",
                "transform": "translateX(50%)"
            });
        }
        $(".forms-wrapper").height(initial_height);
        $(".loader").fadeOut();

        if (current_route.indexOf('houses/edit') > -1) {
            next_form('rules', 'picture');
            main_image = $("#home_main_img");
            house_id = $('#house_id').val();
            console.log('house_id changed');
            $('input[name="rule_checkin"]').val(minToTime($('input[name="rule_checkin"]').val()));
            $('input[name="rule_checkout"]').val(minToTime($('input[name="rule_checkout"]').val()));
            if ($('input[name="rule_checkout"]').val() == '0:0') {
                $('input[name="rule_checkout"]').val('12:00');
            }
            if ($('input[name="rule_checkin"]').val() == '0:0') {
                $('input[name="rule_checkin"]').val('14:00');
            }
            if ($('input[name="rule_checkin"]').val().length == 4) {
                $('input[name="rule_checkin"]').val($('input[name="rule_checkin"]').val() + '0');
            }
            if ($('input[name="rule_checkout"]').val().length == 4) {
                $('input[name="rule_checkout"]').val($('input[name="rule_checkout"]').val() + '0');
            }
            $('.priceShow').each(function () {
                    var priceinletters = wordifyfa($(this).val() * 1000, 1);
                    priceinletters = priceinletters.substring(3)
                    $(this).next('.priceinletters').text(priceinletters + 'تومان');
            });
            map_obj = {
                latitude: $('#map-lat').val(),
                longitude: $('#map-lon').val()
            };

            $('.house_form').attr('action', $('.house_form').attr('action') + '/' + house_id);
            if ($('input[name="floors"]').val() == '0') {
                $('input[name="floors"]').val('1');
            }
            if ($('.img-thumbnail').length > 0)
                isInit = false;
        }

        // map
        $('#map').locationpicker({
            location: map_obj,
            radius: 0,
            scrollwheel: false,
            zoom: 16,
            // gestureHandling: "greedy", // for 1 finger scroll
            inputBinding: {
                latitudeInput: $('#map-lat'),
                longitudeInput: $('#map-lon'),
            },
            markerInCenter: true,
        });
    })

    $(window).on("resize", function () {
        reset_forms_height();
    });

    $(function () {
        $('[data-toggle="popover"]').popover({container: "body"})
    })

    function next_form(current, next) {
        var offset = $("#" + current).outerHeight();
        var min_height = $(".steps").outerHeight();
        var height = $("#" + next).outerHeight();
        if (height < min_height) {
            height = min_height;
            $("#" + next).outerHeight(height);
            $("#btn-" + next).parent().css({
                "bottom": "2em",
                "position": "absolute",
                "right": "50%",
                "-webkit-transform": "translateX(50%)",
                "transform": "translateX(50%)"
            });

        }
        $(".forms").animate(
            {top: "-=" + offset},
            "fast",
            "swing",
            function () {
                $(".forms-wrapper").animate(
                    {height: height},
                    "fast"
                );
            }
        );

        // set active step title
        $("#title-" + current).toggleClass("active");
        $("#title-" + next).toggleClass("active");

        $("#title-" + current).addClass("text-success");


    }

    function previous_form(current, previous) {
        var min_height = $(".steps").outerHeight();
        var height = $("#" + previous).outerHeight();
        if (height < min_height) {
            height = min_height;
            $("#" + previous).outerHeight(height);
            $("#btn-" + previous).parent().css({
                "bottom": "2em",
                "position": "absolute",
                "right": "50%",
                "-webkit-transform": "translateX(50%)",
                "transform": "translateX(50%)"
            });

        }
        $(".forms").animate(
            {top: "+=" + height},
            "fast",
            "swing",
            function () {
                $(".forms-wrapper").animate(
                    {height: height},
                    "fast"
                );
            }
        );

        // set active step title
        $("#title-" + current).toggleClass("active");
        $("#title-" + previous).toggleClass("active");

        $("#title-" + current).removeClass("text-success");

    }

    // next
    $("#btn-rules").click(function () {
        next_form("rules", "picture");
        changeTitle("picture");
        create_tmp_house();
    });
    $("#btn-picture").click(function () {
        $(".crop_ok").click();
        if ($('.img-thumbnail').length > 0) {
            $('.image_alert').css('display', 'none');
            if (check_req("picture")) {
                next_form("picture", "location");
                changeTitle("location");
            }
        }
        else {
            $('.image_alert').css('display', 'block');
        }
    });
    $("#btn-location").click(function () {
        if ($('#province-select option:selected').prop('disabled'))
             $('#province-select').css("border-color", "red");
        if (check_req("location") && !$('#city-select').prop('disabled') && !$('#province-select option:selected').prop('disabled')) {
            next_form("location", "type");
                changeTitle("type");
        }
    });
    $("#btn-type").click(function () {
        if ($('#apartment-type option:selected').prop('disabled'))
            $('#apartment-type').css("border-color", "red");
        if (check_req("type") && !$('#apartment-type option:selected').prop('disabled')) {
            // check req for display floor field
            if ($("#apartment-type option:selected").text() == 'آپارتمان') {
                $(".floor_count_wrapper, .unit_count_wrapper").removeClass("hidden");
                $(".floor_count_wrapper input, .unit_count_wrapper input.form-control").attr("required", true);
            } else {
                if($("#darbast").prop("checked")) {
                    $(".floor_count_wrapper, .unit_count_wrapper").addClass("hidden");
                    $(".floor_count_wrapper input, .unit_count_wrapper input").removeAttr("required");
                }
                else {
                    $(".floor_count_wrapper, .unit_count_wrapper").removeClass("hidden");
                    $(".floor_count_wrapper input, .unit_count_wrapper input.form-control").attr("required", true);
                }
            }
            next_form("type", "options1");
            changeTitle("options1");

        }
    });
    $("#btn-options1").click(function () {

        if ($('#construction-type option:selected').prop('disabled'))
            $('#construction-type').css("border-color", "red");
        if (check_req("options1") && !$('#construction-type option:selected').prop('disabled')) {
            next_form("options1", "options2");
            changeTitle("options2");
        }
    });
    $("#btn-options2").click(function () {
        if (check_req("options2")) {
            next_form("options2", "options3");
            changeTitle("options3");
        }
    });
    $("#btn-options3").click(function () {
        if (($("#options3 input:checked").length) <= 0) {
            $("#options3_err").removeClass("hidden");
        }
        if (check_req("options3") && ($("#options3 input:checked").length) > 0) {
            next_form("options3", "options4");
            changeTitle("options4");
        }
    });
    $("#btn-options4").click(function () {
        if (check_req("options4")) {
            next_form("options4", "time");
            changeTitle("time");
        }
    });
    $("#btn-time").click(function () {
        if (check_req("time")) {
            next_form("time", "price");
            changeTitle("price");
        }
    });
    $("#btn-price").click(function () {
        if (check_req("price")) {
            $('input[type="file"]').remove();
            $('input[name="rule_checkin"]').val(minsAfter12($('input[name="rule_checkin"]').val()));
            $('input[name="rule_checkout"]').val(minsAfter12($('input[name="rule_checkout"]').val()));
            $('.house_form').submit();
        }
            // next_form("price", "finish");
    });

    $(".btn_edit").click(function () {
        if (check_req("time") && check_req("options4") && check_req("options3") && check_req("options2") && check_req("options1") && check_req("picture") && check_req("location") && check_req("type") && check_req("price")) {
            $('input[type="file"]').remove();
            $('input[name="rule_checkin"]').val(minsAfter12($('input[name="rule_checkin"]').val()));
            $('input[name="rule_checkout"]').val(minsAfter12($('input[name="rule_checkout"]').val()));
            if ($('.img-thumbnail').length == 0) {
                $('.image_alert').css('display', 'block');
            }
            else {
                $('.image_alert').css('display', 'none');
                $('.house_form').submit();
            }
        }
    });

    // previous
    $("#btn-picture-previous").click(function () {
        previous_form("picture", "rules");
        changeTitle("rules");

    });
    $("#btn-location-previous").click(function () {
        previous_form("location", "picture");
        changeTitle("picture");

    });
    $("#btn-type-previous").click(function () {
        previous_form("type", "location");
        changeTitle("location");
    });
    $("#btn-options1-previous").click(function () {
        previous_form("options1", "type");
        changeTitle("type");
    });
    $("#btn-options2-previous").click(function () {
        previous_form("options2", "options1");
        changeTitle("options1");
    });
    $("#btn-options3-previous").click(function () {
        previous_form("options3", "options2");
        changeTitle("options2");
    });
    $("#btn-options4-previous").click(function () {
        previous_form("options4", "options3");
        changeTitle("options3");
    });
    $("#btn-time-previous").click(function () {
        previous_form("time", "options4");
        changeTitle("options4");
    });
    $("#btn-price-previous").click(function () {
        previous_form("price", "time");
        changeTitle("time");
    });

    // $('.readonly-input').keyup(function (event) {
    //     if (event.which >= 37 && event.which <= 40) return;
    //     $(this).val('');
    // });

    // SHOW PRICE IN LETTERS
    $('.priceShow').keyup(function (event) {
        // skip for arrow keys
        if (event.which >= 37 && event.which <= 40) return;
        if (Number($(this).val()) > 0) {
            var priceinletters = wordifyfa($(this).val() * 1000, 1);
            priceinletters = priceinletters.substring(3)
            $(this).next('.priceinletters').text(priceinletters + 'تومان');
        }
    });

    // INCREASE INPUT VAL ONE
    $(".plus-val").on("click", function () {
        var $button = $(this);
        var oldValue = parseFloat($button.siblings("input.form-control").val());
        var minValue = parseFloat($button.siblings("input.form-control").attr("min"));
        if (isNaN(minValue)) {
            minValue = 0;
        } else {
            minValue -= 1;
        }

        if (oldValue >= 0 && oldValue > minValue) {
            var newVal = (oldValue) + 1;
        } else {
            newVal = (minValue) + 1;
        }
        $button.siblings("input.form-control").val(newVal);
        $button.siblings("input.form-control").trigger('keyup');
    });
    // DECREASE INPUT VAL ONE
    $(".minus-val").on("click", function () {
        var $button = $(this);
        var oldValue = parseFloat($button.siblings("input.form-control").val());
        var minValue = parseFloat($button.siblings("input.form-control").attr("min"));
        if (isNaN(minValue)) {
            minValue = 1;
        }

        if (oldValue >= 1 && oldValue > minValue) {
            var newVal = (oldValue) - 1;
        } else {
            newVal = minValue;
        }
        $button.siblings("input.form-control").val(newVal);
        $button.siblings("input.form-control").trigger('keyup');
    });

 $(document).on("click", ".step-title", function () {
        var tapped = $(this).attr("id").substr(6); // current section
        if(current_route.indexOf('houses/edit') > -1) {
            var current = $(".steps>.active").attr("id").substr(6); // current section
            if (current == 'rules') return;
            var next = $(this).attr("id").substr(6); // next section
            if (current == next) {
                return false;
            } else {
                var can_go = false;
                switch (current) {
                    case "location" :
                        if ($('#province-select option:selected').prop('disabled'))
                             $('#province-select').css("border-color", "red");
                        if (check_req("location") && !$('#city-select').prop('disabled') && !$('#province-select option:selected').prop('disabled'))
                            can_go = true;
                        break;
                    case "type" :
                        if ($('#apartment-type option:selected').prop('disabled'))
                            $('#apartment-type').css("border-color", "red");
                        if (check_req("type") && !$('#apartment-type option:selected').prop('disabled')) {
                            // check req for display floor field
                            if ($("#darbast").prop("checked") || $("#apartment-type option:selected").text() != 'آپارتمان') {
                                $(".floor_count_wrapper, .unit_count_wrapper").addClass("hidden");
                                $(".floor_count_wrapper input, .unit_count_wrapper input").removeAttr("required");
                            } else {
                                $(".floor_count_wrapper, .unit_count_wrapper").removeClass("hidden");
                                $(".floor_count_wrapper input, .unit_count_wrapper input.form-control").attr("required", true);
                            }
                            can_go = true;
                        }
                        break;
                    case "options1" :
                        if ($('#construction-type option:selected').prop('disabled'))
                            $('#construction-type').css("border-color", "red");
                        if (check_req("options1") && !$('#construction-type option:selected').prop('disabled'))
                            can_go = true;
                        break;
                    case "options3" :
                        if (($("#options3 input:checked").length) <= 0) {
                            $("#options3_err").removeClass("hidden");
                        }
                        if (check_req("options3") && ($("#options3 input:checked").length) > 0)
                            can_go = true;
                        break;
                    case "picture" :
                    case "options2" :
                    case "options4" :
                    case "time" :
                    case "price" :
                        if (check_req(current))
                            can_go = true;
                        break;
                    default:
                        can_go = true;
                        break;
                }
                if (can_go) {

                    $("#title-" + current).removeClass("active");

                    var previous, offset = 0;
                    $(this).prevAll().each(function () {
                        previous = $(this).attr("id").substr(6);
                        offset += $("#" + previous).outerHeight();
                    }); // previous section
                    var height = $("#" + next).outerHeight();
                    var min_height = $(".steps").outerHeight();
                    if (height < min_height) {
                        height = min_height;
                        $("#" + next).outerHeight(height);
                        $("#btn-" + next).parent().css({
                            "bottom": "2em",
                            "position": "absolute",
                            "right": "50%",
                            "-webkit-transform": "translateX(50%)",
                            "transform": "translateX(50%)"
                        });
                    }
                    $("#title-" + next).addClass("active");

                    $(".forms").animate(
                        {top: -offset},
                        "fast",
                        "swing",
                        function () {
                            $(".forms-wrapper").animate(
                                {height: height},
                                "fast"
                            );
                        }
                    );
                    changeTitle(tapped);
                }// can_go == true
                else {
                    return false;
                } //can_go == false


            }// else
        }

    });//function

    // SET CLOCK PICKER
    $('.clockpicker_first').clockpicker({
        placement: 'bottom', // clock popover placement
        align: 'left',       // popover arrow align
        donetext: 'تایید',     // done button text
        autoclose: true,    // auto close when minute is selected
        vibrate: true,        // vibrate the device when dragging clock hand
        afterDone: function () {
            var clockpicker = $(".clockpicker_first");
            if (clockpicker.children(".overlay-title").length < 1) {
                var input_title = clockpicker.children("input").attr("placeholder");
                clockpicker.children("input").before('<span class="overlay-title">' + input_title + '</span>');
                clockpicker.children("input").prev(".overlay-title").animate({
                    "top": "-2em",
                    "right": "1.5em",
                }, "fast", "linear");
            }
        }
    });
    $('.clockpicker_second').clockpicker({
        placement: 'bottom', // clock popover placement
        align: 'left',       // popover arrow align
        donetext: 'تایید',     // done button text
        autoclose: true,    // auto close when minute is selected
        vibrate: true,        // vibrate the device when dragging clock hand
        afterDone: function () {
            var clockpicker = $(".clockpicker_second");
            if (clockpicker.children(".overlay-title").length < 1) {
                var input_title = clockpicker.children("input").attr("placeholder");
                clockpicker.children("input").before('<span class="overlay-title">' + input_title + '</span>');
                clockpicker.children("input").prev(".overlay-title").animate({
                    "top": "-2em",
                    "right": "1.5em",
                }, "fast", "linear");
            }
        }
    });

    // cities
    setProvince();
    $('#province-select').on('change', function (e) {
        $("#city-select").removeAttr("disabled");
        $("#village-select").removeAttr("disabled");
        $("#city-select").trigger("change");
        setCities(this.value);

    });
    /*
     $("#home_imgs").fileinput({
     language: 'fa',
     initialPreview: [
     'http://upload.wikimedia.org/wikipedia/commons/thumb/e/e1/FullMoon2010.jpg/631px-FullMoon2010.jpg',
     'http://upload.wikimedia.org/wikipedia/commons/thumb/6/6f/Earth_Eastern_Hemisphere.jpg/600px-Earth_Eastern_Hemisphere.jpg'
     ],
     initialPreviewAsData: true,
     initialPreviewConfig: [
     {caption: "Moon.jpg", size: 930321, width: "120px", key: 1},
     {caption: "Earth.jpg", size: 1218822, width: "120px", key: 2}
     ],
     deleteUrl: "/site/file-delete",
     overwriteInitial: false,
     maxFileSize: 100,


     });
     */
    // title for inputs
    $("input.form-control:not(.titleless), textarea.form-control").each(function () {
        var $this = $(this);
        if ($(this).val() == '') {
            $(this).prev(".overlay-title").animate({
                "top": ".2em",
                "right": ".9em",
                "opacity": 0
            }, "fast", "linear", function () {
                $(this).remove();
            });

        } else {
            var input_title = $(this).attr('placeholder');
            if ($(this).prev(".overlay-title").length < 1) {
                $(this).before('<span class="overlay-title">' + input_title + '</span>');
                $(this).prev(".overlay-title").animate({
                    "top": "-2em",
                    "right": "1.5em",
                }, "fast", "linear");

            }


        }
    });

    $("input.form-control:not(.titleless), textarea.form-control").on("keyup", function () {
        var $this = $(this);
        if ($(this).val() == '') {
            $(this).prev(".overlay-title").animate({
                "top": ".2em",
                "right": ".9em",
                "opacity": 0
            }, "fast", "linear", function () {
                $(this).remove();
            });

        } else {
            var input_title = $(this).attr('placeholder');
            if ($(this).prev(".overlay-title").length < 1) {
                $(this).before('<span class="overlay-title">' + input_title + '</span>');
                $(this).prev(".overlay-title").animate({
                    "top": "-2em",
                    "right": "1.5em",
                }, "fast", "linear");

            }


        }
    });

    $("input.form-control:not(.titleless), textarea.form-control").on("change", function () {
        var $this = $(this);
        if ($(this).val() == '') {
            $(this).prev(".overlay-title").animate({
                "top": ".2em",
                "right": ".9em",
                "opacity": 0
            }, "fast", "linear", function () {
                $(this).remove();
            });

        } else {
            var input_title = $(this).attr('placeholder');
            if ($(this).prev(".overlay-title").length < 1) {
                $(this).before('<span class="overlay-title">' + input_title + '</span>');
                $(this).prev(".overlay-title").animate({
                    "top": "-2em",
                    "right": "1.5em",
                }, "fast", "linear");

            }


        }
    });
    $("select.form-control").on("change", function () {
        if ($(this).prev(".overlay-title").length < 1) {
            var input_title = $(this).children("option:first-child").val();
            $(this).before('<span class="overlay-title">' + input_title + '</span>');
            $(this).prev(".overlay-title").animate({
                "top": "-2em",
                "right": "1.5em",
            }, "fast", "linear");
        }
    });


    $(".limited").on('keyup', function () {
        $(this).removeAttr("style");
        var max = $(this).attr("maxlength");
        var typed = $(this).val().length;
        $(this).next(".remaining-chars").text(max - typed);
        if (max - typed < 10)
            $(this).next(".remaining-chars").css("color", "red");
        else
            $(this).next(".remaining-chars").removeAttr("style");
    });

    $(".discount-one").on("keyup", function () {

        var value = $(".discount-one").filter(function () {
            return this.value != '';
        });
        if (value.length == 2)
            $(this).parents(".row").first().next('.row').show(function () {
                reset_forms_height();
            });
        else
            $(this).parents(".row").first().next('.row').hide(function () {
                reset_forms_height();
            });


    });


    // images handler
    var inputLocalFont = document.getElementById("image-input"),
        _cropper,
        first_crop;
    inputLocalFont.addEventListener("change", previewImages, false);


    function previewImages() {
        var fileList = this.files;

        var anyWindow = window.URL || window.webkitURL;

        for (var i = 0; i < fileList.length; i++) {

            var objectUrl = anyWindow.createObjectURL(fileList[i]);

            // var image = new Image();
            // var width, height;
            // image.src = objectUrl;
            // image.onload = function () {
            //     width = image.naturalWidth;
            //     height = image.naturalHeight;
            //     if (width < 1000 || height < 500) {
            //         return false;
            //     }
            // }

            var imgs_count = $(".preview-area").children().length;

            if (imgs_count == 0 && i == 0) {
                $('.preview-area').append(
                    '<div class="main_img col-xs-12 text-center">' +
                    '<div class="main_img_div" style="position: relative;">'+
                    '<img class="img-responsive img-thumbnail home-thumbnail" id="home_main_img" draggable="true" src="' + objectUrl + '" />' +
                    '<span class="delete_img delete_main_img"><i class="fa fa-trash"></i></span>' +
                    '<span class="main_img_title">عکس اصلی</span>' +
                    '<span class="crop_home_img"><i class="fa fa-crop"></i></span>' +
                    '<span class="crop_ok hidden"><i class="fa fa-check"></i></span>' +
                    '<span class="crop_nok hidden"><i class="fa fa-times"></i></span></div>' +
                    '</div>');
            } else {
                $('.preview-area').append(
                    '<div class="col-xs-6 col-sm-3">' +
                    '<div style="position: relative;">'+
                    '<img class="img-responsive img-thumbnail home-thumbnail" draggable="true" src="' + objectUrl + '" />' +
                    '<span class="delete_img"><i class="fa fa-trash"></i></span>' +
                    '<span class="make_main_img"><span class="visible-lg">انتخاب به عنوان عکس اصلی</span><i class="fa fa-exchange hidden-lg"></i></span></div>' +
                    '</div>');
            }
            if (imgs_count > 0) {
                $(".fileUpload>.img_input_title").text("افزودن تصاویر");
            }
            window.URL.revokeObjectURL(fileList[i]);
           if (imgs_count > 0) {
              var reader = new FileReader();
                reader.onload = function(event){
                    uploadPhoto(house_id, event.target.result, false);
                };
                reader.readAsDataURL(fileList[i]);
            }

        }
        setTimeout(function () {
            reset_forms_height();
            main_image = $("#home_main_img");

            // run first cropper
            console.log('isinit', isInit);
            if (isInit) {
                isInit = false;
            _cropper = main_image.cropper({
                aspectRatio: 16 / 9,
                viewMode: 3,
                dragMode: 'move',
                rotatable: true,
                autoCropArea: 0.99,
                crop: function (e) {
                    console.log(e.detail.x);
                    console.log(e.detail.y);
                    console.log(e.detail.width);
                    console.log(e.detail.height);
                    console.log(e.detail.rotate);
                    console.log(e.detail.scaleX);
                    console.log(e.detail.scaleY);
                }
            });
            add_rotate();
            first_crop = true;
            $(".main_img_title, .delete_main_img, .crop_home_img, .crop_ok, .make_main_img").toggleClass("hidden");
            $("#picture #image-input").attr("disabled", true);
            $("#picture .fileUpload").addClass("disabled");
        }


        }, 500)
    }
    $(document).on("click", "#rotate-left", function () {
            console.log('rotate-left');
            main_image.cropper('rotate', -90);
    });

    $(document).on("click", "#rotate-right", function () {
            console.log('rotate-right');
            main_image.cropper('rotate', 90);
    });
    
    $(document).on("click", ".crop_nok", function () {
        main_image.cropper('destroy');
        remove_rotate();
        $(".main_img_title, .delete_main_img, .crop_home_img, .crop_ok, .crop_nok, .make_main_img").toggleClass("hidden");
        $("#picture #image-input").removeAttr("disabled");
        $("#picture .fileUpload").removeClass("disabled");
        remove_main_img = false;

    });

    $(document).on("click", ".crop_ok", function () {
        remove_rotate();
        if(remove_main_img) {
            var img_id = $(this).parent().find(".home-thumbnail").attr("img_id");
            removePhoto(house_id, img_id);
        }
        var base64img = main_image.cropper('getCroppedCanvas').toDataURL('image/jpeg');
        $("#picture #image-input").removeAttr("disabled");
        $("#picture .fileUpload").removeClass("disabled");
        main_image.cropper('destroy');
        if (first_crop) {
            // call create house
            $(".main_img_title, .delete_main_img, .crop_home_img, .crop_ok, .make_main_img").toggleClass("hidden");
            first_crop = false;
        } else {
            $(".main_img_title, .delete_main_img, .crop_home_img, .crop_ok, .crop_nok, .make_main_img").toggleClass("hidden");
        }
        $(".preview-area>.main_img>div>.home-thumbnail").attr("src", base64img);
        uploadPhoto(house_id, base64img, true);
        remove_main_img = false;
        setTimeout(function () {
            reset_forms_height();        
        }, 300);
    });
    $(document).on("click", ".crop_home_img", function () {
        add_rotate();
        remove_main_img = true;
        _cropper = main_image.cropper({
            aspectRatio: 16 / 9,
            viewMode: 3,            dragMode: 'move',
            crop: function (e) {
                console.log(e.detail.x);
                console.log(e.detail.y);
                console.log(e.detail.width);
                console.log(e.detail.height);
                console.log(e.detail.rotate);
                console.log(e.detail.scaleX);
                console.log(e.detail.scaleY);
            }
        });
        $(".main_img_title, .delete_main_img, .crop_home_img, .crop_ok, .crop_nok, .make_main_img").toggleClass("hidden");
        $("#picture #image-input").attr("disabled", true);
        $("#picture .fileUpload").addClass("disabled");


    });
    //remove red border on fields
    $('input, select, textarea').on('focus', function () {
        $(this).removeAttr("style");
    });

    $(document).on("click", ".make_main_img", function () {
        var new_main_img = $(this).parent().find(".home-thumbnail").attr("src");
        var old_main_img = $(".preview-area>.main_img>div>.home-thumbnail").attr("src");

        var new_main_img_id = $(this).parent().find(".home-thumbnail").attr("img_id");
        var old_main_img_id = $(".preview-area>.main_img>div>.home-thumbnail").attr("img_id");

        $(this).prevAll(".home-thumbnail").first().attr("src", old_main_img);
        $(".preview-area>.main_img>div>.home-thumbnail").attr("src", new_main_img);

        $(this).prevAll(".home-thumbnail").first().attr("img_id", old_main_img_id);
        $(".preview-area>.main_img>div>.home-thumbnail").attr("img_id", new_main_img_id);

        changeCoverPhoto(new_main_img_id);
    });

    $(document).on("click", ".delete_img", function () {
        removePhoto(house_id, $(this).attr('img_id'));

        if ($(this).hasClass("delete_main_img")) {
            if ($(".preview-area").children(":not(.main_img)").length > 0) {

                $(".preview-area").children(":not(.main_img)").first().find(".make_main_img").trigger("click");

                setTimeout(function () {
                    $(".preview-area").children(":not(.main_img)").first().fadeOut(function () {
                        $.when($(".preview-area").children(":not(.main_img)").first().remove()).then(reset_forms_height());
                    });
                }, 100)


            } else {
                $(this).parents(".main_img").first().fadeOut(function () {
                    $.when($(this).remove()).then(reset_forms_height());
                });
            }
        } else {
            $(this).parents(".col-xs-6.col-sm-3").first().fadeOut(function () {
                $.when($(this).remove()).then(reset_forms_height());
            });
        }
        if ($('.img-thumbnail').length == 1) {
            isInit = true;
        }
    });

    $(document).on("click", ".btn_plus", function () {
        $('#image-input').click();
    });

    $(document).on("keyup", "#standard_capacity", function () {
        var standard_capacity = $(this).val();
        $("#max_capacity").attr("min", standard_capacity);
        if (parseFloat($("#max_capacity").val()) < parseFloat(standard_capacity)) {
            $("#max_capacity").val(standard_capacity);
        }
    });

});

    var tmp_id = 100;
    function uploadPhoto(houseId, base64, isFirst) {
        // $(".main_img").prepend('<div class="spinner"><div class="bounce1"></div><div class="bounce2"></div><div class="bounce3"></div></div>');

        tmp_id++;
        $('.preview-area').children().last().find('img').after('<div class="up_progress a'+tmp_id+'"></div>');
        var blob = dataURItoBlob(base64);
        var fd = new FormData();
        fd.append("image", blob);
        jQuery.ajax({
            url: '/houses/photos/add/'+houseId,
            xhr: function() {
                var myXhr = $.ajaxSettings.xhr();
                if(myXhr.upload){
                    myXhr.upload.addEventListener('progress',progress, false);
                }
                return myXhr;
            },
            data: fd,
            cache: false,
            contentType: false,
            processData: false,
            type: 'POST',
            success: function(data){
                console.log(data);
                if ($('.preview-area').children().length <= 1) {
                    changeCoverPhoto(data.id);
                }
                $('.preview-area').children().last().find('img').attr("img_id", data.id);
                $('.preview-area').children().last().find('.delete_img').attr("img_id", data.id);
                // $(".spinner").remove();
            },

        });
    }

    function removePhoto(houseId, img_id) {
        console.log('img_id', img_id ,'houseId', houseId);
        jQuery.ajax({
            url: '/houses/photos/remove/'+houseId,
            type: 'POST',
            data: 'img_id='+img_id,
            success: function(data){
                console.log(data);
            },

        });
    }

    function minsAfter12(time) {
        var h = parseInt(time.substring(0, 2));
        var m = parseInt(time.substring(3, 5));
        var minutes = h * 60 + m;
        console.log(h, m);
        return (minutes.toString());
    }

    function minToTime(time) {
        var h1 = time / 60;
        var m1 = time % 60;
        console.log('h1', h1, 'm1', m1);
        h1 = h1.toString().substring(0, 2);
        h1 = h1.replace('.', '0');
        m1 = m1.toString();
        var res = h1 + ':' + m1;
        return res
    }

    function create_tmp_house() {
        jQuery.ajax({
            url: '/houses/new',
            type: 'POST',
            success: function(data){
                console.log(data);
                house_id = data.id;
                console.log('house_id changed');
                console.log('house_id', house_id);
                $('.house_form').attr('action', $('.house_form').attr('action') + '/' + house_id);
            },

        });
    }

    function changeCoverPhoto(id) {
        jQuery.ajax({
            url: '/photos/'+id+'/cover',
            type: 'POST',
            success: function(data){
                console.log(data);
            },

        });
    } 

    function progress(e){
        if(e.lengthComputable){
            var max = e.total;
            var current = e.loaded;

            var Percentage = (current * 100)/max;

            $( '.up_progress.a'+tmp_id ).progressCircle({
                nPercent        : Math.floor(Percentage),
                showPercentText : false,
                thickness       : 4,
                circleSize      : 50
            });
            console.log(Percentage);    

            if(Percentage >= 100)
            {
                $('.up_progress.a'+tmp_id).remove();
            }
        }  
    }


// Province and Cities functions
function setProvince() {
    $('#province-select').empty();
    $('#province-select').append('<option selected disabled class="text-center-xs">استان</option>');
    for (i = 1; i < Object.keys(PROVINCES).length; i++) {
        $('#province-select').append('<option class="text-center-xs" value="' + PROVINCES[i] + '">' + PROVINCES[i] + '</option>');
    }
}
function setCities(current_province) {
    var citiesForPr = []
    for (i = 1; i < Object.keys(PROVINCES).length; i++) {
        if (PROVINCES[i] == current_province) {
            var province_id = i;
            break;
        }
    }
    $('#city-select').empty();
    for (var key in CITIES) {
        if (CITIES[key] == province_id) {
            $('#city-select').append('<option class="text-center-xs" value="' + key + '">' + key + '</option>');
        }
    }
}

function add_rotate() {
    $('.main_img_div').append('<span id="rotate-right" class="crop_r"><i class="fa fa-rotate-right"></i></span>');
    $('.main_img_div').append('<span id="rotate-left" class="crop_l"><i class="fa fa-rotate-left"></i></span>');
}

function remove_rotate() {
    $('#rotate-left').remove();
    $('#rotate-right').remove();
}

function reset_forms_height() {
    if ($(".steps>.active").prev().length > 0) {
        var current = $(".steps>.active").attr("id").substr(6); // current section
        var previous, offset = 0;
        $(".steps>.active").prevAll().each(function () {
            previous = $(this).attr("id").substr(6);
            offset += $("#" + previous).outerHeight();
        }); // previous section
        $("#" + current).removeAttr("style");
        $("#btn-" + current).parent().removeAttr("style");
        var height = $("#" + current).outerHeight();
        var min_height = $(".steps").outerHeight();
        if (height < min_height) {
            height = min_height;
            $("#" + current).outerHeight(height);
            $("#btn-" + current).parent().css({
                "bottom": "2em",
                "position": "absolute",
                "right": "50%",
                "-webkit-transform": "translateX(50%)",
                "transform": "translateX(50%)"
            });
        }
        $(".forms-wrapper").css({height: height});
        $(".forms").css({top: -offset});
    }
}

    function check_req(elem_id) {
        var result = true;
        $("#" + elem_id).find('input[required], textarea[required]').each(function () {
            $(this).removeAttr("style");
            var hasMin = false;
            if ($(this).attr('min') != undefined) {
                hasMin = true;
            }
            if (hasMin) {
                if (parseInt($(this).val().trim()) < $(this).attr('min') ) {
                    $(this).css("border-color", "red");
                    result = false;
                }
            }
            if ($(this).val().trim() == '' ) {
                // $(this).focus();
                $(this).css("border-color", "red");
                result = false;
            }
        });
        return result;
    }

    $('document').ready(function() {
      pr = '', ct = '';

      if($('#province-select').attr('default') != "") {
          pr = $('#province-select').attr('default');
      }
      if (pr != '') {
        if($('#city-select').attr('default') != "") {
            ct = $('#city-select').attr('default');
            var cities1 = getCitiesForProvince(pr);
              setCities(cities1);
        }
      }

        for (i = 1; i < Object.keys(PROVINCES).length + 1; i++) {

          if (PROVINCES[i] == pr) {
            $('#province-select').append('<option selected="selected" value="'+PROVINCES[i]+'">'+PROVINCES[i]+'</option>');
          }
          else {
            $('#province-select').append('<option value="'+PROVINCES[i]+'">'+PROVINCES[i]+'</option>');
          }
        }

        $('#province-select').on('change', function (e) { 
          var cities = getCitiesForProvince(this.value);
            setCities(cities);
            var geocoder =  new google.maps.Geocoder();
            console.log(cities[0]);
            geocoder.geocode( { 'address': cities[0]+', ir'}, function(results, status) {
                  if (status == google.maps.GeocoderStatus.OK) {
                    showResults = true;
                    lat = results[0].geometry.location.lat();
                    lng = results[0].geometry.location.lng(); 
                    $('#map').locationpicker("location", {latitude: lat, longitude: lng});
                  }
            });
        });

        $('#city-select').on('change', function (e) { 
            var city = this.value;
            var geocoder =  new google.maps.Geocoder();
            geocoder.geocode( { 'address': city+', ir'}, function(results, status) {
                  if (status == google.maps.GeocoderStatus.OK) {
                    showResults = true;
                    lat = results[0].geometry.location.lat();
                    lng = results[0].geometry.location.lng(); 
                    $('#map').locationpicker("location", {latitude: lat, longitude: lng});
                  }
            });
        });

        $(".btn-pagination").click(function () {
        if (current_route.indexOf('houses/edit') > -1 && !$(this).hasClass("submit"))
            return;
        var current = $(".steps>.active").attr("id").substr(6); // current section
        var can_go = false;
        if ($('.img-thumbnail').length == 0) {
           $('.image_alert').css('display', 'block');
           return;
        }
        switch (current) {
            case "location" :
                if ($('#province-select option:selected').prop('disabled'))
                    $('#province-select').css("border-color", "red");
                if (check_req("location") && !$('#city-select').prop('disabled') && !$('#province-select option:selected').prop('disabled'))
                    can_go = true;
                break;
            case "type" :
                if ($('#apartment-type option:selected').prop('disabled'))
                    $('#apartment-type').css("border-color", "red");
                if (check_req("type") && !$('#apartment-type option:selected').prop('disabled')) {
                    // check req for display floor field
                    if ($("#darbast").prop("checked") || $("#apartment-type option:selected").text() != 'آپارتمان') {
                        $(".floor_count_wrapper, .unit_count_wrapper").addClass("hidden");
                        $(".floor_count_wrapper input, .unit_count_wrapper input").removeAttr("required");
                    } else {
                        $(".floor_count_wrapper, .unit_count_wrapper").removeClass("hidden");
                        $(".floor_count_wrapper input, .unit_count_wrapper input.form-control").attr("required", true);
                    }
                    can_go = true;
                }
                break;
            case "options1" :
                if ($('#construction-type option:selected').prop('disabled'))
                    $('#construction-type').css("border-color", "red");
                if (check_req("options1") && !$('#construction-type option:selected').prop('disabled'))
                    can_go = true;
                break;
            case "options3" :
                if (($("#options3 input:checked").length) <= 0) {
                    $("#options3_err").removeClass("hidden");
                }
                if (check_req("options3") && ($("#options3 input:checked").length) > 0)
                    can_go = true;
                break;
            case "rules" :
            case "picture" :
            case "options2" :
            case "options4" :
            case "time" :
            case "price" :
                if (check_req(current))
                    can_go = true;
                break;
            default:
                can_go = true;
                break;
        }
        if (can_go) {
            var sections = ["location", "type", "options1", "options3", "rules", "picture", "options2", "options4", "time", "price"];

            var passed = 0;
            $.each(sections, function (i, section) {
                var can_submit = false;
                switch (section) {
                    case "location" :
                        if ($('#province-select option:selected').prop('disabled'))
                    $('#province-select').css("border-color", "red");
                if (check_req("location") && !$('#city-select').prop('disabled') && !$('#province-select option:selected').prop('disabled'))
                    can_submit = true;
                        break;
                    case "type" :
                        if ($('#apartment-type option:selected').prop('disabled'))
                            $('#apartment-type').css("border-color", "red");
                        if (check_req("type") && !$('#apartment-type option:selected').prop('disabled')) {
                            // check req for display floor field
                            if ($("#darbast").prop("checked") || $("#apartment-type option:selected").text() != 'آپارتمان') {
                                $(".floor_count_wrapper, .unit_count_wrapper").addClass("hidden");
                                $(".floor_count_wrapper input, .unit_count_wrapper input").removeAttr("required");
                            } else {
                                $(".floor_count_wrapper, .unit_count_wrapper").removeClass("hidden");
                                $(".floor_count_wrapper input, .unit_count_wrapper input.form-control").attr("required", true);
                            }
                            can_submit = true;
                        }
                        break;
                    case "options1" :
                        if ($('#construction-type option:selected').prop('disabled'))
                            $('#construction-type').css("border-color", "red");
                        if (check_req("options1") && !$('#construction-type option:selected').prop('disabled'))
                            can_submit = true;
                        break;
                    case "options3" :
                        if (($("#options3 input:checked").length) <= 0) {
                            $("#options3_err").removeClass("hidden");
                        }
                        if (check_req("options3") && ($("#options3 input:checked").length) > 0)
                            can_submit = true;
                        break;
                    case "rules" :
                    case "picture" :
                    case "options2" :
                    case "options4" :
                    case "time" :
                    case "price" :
                        if (check_req(section))
                            can_submit = true;
                        break;
                    default:
                        can_submit = true;
                        break;
                }
                if (!can_submit) {
                    changeTitle(section);
                    $("#title-" + current).removeClass("active");
                    var previous, offset = 0;
                    $("#title-" + section).prevAll().each(function () {
                        previous = $(this).attr("id").substr(6);
                        offset += $("#" + previous).outerHeight();
                    }); // previous section

                    var height = $("#" + section).outerHeight();
                    var min_height = $(".steps").outerHeight();
                    if (height < min_height) {
                        height = min_height;
                        $("#" + section).outerHeight(height);
                        $("#btn-" + section).parent().css({
                            "bottom": "2em",
                            "position": "absolute",
                            "right": "50%",
                            "-webkit-transform": "translateX(50%)",
                            "transform": "translateX(50%)"
                        });
                    }
                    $("#title-" + section).addClass("active");

                    $(".forms").animate(
                        {top: -offset},
                        "fast",
                        "swing",
                        function () {
                            $(".forms-wrapper").animate(
                                {height: height},
                                "fast"
                            );
                        }
                    );
                    return false;
                } else {
                    passed += 1;
                } //can_submit == true
            });

            if (passed==sections.length) {
                console.log ('can submit form');
                if($(this).hasClass('redirect')) {
                    if ($('.img-thumbnail').length == 0) {
                        $('.image_alert').css('display', 'block');
                    }
                    else {
                        window.location.href = '/houses';
                    }
                }
                if($(this).hasClass('submit')) {
                     $('input[name="rule_checkin"]').val(minsAfter12($('input[name="rule_checkin"]').val()));
                     $('input[name="rule_checkout"]').val(minsAfter12($('input[name="rule_checkout"]').val()));
                    $('.house_form').submit();
                }
            }

        } // can_go == true
    });

    });

        function setCities(citiesList) {
          $('#city-select').empty();
          for (i = 0; i < Object.keys(citiesList).length; i++) {
            if (citiesList[i] == ct) {
              $('#city-select').append('<option selected="selected" value="'+citiesList[i]+'">'+citiesList[i]+'</option>');
            }
            else {
              $('#city-select').append('<option value="'+citiesList[i]+'">'+citiesList[i]+'</option>');
            }
          }
    }


function changeTitle(current) {
    switch (current) {
        case "picture" :
        $('.description').text('تصاویر اقامتگاه خود را اضافه کنید. بهتر است حداقل ۶ عکس از داخل و خارج خانه داشته باشید');
        $('.title').text('تصاویر');
        break;

        case "location" :
        $('.description').text('عنوان، آدرس پستی و موقعیت جغرافیایی را بر روی نقشه را انتخاب کنید');
        $('.title').text('موقعیت');
        break;

        case "type" :
        $('.description').text('نوع اقامتگاه، نکات جذاب محل و مجاورت آن با اماکن مهم و مراکز خرید را مشخص کنید');
        $('.title').text('نوع محل');
        break;

        case "options1" :
        $('.description').text('مشخصات مساحت خانه و تعداد اتاق خواب قابل استفاده را مشخص کنید');
        $('.title').text('متراژ');
        break;

        case "options2" :
        $('.description').text('توضیحاتی در خصوص محل قرارگیری خانه و نوع بافت محله وارد کنید');
        $('.title').text('ظرفیت');
        break;

        case "options3" :
        $('.description').text('توضیحاتی در خصوص محل قرارگیری خانه و نوع بافت محله وارد کنید');
        $('.title').text('بافت');
        break;

        case "options4" :
        $('.description').text('اعلام جزییات کامل از امکانات خانه، سوالات مهمان را کاهش میدهد');
        $('.title').text('امکانات');
        break;

        case "time" :
        $('.description').text('قوانینی که مهمان میبایست در رابطه با خانه شما بداند');
        $('.title').text('قوانین خانه');
        break;

        case "price" : 
        $('.description').text('با اپلیکشن شب میتوانید قیمت را هفتگی تغییر داده و تخفیف لحظه آخری اعمال کنید');
        $('.title').text('قیمت');
        break;

        default: 
        $('.description').text('در این بخش می توانید با انتخاب هر یک از قسمت های سمت راست، اطلاعات آن بخش را ویرایش کنید.');
        $('.title').text('ویرایش آگهی');
        break;
    }
}


    function getCitiesForProvince(pr) {
        var prCode = 0;
        var citiesForPr = [];
        for(var key in PROVINCES){
            if (PROVINCES[key] == pr) {
                prCode = key;
            }
        }

        for(var key in CITIES) {
            if(CITIES[key] == prCode) {
                citiesForPr.push(key);
            }
        }
        return citiesForPr;
    }

/**************************************************************
*
* Progress Circle 1.0
*
**************************************************************/

( function( $ ){
    var ProgressCircle = function( element, options ){

        var settings          = $.extend( {}, $.fn.progressCircle.defaults, options );
        var thicknessConstant = 0.02;
        var nRadian           = 0;

        computePercent();
        setThickness();

        var border      = ( settings.thickness * thicknessConstant ) + 'em';
        var offset      = ( 1 - thicknessConstant * settings.thickness * 2 ) + 'em';
        var circle      = $( element );
        var progCirc    = circle.find( '.prog-circle' );
        var circleDiv   = progCirc.find( '.bar' );
        var circleSpan  = progCirc.children( '.percenttext' );
        var circleFill  = progCirc.find( '.fill' );
        var circleSlice = progCirc.find( '.slice' );

        if ( settings.nPercent == 0 ) {
            circleSlice.hide();
        } else {
            resetCircle();
            transformCircle( nRadians, circleDiv );
        }
        setBorderThickness();
        updatePercentage();
        setCircleSize();

        function computePercent () {
            settings.nPercent > 100 || settings.nPercent < 0 ? settings.nPercent = 0 : settings.nPercent;
            nRadians = ( 360 * settings.nPercent ) / 100;
        }

        function setThickness () {
            if ( settings.thickness > 10 ) {
                settings.thickness = 10;
            } else if ( settings.thickness < 1 ) {
                settings.thickness = 1;
            } else {
                settings.thickness = Math.round( settings.thickness );
            }
        }

        function setCircleSize ( ) {
            progCirc.css( 'font-size', settings.circleSize + 'px' );
        }

        function transformCircle ( nRadians, cDiv ) {
            var rotate = "rotate(" + nRadians + "deg)";
        cDiv.css({
          "-webkit-transform" : rotate,
          "-moz-transform"    : rotate,
          "-ms-transform"     : rotate,
          "-o-transform"      : rotate,
          "transform"         : rotate
        });
        if( nRadians > 180 ) {
            transformCircle( 180, circleFill );
            circleSlice.addClass( ' clipauto ');
            }
        }

        function setBorderThickness () {
            progCirc.find(' .slice > div ').css({
                'border-width' : border,
                'width'        : offset,
                'height'       : offset
            })
            progCirc.find('.after').css({
                'top'    : border,
                'left'   : border,
                'width'  : offset,
                'height' : offset
            })
        }

        function resetCircle () {
            circleSlice.show();
            circleSpan.text( '' );
            circleSlice.removeClass( 'clipauto' )
            transformCircle( 20, circleDiv );
            transformCircle( 20, circleFill );
            return this;
        }

        function updatePercentage () {
            settings.showPercentText && circleSpan.text( settings.nPercent + '%' );
        }
    };

    $.fn.progressCircle = function( options ) {
        return this.each( function( key, value ){
      var element = $( this );
      if ( element.data( 'progressCircle' ) ) {
        var progressCircle = new ProgressCircle( this, options );
        return element.data( 'progressCircle' );
      }
        $( this ).append( '<div class="prog-circle">' +
                                '   <div class="percenttext"> </div>' +
                                '   <div class="slice">' +
                                '       <div class="bar"> </div>' +
                                '       <div class="fill"> </div>' +
                                '   </div>' +
                                '   <div class="after"> </div>' +
                                '</div>');
      var progressCircle = new ProgressCircle( this, options );
      element.data( 'progressCircle', progressCircle );
    });
    };

    $.fn.progressCircle.defaults = {
        nPercent        : 50,
        showPercentText : true,
        circleSize      : 100,
        thickness       : 3
    };

})( jQuery );
