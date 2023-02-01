@include('header')

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
            <!-- Begin # Lost Password Form -->
            <form class="lost-form">
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
                                <input type="text" placeholder="شماره تلفن همراه" class="form-control form-control-customized lost-phoneNumber" maxlength="11">
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
                        <label class="col-xs-7">ورود به حساب کاربری</label>
                        <a href="/login" class="col-xs-5 btn">وارد شوید</a>
                    </div>
                    <!-- End # Lost Password Link To Login Form -->
                </div>
                <!-- End # Lost Password Form Footer -->
            </form>
            <!-- End # Lost Password Form -->
        </div>
        <!-- End # DIV Form -->
    </div>
</div>
<!-- END # LOGIN -->

@include('footer')
