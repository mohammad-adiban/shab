@if(session('status'))
    <div class="col-xs-4 col-xs-offset-4 successMsg">
       <p> {{session('status')}} </p>
    </div>
@endif

<div class="careers col-md-8 col-md-offset-2 col-sm-10 col-sm-offset-1">

    <div class="">
        <p>اگر قصد همکاری با سایت shab.ir را دارید، فرم زیر را پر کنید.</p>
    </div>
    <form action="{{url('careers')}}" method="post">
                      {!! csrf_field() !!}

        <div class="col-sm-6 col-xs-12 flt-rtl">
            <div class="cr-item">
                <label for="name" class="inl-blk">نام و نام خانوادگی</label>
                <div class="inp inl-blk">
                    <input type="text" id="name" name="name" class="form-control">
                </div>
            </div>
            <div class="cr-item">
                <label for="mobile" class="inl-blk">شماره تلفن همراه</label>
                <div class="inp inl-blk">
                    <input id="mobile" type="text" name="mobile" class="form-control">
                </div>
            </div>
        </div>
        <div class="col-sm-6 col-xs-12">
            
            <div class="cr-item">
                <label for="email" class="inl-blk">پست الکترونیک</label>
                <div class="inp inl-blk">
                    <input type="email" id="email" name="email" class="form-control">
                </div>
            </div>
            <div class="cr-item">
                <label for="career_type" class="inl-blk">زمینه همکاری</label>
                <div class="inp inl-blk">
                    <select style="padding: 0 20px" id="career_type" name="career_type" class="form-control">
                        <option value="web_designer">طراح وب</option>
                        <option value="graphist">گرافیست</option>
                        <option value="photographer">عکاس</option>
                        <option value="amlak">معاملات املاک</option>
                        <option value="bazaaryab">بازاریاب</option>
                        <option value="marketing">مارکتینگ</option>
                        <option value="hosting">میزبان</option>
                    </select>
                </div>
            </div>
        </div>
        <div class="col-xs-12">
            <div class="cr-item">
                <label style="margin-top: -50px;" for="details" class="inl-blk">توضیح بیشتر</label>
                <div class="inp area inl-blk">
                <textarea name="details" id="details" class="form-control"></textarea>
                </div>
            </div>            
        </div>
        <div class="col-md-3  col-xs-6 mg-t-2 col-xs-offset-7" style="padding:0">
            <input type="submit" class="btn btn-success" style="width:70%; margin-bottom:20px" value="ارسال">
        </div>
    </form>
</div>
<script type="text/javascript">
        $('form').submit(function() {
            var isFormValidated = true;
            var requiredFields = ['email', 'name', 'mobile'];
            for(var i=0; i<requiredFields.length; i++) {
                $input = $('[name="'+requiredFields[i]+'"]');
                if($input.val() == '') {
                        $input.addClass('error-input');
                    isFormValidated = false;
                }
                else {
                        $input.removeClass('error-input');
                }

            }

            if(isFormValidated) {
                $('.error-text').remove();
                return true;
            }
            else {
                $('.error-text').remove();
                $('input[type="submit"]').parent().after('<div class="error-text col-xs-12 text-center">* لطفا موارد اجباری مشخص شده را کامل کنید.</div>');
                return false;
            }
        });
</script>