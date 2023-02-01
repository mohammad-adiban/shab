@include('header')
<?php use Illuminate\Support\Facades\Route;
$currentRout = Route::getFacadeRoot()->current()->uri();
?>
{{--@include('userpanel/subnav')--}}
@include('userpanel/'.$page)
@include('footer')