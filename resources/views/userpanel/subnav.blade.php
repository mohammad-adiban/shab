 <div class="subnav mg-top">
 	<div class="container">
 		<div class="col-xs-12 col-lg-10 col-lg-offset-1 padding-xs-0 list-unstyled-container">
			<ul class="list-unstyled list-unstyled-customize">
				<li class="col-xs-3">
					<a href="/dashboard" class="subnav-item @if($currentRout == 'dashboard') {{'brdr-bttm'}} @endif">پیشخوان</a>
				</li>
				<li class="col-xs-3">
					<a href="/houses" class="subnav-item @if($currentRout == 'houses') {{'brdr-bttm'}} @endif">آگهی های من</a>
				</li>
				<li class="col-xs-3">
					<a href="/trips" class="subnav-item @if($currentRout == 'trips') {{'brdr-bttm'}} @endif">سفرهای من</a>
				</li>
				<li class="col-xs-3" style="margin-left: 0 !important">
					<a href="/users/edit" class="subnav-item @if($currentRout == 'users/edit' || $currentRout == 'uesrs/security') {{'brdr-bttm'}} @endif">مشخصات من</a>
				</li>
			</ul>
		</div>
 	</div>
 </div>