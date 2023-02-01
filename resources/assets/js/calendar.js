/* #####################################################################
   #
   #   Project       : CALENDAR SHAB.IR
   #   Author        : Amir Hossein Khosravani
   #   Version       : 1.0
   #
   ##################################################################### */

$(function() {

    const $formatDate = 'YYYY-MM-DD';
    const $formatJalaliDate = 'jYYYY-jMM-jDD';
    const $dayLengthTimeStamp = 24*60*60*1000;
    const $minDisableClass = 'calendar-day-minDisable';
    const $disableDaysClass = 'calendar-day-disable';
    const $monthIndex = {
        0: 'فروردین',
        1: 'اردیبهشت',
        2: 'خرداد',
        3: 'تیر',
        4: 'مرداد',
        5: 'شهریور',
        6: 'مهر',
        7: 'آبان',
        8: 'آذر',
        9: 'دی',
        10: 'بهمن',
        11: 'اسفند'
    };
    const $dayOfTheWeekIndex = {
        0: 'شنبه',
        1: 'یک‌شنبه',
        2: 'دوشنبه',
        3: 'سه‌شنبه',
        4: 'چهارشنبه',
        5: 'پنج‌شنبه',
        6: 'جمعه'
    };


    var $jalaaliDate = getCurrentJalaaliDate();
    var $tempJalaaliDate = $jalaaliDate;
    var $todayTimeStamp = $jalaaliDate.valueOf();
    var $arrivalDate = false;
    var $departureDate = false;
    var $minBookingDayCount = $('#ruleMinimumDays').val();
    var $disableDays = [];
    var $priceDays = [];
    var $peakDays = [];
    var $minPrice = $('#minPrice').val();
    var $medianPrice = $('#medianPrice').val();
    var $maxPrice = $('#maxPrice').val();

    var $inProgress = true;

    $(document).ready(function() {
        $('.calendar-arrival-date').addClass('active');

        if($(window).width() > 993) {
            //Reset Jalaali date
            $jalaaliDate = getCurrentJalaaliDate();
            $tempJalaaliDate = getCurrentJalaaliDate();
            $('.previousMonth').css('visibility', 'hidden');


            //Remove months
            $('.calendar-month').remove();

            //Reset disable days
            $disableDays = [];

            //Show calendar
            $(".calendar-container").css('visibility', 'visible');

            //Make current jalaali month
            getDisableDays();

            //Show minimum booking days
            $('.calendar-bookedDays').html('حداقل مدت رزرو: ' + digitsToHindi($minBookingDayCount) + ' شب')
        }

        //Show calendar
        $("#bookingBtn").click(function (e) {
            //No action for Clicking on child
            if (e.target !== this) {
                return;
            }
            //
            else {
                $inProgress = true;

                //Reset Jalaali date
                $jalaaliDate = getCurrentJalaaliDate();
                $tempJalaaliDate = getCurrentJalaaliDate();
                $('.previousMonth').css('visibility', 'hidden');


                //Remove months
                $('.calendar-month').remove();

                //Reset disable days
                $disableDays = [];

                //Show calendar
                $(".calendar-container").css('visibility', 'visible');

                //Make current jalaali month
                getDisableDays();

                //Show minimum booking days
                $('.calendar-bookedDays').html('حداقل مدت رزرو: ' + digitsToHindi($minBookingDayCount) + ' شب')
            }
        });

        //Next month button
        $('.nextMonth').click(function (e) {
            if(!$inProgress) {
                $inProgress = true;

                //Hide current Jalaali month
                $('.month-' + $tempJalaaliDate.jMonth() + '-' + $tempJalaaliDate.jYear()).css('display', 'none');

                //Going one month ahead
                $tempJalaaliDate.add(1, 'jMonth');

                //Show previous month button
                $('.previousMonth').css('visibility', 'visible');


                if ($('.month-' + $tempJalaaliDate.jMonth() + '-' + $tempJalaaliDate.jYear()).length !== 0) {
                    //Show next Jalaali month
                    $('.month-' + $tempJalaaliDate.jMonth() + '-' + $tempJalaaliDate.jYear()).css('display', '');
                    $inProgress = false;
                }
                else {
                    //Make new Jalaali month
                    getDisableDays();
                }

                //Set month name
                setMonthName($tempJalaaliDate.jMonth(), $tempJalaaliDate.jYear());
            }
        });

        //Previous month button
        $('.previousMonth').click(function () {
            //Hide current Jalaali month
            $('.month-'+$tempJalaaliDate.jMonth()+'-'+$tempJalaaliDate.jYear()).css('display', 'none');

            //Going one month ago
            $tempJalaaliDate.subtract(1, 'jMonth');

            if($('.month-'+$tempJalaaliDate.jMonth()+'-'+$tempJalaaliDate.jYear()).length !== 0) {
                $('.month-' + $tempJalaaliDate.jMonth() + '-' + $tempJalaaliDate.jYear()).css('display', '');
                if($arrivalDate) {
                    var tmp = $tempJalaaliDate;
                    tmp.endOf('jMonth');
                    tmp.startOf('day');
                    tmp = moment.utc(tmp).valueOf();
                    if($arrivalDate <= tmp )
                        rangeOfArrivalAndDepartureDate($('.' + tmp ))
                }
            }

            //Hide previous month button
            if($tempJalaaliDate.jMonth() === getCurrentJalaaliDate().jMonth()) {
                $('.previousMonth').css('visibility', 'hidden');
            }

            //Set month name
            setMonthName($tempJalaaliDate.jMonth(), $tempJalaaliDate.jYear());
        });


        //Reset arrival and departure date button
        $('.calendar-reset-btn').click(function () {
            //Reset arrival & departure date
            resetArrivalAndDepartureDate();
        });


        $('.submitBtn, .submitBtn-noLogin').click(function(e) {
            var countInput = '.guestsCount';
            var sSelector = '.calendar-arrival-date';
            var eSelector = ".calendar-departure-date";
            if($(sSelector).html() === 'تاریخ رفت' || $(eSelector).html() === 'تاریخ برگشت') {
                setTimeout(
                    function()
                    {
                        alert('ابتدا تاریخ رفت و برگشت را مشخص کنید');
                    }, 270);
                return false;
            }
            else if($(countInput).val() === '0') {
                setTimeout(
                    function()
                    {
                        alert('تعداد مهمان را مشخص نمایید');
                    }, 270);
                return false;
            }
            else {
                if($(this).hasClass('submitBtn')) {
                    $('#payform').submit();
                }
            }
        });
    });

    //Get current Jalaali date
    function getCurrentJalaaliDate() {
        //Current jalaali date | Jalaali date string
        var date = moment.utc();

        date = date.format($formatJalaliDate);

        //Current jalaali date | Jalaali date object
        date = moment.utc(date, $formatJalaliDate);

        return date
    }






    /*-----------------------------------
        * Month:
        *
        * #1 Calculate month length
        * #2 Day of the week index for first day pf the week
        * #3 Make month component
    *-----------------------------------*/
    // #1 Calculate month length
    function countOfDaysOfTheMonth(monthIndex, yearIndex) {
        if(monthIndex >= 0 && monthIndex <= 5) {
            return 31;
        }
        else if(monthIndex >= 6 && monthIndex <= 10) {
            return 30;
        }
        else if(monthIndex === 11) {
            return moment.jDaysInMonth(yearIndex, 11);
        }
    }


    function goToFirstDayOfJalaaliMonth(date) {
        //Go to first day of current jalaali month
        date = date.startOf('jMonth');

        return date;
    }

    // #2 Day of the weeks of the first day of the month
    function getFirstDayOfMonth(date) {
        //First day of current jalaali month | Jalaali date string
        date = date.format($formatJalaliDate);

        //First day of current jalaali month | Date string
        date = moment(date, $formatJalaliDate).format($formatDate);

        return date;
    }

    function getIndexFirstDayOfTheMonth(date) {
        //Index day of week
        date = (parseInt(moment(date, $formatDate).format('d')) + 1) % 7;

        return date;
    }

    // #3 Make month component
    function calendarMonth() {
        var monthIndex = $jalaaliDate.jMonth(); //Index of the month
        var yearIndex = $jalaaliDate.jYear(); //Index of the year

        var dateOfFirstDayOfTheMonth = goToFirstDayOfJalaaliMonth($jalaaliDate);

        var indexFirstDayOfTheMonth = getIndexFirstDayOfTheMonth(getFirstDayOfMonth(dateOfFirstDayOfTheMonth)); //Index day of the week for first day of the month

        var monthLength = countOfDaysOfTheMonth(monthIndex, yearIndex); //Length of month
        var weekCountInMonth = Math.ceil((monthLength + indexFirstDayOfTheMonth) / 7); //How many weeks there is in the month

        //Set month name
        setMonthName(monthIndex, yearIndex);

        $('.calendar-body').append('<div class="calendar-month month-'+monthIndex+'-'+yearIndex+'"></div>');

        //Make weeks of month
        for (var weekIndex = 0; weekIndex < weekCountInMonth; weekIndex++){
            //Set day of the week index for first day of the week
            var indexOfFirstDayOfTheWeek = (weekIndex === 0) ? indexFirstDayOfTheMonth : 0;

            //Set day of the month index for first day of the week
            var dayOfMonth = Math.max(0, (weekIndex*7)-indexFirstDayOfTheMonth);

            //Set day of the week index for last day of the week
            var indexOfLastDayOfTheWeek = (weekIndex === weekCountInMonth-1) ? (monthLength - (dayOfMonth)) : 7;


            calendarWeek
            (
                yearIndex,
                monthIndex,
                weekIndex,
                indexOfFirstDayOfTheWeek,
                indexOfLastDayOfTheWeek,
                dayOfMonth,
                dateOfFirstDayOfTheMonth
            );
        }

        //Find today & previous day
        findTodayDate();

        //Find arrival & departure date
        findArrivalAndDepartureDate();

        //Find min booking days
        findMinimumBookingDays();

        setDisableDay();

        setPriceForPeakDays();

        setPriceForDisabledDays();

        //Set jQuery Event Methods
        setJQueryEventMethods('.month-'+monthIndex+'-'+yearIndex);
    }

    function setMonthName(monthIndex, yearIndex) {
        //Set month name
        $('.monthName').html($monthIndex[monthIndex] + ' ' + digitsToHindi(yearIndex));
    }
    /*----------------- END -----------------*/







    //Make week
    function calendarWeek(yearIndex, monthIndex, weekIndex, indexOfFirstDayOfTheWeek, indexOfLastDayOfTheWeek, dayOfMonth, timeStamp) {
        //Make week component
        $('.month-'+monthIndex+'-'+yearIndex).append(weekComponent(yearIndex, monthIndex, weekIndex));

        //Make empty day items in start of month component
        for (var i = 0 ; i < indexOfFirstDayOfTheWeek; i++) {
            $('.week-'+weekIndex+'-'+monthIndex+'-'+yearIndex).append(emptyComponent(i));
        }

        //Make days of week
        for(var dayOfTheWeek = indexOfFirstDayOfTheWeek; dayOfTheWeek < indexOfLastDayOfTheWeek; dayOfTheWeek++) {
            dayOfMonth++;
            var dayPrice = (dayOfTheWeek < 4) ? $minPrice : $medianPrice;

            $('.week-'+weekIndex+'-'+monthIndex+'-'+yearIndex).append(dayComponent(dayOfMonth, dayOfTheWeek, moment.utc(timeStamp).valueOf(), dayPrice));
            timeStamp.add(1, 'day');
        }

        //Make empty day items in end of month component
        for (var j = indexOfLastDayOfTheWeek; j < 7; j++) {
            $('.week-'+weekIndex+'-'+monthIndex+'-'+yearIndex).append(emptyComponent(j));
        }

        return timeStamp;
    }

    //Week component
    function weekComponent(yearIndex, monthIndex, weekIndex) {
        var txt =
            (
                '<div class="calendar-day-row week-'+weekIndex+'-'+monthIndex+'-'+yearIndex+'">'+
                '</div>'
            );

        return txt;
    }



    //Day component
    function dayComponent(dayOfMonth, dayOfWeek, timeStamp, dayPrice) {
        var txt =
            (
                '<span class="calendar-day-item '+timeStamp+'" dayOfTheMonth="'+dayOfMonth+'" data="'+dayOfWeek+'">'+
                '<div class="calendar-day-item-date" >' + digitsToHindi(dayOfMonth) + '</div>'+
                '<div class="calendar-day-item-price">' + digitsToHindi(dayPrice) + '</div>'+
                '</span>'
            );

        return txt;
    }

    //Empty component
    function emptyComponent(dayOfWeek) {
        var txt =
            (
                '<span class="calendar-day-noItem" data="'+dayOfWeek+'">' +

                '</span>'
            );

        return txt;
    }





    //Find today and previous days
    function findTodayDate() {
        $('.'+$todayTimeStamp).addClass('calendar-day-today') //Add class for today
            .prevAll().addClass('calendar-day-past'); //Add class for previous day
        $('.'+$todayTimeStamp).parent().prevAll().find('.calendar-day-item').addClass('calendar-day-past'); //Add class for previous day
    }

    //Find arrival & departure date
    function findArrivalAndDepartureDate() {
        var arrivalDateElement = $('.' + $arrivalDate);
        var departureDateElement = $('.' + $departureDate);
        if(arrivalDateElement.length !== 0)
            if($arrivalDate) {
                rangeOfArrivalAndDepartureDate(departureDateElement);
            }
    }








    /*-----------------------------------
         * Booking Days:
         *
         * #1 Find
         * #2 Remove
         * #3 Calculate
     *-----------------------------------*/
    // #1 Find min booking days
    function findMinimumBookingDays() {
        //Remove min booking days
        removeMinBookingDays();

        //Disable min booking days
        for(var i=1; i<$minBookingDayCount; i++) {
            var date = parseInt($arrivalDate) + (i*$dayLengthTimeStamp);
            $('.' + date).addClass($minDisableClass);
        }
    }

    // #2 Remove min booking days
    function removeMinBookingDays() {
        $('.'+$minDisableClass).removeClass($minDisableClass);
    }

    // #3 Calculate the number of booked days
    function calculateBookedDays() {
        var bookedDaysTxt  = digitsToHindi(($departureDate - $arrivalDate) / $dayLengthTimeStamp) + ' ' + 'شب انتخاب شده';
        $('.calendar-bookedDays').html(bookedDaysTxt);
    }
    /*----------------- END -----------------*/







    /*-----------------------------------
          * Disable Days:
          *
          * #1 Get
          * #2 Find
          * #3 Remove
      *-----------------------------------*/
    // #1 Get disable days
    function getDisableDays() {
        //Show loading
        showLoadingBtnComponent('.calendarLoading');

        var dateOfFirstDayOfTheMonth = getFirstDayOfMonth(goToFirstDayOfJalaaliMonth($jalaaliDate));

        //Set request header
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        //Set form data
        var formData = {
            house: $('#houseIdCalendar').val()  ,
            start: dateOfFirstDayOfTheMonth
        };

        //Request
        $.ajax({
            contentType: 'application/x-www-form-urlencoded',
            type: "POST",
            url: "/calendars/show",
            data: formData,
            success: function (result) {
                var data = result.calendars;
                for(var i=0; i<data.length; i++) {
                    //Get timestamp
                    var time = moment.utc(data[i].date, $formatDate).valueOf();

                    //Check type of day
                    if(data[i].disabled === 1 || data[i].unavailable === 1) {
                        //Add to disabled days array
                        $disableDays.push(time);
                    } else {
                        //Add to price days array (Days that its price changed by hosts)
                        $priceDays.push(time + ',' + data[i].price);
                    }
                }

                //Get peak days
                getPeakDays(result.peak_days);

                //Make month
                calendarMonth();

                //Hide loading
                removeLoadingBtnComponent('.calendarLoading');

                //Change state of script
                $inProgress = false;
            },
            error: function (data) {

            }
        });
    }

    // #2 Find disable days
    function findDisableDays() {
        for(var i=0; i<$disableDays.length; i++) {
            $('.' + $disableDays[i]).addClass($disableDaysClass);
        }
    }

    // #3 Remove disable days
    function removeDisableDays() {
        $('.'+$disableDaysClass).removeClass($disableDaysClass);
    }

    // #3 Set Disable days
    function setDisableDay() {
        //Remove disable days
        removeDisableDays();

        //Find disable days
        findDisableDays();

        if(!$departureDate) {
            if ($arrivalDate) {
                var minDisableDay = false;
                for (var i = 0; i < $disableDays.length; i++) {
                    if ($disableDays[i] > parseInt($arrivalDate)) {
                        minDisableDay = $disableDays[i];
                        break;
                    }
                }

                if (minDisableDay) {
                    $('.' + minDisableDay).removeClass($disableDaysClass);
                    for (var j = minDisableDay + $dayLengthTimeStamp; j <= $('.calendar-day-item').last().attr('class').split(/\s+/)[1]; j+=$dayLengthTimeStamp) {
                        $('.'+j).addClass($disableDaysClass);
                    }
                }
            }
        }

    }
    function setPriceForDisabledDays() {
        for (var i = 0; i < $priceDays.length; i++) {
            $('.'+$priceDays[i].split(',')[0]).find('.calendar-day-item-price').html(digitsToHindi($priceDays[i].split(',')[1]))
        }
    }
    /*----------------- END -----------------*/







    function setJQueryEventMethods(monthId) {
        //Click on days
        $(monthId + ' .calendar-day-item:not(.calendar-day-past)').click(function () {
            //If the element that is clicked is not disabled
            if(!$(this).hasClass($minDisableClass) && !$(this).hasClass($disableDaysClass)) {
                //If arrival date had not been selected
                if(!$arrivalDate) {
                    //Set arrival date
                    $arrivalDate = selectArrivalAndDepartureDate($(this), 'arrival');

                    $('.calendar-arrival-date').removeClass('active');
                    $('.calendar-departure-date').addClass('active');

                    //Find min booking days
                    findMinimumBookingDays();

                    //
                    setDisableDay();
                }

                //Else if arrival date had been selected
                else {
                    //If the element that is clicked is before the current arrival date
                    if ($arrivalDate > $(this).attr('class').split(/\s+/)[1]) {
                        //Reset arrival & departure date
                        resetArrivalAndDepartureDate();

                        $('.calendar-arrival-date').removeClass('active');
                        $('.calendar-departure-date').addClass('active');

                        //Change arrival date
                        $arrivalDate = selectArrivalAndDepartureDate($(this), 'arrival');

                        //
                        findMinimumBookingDays();

                        //
                        setDisableDay();
                    }

                    //Else if the element that is clicked is after the arrival date
                    else if ($arrivalDate < $(this).attr('class').split(/\s+/)[1]) {

                        //If departure date had not been selected
                        if (!$departureDate) {
                            //Select departure date
                            $departureDate = selectArrivalAndDepartureDate($(this), 'departure');

                            $('.calendar-arrival-date').removeClass('active');
                            $('.calendar-departure-date').removeClass('active');

                            //
                            rangeOfArrivalAndDepartureDate($(this));

                            removeMinBookingDays();

                            //Calculate the number of days booked
                            calculateBookedDays();

                            //
                            setDisableDay();

                            totalPrice();
                        }

                        //Else if departure date had been selected
                        else {
                            //Reset arrival & departure date
                            resetArrivalAndDepartureDate();

                            $('.calendar-arrival-date').removeClass('active');
                            $('.calendar-departure-date').addClass('active');

                            //Change arrival date
                            $arrivalDate = selectArrivalAndDepartureDate($(this), 'arrival');

                            //
                            findMinimumBookingDays();

                            //
                            setDisableDay();
                        }
                    }
                }
            }
        });

        //Hover on days
        $(monthId + ' .calendar-day-item:not(.calendar-day-past)').hover(function () {
            //If the element that is hovered is not disabled
            if(!$(this).hasClass($minDisableClass) && !$(this).hasClass($disableDaysClass)  ) {
                //If arrival date is selected
                if ($arrivalDate && $arrivalDate < $(this).attr('class').split(/\s+/)[1] && !$departureDate) {
                    rangeOfArrivalAndDepartureDate($(this));
                }
            }
        });


        $(monthId + ' .calendar-day-item:not(.calendar-day-past)').on('mouseleave', function () {
            if(!$departureDate) {
                $('.calendar-day-item').removeClass('calendar-day-item-hover');
            }
        });
    }


    function selectArrivalAndDepartureDate(element, type) {
        var timeStamp = element.attr('class').split(/\s+/)[1];
        $('#'+type+'Calendar').val(timeStamp/1000);
        //Convert timeStamp to jalaali date string + day of the week
        var date = moment(parseInt(timeStamp)).utc().format('jYYYY/jMM/jDD');


        date = $dayOfTheWeekIndex[element.attr('data')] + '<br />' + date;

        //Active the element clicked
        activeArrivalAndDepartureDate(element);

        //Set date info
        $('.calendar-'+type+'-date').html(digitsToHindi(date));

        return timeStamp ;
    }

    //Change style of arrival & departure date
    function activeArrivalAndDepartureDate(element) {
        element.addClass('calendar-day-item-active');
    }

    function resetArrivalAndDepartureDate() {
        removeLoadingBtnComponent('.booking-totalPrice');
        removeLoadingBtnComponent('.totalPrice-loading');

        $('.calendar-arrival-date').addClass('active');
        $('.calendar-departure-date').removeClass('active');

        //Unselect current arrival and departure date
        $('.calendar-day-item').removeClass('calendar-day-item-active calendar-day-item-hover calendar-day-disable');

        //Remove min booking days
        removeMinBookingDays();

        //Default text for arrival date
        $('.calendar-arrival-date').html('تاریخ رفت');

        //Default text for departure date
        $('.calendar-departure-date').html('تاریخ برگشت');

        //Empty booked days
        $('.calendar-bookedDays').html('حداقل مدت رزرو: ' + digitsToHindi($minBookingDayCount) + ' شب');

        //Unselect arrival date
        $arrivalDate = false;

        //Unselect departure date
        $departureDate = false;

        setDisableDay();
    }

    function rangeOfArrivalAndDepartureDate(element) {
        element.addClass('calendar-day-item-hover');
        element.prevUntil('.calendar-day-item.' + $arrivalDate, '.calendar-day-item').addClass('calendar-day-item-hover');

        if(!element.prevAll('.calendar-day-item.'+$arrivalDate).length) {
            element.parent().prevUntil('.calendar-day-row:has(.' + $arrivalDate + ')').find('.calendar-day-item').addClass('calendar-day-item-hover');
            if($('.'+$arrivalDate).attr('data') != 6)
                element.parent().prevAll('.calendar-day-row:has(.' + $arrivalDate + ')').find('.calendar-day-item:last-child').addClass('calendar-day-item-hover').prevUntil('.calendar-day-item.'+$arrivalDate).addClass('calendar-day-item-hover');
        }
    }





    /*-----------------------------------
          * Loading:
          *
          * #1 Show
          * #2 Hide
      *-----------------------------------*/
    // #1 Show loading component
    function showLoadingBtnComponent(element) {
        $(element).css('display', '')
    }

    // #2 Hide loading component
    function removeLoadingBtnComponent(element) {
        $(element).css('display', 'none')
    }






    /*-----------------------------------
          * Peak Days:
          *
          * #1 Get
          * #2 Set
      *-----------------------------------*/
    // #1 Get peak days
    function getPeakDays(peakDays) {
        for(var i=0; i<peakDays.length; i++) {
            var time = moment.utc(peakDays[i], $formatDate).valueOf();
            $peakDays.push(time);
        }
    }

    // #2 Get peak days
    function setPriceForPeakDays() {
        for (var i = 0; i < $peakDays.length; i++) {
            $('.'+$peakDays[i]).find('.calendar-day-item-price').html(digitsToHindi($maxPrice))
        }
    }





    /*-----------------------------------
         * Guest Count:
         *
         *
         * #1 Increase
         * #2 Decrease
     *-----------------------------------*/
    var totalreq;
    // #1 Increase guest count
    $('.guestUp').click(function () {
        if(!$(this).hasClass('guest-btn-disable')) {
            var guestCountVal = parseInt(guestCount.val()) + 1;

            //Clear previous time out
            clearTimeout(totalreq);

            if ($arrivalDate && $departureDate) {
                removeLoadingBtnComponent('.booking-totalPrice');
                showLoadingBtnComponent('.totalPrice-loading');
            }

            //Set time out
            totalreq = setTimeout(function () {
                totalPrice();
            }, 1500);


            if (guestCountVal <= maxAccommodates) {
                if(guestCountVal !== 1)
                    $('.guestDown').removeClass('guest-btn-disable');
                $('.guestCountDisplay').html(digitsToHindi(guestCountVal));
                guestCount.val(guestCountVal);


                if (guestCountVal > accommodates) {
                    var txt = 'نفرات اضافه: ' + digitsToHindi(guestCountVal - accommodates);
                    $('.okAccommodates').html(txt);
                }


                if (guestCountVal === maxAccommodates) {
                    $('.guestUp').addClass('guest-btn-disable');
                }

                $('#accomodatesCalendar').val(guestCountVal);
            }
        }
    });

    // #2 Decrease guest count
    $('.guestDown').click(function () {
        if(!$(this).hasClass('guest-btn-disable')) {
            var guestCountVal = parseInt(guestCount.val()) - 1;

            //Clear previous time out
            clearTimeout(totalreq);

            if ($arrivalDate && $departureDate) {
                removeLoadingBtnComponent('.booking-totalPrice');
                showLoadingBtnComponent('.totalPrice-loading');
            }

            //Set time out
            totalreq = setTimeout(function () {
                totalPrice();
            }, 1500);


            if (guestCountVal >= 1) {
                $('.guestUp').removeClass('guest-btn-disable');
                $('.guestCountDisplay').html(digitsToHindi(guestCountVal));
                guestCount.val(guestCountVal);

                if (guestCountVal >= accommodates) {
                    var diff = guestCountVal - accommodates;
                    if (diff) {
                        var txt = 'نفرات اضافه: ' + digitsToHindi(guestCountVal - accommodates);
                    } else {
                        var txt = '';
                    }
                    $('.okAccommodates').html(txt);
                }

                if (guestCountVal === 1) {
                    $('.guestDown').addClass('guest-btn-disable');
                }

                $('#accomodatesCalendar').val(guestCountVal);
            }
        }
    });








    /*-----------------------------------
          * Total Price:
          *
          * #1 Calculate
          * #2 Set
      *-----------------------------------*/
    // #1 Calculate total price (from server)
    function totalPrice() {
        if($arrivalDate && $departureDate) {
            //Hide total price section
            removeLoadingBtnComponent('.booking-totalPrice');

            //Show loading
            showLoadingBtnComponent('.totalPrice-loading');

            //Set headers
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });

            //Form data
            var formData = {
                checkin: $arrivalDate / 1000,
                checkout: $departureDate / 1000,
                guests: $('.guestsCount').val()
            };

            //Request
            $.ajax({
                contentType: 'application/x-www-form-urlencoded',
                type: "POST",
                url: "/houses/" + $('#houseIdCalendar').val() + "/price",
                data: formData,
                success: function (data) {
                    //Set total price
                    setTotalPrice(data);

                    //Hide loading
                    removeLoadingBtnComponent('.totalPrice-loading');

                    //Show total price section
                    showLoadingBtnComponent('.booking-totalPrice');

                },
                error: function (data) {
                    //Nothing
                }
            });
        }
    }

    // #2 Set total price
    function setTotalPrice(price) {
        var txt = digitsToHindi(price * 1000) + ' تومان';
        $('.booking-totalPrice span').html(txt);
    }
});