<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;

class HouseStatisticsController extends Controller
{
    public function getHouseStatistics($id)
    {
    	$house = \App\House::findOrFail($id);
    	return $house->statistics;
    }
}
