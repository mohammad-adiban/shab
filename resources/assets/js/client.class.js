var Client = function() {

};

var items = '';
var averagePrice = 0;


Client.prototype = {
    getSearchItems: function(params, page) {

        //Active Loading
        $(".search-result").addClass("loading");


        //Read URL Parameters & Make FormBody For Search Request
        var formBody = [];
        for (var property in params) {
            var encodedKey = (property);
            var encodedValue = (params[property]);
            formBody.push(encodedKey + "=" + encodedValue);
        }
        formBody = formBody.join("&");


        var url = 'search';
        var averagePrice = 0;
        $.ajax({
            url:'/'+url+'?page='+page,
            type:"POST",
            data: formBody,
            success: function(items){

                //Clear Container
                $("#searchResultListContainer").html(" ");
                isMapMaked = false;


                //Items Location
                if(params['city']) {
                    $('.choosed_city').text(decodeURI(params['city']));
                }
                else if(params['destination']) {
                    $('.choosed_city').text(decodeURI(getUrlParam("destination")));
                }
                else {
                    $('.choosed_city').text('همه جا');
                }
                //Items Count
                $('.choosed_count').text(items.total + ' ' + 'مورد');


                //Price Order
                var priceOrder = parseInt($('.filter-dropBox-field-input[name="price_order"]').val());
                var priceOrderTxt = 'min_price';
                if(priceOrder === 1) {
                    priceOrderTxt = 'median_price';
                } else if(priceOrder === 2) {
                    priceOrderTxt = 'max_price'
                }


                var isGuest = $('#isGuest').val();
                //Make Items
                $.each(items.data, function(i, field) {
                    averagePrice += field[priceOrderTxt];
                    $("#searchResultListContainer").append(houseItemMaker(field, false, isGuest, priceOrder));

                    $('.main-carousel').flickity({
                        freeScroll: false,
                        lazyLoad: true,
                        wrapAround: true,
                        pageDots: true
                    }).flickity( 'select', 0 );
                    $('.carousel-cell').css("display", "");

                    // google.maps.event.addDomListener(window, 'load', function() {
                    initialize(field);
                    // });
                });



                if(items.total === 0) {
                    isMapMaked = false;
                    initialize("");
                    averagePrice = 0;
                    $(".average-price-result").find("b").html(digitsToHindi(Math.round(averagePrice)));
                }
                else {
                    $(".average-price-result").find("b").html(digitsToHindi(commaSeperated(Math.round(averagePrice/(items.data.length*1000) * 1000) * 1000)));
                }

                //Remove Loading
                $(".search-result").removeClass("loading");


                if(items.current_page === 1) {
                    var visibleCount;
                    if( /Android|webOS|iPhone|iPad|iPod|BlackBerry|IEMobile|Opera Mini/i.test(navigator.userAgent) ) {
                        visibleCount = 2;
                    }
                    else {
                        visibleCount = 3;
                    }
                    var firstPageClick = true;
                    var $pagination = $('.paginate ul');
                    var defaultOpts = {
                        totalPages: 20
                    };
                    $pagination.twbsPagination(defaultOpts);

                    if(items.total != 0) {
                        $pagination.twbsPagination('destroy');
                        $pagination.twbsPagination($.extend({}, defaultOpts, {
                            startPage: 1,
                            totalPages: items.last_page,
                            visiblePages: visibleCount,
                            onPageClick: function (event, page) {
                                if (firstPageClick) {
                                    firstPageClick = false;
                                    return;
                                }

                                $('#page-content').text('Page ' + page);
                                if (!$(this).parent().hasClass('disabled')) {

                                    var dup = {}; // duplicated params
                                    dup.room_type = [];
                                    dup.amenities = [];
                                    var optionName = $(this).attr('name');
                                    var optionValue = $(this).val();
                                    var multipleChoiceOptions = ['room_type', 'amenities'];

                                    if ($.inArray(optionName, multipleChoiceOptions) > -1) {
                                        if ($(this).is(':checked')) {
                                            setUrlParam(optionName, encodeURIComponent(optionValue));
                                            dup[optionName].push(optionValue);
                                        }
                                        else {
                                            removeUrlParam(optionName, encodeURIComponent(optionValue));
                                            var index = dup[optionName].indexOf(optionValue);
                                            dup[optionName].splice(index, 1);
                                        }
                                    }
                                    else if (issetUrlParam(optionName)) {
                                        updateUrlParam(optionName, encodeURIComponent(optionValue));
                                    }
                                    else {
                                        setUrlParam(optionName, encodeURIComponent(optionValue));
                                    }

                                    var reqData = objFromUrl();

                                    USER.getSearchItems(reqData, page);
                                }
                            }
                        }));
                    } else {
                        $pagination.twbsPagination('destroy');
                    }
                    priceToPersianNumber();

                    if(items.total === 0)
                        $('.items-count').text('موردی یافت نشد')
                    else {
                        $('.items-count').html('<span id="firstItem"></span> -<span id=\"lastItem\"></span> از <span id=\"itemsCount\"></span> نتیجه')
                    }
                    destSearch = "همه جا";
                    if(getUrlParam("destination"))
                        destSearch = decodeURI(getUrlParam("destination"));
                    $('.slength').text(items.total + ' مورد یافت شد . ' + destSearch);
                    traverse($(".search-page-buttons")[0]);

                    $('#itemsCount').text(items.total);
                    $('.items-count').show();

                    if($(".s-list .row").children().length == 0) {
                        $('.slength').text('موردی یافت نشد');
                    }
                }


                $('#firstItem').text(items.from);
                $('#lastItem').text(items.to);

                traverse($(".results-count")[0]);
                traverse($(".search-result")[0]);
                traverse($(".s-list")[0]);
                traverse($(".filter-choosed")[0]);

                configHouse();
            } // end of else
        })
    }
};

var dup = {}; // duplicated params
dup.room_type = [];
dup.amenities = [];


//Search When Inputs Change in Desktop
function doSearch($this) {
    //Get Input Info
    var optionName = $this.attr('name');
    var optionValue = $this.val();

    //More Filter Inputs Name
    var multipleChoiceOptions = ['area_type', 'room_type', 'amenities'];

    //Check Input is Inside More Filter
    if($.inArray(optionName, multipleChoiceOptions) > -1) {
        if($this.is(':checked')) {
            setUrlParam(encodeURIComponent(optionValue), '1');
            dup[optionName].push(optionValue);
        }
        else {
            removeUrlParam(encodeURIComponent(optionValue), '1');
            var index = dup[optionName].indexOf(optionValue);
            dup[optionName].splice(index, 1);
        }
    }
    //Or Not...
    else if(issetUrlParam(optionName)) {
        updateUrlParam(optionName, encodeURIComponent(optionValue));
    }
    else {
        setUrlParam(optionName, encodeURIComponent(optionValue));
    }

    var reqData = objFromUrl();
    USER.getSearchItems(reqData, 1);
}



isMapMaked = false;
var map;
function initialize(field) {
    if(field == ""){
        var myLatlng = new google.maps.LatLng(31.9736139, 44.6680673);
    } else {
        var myLatlng = new google.maps.LatLng(field.latitude, field.longitude);
    }
    if (!isMapMaked) {
        var mapOptions = {
            zoom: 5,
            center: myLatlng,
            disableDefaultUI: true,
            zoomControl: true,
            zoomControlOptions: {
                position: google.maps.ControlPosition.TOP_RIGHT
            },
        }
        map = new google.maps.Map(document.getElementById('map'), mapOptions);

        isMapMaked = true;
    }

    if(getUrlParam("destination") != "" && getUrlParam("destination") != null) {
        if(decodeURI(getUrlParam("destination")).split(",").length == 1) {
            var geocoder = new google.maps.Geocoder();
            geocoder.geocode({'address': decodeURI(getUrlParam("destination"))}, function (results, status) {
                if (status == google.maps.GeocoderStatus.OK) {
                    map.setCenter(results[0].geometry.location);
                    map.setZoom(12);
                } else {
                    //occur error
                }
            });
        }
    }
    else {
        var pathArray = window.location.pathname.split( '/' );
        if((pathArray[2] == 'province' && pathArray[4] == 'city')) {
            var geocoder = new google.maps.Geocoder();
            geocoder.geocode({'address': decodeURI(pathArray[5])}, function (results, status) {
                if (status == google.maps.GeocoderStatus.OK) {
                    map.setCenter(results[0].geometry.location);
                    map.setZoom(12);
                } else {
                    //occur error
                }
            });
        }
        else if(pathArray[2] == 'city') {
            var geocoder = new google.maps.Geocoder();
            geocoder.geocode({'address': decodeURI(pathArray[3])}, function (results, status) {
                if (status == google.maps.GeocoderStatus.OK) {
                    map.setCenter(results[0].geometry.location);
                    map.setZoom(12);
                } else {
                    //occur error
                }
            });
        }
        else if(pathArray[2] == 'province') {
            var geocoder = new google.maps.Geocoder();
            geocoder.geocode({'address': decodeURI(pathArray[3])}, function (results, status) {
                if (status == google.maps.GeocoderStatus.OK) {
                    map.setCenter(results[0].geometry.location);
                    map.setZoom(8);
                } else {
                    //occur error
                }
            });
        }
    }

    if(field != "")
    overlay = new CustomMarker(
        myLatlng,
        map, {
            marker_id: field.id
        },
        field
    );

    //search with move the map
    map.addListener('dragend', function (coord) {
        if ($('#searchByMap').is(":checked")) {
            //if checked the checkBox do search
        }
        else {

        }
    });

}
function showMarker(id){
    $("#"+id+"Marker").addClass("map-tooltip-hover");
}
function hideMarker(id){
    $("#"+id+"Marker").removeClass("map-tooltip-hover");
}

function dataURItoBlob(dataURI) {
    var binary = atob(dataURI.split(',')[1]);
    var array = [];
    for(var i = 0; i < binary.length; i++) {
        array.push(binary.charCodeAt(i));
    }
    return new Blob([new Uint8Array(array)], {type: 'image/jpeg'});
}



$(document).ready(function () {

    //close sort menu by click on its container
    $(".filter-dropBox-container").click(function () {
        if ($(".filter-dropBox-box").css("opacity") == "1")
            $(this).blur();
    });

    //Change Sort by Click on Choices
    $(".filter-dropBox-box > li").click(function () {
        $(this).parent().parent().find(".filter-dropBox-field-txt").html($(this).html());
        $(this).parent().parent().find(".filter-dropBox-field-input").val( $(this).attr('data') );

        doSearch($(this).parent().parent().find(".filter-dropBox-field-input"));
    });
});




















//
// function resultItemMaker(field, priceOrder) {
//     console.log(field);
//     var type;
//     switch (field.type) {
//         case "apartment":
//             type = "آپارتمان";
//             break;
//
//         case "villa":
//             type = "ویلا";
//             break;
//
//         case "room":
//             type = "سوئیت";
//             break;
//     }
//
//     var roomCount = field.rooms;
//     if(field.rooms == 0)
//         roomCount = "بدون";
//
//     field.image = field.photo.thumbnail_path;
//     if(field.image === null) {
//         return;
//     }
//
//     /*
//     if (field.image == undefined) {
//         field.image = field.photo.thumbnail_path;
//     }
//     */
//     var txt="";
//     txt += '<div onmouseover="showMarker(this.id)" onmouseout="hideMarker(this.id)" class="col-lg-6 col-md-6 col-sm-12 col-sm-offset-0 col-xs-12 list-item list-item-search" marker="19" id="'+field.id+'"> <!— search result item —>';
//     txt += '<div class="item-main">';
//     txt += '<div class="image-price-container">';
//     txt += '<img src="/'+field.image+'" class="fullImg">';
//
//     // txt +=
//     //     '<div class="item-favorite-container">' +
//     //         '<span class="item-favorite">' +
//     //             '<i class="fa fa-heart-o" aria-hidden="true"></i>' +
//     //         '</span>' +
//     //         '<span class="item-favorite-hovered"><i class="fa fa-heart" aria-hidden="true"></i></span>' +
//     //     '</div>';
//     txt += '<div class="change-image-container left-change-image-container" style="visibility: hidden">';
//     txt += '<div class="change-image-btn-container left-change-image-btn-container" onclick="clickToChangeImage()">';
//     txt += '<i class="fa fa-angle-left change-image-btn change-image-btn-left" aria-hidden="true"></i>';
//     txt += '</div>';
//
//     txt += '<div class="item-price" style="visibility: visible">';
//     txt += '<span id="item-price">';
//     if(priceOrder == 0) {
//         txt += digitsToHindi(priceToReadable(field.min_price, 'long'));
//     }
//     else if(priceOrder == 1) {
//         txt += digitsToHindi(priceToReadable(field.median_price, 'long'));
//     }
//     else if(priceOrder == 2) {
//         txt += digitsToHindi(priceToReadable(field.max_price, 'long'));
//     }
//     txt +=  '</span>';
//     txt += '</div>';
//
//     txt += '</div>';
//
//     txt += '<div class="change-image-container right-change-image-container" style="visibility: hidden">';
//     txt += '<div class="change-image-btn-container right-change-image-btn-container" onclick="clickToChangeImage()">';
//     txt += '<i class="fa fa-angle-right change-image-btn change-image-btn-right" aria-hidden="true"></i>';
//     txt += '</div>';
//     txt += '</div>';
//     txt += '</div>';
//     txt += '<a href="/houses/show/'+field.id+'" target="_blank" id="item-a" class="item-desc">';
//     txt += '<div class="col-xs-1 slidesec slide-left">';
//     txt += '<div class="icon-center text-center">';
//     txt += '<div class="slide left"></div>';
//     txt += '<div class="slide left leftdown"></div>';
//     txt += '</div>';
//     txt += '</div>';
//     txt += '<div class="col-xs-1 slidesec slide-right">';
//     txt += '<div class="icon-center text-center">';
//     txt += '<div class="slide rightdown"></div>';
//     txt += '<div class="slide rightup"></div>';
//     txt += '</div>';
//     txt += '</div>';
//     txt += '<div class="load-spinner"></div>';
//     txt += '</a>';
//     txt += '</div>';
//
//     txt += '<div class="panel-body panel-card-section">';
//     txt += '<div class="media">';
//     txt += '<div class="item-info">';
//     txt += '<span>';
//     txt += '<a id="item-a" target="_blank" href="/houses/show/'+field.id+'">';
//     txt += '<h4 class="item-title">'+field.title+'</h4>';
//     txt += '<div>';
//
//     txt += '<span class="col-xs-12" id="item-location">';
//     //txt += '<i class="fa fa-map-marker" aria-hidden="true"></i> ';
//     txt += '<span>'+field.province+'</span>';
//     txt += '&nbsp;';
//     txt += '<span class="item-sign">&minus;</span>';
//     txt += '&nbsp;';
//     txt += '<span>'+field.city+'</span>';
//     txt += '</span>';
//     txt += '</div>';
//
//
//     txt += '<div>';
//     txt += '<span class="col-xs-7" id="item-type">';
//     txt += '<span>';
//     txt += type;
//     txt += '</span>';
//     txt += '<span class="item-sign">&nbsp; | &nbsp;</span>';
//     txt += '<span>';
//     txt += '<span class="item-bold">'+digitsToHindi(roomCount)+'</span>';
//     txt += '&nbsp;';
//     txt += 'اتاق';
//     txt += '</span>';
//     txt += '<span class="item-sign">&nbsp; | &nbsp;</span>';
//     txt += '<span>';
//     txt += 'تا';
//     txt += '&nbsp;';
//     txt += '<span class="item-bold">'+digitsToHindi(field.max_accommodates)+'</span>';
//     txt += '&nbsp;';
//     txt += 'نفر';
//     txt += '</span>';
//     txt += '</span>';
//
//     txt += '<div class="col-xs-5 star-rating">';
//     // txt += '<span id="reviewCount">۲۴</span>&nbsp;<span>رزرو</span>';
//     txt += '<div class="background">';
//     if(field.statistics)
//         var average = (field.statistics.accessibility + field.statistics.accuracy + field.statistics.cleanliness + field.statistics.host + field.statistics.neighborhood + field.statistics.value ) /6;
//     for(var i=0; i<5 ; i++) {
//         if(i < Math.round(average)) {
//             txt += '<i class="fa fa-star"></i>';
//         }
//         else {
//             txt += '<i class="fa fa-star star-0"></i>';
//         }
//     }
//     txt += '</div>';
//     txt += '</div>';
//     txt += '</div>';
//
//     txt += '</a>';
//     txt += '</span>';
//     txt += '</div>';
//     txt += '</div>';
//     txt += '</div>';
//     txt += '</div>';
//
//     return txt;
// }
