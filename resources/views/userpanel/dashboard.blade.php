@if(session('status') == 1000)
	<div class="col-xs-2 col-xs-offset-5 successMsg">
		<p>تصویر جدید با موفقیت ثبت شد</p>
	</div>
@endif

<div class="main-user">

<div class="container dashboard user-panel">
	<div class="col-sm-10 col-sm-offset-1">
		<div class="row!!!">
			<div class="col-md-3 col-sm-4"> <!-- left sidebar (smaller) -->
			<div class="panel space-4">
				<div class="media photo-block">

					<a href="#">
						<img height="160" id="profile_pic" width="160" src="data:image/{{getPicture()}}" alt="profile picture">
					</a>
					<form method="post" enctype="multipart/form-data" id="pic_change" action="{{url('/users/upload_pic')}}">
			          {!! csrf_field() !!}
						<div class="btn btn-default upload-photo-btn">
							 <label for="change-pic">
								<i class="fa fa-camera"></i>
								انتخاب تصویر پروفایل
								</label>
							 <input name="picture" type="file" id="change-pic" style="display: none">
						</div>
						 <input type="submit" class="btn btn-default text-center top-2" value="ثبت عکس" id="submit" style="display:none">
					</form>
				</div>
				<div class="panel-body">
					<h2 class="text-center">{{$user->name}}</h2>
					<ul class="list-unstyled text-center">
						<li>
							<a href="/users/edit"><lng key="dashboard.viewProfile"></lng></a>
						</li>
						<li>
							<a href="/users/edit" class="btn1 btn-primary-1 btn-block text-wrap space-top-1" id="edit-profile"><lng key="dashboard.editProfile"></lng></a>
						</li>
					</ul>
				</div>
			</div>
		</div>
		<div class="col-md-9 col-sm-8"> <!-- right sidebar (bigger) -->
		<div class="panel space-4">
			<div class="panel-header">
				<lng key="dashboard.notifs"></lng>
			</div>
			<div class="panel-body">
				<p>
					در حال حاضر اطلاعیه‌ای ندارید
				</p>
				<!-- <ul class="list-unstyled">
					<li class="space-2">
						<strong><a href="/rooms">تیتر</a></strong>
						<div>متن تیتر متن تیتر متن تیتر متن تیتر </div>
					</li>
 					<hr>
					<li class="space-2">
						<strong><a href="/rooms">تیتر</a></strong>
						<div>متن تیترمتن تیتر متن تیتر متن تیتر متن تیتر متن تیتر </div>
					</li>
 					<hr>
 
					<li class="space-2">
						<strong><a href="/rooms">تیتر</a></strong>
						<div>متن تیترمتن تیتر متن تیتر متن تیتر متن تیتر </div>
					</li>
 
				</ul> -->
			</div>
		</div>
		
	<!-- 	<div class="panel space-4">
			<div class="panel-header">
				Messages (0 new)
			</div>
			<div class="panel-body">
				<p>
					When you message hosts or send reservation requests, you’ll see their responses here.
				</p>
			</div>
		</div>	 -->

		<div class="panel space-4">
			<div class="panel-header">
				<lng key="dashboard.invFriends"></lng>
			
			</div>
			<div class="panel-body">
				<div class="col-sm-9">
					<p>
						دوستان خود را به شب دعوت کنید.
					</p>
				</div>
				{{--<div class="col-sm-3">--}}
					{{--<a href="#" class="btn invite btn-primary"><lng key="dashboard.invFriends"></lng></a>--}}
				{{--</div>--}}
			</div>
		</div>
	</div>
</div>
</div>
</div>
</div>

<script type="text/javascript">
	
$(document.body).on("change", "#change-pic", function(a) {

        var maxImageWidth = 1300,
            minImageWidth = 50,
            maxImageHeight = 800,
            minImageHeight = 100;

        var val = $(this).val();
        var $this = $(this);

    switch (val.substring(val.lastIndexOf('.') + 1).toLowerCase()) {
            case 'jpg':
            case 'jpeg':
                var files = !!this.files ? this.files : [];
                if (!files.length || !window.FileReader) return;
                if (/^image/.test(files[0].type)) {

                    var reader = new FileReader();
                    reader.readAsDataURL(files[0]);
                    reader.onloadend = function(response) {

                        var img1 = $('<img src =' + this.result + ' />');
                        /*
                        if (img1.get(0).naturalWidth > maxImageWidth || img1.get(0).naturalHeight > maxImageHeight) {
                            alert('سایز تصویر نمی تواند از ۱۲۸۰ در ۷۲۰ پیکسل بیشتر باشد.');
                            control = $this;
                            control.replaceWith(control = control.clone(true));
                        }
                        */
                        // if (img1.get(0).naturalWidth < minImageWidth || img1.get(0).naturalHeight < minImageHeight) {
                        //     alert('سایز تصویر نمی تواند از ۴۰۰ در ۳۰۰ پیکسل کمتر باشد.');
                        //     control = $this;
                        //     control.replaceWith(control = control.clone(true));                            
                        // }
                        // else {
                            $('#profile_pic').attr('src', this.result);
                            $('#submit').click(); 
                        // }
                    }
                }
                break;
                default: 
                    alert('فرمت تصویر باید jpeg باشد.');
                break;
        }

    // var input = this;

    // if (input.files && input.files[0]) {
    //     var reader = new FileReader();

    //     reader.onload = function (e) {
    //         $('.image#'+imgId).attr('src', e.target.result);
    //     }

    //     reader.readAsDataURL(input.files[0]);
    // }
 
});
        setTimeout(
	    function() 
	    {
	      $('.successMsg').fadeOut(500);

	    }, 4000);
</script>
