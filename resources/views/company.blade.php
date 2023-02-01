@include('header')
<?php use Illuminate\Support\Facades\Route;
$currentRout = Route::getFacadeRoot()->current()->uri();
?>
 <div class="subnav mg-top">
    <div class="container">
        @if($currentRout != 'help/guest')
            <div class="col-sm-10 col-sm-offset-1">
                <ul class="list-unstyled">
                    <li>
                        <a href="{{ url('/about') }}" class="subnav-item  @if($currentRout == 'about') {{'brdr-bttm'}} @endif"><lng key="company.about"></lng></a>
                    </li>
                    <li>
                        <a href="{{ url('/policies') }}" class="subnav-item  @if($currentRout == 'policies') {{'brdr-bttm'}} @endif"><lng key="company.policies"></lng></a>
                    </li>
                    <li>
                        <a href="{{ url('/careers') }}" class="subnav-item  @if($currentRout == 'careers') {{'brdr-bttm'}} @endif"><lng key="company.careers"></lng></a>
                    </li>
                    <li>
                        <a href="{{ url('/terms') }}" class="subnav-item @if($currentRout == 'terms') {{'brdr-bttm'}} @endif"><lng key="company.terms"></lng></a>
                    </li>
                    <li>
                        <a href="{{ url('/refund') }}" class="subnav-item @if($currentRout == 'refund') {{'brdr-bttm'}} @endif"><lng key="company.refund"></lng></a>
                    </li>
                    <li>
                        <a href="{{ url('/help/host') }}" class="subnav-item @if($currentRout == 'help/host') {{'brdr-bttm'}} @endif"><lng key="company.help"></lng></a>
                    </li>
                    <li>
                        <a href="{{ url('/complaints') }}" class="subnav-item @if($currentRout == 'complaints') {{'brdr-bttm'}} @endif"><lng key="company.complaints"></lng></a>
                    </li>
                </ul>
            </div>
        @endif
    </div>
 </div>
 <div class="container room mg-top space-4">
    <div id="content1" class="@if($currentRout != 'help/guest') col-xs-10 col-xs-offset-1 @endif ">
    @if($currentRout == 'help/host' || $currentRout == 'help/trust')
            <div class="col-sm-3 panel flt-rtl">  
                <ul class="list-unstyled sidenav-list">
                      <li>
                        <a href="/help/trust" aria-selected="false" class="sidenav-item @if($currentRout == 'help/trust') {{'bold'}} @endif"><lng key="company.helpTrust"></a>
                      </li>
                      <li>
                        <a href="/help/guest" aria-selected="false" class="sidenav-item @if($currentRout == 'help/guest') {{'bold'}} @endif"><lng key="company.helpGuest"></a>
                      </li>
                      <li>
                        <a href="/help/host" aria-selected="true" class="sidenav-item @if($currentRout == 'help/host') {{'bold'}} @endif"><lng key="company.helpHost"></a>
                      </li>
                </ul>
            </div>
    <div class="col-sm-8 company"> {{ $content }} </div>

    @elseif($currentRout == 'help/guest')
        @include('helpguest')

    @elseif($currentRout == 'careers')
        @include('careers')
    @elseif($currentRout == 'complaints')
            <div class="company" style="margin-bottom: 20px;"> {{ $content }} </div>
            {{-- 

            <div class="col-xs-12" style="margin-top:12px;">

            <div class="col-xs-3">
                <p style="font-size: 18px; margin-bottom: 28px">تماس با ما</p>

                <p>نام و نام خانوادگی</p>
                <input required type="text" name="name" class="form-control" />
            </div>
        </div>
            <div class="col-xs-12" style="margin-top:12px;">
                <div class="col-xs-3">
                    <p>پست الکترونیک</p>
                    <input required type="text" name="email" class="form-control" />
                </div>
            </div>

            <div class="col-xs-12" style="margin-top:12px;">
                <div class="col-xs-3">
                    <p>شماره موبایل</p>
                    <input required type="text" name="mobile" class="form-control" />
                </div>
            </div>

            <div class="col-xs-12" style="margin-top:12px;">
                <div class="col-xs-6">
                    <p>متن پیغام</p>
                    <textarea required type="text" rows="10" cols="150" name="name" class="form-control"></textarea>
                </div>
            </div>


            <div class="col-xs-12" style="margin-top:12px;margin-bottom: 20px;">
                <div class="col-xs-6">
                    <button type="button" class="btn btn-info" onclick="setTimeout(function(){alert('پیام شما با موفقیت ارسال شد');$('.btn').attr('disabled', 'true') },1000)" style=" padding: 7px 80px;" >ارسال</button>
                </div>
            </div>
            --}}
    @else
      <div class="company"> {{ $content }} </div>
    @endif
     </div>
 </div>
@include('footer')
