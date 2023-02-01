<?php SEO::setTitle('ثبت نام'); ?>
<?php if(!isset($_GET['loginObj'])) { ?>
@include('header')
<?php } ?>
<!-- BEGIN # REGISTER -->
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

            <!-- Begin # Register Form -->
            <form class="register-form" style="display:block;">
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
                            <input type="password" placeholder="کلمه عبور" class="form-control form-control-customized register-password">
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
                        <a href="/login" class="col-xs-7">ورود به حساب کاربری</a>
                        <a href="/login" class="col-xs-5 btn">وارد شوید</a>
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
<!-- END # REGISTER -->

<?php if(!isset($_GET['loginObj'])) { ?>
@extends('footer')
<?php } ?>