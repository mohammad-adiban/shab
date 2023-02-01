<!DOCTYPE html>
<html dir="rtl" lang="fa">
<head>

    <title>شب - رسید پرداخت</title>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <script src="{{ asset('js/jquery.min.js') }}" type="text/javascript"></script>
    <script src="{{ asset('js/bootstrap.js') }}" type="text/javascript"></script>
    <script src="{{ asset('js/all.js?v=1.6.9') }}" type="text/javascript"></script>

    <link rel="stylesheet" type="text/css" href="{{ URL::asset('css/index.css?v=1.2') }}">
    <link rel="stylesheet" type="text/css" href="{{ URL::asset('css/bootstrap-rtl.css?v=1.2') }}">
    <link rel="stylesheet" href="{{ asset('css/font-awesome.css') }}">
    <link href="{{ URL::asset('css/charge_credit.css') }}" rel="stylesheet">


</head>
<body>


<main>

    <?php
    preg_match("/[^\/]+$/", $_SERVER['REQUEST_URI'], $matches);
        $type = explode('?', $matches[0])[0];
        $isWeb = true;
        if($type == 'app')
            $isWeb = false;
    ?>

    <div class="container-fluid" style="padding-right: 15px">
        <div class="row">

            <input id="isWeb" value="<?php echo $isWeb; ?>" hidden>

            <div class="col-xs-12 col-md-8 col-md-offset-2">
                <div class="app-header"><img src="{{URL::asset('img/logo.png')}}" class="app-logo" alt="logo"></div>
            </div>

            @if($payment->verified != 0)
                <div class="col-xs-12 col-md-8 col-md-offset-2">
                    <div class="flash success"><div class="error text-center">صورت حساب با موفقیت پرداخت شد.</div></div>
                    <script>
                        ga('require', 'ecommerce');
                        ga('ecommerce:addTransaction', {
                          'id': "{{$payment->invoice_id}}",
                          'affiliation': 'Shab',
                          'revenue': "{{10000 * 0.1 * $payment->invoice->total_fee}}",
                          'shipping': "{{10000 * $payment->invoice->total_fee}}",
                          'tax': '0'
                        });

                        ga('ecommerce:addItem', {
                          'id': "{{$payment->invoice_id}}",
                          'name': "{{$payment->invoice->house->title}}",
                          'sku': "{{$payment->invoice->house->id}}",
                          'category': "{{$payment->invoice->house->province}}",
                          'price': "{{$payment->invoice->total_fee}}",
                          'quantity': "{{$payment->invoice->house->id}}",
                          'currency': 'IRR'
                        });

                        ga('ecommerce:send');
                        ga('ecommerce:clear');

                    </script>
                </div>




            @else
                <div class="col-xs-12 col-md-8 col-md-offset-2">
                    <div class="flash error"><div class="error text-center">پرداخت به درخواست شما لغو شد.</div></div>
                </div>

            @endif


            <div class="col-xs-12 col-md-8 col-md-offset-2">
                <div class="actions">
                    <div>
                        <div class="countdown">
                            <div class="countdown-number">۱۰</div>
                            <svg>
                                <circle r="18" cx="20" cy="20"></circle>
                            </svg>
                            <?php if($isWeb) { ?>
                                <span class="countdown-text">ثانیه دیگر به صفحه رسید منتقل خواهید شد</span>
                            <?php } else { ?>
                                <span class="countdown-text">ثانیه دیگر به برنامه منتقل خواهید شد</span>
                            <?php }?>
                        </div>

                        <form method="DELETE" action="">
                            <button type="button" onclick="stay1()" id="stayinpage"><span>ماندن در صفحه</span></button>
                        </form>
                        <form method="POST" action="">
                            <?php if($isWeb) { ?>
                                <button type="button" onclick="redirect(true)"><span>مشاهده رسید</span></button>
                            <?php } else { ?>
                                <button type="button" onclick="redirect(false)"><span>بازگشت به برنامه</span></button>
                            <?php }?>
                        </form>
                    </div>
                </div>
            </div>
            <div class="col-xs-12 col-md-8 col-md-offset-2">
                <div>

                </div>
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
        </div>
    </div>
</main>

<script>
    var stay = false;
    function stay1() {
        stay = true;
    }

    var status = "{{$payment->verified}}";
    if (status === 0) {
        status = 'false';
    }

    else {
        status = 'true';
    }

    var isWeb =  $('#isWeb').val();












    window.setInterval(function () {
        var num = parseInt(digitsToLatin($(".countdown-number").text()));
        if (num == 0) {
        if (!stay) {
                console.log(isWeb)
                if(isWeb) {
                    redirect(true);
                } else {
                    redirect(false);
                }
            }
        }
        else {
            $(".countdown-number").text(digitsToHindi(num - 1));
        }

    }, 1000);

    function redirect(isWeb) {
        if(isWeb) {
            window.location.href = "/invoices/{{$payment->invoice_id}}/show";
        } else {
            window.location.href = "shab:\/\/pay=" + status;
        }
    }

</script>

</body>
</html>

