@include('header')

<script src="{{ asset('js/nouislider.js') }}"></script>
<link href="{{ asset('css/nouislider.css') }}" rel="stylesheet">

<!--start addd css and js file-->
<link href="{{ asset('css/easy-autocomplete.min.css') }}" type="text/css" rel="stylesheet"/>
<link type="text/css" href="{{ asset('css/search_new.css?v=1.0.3') }}" rel="stylesheet">

<script src="{{ URL::asset('js/persian-date.js') }}"></script>
<script src="{{ URL::asset('js/persian-datepicker-0.4.5.js') }}"></script>
<link rel="stylesheet" href="{{ URL::asset('css/persian-datepicker.css?v=1.1') }}"/>
<link rel="stylesheet" type="text/css" href="{{ URL::asset('css/bookmarks.css?v=0.0.4') }}">
<link type="text/css" href="{{ asset('css/flickity.min.css') }}" rel="stylesheet"/>

<script src="{{ asset('js/flickity.pkgd.min.js') }}" type="text/javascript"></script>
<!--end addd css file-->

<body>
<script>
    $(".prj-header").css("position" , "fixed");
</script>
<!--start snackBar and filter modal-->
<!--start snackBar-->
<div id="snackbar" class="visible-xs">
        <span id="snackBar-filter" class="col-xs-6 snackBar-choice" style="border-left: 0.5px solid rgba(85,85,85,0.7)">
			<span class="snackBar-choice-icon">
				<svg viewBox="0 0 12 12" role="presentation" aria-hidden="true" focusable="false"
                     style="display: inline-block; fill: currentcolor; height: 1em; width: 1em;"><path
                            fill-rule="evenodd"
                            d="M2.5.25a.75.75 0 0 0-.75.75v.378a2.25 2.25 0 0 0 0 4.244V11a.75.75 0 0 0 1.5 0V5.622a2.25 2.25 0 0 0 0-4.244V1A.75.75 0 0 0 2.5.25zm0 4a.75.75 0 1 1 0-1.5.75.75 0 0 1 0 1.5zm3.5-4a.75.75 0 0 0-.75.75v5.378a2.25 2.25 0 0 0 0 4.244V11a.75.75 0 0 0 1.5 0v-.378a2.25 2.25 0 0 0 0-4.244V1A.75.75 0 0 0 6 .25zm0 9a.75.75 0 1 1 0-1.5.75.75 0 0 1 0 1.5zm4.25-7.872V1a.75.75 0 0 0-1.5 0v.378a2.25 2.25 0 0 0 0 4.244V11a.75.75 0 0 0 1.5 0V5.622a2.25 2.25 0 0 0 0-4.244zM9.5 4.25a.75.75 0 1 1 0-1.5.75.75 0 0 1 0 1.5z"></path></svg>
			</span> &nbsp; فیلتر
        </span>

    <span id="snackBar-map" class="col-xs-6 snackBar-choice" onclick="showMap()">
			<span class="snackBar-choice-icon">
				<svg viewBox="0 0 12 12" role="presentation" aria-hidden="true" focusable="false"
                     style="display: inline-block; fill: currentcolor; height: 1em; width: 1em;"><path
                            fill-rule="evenodd"
                            d="M10.377.76l-2.816.469L4.738.288a.753.753 0 0 0-.474 0l-3 1a.75.75 0 0 0-.513.711v9a.75.75 0 0 0 .987.711l2.763-.921 2.763.921c.154.051.32.051.474 0l3-1a.75.75 0 0 0 .513-.711v-8.5a.75.75 0 0 0-.873-.74l-.001.001zM2.25 9.959V2.54l1.5-.5v7.419l-1.5.5zm3-7.919l1.5.5v7.419l-1.5-.5V2.04zm3 .595l1.5-.25v7.074l-1.5.5V2.635z"></path></svg>
			</span> &nbsp; نقشه
        </span>

    <span id="snackBar-list" class="col-xs-6 snackBar-choice" style="display: none" onclick="hideMap()">
			<span class="snackBar-choice-icon">
				<svg viewBox="0 0 12 4" role="presentation" aria-hidden="true" focusable="false"
                     style="display: inline-block; fill: currentcolor; height: 1em; width: 1em;"><path
                            fill-rule="evenodd"
                            d="M10.5 3.5a1.5 1.5 0 1 0-.001-3.001A1.5 1.5 0 0 0 10.5 3.5zM6 3.5A1.5 1.5 0 1 0 5.999.499 1.5 1.5 0 0 0 6 3.5zm-4.5 0A1.5 1.5 0 1 0 1.499.499 1.5 1.5 0 0 0 1.5 3.5z"></path></svg>
			</span> &nbsp; لیست
        </span>
</div>
<!--end snackBar-->

<!--start filter modal-->
<div id="filterModal" class="filter-modal">
    <div class="filter-modal-content animate">
        <div class="filter-modal-close-container">
            <span class="filter-modal-close" title="Close Modal">&times;</span>
        </div>

        <div id="filterModal-body" class="filter-modal-container">

        </div>

        <div id="filterModal-footer" class="filter-modal-container" style="background-color:#f1f1f1">

        </div>
    </div>
</div>
<!--end filter modal-->

<script>
    MIN = 10;
    MAX = 1000;
    var cpyFilterChoosedContainer;
    $("#snackBar-filter").click(function () {
        //copy current filtering state for cancel it by close button
        cpyFilterChoosedContainer = $("#filter-choosed-container").html();

        //call show filter modal function
        showFilterModal();

        $("#filterModal-footer").html($("#filter-search-btn"));
        $("#filter-search-btn").removeClass("hidden");
        $("#filterModal-body").html($(".filter-container").html());
        $('#price-slider5').remove();
        $('#sliderParent').after('<div class="row row-slider col-xs-8" id="price-slider5"></div>');
        var slider = document.getElementById('price-slider5');
        initSlider(slider, MIN, MAX);

        //read from filter choosed container and checking the checkboxes
        var childrenFilterChoosedContainer = $("#filter-choosed-container").children();
        for (var i = 0; i < childrenFilterChoosedContainer.length; i++)
            $("[value=" + childrenFilterChoosedContainer[i].id + "]").prop("checked", true);
    });

    //click on close button and cancel new filtering
    $(".filter-modal-close").click(function () {
        $("#filter-choosed-container").html(cpyFilterChoosedContainer);
        hideFilterModal();
    });

    //function for hide the filter modal
    function hideFilterModal() {
        $("#filter-search-btn").addClass("hidden");
        $("#filterModal").css("display", "none");
        $("#snackbar").css("z-index", "9999");
    }

    function searchFromMobile() {
        hideFilterModal();
        var childrenFilterChoosedContainer = $("#filter-choosed-container").children();
        for (var i = 0; i < childrenFilterChoosedContainer.length; i++) {
            if (childrenFilterChoosedContainer[i].id !== 'location-result' && childrenFilterChoosedContainer[i].id !== 'clearAll-result')
                setUrlParam(encodeURIComponent(childrenFilterChoosedContainer[i].id), $(childrenFilterChoosedContainer[i]).data('value'));
        }
        var reqData = objFromUrl();
        USER.getSearchItems(reqData, 1);
    }

    //function for show the filter modal
    function showFilterModal() {
        $("#filterModal").css("display", "block");
        $("#snackbar").css("z-index", "10");
    }

    function showMap(){
        $(".map").css("display", "block");
        google.maps.event.trigger(map, 'resize');
        $(".search-sidebar").css("display", "none");
        $("#snackBar-map").css("display", "none");
        $("#snackBar-list").css("display", "inline-block");
        $("#header").css("display" , "none");
        $(".mg-top").attr("style" , "margin-top: 0px !important; padding-right: 0 !important;");
    }

    function hideMap() {
        $(".search-sidebar").css("display", "block");
        $(".map").css("display", "none");
        $("#snackBar-list").css("display", "none");
        $("#snackBar-map").css("display", "inline-block");
        $("#header").css("display" , "block");
        $(".mg-top").removeAttr("style");
    }

    // Get the modal
    var modal = document.getElementById('filterModal');
    // When the user clicks anywhere outside of the modal, close it
    window.onclick = function (event) {
        if (event.target == modal) {
            modal.style.display = "none";
        }
    }
</script>
<!--end snackBar and filter modal-->

<input type="hidden" value="search" id="currentRout">
<script type="text/javascript">
    $(function () {
        var params = objFromUrl();
        USER.getSearchItems(objFromUrl(), 1);
    });
</script>
<section class="s5">
    <div class="mg-top">
        <div class="col-xs-12 col-sm-7 search-sidebar">
            <!-- sidebar -->

            <div class="filter-container hidden-xs">
                <div class="panel-body date">
                    <div class="row">
                        <div class="col-lg-2 col-md-12 text-center-sm text-center-md pad-l-0">
                            <label>تاریخ</label>
                        </div>
                        <form class="col-lg-9 trip-form flt-rtl">
                            <div class="row row-condensed">
                                <div class="col-xs-4 row-space-1-sm filter-date-input-container">
                                    <input value="" class="form-control form-control-date" name="checkin"
                                           type="text" id="checkin1" autocomplete="off" placeholder="زمان رفت">
                                </div>
                                <div class="col-xs-4 row-space-1-sm filter-date-input-container">
                                    <input value="" type="text" class="form-control form-control-date"
                                           name="checkout" id="checkout1" autocomplete="off"
                                           placeholder="زمان برگشت">

                                </div>
                                <div class="col-xs-4  row-space-1-sm filter-date-input-container">
                                    <div class="select select-block">
                                        <select tag="search" value="" name="guests" class="form-control"
                                                id="guest-select">
                                            <option value="1">۱ نفر</option>
                                            <option value="2">۲ نفر</option>
                                            <option value="3">۳ نفر</option>
                                            <option value="4">۴ نفر</option>
                                            <option value="5">۵ نفر</option>
                                            <option value="6">۶ نفر</option>
                                            <option value="7">۷ نفر</option>
                                            <option value="8">۸ نفر</option>
                                            <option value="9">۹ نفر</option>
                                            <option value="10">۱۰ نفر</option>
                                            <option value="11">۱۱ نفر</option>
                                            <option value="12">۱۲ نفر</option>
                                            <option value="13">۱۳ نفر</option>
                                            <option value="14">۱۴ نفر</option>
                                            <option value="15">۱۵ نفر</option>
                                            <option value="16">+۱۶ نفر</option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>

                <div class="col-sm-12 panel-body">
                    <div class="row">
                        <div class="col-lg-2 col-md-12 text-center-sm text-center-md pad-l-0">
                            <label>محدوده قیمت</label>
                        </div>
                        <div class="col-lg-9  col-xs-12 col-lg-offset-0 col-xs-offset-0">
                            <div class="average-price-result">
                                میانگین قیمت - <b></b> تومان
                            </div>
                            <div class="row price-slider-container ">
                                <input onkeyup="changeSlider()" tag="search" class="col-xs-1 price-input price_max"
                                       id="sliderParent" type="number" value="1000">
                                <div class="row row-slider col-xs-8 " id="price-slider5"></div> <!-- range slider -->
                                <!— range slider —>
                                <!--<div class="price-input-container">-->
                                <input onkeyup="changeSlider()" class="col-xs-1 price-input price_min" type="number"
                                       value="10">

                                <!--</div>-->
                            </div>
                            <div class="row" style="display: flex; justify-content: center">
                                <div class="col-xs-6 flt-rtl-always range" id="start-point">۱ میلیون تومان</div>
                                <div class="col-xs-5 text-right range" id="end-point">۱۰ هزار تومان</div>
                            </div>
                        </div>
                    </div>
                </div>


                <div class="col-sm-12 panel-body filters-section">
                    <div class="row">
                        <div class="col-lg-2 col-md-12 text-center-sm text-center-md pad-l-0">
                            <label class="display_inline">اندازه</label>
                        </div>
                        <div class="col-lg-9 col-xs-12 flt-rtl">
                            <div class="row row-condensed">
                                <div class="col-xs-4 row-space-1-sm filter-date-input-container">
                                    <div class="select select-block">
                                        <select tag="search" name="bedroom_count" class="form-control"
                                                id="room-select"
                                                onchange="if (typeof(this.selectedIndex) != 'undefined')selectingFilterOptions(this.name , this.selectedIndex , this.id , '')">
                                            <option value="remove">اتاق خواب</option>
                                            <option value="1">۱ خواب</option>
                                            <option value="2">۲ خواب</option>
                                            <option value="3">۳ خواب</option>
                                            <option value="4">۴ خواب</option>
                                            <option value="5">۵ خواب</option>
                                            <option value="6">۶ خواب</option>
                                            <option value="7">۷ خواب</option>
                                            <option value="8">۸ خواب</option>
                                            <option value="9">۹ خواب</option>
                                            <option value="10">+&zwnj;۱۰ خواب</option>

                                        </select>
                                    </div>
                                </div>
                                <div class="col-xs-4  row-space-1-sm filter-date-input-container">
                                    <div class="select select-block">
                                        <select tag="search" name="bed_count" class="form-control" id="bed-select"
                                                onchange="if (typeof(this.selectedIndex) != 'undefined')selectingFilterOptions(this.name , this.selectedIndex , this.id , '')">
                                            <option value="remove">تخت</option>
                                            <option value="1">۱ تخت</option>
                                            <option value="2">۲ تخت</option>
                                            <option value="3">۳ تخت</option>
                                            <option value="4">۴ تخت</option>
                                            <option value="5">۵ تخت</option>
                                            <option value="6">۶ تخت</option>
                                            <option value="7">۷ تخت</option>
                                            <option value="8">۸ تخت</option>
                                            <option value="9">۹ تخت</option>
                                            <option value="10">۱۰ تخت</option>
                                            <option value="11">۱۱ تخت</option>
                                            <option value="12">۱۲ تخت</option>
                                            <option value="13">۱۳ تخت</option>
                                            <option value="14">۱۴ تخت</option>
                                            <option value="15">۱۵ تخت</option>
                                            <option value="16">+&zwnj;۱۶ تخت</option>

                                        </select>
                                    </div>
                                </div>

                                <div class="col-xs-4 row-space-1-sm filter-date-input-container">
                                    <div class="select select-block">
                                        <select tag="search" name="guests" class="form-control"
                                                id="capacity-select"
                                                onchange="if (typeof(this.selectedIndex) != 'undefined')selectingFilterOptions(this.name , this.selectedIndex , this.id ,'حداکثر ظرفیت: ')">
                                            <option value="remove">حداکثر ظرفیت</option>
                                            <option value="1">۱ نفر</option>
                                            <option value="2">۲ نفر</option>
                                            <option value="3">۳ نفر</option>
                                            <option value="4">۴ نفر</option>
                                            <option value="5">۵ نفر</option>
                                            <option value="6">۶ نفر</option>
                                            <option value="7">۷ نفر</option>
                                            <option value="8">۸ نفر</option>
                                            <option value="9">۹ نفر</option>
                                            <option value="10">۱۰ نفر</option>
                                            <option value="11">۱۱ نفر</option>
                                            <option value="12">۱۲ نفر</option>
                                            <option value="13">۱۳ نفر</option>
                                            <option value="14">۱۴ نفر</option>
                                            <option value="15">۱۵ نفر</option>
                                            <option value="16">۱۶ نفر</option>
                                            <option value="17">۱۷ نفر</option>
                                            <option value="18">۱۸ نفر</option>
                                            <option value="19">۱۹ نفر</option>
                                            <option value="20">+&zwnj;۲۰ نفر</option>

                                        </select>
                                    </div>
                                </div>


                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-sm-12 panel-body filters-section">

                    <div class="row">
                        <div class="row">
                            <div class="col-sm-1 showMore">
                                <label class="show-more" onclick="rotateArrowOfFilter(this)" data-toggle="collapse"
                                       data-target="#filter-main">
                                        <span>
									<i class="fa fa-caret-left"></i>
									 <span>فیلترهای بیشتر</span>
                                        </span>
                                </label>
                            </div>
                        </div>

                        <div class="col-sm-11 col-xs-12 col-lg-offset-1 col-md-offset-1 col-xs-offset-1 padding-filter">
                            <div class="row row-condensed labels ">
                            </div>
                            <div id="filter-main" class="filters-more collapse-filter collapse" aria-expanded="true">

                                <div class="row">
                                    <div class="row">
                                        <div class="col-sm-1 showMore">
                                            <label class="show-more" onclick="rotateArrowOfFilter(this)"
                                                   data-toggle="collapse" data-target="#filter-0">
                                                    <span>
											<i class="fa fa-caret-left"></i>
											 <span>امکانات</span>
                                                    </span>
                                            </label>
                                        </div>
                                    </div>


                                    <div class="col-xs-12 col-lg-offset-1 col-md-offset-1 col-xs-offset-0 padding-filter">
                                        <div class="row row-condensed labels ">
                                        </div>
                                        <div id="filter-0" class="filters-more collapse-filter collapse"
                                             aria-expanded="true">
                                            <div class="row row-condensed filters-columns">

                                                <div class="col-xs-6 col-sm-4 row-space-1-sm">
                                                        <span class="filter-label">
													<span>
														<input tag="search" type="checkbox" name="amenities"
                                                               value="internet" onclick="checkingFilterChekBox(this)"
                                                               data-smartlook_2fecb6293ed16="false">
													</span>
                                                        <label onclick="clickOnFilterCheckBoxLabel(this)">اینترنت وایرلس</label>
                                                        </span>
                                                </div>

                                                <div class="col-xs-6 col-sm-4 row-space-1-sm">
                                                        <span class="filter-label">
													<span>
														<input tag="search" type="checkbox" name="amenities"
                                                               value="barbecue" onclick="checkingFilterChekBox(this)"
                                                               data-smartlook_2fecb6293ed16="false">
													</span>
                                                        <label onclick="clickOnFilterCheckBoxLabel(this)">باربیکیو</label>
                                                        </span>
                                                </div>

                                                <div class="col-xs-6 col-sm-4  row-space-1-sm">
                                                        <span class="filter-label">
													<span>
														<input tag="search" type="checkbox" name="amenities"
                                                               value="heating" onclick="checkingFilterChekBox(this)"
                                                               data-smartlook_2fecb6293ed16="false">
													</span>
                                                        <label onclick="clickOnFilterCheckBoxLabel(this)">گرمایش</label>
                                                        </span>
                                                </div>
                                                <div class="col-xs-6 col-sm-4  row-space-1-sm">
                                                        <span class="filter-label">
													<span>
														<input tag="search" type="checkbox" name="amenities"
                                                               value="water_cooling"
                                                               onclick="checkingFilterChekBox(this)"
                                                               data-smartlook_2fecb6293ed16="false">
													</span>
                                                        <label onclick="clickOnFilterCheckBoxLabel(this)">کولر آبی</label>
                                                        </span>
                                                </div>
                                                <div class="col-xs-6 col-sm-4  row-space-1-sm">
                                                        <span class="filter-label">
													<span>
														<input tag="search" type="checkbox" name="amenities"
                                                               value="split_cooling"
                                                               onclick="checkingFilterChekBox(this)"
                                                               data-smartlook_2fecb6293ed16="false">
													</span>
                                                        <label onclick="clickOnFilterCheckBoxLabel(this)">کولر گازی</label>
                                                        </span>
                                                </div>
                                                <div class="col-xs-6 col-sm-4  row-space-1-sm">
                                                        <span class="filter-label">
													<span>
														<input tag="search" type="checkbox" name="amenities"
                                                               value="breakfast" onclick="checkingFilterChekBox(this)"
                                                               data-smartlook_2fecb6293ed16="false">
													</span>
                                                        <label onclick="clickOnFilterCheckBoxLabel(this)">صبحانه</label>
                                                        </span>
                                                </div>
                                                <div class="col-xs-6 col-sm-4  row-space-1-sm">
                                                        <span class="filter-label">
													<span>
														<input tag="search" type="checkbox" name="amenities"
                                                               value="television" onclick="checkingFilterChekBox(this)"
                                                               data-smartlook_2fecb6293ed16="false">
													</span>
                                                        <label onclick="clickOnFilterCheckBoxLabel(this)">تلویزیون</label>
                                                        </span>
                                                </div>
                                                <div class="col-xs-6 col-sm-4  row-space-1-sm">
                                                        <span class="filter-label">
													<span>
														<input tag="search" type="checkbox" name="amenities"
                                                               value="parking" onclick="checkingFilterChekBox(this)"
                                                               data-smartlook_2fecb6293ed16="false">
													</span>
                                                        <label onclick="clickOnFilterCheckBoxLabel(this)">پارکینگ</label>
                                                        </span>
                                                </div>

                                                <div class="col-xs-6 col-sm-4  row-space-1-sm">
                                                        <span class="filter-label">
													<span>
														<input tag="search" type="checkbox" name="amenities"
                                                               value="elevator" onclick="checkingFilterChekBox(this)"
                                                               data-smartlook_2fecb6293ed16="false">
													</span>
                                                        <label onclick="clickOnFilterCheckBoxLabel(this)">آسانسور</label>
                                                        </span>
                                                </div>
                                                <div class="col-xs-6 col-sm-4  row-space-1-sm">
                                                        <span class="filter-label">
													<span>
														<input tag="search" type="checkbox" name="amenities"
                                                               value="furniture" onclick="checkingFilterChekBox(this)"
                                                               data-smartlook_2fecb6293ed16="false">
													</span>
                                                        <label onclick="clickOnFilterCheckBoxLabel(this)">مبلمان</label>
                                                        </span>
                                                </div>

                                                <div class="col-xs-6 col-sm-4  row-space-1-sm">
                                                        <span class="filter-label">
													<span>
														<input tag="search" type="checkbox" name="amenities"
                                                               value="european_wc" onclick="checkingFilterChekBox(this)"
                                                               data-smartlook_2fecb6293ed16="false">
													</span>
                                                        <label onclick="clickOnFilterCheckBoxLabel(this)">سرویس فرنگی</label>
                                                        </span>
                                                </div>
                                                <div class="col-xs-6 col-sm-4  row-space-1-sm">
                                                        <span class="filter-label">
													<span>
														<input tag="search" type="checkbox" name="amenities"
                                                               value="kitchen_equipment"
                                                               onclick="checkingFilterChekBox(this)"
                                                               data-smartlook_2fecb6293ed16="false">
													</span>
                                                        <label onclick="clickOnFilterCheckBoxLabel(this)">تجهیزات آشپزی</label>
                                                        </span>
                                                </div>

                                                <div class="col-xs-6 col-sm-4  row-space-1-sm">
                                                        <span class="filter-label">
													<span>
														<input tag="search" type="checkbox" name="amenities"
                                                               value="balcony" onclick="checkingFilterChekBox(this)"
                                                               data-smartlook_2fecb6293ed16="false">
													</span>
                                                        <label onclick="clickOnFilterCheckBoxLabel(this)">تراس</label>
                                                        </span>
                                                </div>

                                                <div class="col-xs-6 col-sm-4  row-space-1-sm">
													<span class="filter-label">
														<span>
															<input tag="search" type="checkbox" name="amenities"
                                                                   value="bathroom"
                                                                   onclick="checkingFilterChekBox(this)"
                                                                   data-smartlook_2fecb6293ed16="false">
														</span>
														<label onclick="clickOnFilterCheckBoxLabel(this)">حمام</label>
													</span>
                                                </div>

                                                <div class="col-xs-6 col-sm-4  row-space-1-sm">
													<span class="filter-label">
														<span>
															<input tag="search" type="checkbox" name="amenities"
                                                                   value="outdoor_pool"
                                                                   onclick="checkingFilterChekBox(this)"
                                                                   data-smartlook_2fecb6293ed16="false">
														</span>
														<label onclick="clickOnFilterCheckBoxLabel(this)">استخر سرباز</label>
													</span>
                                                </div>

                                                <div class="col-xs-6 col-sm-4  row-space-1-sm">
													<span class="filter-label">
														<span>
															<input tag="search" type="checkbox" name="amenities"
                                                                   value="indoor_pool"
                                                                   onclick="checkingFilterChekBox(this)"
                                                                   data-smartlook_2fecb6293ed16="false">
														</span>
														<label onclick="clickOnFilterCheckBoxLabel(this)">استخر سرپوشیده</label>
													</span>
                                                </div>

                                                <div class="col-xs-6 col-sm-4  row-space-1-sm">
													<span class="filter-label">
														<span>
															<input tag="search" type="checkbox" name="amenities"
                                                                   value="receiver"
                                                                   onclick="checkingFilterChekBox(this)"
                                                                   data-smartlook_2fecb6293ed16="false">
														</span>
														<label onclick="clickOnFilterCheckBoxLabel(this)"> گیرنده دیجیتال</label>
													</span>
                                                </div>

                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="row">
                                        <div class="col-sm-1 showMore">
                                            <label class="show-more" onclick="rotateArrowOfFilter(this)"
                                                   data-toggle="collapse" data-target="#filter-1">
                                                    <span>
											<i class="fa fa-caret-left"></i>
											 <span>نوع محل</span>
                                                    </span>
                                            </label>
                                        </div>
                                    </div>


                                    <div class="col-xs-12 col-lg-offset-1 col-md-offset-1 col-xs-offset-0 padding-filter">
                                        <div class="row row-condensed labels ">
                                        </div>
                                        <div id="filter-1" class="filters-more collapse-filter collapse"
                                             aria-expanded="true">
                                            <div class="row row-condensed filters-columns">

                                                <div class="col-xs-6 col-sm-4 row-space-1-sm">
                                                        <span class="filter-label">
													<span>
														<input tag="search" type="checkbox" name="amenities"
                                                               value="detached" onclick="checkingFilterChekBox(this)"
                                                               data-smartlook_2fecb6293ed16="false">
													</span>
                                                        <label onclick="clickOnFilterCheckBoxLabel(this)">دربست</label>
                                                        </span>
                                                </div>
                                                <div class="col-xs-6 col-sm-4  row-space-1-sm">
                                                        <span class="filter-label">
													<span>
														<input tag="search" type="checkbox" name="amenities"
                                                               value="in_complex" onclick="checkingFilterChekBox(this)"
                                                               data-smartlook_2fecb6293ed16="false">
													</span>
                                                        <label onclick="clickOnFilterCheckBoxLabel(this)">داخل شهرک</label>
                                                        </span>
                                                </div>
                                                <div class="col-xs-6 col-sm-4  row-space-1-sm">
                                                        <span class="filter-label">
													<span>
														<input tag="search" type="checkbox" name="amenities"
                                                               value="janitor" onclick="checkingFilterChekBox(this)"
                                                               data-smartlook_2fecb6293ed16="false">
													</span>
                                                        <label onclick="clickOnFilterCheckBoxLabel(this)">سرایدار</label>
                                                        </span>
                                                </div>

                                                <div class="col-xs-6 col-sm-4  row-space-1-sm">
                                                        <span class="filter-label">
													<span>
														<input tag="search" type="checkbox" name="amenities"
                                                               value="private_yard"
                                                               onclick="checkingFilterChekBox(this)"
                                                               data-smartlook_2fecb6293ed16="false">
													</span>
                                                        <label onclick="clickOnFilterCheckBoxLabel(this)">حیاط در اختیار</label>
                                                        </span>
                                                </div>

                                                <div class="col-xs-6 col-sm-4  row-space-1-sm">
                                                        <span class="filter-label">
													<span>
														<input tag="search" type="checkbox" name="amenities"
                                                               value="shared_yard" onclick="checkingFilterChekBox(this)"
                                                               data-smartlook_2fecb6293ed16="false">
													</span>
                                                        <label onclick="clickOnFilterCheckBoxLabel(this)">حیاط مشترک</label>
                                                        </span>
                                                </div>

                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="row">
                                        <div class="col-sm-1 showMore">
                                            <label class="show-more" onclick="rotateArrowOfFilter(this)"
                                                   data-toggle="collapse" data-target="#filter-2">
                                                    <span>
											<i class="fa fa-caret-left"></i>
											 <span> نوع ساختمان</span>
                                                    </span>
                                            </label>
                                        </div>
                                    </div>


                                    <div class="col-xs-12 col-lg-offset-1 col-md-offset-1 col-xs-offset-0 padding-filter">
                                        <div class="row row-condensed labels ">
                                        </div>
                                        <div id="filter-2" class="filters-more collapse-filter collapse"
                                             aria-expanded="true">
                                            <div class="row row-condensed filters-columns">

                                                <div class="col-xs-6 col-sm-4 row-space-1-sm">
                                                        <span class="filter-label">
													<span>
														<input tag="search" type="checkbox" name="amenities"
                                                               value="villa" onclick="checkingFilterChekBox(this)"
                                                               data-smartlook_2fecb6293ed16="false">
													</span>
                                                        <label onclick="clickOnFilterCheckBoxLabel(this)">خانه ویلایی</label>
                                                        </span>
                                                </div>

                                                <div class="col-xs-6 col-sm-4  row-space-1-sm">
                                                        <span class="filter-label">
													<span>
														<input tag="search" type="checkbox" name="amenities"
                                                               value="apartment" onclick="checkingFilterChekBox(this)"
                                                               data-smartlook_2fecb6293ed16="false">
													</span>
                                                        <label onclick="clickOnFilterCheckBoxLabel(this)">آپارتمان</label>
                                                        </span>
                                                </div>

                                                <div class="col-xs-6 col-sm-4  row-space-1-sm">
                                                        <span class="filter-label">
													<span>
														<input tag="search" type="checkbox" name="amenities"
                                                               value="room" onclick="checkingFilterChekBox(this)"
                                                               data-smartlook_2fecb6293ed16="false">
													</span>
                                                        <label onclick="clickOnFilterCheckBoxLabel(this)">سوئیت</label>
                                                        </span>
                                                </div>

                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="row">
                                        <div class="col-sm-1 showMore">
                                            <label class="show-more" onclick="rotateArrowOfFilter(this)"
                                                   data-toggle="collapse" data-target="#filter-3">
                                                    <span>
											<i class="fa fa-caret-left"></i>
											 <span>بافت</span>
                                                    </span>
                                            </label>
                                        </div>
                                    </div>


                                    <div class="col-xs-12 col-lg-offset-1 col-md-offset-1 col-xs-offset-0 padding-filter">
                                        <div class="row row-condensed labels ">
                                        </div>
                                        <div id="filter-3" class="filters-more collapse-filter collapse"
                                             aria-expanded="true">
                                            <div class="row row-condensed filters-columns">

                                                <div class="col-xs-6 col-sm-4 row-space-1-sm">
                                                        <span class="filter-label">
													<span>
														<input tag="search" type="checkbox" name="amenities"
                                                               value="forest" onclick="checkingFilterChekBox(this)"
                                                               data-smartlook_2fecb6293ed16="false">
													</span>
                                                        <label onclick="clickOnFilterCheckBoxLabel(this)">جنگلی</label>
                                                        </span>
                                                </div>
                                                <div class="col-xs-6 col-sm-4  row-space-1-sm">
                                                        <span class="filter-label">
													<span>
														<input tag="search" type="checkbox" name="amenities"
                                                               value="mountain" onclick="checkingFilterChekBox(this)"
                                                               data-smartlook_2fecb6293ed16="false">
													</span>
                                                        <label onclick="clickOnFilterCheckBoxLabel(this)">کوهستانی</label>
                                                        </span>
                                                </div>
                                                <div class="col-xs-6 col-sm-4  row-space-1-sm">
                                                        <span class="filter-label">
													<span>
														<input tag="search" type="checkbox" name="amenities"
                                                               value="desert" onclick="checkingFilterChekBox(this)"
                                                               data-smartlook_2fecb6293ed16="false">
													</span>
                                                        <label onclick="clickOnFilterCheckBoxLabel(this)">کویری</label>
                                                        </span>
                                                </div>

                                                <div class="col-xs-6 col-sm-4  row-space-1-sm">
                                                        <span class="filter-label">
													<span>
														<input tag="search" type="checkbox" name="amenities"
                                                               value="coastal" onclick="checkingFilterChekBox(this)"
                                                               data-smartlook_2fecb6293ed16="false">
													</span>
                                                        <label onclick="clickOnFilterCheckBoxLabel(this)">ساحلی</label>
                                                        </span>
                                                </div>

                                                <div class="col-xs-6 col-sm-4  row-space-1-sm">
                                                        <span class="filter-label">
													<span>
														<input tag="search" type="checkbox" name="amenities"
                                                               value="in_town" onclick="checkingFilterChekBox(this)"
                                                               data-smartlook_2fecb6293ed16="false">
													</span>
                                                        <label onclick="clickOnFilterCheckBoxLabel(this)">درون شهری</label>
                                                        </span>
                                                </div>

                                                <div class="col-xs-6 col-sm-4  row-space-1-sm">
                                                        <span class="filter-label">
													<span>
														<input tag="search" type="checkbox" name="amenities"
                                                               value="historic" onclick="checkingFilterChekBox(this)"
                                                               data-smartlook_2fecb6293ed16="false">
													</span>
                                                        <label onclick="clickOnFilterCheckBoxLabel(this)">بنای تاریخی</label>
                                                        </span>
                                                </div>

                                                <div class="col-xs-6 col-sm-4  row-space-1-sm">
                                                        <span class="filter-label">
													<span>
														<input tag="search" type="checkbox" name="amenities"
                                                               value="rural" onclick="checkingFilterChekBox(this)"
                                                               data-smartlook_2fecb6293ed16="false">
													</span>
                                                        <label onclick="clickOnFilterCheckBoxLabel(this)">روستایی</label>
                                                        </span>
                                                </div>

                                                <div class="col-xs-6 col-sm-4  row-space-1-sm">
                                                        <span class="filter-label">
													<span>
														<input tag="search" type="checkbox" name="amenities"
                                                               value="summer" onclick="checkingFilterChekBox(this)"
                                                               data-smartlook_2fecb6293ed16="false">
													</span>
                                                        <label onclick="clickOnFilterCheckBoxLabel(this)">ییلاقی</label>
                                                        </span>
                                                </div>

                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="row">
                                        <div class="col-sm-1 showMore">
                                            <label class="show-more" onclick="rotateArrowOfFilter(this)"
                                                   data-toggle="collapse" data-target="#filter-4">
                                                    <span>
											<i class="fa fa-caret-left"></i>
											 <span>قوانین</span>
                                                    </span>
                                            </label>
                                        </div>
                                    </div>


                                    <div class="col-xs-12 col-lg-offset-1 col-md-offset-1 col-xs-offset-0 padding-filter">
                                        <div class="row row-condensed labels ">
                                        </div>
                                        <div id="filter-4" class="filters-more collapse-filter collapse"
                                             aria-expanded="true">
                                            <div class="row row-condensed filters-columns">

                                                <div class="col-xs-6 row-space-1-sm">
                                                        <span class="filter-label">
													<span>
														<input tag="search" type="checkbox" name="amenities"
                                                               value="rule_cermony"
                                                               onclick="checkingFilterChekBox(this)"
                                                               data-smartlook_2fecb6293ed16="false">
													</span>
                                                        <label onclick="clickOnFilterCheckBoxLabel(this)">امکان برگزاری مراسم</label>
                                                        </span>
                                                </div>

                                                <div class="col-xs-6  row-space-1-sm" style="padding: 0">
                                                        <span class="filter-label">
													<span>
														<input tag="search" type="checkbox" name="amenities"
                                                               value="rule_pets" onclick="checkingFilterChekBox(this)"
                                                               data-smartlook_2fecb6293ed16="false">
													</span>
                                                        <label onclick="clickOnFilterCheckBoxLabel(this)">امکان ورود حیوانات خانگی</label>
                                                        </span>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                            </div>
                            <!-- more filters -->
                        </div>

                    </div>

                </div>
            </div>
            <button id="filter-search-btn" class="hidden btn col-xs-10 col-xs-offset-1 btn-default top-6"
                    onclick="searchFromMobile()">جستجو
            </button>
            <div class="col-sm-12 search-result pad-xs-0">


                <!--start choosed filters-->
                <div id="filter-choosed-container" class="row">
                    <!— #new —>
                    <span id="location-result" class="filter-choosed filter-choosed-fixed">
                          <span class="filter-choosed-txt choosed_city"></span>
                           - 
                          <span class="filter-choosed-txt choosed_count"></span>
					</span>

                    <span id="clearAll-result" class="filter-choosed filter-choosed-fixed" onclick="clickOnClearAllFilter()">
                          <span class="filter-choosed-txt">پاک کردن همه</span>
					</span>


                </div>
                <!--end choosed filters-->

                <div style="clear: both"></div>
                <!--start filter dropBox-->
                <div class="row filter-dropBox-row">
                    <div>
                        <div>مرتب‌سازی براساس</div>
                        <div class="filter-dropBox-container" tabindex="1">
                            <div class="filter-dropBox-field">
                                <span class="filter-dropBox-field-txt">بیشترین امتیاز</span>
                                <input class="filter-dropBox-field-input" name="sortby" value="1" hidden>
                                <span class="filter-dropBox-field-arrow"><i class="fa fa-chevron-down"
                                                                            aria-hidden="true"></i></span>
                            </div>
                            <ul class="filter-dropBox-box">
                                <li data="10">بیشترین امتیاز</li>
                                <li data="1">جدیدترین</li>
                                <li data="2">گرانترین</li>
                                <li data="3">ارزران‌ترین</li>
                                {{--<li data="4">بیشترین نظر</li>--}}
                                {{--<li data="5">بیشترین عکس</li>--}}
                                <li data="6">بیشترین درخواست</li>
                                {{--<li data="7">بیشترین رزرو</li>--}}
                                {{--<li data="8">پربازدیدترین</li>--}}
                                <li data="9">محبوب‌ترین</li>
                            </ul>
                        </div>
                    </div>

                    <div>
                        <div>نمایش قیمت</div>
                        <div class="filter-dropBox-container" tabindex="1">
                            <div class="filter-dropBox-field">
                                <span class="filter-dropBox-field-txt">روزهای وسط هفته</span>
                                <input class="filter-dropBox-field-input" name="price_order" value="0" hidden>
                                <span class="filter-dropBox-field-arrow"><i class="fa fa-chevron-down"
                                                                            aria-hidden="true"></i></span>
                            </div>
                            <ul class="filter-dropBox-box">
                                <li data="0">روزهای وسط هفته</li>
                                <li data="1">روزهای آخر هفته</li>
                                <li data="2">ایام پیک</li>
                            </ul>
                        </div>
                    </div>
                </div>
                <!--end filter dropBox-->


                <div class="col-sm-12 result-description">
                    <span></span>
                </div>


                <!--start search result item-->

                <div class="search-result-list-container">
                    <div class="s-list">

                        <!--start search result list-->
                        <div id="searchResultListContainer" class="row"
                        >

                        </div>
                        <!--end search result list-->
                    </div>
                </div>

                <div style="display: none;" id="searchItemTemplate">
                    <div class="col-sm-6 col-sm-offset-0 col-xs-8 col-xs-offset-2 list-item">
                        <!-- search result item -->
                        <div id="item-id" class="item-main">
                            <img src="" class="fullImg">
                            <a href="" target="_blank" id="item-a" class="item-desc">
                                <!-- <div class="item-like">
                                <i class="fa fa-heart"></i>
                                <i class="fa fa-heart-o"></i>
                            </div> -->
                                <div class="col-xs-1 slidesec slide-left">
                                    <div class="icon-center text-center">
                                        <div class="slide left"></div>
                                        <div class="slide left leftdown"></div>
                                    </div>
                                </div>
                                <div class="col-xs-1 slidesec slide-right">
                                    <div class="icon-center text-center">
                                        <div class="slide rightdown"></div>
                                        <div class="slide rightup"></div>
                                    </div>
                                </div>
                                <div class="load-spinner"></div>
                                <div class="item-price">
                                    <span id="item-price" class="priceReadable"></span>
                                    <!-- <small><lng key="search.currency"></lng></small> -->
                                    <!--	<small class="gray"><lng key="search.perMonth"></lng></small> -->
                                </div>
                            </a>

                        </div>
                        <div class="panel-body panel-card-section">
                            <div class="media">
                                <a href="#" class="media-photo-badge pull-right card-profile-picture">
                                    <div class="media-photo media-round">
                                        <img class="userImg" src="https://www.shab.ir/img/user-default.png">
                                    </div>
                                </a>
                                <div class="item-info">
                                        <span>
											<a id="item-a" target="_blank" href="">
												<h4 id="item-title"></h4>
												<span id="item-type" style="float: left;font-size: 14px;"></span>
                                        <div style="visibility: hidden;" class="star-rating">
                                            <div class="foreground">
                                                <i class="fa fa-star star-1"></i>
                                                <i class="fa fa-star"></i>
                                                <i class="fa fa-star"></i>
                                                <i class="fa fa-star"></i>
                                                <i class="fa fa-star"></i>
                                            </div>
                                            <div class="background">
                                                <i class="fa fa-star "></i>
                                                <i class="fa fa-star"></i>
                                                <i class="fa fa-star star-0"></i>
                                                <i class="fa fa-star"></i>
                                                <i class="fa fa-star"></i>
                                            </div>
                                        </div>
                                        <span style="visibility: hidden;" id="reviewCount">۰</span><span
                                                        style="visibility: hidden;"> دیدگاه</span>

                                        </a>
                                        </span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <input type="hidden" name="Search" tag="search">

                <div class="results-footer">

                    <div class="search-page-buttons">
                        <div class="results-count">
                            <p class="items-count text-left" style="text-align: center;"><span id="firstItem"></span> -
                                <span id="lastItem"></span> از <span id="itemsCount"></span> نتیجه</p>
                        </div>
                        <div class="paginate">
                            <ul class="list-unstyled">
                            </ul>
                        </div>
                    </div>
                </div>

                <div style="text-align: justify; margin-bottom: 40px">
                    @if(! empty($seo_content))
                        {!! $seo_content !!}
                    @endif
                </div>
            </div>
        </div>
        <div class="col-xs-12 col-sm-5 map map-container" style="overflow: hidden">
            <div class="map-search-checkBox" style="visibility: hidden">
                <input type="checkBox" id="searchByMap" value="searchOnMap"/>
                <span>
                    جستجو با تغییر نقشه
                  </span>
            </div>
            <div id="mapSearchClose" class="map-search-close visible-xs" onclick="hideMap()">
                <span class="filter-modal-close" title="Close Modal">×</span>
            </div>
            <div class="col-xs-12 map" style="z-index: 1; position: relative; overflow: hidden; padding: 0;" id="map">

            </div>
        </div>

        <script src="{{ asset('js/CustomGoogleMapMarker.js?v=1.0') }}"></script>

    </div>
</section>
<script>
    function rotateArrowOfFilter(el) {
        if ($(el).find("i").attr("class") == "fa fa-caret-left") {
            $(el).find("i").removeClass("fa-caret-left");
            $(el).find("i").addClass("fa-caret-down");
        }
        else {
            $(el).find("i").removeClass("fa-caret-down");
            $(el).find("i").addClass("fa-caret-left");
        }
    }

    function checkingFilterChekBox(el) {
        if($("#filter-choosed-container").children().length > 1)
            $("#clearAll-result").css("display" , "inline-block");
        if ($(el).is(':checked'))
            $("#filter-choosed-container").append(filterChoosedItemMaker($(el).parent().parent().children("label").html(), $(el).val(), "checkBox", 1));
        else
            $("#" + $(el).val()).remove();
    }
    function selectingFilterOptions(id, el, parentId, type) {
        if($("#filter-choosed-container").children().length > 1)
            $("#clearAll-result").css("display" , "inline-block");
        if (el > 0) {
            el = document.getElementById(parentId).options[el];
            $("#" + id).remove();
            $("#filter-choosed-container").append(filterChoosedItemMaker(type + $(el).html(), id, parentId, $(el).val()));
        }
        else if (el === 0)
            $("#" + id).remove();
    }

    function clickOnClearAllFilter () {
        $(".filter-choosed:not(#location-result,#clearAll-result)").remove();
        $("#clearAll-result").css("display" , "none");
        $(".filter-label").find("input").prop("checked", false);
        $("select.form-control option[value = 'remove']").prop("selected", true);
        var url = window.location.href;
        var url = url.substr(0, url.indexOf('?'));
        window.history.pushState('', "removeUrlParam", url);
        doSearch($("input[name='price_min']"));
    }

    function clickOnFilterCheckBoxLabel(el) {
        $(el).parent().find("input").click();
    }


    function closeBtnChoosedFilter(el) {
        if ($(el).attr("name") == "checkBox")
            $("input[value=" + $(el).parent().attr('id') + "]").prop("checked", false);
        else
            $("#" + $(el).attr("name") + " option[value = 'remove']").prop("selected", true);

        removeUrlParam(encodeURIComponent($(el).parent().attr('id')), getParameterByName($(el).parent().attr('id')));
        $(el).parent().remove();
        if($("#filter-choosed-container").children().length == 2)
            $("#clearAll-result").css("display" , "none");
        doSearch($("input[name=" + $(el).parent().attr('id') + "]"));
    }

    function filterChoosedItemMaker(text, name, type, value) {
        var txt = '<span id="'+name+'" data-value="'+value+'" class="filter-choosed">';
        txt += '<span class="filter-choosed-txt">';
        txt += text;
        txt += '</span>';
        txt += '<span class="filter-choosed-close" name="' + type + '" onclick="closeBtnChoosedFilter(this)">';
        txt += '&times;';
        txt += '</span>';
        txt += '</span>';

        return txt;
    }
</script>


<div class="visible-xs">
</div>

<script type="text/javascript">

    var slider = document.getElementById('price-slider5');

    //Initial slider for width greater than 768px
    if ($(window).width() > 768) {
        initSlider(slider, 10, 1000);
    }

    //Initial slider function
    function initSlider(slider, min, max) {
        //Create price slider
        noUiSlider.create(slider, {
            start: [min, max],
            connect: true,
            step: 5,
            range: {
                'min': 10,
                'max': 1000
            }
        });

        //Update price slider
        slider.noUiSlider.on('update', function (values, handle) {
            var value = values[handle].split('.')[0];
            var inputValue = value;
            if (!handle) { // must change it back to if(handle). did it for rtl. must read lang from cookie.
                var currency = ' هزار تومان';
                if (value > 999) {
                    value /= 1000;
                    currency = ' میلیون تومان';
                }
                MIN = values[handle].split('.')[0];
                $("#end-point").text(value + currency); //end point
                $(".price_min").val(inputValue); //end point
                traverse($("#end-point")[0]);

            } else {
                var currency = ' هزار تومان';
                var preText = '';
                if (value > 999) {
                    value /= 1000;
                    currency = ' میلیون تومان';
                    preText = 'بیش از '
                }
                MAX = values[handle].split('.')[0];
                $("#start-point").text(preText + value + currency); //start point
                $(".price_max").val(inputValue); //end point
                traverse($("#start-point")[0]);
            }
            traverse($(".price-slider-container")[0]);
        });


        slider.noUiSlider.on('change', function (values, handle) {
            var value = values[handle].split('.')[0];
            if (!handle) {
                if (issetUrlParam('price_min')) {
                    updateUrlParam('price_min', encodeURIComponent(value));
                }
                else {
                    setUrlParam('price_min', encodeURIComponent(value));
                }
            } else {
                if (issetUrlParam('price_max')) {
                    updateUrlParam('price_max', encodeURIComponent(value));
                }
                else {
                    setUrlParam('price_max', encodeURIComponent(value));
                }

                if(encodeURIComponent(value) >= 1000) {
                    removeUrlParam('price_max', encodeURIComponent(value));
                }
            }

            $('#guest-select').trigger("change");
        });
    }

</script>

<div id="ui-datepicker-div"
     class="ui-datepicker ui-widget ui-widget-content ui-helper-clearfix ui-corner-all ui-datepicker-rtl"
     style="position: absolute; top: 99px; z-index: 4; display: none; left: inherit; right: 249.8px;">
    <div class="ui-datepicker-header ui-widget-header ui-helper-clearfix ui-corner-all"><a style="direction:ltr"
                                                                                           class="ui-datepicker-next ui-corner-all"
                                                                                           onclick="DP_jQuery_1497863063844.datepicker._adjustDate('#checkoutResult', +1, 'M');"
                                                                                           title="بعد"><span
                    class="ui-icon ui-icon-circle-triangle-w">بعد</span></a><a style="direction:ltr"
                                                                               class="ui-datepicker-prev ui-corner-all"
                                                                               onclick="DP_jQuery_1497863063844.datepicker._adjustDate('#checkoutResult', -1, 'M');"
                                                                               title="قبل"><span
                    class="ui-icon ui-icon-circle-triangle-e">قبل</span></a>
        <div class="ui-datepicker-title"><span class="ui-datepicker-month">خرداد</span>&nbsp;<span
                    class="ui-datepicker-year">1396</span>
        </div>
    </div>
    <table class="ui-datepicker-calendar">
        <thead>
        <tr>
            <th class="ui-datepicker-week-end"><span title="شنبه">ش</span>
            </th>
            <th class="ui-datepicker-week-end"><span title="يکشنبه">ي</span>
            </th>
            <th><span title="دوشنبه">د</span>
            </th>
            <th><span title="سه شنبه">س</span>
            </th>
            <th><span title="چهارشنبه">چ</span>
            </th>
            <th><span title="پنجشنبه">پ</span>
            </th>
            <th><span title="جمعه">ج</span>
            </th>
        </tr>
        </thead>
        <tbody>
        <tr>
            <td class=" ui-datepicker-week-end ui-datepicker-other-month ui-datepicker-unselectable ui-state-disabled">
                &nbsp;</td>
            <td class=" ui-datepicker-week-end ui-datepicker-other-month ui-datepicker-unselectable ui-state-disabled">
                &nbsp;</td>
            <td class=" "
                onclick="DP_jQuery_1497863063844.datepicker._selectDay('#checkoutResult',2,1396, this);return false;"><a
                        class="ui-state-default" href="#">1</a>
            </td>
            <td class=" "
                onclick="DP_jQuery_1497863063844.datepicker._selectDay('#checkoutResult',2,1396, this);return false;"><a
                        class="ui-state-default" href="#">2</a>
            </td>
            <td class=" "
                onclick="DP_jQuery_1497863063844.datepicker._selectDay('#checkoutResult',2,1396, this);return false;"><a
                        class="ui-state-default" href="#">3</a>
            </td>
            <td class=" "
                onclick="DP_jQuery_1497863063844.datepicker._selectDay('#checkoutResult',2,1396, this);return false;"><a
                        class="ui-state-default" href="#">4</a>
            </td>
            <td class=" "
                onclick="DP_jQuery_1497863063844.datepicker._selectDay('#checkoutResult',2,1396, this);return false;"><a
                        class="ui-state-default" href="#">5</a>
            </td>
        </tr>
        <tr>
            <td class=" ui-datepicker-week-end "
                onclick="DP_jQuery_1497863063844.datepicker._selectDay('#checkoutResult',2,1396, this);return false;"><a
                        class="ui-state-default" href="#">6</a>
            </td>
            <td class=" ui-datepicker-week-end "
                onclick="DP_jQuery_1497863063844.datepicker._selectDay('#checkoutResult',2,1396, this);return false;"><a
                        class="ui-state-default" href="#">7</a>
            </td>
            <td class=" "
                onclick="DP_jQuery_1497863063844.datepicker._selectDay('#checkoutResult',2,1396, this);return false;"><a
                        class="ui-state-default" href="#">8</a>
            </td>
            <td class=" "
                onclick="DP_jQuery_1497863063844.datepicker._selectDay('#checkoutResult',2,1396, this);return false;"><a
                        class="ui-state-default" href="#">9</a>
            </td>
            <td class=" "
                onclick="DP_jQuery_1497863063844.datepicker._selectDay('#checkoutResult',2,1396, this);return false;"><a
                        class="ui-state-default" href="#">10</a>
            </td>
            <td class=" "
                onclick="DP_jQuery_1497863063844.datepicker._selectDay('#checkoutResult',2,1396, this);return false;"><a
                        class="ui-state-default" href="#">11</a>
            </td>
            <td class=" "
                onclick="DP_jQuery_1497863063844.datepicker._selectDay('#checkoutResult',2,1396, this);return false;"><a
                        class="ui-state-default" href="#">12</a>
            </td>
        </tr>
        <tr>
            <td class=" ui-datepicker-week-end "
                onclick="DP_jQuery_1497863063844.datepicker._selectDay('#checkoutResult',2,1396, this);return false;"><a
                        class="ui-state-default" href="#">13</a>
            </td>
            <td class=" ui-datepicker-week-end "
                onclick="DP_jQuery_1497863063844.datepicker._selectDay('#checkoutResult',2,1396, this);return false;"><a
                        class="ui-state-default" href="#">14</a>
            </td>
            <td class=" "
                onclick="DP_jQuery_1497863063844.datepicker._selectDay('#checkoutResult',2,1396, this);return false;"><a
                        class="ui-state-default" href="#">15</a>
            </td>
            <td class=" "
                onclick="DP_jQuery_1497863063844.datepicker._selectDay('#checkoutResult',2,1396, this);return false;"><a
                        class="ui-state-default" href="#">16</a>
            </td>
            <td class=" "
                onclick="DP_jQuery_1497863063844.datepicker._selectDay('#checkoutResult',2,1396, this);return false;"><a
                        class="ui-state-default" href="#">17</a>
            </td>
            <td class=" "
                onclick="DP_jQuery_1497863063844.datepicker._selectDay('#checkoutResult',2,1396, this);return false;"><a
                        class="ui-state-default" href="#">18</a>
            </td>
            <td class=" "
                onclick="DP_jQuery_1497863063844.datepicker._selectDay('#checkoutResult',2,1396, this);return false;"><a
                        class="ui-state-default" href="#">19</a>
            </td>
        </tr>
        <tr>
            <td class=" ui-datepicker-week-end "
                onclick="DP_jQuery_1497863063844.datepicker._selectDay('#checkoutResult',2,1396, this);return false;"><a
                        class="ui-state-default" href="#">20</a>
            </td>
            <td class=" ui-datepicker-week-end "
                onclick="DP_jQuery_1497863063844.datepicker._selectDay('#checkoutResult',2,1396, this);return false;"><a
                        class="ui-state-default" href="#">21</a>
            </td>
            <td class=" "
                onclick="DP_jQuery_1497863063844.datepicker._selectDay('#checkoutResult',2,1396, this);return false;"><a
                        class="ui-state-default" href="#">22</a>
            </td>
            <td class=" "
                onclick="DP_jQuery_1497863063844.datepicker._selectDay('#checkoutResult',2,1396, this);return false;"><a
                        class="ui-state-default" href="#">23</a>
            </td>
            <td class=" "
                onclick="DP_jQuery_1497863063844.datepicker._selectDay('#checkoutResult',2,1396, this);return false;"><a
                        class="ui-state-default" href="#">24</a>
            </td>
            <td class=" "
                onclick="DP_jQuery_1497863063844.datepicker._selectDay('#checkoutResult',2,1396, this);return false;"><a
                        class="ui-state-default" href="#">25</a>
            </td>
            <td class=" "
                onclick="DP_jQuery_1497863063844.datepicker._selectDay('#checkoutResult',2,1396, this);return false;"><a
                        class="ui-state-default" href="#">26</a>
            </td>
        </tr>
        <tr>
            <td class=" ui-datepicker-week-end "
                onclick="DP_jQuery_1497863063844.datepicker._selectDay('#checkoutResult',2,1396, this);return false;"><a
                        class="ui-state-default" href="#">27</a>
            </td>
            <td class=" ui-datepicker-week-end "
                onclick="DP_jQuery_1497863063844.datepicker._selectDay('#checkoutResult',2,1396, this);return false;"><a
                        class="ui-state-default" href="#">28</a>
            </td>
            <td class=" ui-datepicker-days-cell-over  ui-datepicker-today"
                onclick="DP_jQuery_1497863063844.datepicker._selectDay('#checkoutResult',2,1396, this);return false;"><a
                        class="ui-state-default ui-state-highlight ui-state-hover" href="#">29</a>
            </td>
            <td class=" "
                onclick="DP_jQuery_1497863063844.datepicker._selectDay('#checkoutResult',2,1396, this);return false;"><a
                        class="ui-state-default" href="#">30</a>
            </td>
            <td class=" "
                onclick="DP_jQuery_1497863063844.datepicker._selectDay('#checkoutResult',2,1396, this);return false;"><a
                        class="ui-state-default" href="#">31</a>
            </td>
            <td class=" ui-datepicker-other-month ui-datepicker-unselectable ui-state-disabled">&nbsp;</td>
            <td class=" ui-datepicker-other-month ui-datepicker-unselectable ui-state-disabled">&nbsp;</td>
        </tr>
        </tbody>
    </table>
</div>
<script>
    var myVar;
    function changeSlider(el) {
        var slider = document.getElementById('price-slider5');
        clearTimeout(myVar);
        myVar = setTimeout(function () {
            MIN = $(".price_min").val();
            MAX = $(".price_max").val();
            slider.noUiSlider.set([MIN, MAX]);
            requestSearch();
            if(MAX >= 1000) {
                removeUrlParam('price_max', MAX);
                USER.getSearchItems(objFromUrl(), 1);
            }
        }, 1000);
    }

    function requestSearch() {
        if (issetUrlParam('price_max')) {
            updateUrlParam('price_max', encodeURIComponent(MAX));
        }
        else {
            setUrlParam('price_max', encodeURIComponent(MAX));
        }
        if (issetUrlParam('price_min')) {
            updateUrlParam('price_min', encodeURIComponent(MIN));
        }
        else {
            setUrlParam('price_min', encodeURIComponent(MIN));
        }
        USER.getSearchItems(objFromUrl(), 1);
    }

    $("#checkin1").pDatepicker({
        format: "YY/MM/DD",
        checkDate: function (unix) {
            var output = true;
            var yester = new Date();
            yester.setDate(yester.getDate() - 1);
            yester = yester.getTime(); //yesterday Unix
            if (unix < yester) {
                output = false;
            } else {

            }
            return output;
        }, monthPicker: {
            enabled: false
        }, yearPicker: {
            enabled: false
        }, dayPicker: {
            scrollEnabled: false,
        },
        altField: "#checkin_hidden",
        altFieldFormatter: function (unixDate) {
            return unixDate
        },
        dayPicker: {
            onSelect: function () {
//                $("#checkout1").focus();
                $("#checkin1").pDatepicker("hide");
//                if (!first) {
//                    $("#checkout1").pDatepicker("destroy");
//                }
                setTimeout(function () {
//                    checkout_date();
                },100);
            }
        }
    });
    $("#checkin1").val('')

    $("#checkout1").pDatepicker({
        format: "YY/MM/DD",
        persianDigit: true,
        checkDate: function (unix) {
            var output = true;
            var yester = new Date();
            yester.setDate(yester.getDate() - 1);
            yester = yester.getTime(); //yesterday Unix
            checkin = $("#checkin_hidden").val();
            if (unix < yester) {
                output = false;
            } else {

            }
            if (unix < checkin) {
                output = false;
            }
            return output;
        }, monthPicker: {
            enabled: false
        }, yearPicker: {
            enabled: false
        }, dayPicker: {
            scrollEnabled: false,
        },
        autoClose: true,
        altField: "#checkout_hidden",
        altFieldFormatter: function (unixDate) {
            return unixDate
        },
    });
    $("#checkout1").val('')

</script>
<input id="isGuest" value="{{Auth::guest()}}" hidden>
</body>
</html>

<script src="{{ asset('js/bookmarks.js?v=0.0.4') }}" type="text/javascript"></script>
