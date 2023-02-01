<div class="main-user">
	<div class="container room user-panel">
		<div class="col-sm-10 col-sm-offset-1 col-xs-12 padding-xs-0">
			<div class="row!!!">
				<div class="col-md-3 padding-xs-0"> <!-- left sidebar (smaller) -->
				<ul class="list-unstyled sidenav-list">
	  <li>
	    <a href="/houses" aria-selected="true" class="sidenav-item @if($currentRout == 'houses') {{'bold'}} @endif"><lng key="user.myListings"></a>
	  </li>
	  <li>
	    <a href="/my_reservations" aria-selected="false" class="sidenav-item @if($currentRout == 'my_reservations') {{'bold'}} @endif"><lng key="user.myReserves"></a>
	  </li>
	<!--   <li>
	  <a href="/hosting/requirements" aria-selected="false" class="sidenav-item">Reservation Requirements</a>
	  </li> -->

	<div class="space-top-4 space-4">
	  <a href="/houses/new" aria-selected="false" class="btn btn-default"><lng key="user.newHouseButton"></lng></a>
	</div>

	      </ul>
				</div>
				<div class="col-md-9 padding-xs-0">
					<div class="panel space-4">
						<div class="panel-header">
							 لیست آگهی ها
						</div>
							<ul class="list-unstyled myhouses" style="background-color: #f5f5f5; padding: 0;">
						 	@if($houses->isEmpty())
						     	<p class="panel-body">لیست شما خالی است.</p>
							@endif

							@foreach($houses as $house)
								<li class="col-xs-12 col-lg-6 user-panel-cards" style="margin-bottom: 15px !important">
									<div class="container col-xs-12 padding-xs-0;" style="padding: 6px">
										<a href="/houses/show/{{ $house->id }}">
										<div class="houses-info-container">
											<div class="houses-img-container">
												<div>
													<img src="@if($house->photo['thumbnail_path'] == null) /img/camera.png @else {{$house->photo['thumbnail_path']}} @endif">
												</div>
											</div>

											<div class="houses-locationAndRate-container">
												<div style="margin-bottom: 8px">
													<div class="houses-title">@if($house->title == '') &nbsp; @else {{ $house->title }} @endif</div>
													<div>@if($house->province == '' && $house->city == '') &nbsp; @else {{ $house->province }} - {{ $house->city }} @endif</div>
												</div>

												<div class="houses-rate-container">
													<div style="display: inline-block;">
														<i class="fa fa-star" style="color: #008489"></i>
														<i class="fa fa-star" style="color: #008489"></i>
														<i class="fa fa-star" style="color: #008489"></i>
														<i class="fa fa-star" style="color: #008489"></i>
														<i class="fa fa-star" style="color: #008489"></i>
													</div>
												</div>
											</div>
										</div>

										<div class="houses-btn-container">
											<a href="/houses/edit/{{ $house->id }}" class="houses-btn" style="width: 49%;">
												<div>
													<div class="houses-btn-icon"><i class="fa fa-pencil-square-o" aria-hidden="true"></i></div>
													<div>ویرایش</div>
												</div>
											</a>

											<a href="#" class="houses-btn" style="width: 49%;"">
												<div>
													<div class="houses-btn-icon"><i class="fa fa-calendar" aria-hidden="true"></i></div>
													<div>تقویم</div>
												</div>
											</a>
										</div>
									</div>
								</li>
							@endforeach
				


							<!-- @if($houses->isEmpty())
							     <p class="panel-body">لیست شما خالی است.</p>
							@endif
							@foreach($houses as $house)
						   	   <li class="panel-body">
									<div class="row row-table">
										<div class="pic col-lg-3 col-md-4 col-lg-offset-0 col-sm-offset-0 col-sm-5 col-xs-6 col-sm-offset-3 col-xs-offset-1 text-xs-center">
											<a href="/houses/show/{{ $house->id }}" class="photo">
												<div class="media-photo">
													<div class="media-cover">
														<?php $imgPath = $house->photos()->get()->first()["path"]; ?>
														@if($imgPath != "")
															<img src="data:image/jpeg;base64,{{base64_encode(file_get_contents($imgPath)) }}">
														@endif
														
													</div>
												</div>
											</a>
										</div>

										<div class="col-md-5 col-sm-7 col-xs-10 col-sm-offset-0 col-xs-offset-1 col-mid text-xs-center">
											<span class="h4 houseName">
												<a href="/houses/show/{{ $house->id }}">{{ $house->title }}</a>
											</span>
											<div class="actions hidden-xs">
												<a href="/houses/edit/{{ $house->id }}">ویرایش مشخصات آگهی</a>
											</div>
										</div>
										<div class="text-center col-md-3 col-sm-7 col-md-offset-0 col-sm-offset-3 col-xs-offset-1 steps-left">
											<a href="/houses/edit/{{ $house->id }}" class="btn btn-default col-xs-10 top-2">ویرایش آگهی</a>
											<button id="/houses/delete/{{ $house->id }}" class="btn btn-warning remove remove-house- col-xs-10">حذف آگهی</button>
										</div>
									</div>
								</li>

								<hr>
						    @endforeach -->
							</ul>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
 