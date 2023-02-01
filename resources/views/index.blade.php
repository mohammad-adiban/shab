@include('header')
<!-- search bar section -->
<section class="s1">
	<div class="slider">
		<div class="sh-slideshow">
			<ul class="list-unstyled">
				<li class="sh-slide">
					<img src="{{asset('img/wall.jpg')}}" alt="shab">
				</li>
			</ul>
		</div>
	</div>
	<div class="container hero">
		<div class="s1-container col-lg-12">
			<div class="s1-container-2">
				<h2><lng key="index.welcome"></lng></h2>
				<h4 class="hidden-xs"><lng key="index.welcomeDesc"></lng></h4>
				<a id="how-it-works" href="#intro"><lng key="index.shabHelp"></lng></a>
			</div>
		</div>
	</div>
	<div id="search-bar" class="search-bar">
		<div class="search-bar-1">
			<form id="search-form" action="" method="GET">
				
				<div class="col-md-offset-2 col-xs-offset-1">
					<button id="searchbar-submit" class="btn btn-success" type="submit"><span class="hidden-sm hidden-xs"><lng key="index.search"></lng></span><i class="visible-xs visible-sm fa fa-search"></i></button>
					<div class="col-xs-1 col-padding  hidden-xs">
						<select dir="rtl" class="form-control">
							<option><lng key="index.guestCount"></lng></option>
							<option>۱ نفر</option>
							<option>۲ نفر</option>
						</select>
					</div>
					<div class="col-xs-3 col-sm-4 col-padding col-margin  hidden-xs">
						<div class="col-xs-5 col-padding">
							<input dir="auto" id="checkout" placeholder="index.retDate" type="text" class="form-control">
							
						</div>
						<div class="col-xs-1 col-padding arrow-left"><i class="fa fa-long-arrow-left"></i></div>
						<div class="col-xs-5 col-padding col-xs-offset-2">
							<input dir="auto" id="checkin" placeholder="index.startDate" type="text" class="form-control">
							
						</div>
					</div>
					<div class="col-xs-10 col-md-3 col-sm-5 col-padding col-3-increase">
						<input  dir="auto" placeholder="index.destination" type="text" class="form-control inp-padding">
					</div>
				</div>
				
				
			</form>
		</div>
	</div>
</section>
<!-- end of search bar section -->
<!-- section between header and footer -->
<section class="s2" id="intro">
	<div class="container">
		<div class="col-lg-12 col-lg-offset-1s">
			<div class="space-top-2">
				<div class="col-sm-4 step-1">
					<div class="panel-body">
						<div class="bg-img"></div>
						<h3 class="text-center">تیتر اول</h3>
						<p>می توان به راحتی با جستجو در شب، انبوهی از اقامتگاه ها را بررسی کرده پ با مقایسه آن ها، اقامتگاه مورد نظر خود را انتخاب کنید.</p>
					</div>
				</div>
				<div class="col-sm-4 step-2">
					<div class="panel-body">
						<div class="bg-img"></div>
						<h3 class="text-center">تیتر دوم</h3>
						<p>محلی را که انتخاب کردید به راحتی در شب رزرو کرده و آماده ی سفر می شوید.</p>
					</div>
				</div>
				<div class="col-sm-4 step-3">
					<div class="panel-body">
						<div class="bg-img"></div>
						<h3 class="text-center">تیتر سوم</h3>
						<p>به مکان مورد نظرتان سفر می کنید و از اقامتتون لذت می برید و تجربیاتتان را با ما نیز به اشتراک می گذارید!</p>
					</div>
				</div>
			</div>
			<div class="col-md-10 col-md-offset-1 learn-more">اگر دوست دارید راجع به روند کار بیشتر بدانید، می توانید <a href="#">اینجا</a> مطالعه کنید.
		</div>
	</div>
</div>
</section>
<section class="container s3">
<div class="space-top-2 text-center">
	<h2>معرفی مکان ها</h2>
</div>
<ul class=" col-center list-unstyled">
	<li class="col-md-3 col-lg-3 col-sm-6 col-xs-12 space-md-4">
		<a href="">
			<div class="community-c">
				<div class="col-md-11 col-xs-11 pad-top text-center">
					<h2>تیتر اول</h2>
					<p>معرفی اقامتگاه های روستایی</p>
				</div>
			</div>
		</a>
	</li>
	<li class="col-md-3 col-lg-3 col-sm-6 col-xs-12 space-md-4">
		<a href="">
			<div class="community-c">
				<div class="col-md-11 col-xs-11 pad-top text-center">
					<h2>تیتر دوم</h2>
					<p>پیش بینی آب و هوا</p>
				</div>
			</div>
		</a>
	</li>
	<li class="col-md-3 col-lg-3 col-sm-6 col-xs-12 space-md-4">
		<a href="">
			<div class="community-c">
				<div class="col-md-11 col-xs-11  pad-top text-center">
					<h2>تیتر سوم</h2>
					<p>معرفی مکان های تفریحی</p>
				</div>
			</div>
		</a>
	</li>
	<li class="col-md-3 col-lg-3 col-sm-6 col-xs-12  space-md-4">
		<a href="">
			<div class="community-c">
				<div class="col-md-11 col-xs-11 pad-top text-center">
					<h2>تیتر چهارم</h2>
					<p>معرفی مکان های تاریخی</p>
				</div>
			</div>
		</a>
	</li>
</ul>
</section>
<!-- end of section -->
</body>
@include('footer')