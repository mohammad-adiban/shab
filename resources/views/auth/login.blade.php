<?php SEO::setTitle('ورود'); ?>
<?php if(!isset($_GET['loginObj'])) { ?>
@include('header')
<?php } ?>

<!-- BEGIN # LOGIN -->
<div class="modal-dialog">
    <div class="modal-content" style="margin: 130px auto 40px auto; box-shadow: none; border-radius: 0">

        <!-- Begin # Header Of Modal -->
        <div class="modal-header" align="center">
            <!-- Begin # Logo -->
            <!--<img id="img_logo" src="https://shab.ir/img/landing_page/logo-header.png">-->
            <!-- End # Logo -->

            <!-- Begin # Close Button -->
        {{--<button type="button" class="close" data-dismiss="modal" aria-label="Close">--}}
        {{--<span class="glyphicon glyphicon-remove" aria-hidden="true"></span>--}}
        {{--</button>--}}
        <!-- End # Close Button -->
        </div>
        <!-- End # Header Of Modal -->

        <!-- Begin # DIV Form -->
        <div id="div-formsPage" style="height: auto !important;">
            <!-- Begin # Login Form -->
            <form class="login-form" method="POST">
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
                        <a href="/password/sms" style="font-weight: 600; color: #1c61ae; cursor: pointer; text-decoration: none">بازیابی کلمه عبور</a>
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
                        <a href="/register" class="col-xs-7">ایجاد حساب کاربری جدید</a>
                        <a href="/register" class="col-xs-5 btn">ثبت‌‌نام کنید</a>
                    </div>
                    <!-- End # Login Link To Register Form -->
                </div>
                <!-- End # Login Form Footer -->
            </form>
            <!-- End # Login Form -->
        </div>
        <!-- End # DIV Form -->
    </div>
</div>
<!-- END # LOGIN -->

<?php if(!isset($_GET['loginObj'])) { ?>
@extends('footer')
<?php } ?>
