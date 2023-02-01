@if(session('status') == 1000)
	<div class="col-xs-2 col-xs-offset-5 successMsg">
		<p>تغییرات با موفقیت انجام شد</p>
	</div>
@endif
<div class="main-user">
<div class="container room user-panel">
	<div class="col-sm-10 col-sm-offset-1">
		<div class="row!!!">
			<div class="col-sm-3"> <!-- left sidebar (smaller) -->
			<ul class="list-unstyled sidenav-list">
  <li>
    <a href="/users/edit" aria-selected="true" class="sidenav-item @if($currentRout == 'users/edit') {{'bold'}} @endif">ویرایش مشخصات</a>
  </li>
  <li>
    <a href="/users/security" aria-selected="false" class="sidenav-item @if($currentRout == 'users/security') {{'bold'}} @endif">تغییر کلمه عبور</a>
  </li>


      </ul>
			</div>
<form method="post" id="edit_profile" action="{{url('/users/edit')}}">
    {!! csrf_field() !!}
	<div class="col-sm-9 profile">

		@if(session('status') == 1000 )
			<div id="review-error-alert" class="col-xs-12 pad-r-0" style="margin: 0 0 15px 0; padding: 0">
				<div class="alert alert-success alert-dismissable fade in">
					<a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
					<span id="reviewResultAlert">اطلاعات شما با موفقیت ویرایش گردید</span>
				</div>
			</div>
		@endif

		<div class="col-sm-12 pad-l-0 pad-r-0">
			<div class="panel space-4"> 
				<div class="panel-header">
					ویرایش مشخصات
				</div>
				<div class="panel-body">
					<div class="row row-condensed space-4">
						<label class="text-left col-sm-3 info" for="user_first_name">
							نام
						</label>
						<div class="col-sm-9">
							
							<input value="{{$user->name}}" class="form-control" id="user_first_name" name="name" size="30" type="text">
							
						</div>
						@if ($errors->has('name'))
						    <span class="help-block has-error-text">
						        <strong>{{ $errors->first('name') }}</strong>
						    </span>
					    @endif
					</div>

					<div class="row row-condensed space-4">
						<label class="text-left col-sm-3 info" for="user_last_name">
							نام خانوادگی
						</label>
						<div class="col-sm-9">
							
							<input value="{{$user->family}}" class="form-control" id="user_last_name" name="family" size="30" type="text" >
							
						</div>

						@if ($errors->has('family'))
						    <span class="help-block has-error-text">
						        <strong>{{ $errors->first('family') }}</strong>
						    </span>
					    @endif
					</div>

					<div class="row row-condensed space-4">
						<label class="text-left col-sm-3 info" for="user_email">
							ایمیل
						</label>
						<div class="col-sm-9">
							<input value="{{$user->email}}" class="form-control" type="text" id="user_email" name="email" size="30" type="text" >
						</div>

						@if ($errors->has('email'))
						    <span class="help-block has-error-text">
						        <strong>{{ $errors->first('email') }}</strong>
						    </span>
					    @endif
					</div>

					<div class="row row-condensed space-4">
						<label class="text-left col-sm-3 info" for="user_phone_number">
							تلفن همراه
						</label>
						<div class="col-sm-9">
							<input class="form-control" id="user_phone_number" name="mobile" size="30" type="text" value="{{$user->mobile}}" disabled="disabled">
						</div>

						@if ($errors->has('mobile'))
						    <span class="help-block has-error-text">
						        <strong>{{ $errors->first('mobile') }}</strong>
						    </span>
					    @endif
					</div>
					<div class="row row-condensed space-4">
						<label class="text-left col-sm-3 info" for="user_tel">
							تلفن ثابت
						</label>
						<div class="col-sm-9">
							
							<input class="form-control" id="user_tel" name="tel" size="30" type="text" value="{{$user->tel}}">
							
						</div>

						@if ($errors->has('tel'))
						    <span class="help-block has-error-text">
						        <strong>{{ $errors->first('tel') }}</strong>
						    </span>
					    @endif
					</div>
					<div class="row row-condensed space-4">
						<label class="text-left col-sm-3 info" for="user_address">
							آدرس
						</label>
						<div class="col-sm-9">
							
							<textarea class="form-control" id="user_address" name="address" size="30" type="text" >{{$user->address}}</textarea>
							
						</div>

						@if ($errors->has('address'))
						    <span class="help-block has-error-text">
						        <strong>{{ $errors->first('address') }}</strong>
						    </span>
					    @endif
					</div>
					<div class="row row-condensed space-4">
						<label class="text-left col-sm-3 info" for="user_gender">
							جنسیت <i class="icon icon-lock icon-ebisu" data-behavior="tooltip" aria-label="Private"></i>
						</label>
						<div class="col-sm-9">
							
							<div class="select">
								<select id="user_gender" name="gender">
									<option value="">انتخاب</option>
									<option @if($user->gender == 'male') selected @endif value="male">مرد</option>
									<option @if($user->gender == 'female') selected @endif value="female">زن</option>
								</select>
							</div>

						@if ($errors->has('gender'))
						    <span class="help-block has-error-text">
						        <strong>{{ $errors->first('gender') }}</strong>
						    </span>
					    @endif
							<div class="text-muted row-space-top-1">این اطلاعات خصوصی است و دیگر کاربران آن را نمی بینند.</div>
						</div>
					</div>
					    <?php
						    $months = array(
						    1 => 'فروردین' ,
						    2 => 'اردیبهشت' ,
						    3 => 'خرداد' ,
						    4 => 'تیر' ,
						    5 => 'مرداد' ,
						    6 => 'شهریور' ,
						    7 => 'مهر' ,
						    8 => 'آبان' ,
						    9 => 'آذر' ,
						    10 => 'دی' ,
						    11 => 'بهمن' ,
						    12 => 'اسفند'
						    );
					    ?>
					<div class="row row-condensed space-4">
						<label class="text-left col-sm-3 info" for="user_birthdate_2i">
							تاریخ تولد <i class="icon icon-lock icon-ebisu" data-behavior="tooltip" aria-label="Private"></i>
						</label>
						<div class="col-sm-9">
							
							<div class="select">
								<select id="user_birthdate_2i" name="user[birthdate(2i)]">
						            <option value="0">ماه</option>
						            @foreach ($months as $i=>$j)
						            	@if($i<10)
								            <option value="0{{$i}}">{{$j}}</option>
								        @else
								            <option value="{{$i}}">{{$j}}</option>
							            @endif
						            @endforeach
								</select>
							</div>
							<div class="select">
								<select id="user_birthdate_3i" name="user[birthdate(3i)]">
						          <option value="0">روز</option>
						            @for ($i = 1; $i <= 31; $i++)
						            @if($i<10)
						            	<option value="0{{$i}}">{{$i}}</option>
						            @else
						            	<option value="{{$i}}">{{$i}}</option>
						            @endif
						            @endfor
								</select>
							</div>
							<div class="select">
								<select id="user_birthdate_1i" name="user[birthdate(1i)]">
						            <option value="0">سال</option>
						            @for ($i = 1395; $i >= 1320; $i--)
						            <option value="{{$i}}">{{$i}}</option>
						            @endfor
								</select>
							</div>
							
						@if ($errors->has('birthdate'))
						    <span class="help-block has-error-text">
						        <strong>{{ $errors->first('birthdate') }}</strong>
						    </span>
					    @endif
							<div class="text-muted row-space-top-1">این اطلاعات خصوصی است و دیگر کاربران آن را نمی بینند.</div>
						</div>
					</div>
				</div>
			</div>
 
<!-- 			<div id="business-travel" class="panel space-4">
				<div class="panel-header">
					Business Travel
				</div>
				<div class="panel-body">
					<div class="row row-condensed space-4">
						<label class="text-left col-sm-3" for="">
							Work Email Address <i class="fa fa-lock" data-behavior="tooltip" aria-label="Private"></i>
						</label>
						<div class="col-sm-9">
							<input class="form-control" type="text" value="" data-reactid=".187ot9g64g0.0.0.0"><div><span >Expense business trips easily and see Business Travel Ready homes.</span></div></div>
							
						</div>
					</div>
				</div> -->
				<input  name="birthdate" value="{{$user->birthdate}}" type="hidden">
				<button type="submit" class="space-4 btn btn-primary btn-save">
  اعمال تغییرات
</button>
			</div>
		</div>
		</form>
 		</div>
	</div>
</div>
</div>

<script type="text/javascript" src="{{ asset('js/moment.js') }}"></script>
<script type="text/javascript" src="{{ asset('js/moment-jalaali.js') }}"></script>

<script type="text/javascript">

$(document).ready(function() {

	setTimeout(
	  function() 
	  {
	    $('.successMsg').fadeOut(500);

	  }, 4000);

if($('input[name="birthdate"]').val() != 0) {
	var year = moment.utc($('input[name="birthdate"]').val(), 'X').format("jYYYY");
	var day = moment.utc($('input[name="birthdate"]').val(), 'X').format("jDD");
	var month = moment.utc($('input[name="birthdate"]').val(), 'X').format("jMM");

	$('#user_birthdate_1i').val(year);
	$('#user_birthdate_2i').val(month);

	if (day < 10)
		day = day[1];
	day++;
	if (day < 10)
		day = "0" + day;
	$('#user_birthdate_3i').val(day);
}
});

$('#edit_profile').submit(function() { 
	var year, day, month;
	year = $('#user_birthdate_1i').val();
	month = $('#user_birthdate_2i').val();
	day = $('#user_birthdate_3i').val();


    var bdate = moment(year+'-'+month+'-'+day, 'jYYYY-jMM-jDD');
    bdate = bdate.format('YYYY-MM-DD');

	if(year == '0' && month == '0' && day == '0') {
		return true;
	}

	if(year == '0') {
		alert('لطفا سال تولد را انتخاب کنید');
		return false;
	}
	else if(month == '0') {
		alert('لطفا ماه تولد را انتخاب کنید');
		return false;
	}
	else if(day == '0') {
		alert('لطفا روز تولد را انتخاب کنید');
		return false;	
	}
	else {
		$('form').append('<input type="hidden" name="birthdate">');
		$('input[name="birthdate"]').val(moment(bdate).unix());
		// $('#user_birthdate_1i, #user_birthdate_3i, #user_birthdate_2i').remove();
		return true;
	}

});
</script>