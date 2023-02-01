var text = $.parseHTML($('.company').text());
$('.company').html(text);

traverse(document.body); // convert all numbers to persian

if ($('#checkin').length > 0) {
    $('#checkin').datepicker();
    $('#checkout').datepicker();
}
if ($('#checkinResult').length > 0) {
    $('#checkinResult').datepicker();
    $('#checkoutResult').datepicker();
}
var currentRout = $('#currentRout').val();
var companyRouts = ['about','refund','terms', 'careers','policies'];
var found = $.inArray(currentRout, companyRouts) > -1;
if(found > -1) {
    var htmlContent = $('#content').text();
    htmlContent = $.parseHTML(htmlContent);
    $('#content').empty();
    $('#content').append(htmlContent);
}

$('a[href*="#"]:not([href="#"])').click(function() {
    // if (location.pathname.replace(/^\//, '') == this.pathname.replace(/^\//, '') && location.hostname == this.hostname) {
    //     var target = $(this.hash);
    //     target = target.length ? target : $('[name=' + this.hash.slice(1) + ']');
    //     if (target.length) {
    //         $('html, body').animate({
    //             scrollTop: target.offset().top
    //         }, 600);
    //         return false;
    //     }
    // }
});

// $(document.body).on("mouseenter", ".dropdown", function(a) {
//     $(this).addClass('open');
// })
//     .on("mouseleave", ".dropdown", function() {
//         $(this).removeClass('open');
//
//     });
//
//
// $('.navbar-toggle').click(function() {
//     if ($(this).attr('toggle') == "false") {
//         $(this).attr('toggle', "true");
//         $(this).css('transform', 'rotate(90deg)');
//     } else {
//         $(this).attr('toggle', "false");
//         $(this).css('transform', 'rotate(0deg)');
//
//     }
//
// });

$("#destination,#checkin,#checkout,#guests").keydown(function (e) {
    if (e.which == 9) {
        switch(this.id) {
            case 'destination':
                $("#checkin").focus();
                break;
            case 'checkin':
                $("#checkout").focus();
                break;
            case 'checkout':
                $("#guests").focus();
                break;
            case 'guests':
                $("#searchbar-submit").focus();
                break;
        }
        e.preventDefault();
    }

});

$(document.body).on("mouseenter", ".menu-option", function(a) {
    $(this).addClass("itemHover")
})
    .on("mouseleave", ".menu-option", function() {
        $(this).removeClass("itemHover")
    });


setTimeout(function() {
    translateDocument('body');
},100);

$('#how-it-works').css('width', $('#how-it-works').text().length * 11); // dynamic width for first page How It Works button
}); // end line of all js files

function translateDocument(element) {
    // language
    if (getCookie('lang') == '')
        setCookie('lang', 'fa', 30);
    var userLanguage = getCookie('lang');
    $(element).find('lng').each(function() {
        $(this).replaceWith(getTranslate($(this).attr('key'), userLanguage));
    });
    $(element).find('input').each(function() {
        $(this).attr('placeholder', getTranslate($(this).attr('placeholder'), userLanguage));
    });
}

var persian = {
    0: '۰',
    1: '۱',
    2: '۲',
    3: '۳',
    4: '۴',
    5: '۵',
    6: '۶',
    7: '۷',
    8: '۸',
    9: '۹'
};

function getTranslate(key, lang) {
    switch (lang) {
        case 'fa':
            if (key != undefined && key.split('.')[1] != undefined)
                return l_Fa[key.split('.')[0]][key.split('.')[1]];
        case 'en':
            if (key != undefined && key.split('.')[1] != undefined)
                return l_En[key.split('.')[0]][key.split('.')[1]];
            break;
    }
}

function traverse(el) { // convert all numbers to persian
    if (el.nodeType == 3) {
        var list = el.data.match(/[0-9]/g);
        if (list != null && list.length != 0) {
            for (var i = 0; i < list.length; i++)
                el.data = el.data.replace(list[i], persian[list[i]]);
        }
    }
    for (var i = 0; i < el.childNodes.length; i++) {
        traverse(el.childNodes[i]);
    }
}

function setCookie(cname, cvalue, exdays) {
    var d = new Date();
    d.setTime(d.getTime() + (exdays * 24 * 60 * 60 * 1000));
    var expires = "expires=" + d.toUTCString();
    document.cookie = cname + "=" + cvalue + "; " + expires;
}

function getCookie(cname) {
    var name = cname + "=";
    var ca = document.cookie.split(';');
    for (var i = 0; i < ca.length; i++) {
        var c = ca[i];
        while (c.charAt(0) == ' ') c = c.substring(1);
        if (c.indexOf(name) == 0) return c.substring(name.length, c.length);
    }
    return "";
}

function eraseCookie(name) {
    setCookie(name, "", -1);
}

function getParameterByName(name, url) {
    if (!url) url = window.location.href;
    name = name.replace(/[\[\]]/g, "\\$&");
    var regex = new RegExp("[?&]" + name + "(=([^&#]*)|&|#|$)"),
        results = regex.exec(url);
    if (!results) return null;
    if (!results[2]) return '';
    return decodeURIComponent(results[2].replace(/\+/g, " "));
}

function updateUrlParam(param, value)
{
    if (param != undefined) {
        var url = location.search,
            newUrl = ""; // url value after "?" mark
        var re = new RegExp(param+"(.+?)(&|$)","g");
        newUrl = url.replace(re, param+'='+value+'&');
        if(newUrl.charAt(newUrl.length - 1) == '&')
            newUrl = newUrl.substring(0, newUrl.length - 1);
        window.history.pushState(param+'='+value, "updateUrlParam", newUrl);
        if(value=='remove') {
            removeUrlParam(param, value);
            return;
        }
    }
}
function setUrlParam(param, value)
{
    if (param != undefined) {
        var url = location.search; // url value after "?" mark
        if(location.search == '')
            var sign = '?';
        else
            var sign = '&'
        var newUrl = url + sign + param + '=' + value;
        window.history.pushState(param+'='+value, "setUrlParam", newUrl);
        if(value=='remove') {
            removeUrlParam(param, value);
            return;
        }
    }
}

function shuffleArray(array) {
    var currentIndex = array.length, temporaryValue, randomIndex;

    while (0 !== currentIndex) {
        randomIndex = Math.floor(Math.random() * currentIndex);
        currentIndex -= 1;
        temporaryValue = array[currentIndex];
        array[currentIndex] = array[randomIndex];
        array[randomIndex] = temporaryValue;
    }
    return array;
}


function itemMaker(field) {
    var type;
    switch (field.type) {
        case "apartment":
            type = "آپارتمان";
            break;

        case "villa":
            type = "ویلا";
            break;

        case "room":
            type = "سوئیت";
            break;
    }

    var roomCount = field.rooms;
    if(field.rooms == 0)
        roomCount = "بدون";

    var image = field.photo.thumbnail_path;
    /*
    if (image == undefined) {
        image = '';
        if (field.photo != undefined) {
            image = field.photo.thumbnail_path;
        }
        else
            image = field.thumbnail_path;
    }
    */
    var house_type = '';
    switch (field.type) {
        case 'villa':
            house_type = 'ویلا';
            break;
        case 'apartment':
            house_type = 'آپارتمان';
            break;
        case 'room':
            house_type = 'سوئیت';
            break;
    }

    var shomal = '';
    var image_alt = '';
    if(field.province == 'مازندران' || field.province == 'گرگان' || field.province == 'گیلان')
        shomal = ', شمال';
    image_alt = 'اجاره '+house_type+' در '+field.city+', '+field.province+shomal+' - '+field.title;


    var txt="";
    txt += '<div onmouseover="showMarker(this.id)" onmouseout="hideMarker(this.id)" class="gallery-cell list-item" marker="19" id="'+field.id+'" style="margin-bottom: 0"> <!— search result item —>';
    txt += '<a href="/houses/show/'+field.id+'" target="_blank" id="item-a" class="item-desc">';
    txt += '<div class="item-main">';

    txt += '<div class="image-price-container">';
    txt += '<img src="/'+image+'" class="fullImg" alt="'+image_alt+'" style="width: 100%; height: 100%; position: absolute; top: 0;">';
    txt += '<div class="item-price item-price3">';
    txt += '<span class="priceReadable">از ';
    txt += '<span id="item-price">'+digitsToHindi(priceToReadable(field.min_price, 'long'))+'</span>';
    txt += '</div>';
    txt += '</div>';
    txt += '<div class="load-spinner"></div>';

    txt += '</div>';

    txt += '<div class="panel-card-section">';
    txt += '<div class="media">';
    txt += '<div class="item-info">';
    txt += '<span>';

    txt += '<h4 class="item-title">'+field.title+'</h4>';
    txt += '<div>';

    txt += '<span class="col-xs-12" id="item-location">';
    //txt += '<i class="fa fa-map-marker" aria-hidden="true"></i> ';
    txt += '<span>'+field.province+'</span>';
    txt += '&nbsp;';
    txt += '<span class="item-sign">&minus;</span>';
    txt += '&nbsp;';
    txt += '<span>'+field.city+'</span>';
    txt += '</span>';
    txt += '</div>';


    txt += '<div>';
    txt += '<span class="col-xs-7" id="item-type">';
    txt += '<span>';
    txt += type;
    txt += '</span>';
    txt += '<span class="item-sign">&nbsp; | &nbsp;</span>';
    txt += '<span>';
    txt += '<span class="item-bold">'+digitsToHindi(roomCount)+'</span>';
    txt += '&nbsp;';
    txt += 'اتاق';
    txt += '</span>';
    txt += '<span class="item-sign">&nbsp; | &nbsp;</span>';
    txt += '<span>';
    txt += 'تا';
    txt += '&nbsp;';
    txt += '<span class="item-bold">'+digitsToHindi(field.max_accommodates)+'</span>';
    txt += '&nbsp;';
    txt += 'نفر';
    txt += '</span>';
    txt += '</span>';

    txt += '<div class="col-xs-5 star-rating">';
    //txt += '<span id="reviewCount">۲۴</span>&nbsp;<span>رزرو</span>';
    txt += '<div class="background">';
    console.log(field)
    if(field.statistics)
        var average = (field.statistics.accessibility + field.statistics.accuracy + field.statistics.cleanliness + field.statistics.host + field.statistics.neighborhood + field.statistics.value ) /6;
    for(var i=0; i<5 ; i++) {
        if(i < Math.round(average)) {
            txt += '<i class="fa fa-star"></i>';
        }
        else {
            txt += '<i class="fa fa-star star-0"></i>';
        }
    }
    txt += '</div>';
    txt += '</div>';
    txt += '</div>';


    txt += '</span>';
    txt += '</div>';
    txt += '</div>';
    txt += '</div>';
    txt += '</a>';
    txt += '</div>';

    return txt;
}

function removeUrlParam(param, value)
{
    var url = location.search; // url value after "?" mark
    var newUrl = url.replace('&' + param + '=' + value, '');
    if (url.indexOf('?' + param + '=' + value) != -1) {
        newUrl = url.replace('?' + param + '=' + value, '?');
        if(newUrl.indexOf('?&') != -1) {
            newUrl = newUrl.replace('?&', '?');
        }
    }
    window.history.pushState(param+'='+value, "removeUrlParam", newUrl);
}

function issetUrlParam(param)
{
    var url = location.search; // url value after "?" mark
    if(url.indexOf(param + '=') != -1)
        return true;
    return false
}

function objFromUrl() {
    var urlParams;
    var match,
        pl     = /\+/g,  // Regex for replacing addition symbol with a space
        search = /([^&=]+)=?([^&]*)/g,
        decode = function (s) { return (s.replace(pl, " ")); },
        query  = window.location.search.substring(1);

    urlParams = {};
    while (match = search.exec(query)) {
        if (decode(match[2]) != "")
            urlParams[decode(match[1])] = decode(match[2]);
    }

    urlParts = window.location.pathname.split( '/' );

    if(urlParts[2] == 'city' && urlParts[3])
        urlParams['city'] = urlParts[3];
    if(urlParts[2] == 'province' && urlParts[3])
        urlParams['province'] = urlParts[3];
    if(urlParts[2] == 'province' && urlParts[3] && urlParts[4] == 'city' && urlParts[5])
    {
        urlParams['city'] = urlParts[5];
        urlParams['province'] = urlParts[3];
    }

    return urlParams;
}

function getUrlParam(name) {
    var url = location.href;
    name = name.replace(/[\[]/,"\\\[").replace(/[\]]/,"\\\]");
    var regexS = "[\\?&]"+name+"=([^&#]*)";
    var regex = new RegExp( regexS );
    var results = regex.exec( url );
    return results == null ? null : results[1];
}

function loadingEnable(element) {
    $('.'+element).prepend('<div class="loader-'+element+'"></div>');
    var parent = $('.'+element);
    var $this = $('.loader-'+element);
    $this.css('z-index', '9999');
    $this.css('position', 'absolute');
    $this.css('background-color', 'rgba(255,255,255,.5)');
    $this.css('width', parent.width());
    $this.css('height', parent[0].scrollHeight);
    //  parent.css('overflow', 'hidden');
}
function loadingDisable(element) {
    $('.loader-'+element).remove();
    //  $('.'+element).css('overflow', '');
}
function priceToReadable(price, type) {
    price = digitsToLatin(price);
    price = price.toString();
    var t1 = 'هزار',
        t2 = 'میلیون',
        currency = type == 'short' ? 'ت' : 'تومان';
    if(price == '0')
        return 0;
    if (price.length <= 3) {
        return price + ' ' + t1 + ' ' + currency;
    }
    else {
        var h = price.slice(-3),
            m = price.substring(0, price.lastIndexOf(h));
        if (h[0] == '0' && h[1] == '0') {
            h = h[2];
        }
        if (h == 000) {
            h = 0;
        }
        if (h[0] == '0' && h[1] != '0') {
            h = h.substring(1, 3);
        }
        if (h == 0)
            return digitsToHindi(m + ' ' + t2 + ' ' + currency);
        else
            return digitsToHindi(m + ' ' + t2 + ' و ' + h + ' ' + t1 + ' ' + currency);
    }
}

function digitsToLatin(str) {
    if (str == undefined) return '';
    str = str.toString();
    str = str.replace(/۰/g, '0');
    str = str.replace(/۱/g, '1');
    str = str.replace(/۲/g, '2');
    str = str.replace(/۳/g, '3');
    str = str.replace(/۴/g, '4');
    str = str.replace(/۵/g, '5');
    str = str.replace(/۶/g, '6');
    str = str.replace(/۷/g, '7');
    str = str.replace(/۸/g, '8');
    str = str.replace(/۹/g, '9');

    str = str.replace(/▒| /g, '0');
    str = str.replace(/١/g, '1');
    str = str.replace(/٢/g, '2');
    str = str.replace(/٣/g, '3');
    str = str.replace(/٤/g, '4');
    str = str.replace(/٥/g, '5');
    str = str.replace(/٦/g, '6');
    str = str.replace(/٧/g, '7');
    str = str.replace(/٨/g, '8');
    str = str.replace(/٩/g, '9');
    return str;
}

function commaSeperated(num) {
    return num.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",");
}

function digitsToLatin(str) {
    if (str == undefined) return '';
    str = str.toString();
    str = str.replace(/۰/g, '0');
    str = str.replace(/۱/g, '1');
    str = str.replace(/۲/g, '2');
    str = str.replace(/۳/g, '3');
    str = str.replace(/۴/g, '4');
    str = str.replace(/۵/g, '5');
    str = str.replace(/۶/g, '6');
    str = str.replace(/۷/g, '7');
    str = str.replace(/۸/g, '8');
    str = str.replace(/۹/g, '9');
    return str;
}
function digitsToHindi(str) {
    if (str == undefined) return '';
    str = str.toString();
    str = str.replace(/0/g, '۰');
    str = str.replace(/1/g, '۱');
    str = str.replace(/2/g, '۲');
    str = str.replace(/3/g, '۳');
    str = str.replace(/4/g, '۴');
    str = str.replace(/5/g, '۵');
    str = str.replace(/6/g, '۶');
    str = str.replace(/7/g, '۷');
    str = str.replace(/8/g, '۸');
    str = str.replace(/9/g, '۹');
    return str;
}

function appendAllPrices() {
    $('.priceReadable').each(function () {
        if (!$(this).hasClass('ignore')) {
            if ($(this).hasClass('shortPrice'))
                $(this).text(priceToReadable($(this).attr('price'), 'short'));
            else
                $(this).text(priceToReadable($(this).attr('price')));
        }
    });
    priceToPersianNumber();
}

function priceToPersianNumber() {
    $('.priceReadable').each(function () {
        traverse($(this)[0]);
    });

}
