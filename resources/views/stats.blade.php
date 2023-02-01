<!DOCTYPE html>
<html>
	<head>
		<meta charset="UTF-8">
		<title>Shab Statistics</title>
	</head>
	<body>
		<h1>Registrations: </h1>
		<h2>March 6:  </h2><p>{{\App\User::whereDate('created_at', '<=', '2017-03-06')->count()}}</p>
		<h2>March 13: </h2><p>{{\App\User::whereDate('created_at', '<=', '2017-03-13')->count()}}</p>
		<h2>March 20: </h2><p>{{\App\User::whereDate('created_at', '<=', '2017-03-20')->count()}}</p>
		<h2>March 27: </h2><p>{{\App\User::whereDate('created_at', '<=', '2017-03-27')->count()}}</p>
		<h2>April 6:  </h2><p>{{\App\User::whereDate('created_at', '<=', '2017-04-06')->count()}}</p>
		<h2>April 13: </h2><p>{{\App\User::whereDate('created_at', '<=', '2017-04-13')->count()}}</p>
		<h2>April 20: </h2><p>{{\App\User::whereDate('created_at', '<=', '2017-04-20')->count()}}</p>
		<h2>April 27: </h2><p>{{\App\User::whereDate('created_at', '<=', '2017-04-27')->count()}}</p>
		<h2>From May 1 to May 11: </h2><p>{{\App\User::whereBetween('created_at', ['2017-05-01','2017-05-11'])->count()}}</p>
		
		<h1>Reservations: </h1>
		<h2>By Province: </h2>
		<p>
		{{
			json_encode(\App\Reservation::selectRaw('province, count(*) AS `reservations`')->leftJoin('houses', 'reservations.house_id', '=', 'houses.id')->groupBy('province')->whereNotIn('reservations.guest_user_id', [1, 2, 4, 649])->where('temp', 0)->where('disabled', 0)->orderBy('reservations', 'desc')->get(), JSON_UNESCAPED_UNICODE)
		}}
		</p>
		<h2>Total From 1 to 11 May: </h2><p>{{\App\Reservation::whereNotIn('id', [1, 2, 4, 649])->whereBetween('created_at', ['2017-05-01', '2017-05-11'])->count()}}</p>

		<h2>Total until April 27: </h2><p>{{\App\Reservation::whereNotIn('id', [1, 2, 4, 649])->whereDate('created_at', '<=', '2017-04-27')->count()}}</p>
		<h2>Top Reservations in the last 2 months: </h2>
		<p>{{
		\App\Reservation::selectRaw('house_id, count(*) AS `reservations`')->groupBy('house_id')->whereDate('created_at', '>=', date('Y-m-d', strtotime('-2 months')))->whereNotIn('id', [1, 2, 4, 649])->orderBy('reservations', 'desc')->take(20)->get()
    	}}</p>
		<h2>Avg guests until April 27: </h2><p>{{\App\Reservation::whereNotIn('id', [1, 2, 4, 649])->whereDate('created_at', '<=', '2017-04-27')->avg('guests')}}</p>
		<h2>Avg reserve duration until April 27: </h2>
		<p>
		<?php 
			$reservations = \App\Reservation::whereNotIn('id', [1, 2, 4, 649])->whereDate('created_at', '<=', '2017-04-27')->get();
			$count_reserve = 0;
			$avg_reserve = 0;
			foreach($reservations as $reserve)
			{
				$count_reserve++;
				$avg_reserve += $reserve->checkout - $reserve->checkin;
			}
			echo $avg_reserve/$count_reserve/86400;
		?></p>
		
		<h1>Prices: </h1>
		<h2>Avg weekdays price until April 27: </h2><p>{{\App\House::whereDate('created_at', '<=', '2017-04-27')->avg('min_price')}}</p>
		<h2>Avg weekend price until April 27: </h2><p>{{\App\House::whereDate('created_at', '<=', '2017-04-27')->avg('median_price')}}</p>
		<h2>Avg peak price until April 27: </h2><p>{{\App\House::whereDate('created_at', '<=', '2017-04-27')->avg('max_price')}}</p>
		<h2>Avg workweek price per city until April 27: </h2><p>{{
		json_encode(\App\House::selectRaw('city, AVG(min_price) AS `average_workweek_price`')->groupBy('city')->whereDate('created_at', '<=', '2017-04-27')->get(), JSON_UNESCAPED_UNICODE)}}</p>
		<h2>Avg weekend price per city until April 27: </h2><p>{{
		json_encode(\App\House::selectRaw('city, AVG(median_price) AS `average_weekend_price`')->groupBy('city')->whereDate('created_at', '<=', '2017-04-27')->get(), JSON_UNESCAPED_UNICODE)}}</p>
		<h2>Avg peak price per city until April 27: </h2><p>{{
		json_encode(\App\House::selectRaw('city, AVG(max_price) AS `average_peak_price`')->groupBy('city')->whereDate('created_at', '<=', '2017-04-27')->get(), JSON_UNESCAPED_UNICODE)}}</p>
		<h1>Photographer: </h1>
		<h2>Total: </h2><p>{{\App\House::where('photographer', 1)->count()}}</p>
	</body>
</html>
