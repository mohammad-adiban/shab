<!--include header-->
@include('header')

<div class="main-user">
    <div class="container room user-panel">
        <div class="col-sm-10 col-sm-offset-1 col-xs-12 padding-xs-0">
            <div class="col-xs-12 padding-xs-0" style="display: flex; flex-direction: column; align-items: center; margin-bottom: 3em;">
                <div class="col-xs-12 padding-0">
                    <!--Responsive table-->
                    <div class="table-responsive" style="border: none">
                        <!--Table element-->
                        <table class="table table-hover col-xs-12 padding-0" style="border-collapse: separate; border-spacing: 0 8px; empty-cells: hide;">
                            <!--Define headers-->
                            <tr>
                                <th class="col-xs-1 padding-xs-0" style="font-size: 12px; text-align: center; padding: 10px 0; border: 1px solid #eee; background-color: #eee;">شماره</th>
                                <th class="col-md-4 padding-xs-0" style="font-size: 13px; text-align: center; padding: 10px 0; border: 1px solid #eee;">تاریخ</th>
                                <th class="col-xs-4 padding-xs-0" style="font-size: 13px; text-align: center; padding: 10px 0; border: 1px solid #eee;">قیمت</th>
                                <th class="col-xs-3 padding-xs-0" style="font-size: 13px; text-align: center; padding: 10px 0; border: 1px solid #eee;">کد رهگیری</th>
                            </tr>
                            <!--Make payment items-->
                            <?php $i = 1 ?>
                            @foreach($payments as $payment)
                                <tr>
                                    <!--Row number-->
                                    <td class="col-xs-1 padding-xs-0" style="font-size: 12px; text-align: center; padding: 10px 0; border: 1px solid #eee; background-color: #eee">
                                        {{ $i }}
                                    </td>
                                    <!--Date-->
                                    <td class="col-md-4 padding-xs-0 payment-date" data="{{$payment->created_at}}" style="font-size: 13px; text-align: center; padding: 10px 0; border: 1px solid #eee;">

                                    </td>
                                    <!--Amount of payment-->
                                    <td class="col-xs-4 padding-xs-0" style="font-size: 13px; text-align: center; padding: 10px 0; border: 1px solid #eee;">
                                        <span>{{$payment->amount * 1000}}</span>
                                        <span> تومان </span>
                                    </td>
                                    <!--Tracking code-->
                                    <td class="col-xs-3 padding-xs-0" style="font-size: 13px; text-align: center; padding: 10px 0; border: 1px solid #eee;">
                                        {{$payment->tracking}}
                                    </td>
                                </tr>
                                <?php $i++ ?>
                            @endforeach
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!--background-color: #ffffff; box-shadow: 0px 1px 9px #d8d8d8;-->

<!--Convert Date to Jalaali format-->
<script type="text/javascript" src="{{ asset('js/moment.js') }}"></script>
<script type="text/javascript" src="{{ asset('js/moment-jalaali.js') }}"></script>
<script>
    $('.payment-date').each(function() {
        $(this).text(digitsToHindi(moment($(this).attr('data'), 'YYYY-MM-DD HH:mm:ss').format("jYYYY/jMM/jDD")));
    });
</script>
