<!--Add token-->
<head>
    <meta name="_token" content="{{ csrf_token() }}">
</head>

<!--include header-->
@include('header')

<!--Start review form-->
<form id="review-form" accept-charset="UTF-8" role="form" method="POST" action="@if(isset($review)) {{url('/reviews/'.$review->id.'/update')}} @else {{url('/reservations/'.$reservation->id.'/reviews/store')}} @endif">
    {!! csrf_field() !!}

    <div class="main-user" style="padding-top: 110px">
        <div class="container room user-panel">
            <div class="col-sm-10 col-sm-offset-1 col-xs-12 padding-xs-0">

                <!--Input with reservation id value for submit a new review-->
                @if(!isset($review))
                    <input name="reservation" value="{{$reservation->id}}" style="display: none;">
                @endif

            <!--Form title-->
                <div class="col-xs-12" style="display: flex; flex-direction: column; align-items: center; margin-bottom: 3em;">
                    <div style="margin-bottom: 15px; text-align: center; font-weight: bold; font-size: 1.4em;">
                        <span style="color: #0060ae">نظر شما </span><span>انتخاب دیگران رو آسون‌تر میکنه</span>
                    </div>
                    <div style="margin-bottom: 15px; text-align: center; font-size: 1.2em;">
                        <span>@if(isset($review)){{$review->reservation->guest->name}} @else {{$reservation->guest->name}} @endif عزیز ممنون بابت وقتی که میذاری و ما رو کمک میکنی</span>
                    </div>
                </div>

                <!--Error alert -->
                @if($errors->any())
                    <div id="review-error-alert" class="col-xs-12" style="margin: 0 0 15px 0">
                        <div class="alert alert-danger alert-dismissable fade in">
                            <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
                            {{ implode('', $errors->all(':message')) }}
                        </div>
                    </div>
            @endif

            <!--About house-->
                <div class="row" style="margin: 0 0 15px 0">
                    <!--title-->
                    <div class="col-md-3 col-xs-12 padding-xs-0" style="margin-bottom: 13px; font-size: 16px"> <!-- left sidebar (smaller) -->
                        <span style="font-weight: 500; color: #555">اطلاعات اقامتگاه</span>
                    </div>

                    <!--House information-->
                    <div class="col-md-8 col-xs-12 padding-xs-0">
                        <div style="background-color: #ffffff; border: 1px solid #dcdcdc">
                            <div class="rate-container-info">

                                <div class="rate-container-info-img">
                                    <div>
                                        <img style="position: absolute; top: 0; width: 100%; height: 100%" src="/@if(isset($review)){{$review->reservation->house->photo->thumbnail_path}}@else{{$reservation->house->photo->thumbnail_path}}@endif">
                                    </div>
                                </div>

                                <div class="rate-container-info-txt">
                                    <div style="display: flex; flex-direction: column; justify-content: flex-start; padding-top: 5px">
                                        <div style="margin-bottom: 5px; font-weight: bold; font-size: 15px; overflow: hidden; text-overflow: ellipsis; white-space: nowrap;">@if(isset($review)){{$review->reservation->house->title}} @else {{$reservation->house->title}} @endif</div>
                                        <div style="margin-bottom: 5px; font-size: 14px; color: #505050">@if(isset($review)){{$review->reservation->house->province}} @else {{$reservation->house->province}} @endif - @if(isset($review)){{$review->reservation->house->city}} @else {{$reservation->house->city}} @endif </div>
                                    </div>
                                </div>

                            </div>
                        </div>
                    </div>
                </div>


                <div class="row" style="margin: 0 0 15px 0">

                    <div class="col-md-3 col-xs-12 padding-xs-0" style="margin-bottom: 13px; font-size: 16px"> <!-- left sidebar (smaller) -->
                        <span style="font-weight: 500; color: #555">امتیازدهی</span>
                    </div>


                    <div class="col-md-8 col-xs-12 padding-xs-0">
                        <div style="background-color: #ffffff; border: 1px solid #dcdcdc">
                            <div style="padding: 10px 0">

                                <div style="display:flex; justify-content: space-between; align-content: center; padding: 10px 0;">
                                    <div class="col-xs-12">
                                        <div class="col-xs-5 padding-xs-0" style="font-weight: bold; font-size: 14px">
                                            <div id="accessibility-name" class="review-name">دسترسی</div>
                                            <div id="accessibility-error" class="review-error" style="display: none; color: #cd0000; font-size: 11px; margin-top: 4px;">لطفا این بخش را تکمیل نمایید</div>
                                        </div>

                                        <div class="col-xs-7 padding-xs-0" style="display: flex; justify-content: flex-end; align-items: center;">
                                            <div class="rate" style="display: inline-block;">
                                                @for($i=5 ; $i>0; $i--)
                                                    <i data="{{$i}}" class="fa fa-star rate-star @if(isset($review) && $i <= $review->accessibility) choosed-rate @endif "></i>
                                                @endfor
                                            </div>

                                            <input type="text" style="display: none;" value="@if(isset($review)) {{$review->accessibility}} @else 0 @endif" name="accessibility" />

                                            <div style="display: flex; justify-content: center; align-items: center; width: 30px; height: 30px; margin-right: 10px; background-color: #c5c5c5; color: #fff; border-radius: 5px; font-weight: bold">
                                                <span id="accessibility-data" data="@if(isset($review)) {{$review->accessibility}} @else 0 @endif">@if(isset($review)) {{$review->accessibility}} @else 0 @endif</span>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div style="display:flex; justify-content: space-between; align-content: center; padding: 10px 0;">
                                    <div class="col-xs-12">
                                        <div class="col-xs-5 padding-xs-0" style="font-weight: bold; font-size: 14px">
                                            <div id="cleanliness-name" class="review-name">نظافت</div>
                                            <div id="cleanliness-error" class="review-error" style="display: none; color: #cd0000; font-size: 11px; margin-top: 4px;">لطفا این بخش را تکمیل نمایید</div>
                                        </div>

                                        <div class="col-xs-7 padding-xs-0" style="display: flex; flex-direction: row; justify-content: flex-end; align-items: center">
                                            <div class="rate" style="display: inline-block;">
                                                @for($i=5 ; $i>0; $i--)
                                                    <i data="{{$i}}" class="fa fa-star rate-star @if(isset($review) && $i <= $review->cleanliness) choosed-rate @endif "></i>
                                                @endfor
                                            </div>

                                            <input type="text" style="display: none;" value="@if(isset($review)) {{$review->cleanliness}} @else 0 @endif" name="cleanliness" />

                                            <div style="display: flex; justify-content: center; align-items: center; width: 30px; height: 30px; margin-right: 10px; background-color: #c5c5c5; color: #fff; border-radius: 5px">
                                                <span id="cleanliness-data" data="@if(isset($review)) {{$review->cleanliness}} @else 0 @endif">@if(isset($review)) {{$review->cleanliness}} @else 0 @endif</span>
                                            </div>
                                        </div>
                                    </div>
                                </div>


                                <div style="display:flex; justify-content: space-between; align-content: center; padding: 10px 0;">
                                    <div class="col-xs-12">
                                        <div class="col-xs-5 padding-xs-0" style="font-weight: bold; font-size: 14px">
                                            <div id="value-name" class="review-name">ارزش</div>
                                            <div id="value-error" class="review-error" style="display: none; color: #cd0000; font-size: 11px; margin-top: 4px;">لطفا این بخش را تکمیل نمایید</div>
                                        </div>

                                        <div class="col-xs-7 padding-xs-0" style="display: flex; flex-direction: row; justify-content: flex-end; align-items: center">
                                            <div class="rate" style="display: inline-block;">
                                                @for($i=5 ; $i>0; $i--)
                                                    <i data="{{$i}}" class="fa fa-star rate-star @if(isset($review) && $i <= $review->value) choosed-rate @endif "></i>
                                                @endfor
                                            </div>

                                            <input type="text" style="display: none;" value="@if(isset($review)) {{$review->value}} @else 0 @endif" name="value" />

                                            <div class="rate-number" style="display: flex; justify-content: center; align-items: center; width: 30px; height: 30px; margin-right: 10px; background-color: #c5c5c5; color: #fff; border-radius: 5px">
                                                <span id="value-data" data="@if(isset($review)) {{$review->value}} @else 0 @endif">@if(isset($review)) {{$review->value}} @else 0 @endif</span>
                                            </div>
                                        </div>
                                    </div>
                                </div>


                                <div style="display:flex; justify-content: space-between; align-content: center; padding: 10px 0;">
                                    <div class="col-xs-12">
                                        <div class="col-xs-5 padding-xs-0" style="font-weight: bold; font-size: 14px">
                                            <div id="accuracy-name" class="review-name">تطابق</div>
                                            <div id="accuracy-error" class="review-error" style="display: none; color: #cd0000; font-size: 11px; margin-top: 4px;">لطفا این بخش را تکمیل نمایید</div>
                                        </div>

                                        <div class="col-xs-7 padding-xs-0" style="display: flex; flex-direction: row; justify-content: flex-end; align-items: center">
                                            <div class="rate" style="display: inline-block;">
                                                @for($i=5 ; $i>0; $i--)
                                                    <i data="{{$i}}" class="fa fa-star rate-star @if(isset($review) && $i <= $review->accuracy) choosed-rate @endif "></i>
                                                @endfor
                                            </div>

                                            <input type="text" style="display: none;" value="@if(isset($review)) {{$review->accuracy}} @else 0 @endif" name="accuracy" />

                                            <div class="rate-number" style="display: flex; justify-content: center; align-items: center; width: 30px; height: 30px; margin-right: 10px; background-color: #c5c5c5; color: #fff; border-radius: 5px">
                                                <span id="accuracy-data" data="@if(isset($review)) {{$review->accuracy}} @else 0 @endif">@if(isset($review)) {{$review->accuracy}} @else 0 @endif</span>
                                            </div>
                                        </div>
                                    </div>
                                </div>


                                <div style="display:flex; justify-content: space-between; align-content: center; padding: 10px 0;">
                                    <div class="col-xs-12">
                                        <div class="col-xs-5 padding-xs-0" style="font-weight: bold; font-size: 14px">
                                            <div id="neighborhood-name" class="review-name">همسایگی</div>
                                            <div id="neighborhood-error" class="review-error" style="display: none; color: #cd0000; font-size: 11px; margin-top: 4px;">لطفا این بخش را تکمیل نمایید</div>
                                        </div>

                                        <div class="col-xs-7 padding-xs-0" style="display: flex; flex-direction: row; justify-content: flex-end; align-items: center">
                                            <div class="rate" style="display: inline-block;">
                                                @for($i=5 ; $i>0; $i--)
                                                    <i data="{{$i}}" class="fa fa-star rate-star @if(isset($review) && $i <= $review->neighborhood) choosed-rate @endif "></i>
                                                @endfor
                                            </div>

                                            <input type="text" style="display: none;" value="@if(isset($review)) {{$review->neighborhood}} @else 0 @endif" name="neighborhood" />

                                            <div class="rate-number" style="display: flex; justify-content: center; align-items: center; width: 30px; height: 30px; margin-right: 10px; background-color: #c5c5c5; color: #fff; border-radius: 5px">
                                                <span id="neighborhood-data" data="@if(isset($review)) {{$review->neighborhood}} @else 0 @endif">@if(isset($review)) {{$review->neighborhood}} @else 0 @endif</span>
                                            </div>
                                        </div>
                                    </div>
                                </div>


                                <div style="display:flex; justify-content: space-between; align-content: center; padding: 10px 0;">
                                    <div class="col-xs-12">
                                        <div class="col-xs-5 padding-xs-0" style="font-weight: bold; font-size: 14px">
                                            <div  id="host-name" class="review-name">میزبانی</div>
                                            <div id="host-error" class="review-error" style="display: none; color: #cd0000; font-size: 11px; margin-top: 4px;"></div>
                                        </div>

                                        <div class="col-xs-7 padding-xs-0" style="display: flex; flex-direction: row; justify-content: flex-end; align-items: center">
                                            <div class="rate" style="display: inline-block;">
                                                @for($i=5 ; $i>0; $i--)
                                                    <i data="{{$i}}" class="fa fa-star rate-star @if(isset($review) && $i <= $review->host) choosed-rate @endif "></i>
                                                @endfor
                                            </div>

                                            <input type="text" style="display: none;" value="@if(isset($review)) {{$review->host}} @else 0 @endif" name="host" />

                                            <div class="rate-number" style="display: flex; justify-content: center; align-items: center; width: 30px; height: 30px; margin-right: 10px; background-color: #c5c5c5; color: #fff; border-radius: 5px">
                                                <span id="host-data" data="@if(isset($review)) {{$review->host}} @else 0 @endif">@if(isset($review)) {{$review->host}} @else 0 @endif</span>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                            </div>
                        </div>
                    </div>

                </div>



                <div class="row" style="margin: 0 0 15px 0">
                    <div class="col-md-3 col-xs-12 padding-xs-0" style="margin-bottom: 13px; font-size: 16px"> <!-- left sidebar (smaller) -->
                        <span style="font-weight: 500; color: #555">نظر شما</span>
                    </div>

                    <div class="col-md-8 col-xs-12 padding-xs-0">
                        <div id="reviewTextareaError" style="font-size: 12px; color: darkred; margin-bottom: 7px; display: none">(لطفا نظر خودتون رو با ما به اشتراک بذارید)</div>
                        <div class="col-xs-12 padding-0" style="padding: 5px !important; background-color: #ffffff; border: 1px solid #dcdcdc">
                            <textarea id="description-data" name="description" class="col-xs-12" style="position: relative; height: 200px; resize: none; border: none; overflow: auto; outline: none; -webkit-box-shadow: none; -moz-box-shadow: none; box-shadow: none;" placeholder="لطفا نظر خود را وارد نمایید...">@if(isset($review)){{$review->description}} @else @endif</textarea>
                        </div>
                    </div>
                </div>


                <div class="col-xs-12 padding-0" style="margin-bottom: 20px">
                    <id id="submit-comment" class="col-md-11 col-xs-12 padding-xs-0" style="display: flex; justify-content: flex-end;" >
                        <button class="btn" type="submit" style="display: inline-block; padding: 10px 35px; background-color: #0060ae; border-radius: 5px; color: #fff; font-weight: bold; font-size: 15px">
                            <span>@if(isset($review)) ویراش نظرات @else ثبت نظر @endif</span>
                        </button>
                    </id>
                    <div class="col-md-1 hidden-xs"></div>
                </div>
            </div>
        </div>
    </div>
</form>



<script>
    $(document).ready(function () {
        //Validation form, before submitting
        $("#review-form").submit(function(e) {
            $('.review-error').css('display', 'none');
            $('.review-name').css('color', '555');

            if($.trim($("input[name='accessibility']").val()) === "0") {
                e.preventDefault();
                $('#accessibility-name').css('color', '#cd0000');
                $('#accessibility-error').css('display', 'block');
            }

            if($.trim($("input[name='cleanliness']").val()) === "0") {
                e.preventDefault();
                $('#cleanliness-name').css('color', '#cd0000');
                $('#cleanliness-error').css('display', 'block');
            }

            if($.trim($("input[name='value']").val()) === "0") {
                e.preventDefault();
                $('#value-name').css('color', '#cd0000');
                $('#value-error').css('display', 'block');
            }


            if($.trim($("input[name='accuracy']").val()) === "0") {
                e.preventDefault();
                $('#accuracy-name').css('color', '#cd0000');
                $('#accuracy-error').css('display', 'block');
            }


            if($.trim($("input[name='neighborhood']").val()) === "0") {
                e.preventDefault();
                $('#neighborhood-name').css('color', '#cd0000');
                $('#neighborhood-error').css('display', 'block');
            }

            if($.trim($("input[name='host']").val()) === "0") {
                e.preventDefault();
                $('#host-name').css('color', '#cd0000');
                $('#host-error').css('display', 'block');
            }

            if(!$.trim($("#description-data").val())) {
                e.preventDefault();
                $("#description-data").focus().addClass("review-textarea-error").parent().css("border", '2px solid darkred');
                $("#reviewTextareaError").css("display" , "block");
            }
        });
    });

    String.prototype.toEnglishDigits = function () {
        var num_dic = {
            '0': '۰',
            '1': '۱',
            '2': '۲',
            '3': '۳',
            '4': '۴',
            '5': '۵',
            '6': '۶',
            '7': '۷',
            '8': '۸',
            '9': '۹'
        };

        return (this.replace(/[0-9]/g, function (w) {
            return num_dic[w]
        }));
    };


    $(document).ready(function() {
        //console.log($(".rate").parent().parent().find("span").attr("data"))
        $(".rate").parent().find("span").html($(this).parent().find("span").attr("data"));

        $(".rate i").click(function() {
            $(this).parent().children().removeClass("choosed-rate");
            $(this).addClass("choosed-rate");
            $(this).nextAll().addClass("choosed-rate");
            $(this).parent().parent().find("span").attr("data" , $(this).attr("data"));
            $(this).parent().parent().find("span").html($(this).attr("data").toEnglishDigits());
            $(this).parent().parent().find("input").val($(this).attr("data"));
        }).mouseout(function() {
            $(this).removeClass("hover-rate");
            $(this).nextAll().removeClass("hover-rate");
            $(this).prevAll().removeClass("not-hover-rate");
            $(this).parent().parent().find("span").html($(this).parent().parent().find("span").attr("data").toEnglishDigits());
        }).mouseover(function() {
            $(this).addClass("hover-rate");
            $(this).nextAll().addClass("hover-rate");
            $(this).prevAll().addClass("not-hover-rate");
            $(this).parent().parent().find("span").html($(this).attr("data").toEnglishDigits());
        })
    })
</script>