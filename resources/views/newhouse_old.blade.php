@include('header')
  <script src="{{ asset('js/nouislider.js') }}"></script>
  <link href="{{ asset('css/nouislider.css') }}" rel="stylesheet">

<div class="panel mg-top new-room">
  <div class="panel-body panel-light">
    <div></div>
    <div class="row space-2 ">
      <div class="col-sm-10 col-sm-offset-1 col-center text-center">
        <h2 class="space-2">
        @if(isset($house))
           <lng key="house.editHouse"></lng>
        @else
          <lng key="house.newHouse"></lng>
        @endif
        </h2>
        <p class="text-lead">
        @if(!isset($house))
          در این بخش کافی است ویژگی های آگهی خود را مشخص کنید. پس از تایید سایت، آگهی شما در شب قرار می گیرد.
          @endif
        </p>
      </div>
    </div>
    <div></div>
  </div>
  <div class="panel-body form">
    <div class="col-sm-12">
      <div class="row">
        @if (count($errors) > 0)
            <div class="alert alert-danger">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif
        <form class="newroom-form" enctype="multipart/form-data" action="" method="post" accept-charset="UTF-8">
          {!! csrf_field() !!}
          <div class="col-lg-10 padd-off col-lg-offset-2">
            <div class="row row-condensed space-4 col-md-9 col-sm-10 mg-d-2">
              <label class="info-l text-left col-sm-3" >
                عنوان آگهی
                  <br>
                  <small class="hidden-xs info" >نامی که خودتان برای منزلتان به کار می برید</small>
              </label>
              <div class="col-sm-9">
                
                <input class="form-control" id="title" name="title" size="30" type="text" value="@if(isset($house)){{ $house->title }}@endif">
                
              </div>
            </div>
            <div class="row row-condensed space-4 col-md-9 col-sm-10 mg-d-2">
              <input type="hidden" name="type" value="@if(isset($house)){{$house->type}}@endif">
              
              <div id="property-type-id-header" class="col-sm-3 flt-rtl h5 text-light">
                <label for="room-type" class="text-left">
                  <strong>
                    نوع اقامتگاه
                  </strong>
                </label>
              </div>
              <div class="btn-group space-4 col-sm-9 col-xs-12 flt-rtl ">
                             <div class="col-sm-4 inl-blk pad-0">
                  <button  group="2" name="villa" type="button"  class="btn btn-default btn-roomtype">
                  <i class="fa fa-share"></i> <lng key="search.villa"></lng>
                  </button>
                  <!-- <div class="tooltip tooltip-top-middle">  <p class="panel-body">محل قرارگیزی توضیح</p></div> -->
                </div>
                <div class="col-sm-4 inl-blk pad-0">
                  <button group="2"  name="apartment" type="button"  class="btn btn-default btn-roomtype">
                  <i class="fa fa-home"></i> <lng key="search.entireHome"></lng>
                  </button>
                  <!-- <div class="tooltip tooltip-top-middle">  <p class="panel-body">محل قرارگیزی توضیح</p></div> -->
                </div>
                <div class="col-sm-4 inl-blk pad-0">
                  <button group="2"  name="room"  type="button" class="btn btn-default btn-roomtype">
                  <i class="fa fa-user-secret"></i>  <lng key="search.privateRoom"></lng>
                  </button>
                  <!-- <div class="tooltip tooltip-top-middle">  <p class="panel-body">محل قرارگیزی توضیح</p></div> -->
                </div>
 
              </div>
            </div>


            
            
            <div class="row row-condensed space-4 col-md-9 col-sm-10 mg-d-2">
              <label class="text-left col-sm-3" >
                قیمت
              </label>
              <br>
              <div class="col-sm-9">
                <p class="info-l">قیمت حداقل هفته
                <br>
                  <small class="hidden-xs info" >میان هفته های زمستان و ایام خلوت</small>
                  </p>
                <div class="row-slider" id="price-slider1"></div> <!-- range slider -->
                <div class="col-xs-12 center mg-top-1">
                  <p class="price-val" id="min-price" class="price" name="price"></p> <span class="price-curr">  </span>
                  <input type="hidden" name="min_price" value="@if(isset($house)){{$house->min_price}}@endif">
                </div>
              </div>
              <div class="col-sm-9 col-sm-offset-3">
                <p class="info-l">قیمت میانه
                <br>
                  <small class="hidden-xs info" >وسط هفته تابستان و آخر هفته زمستان</small>
                  </p>
                <div class="row-slider" id="price-slider2"></div> <!-- range slider -->
                <div class="col-xs-12 center mg-top-1">
                  <p class="price-val" id="median-price" class="price" name="price"></p> <span class="price-curr">  </span>
                  <input type="hidden" name="median_price" value="@if(isset($house)){{$house->median_price}}@endif">
                </div>
              </div>
              <div class="col-sm-9 col-sm-offset-3">
                <p class="info-l">قیمت پیک
                <br>
                  <small class="hidden-xs info" >تعطیلات خاص و ایام پیک سفرها</small>
                  </p>
                <div class="row-slider" id="price-slider3"></div> <!-- range slider -->
                <div class="col-xs-12 center mg-top-1">
                  <p class="price-val" id="max-price" class="price" name="price"></p> <span class="price-curr">  </span>
                  <input type="hidden" name="max_price" value="@if(isset($house)){{$house->max_price}}@endif">
                </div>
              </div>
              <div class="text-left down-2 top-3">
                <p class="info-l col-sm-3">قیمت هر نفر اضافه
                <br>
                  <small class="hidden-xs info" >مبلغی که به ازای هر نفر بیش از ظرفیت نرمال اضافه می شود را مشخص کنید</small>
                  </p>
                  <div class="col-sm-9"> <input name="extra_person" type="number" min="0" value="@if(isset($house)){{$house->extra_person}}@endif" class="extra"> هزار تومان
              </div></div>
              <br>
              <div class="text-left mg-t-2 col-sm-12 pad-l-0 pad-r-0">
                <p class="info-l col-sm-3">تخفیف ها
                <br>
                  <small class="hidden-xs info" >مثال: بالای ۳ روز ۱۰ درصد</small>
                  </p>
                  <div class="col-sm-9"><span>بالای</span> <input name="discount_days" type="number" min="0" value="@if(isset($house)){{$house->discount_days}}@endif" class="discount"> روز <input name="discount_rate" type="number" min="0" value="@if(isset($house)){{$house->discount_rate}}@endif" class="discount"> درصد</div>
              </div>
            </div>
            

  
            <div class="row row-condensed space-4 col-md-9 col-sm-10 mg-d-2">
              <label class="text-left col-sm-3" >
                 حداکثر ظرفیت
              </label>
            <!--   <div class="col-md-3 flt-rtl ">
                <label class="text-right col-sm-12 flt-rtl pad-l-0" >
                  تاریخ شروع
                </label>
                <div class="col-sm-12">
                  
                  <input class="form-control" id="checkin" name="available_from" size="30" type="text" value="@if(isset($house)){{$house->available_from}}@endif">
                  
                </div>
              </div>
              <div class="col-md-3 flt-rtl ">
                <label class="text-right col-sm-12 flt-rtl  pad-l-0" >
                  تاریخ پایان
                </label>
                <div class="col-sm-12">
                  
                  <input class="form-control" id="checkout" name="available_to" size="30" type="text" value="@if(isset($house)){{$house->available_to}}@endif">
                  
                </div>
              </div> 
              <div class="col-md-3">
                <label class="text-right col-sm-12 flt-rtl pad-l-0" >
                  <lng key="search.maxGuests"></lng>
                  
                </label>
                <div class="col-sm-12">
                  <div class="select select-large hover-select-highlight">
                    <select name="accommodates" id="accommodates-select">
                      @for($i=1; $i<16; $i++)
                        @if(isset($house) && $house->accommodates == $i)
                          <option selected="selected" class="accommodates" value="{{ $i }}">{{ $i }}</option>
                        @else
                          <option class="accommodates" value="{{ $i }}">{{ $i }}</option>
                        @endif
                      @endfor
                      <option class="accommodates" value="17">+16</option> // MUST FIX THIS
                    </select>
                  </div>
                </div>
              </div> -->
              
            <div class="col-sm-9 pad-r-0 pad-l-0">
                <div class="col-sm-12">
                  <div class="select select-large hover-select-highlight">
                    <select name="accommodates" id="accommodates-select">
                      @for($i=1; $i<16; $i++)
                        @if(isset($house) && $house->accommodates == $i)
                          <option selected="selected" class="accommodates" value="{{ $i }}">{{ $i }}</option>
                        @else
                          <option class="accommodates" value="{{ $i }}">{{ $i }}</option>
                        @endif
                      @endfor
                      <option class="accommodates" value="17">+16</option> // MUST FIX THIS
                    </select>
                  </div>
                </div>
              </div>


            </div>
            


            <div class="row row-condensed space-4 col-md-9 col-sm-10 mg-d-2">
              <label class="text-left col-sm-3" >
                استان
              </label>
              <div class="col-sm-9">
                
                {{-- <input class="form-control" id="destination" name="province" size="30" type="text" value="@if(isset($house)){{$house->province}}@endif"> --}}
                      <select default="@if(isset($house)){{$house->province}}@endif" class="dropdown" name="province" id="province-select">
                          <option></option>
                      </select>
                
              </div>
            </div>
            
            <div class="row row-condensed space-4 col-md-9 col-sm-10 mg-d-2">
              <label class="text-left col-sm-3" >
                شهر
              </label>
              <div class="col-sm-9">
                      <select default="@if(isset($house)){{$house->city}}@endif" class="dropdown" name="city" id="city-select">
                          <option></option>
                      </select>

                {{-- <input class="form-control" id="city" name="city" size="30" type="text" value="@if(isset($house)){{$house->city}}@endif"> --}}
                
              </div>
            </div>
            <div class="row row-condensed space-4 col-md-9 col-sm-10 mg-d-2">
              <label class="text-left col-md-3 col-sm-12" >
                امکانات
              </label>
              <div class="col-md-9 col-md-offset-0 col-sm-offset-2">
                <div class="col-md-4 pad-0 col-xs-6 mg-t-1">
                  <label class="text-left col-sm-12" >
                    تعداد اتاق خواب
                  </label>
                  <div class="col-sm-12 ">
                    <div class="select select-large hover-select-highlight">
                      <select name="rooms" id="accommodates-select">
                        @for($i=1; $i<10; $i++)
                         @if(isset($house) && $house->rooms == $i)
                           <option selected="selected" class="accommodates" value="{{ $i }}">{{ $i }}</option>
                          @else
                           <option class="accommodates" value="{{ $i }}">{{ $i }}</option>
                          @endif
                        @endfor
                        <option class="accommodates" value="10">+10</option>
                      </select>
                    </div>
                  </div>
                </div>
                <div class="col-md-4 pad-0 col-xs-6 mg-t-1">
                  <label class="text-left col-sm-12 " >
                    تعداد تخت <small>(ظرفیت نرمال)</small>
                  </label>
                  <div class="col-sm-12">
                    <div class="select select-large hover-select-highlight">
                      <select name="beds" id="accommodates-select">
                        @for($i=1; $i<16; $i++)
                         @if(isset($house) && $house->beds == $i)
                          <option selected="selected"  class="accommodates" value="{{ $i }}">{{ $i }}</option>
                          @else
                          <option class="accommodates" value="{{ $i }}">{{ $i }}</option>
                          @endif
                        @endfor
                        <option class="accommodates" value="16">+16</option>
                      </select>
                    </div>
                  </div>
                </div>
                <div class="col-md-4 pad-0 col-xs-6 mg-t-1">
                  <label class="text-left col-sm-12" >
                   نوع محل
                    
                  </label>
                  <div class="col-sm-12">
                    <div class="select select-large hover-select-highlight">
                      <select name="area_type" id="type-select">
                          <option @if(isset($house) && $house->area_type == 'detached') selected @endif  value="detached">دربست</option>
                          <option @if(isset($house) && $house->area_type == 'in_complex') selected @endif"  value="in_complex">داخل شهرک</option>
                      </select>
                    </div>
                  </div>
                </div>

                <br>

                <div class="pad-v-1-5 mg-t-1 mg-d-3">
                  <label class="text-left col-sm-12 flt-rtl pad-l-0  pad-0" >
                    متراژ زمین (متر مربع)
                    
                  </label>
                  <div class="col-sm-12 pad-0">
                    <div class="select select-large hover-select-highlight">
                      <input type="number" min="0" value="@if(isset($house)){{$house->land_area}}@endif" name="land_area" class="form-control col-xs-12">
                    </div>
                  </div>
                </div>



                <div class="pad-v-1-5 mg-t-1 mg-d-3">
                  <label class="text-left col-sm-12 flt-rtl pad-l-0 pad-0" >
                    متراژ بنا (متر مربع)
                    
                  </label>
                  <div class="col-sm-12 pad-0">
                    <div class="select select-large hover-select-highlight">
                      <input type="number" min="0" value="@if(isset($house)){{$house->building_area}}@endif" name="building_area" class="form-control col-xs-12">
                      
                    </div>
                  </div>
                </div>





                
                <div class="row row-condensed col-xs-12">
                  <div class="col-sm-4 col-xs-6 row-space-1-sm">
                    <label class="house-aments" title="Wireless Internet">
                      <div>
                        <input @if(isset($house) && $house->internet == 1) checked @endif type="checkbox"   name="internet" value="1">
                      </div>
                      <div><span>اینترنت وایرلس</span></div>
                    </label>
                  </div>
                  <div class="col-sm-4 col-xs-6  row-space-1-sm">
                    <label class="house-aments" title="Pool">
                      <div>
                        <input   @if(isset($house) && $house->pool == 1) checked @endif type="checkbox"   name="pool" value="1">
                      </div>
                      <div><span>استخر</span></div>
                    </label>
                  </div>
                  <div class="col-sm-4 col-xs-6  row-space-1-sm">
                    <label class="house-aments" title="Kitchen">
                      <div>
                        <input   @if(isset($house) && $house->barbecue == 1) checked @endif type="checkbox"   name="barbecue" value="1">
                      </div>
                      <div><span>باربیکیو</span></div>
                    </label>
                  </div>
                </div>
                <div class="row row-condensed filters-columns col-xs-12">
                  <div class="col-sm-4 col-xs-6  row-space-1-sm">
                    <label class="house-aments" title="Pool">
                      <div>
                        <input   @if(isset($house) && $house->heating == 1) checked @endif type="checkbox"   name="heating" value="1">
                      </div>
                      <div><span>گرمایش</span></div>
                    </label>
                  </div>
                  <div class="col-sm-4 col-xs-6  row-space-1-sm">
                    <label class="house-aments" title="Pool">
                      <div>
                        <input   @if(isset($house) && $house->water_cooling == 1) checked @endif type="checkbox"   name="water_cooling" value="1">
                      </div>
                      <div><span>کولر آبی</span></div>
                    </label>
                  </div>
                  <div class="col-sm-4 col-xs-6  row-space-1-sm">
                    <label class="house-aments" title="Pool">
                      <div>
                        <input   @if(isset($house) && $house->split_cooling == 1) checked @endif type="checkbox"   name="split_cooling" value="1">
                      </div>
                      <div><span>کولر گازی</span></div>
                    </label>
                  </div>
                  <div class="col-sm-4 col-xs-6  row-space-1-sm">
                    <label class="house-aments" title="Pool">
                      <div>
                        <input   @if(isset($house) && $house->breakfast == 1) checked @endif type="checkbox"   name="breakfast" value="1">
                      </div>
                      <div><span>صبحانه</span></div>
                    </label>
                  </div>
                  <div class="col-sm-4 col-xs-6  row-space-1-sm">
                    <label class="house-aments" title="Pool">
                      <div>
                        <input   @if(isset($house) && $house->television == 1) checked @endif type="checkbox"   name="television" value="1">
                      </div>
                      <div><span>تلویزیون</span></div>
                    </label>
                  </div>
                  <div class="col-sm-4 col-xs-6  row-space-1-sm">
                    <label class="house-aments" title="Pool">
                      <div>
                        <input   @if(isset($house) && $house->parking == 1) checked @endif type="checkbox"   name="parking" value="1">
                      </div>
                      <div><span>پارکینگ</span></div>
                    </label>
                  </div>
                  <div class="col-sm-4 col-xs-6  row-space-1-sm">
                    <label class="house-aments" title="Pool">
                      <div>
                        <input   @if(isset($house) && $house->local_breakfast == 1) checked @endif type="checkbox"   name="local_breakfast" value="1">
                      </div>
                      <div><span>صبحانه محلی</span></div>
                    </label>
                  </div>
                  <div class="col-sm-4 col-xs-6  row-space-1-sm">
                    <label class="house-aments" title="Pool">
                      <div>
                        <input   @if(isset($house) && $house->elevator == 1) checked @endif type="checkbox"   name="elevator" value="1">
                      </div>
                      <div><span>آسانسور</span></div>
                    </label>
                  </div>
                  <div class="col-sm-4 col-xs-6  row-space-1-sm">
                    <label class="house-aments" title="Pool">
                      <div>
                        <input   @if(isset($house) && $house->furniture == 1) checked @endif type="checkbox"   name="furniture" value="1">
                      </div>
                      <div><span>مبلمان</span></div>
                    </label>
                  </div>
                  <div class="col-sm-4 col-xs-6  row-space-1-sm">
                    <label class="house-aments" title="Pool">
                      <div>
                        <input   @if(isset($house) && $house->bicycle == 1) checked @endif type="checkbox"   name="bicycle" value="1">
                      </div>
                      <div><span>دوچرخه</span></div>
                    </label>
                  </div>
                  <div class="col-sm-4 col-xs-6  row-space-1-sm">
                    <label class="house-aments" title="Pool">
                      <div>
                        <input   @if(isset($house) && $house->european_wc == 1) checked @endif type="checkbox"   name="european_wc" value="1">
                      </div>
                      <div><span>سرویس فرنگی</span></div>
                    </label>
                  </div>
                  <div class="col-sm-4 col-xs-6  row-space-1-sm">
                    <label class="house-aments" title="Pool">
                      <div>
                        <input   @if(isset($house) && $house->kitchen_equipment == 1) checked @endif type="checkbox"   name="kitchen_equipment" value="1">
                      </div>
                      <div><span>تجهیزات آشپزی</span></div>
                    </label>
                  </div>
                  <div class="col-sm-4 col-xs-6  row-space-1-sm">
                    <label class="house-aments" title="green_space">
                      <div>
                        <input   @if(isset($house) && $house->green_space == 1) checked @endif type="checkbox"   name="green_space" value="1">
                      </div>
                      <div><span>فضای سبز</span></div>
                    </label>
                  </div>
                  <div class="col-sm-4 col-xs-6  row-space-1-sm">
                    <label class="house-aments" title="balcony">
                      <div>
                        <input   @if(isset($house) && $house->balcony == 1) checked @endif type="checkbox"   name="balcony" value="1">
                      </div>
                      <div><span>تراس</span></div>
                    </label>
                  </div>
                </div>
              </div>
            </div>
            
            
            
            
            <div class="row row-condensed space-4 col-md-9 col-sm-10 mg-d-2">
              <label class="text-left col-sm-3" >
                موقعیت (بر روی مکان خانه کلیک کنید)
              </label><br>
              <div class="col-sm-9 gmap">
                <div id="gmap"></div>
                
              </div>
            </div>
            
            <!-- images section -->


            <div class="row row-condensed space-4 col-md-9 col-sm-10 mg-d-2">
              <label class="text-left col-sm-3 info-l" >
                تصاویر خانه <br> <small class="info">عکس ها بهترین معرفی از اقامتگاه شما هستند، عکس های کامل و مناسب از اقامتگاه تهیه کنید</small>

              </label><br>
              <div class="col-sm-9 house-images">
                <div class="col-xs-12 image-main">
                  <label for="add-image" class="col-md-1 col-sm-2 plus-btn flt-rtl btn btn-default"><i class="fa fa-plus"></i></label>
                
                  <input type="file" name="images[]" class="add-image empty img-1" style="display: none">
                  <div class="col-xs-10">افزودن تصویر</div><br>
                  <p class="top-3 col-xs-12 pad-0 mg-t-1"><input value="1" class="photographer" type="checkbox" @if(isset($house) && $house->photographer == 1) checked @endif name="photographer">اگر نیاز به یک عکاس حرفه ای رایگان برای تهیه عکس های خوب از اقامتگاه خود دارید، این گزینه را تکمیل کنید.</p>

                </div>
                     @if(isset($house))
                       <?php $images = $house->photos()->get() ?>
                        <?php $imgId = 0 ?>
                        @foreach($images as $image)
                          <?php $imgId = $imgId + 1 ?>
                          <?php $imgPath = $image['path'] ?>
                          <div class="col-xs-6 image-sec mg-top-4 flt-rtl" img-num="{{ $imgId }}"><img src="data:image/jpeg;base64,{{ base64_encode(file_get_contents($imgPath)) }}" id="{{ $imgId }}" class="image"><div class="delete-image" id="{{ $imgId }}"><i id="{{ $imgId }}" img-id="{{ $image['id'] }}" class="fa fa-remove pointer"></i></div></div>
                        @endforeach
                        <input type="hidden" id="imgId" value="{{ $imgId }}">
                    @endif
                    <input type="hidden" name="deleted_images" value="">
              </div>
            </div>
            
            <!--end images section -->
            
            
            <div class="row row-condensed space-4 col-md-9 col-sm-10 mg-d-2">
              <label class="text-left col-sm-3 info-l" >
                درباره خانه <br> <small class="info">هر توضیحی نسبت به مکان و امکانات دیگر اقامتگاه شما یا قوانین خاص شما</small>
              </label>
              <div class="col-sm-9">
                
                <textarea class="form-control" id="about" name="about" size="30">@if(isset($house)){{$house->about}}@endif</textarea>
                
              </div>
            </div>
            
            
            <div class="row row-condensed space-4 col-md-9 col-sm-10 mg-d-2">
              <label class="text-left col-sm-3 flt-rtl info-l" >
                توضیحات <br> <small class="info">هر توضیحی در مورد شهر یا دسترسی مکان شما به نقاط دیگر شهر یا جاذبه های گردشگری آن </small>
              </label>
              <div class="col-sm-9">
                
                <textarea class="form-control" id="description" name="description" size="30">@if(isset($house)){{$house->description}}@endif</textarea>
                
              </div>
            </div>
            
            
            
            <div class="row row-condensed space-4 col-md-9 col-sm-10 mg-d-2">
              <label class="text-left col-sm-3 flt-rtl" >
                آدرس پستی دقیق
              </label>
              <div class="col-sm-9">
                
                <textarea class="form-control" id="address" name="address" size="30">@if(isset($house)){{$house->address}}@endif</textarea>
                
              </div>
            </div>
            
            <div class="continue-button col-xs-4 col-xs-offset-3">
              <button type="submit" class="btn btn-primary submit
              clickable ">
        @if(!isset($house))
           ثبت آگهی 
        @else
           ویرایش آگهی 
        @endif
              </button>
            </div>
          </div>
          <input type="hidden" id="lat" name="latitude" value="@if(isset($house)){{$house->latitude}}@endif">
          <input type="hidden" id="lng" name="longitude" value="@if(isset($house)){{$house->longitude}}@endif">
        </form>
      </div>
    </div>
  </div>
</div>
@include('footer')

<script type="text/javascript">

    $('document').ready(function() {
      pr = '', ct = '';

      if($('#province-select').attr('default') != "") {
          pr = $('#province-select').attr('default');
      }
      if (pr != '') {
        if($('#city-select').attr('default') != "") {
            ct = $('#city-select').attr('default');
            var cities1 = getCitiesForProvince(pr);
              setCities(cities1);
        }
      }

        for (i = 1; i < Object.keys(PROVINCES).length + 1; i++) {

          if (PROVINCES[i] == pr) {
            $('#province-select').append('<option selected="selected" value="'+PROVINCES[i]+'">'+PROVINCES[i]+'</option>');
          }
          else {
            $('#province-select').append('<option value="'+PROVINCES[i]+'">'+PROVINCES[i]+'</option>');
          }
        }

        $('#province-select').on('change', function (e) { 
          var cities = getCitiesForProvince(this.value);
            setCities(cities);
        });

    });

    function setCities(citiesList) {
          $('#city-select').empty();
          for (i = 0; i < Object.keys(citiesList).length; i++) {
            if (citiesList[i] == ct) {
              $('#city-select').append('<option selected="selected" value="'+citiesList[i]+'">'+citiesList[i]+'</option>');
            }
            else {
              $('#city-select').append('<option value="'+citiesList[i]+'">'+citiesList[i]+'</option>');
            }
          }
    }

    function getCitiesForProvince(pr) {
        var prCode = 0;
        var citiesForPr = [];
        for(var key in PROVINCES){
            if (PROVINCES[key] == pr) {
                prCode = key;
            }
        }

        for(var key in CITIES) {
            if(CITIES[key] == prCode) {
                citiesForPr.push(key);
            }
        }
        return citiesForPr;
    }

</script>