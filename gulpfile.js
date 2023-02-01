var elixir = require('laravel-elixir');

/*
 |--------------------------------------------------------------------------
 | Elixir Asset Management
 |--------------------------------------------------------------------------
 |
 | Elixir provides a clean, fluent API for defining some basic Gulp tasks
 | for your Laravel application. By default, we are compiling the Sass
 | file for our application, as well as publishing vendor resources.
 |
 */

elixir(function(mix) {
  var bpath = 'resources/js/bootstrap/dist';
  var b_rtlPath = 'resources/js/bootstrap-rtl/dist';
  var jqueryPath = 'resources/js/jquery';
  var faPath = 'resources/js/font-awesome';
  var jUIPath = 'resources/js/jquery-ui';
  var noUIPath = 'resources/js/nouislider';
  var gmapsPath = 'resources/js/gmaps';
  var jQFormPath = 'resources/js/jquery-form';
  var galleryPath = 'resources/js/superslides';
  var momentPath = 'resources/js/moment';  
  var datepickerPath = 'resources/js/persian-datepicker';
  var newLandingJsPath = 'resources/assets/js';
  var clockPickerPath = 'resources/js/clockpicker/dist';
  var cropperPath = 'resources/js/cropper/dist';
  var locationPickerPath = 'resources/js/jquery-locationpicker-plugin/dist';
  var aCheckboxPath = 'resources/js/awesome-bootstrap-checkbox';
  var easyAutoCompletePath = 'resources/js/EasyAutocomplete'; 
  var slickPath = 'resources/js/slick-carousel/slick'; 
  mix.sass('index.scss')
      .copy(bpath + '/fonts', 'public/fonts')
      .copy(faPath + '/fonts', 'public/fonts')
      .copy(bpath + '/css/bootstrap.css', 'public/css')
      .copy(bpath + '/js/bootstrap.js', 'public/js')
      .copy(b_rtlPath + '/css/bootstrap-rtl.css', 'public/css')
      .copy(jqueryPath + '/jquery.min.js', 'public/js')
      .copy(faPath + '/css/font-awesome.css', 'public/css')
      .copy(faPath + '/css/font-awesome.min.css', 'public/css')
      .copy(noUIPath + '/distribute/nouislider.js', 'public/js')
      .copy(noUIPath + '/distribute/nouislider.css', 'public/css')
      .copy(jUIPath + '/themes/base/jquery-ui.css', 'public/css')
      .copy(galleryPath + '/dist/jquery.superslides.min.js', 'public/js')
      .copy(galleryPath + '/dist/stylesheets/superslides.css', 'public/css')
      .copy(galleryPath + '/examples/javascripts/jquery.animate-enhanced.min.js', 'public/js')
      .copy(momentPath + '/moment.js', 'public/js')
      .copy(momentPath + '-jalaali/build/moment-jalaali.js', 'public/js')
      .copy(gmapsPath + '/gmaps.js', 'public/js')
      .copy(datepickerPath + '/dist/css/persian-datepicker.css', 'public/css')
      .copy(datepickerPath + '/assets/persian-date.js', 'public/js')
      .copy(datepickerPath + '/dist/js/persian-datepicker-0.4.5.js', 'public/js')
      .copy(newLandingJsPath + '/new_landing.js', 'public/js')
      .copy(clockPickerPath + '/jquery-clockpicker.min.css', 'public/css')
      .copy(clockPickerPath + '/jquery-clockpicker.min.js', 'public/js')
      .copy(clockPickerPath + '/bootstrap-clockpicker.min.js', 'public/js')
      .copy(clockPickerPath + '/bootstrap-clockpicker.min.css', 'public/css')
      .copy(cropperPath + '/cropper.min.js', 'public/js')
      .copy(cropperPath + '/cropper.min.css', 'public/css')
      .copy(locationPickerPath + '/locationpicker.jquery.min.js', 'public/js')
      .copy(aCheckboxPath + '/awesome-bootstrap-checkbox.css', 'public/css')
      .copy(easyAutoCompletePath + '/dist/easy-autocomplete.min.css', 'public/css')
      .copy(easyAutoCompletePath + '/dist/jquery.easy-autocomplete.min.js', 'public/js')
      .copy(slickPath + '/slick.min.js', 'public/js')
      .copy(slickPath + '/slick.css', 'public/css')
      .copy(slickPath + '/slick-theme.css', 'public/css')

  mix.sass('charge_credit.scss');
  mix.sass('create_house_new.scss');
  mix.sass('house_new.scss');
  mix.sass('search_new.scss');
  mix.sass('trip.scss');
  mix.sass('telegramLink.scss');
  mix.sass('signinup.scss');
  mix.sass('calendar.scss');
  mix.sass('bookmarks.scss');
  mix.sass('helpGuest.scss');
  mix.sass('myTrips.scss');

  mix.scripts([
      'client.class.js',
      'search.js',
      'header.js',
      'slider.js',
      'newhouse.js',
      'myhouses.js',
      'app.jquery.js',
      'cities_list.js'
  ]).scripts(['create_house_new.js'], 'public/js/create_house_new.js')
  .scripts(['house_new.js'], 'public/js/house_new.js')
  .scripts(['CustomGoogleMapMarker.js'], 'public/js/CustomGoogleMapMarker.js')
    .scripts(['signinup.js'], 'public/js/signinup.js')
      .scripts(['calendar-min.js'], 'public/js/calendar-min.js')
      .scripts(['bookmarks.js'], 'public/js/bookmarks.js')
      .scripts(['helpGuest.js'], 'public/js/helpGuest.js');


    mix.version(['css/index.css', 'js/all.js']);

});
