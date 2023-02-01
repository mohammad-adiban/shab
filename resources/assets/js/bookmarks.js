function configHouse() {
    //Make carousels

    $('.main-carousel').each(function() {
        $(this).flickity({
            // options
            freeScroll: false,
            lazyLoad: true,
            wrapAround: true,
            pageDots: parseInt($(this).attr('data-imageCount')) > 1
        }).flickity('select', 0);
        $('.carousel-cell').css("display", "");
    });

    //Prevent Default for some classes
    $('.price, .flickity-prev-next-button, .item-favorite-container, .dot').click(function (e) {
        e.preventDefault();
    });

    $('.location').click(function (e) {
        e.preventDefault();
        var province = $(this).data('province');
        var city = $(this).data('city');
        window.location.assign('/search/province/' + province + '/city/' + city);
    });

    $('.house-item-container').click(function (e) {
        var nodeName = e.target.nodeName.toLowerCase();
        if ($(this).find('.price-tooltip').css("opacity") === "1") {
            e.preventDefault();
        } else if (nodeName === 'button' || nodeName === 'svg' || nodeName === 'path') {
            e.preventDefault();
        }
    });


    //Persian & formatted price numbers
    $('.price-formatted').each(function() {
        $(this).html(digitsToHindi($(this).attr('data-price').replace(/\B(?=(\d{3})+(?!\d))/g, ",")));
    });


    //Bookmark request
    $('.house-item-container').each(function() {
        var bookmarked = parseInt($(this).data('bookmarked'));
        $(this).find('.item-favorite-container').click(function (e) {
            console.log(e)
            e.preventDefault();
            var target = $(this);
            if (bookmarked) {
                $.ajax({
                    type: "POST",
                    url: "/bookmarks/"+target.parent().parent().attr("id")+"/delete",
                    success: function (data) {
                        if (data.status === 'success') {
                            target.find('.fa-heart').removeClass('active');
                            bookmarked = false;
                        }
                    },
                    error: function (data) {

                    }
                });
            } else {
                $.ajax({
                    type: "POST",
                    url: "/houses/"+target.parent().parent().attr("id")+"/bookmark",
                    success: function (data) {
                        if (data.status === 'success') {
                            target.find('.fa-heart').addClass('active');
                            bookmarked = true;
                        }
                    },
                    error: function (data) {

                    }
                });
            }
        });

    });
}

$(document).ready(function () {
    configHouse();
});


function houseItemMaker(data, isWelcome, isGuest, priceOrder) {
    var type;
    switch (data.type) {
        case "apartment":
            type = "آپارتمان";
            break;

        case "villa":
            type = "ویلایی";
            break;

        case "room":
            type = "سوئیت";
            break;
    }
    var roomCount = digitsToHindi(data.rooms);
    if(data.rooms === 0) {
        roomCount = "بدون";
    }
    data.image = data.photo.thumbnail_path;
    if(data.image === null) {
        return;
    }
    var bookmarked = parseInt(data.bookmarked) === 1 ? 'active' : '';
    var provinceWord = (data.province.length < 10 && !isWelcome) ? 'استان' : '';
    var requestCountTxt = data.requests ? digitsToHindi(data.requests) + ' بار رزرو' : 'رزرو نشده';
    var average = 0;
    if(data.accessibility) {
         average = (
            data.accessibility +
            data.accuracy +
            data.cleanliness +
            data.neighborhood +
            data.host +
            data.value) * 100 / 30;
    }

    var txt=
        '<a \n' +
            'href="/houses/show/'+data.id+'" \n' ;
        if(isWelcome) {
            txt += 'class="col-xs-12 col-sm-6 col-md-6 house-item-container gallery-cell"\n' ;
        } else {
            txt += 'class="col-xs-12 col-sm-12 col-md-6 house-item-container list-item-search" style="max-width: none"\n';
        }
            txt +=
                'id="'+data.id+'"\n' +
                'target="_blank"\n' +
                'data-bookmarked="'+data.bookmarked+'"\n' +
        '>\n' +
            '<div class="house-top-part">\n' +
                '<div class="img-container">\n';
                if(isWelcome) {
                    txt += '<img src="/'+data.photos[0].thumbnail_path+'">\n' ;
                } else {
                    txt +=
                        '<div \n' +
                            'class="main-carousel"\n' +
                            'style="position:absolute;top:0; width:100%; height:100%"\n' +
                            'data-imageCount="'+data.photos.length+'" \n' +
                        '>\n';

                            for (var i = 0; i < data.photos.length && i < 10; i++) {
                                txt +=
                                    '<div class="carousel-cell" style="display: none">\n' +
                                        '<img data-flickity-lazyload="/' + data.photos[i].thumbnail_path + '">\n' +
                                    '</div>\n';
                            }
                    txt +=
                        '</div>\n';
                }
                txt +=
                '</div>\n' +
                '\n' +
                '\n' +
                '<div \n' +
                    'class="item-favorite-container" \n' +
                    ' title="علاقه‌مندی‌ها" \n';
                    if(isGuest) {
                        txt += 'data-toggle="modal" data-target="#login-modal" \n';
                    }
                    txt +=
                    '>\n' +
                    '<div class="item-favorite">\n' +
                        '<i class="fa fa-heart '+bookmarked+'"></i>\n' +
                        '<i class="fa fa-heart-o"></i>\n' +
                    '</div>\n' +
                    // '<div class="item-favorite-count"> \n' +
                    //     '<span>'+digitsToHindi(data.bookmarks)+'</span> \n' +
                    //     '&nbsp;'+
                    //     '<span>نفر</span> \n' +
                    // '</div> \n' +
                '</div>\n' +
            '</div>\n' +
            '\n' +
            '\n' +
            '\n' +
            '\n' +
            '<div class="house-info">\n' +
                '<div class="rows">\n' +
                    '<div class="title">\n' +
                        '<h4>'+data.title+'</h4>\n' +
                    '</div>\n' +
                ' </div>\n' +
                '\n' +
                '\n' +
                '<div class="rows">\n' +
                    '<div\n' +
                        'class="location"\n' +
                        'data-province="'+data.province+'"\n' +
                        'data-city="'+data.city+'"\n' +
                        'title="جستجوی اقامتگاه‌های '+data.city+'"\n' +
                    '>\n' +
                        '<span>\n' +
                            '<i class="fa fa-map-marker" aria-hidden="true"></i>\n' +
                            '<span class="hidden-md">'+provinceWord+'</span>\n' +
                            '<span> '+data.province+'</span>\n' +
                            '<span> - </span>\n' +
                            '<span>'+data.city+'</span>\n' +
                        '</span>\n' +
                    '</div>\n' +
                    '\n' +
                    '<div class="price">\n' +
                        '<span class="price-txt">\n';
                            if(priceOrder === 0) {
                                txt += '<span>از</span>\n';
                            }
                            txt +=
                                '<span \n' +
                                'class="price-count price-formatted"\n';

                                if(priceOrder === 0) {
                                    txt += 'data-price="'+(data.min_price * 1000)+'"\n';
                                } else if(priceOrder === 1) {
                                    txt += 'data-price="'+(data.median_price * 1000)+'"\n';
                                } else if(priceOrder === 2) {
                                    txt += 'data-price="'+(data.max_price * 1000)+'"\n';
                                } else {
                                    txt += 'data-price="'+(data.min_price * 1000)+'"\n';
                                }
                            txt +=
                                '></span>\n' +
                            '<span>تومان</span>\n' +
                        '</span>\n' +
                        '\n' +
                        '<span class="price-detail">\n' +
                            '<i class="fa fa-question-circle" aria-hidden="true"></i>\n' +
                            '<span class="price-tooltip price-tooltip-top">\n' +
                                '<div class="title">\n' +
                                    '<span>جزییات قیمت اقامتگاه</span>\n' +
                                '</div>\n' +
                                '\n' +
                                '<div>\n' +
                                    '<span>وسط هفته</span>\n' +
                                    '<div>\n' +
                                        '<span\n' +
                                            'class="price-formatted"\n' +
                                            'data-price="'+(data.min_price * 1000)+'"\n' +
                                        '></span>\n' +
                                        '<span>تومان </span>\n' +
                                    '</div>\n' +
                                '</div>\n' +
                                '\n' +
                                '<div>\n' +
                                    '<span>آخر هفته</span>\n' +
                                    '<div>\n' +
                                        '<span\n' +
                                            'class="price-formatted"\n' +
                                            'data-price="'+(data.median_price * 1000)+'"\n' +
                                        '></span>\n' +
                                        '<span>تومان </span>\n' +
                                    '</div>\n' +
                                '</div>\n' +
                                '\n' +
                                '<div>\n' +
                                    '<span>ایام پیک</span>\n' +
                                    '<div>\n' +
                                        '<span\n' +
                                            'class="price-formatted"\n' +
                                            'data-price="'+(data.max_price * 1000)+'" \n' +
                                        '></span>\n' +
                                        '<span>تومان </span>\n' +
                                    '</div>\n' +
                                '</div>\n' +
                                '\n' +
                                '<div>\n' +
                                    '<span>هر نفر اضافه</span>\n' +
                                    '<div>\n' +
                                        '<span\n' +
                                            'class="price-formatted"\n' +
                                            'data-price="'+data.extra_person * 1000+'"\n' +
                                        '></span>\n' +
                                        '<span>تومان </span>\n' +
                                    '</div>\n' +
                                '</div>\n' +
                            '</span>\n' +
                        '</span>\n' +
                    '</div>\n' +
                '</div>\n' +
                '\n' +
                '\n' +
                '<div class="rows" style="padding-top: 7px; border-top: 1px solid #eee; margin: 0">\n' +
                    '\n' +
                    '<div class="features">\n' +
                        '<span class="feature-item">\n' +
                            '<div class="icon">\n' +
                                '<img src="/img/icons/home.svg" />\n' +
                            '</div>\n' +
                            '<div>\n' +
                                '<span>'+type+'</span>\n' +
                            '</div>\n' +
                        '</span>\n' +
                        '\n' +
                        '<span class="feature-item">\n' +
                            '<div class="icon">\n' +
                                '<img src="/img/icons/doorway.svg" />\n' +
                            '</div>\n' +
                            '<div>\n' +
                                '<span>'+roomCount+'</span>\n' +
                                '<span>اتاق</span>\n' +
                            '</div>\n' +
                        '</span>\n' +
                        '\n' +
                        '<span class="feature-item">\n' +
                            '<div class="icon">\n' +
                                '<img src="/img/icons/group.svg" />\n' +
                            '</div>\n' +
                            '<div>\n' +
                                '<span>'+digitsToHindi(data.accommodates)+'</span>+<span>'+digitsToHindi(data.max_accommodates - data.accommodates)+'</span>\n' +
                                '<span>نفر</span>\n' +
                            '</div>\n' +
                        '</span>\n' +
                    '</div>\n' +
                    '\n' +
                    '<div class="rate">\n' +
                        '<div class="txt">\n' +
                            '<span>\n' +
                                '<span>'+requestCountTxt+'</span>\n' +
                            '</span>\n' +
                            '\n' +
                        '</div>\n' +
                        '\n' +
                        '<div class="star-ratings-css" >\n' +
                            '<div class="star-ratings-css-top" style="width: '+average+'%"><span>★</span><span>★</span><span>★</span><span>★</span><span>★</span></div>\n' +
                            '<div class="star-ratings-css-bottom"><span>★</span><span>★</span><span>★</span><span>★</span><span>★</span></div>\n' +
                        '</div>\n' +
                    '</div>\n' +
                '</div>\n' +
            '</div>\n' +
        '</a>';

    return txt;
}