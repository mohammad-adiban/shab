<head>
    <link rel="stylesheet" type="text/css" href="{{ URL::asset('css/signinup.css?v=0.0.1') }}">
</head>

<body>

<!-- HIDDEN INPUTS FOR REDIRECT FORMS-->
<input id="redirectToBeHost" type="checkbox" value="false" style="display: none">
<input id="redirectToPreInvoice" type="checkbox" value="false" style="display: none;">

<!-- BEGIN # MODAL LOGIN -->
<div class="modal fade" id="login-modal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" style="display: none;">
    <div class="modal-dialog">
        <div class="modal-content">

            <!-- Begin # Header Of Modal -->
            <div class="modal-header" align="center">
                <!-- Begin # Logo -->
                <!--<img id="img_logo" src="https://shab.ir/img/landing_page/logo-header.png">-->
                <!-- End # Logo -->

                <!-- Begin # Close Button -->
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span class="glyphicon glyphicon-remove" aria-hidden="true"></span>
                </button>
                <!-- End # Close Button -->
            </div>
            <!-- End # Header Of Modal -->

            <!-- Begin # DIV Form -->
            <div id="div-forms">
                <!-- Begin # Login Form -->
                <form class="login-form" style="display: block">
                    <div class="modal-body">
                        <!-- Begin # Login Form Header -->
                        <div class="header-forms">
                            <h3>ورود</h3>
                            <span>ورود به حساب کاربری</span>
                        </div>
                        <!-- End # Login Form Header -->

                        <!-- Begin # Login Error Alert | Fill By JS -->
                        <div class="alert alert-danger" style="display: none">

                        </div>
                        <!-- End # Login Error Alert -->

                        <!-- Begin # Login Phone Number -->
                        <div>
                            <span class="input-group">
                                <input type="text" placeholder="شماره موبایل (******09)" class="form-control form-control-customized login-phoneNumber" maxlength="11">
                                <span class="input-group-addon">
                                    <span class="glyphicon glyphicon-phone"></span>
                                </span>
                            </span>
                            <div class="error-class-msg">

                            </div>
                        </div>
                        <!-- End # Login Phone Number -->

                        <!-- Begin # Login Password -->
                        <div>
                            <span class="input-group">
                                <input type="password" placeholder="کلمه عبور" class="form-control form-control-customized login-password">
                                <span class="input-group-addon">
                                    <span class="glyphicon glyphicon-lock"></span>
                                </span>
                            </span>
                            <div class="error-class-msg">

                            </div>
                        </div>
                        <!-- End # Login Password -->

                        <!-- Begin # Login Remember Me -->
                        <div class="checkbox">
                            <label>
                                <input class="login-rememberMe" type="checkbox" value="false"> مرا بخاطر بسپار
                            </label>
                        </div>
                        <!-- End # Login Remember Me -->

                        <!-- Begin # Login Link To Lost Password Form -->
                        <div style="margin-top: 15px; font-size: 13px">
                            <span>کلمه عبور را فراموش کرده‌اید؟</span>
                            <span id="login_lost_btn" style="font-weight: 600; color: #1c61ae; cursor: pointer">بازیابی کلمه عبور</span>
                        </div>
                        <!-- End # Login Link To Lost Password Form -->
                    </div>

                    <!-- Begin # Login Form Footer -->
                    <div class="modal-footer">
                        <!-- Begin # Login Submit Button -->
                        <div>
                            <button type="submit" class="btn btn-customized btn-lg btn-block login-submit-btn">ورود</button>
                        </div>
                        <!-- End # Login Submit Button -->

                        <!-- Begin # Login Link To Register Form -->
                        <div class="switch-btn-container">
                            <label class="col-xs-7" for="login_register_btn">ایجاد حساب کاربری جدید</label>
                            <button type="button" class="col-xs-5 btn" id="login_register_btn">ثبت‌‌نام کنید</button>
                        </div>
                        <!-- End # Login Link To Register Form -->
                    </div>
                    <!-- End # Login Form Footer -->
                </form>
                <!-- End # Login Form -->


                <!-- Begin # Lost Password Form -->
                <form class="lost-form" style="display:none;">
                    <div class="modal-body">
                        <!-- Begin # Lost Password Form Header -->
                        <div class="header-forms">
                            <h3>بازیابی کلمه عبور</h3>
                            <span>با وارد کردن شماره موبایل، کلمه عبور را بازیابی نمایید</span>
                        </div>
                        <!-- End # Lost Password Form Header -->

                        <!-- Begin # Lost Password Error Alert | Fill By JS -->
                        <div class="alert alert-danger" style="display: none">

                        </div>
                        <!-- End # Lost Password Error Alert -->

                        <!-- Begin # Lost Password Success Alert -->
                        <div class="alert alert-success" style="display: none">
                            <span>لینک بازیابی رمزعبور برای شما پیامک گردید.</span>
                        </div>
                        <!-- End # Lost Password Success Alert -->

                        <!-- Begin # Lost Password Phone Number -->
                        <div>
                            <span class="input-group">
                                <input type="text" placeholder="شماره موبایل (******09)" class="form-control form-control-customized lost-phoneNumber" maxlength="11">
                                <span class="input-group-addon"> <span class="glyphicon glyphicon-phone"></span></span>
                            </span>
                            <div class="error-class-msg">

                            </div>
                        </div>
                        <!-- End # Lost Password Phone Number -->
                    </div>

                    <!-- Begin # Lost Password Form Footer -->
                    <div class="modal-footer">
                        <!-- Begin # Lost Password Submit Button -->
                        <div>
                            <button type="submit" class="btn btn-customized btn-lg btn-block lost-submit-btn">ارسال</button>
                        </div>
                        <!--End # Lost Password Submit Button -->

                        <!-- Begin # Lost Password Link To Login Form -->
                        <div class="switch-btn-container">
                            <label class="col-xs-7" for="lost_login_btn">ورود به حساب کاربری</label>
                            <button type="button" class="col-xs-5 btn" id="lost_login_btn">وارد شوید</button>
                        </div>
                        <!-- End # Lost Password Link To Login Form -->
                    </div>
                    <!-- End # Lost Password Form Footer -->
                </form>
                <!-- End # Lost Password Form -->


                <!-- Begin # Register Form -->
                <form class="register-form" style="display:none;">
                    <div class="modal-body">
                        <!-- Begin # Register Form Header -->
                        <div class="header-forms">
                            <h3>ثبت‌نام</h3>
                            <span>ایجاد حساب کاربری جدید</span>
                        </div>
                        <!-- End # Register Form Header -->

                        <!-- Begin # Register Error Alert | Fill By JS -->
                        <div class="alert alert-danger" style="display: none">

                        </div>
                        <!-- End # Register Error Alert -->

                        <!-- Begin # Register First Name -->
                        <div>
                            <span class="input-group">
                                <input type="text" placeholder="نام" class="form-control form-control-customized register-firstName">
                                <span class="input-group-addon">
                                    <span class="glyphicon glyphicon-user"></span>
                                </span>
                            </span>
                            <div class="error-class-msg">

                            </div>
                        </div>
                        <!-- End # Register First Name -->

                        <!-- Begin # Register Last Name -->
                        <div>
                            <span class="input-group">
                                <input type="text" placeholder="نام خانوادگی" class="form-control form-control-customized register-lastName">
                                <span class="input-group-addon">
                                    <span class="glyphicon glyphicon-user"></span>
                                </span>
                            </span>
                            <div class="error-class-msg">

                            </div>
                        </div>
                        <!-- End # Register Last Name -->

                        <!-- Begin # Register Phone Number -->
                        <div>
                            <span class="input-group">
                                <input type="text" placeholder="شماره موبایل (******09)" class="form-control form-control-customized register-phoneNumber" maxlength="11">
                                <span class="input-group-addon">
                                    <span class="glyphicon glyphicon-phone"></span>
                                </span>
                            </span>
                            <div class="error-class-msg">

                            </div>
                        </div>
                        <!-- End # Register Phone Number -->

                        <!-- Begin # Register Password -->
                        <div>
                            <span class="input-group">
                                <input type="password" placeholder="انتخاب کلمه عبور" class="form-control form-control-customized register-password">
                                <span class="input-group-addon">
                                    <span class="glyphicon glyphicon-lock"></span>
                                </span>
                            </span>
                            <div class="error-class-msg">

                            </div>
                        </div>
                        <!-- End # Register Password-->

                        <!-- Begin # Register Email -->
                        <div>
                            <span class="input-group">
                                <input type="text" placeholder="ایمیل (اختیاری)" class="form-control form-control-customized register-email">
                                <span class="input-group-addon">
                                    <span class="glyphicon glyphicon-envelope"></span>
                                </span>
                            </span>
                            <div class="error-class-msg">

                            </div>
                        </div>
                        <!-- End # Register Email -->
                    </div>

                    <!-- Begin # Register Form Footer -->
                    <div class="modal-footer">
                        <!-- Begin # Register Submit Button -->
                        <div>
                            <button type="submit" class="btn btn-customized btn-lg btn-block register-submit-btn">ثبت‌نام</button>
                        </div>
                        <!-- End # Register Submit Button -->

                        <!-- Begin # Register Link To Login Form -->
                        <div class="switch-btn-container">
                            <label class="col-xs-7" for="register_login_btn">ورود به حساب کاربری</label>
                            <button type="button" class="col-xs-5 btn" id="register_login_btn">وارد شوید</button>
                        </div>
                        <!-- End # Register Link To Login Form -->
                    </div>
                    <!-- End # Register Form Footer -->
                </form>
                <!-- End # Register Form -->


                <!-- Begin # Activation Code Form -->
                <form class="activationCode-form" style="display:none;">
                    <div class="modal-body">
                        <!-- Begin # Activation Code Form Header -->
                        <div class="header-forms">
                            <h3>کد فعالسازی</h3>
                            <span>کد فعالسازی ارسال شده به شماره </span>
                            <span class="activationCode-phoneNumber" style="color: #126ed6;"></span>
                            <span> را وارد نمایید</span>
                        </div>
                        <!-- End # Activation Code Form Header -->

                        <!-- Begin # Activation Code Error Alert -->
                        <div class="alert alert-danger" style="display: none">

                        </div>
                        <!-- End # Activation Code Error Alert -->

                        <!-- Begin # Activation Code, Code -->
                        {{--<div>--}}
                            {{--<span class="input-group">--}}
                                {{--<input type="text" style="background: #fff" class="form-control form-control-customized activationCode-phoneNumber" maxlength="11" disabled>--}}
                                {{--<span class="input-group-addon">--}}
                                    {{--<span class="glyphicon glyphicon-phone"></span>--}}
                                {{--</span>--}}
                            {{--</span>--}}
                            {{--<div class="error-class-msg">--}}

                            {{--</div>--}}
                        {{--</div>--}}
                        <!-- End # Activation Code, Code -->

                        <!-- Begin # Activation Code, Code -->
                        <div>
                            <span class="input-group">
                                <input type="text" placeholder="کد فعالسازی" class="form-control form-control-customized activationCode-code" maxlength="5">
                                <span class="input-group-addon">
                                    <span class="glyphicon glyphicon-phone"></span>
                                </span>
                            </span>
                            <div class="error-class-msg">

                            </div>
                        </div>
                        <!-- End # Activation Code, Code -->
                    </div>

                    <!-- Begin # Activation Code Form Footer -->
                    <div class="modal-footer">
                        <!-- Begin # Activation Code Submit Button -->
                        <div>
                            <button type="submit" class="btn btn-customized btn-lg btn-block activationCode-submit-btn">تایید</button>
                        </div>
                        <!-- End # Activation Code Submit Button -->

                        <!-- Begin # Activation Code Resend Timer -->
                        <div  id="activationCode-timer-container">
                            <span>حداکثر تا </span>
                            <span id="activationCode-timer"></span>
                            <span>ثانیه دیگر برای شما ارسال می‌شود</span>
                        </div>
                        <!-- End # Activation Code Resend Timer-->

                        <!-- Begin # Activation Code Link to Register -->
                        <div class="switch-btn-container">
                            <label class="col-xs-7" for="activationCode_register_btn">ویرایش اطلاعات</label>
                            <button type="button" class="col-xs-5 btn activationCode_register_btn">بازگشت</button>
                        </div>
                        <!-- End # Activation Code Link to Register -->
                    </div>
                    <!-- End # Activation Code Form Footer -->
                </form>
                <!-- End # Activation Code Form -->

            </div>
            <!-- End # DIV Form -->
        </div>
    </div>
</div>
<!-- END # MODAL LOGIN -->

<script src="{{ asset('js/signinup.js?v=0.0.1') }}" type="text/javascript"></script>

</body>