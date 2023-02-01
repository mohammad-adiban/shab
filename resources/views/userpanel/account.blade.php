   <?php use Illuminate\Support\Facades\Route;
$currentRout = Route::getFacadeRoot()->current()->uri();
?>
@if(session('status') == 1000)
  <div class="col-xs-2 col-xs-offset-5 successMsg">
    <p>رمز عبور با موفقیت تغییر یافت</p>
  </div>
@endif
    <div class="main-user">
<div class="container room user-panel">
  <div class="col-sm-10 col-sm-offset-1">
    <div class="row!!!">
      <div class="col-sm-3"> <!-- left sidebar (smaller) -->
      <ul class="list-unstyled sidenav-list">
  <li>
    <a href="/users/edit" aria-selected="true" class="sidenav-item  @if($currentRout == 'users/edit') {{'bold'}} @endif">ویرایش مشخصات</a>
  </li>
  <li>
    <a href="/users/security" aria-selected="false" class="sidenav-item  @if($currentRout == 'users/security') {{'bold'}} @endif">تغییر کلمه عبور</a>
  </li>


      </ul>
      </div>

 <form method="post" action="{{url('users/security/password')}}" >
      {!! csrf_field() !!}
      <div class="col-sm-9">
        <div class="panel space-4">
          <div class="panel-header">
             تغییر کلمه عبور 
          </div>
          <div class="panel-body">

        <div class="row">
          <div class="col-lg-7">
            <div class="row row-condensed row-space-2">
              <div class="col-md-5 text-left">
                <label for="old_password">
                  کلمه عبور کنونی
                </label>
              </div>
              <div class="col-md-7">
                <input class="form-control" id="old_password" name="oldPassword" type="password">
              </div>
              @if ($errors->has('oldPassword'))
                <span class="help-block has-error-text">
                    <strong>{{ $errors->first('oldPassword') }}</strong>
                </span>
              @endif
            </div>
          </div>
        </div>

        <div class="row">
          <div class="col-lg-7">
            <div class="row row-condensed row-space-2">
              <div class="col-md-5 text-left">
                <label for="user_password">
                  کلمه عبور جدید
                </label>
              </div>
              <div class="col-md-7">
                <input class="form-control" data-hook="new_password" id="new_password" name="newPassword" size="30" type="password">
              </div>
            </div>

            <div class="row row-condensed row-space-2">
              <div class="col-md-5 text-left">
                <label for="user_password_confirmation">
                  تایید کلمه عبور جدید
                </label>
              </div>
              <div class="col-md-7">
                <input class="form-control" id="user_password_confirmation" name="newPassword_confirmation" size="30" type="password">
              </div>
              @if ($errors->has('newPassword'))
                <span class="help-block has-error-text">
                    <strong>{{ $errors->first('newPassword') }}</strong>
                </span>
              @endif
            </div>
          </div>
          <div class="col-lg-5 password-strength" data-hook="password-strength">*کلمه عبور می بایست حداقل ۶ کاراکتر باشد</div>
        </div>
    </div>
    <div class="panel-footer">
      <button type="submit" class="btn btn-primary">
        اعمال تغییرات
      </button>
    </div>
    
        </div>
      </div>
      </form>
    </div>
  </div>
</div>
</div>
<script type="text/javascript">
$(document).ready(function() {
  
    setTimeout(
    function() 
    {
      $('.successMsg').fadeOut(500);

    }, 4000);
});
</script>