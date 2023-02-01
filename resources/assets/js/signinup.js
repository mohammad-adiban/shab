/* #####################################################################
   #
   #   Project       : SHAB.IR
   #   Author        : Amir Hossein Khosravani
   #   Version       : 1.0
   #
   ##################################################################### */

$(function() {

    var $divForms = $('#div-forms');
    var $formLogin = $divForms.find('.login-form');
    var $formLost = $divForms.find('.lost-form');
    var $formRegister = $divForms.find('.register-form');
    var $formActivationCode = $divForms.find('.activationCode-form');

    var $modalAnimateTime = 300;
    var $msgAnimateTime = 150;
    var $msgShowTime = 2000;





    /* #####################################################################
    #
    #   Submit Forms
    #
    ##################################################################### */

    //Submit forms
    $(".login-form, .lost-form, .register-form, .activationCode-form").submit(function () {

        var $container = $(this).parent();

        //Remove submit form error
        removeSubmitFormsErrorComponent($(this));

        //Submit login forms
        if($(this).hasClass("login-form")) {
            //Login form validation
            //If is valid...
            if (loginFormValidation($(this))) {
                //Show loading
                showLoadingBtnComponent($(this));
                //Login request
                loginRequest($(this));
            }
            //If not valid...
            else {
                //Change height of form, because error of inputs occurs
                changeHeight($(this), $container);
            }
            return false;
        }

        //Submit lost password forms
        else if($(this).hasClass("lost-form")) {
            //Lost password form validation
            //If is valid...
            if (lostPasswordFormValidation($(this))) {
                //Show loading
                showLoadingBtnComponent($(this));
                //Lost password request
                lostPasswordRequest($(this));
            }
            //If not valid...
            else {
                //Change height of form, because error of inputs occurs
                changeHeight($(this), $container);
            }
            return false;
        }

        //Submit register forms
        else if($(this).hasClass("register-form")) {
            //Register form validation
            //If it's valid...
            if (registerFormValidation($(this))) {
                //Show loading
                showLoadingBtnComponent($(this));
                //Send activation code request
                sendActivationCodeRequest($(this));
            }
            //If not valid...
            else {
                //Change height of form, because error of inputs occurs
                changeHeight($(this), $container);
            }
            return false;
        }

        //Submit activation code forms
        else if($(this).hasClass("activationCode-form")) {
            //Activation code form validation
            //If it's valid...
            if(validationCodeFormValidation($(this))) {
                //Show loading
                showLoadingBtnComponent($(this));
                //Register request
                registerRequest($(this));
            }
            //If not valid...
            else {
                //Change height of form, because error of inputs occurs
                changeHeight($(this), $container);
            }
            return false;
        }
    });





    /* #####################################################################
    #
    #   Change Views
    #
    ##################################################################### */

    //Change view by click on buttons
    $('#login_register_btn').click( function () { modalAnimate($formLogin, $formRegister, $divForms); });
    $('#register_login_btn').click( function () { modalAnimate($formRegister, $formLogin, $divForms); });
    $('#login_lost_btn').click( function () { modalAnimate($formLogin, $formLost, $divForms); });
    $('#lost_login_btn').click( function () { modalAnimate($formLost, $formLogin, $divForms); });
    $('#lost_register_btn').click( function () { modalAnimate($formLost, $formRegister, $divForms); });
    $('#register_lost_btn').click( function () { modalAnimate($formRegister, $formLost, $divForms); });
    $('.activationCode_register_btn').click( function () { modalAnimate($(this).closest("form"), $(this).closest("form").parent().find('.register-form'), $(this).closest("form").parent()); });

    //Change view with animation
    function modalAnimate ($oldForm, $newForm, $container) {
        console.log("hi")
        var $oldH = $oldForm.height();
        var $newH = $newForm.height();
        $container.css("height",$oldH);
        $oldForm.fadeToggle($modalAnimateTime, function(){
            $container.animate({height: $newH, minHeight: $newH}, $modalAnimateTime, function(){
                $newForm.fadeToggle($modalAnimateTime);
            });
        });
    }

    //Change height of view
    function changeHeight($currentForm, $container) {
        console.log("an")
        var $currentH = $currentForm.height();
        $container.css({height: $currentH});
    }





    /* #####################################################################
    #
    #   Focus Out & onChange Inputs
    #
    ##################################################################### */

    //phone number focus out
    $(".login-phoneNumber, .lost-phoneNumber, .register-phoneNumber").focusout(function(){
        removeError($(this));
        if($(this).val()) {
            phoneNumberValidation($(this));
        }
        //Change height of form
        changeHeight($(this).closest("form"), $(this).closest("form").parent());
    });

    //Password focus out
    $(".login-password, .register-password").focusout(function(){
        removeError($(this));
        if($(this).val()) {
            passwordValidation($(this));
        }
        //Change height of form
        changeHeight($(this).closest("form"), $(this).closest("form").parent());
    });

    //First and last name focus out
    $(".register-firstName, .register-lastName").focusout(function(){
        removeError($(this));
        if($(this).val()) {
            nameValidation($(this));
        }
        //Change height of form
        changeHeight($(this).closest("form"), $(this).closest("form").parent());
    });

    //Email focus out
    $(".register-email").focusout(function(){
        removeError($(this));
        if($(this).val()) {
            emailValidation($(this));
        }
        //Change height of form
        changeHeight($(this).closest("form"), $(this).closest("form").parent());
    });

    //Remember me onchange
    $(".login-rememberMe").on('change', function() {
        if ($(this).is(':checked')) {
            $(this).attr('value', 'true');
        } else {
            $(this).attr('value', 'false');
        }
    });

    //Activation code focus out
    $(".activationCode-code").focusout(function(){
        removeError($(this));
        if($(this).val()) {
            activationCodeValidation($(this));
        }
        //Change height of form
        changeHeight($(this).closest("form"), $(this).closest("form").parent());
    });





    /* #####################################################################
    #
    #   Inputs Validation Functions
    #
    ##################################################################### */

    //Phone Number validation
    function phoneNumberValidation(element) {
        removeError(element);

        var phoneNumberRegex = /^[0][9](0|1|2|3|9)[0-9]{8,8}$/g;
        //Checking is empty or not
        if(element.val().length === 0) {
            showError(element, 'شماره موبایل را وارد نمایید');
            return false;
        }
        //Checking phone number pattern
        else if(!element.val().match(phoneNumberRegex)) {
            showError(element, 'شماره موبایل را صحیح وارد نمایید');
            return false;
        }

        return true;
    }

    //Password validation
    function passwordValidation(element) {
        removeError(element);

        //Checking is empty or not
        if(element.val().length === 0) {
            showError(element, 'رمز عبور را وارد نمایید');
            return false;
        }
        //If current form is not login form
        else if(!element.hasClass("login-password")) {
            //Checking password length, It should be greater than 8
            if (element.val().length < 8) {
                showError(element, 'رمز عبور باید بیش‌از ۸ کاراکتر باشد');
                return false;
            }
        }

        return true;
    }

    //First name and last name validation
    function nameValidation(element) {
        removeError(element);

        //Checking is empty or not
        if(element.val().length === 0) {
            showError(element, 'این بخش الزامی است');
            return false;
        }
        //Check name length, It should be less than 32
        else if(element.val().length > 32) {
            showError(element, 'حداکثر ۳۲حرف باشد');
            return false;
        }

        return true;
    }

    //Email validation
    function emailValidation(element) {
        removeError(element);

        var emailRegex = /^(([^<>()\[\]\.,;:\s@\"]+(\.[^<>()\[\]\.,;:\s@\"]+)*)|(\".+\"))@(([^<>()[\]\.,;:\s@\"]+\.)+[^<>()[\]\.,;:\s@\"]{2,})$/i;
        //Checking is empty or not
        if(element.val().length === 0) {
            return true;
        }
        //Check name length, It should be less than 32
        else if(!element.val().match(emailRegex)) {
            showError(element, 'ایمیل رو صحیح وارد نمایید');
            return false;
        }

        return true;
    }

    //Activation code validation
    function activationCodeValidation(element) {
        removeError(element);

        //Checking is empty or not
        if(element.val().length === 0) {
            showError(element, 'این بخش الزامی است');
            return false;
        }
        //Check name length, It should be 5
        else if(element.val().length !== 5) {
            showError(element, 'کد فعالسازی باید ۵رقمی باشد');
            return false;
        }

        return true;
    }





    /* #####################################################################
    #
    #   Forms Validation Functions
    #
    ##################################################################### */

    //Login forms validation
    function loginFormValidation(form) {
        var noError = true;
        //Phone Number validation
        if(!phoneNumberValidation(form.find(".login-phoneNumber")))
            noError = false;
        //Password validation
        if(!passwordValidation(form.find(".login-password")))
            noError = false;

        return noError;
    }

    //Register forms validation
    function registerFormValidation(form) {
        var noError = true;
        //First name validation
        if(!nameValidation(form.find(".register-firstName")))
            noError = false;
        //Last name validation
        if(!nameValidation(form.find(".register-lastName")))
            noError = false;
        //Phone Number validation
        if(!phoneNumberValidation(form.find(".register-phoneNumber")))
            noError = false;
        //Email validation
        if(!emailValidation(form.find(".register-email")))
            noError = false;
        //Password validation
        if(!passwordValidation(form.find(".register-password")))
            noError = false;
        //Repeat password validation
        // if(!repeatPasswordValidation($("#register-repeatPassword"), $("#register-password")))
        //     noError = false;

        return noError;
    }

    //Lost password forms validation
    function lostPasswordFormValidation(form) {
        var noError = true;
        //Phone Number validation
        if(!phoneNumberValidation(form.find(".lost-phoneNumber")))
            noError = false;

        return noError;
    }

    //Activation code forms validation
    function validationCodeFormValidation(form) {
        var noError = true;
        //Phone Number validation
        if(!activationCodeValidation(form.find(".activationCode-code")))
            noError = false;

        return noError;
    }





    /* #####################################################################
    #
    #   Forms Request Functions
    #
    ##################################################################### */

    //Login request
    function loginRequest(form) {
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        var formData = {
            mobile: form.find(".login-phoneNumber").val(),
            password: form.find(".login-password").val(),
            remember_me: form.find(".login-rememberMe").val()
        };

        $.ajax({
            type: "POST",
            url: "/login",
            data: formData,
            success: function (data) {
                //If status is success...
                if(data.status === 'success') {
                    //Redirect to...
                    redirectTo(data , form.parent());
                }
                //Else if status is failed...
                else if(data.status === 'failed') {
                    //Show its error
                    showSubmitFormsErrorComponent(form, data.error);
                }
                //Remove loading
                removeLoadingBtnComponent(form);
            },
            error: function (data) {
                //Show error
                showSubmitFormsErrorComponent(form, messageForErrorStatus(data.status));
                //Remove loading
                removeLoadingBtnComponent(form);
            }
        });
    }

    //Send activation code request
    function sendActivationCodeRequest(form) {
        var formData = {
            mobile: form.parent().find(".register-phoneNumber").val()
        };

        $.ajax({
            type: "POST",
            url: "/api/v1/send_code",
            data: formData,
            success: function (data) {
                //If status is success...
                if(data.status === 'success') {
                    console.log(data)
                    //If current form is register form modal...
                    if(form.hasClass('register-form')) {
                        //Show activation code form
                        modalAnimate(form, form.parent().find('.activationCode-form'), form.parent());
                        form.parent().find('.activationCode-phoneNumber').html(form.find('.register-phoneNumber').val());
                    }
                    //Start activation code timer
                    activationCodeTimer(form.parent().find(".activationCode-form"));
                }
                //Else if status is failed...
                else if(data.status === 'failed') {
                    //Show its error
                    showSubmitFormsErrorComponent(form, data.error);
                }
                //Remove loading
                removeLoadingBtnComponent(form);
            },
            error: function (data) {
                //Show error
                showSubmitFormsErrorComponent(form, messageForErrorStatus(data.status));
                //Remove loading
                removeLoadingBtnComponent(form);
            }
        });
    }

    //Register Request
    function registerRequest(form) {
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        var formData = {
            name: form.parent().find(".register-firstName").val(),
            family: form.parent().find(".register-lastName").val(),
            mobile: form.parent().find(".register-phoneNumber").val(),
            email: form.parent().find(".register-email").val(),
            password: form.parent().find(".register-password").val(),
            password_confirmation: form.parent().find(".register-password").val(),
            verify_code: form.find(".activationCode-code").val()
        };

        $.ajax({
            type: "POST",
            url: "/register",
            data: formData,
            success: function (data) {
                //If status is success...
                if(data.status === 'success') {
                    //Redirect to...
                    redirectTo(data , form.parent());
                }
                //Else if status is failed...
                else if(data.status === 'failed') {
                    //Show its error
                    showSubmitFormsErrorComponent(form, data.error);
                }
                //Remove loading
                removeLoadingBtnComponent(form);
            },
            error: function (data) {
                //Show error
                showSubmitFormsErrorComponent(form, messageForErrorStatus(data.status));
                //Remove loading
                removeLoadingBtnComponent(form);
            }
        });
    }

    //Lost password request
    function lostPasswordRequest(form) {
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        var formData = {
            mobile: form.find(".lost-phoneNumber").val()
        };

        $.ajax({
            type: "POST",
            url: "/password/sms",
            data: formData,
            success: function (data) {
                //If status is success...
                if(data.status === 'success') {
                    //Show success message
                   form.find(".alert-success").css("display", "block");
                    //Change height of form
                    changeHeight(form, form.parent());

                    //After 5 seconds...
                    setTimeout(function() {
                        //Show login form
                        modalAnimate(form, $formLogin, form.parent());
                        //Hide success message
                        $formLost.find(".alert-success").css("display", "none");
                    } , 5000);
                }
                //Else if status is failed...
                else if(data.status === 'failed') {
                    //Show its error
                    showSubmitFormsErrorComponent(form, data.error);
                }
                //Remove loading
                removeLoadingBtnComponent(form);
            },
            error: function (data) {
                //Show error
                showSubmitFormsErrorComponent(form, messageForErrorStatus(data.status));
                //Remove loading
                removeLoadingBtnComponent(form);
            }
        });
    }





    /* #####################################################################
    #
    #   Activation Code Timer
    #
    ##################################################################### */

    //Start activation code timer
    function activationCodeTimer(form) {
        //Make the activation timer component
        form.find("#activationCode-timer-container").html(makeActivationCodeTimerComponent());

        //Set timer to 120 seconds
        var $time = 120;
        var temp = setInterval(function () {
            if($time > 0) {
                form.find("#activationCode-timer").text($time--);
            } else {
                form.find("#activationCode-timer-container").html(makeResendActivationCodeComponent());
                form.find("#activationCode-resend").click(function () {
                    sendActivationCodeRequest(form);
                });
                clearInterval(temp);
            }
        }, 1000);
    }

    //Make resend activation code component function
    function makeResendActivationCodeComponent() {
        var txt =
            '<span id="activationCode-resend">' +
            '<span class="glyphicon glyphicon-repeat"> </span>' +
            ' '+
            '<span>ارسال مجدد کد فعالسازی</span>' +
            '</span>';

        return txt;
    }

    //Make activation code timer component
    function makeActivationCodeTimerComponent() {
        var txt =
            '<span>حداکثر تا </span>\n' +
            '<span id="activationCode-timer"></span>\n' +
            '<span>ثانیه دیگر برای شما ارسال می‌شود</span>';

        return txt;
    }





    /* #####################################################################
    #
    #   Loading
    #
    ##################################################################### */

    //Set loading component in button
    function showLoadingBtnComponent(element) {
        element.find('button[type="submit"]').html(makeLoadingBtnCompnent());
    }

    //Set text in button
    function removeLoadingBtnComponent(element) {
        element.find('button[type="submit"]').html(makeTxtBtnComponent(element.find('button[type="submit"]')));
    }

    //Make loading component
    function makeLoadingBtnCompnent() {
        var txt =
            '<div class="spinner">\n' +
                '<div class="bounce1"></div>\n' +
                '<div class="bounce2"></div>\n' +
                '<div class="bounce3"></div>\n' +
            '</div>';

        return txt;
    }

    //Make unique submit button text for each forms
    function makeTxtBtnComponent(elemenent) {

        if(elemenent.hasClass('login-submit-btn'))
            return 'ورود';
        else if(elemenent.hasClass('register-submit-btn'))
            return 'ثبت‌نام';
        else if(elemenent.hasClass('lost-submit-btn'))
            return 'ارسال';
        else if(elemenent.hasClass('activationCode-submit-btn'))
            return 'تایید';

        return '';
    }





    /* #####################################################################
    #
    #   Redirect Page
    #
    ##################################################################### */

    //Redirect to
    function redirectTo(data, container) {
        if(container.attr('id') === 'div-forms') {
            if ($("#redirectToBeHost").val() === 'true') {
                $("#redirectToBeHost").val('value', 'false');
                window.location = "/houses/new";
            }
            else if ($('#redirectToPreInvoice').val() === 'true') {
                $('#redirectToPreInvoice').val('value', 'false');
                $('#payform').submit();            
            }
            else {
                location.reload();
            }
        }

        else if(container.attr('id') === 'div-formsPage') {
            window.location = data.intended_url;
        }
    }





    /* #####################################################################
    #
    #   Convert Persian Number
    #
    ##################################################################### */

    //Convert persian number to english number
    String.prototype.toEnglishDigits = function () {
        var num_dic = {
            '۰': '0',
            '۱': '1',
            '۲': '2',
            '۳': '3',
            '۴': '4',
            '۵': '5',
            '۶': '6',
            '۷': '7',
            '۸': '8',
            '۹': '9'
        }

        return (this.replace(/[۰-۹]/g, function (w) {
            return num_dic[w]
        }));
    };

    //Convert persian number to english number for phone numbers
    $('.login-phoneNumber, .register-phoneNumber, .lost-phoneNumber').on('input', function () {
        $(this).val($(this).val().toEnglishDigits());
    });





    /* #####################################################################
    #
    #   Errors
    #
    ##################################################################### */

    //Show submit forms errors
    function showSubmitFormsErrorComponent(form, message) {
        form.find(".alert-danger").css("display", "block").html(message);
        //Change height of form
        changeHeight(form, form.parent());

    }

    //Remove submit form error
    function removeSubmitFormsErrorComponent(form) {
        form.find(".alert-danger").css("display", "none").html("");
        //Change height of form
        changeHeight(form, form.parent());
    }

    //Show error of inputs
    function showError(element, message) {
        var $error_msg = element.parent().parent().find(".error-class-msg");
        element.addClass('error-class-input');
        element.parent().find(".input-group-addon").addClass('error-class-input');
        $error_msg.html(message);

        return true;
    }

    //Remove error of inputs
    function removeError(element) {
        var $error_msg = element.parent().parent().find(".error-class-msg");
        element.removeClass('error-class-input');
        element.parent().find(".input-group-addon").removeClass('error-class-input');
        $error_msg.html("");

        return false;
    }

    //Return a special message for each error status
    function messageForErrorStatus(status) {
        var message = '';
        switch (status) {
            //Activation code form
            case 400:
                message = 'کد فعالسازی وارد شده، معتبر نیست';
                break;
            //Login Form
            case 401:
                message = 'نام کاربری یا کلمه عبور اشتباه است';
                break;
            //Lost password form
            case 422:
                message = 'این شماره در سیستم ثبت نشده است';
                break;
            //Activation code form
            case 429:
                message = 'تعداد درخواست‌های شما بیش‌ازحد مجاز بوده است';
                break;
            //All forms
            case 500:
                message = 'متاسفانه مشکلی رخ داده است';
                break;
            default:
                message = 'خطایی ایجاد شده است';
                break;
        }

        return message;
    }
});


function redirectToBehHost(){
    $('#redirectToBeHost').attr('value', 'true');
    $('#redirectToPreInvoice').attr('value', 'false');
}

function redirectToPreInvoice() {
    $('#redirectToPreInvoice').attr('value', 'true');
    $('#redirectToBeHost').attr('value', 'false');
}


$(document).ready(function() {
        $("#div-forms").css("height", "auto");
}
);
// function msgChange($divTag, $iconTag, $textTag, $divClass, $iconClass, $msgText) {
//     var $msgOld = $divTag.text();
//     msgFade($textTag, $msgText);
//     $divTag.addClass($divClass);
//     $iconTag.removeClass("glyphicon-chevron-right");
//     $iconTag.addClass($iconClass + " " + $divClass);
//     setTimeout(function() {
//         msgFade($textTag, $msgOld);
//         $divTag.removeClass($divClass);
//         $iconTag.addClass("glyphicon-chevron-right");
//         $iconTag.removeClass($iconClass + " " + $divClass);
// 	}, $msgShowTime);
// }

// function msgFade ($msgId, $msgText) {
//     $msgId.fadeOut($msgAnimateTime, function() {
//         $(this).text($msgText).fadeIn($msgAnimateTime);
//     });
// }