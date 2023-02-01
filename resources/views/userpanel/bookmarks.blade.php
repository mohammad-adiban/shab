<head>
    <link rel="stylesheet" type="text/css" href="{{ URL::asset('css/bookmarks.css?v=0.0.1') }}">
    <link type="text/css" href="{{ asset('css/flickity.min.css') }}" rel="stylesheet"/>

    <script src="{{ asset('js/flickity.pkgd.min.js') }}" type="text/javascript"></script>
</head>


<div class="main-user">
    <div class="container room user-panel" style="display: flex; justify-content: center">

        <div class="col-xs-12 bookmarks-container">

            <!-- Check bookmark exist -->
            @if(sizeof($bookmarks))
                <?php
                function ustrlen($text)
                {
                    if(function_exists('mb_strlen')) {
                        return mb_strlen( $text , 'utf-8' );
                    } else {
                        return count(preg_split('//u', $text)) - 2;
                    }
                }
                ?>
                @foreach($bookmarks as $bookmark)
                    <a
                            href="houses/show/{{$bookmark->house->id}}"
                            class="col-xs-12 col-sm-6 col-md-4 house-item-container"
                            id="{{$bookmark->house->id}}"
                            target="_blank"
                            data-bookmarked="{{$bookmark->house->bookmarked}}"
                    >
                        <div class="house-top-part">
                            <div class="img-container">
                                <div
                                        class="main-carousel"
                                        style="position:absolute;top: 0;width: 100%;height: 100%"
                                        data-imageCount="{{sizeof($bookmark->house->photos)}}"
                                >
                                    @for($i=0; $i<sizeof($bookmark->house->photos) && $i < 10; $i++)
                                        <div class="carousel-cell" style="display: none">
                                            <img data-flickity-lazyload="{{$bookmark->house->photos[$i]->thumbnail_path}}">
                                        </div>
                                    @endfor
                                </div>
                            </div>


                            <div class="item-favorite-container" title="علاقه‌مندی‌ها">
                                <div class="item-favorite">
                                    <i class="fa fa-heart @if($bookmark->house) active @endif"></i>
                                    <i class="fa fa-heart-o"></i>
                                </div>
                                {{--<div class="item-favorite-count">--}}
                                {{--<span>{{$bookmark->house->statistics['bookmarks']}}</span>--}}
                                {{--&nbsp;--}}
                                {{--<span>نفر</span>--}}
                                {{--</div>--}}
                            </div>
                        </div>




                        <div class="house-info">
                            <div class="rows">
                                <div class="title">
                                    <h4>{{$bookmark->house->title}}</h4>
                                </div>
                            </div>


                            <div class="rows">
                                <div
                                        class="location"
                                        data-province="{{$bookmark->house->province}}"
                                        data-city="{{$bookmark->house->city}}"
                                        title="جستجوی اقامتگاه‌های {{$bookmark->house->city}}"
                                >
                                    <span>
                                        <i class="fa fa-map-marker" aria-hidden="true"></i>
                                        @if(ustrlen($bookmark->house->province < 9 && $bookmark->house->city) < 9)
                                            <span>استان </span>
                                        @endif
                                        <span>{{$bookmark->house->province}}</span>
                                        <span> - </span>
                                        <span>{{$bookmark->house->city}}</span>
                                    </span>
                                </div>

                                <div class="price">
                                    <span class="price-txt">
                                        <span>از</span>
                                        <span
                                                class="price-count price-formatted"
                                                data-price={{$bookmark->house->min_price * 1000}}
                                        ></span>
                                        <span>تومان</span>
                                    </span>

                                    <span class="price-detail">
                                        <i class="fa fa-question-circle" aria-hidden="true"></i>
                                        <span class="price-tooltip price-tooltip-top">
                                            <div class="title">
                                                <span>جزییات قیمت اقامتگاه</span>
                                            </div>

                                            <div>
                                                <span>وسط هفته</span>
                                                <div>
                                                    <span
                                                            class="price-formatted"
                                                            data-price={{$bookmark->house->min_price * 1000}}
                                                    ></span>
                                                    <span>تومان </span>
                                                </div>
                                            </div>

                                            <div>
                                                <span>آخر هفته</span>
                                                <div>
                                                    <span
                                                            class="price-formatted"
                                                            data-price={{$bookmark->house->median_price * 1000}}
                                                    ></span>
                                                    <span>تومان </span>
                                                </div>
                                            </div>

                                            <div>
                                                <span>ایام پیک</span>
                                                <div>
                                                    <span
                                                            class="price-formatted"
                                                            data-price={{$bookmark->house->max_price * 1000}}
                                                    ></span>
                                                    <span>تومان </span>
                                                </div>
                                            </div>

                                            <div>
                                                <span>هر نفر اضافه</span>
                                                <div>
                                                    <span
                                                            class="price-formatted"
                                                            data-price={{$bookmark->house->extra_person * 1000}}
                                                    ></span>
                                                    <span>تومان </span>
                                                </div>
                                            </div>
                                        </span>
                                    </span>
                                </div>
                            </div>


                            <div class="rows" style="padding-top: 7px; border-top: 1px solid #eee">

                                <div class="features">
                                    <span class="feature-item">
                                        @if($bookmark->house->type == 'villa')
                                            <div class="icon">
                                                <img src="{{url('/img/icons/home.svg')}}" />
                                            </div>
                                            <div>
                                                <span>ویلایی</span>
                                            </div>

                                        @elseif($bookmark->house->type == 'apartment')
                                            <div class="icon">
                                                <img src="{{url('/img/icons/building-with-big-windows.svg')}}" />
                                             </div>
                                            <div>
                                                <span>آپارتمان</span>
                                            </div>

                                        @else
                                            <div class="icon">
                                                <img src="{{url('/img/icons/bed.svg')}}" />
                                             </div>
                                            <div>
                                                <span>سوییت</span>
                                            </div>
                                        @endif
                                    </span>

                                    <span class="feature-item">
                                        <div class="icon">
                                            <img src="{{url('/img/icons/doorway.svg')}}" />
                                        </div>

                                        <div>
                                            <span>{{$bookmark->house->rooms}}</span>
                                            <span>اتاق</span>
                                        </div>
                                    </span>

                                    <span class="feature-item">
                                        <div class="icon">
                                            <img src="{{url('/img/icons/group.svg')}}" />
                                        </div>

                                        <div>
                                            <span>{{$bookmark->house->accommodates}}</span>+<span>{{$bookmark->house->max_accomodates + $bookmark->house->accommodates}}</span>
                                            <span>نفر</span>
                                        </div>
                                    </span>
                                </div>

                                <div class="rate">
                                    <div class="txt">
                                        <span>
                                            @if($bookmark->house->statistics['requests'])
                                                {{$bookmark->house->statistics['requests']}}
                                                <span>بار رزرو</span>
                                            @else
                                                <span>رزرو نشده</span>
                                            @endif
                                        </span>

                                    </div>

                                    <?php
                                    $rate = 0;
                                    if($bookmark->house->statistics) {
                                        $statistics = $bookmark->house->statistics;
                                        $rate =
                                            ($statistics->accessibility +
                                                $statistics->accuracy +
                                                $statistics->cleanliness +
                                                $statistics->host +
                                                $statistics->neighborhood +
                                                $statistics->neighborhood) * 100 / 30;
                                    }
                                    ?>
                                    <div class="star-ratings-css" >
                                        <div class="star-ratings-css-top" style="width: {{$rate}}%"><span>★</span><span>★</span><span>★</span><span>★</span><span>★</span></div>
                                        <div class="star-ratings-css-bottom"><span>★</span><span>★</span><span>★</span><span>★</span><span>★</span></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </a>
                @endforeach
            @else
                <div class="empty-container">
                    <span>لیست علاقه‌مندی‌های شما خالی ست</span>
                </div>
            @endif
        </div>
    </div>
    {{ $bookmarks->links() }}
</div>

<script src="{{ asset('js/bookmarks.js?v=0.0.5') }}" type="text/javascript"></script>
