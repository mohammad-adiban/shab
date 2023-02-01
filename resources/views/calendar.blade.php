
<div class="bookingModal-item" style="margin: 0">
    <div class="inputBox" id="mobileCalendar" style="border: none">

        <!-- BEGIN CALENDAR -->
        <span class="calendar-container">
            <div class="calendar-content">

                <div class="calendar-header" style="margin: 0">
                    <div style="margin-bottom: 12px">
                        <span id="bookingModalClose" class="close hidden-md hidden-lg">&times;</span>

                        <span class="calendar-reset-btn">
                            <span class="glyphicon glyphicon-refresh"></span>
                            <span>انتخاب مجدد</span>
                        </span>

                    </div>

                    <div class="calendar-arrival-departure-date">
                        <div class="calendar-arrival-date">تاریخ رفت</div>
                        <div><span class="glyphicon glyphicon-chevron-left"></span></div>
                        <div class="calendar-departure-date">تاریخ برگشت</div>
                    </div>

                     <hr style="margin: 12px 0;" />

                    <div>
                        <div class="calendar-change-month previousMonth" style="visibility: hidden"><span class="glyphicon glyphicon-menu-right"></span></div>
                        <b><div class="monthName"><span>مهرماه</span></div></b>
                        <div class="calendar-change-month nextMonth"><span class="glyphicon glyphicon-menu-left"></span></div>
                    </div>
                </div>

                <div class="calendar-body">
                    <div id="daysOfWeek" class="calendar-day-row">
                        <span data="0">ش</span>
                        <span data="1">ی</span>
                        <span data="2">د</span>
                        <span data="3">س</span>
                        <span data="4">چ</span>
                        <span data="5">پ</span>
                        <span data="6">ج</span>
                    </div>

                    <div class="spinner calendarLoading">
                        <div class="bounce1"></div>
                        <div class="bounce2"></div>
                        <div class="bounce3"></div>
                    </div>
                </div>

                <div class="calendar-footer">
                    <div class="calendar-price-tip">* قیمت‌  به هزار تومان</div>
                    <div class="calendar-bookedDays"></div>
                </div>
            </div>
        </span>
        <!-- END CALENDAR -->

    </div>
</div>

<hr style="margin: 7px 15px;" />

<!-- BEGIN GUEST COUNT-->
<div class="bookingModal-item guest-count-container">
    <div class="inputBox">
        <div class="guest-count-title">
            <b style="font-size: 14px; font-weight: 500">تعداد مهمان‌ها</b>
            <span class="okAccommodates"></span>
        </div>
    </div>

    <div class="inputBox">
        <span class="guest-btn guestUp"><i class="fa fa-plus"></i></span>
        <input class="guestsCount" value="0" max="{{$house->max_accommodates}}" readonly="readonly" hidden/>
        <span class="guestCountDisplay">۰</span>
        <span class="guest-btn guestDown guest-btn-disable"><i class="fa fa-minus"></i></span>
    </div>
</div>
<!-- END GUEST COUNT-->

<!-- BEGIN TOTAL PRICE -->
<div class="bookingModal-item booking-totalPrice-container">
    <div class="inputBox booking-totalPrice" style="display: none; margin: 0 10px; padding: 5px 0">
        <b style="font-size: 14px">قیمت نهایی</b>
        <b style="font-size: 14px"><span></span></b>
    </div>
    <div class="spinner totalPrice-loading" style="width: auto; margin: 0; padding: 0; display: none">
        <div class="bounce1"></div>
        <div class="bounce2"></div>
        <div class="bounce3"></div>
    </div>
</div>
<!-- END TOTAL PRICE -->

<!-- BEGIN SUBMIT -->
<div class="bookingModal-item">
    <button @if (Auth::guest())
                class="submitBtn-noLogin bookingModal-Btn" data-toggle="modal" data-target="#login-modal" onclick="redirectToPreInvoice()"
            @else
                class="submitBtn bookingModal-Btn"
            @endif
    >ثبت درخواست</button>
</div>
<!-- eND SUBMIT -->



