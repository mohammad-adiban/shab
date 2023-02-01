@include('header')
<html dir="rtl" lang="fa">
<head>
    <title>آگهی جدید - سایت شب</title>
    <link rel="stylesheet" href="{{ asset('css/jquery-clockpicker.min.css') }}">
    <link rel="stylesheet" href="{{ asset('css/bootstrap-clockpicker.min.css') }}">
    <link rel="stylesheet" href="{{ asset('css/font-awesome.css') }}">
    <link rel="stylesheet" href="{{ asset('css/cropper.min.css') }}">
    <link rel="stylesheet" href="{{ asset('css/awesome-bootstrap-checkbox.css') }}">
    <link href="{{ asset('css/create_house_new.css') }}" rel="stylesheet">

    <script src="{{ asset('js/jquery-clockpicker.min.js') }}"></script>
    <script src="{{ asset('js/bootstrap-clockpicker.min.js') }}"></script>
    <script src="{{ asset('js/locationpicker.jquery.min.js') }}"></script>
    <script src="{{ asset('js/cropper.min.js') }}"></script>
    <script src="{{ asset('js/create_house_new.js?v=1.0.1') }}"></script>

</head>
<body style="margin-top:85px">
{{-- <div class="hidden" house_id="{{ $house->id }}"></div> --}}

<div class="loader"></div>
<main>
<form class="house_form" enctype="multipart/form-data" action="{{url('/houses/edit/')}}" method="post" accept-charset="UTF-8" style="margin-top: 117px">

 {!! csrf_field() !!}
 @if (count($errors) > 0)
    <div class="alert alert-danger">
        <ul>
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <h2 class="title-wrapper text-center"><span class="title">@if(!isset($house)){{'ایجاد آگهی جدید'}}@else{{'ویرایش آگهی'}}@endif</span></h2>
                <p class="text-center description" style="margin-top: 10px;">@if(!isset($house)){{'در این بخش کافی است ویژگی های آگهی خود را مشخص کنید. پس از تایید
                    سایت، آگهی شما در شب قرار می گیرد'}}@else{{ 'در این بخش می توانید با انتخاب هر یک از قسمت های سمت راست، اطلاعات آن بخش را ویرایش کنید.' }}@endif</p>
            </div>
        </div>
    </div>
    <div class="container">
        <div class="row equal-height">
            <div class="col-md-12">
                <div class="panel-wrapper clearfix">
                    <div class="col-sm-12 col-md-3 col-lg-2 steps-wrapper equal-col">
                        <div class="steps text-center">
                        @if(!isset($house))
                            <p class="step-title visible-xs-inline-block visible-sm-inline-block visible-md-block visible-lg-block active"
                               id="title-rules">قوانین سایت</p>
                        @else
                            <p style="visibility:hidden" class="step-title visible-xs-inline-block visible-sm-inline-block visible-md-block visible-lg-block active"
                               id="title-rules">قوانین سایت</p>

                        @endif
                            <p class="step-title visible-xs-inline-block visible-sm-inline-block visible-md-block visible-lg-block"
                               id="title-picture">تصاویر</p>
                            <p class="step-title visible-xs-inline-block visible-sm-inline-block visible-md-block visible-lg-block"
                               id="title-location">موقعیت</p>
                            <p class="step-title visible-xs-inline-block visible-sm-inline-block visible-md-block visible-lg-block"
                               id="title-type">نوع محل</p>
                            <p class="step-title visible-xs-inline-block visible-sm-inline-block visible-md-block visible-lg-block"
                               id="title-options1">متراژ</p>
                            <p class="step-title visible-xs-inline-block visible-sm-inline-block visible-md-block visible-lg-block"
                               id="title-options2">ظرفیت</p>
                            <p class="step-title visible-xs-inline-block visible-sm-inline-block visible-md-block visible-lg-block"
                               id="title-options3">بافت</p>
                            <p class="step-title visible-xs-inline-block visible-sm-inline-block visible-md-block visible-lg-block"
                               id="title-options4">امکانات</p>
                            <p class="step-title visible-xs-inline-block visible-sm-inline-block visible-md-block visible-lg-block"
                               id="title-time">قوانین خانه</p>
                            <p class="step-title visible-xs-inline-block visible-sm-inline-block visible-md-block visible-lg-block"
                               id="title-price">قیمت</p>
                        </div>
                    </div>
                    <div class="col-sm-12 col-md-9 col-lg-10 forms-wrapper">
                        <div class="forms">

                            <div class="form-item" id="rules" style="@if(isset($house)){{ 'visibility: hidden' }}@endif">
                                <div class="form-group">
                                    <ol class="text-justify" id="rules-text">
                                    <li>انتشار آگهی شما در سایت به نام خودتان خواهد بود و شماره تماس شما به عنوان مالک پس از انجام رزرو به میهمان ارائه میشود. در صورتی که میهمان در خواست رزرو واحد شما را داشته باشد ، یک پیام حاوی اطلاعات زمان اقامت میهمان و مشخصات ایشان برای شما ارسال خواهد شد و در صورت تاییدتان ، پیش فاکتور نهایی شده توسط شما برای مشتری نمایش داده شده و پس از پرداخت، رزرو نهایی می شود.</li>
                                    <li>در تکمیل فرم اطلاعات منزل دقیق باشید و از تصاویر باکیفیت استفاده کنید چرا که ارائه ی هرچه بهتر اطلاعات صحیح، در جذب مشتری تاثیر به سزایی دارد.</li>
                                    <li>مجموعه "شب" مبلغ اجاره روز اول را از مشتری دریافت کرده و پس از شروع اقامت، مبلغ پیش پرداخت را به حساب مالک انتقال خواهد داد.</li>
                                    <li>مبلغ پیش پرداخت به عنوان ودیعه تا شروع اقامت مشتری نزد مجموعه شب می ماند، در صورت عدم ورود مشتری در تاریخ رزرو مبلغ پیش پرداخت به مالک تحویل داده خواهد شد.</li>
                                    <li>درج آگهی در وبسایت رایگان است وتبلیغ خانه شما در شبکه های اجتماعی ما به صورت رایگان انجام می پذیرد، اما در صورت رزرو شدن خانه ی شما از طریق وبسایت "شب" ، ۱۰ درصد از مبلغ کل رزرو به سایت تعلق خواهد گرفت.</li>
                                    </ol>
                                </div>
                                <button type="button" class="btn btn-primary center-block" id="btn-rules">قبول قوانین
                                </button>
                            </div>

                            <div class="form-item" id="picture">
                                <div class="form-group text-center">
                                    {{-- <div class="fileUpload btn btn-primary"> --}}
                                        {{-- <span class="img_input_title">انتخاب تصاویر</span> --}}
                                    {{-- </div> --}}
                                    <input style="display:none" type="file" id="image-input" name="project_file" class="upload"
                                               value="انتخاب تصاویر" accept="image/*">
                                    <p class="image_alert text-danger" style="display:none; margin:10px;">انتخاب حداقل یک عکس الزامی است.</p>
                                    <div class="preview-area clearfix">
                                        @if(isset($house))
                                           <?php $images = $house->photos()->get() ?>
                                            <?php $imgId = 0; $i = 0; ?>
                                            @foreach($images as $image)
                                              <?php $imgId = $imgId + 1; ?>
                                              <?php $imgPath = $image['path']; ?>
                                              @if($i == 0) 
                                                <div class="main_img col-xs-12 text-center">

                                                    <div class="main_img_div" style="position: relative;">
                                                        <div class="spinner">
                                                            <div class="bounce1"></div>
                                                            <div class="bounce2"></div>
                                                            <div class="bounce3"></div>
                                                        </div>
                                                        <img img_id="{{ $image['id'] }}" class="img-responsive img-thumbnail home-thumbnail" id="home_main_img" draggable="true" src="data:image/jpeg;base64,{{ base64_encode(file_get_contents($imgPath)) }}">
                                                        <span class="delete_img delete_main_img" img_id="{{ $image['id'] }}">
                                                            <i class="fa fa-trash"></i>
                                                        </span>
                                                        <span class="main_img_title">عکس اصلی</span>
                                                        <span class="crop_home_img">
                                                            <i class="fa fa-crop"></i>
                                                        </span>
                                                        <span class="crop_ok hidden">
                                                            <i class="fa fa-check"></i>
                                                        </span>
                                                        <span class="crop_nok hidden">
                                                            <i class="fa fa-times"></i>
                                                        </span>
                                                    </div>
                                                </div>
                                              @else
                                                <div class="col-xs-6 col-sm-3">
                                                    <div style="position: relative;"><img img_id="{{ $image['id'] }}" class="img-responsive img-thumbnail home-thumbnail" draggable="true" src="data:image/jpeg;base64,{{ base64_encode(file_get_contents($imgPath)) }}"><span img_id="{{ $image['id'] }}" class="delete_img"><i class="fa fa-trash"></i></span><span class="make_main_img"><span class="visible-lg">انتخاب به عنوان عکس اصلی</span><i class="fa fa-exchange hidden-lg"></i>
                                                        </span>
                                                    </div>
                                                </div>
                                              @endif
                                              <?php $i = $i + 1; ?>

                                            @endforeach
                                        @endif
                                    </div>

                                </div>
                                <div class="text-center buttons-wrapper col-x-12">
                                <button type="button" class="btn btn-default fa fa-plus btn_plus"></button>
                                    @if(!isset($house))
                                    <button type="button" class="btn btn-warning" id="btn-picture-previous">قبلی
                                    </button>
                                    @endif
                                    <button type="button" class="btn btn-primary btn-pagination" id="btn-picture">بعدی</button>
                                </div>
                                    
                            </div>

                            <div class="form-item" id="location">
                                <div class="row">
                                    <div class="col-md-6 clearfix">
                                        <div class="form-group form-group-limited">
                                            <a tabindex="0" class="form-info" role="button" data-toggle="popover"
                                               data-placement="left" data-trigger="focus"
                                               data-content=""><i
                                                    class="fa fa-question-circle"></i></a>
                                            <input type="text" name="title" value="@if(isset($house)){{ $house->title }}@endif" class="form-control limited" required
                                                   placeholder="عنوان آگهی" maxlength="40">
                                            <span class="remaining-chars"></span>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <select required default="@if(isset($house)){{$house->province}}@endif" name="province" class="form-control text-center-xs" id="province-select" ></select>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-6 clearfix">
                                        <div class="form-group">
                                            <select required default="@if(isset($house)){{$house->city}}@endif"  name="city" class="form-control text-center-xs" id="city-select" >
                                                <option selected class="text-center-xs">شهر</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group form-group-limited">
                                            <a tabindex="0" class="form-info" role="button" data-toggle="popover"
                                               data-placement="left" data-trigger="focus"
                                               data-content="مثال : فیلبند ، هرمز ، رودخان"><i
                                                    class="fa fa-question-circle"></i></a>
                                            <input value="@if(isset($house)){{ $house->village }}@endif" name="village" type="text" class="form-control limited" maxlength="31"
                                                   id="village-select" placeholder="روستا">
                                            <span class="remaining-chars"></span>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="form-group form-group-limited">
                                            <a tabindex="0" class="form-info" role="button" data-toggle="popover"
                                               data-placement="left" data-trigger="focus"
                                               data-content="آدرسی که اعلام می کنید پیش از رزرو برای مهمان نمایش داده نمی شود"><i
                                                    class="fa fa-question-circle"></i></a>
                                            <textarea name="address" type="text" class="form-control limited" required maxlength="255"
                                                      placeholder="آدرس">@if(isset($house)){{$house->address}}@endif</textarea>
                                            <span class="remaining-chars"></span>
                                        </div>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label for="map">مکان دقیق خانه را بر روی نقشه مشخص کنید</label>
                                            <div id="map"></div>
                                            <input type="hidden" id="map-lat" name="latitude" value="@if(isset($house)){{$house->latitude}}@endif">
                                            <input type="hidden" id="map-lon" name="longitude" value="@if(isset($house)){{$house->longitude}}@endif">
                                        </div>
                                    </div>
                                </div>

                                <div class="text-center buttons-wrapper col-x-12">
                                    <button type="button" class="btn btn-warning" id="btn-location-previous">قبلی
                                    </button>
                                    <button type="button" class="btn btn-primary btn-pagination" id="btn-location">بعدی</button>
                                </div>

                            </div>

                            <div class="form-item" id="type">
                            <div class="row">
                            <div class="col-xs-12 col-sm-6 col-md-4">
                                <div class="form-group">
                                    <select name="type" value="@if(isset($house)){{$house->type}}@endif" class="form-control text-center-xs" id="apartment-type">
                                        <option selected disabled class="text-center-xs">نوع ساختمان</option>
                                        @if(isset($house) && $house->type == 'villa')
                                            <option value="villa" selected class="text-center-xs">ویلایی</option>
                                        @else 
                                            <option value="villa" class="text-center-xs">ویلایی</option>
                                        @endif
                                        
                                        @if(isset($house) && $house->type == 'apartment')
                                            <option value="apartment" selected class="text-center-xs">آپارتمان</option>
                                        @else 
                                            <option value="apartment" class="text-center-xs">آپارتمان</option>
                                        @endif
                                        
                                        @if(isset($house) && $house->type == 'room')
                                            <option value="room" selected class="text-center-xs">سوییت</option>
                                        @else 
                                            <option value="room" class="text-center-xs">سوییت</option>
                                        @endif
                                        
                                    </select>
                                    <span class="remaining-chars"></span>
                                </div>
                                </div>
                                </div>
                                <div class="clearfix form-group">
                                    <div class="col-xs-6 col-md-3">
                                        <div class="checkbox abc-checkbox abc-checkbox-success">
                                            <input  type='hidden' value='0' name='detached'>

                                            <input @if(isset($house) && $house->detached == 1) checked @endif name="detached" id="darbast" class="styled" type="checkbox" value="1">
                                            <label for="darbast">دربست</label>

                                        </div>
                                    </div>
                                    <div class="col-xs-6 col-md-3">
                                        <div class="checkbox abc-checkbox abc-checkbox-success">
                                            <input  type='hidden' value='0' name='in_complex'>

                                            <input @if(isset($house) && $house->in_complex == 1) checked @endif name="in_complex" id="shahrak" class="styled" type="checkbox" value="1">
                                            <label for="shahrak">داخل شهرک</label>

                                        </div>
                                    </div>
                                    <div class="col-xs-6 col-md-3">
                                        <div class="checkbox abc-checkbox abc-checkbox-success">
                                            <input  type='hidden' value='0' name='janitor'>

                                            <input @if(isset($house) && $house->janitor == 1) checked @endif name="janitor" id="seraydari" class="styled" type="checkbox" value="1">
                                            <label for="seraydari">سرایداری</label>

                                        </div>
                                    </div>
                                    <div class="col-xs-6 col-md-3">
                                        <div class="checkbox abc-checkbox abc-checkbox-success">
                                            <input  type='hidden' value='0' name='private_yard'>

                                            <input @if(isset($house) && $house->private_yard == 1) checked @endif name="private_yard" id="hayatdar" class="styled" type="checkbox" value="1">
                                            <label for="hayatdar">حیاط – در اختیار</label>

                                        </div>
                                    </div>

                                    <div class="col-xs-6 col-md-3">
                                        <div class="checkbox abc-checkbox abc-checkbox-success">
                                            <input  type='hidden' value='0' name='shared_yard'>

                                            <input @if(isset($house) && $house->shared_yard == 1) checked @endif name="shared_yard" id="hayatdar2" class="styled" type="checkbox" value="1">
                                            <label for="hayatdar2">حیاط – مشترک</label>

                                        </div>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-xs-12">
                                        <div class="form-group form-group-limited">
                                            <textarea type="text" class="form-control limited" required maxlength="1023" name="about" 
                                                      placeholder="درباره خانه">@if(isset($house)){{$house->about}}@endif</textarea>
                                            <span class="remaining-chars"></span>
                                        </div>
                                    </div>
                                </div>

                                <div class="text-center buttons-wrapper col-x-12">
                      
                          

                                
                                    <button type="button" class="btn btn-warning" id="btn-type-previous">قبلی</button>
                                    <button type="button" class="btn btn-primary btn-pagination" id="btn-type">بعدی</button>
                                </div>

                            </div>

                            <div class="form-item" id="options1">
                                <div class="row">
                                    <div class="col-xs-12 col-sm-6 col-md-4">
                                        <div class="form-group">
                                            <select name="structure" class="form-control text-center-xs" id="construction-type">
                                                <option selected disabled class="text-center-xs" >تیپ سازه</option>
                                                @if(isset($house))
                                                    @if($house->structure != 'flat' && $house->structure != 'duplex' && $house->structure != 'triplex')
                                                        <option value="flat" selected class="text-center-xs">هم سطح</option>
                                                    @else
                                                        @if($house->structure == 'flat')
                                                            <option value="flat" selected class="text-center-xs">هم سطح</option>
                                                        @else 
                                                            <option value="flat" class="text-center-xs">هم سطح</option>
                                                        @endif
                                                        
                                                        @if(isset($house) && $house->structure == 'duplex')
                                                            <option value="duplex" selected class="text-center-xs">دوبلکس</option>
                                                        @else 
                                                            <option value="duplex" class="text-center-xs">دوبلکس</option>
                                                        @endif
                                                        @if(isset($house) && $house->structure == 'triplex')
                                                            <option value="triplex" selected class="text-center-xs">تربلکس</option>
                                                        @else 
                                                            <option value="triplex" class="text-center-xs">تربلکس</option>
                                                        @endif
                                                    @endif
                                                @else
                                                    <option value="flat" class="text-center-xs">هم سطح</option>
                                                    <option value="duplex" class="text-center-xs">دوبلکس</option>
                                                    <option value="triplex" class="text-center-xs">تربلکس</option>
                                                @endif
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-xs-12 col-sm-4 floor_count_wrapper">
                                        <div class="form-group">
                                            <div class="input-group">
                                                <div class="input-group-addon plus-val"><i class="fa fa-plus"></i></div>
                                                <input name="floors" value="@if(isset($house)){{$house->floors}}@else{{ '1' }}@endif" type="text" class="form-control text-center" min="1" required
                                                       placeholder="تعداد طبقات"
                                                       onkeypress='return event.charCode >= 48 && event.charCode <= 57'>
                                                <div class="input-group-addon minus-val"><i class="fa fa-minus"></i>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-xs-12 col-sm-4 unit_count_wrapper">
                                        <div class="form-group">
                                            <div class="input-group">
                                                <div class="input-group-addon plus-val"><i class="fa fa-plus"></i></div>
                                                <input name="floor_no" value="@if(isset($house)){{$house->floor_no}}@else{{ '1' }}@endif" type="text" class="form-control text-center" required min="0"
                                                       placeholder="طبقه واحد"
                                                       onkeypress='return event.charCode >= 48 && event.charCode <= 57'>
                                                <div class="input-group-addon minus-val"><i class="fa fa-minus"></i>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-xs-12 col-sm-4">
                                        <div class="form-group">
                                            <div class="input-group">
                                                <div class="input-group-addon plus-val"><i class="fa fa-plus"></i></div>
                                                <input name="rooms" value="@if(isset($house)){{$house->rooms}}@endif" type="text" class="form-control text-center" required min="0"
                                                       placeholder="تعداد اتاق خواب"
                                                       onkeypress='return event.charCode >= 48 && event.charCode <= 57'>
                                                <div class="input-group-addon minus-val"><i class="fa fa-minus"></i>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-6 col-xs-12">
                                        <div class="form-group">
                                            <input name="building_area" value="@if(isset($house)){{$house->building_area}}@endif" type="text" class="form-control text-center-xs" minlength="0"
                                                   required placeholder="متراژ ساختمان (متر مربع)" onkeypress='return event.charCode >= 48 && event.charCode <= 57'>
                                        </div>
                                    </div>
                                    <div class="col-md-6 col-xs-12">
                                        <div class="form-group">
                                            <input name="land_area" value="@if(isset($house)){{$house->land_area}}@endif" type="text" class="form-control text-center-xs" required
                                                   minlength="0" placeholder="متراژ زمین (متر مربع)" onkeypress='return event.charCode >= 48 && event.charCode <= 57'>
                                        </div>
                                    </div>
                                </div>
                                <div class="text-center buttons-wrapper col-x-12">
                  
                               

                                
                                    <button type="button" class="btn btn-warning" id="btn-options1-previous">قبلی
                                    </button>
                                    <button type="button" class="btn btn-primary btn-pagination" id="btn-options1">بعدی</button>
                                </div>

                            </div>

                            <div class="form-item" id="options2">
                                <div class="row">
                                    <div class="col-xs-12 col-sm-6 col-md-4 col-md-offset-4">
                                        <div class="form-group">
                                            <div class="input-group">
                                                <div class="input-group-addon plus-val"><i class="fa fa-plus"></i></div>
                                                <a tabindex="0" class="form-info" role="button" data-toggle="popover"
                                               data-placement="left" data-trigger="focus" data-trigger="focus"
                                               data-content="تعداد مهمان بدون افزایش قیمت برابر با ظرفیت استاندارد است">
                                                <i class="fa fa-question-circle"></i>
                                            </a>
                                                <input name="accommodates" value="@if(isset($house)){{$house->accommodates}}@endif" type="text" class="form-control text-center" required min="1"
                                                       placeholder="ظرفیت استاندارد"
                                                       id="standard_capacity"
                                                       onkeypress='return event.charCode >= 48 && event.charCode <= 57'>
                                                <div class="input-group-addon minus-val"><i class="fa fa-minus"></i>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-xs-12 col-sm-6 col-md-4 col-md-offset-4">
                                        <div class="form-group">
                                            <div class="input-group">
                                                <div class="input-group-addon plus-val"><i class="fa fa-plus"></i></div>
                                                <?php if(isset($house)) {
//                                                    $m = $house->max_accommodates == 0 ? $house->accommodates : $house->max_accommodates;
                                                        $m = $house->max_accommodates;
                                                    }
                                                    else
                                                        $m = '';
                                                ?>
                                                <input name="max_accommodates" value="@if(isset($house)){{$m}}@endif" type="text" class="form-control text-center" required
                                                       placeholder="حداکثر ظرفیت"
                                                       id="max_capacity"
                                                       onkeypress='return event.charCode >= 48 && event.charCode <= 57'>
                                                <div class="input-group-addon minus-val"><i class="fa fa-minus"></i>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-xs-12 col-sm-6 col-md-4 col-md-offset-4">
                                        <div class="form-group">
                                            <div class="input-group">
                                                <div class="input-group-addon plus-val"><i class="fa fa-plus"></i></div>
                                                <input name="single_beds" value="@if(isset($house)){{$house->single_beds}}@endif" type="text" class="form-control text-center" required min="0"
                                                       placeholder="تعداد تخت یک نفره"
                                                       onkeypress='return event.charCode >= 48 && event.charCode <= 57'>
                                                <div class="input-group-addon minus-val"><i class="fa fa-minus"></i>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-xs-12 col-sm-6 col-md-4 col-md-offset-4">
                                        <div class="form-group">
                                            <div class="input-group">
                                                <div class="input-group-addon plus-val"><i class="fa fa-plus"></i></div>
                                                <input name="double_beds" value="@if(isset($house)){{$house->double_beds}}@endif" type="text" class="form-control text-center" required min="0"
                                                       placeholder="تعداد تخت دو نفره"
                                                       onkeypress='return event.charCode >= 48 && event.charCode <= 57'>
                                                <div class="input-group-addon minus-val"><i class="fa fa-minus"></i>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>


                                <div class="text-center buttons-wrapper">

                                    
                                    <button type="button" class="btn btn-warning" id="btn-options2-previous">قبلی
                                    </button>
                                    <button type="button" class="btn btn-primary btn-pagination" id="btn-options2">بعدی</button>
                                </div>

                            </div>

                            <div class="form-item" id="options3">
                                <div class="col-xs-12 hidden" id="options3_err">
                                    <p class="text-danger">انتخاب حداقل یکی از گزینه‌ها الزامی است.</p>
                                </div>
                                <div class="clearfix form-group">
                                    <div class="col-xs-6 col-md-3">
                                        <div class="checkbox abc-checkbox abc-checkbox-success">
                                            <input  type='hidden' value='0' name='forest'>

                                            <input name="forest" @if(isset($house) && $house->forest == 1) checked @endif  id="jangali" class="styled" type="checkbox" value="1">
                                            <label for="jangali"> جنگلی</label>

                                        </div>
                                    </div>
                                    <div class="col-xs-6 col-md-3">
                                        <div class="checkbox abc-checkbox abc-checkbox-success">
                                            <input  type='hidden' value='0' name='mountain'>

                                            <input name="mountain" @if(isset($house) && $house->mountain == 1) checked @endif id="kouhestani" class="styled" type="checkbox" value="1">
                                            <label for="kouhestani"> کوهستانی</label>

                                        </div>
                                    </div>
                                    <div class="col-xs-6 col-md-3">
                                        <div class="checkbox abc-checkbox abc-checkbox-success">
                                            <input  type='hidden' value='0' name='desert'>

                                            <input name="desert" @if(isset($house) && $house->desert == 1) checked @endif id="kaviri" class="styled" type="checkbox" value="1">
                                            <label for="kaviri"> کویری</label>

                                        </div>
                                    </div>
                                    <div class="col-xs-6 col-md-3">
                                        <div class="checkbox abc-checkbox abc-checkbox-success">
                                            <input  type='hidden' value='0' name='coastal'>

                                            <input name="coastal" @if(isset($house) && $house->coastal == 1) checked @endif id="saheli" class="styled" type="checkbox" value="1">
                                            <label for="saheli"> ساحلی</label>

                                        </div>
                                    </div>
                                </div>
                                <div class="clearfix">
                                    <div class="col-xs-6 col-md-3">
                                        <div class="checkbox abc-checkbox abc-checkbox-success">
                                            <input  type='hidden' value='0' name='in_town'>

                                            <input name="in_town" @if(isset($house) && $house->in_town == 1) checked @endif id="shahri" class="styled" type="checkbox" value="1">
                                            <label for="shahri"> درون شهری</label>

                                        </div>
                                    </div>
                                    <div class="col-xs-6 col-md-3">
                                        <div class="checkbox abc-checkbox abc-checkbox-success">
                                            <input  type='hidden' value='0' name='historic'>

                                            <input name="historic" @if(isset($house) && $house->historic == 1) checked @endif id="tarikhi" class="styled" type="checkbox" value="1">
                                            <label for="tarikhi"> بنای تاریخی</label>

                                        </div>
                                    </div>
                                    <div class="col-xs-6 col-md-3">
                                        <div class="checkbox abc-checkbox abc-checkbox-success">
                                            <input  type='hidden' value='0' name='rural'>

                                            <input name="rural" @if(isset($house) && $house->rural == 1) checked @endif id="roostaei" class="styled" type="checkbox" value="1">
                                            <label for="roostaei"> روستایی</label>

                                        </div>
                                    </div>
                                    <div class="col-xs-6 col-md-3">
                                        <div class="checkbox abc-checkbox abc-checkbox-success">
                                            <input  type='hidden' value='0' name='summer'>

                                            <input name="summer" @if(isset($house) && $house->summer == 1) checked @endif id="yeylaghi" class="styled" type="checkbox" value="1">
                                            <label for="yeylaghi"> ییلاقی</label>

                                        </div>
                                    </div>
                                </div>


                                <div class="row">
                                    <div class="col-xs-12">
                                        <div class="form-group form-group-limited">
                                            <textarea name="place_desc" type="text" class="form-control limited" maxlength="2047"
                                                      placeholder="توضیحات">@if(isset($house)){{$house->place_desc}}@endif</textarea>
                                            <span class="remaining-chars"></span>
                                        </div>
                                    </div>
                                </div>


                                <div class="text-center buttons-wrapper col-x-12">
                                 
                                    <button type="button" class="btn btn-warning" id="btn-options3-previous">قبلی
                                    </button>
                                    <button type="button" class="btn btn-primary btn-pagination" id="btn-options3">بعدی</button>
                                </div>

                            </div>

                            <div class="form-item" id="options4">
                                <div class="col-xs-6 col-md-3">
                                    <div class="checkbox abc-checkbox abc-checkbox-success">
                                        <input  type='hidden' value='0' name='split_cooling'>

                                        <input name="split_cooling" @if(isset($house) && $house->split_cooling == 1) checked @endif  id="gazi" class="styled" type="checkbox" value="1">
                                        <label for="gazi"> کولر گازی</label>

                                    </div>
                                </div>
                                <div class="col-xs-6 col-md-3">
                                    <div class="checkbox abc-checkbox abc-checkbox-success">
                                        <input  type='hidden' value='0' name='water_cooling'>

                                        <input name="water_cooling" @if(isset($house) && $house->water_cooling == 1) checked @endif  id="abi" class="styled" type="checkbox" value="1">
                                        <label for="abi"> کولر آبی</label>


                                    </div>
                                </div>
                                <div class="col-xs-6 col-md-3">
                                    <div class="checkbox abc-checkbox abc-checkbox-success">
                                        <input  type='hidden' value='0' name='heating'>

                                        <input name="heating" @if(isset($house) && $house->heating == 1) checked @endif  id="garmayesh" class="styled" type="checkbox" value="1">
                                        <label for="garmayesh"> گرمایش</label>

                                    </div>
                                </div>
                                <div class="col-xs-6 col-md-3">
                                    <div class="checkbox abc-checkbox abc-checkbox-success">
                                        <input  type='hidden' value='0' name='internet'>

                                        <input name="internet" @if(isset($house) && $house->internet == 1) checked @endif  id="net" class="styled" type="checkbox" value="1">
                                        <label for="net"> اینترنت وایرلس</label>

                                    </div>
                                </div>
                                <div class="col-xs-6 col-md-3">
                                    <div class="checkbox abc-checkbox abc-checkbox-success">
                                        <input  type='hidden' value='0' name='indoor_pool'>

                                        <input name="indoor_pool" @if(isset($house) && $house->indoor_pool == 1) checked @endif  id="sarpooshide" class="styled" type="checkbox" value="1">
                                        <label for="sarpooshide"> استخر سرپوشیده</label>

                                    </div>
                                </div>
                                <div class="col-xs-6 col-md-3">
                                    <div class="checkbox abc-checkbox abc-checkbox-success">
                                        <input  type='hidden' value='0' name='outdoor_pool'>

                                        <input name="outdoor_pool" @if(isset($house) && $house->outdoor_pool == 1) checked @endif  id="sarbaz" class="styled" type="checkbox" value="1">
                                        <label for="sarbaz"> استخر سرباز</label>

                                    </div>
                                </div>
                                <div class="col-xs-6 col-md-3">
                                    <div class="checkbox abc-checkbox abc-checkbox-success">
                                        <input  type='hidden' value='0' name='elevator'>

                                        <input name="elevator" @if(isset($house) && $house->elevator == 1) checked @endif  id="asansor" class="styled" type="checkbox" value="1">
                                        <label for="asansor"> آسانسور</label>

                                    </div>
                                </div>
                                <div class="col-xs-6 col-md-3">
                                    <div class="checkbox abc-checkbox abc-checkbox-success">
                                        <input  type='hidden' value='0' name='balcony'>

                                        <input name="balcony" @if(isset($house) && $house->balcony == 1) checked @endif  id="tras" class="styled" type="checkbox" value="1">
                                        <label for="tras"> تراس</label>

                                    </div>
                                </div>
                                <div class="col-xs-6 col-md-3">
                                    <div class="checkbox abc-checkbox abc-checkbox-success">
                                        <input  type='hidden' value='0' name='european_wc'>

                                        <input name="european_wc" @if(isset($house) && $house->european_wc == 1) checked @endif  id="farangi" class="styled" type="checkbox" value="1">
                                        <label for="farangi"> سرویس فرنگی</label>

                                    </div>
                                </div>
                                <div class="col-xs-6 col-md-3">
                                    <div class="checkbox abc-checkbox abc-checkbox-success">
                                        <input  type='hidden' value='0' name='parking'>

                                        <input name="parking" @if(isset($house) && $house->parking == 1) checked @endif id="parking" class="styled" type="checkbox" value="1">
                                        <label for="parking"> پارکینگ</label>

                                    </div>
                                </div>
                                <div class="col-xs-6 col-md-3">
                                    <div class="checkbox abc-checkbox abc-checkbox-success">
                                        <input  type='hidden' value='0' name='barbecue'>

                                        <input name="barbecue" @if(isset($house) && $house->barbecue == 1) checked @endif  id="barbecue" class="styled" type="checkbox" value="1">
                                        <label for="barbecue"> باربیکیو</label>

                                    </div>
                                </div>
                                <div class="col-xs-6 col-md-3">
                                    <div class="checkbox abc-checkbox abc-checkbox-success">
                                        <input  type='hidden' value='0' name='television'>

                                        <input name="television" @if(isset($house) && $house->television == 1) checked @endif  id="tv" class="styled" type="checkbox" value="1">
                                        <label for="tv"> تلویزیون</label>

                                    </div>
                                </div>
                                <div class="col-xs-6 col-md-3">
                                    <div class="checkbox abc-checkbox abc-checkbox-success">
                                        <input  type='hidden' value='0' name='breakfast'>

                                        <input name="breakfast" @if(isset($house) && $house->breakfast == 1) checked @endif  id="sobhane" class="styled" type="checkbox" value="1">
                                        <label for="sobhane"> صبحانه</label>

                                    </div>
                                </div>
                                <div class="col-xs-6 col-md-3">
                                    <div class="checkbox abc-checkbox abc-checkbox-success">
                                        <input  type='hidden' value='0' name='bathroom'>

                                        <input name="bathroom" @if(isset($house) && $house->bathroom == 1) checked @endif  id="hamam" class="styled" type="checkbox" value="1">
                                        <label for="hamam"> حمام</label>

                                    </div>
                                </div>
                                <div class="col-xs-6 col-md-3">
                                    <div class="checkbox abc-checkbox abc-checkbox-success">
                                        <input  type='hidden' value='0' name='receiver'>

                                        <input name="receiver" @if(isset($house) && $house->receiver == 1) checked @endif  id="receiver" class="styled" type="checkbox" value="1">
                                        <label for="receiver"> گیرنده دیجیتال</label>

                                    </div>
                                </div>

                                <div class="col-xs-6 col-md-3">
                                    <div class="checkbox abc-checkbox abc-checkbox-success">
                                        <input  type='hidden' value='0' name='furniture'>

                                        <input name="furniture" @if(isset($house) && $house->furniture == 1) checked @endif  id="furniture" class="styled" type="checkbox" value="1">
                                        <label for="furniture"> مبلمان</label>

                                    </div>
                                </div>

                                <div class="col-xs-6 col-md-3">
                                    <div class="checkbox abc-checkbox abc-checkbox-success">
                                        <input  type='hidden' value='0' name='kitchen_equipment'>

                                        <input name="kitchen_equipment" @if(isset($house) && $house->kitchen_equipment == 1) checked @endif  id="kitchen_equipment" class="styled" type="checkbox" value="1">
                                        <label for="kitchen_equipment"> تجهیزات آشپزی</label>

                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-xs-12">
                                        <div class="form-group form-group-limited">
                                            <textarea type="text" required name="description" class="form-control limited" maxlength="2047"
                                                      placeholder="توضیحات. مثال: میز بیلیارد، وسایل تفریحی، تعداد کولر، تعداد پارکینگ، آنتن دهی 3G  و ...
">@if(isset($house)){{$house->description}}@endif</textarea>
                                            <span class="remaining-chars"></span>
                                        </div>
                                    </div>
                                </div>

                                <div class="text-center buttons-wrapper col-x-12">
                                    
                                  
                                    <button type="button" class="btn btn-warning" id="btn-options4-previous">قبلی
                                    </button>
                                    <button type="button" class="btn btn-primary btn-pagination" id="btn-options4">بعدی</button>
                                </div>

                            </div>

                            <div class="form-item" id="time">
                                <div class="row">
                                    <div class="col-xs-12 col-sm-6 col-md-4 col-md-offset-4">
                                        <div class="form-group">
                                            <div class="input-group clockpicker_first">
                                                <input name="rule_checkin" value="@if(isset($house)){{$house->rule_checkin}}@endif" required type="text"
                                                       class="form-control text-center-xs readonly-input"
                                                       placeholder="ساعت ورود مهمان" onkeypress='return false' onFocus='blur()'>
                                                <span class="input-group-addon"><span
                                                        class="fa fa-clock-o"></span></span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-xs-12 col-sm-6 col-md-4 col-md-offset-4">
                                        <div class="form-group">
                                            <div class="input-group clockpicker_second">
                                                <input name="rule_checkout" value="@if(isset($house)){{$house->rule_checkout}}@endif" required type="text"
                                                       class="form-control text-center-xs readonly-input"
                                                       placeholder="ساعت خروج مهمان" onkeypress='return false' onFocus='blur()'>
                                                <span class="input-group-addon"><span
                                                        class="fa fa-clock-o"></span></span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-xs-12 col-sm-6 col-md-4 col-md-offset-4">
                                        <div class="form-group">
                                            <div class="input-group">
                                                <div class="input-group-addon plus-val"><i class="fa fa-plus"></i></div>
                                                <input name="rule_minimum_days" value="@if(isset($house)){{$house->rule_minimum_days}}@endif" required type="text" class="form-control text-center-xs" min="1"
                                                       placeholder="حداقل تعداد روز رزرو"
                                                       onkeypress='return event.charCode >= 48 && event.charCode <= 57'>
                                                <div class="input-group-addon minus-val"><i class="fa fa-minus"></i>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-12 ">
                                    <div class="checkbox abc-checkbox abc-checkbox-success">
                                        <input  type='hidden' value='0' name='rule_cermony'>

                                        <input name="rule_cermony" @if(isset($house) && $house->rule_cermony == 1) checked @endif id="marasem" class="styled" type="checkbox" value="1">
                                        <label for="marasem"> امکان برگزاری مراسم</label>

                                    </div>
                                </div>
                                <div class="col-md-12 ">
                                    <div class="checkbox abc-checkbox abc-checkbox-success">
                                        <input  type='hidden' value='0' name='rule_pets'>

                                        <input name="rule_pets" @if(isset($house) && $house->rule_pets == 1) checked @endif id="animals" class="styled" type="checkbox" value="1">
                                        <label for="animals"> امکان ورود حیوانات خانگی</label>

                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-xs-12">
                                        <div class="form-group form-group-limited">
                                            <textarea type="text" class="form-control limited" maxlength="2047" name="rules_desc" 
                                                      placeholder="قوانین شما. مثال : مدارک محرمیت الزامیست، سیگار کشیدن داخل ممنوع  یا ...">@if(isset($house)){{$house->rules_desc}}@endif</textarea>
                                            <span class="remaining-chars"></span>
                                        </div>
                                    </div>
                                </div>

                                <div class="text-center buttons-wrapper col-x-12">

                                    
                                
                                
                                    <button type="button" class="btn btn-warning" id="btn-time-previous">قبلی</button>
                                    <button type="button" class="btn btn-primary btn-pagination" id="btn-time">بعدی</button>
                                </div>

                            </div>



                            <div class="form-item" id="price">
                                <div class="row">
                                    <div class="col-md-6 col-xs-12">
                                        <div class="form-group form-group-limited">
                                            <a tabindex="0" class="form-info" role="button" data-toggle="popover"
                                               data-placement="left" data-trigger="focus" data-trigger="focus"
                                               data-content="">
                                                <i class="fa fa-question-circle"></i>
                                            </a>
                                            <input name="min_price" value="@if(isset($house)){{$house->min_price}}@endif" required type="text" class="form-control priceShow" min="0"
                                                   maxlength="4"
                                                   onkeypress='return event.charCode >= 48 && event.charCode <= 57'
                                                   placeholder="قیمت وسط هفته (شنبه تا سه شنبه)">
                                            <span class="priceinletters"></span>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-6 col-xs-12">
                                        <div class="form-group form-group-limited">
                                            <a tabindex="0" class="form-info" role="button" data-toggle="popover"
                                               data-placement="left" data-trigger="focus" data-trigger="focus"
                                               data-content="">
                                                <i class="fa fa-question-circle"></i>
                                            </a>
                                            <input name="median_price" value="@if(isset($house)){{$house->median_price}}@endif" required type="text" class="form-control priceShow" min="0"
                                                   maxlength="4"
                                                   onkeypress='return event.charCode >= 48 && event.charCode <= 57'
                                                   placeholder="قیمت آخر هفته (چهارشنبه تا جمعه)">
                                            <span class="priceinletters"></span>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-6 col-xs-12">
                                        <div class="form-group form-group-limited">
                                            <a tabindex="0" class="form-info" role="button" data-toggle="popover"
                                               data-placement="left" data-trigger="focus" data-trigger="focus"
                                               data-content="">
                                                <i class="fa fa-question-circle"></i>
                                            </a>
                                            <input name="max_price" value="@if(isset($house)){{$house->max_price}}@endif" required type="text" class="form-control priceShow" min="0"
                                                   maxlength="6"
                                                   onkeypress='return event.charCode >= 48 && event.charCode <= 57'
                                                   placeholder="قیمت پیک (تعطیلات خاص و ایام شلوغ)">
                                            <span class="priceinletters"></span>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-6 col-xs-12">
                                        <div class="form-group form-group-limited">
                                            <a tabindex="0" class="form-info" role="button" data-toggle="popover"
                                               data-placement="left" data-trigger="focus" data-trigger="focus"
                                               data-content="">
                                                <i class="fa fa-question-circle"></i>
                                            </a>
                                            <input name="extra_person" value="@if(isset($house)){{$house->extra_person}}@endif" required type="text" class="form-control priceShow" min="0"
                                                   maxlength="3"
                                                   onkeypress='return event.charCode >= 48 && event.charCode <= 57'
                                                   placeholder="قیمت هر نفر اضافه (به ازای هر شب)">
                                            <span class="priceinletters"></span>
                                        </div>
                                    </div>
                                </div>
                            <p>۱۰٪ از جمع مبلغ اعلام شده در هنگام رزرو به عنوان خدمات سایت کسر می شود.</p>

                                <div class="row">
                                    <div class="col-xs-12">
                                        <div class="form-group form-group-limited">
                                            <label><span class="text-main-color">تخفیف رزرو طولانی یک</span>: بالای </label>
                                            <?php
                                             if (isset($house)) {
                                             $d1 = $house->discount_days_level1 == 0 ? '' : $house->discount_days_level1;
                                             $p1 = $house->discount_rate_level1 == 0 ? '' : $house->discount_rate_level1;
                                              $d2 = $house->discount_days_level2 == 0 ? '' : $house->discount_days_level2;
                                               $p2 = $house->discount_rate_level2 == 0 ? '' : $house->discount_rate_level2;

                                             }
                                           else {
                                            $d1 = '';
                                            $p1 = '';
                                            $d2 = '';
                                            $p2 = '';
                                           }
                                            ?>
                                            <input type="text"
                                                   class="form-control titleless discount-input text-center discount-one"
                                                   maxlength="4"
                                                   name="discount_days_level1" value="@if(isset($house)){{$d1}}@endif" 
                                                   onkeypress='return event.charCode >= 48 && event.charCode <= 57'>روز
                                            <input type="text"
                                                   class="form-control titleless discount-input text-center discount-one"
                                                   maxlength="3"
                                                   name="discount_rate_level1" value="@if(isset($house)){{$p1}}@endif" 
                                                   onkeypress='return event.charCode >= 48 && event.charCode <= 57'>درصد

                                            <span class="priceinletters"></span>
                                        </div>
                                    </div>
                                </div>
                                <div class="row" style="@if(!isset($house)){{ 'display: none;' }}@endif">
                                    <div class="col-xs-12">
                                        <div class="form-group form-group-limited">
                                            <label><span class="text-main-color">تخفیف رزرو طولانی دو</span>: بالای </label>
                                            <input type="text"
                                                   class="form-control titleless discount-input text-center discount-two"
                                                   maxlength="4"
                                                   name="discount_days_level2" value="@if(isset($house)){{$d2}}@endif" 
                                                   onkeypress='return event.charCode >= 48 && event.charCode <= 57'>روز
                                            <input type="text"
                                                   class="form-control titleless discount-input text-center discount-two"
                                                   maxlength="3"
                                                   name="discount_rate_level2" value="@if(isset($house)){{$p2}}@endif" 
                                                   onkeypress='return event.charCode >= 48 && event.charCode <= 57'>درصد
                                            <span class="priceinletters"></span>
                                        </div>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-xs-12">
                                        <div class="form-group form-group-limited">
                                            <a tabindex="0" class="form-info" role="button" data-toggle="popover"
                                               data-placement="left" data-trigger="focus" data-trigger="focus"
                                               data-content="">
                                                <i class="fa fa-question-circle"></i>
                                            </a>
                                            <textarea type="text" class="form-control limited" maxlength="2047" name="price_desc" 
                                                      placeholder="توضیحات">@if(isset($house)){{$house->price_desc}}@endif</textarea>
                                            <span class="remaining-chars"></span>
                                        </div>
                                    </div>

                                </div>
                                <div class="text-center buttons-wrapper col-x-12">
                                    
                                    @if(!isset($house))
                                    <button type="button" class="btn btn-warning" id="btn-price-previous">قبلی</button>
                                    <button type="button" class="btn btn-success btn-pagination" id="btn-price">ثبت آگهی</button>
                                    @else 
                                    <button type="button" class="btn btn-success btn-pagination submit">ویرایش آگهی</button>
                                    @endif

                                </div>
                            </div>

                            <input type="hidden" name="unavailable_days" value="1">
                            <input type="hidden" name="peak_days" value="1">

                            <div class="form-item" id="finish">
                                <div class="alert alert-success" role="alert">
                                    <p>
                                        <i class="fa fa-check-circle"></i>
                                        <span>آگهی شما با موفقیت ثبت شد.</span>
                                    </p>
                                </div>
                            </div>

                        </div>
                    </div>
                </div>
            </div>
        </div>
</form>
<input type="hidden" id="house_id" value="@if(isset($house)){{$house->id}}@endif">

</main>



</body>
</html>

<script type="text/javascript">
    $('input[type="checkbox"]').change(function(){
        this.value = (Number(this.checked));
    });


  var wordifyfa = function (num, level) {
  'use strict';
    if (num === null) {
        return "";
  }
  // convert negative number to positive and get wordify value
  if (num<0) {
    num = num * -1;
    return "منفی " + wordifyfa(num, level); 
  }
    if (num === 0) {
        if (level === 0) {
            return "صفر";
    } else {
            return "";
    }
  }
  var result = "",
    yekan = [" یک ", " دو ", " سه ", " چهار ", " پنج ", " شش ", " هفت ", " هشت ", " نه "],
    dahgan = [" بیست ", " سی ", " چهل ", " پنجاه ", " شصت ", " هفتاد ", " هشتاد ", " نود "],
    sadgan = [" یکصد ", " دویست ", " سیصد ", " چهارصد ", " پانصد ", " ششصد ", " هفتصد ", " هشتصد ", " نهصد "],
    dah = [" ده ", " یازده ", " دوازده ", " سیزده ", " چهارده ", " پانزده ", " شانزده ", " هفده ", " هیجده ", " نوزده "];
    if (level > 0) {
        result += " و ";
        level -= 1;
    }
   
    if (num < 10) {
        result += yekan[num - 1];
    } else if (num < 20) {
        result += dah[num - 10];
    } else if (num < 100) {
        result += dahgan[parseInt(num / 10, 10) - 2] +  wordifyfa(num % 10, level + 1);
    } else if (num < 1000) {
        result += sadgan[parseInt(num / 100, 10) - 1] + wordifyfa(num % 100, level + 1);
    } else if (num < 1000000) {
        result += wordifyfa(parseInt(num / 1000, 10), level) + " هزار " + wordifyfa(num % 1000, level + 1);
    } else if (num < 1000000000) {
        result += wordifyfa(parseInt(num / 1000000, 10), level) + " میلیون " + wordifyfa(num % 1000000, level + 1);
    } else if (num < 1000000000000) {
        result += wordifyfa(parseInt(num / 1000000000, 10), level) + " میلیارد " + wordifyfa(num % 1000000000, level + 1);
    } else if (num < 1000000000000000) {
        result += wordifyfa(parseInt(num / 1000000000000, 10), level) + " تریلیارد " + wordifyfa(num % 1000000000000, level + 1);
    }
  return result;

};

var wordifyRials = function (num) {
  'use strict';
    return wordifyfa(num, 0) + " ریال";
};

var wordifyRialsInTomans = function (num) {
  'use strict';
    if (num >= 10) {
        num = parseInt(num / 10, 10);
    } else if (num<=-10) {
        num = parseInt(num/10,10);
    } else {
    num=0;
  }
  
    return wordifyfa(num, 0) + " تومان";
};

if (typeof module !== 'undefined' && module.exports) {
  module.exports.wordifyfa = wordifyfa;
  module.exports.wordifyRials = wordifyRials;
  module.exports.wordifyRialsInTomans = wordifyRialsInTomans;
}
</script>