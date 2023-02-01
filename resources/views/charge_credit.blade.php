<!DOCTYPE html>
<html dir="rtl" lang="fa">
<head>

    <title>شب - افزایش اعتبار</title>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
	<script src="{{ asset('js/jquery.min.js') }}" type="text/javascript"></script>
	<script src="{{ asset('js/bootstrap.js') }}" type="text/javascript"></script>

    <link rel="stylesheet" type="text/css" href="{{ URL::asset('css/index.css?v=1.2') }}">
    <link rel="stylesheet" type="text/css" href="{{ URL::asset('css/bootstrap-rtl.css?v=1.2') }}">
	<link rel="stylesheet" href="{{ asset('css/font-awesome.css') }}">
    <link href="{{ URL::asset('css/charge_credit.css') }}" rel="stylesheet">

</head>
<body>

<main>
    <div class="container-fluid" style="padding-right: 15px">
        <div class="row">

            <div class="col-xs-12 col-md-8 col-md-offset-2">
                <div class="app-header"><img src="{{URL::asset('img/logo.png')}}" class="app-logo" alt="logo"></div>
            </div>

            <div class="col-xs-12 col-md-8 col-md-offset-2">
                <div class="card">
                    <div class="inoivce-summary-container">
                        <div>
                            <div class="order-summary">
                                <div><strong class="title">افزایش اعتبار کاربری به میزان {{$payment->amount * 1000}} تومان</strong><span
                                        class="date">{{$payment->created_at}}</span>
                                </div>
                                <div><span class="text-support">نام کاربر: {{$payment->user['name']}} {{$payment->user['family']}}</span></div>
                                <!-- <div><span class="text-support">شماره تماس: 09191190783</span></div> -->
                                <div class="divider"></div>
                                <div><h3 class="">قابل پرداخت<span class="amount">{{$payment->amount * 1000}} تومان</span></h3></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-xs-12 col-md-8 col-md-offset-2">
                <div class="card">
                    <div class="payments-container">
                        <div><strong class="title">لطفا شیوه پرداخت خود را تایید کنید</strong></div>
                        <div class="divider"></div>
                        <div class="method disabled">
                            <div class="method-name"><span>درگاه بانکی</span></div>
                            <div class="options">
                                <div class="gateway-option saman  active">
                                    <div class="gateway-button option"><img
                                            src="{{URL::asset('img/zarin.png')}}"
                                            role="presentation"><label>
                                        <div class="radio active"></div><span>زرین پال</span></label></div>
                                </div>
                            </div>
                            <div class="divider"></div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-xs-12 col-md-8 col-md-offset-2">
                <div class="actions">
                    <div>
                        <button type="button" onclick="redirectToApp()"><span>لغو صورت&zwnj;حساب</span></button>
                        <form action="{{$payment->url}}" method="post">
                            <button type="submit"><span>ادامه&zwnj; پرداخت</span></button>
                        </form>
                    </div>
                </div>
            </div>
            <div class="col-xs-12 col-md-8 col-md-offset-2">
                <div class="card">
                    <div class="inoivce-details-container">
                        <div>
                            <div class="order-details">
                                <div><strong class="title">جزئیات صورتحساب</strong></div>
                                <div class="table-row"><span>کد پیگیری</span><span>{{$payment->tracking}}</span></div>
                                <div class="table-row table-head"><span class="text-support">#</span><span
                                        class="text-support">شرح</span><span class="text-support">مبلغ (تومان)</span>
                                </div>
                                <div>
                                    <div class="table-row table-item"><span></span><span>افزایش اعتبار حساب کاربری به میزان {{$payment->amount * 1000}}</span><span>{{$payment->amount * 1000}}</span>
                                    </div>
                                </div>
                                <div class="divider"></div>
                                <div class="table-row table-summary"><span
                                        class="text-support">مجموع آیتم&zwnj;ها</span><span
                                        class="text-support">{{$payment->amount * 1000}}</span></div>
                                <div class="table-row table-summary"><span class="text-support">تخفیف</span><span
                                        class="text-support">0</span></div>
                                <div class="divider"></div>
                                <div class="table-row"><h3 class="">جمع کل</h3>
                                    <h3 class="amount">{{$payment->amount * 1000}} تومان</h3></div>
                            </div>
                        </div>
                    </div>
                </div>

            </div>


</main>

</body>

<script>
    function redirectToApp() {
        window.location = "shab:\/\/pay=false";
    }
</script>

</html>