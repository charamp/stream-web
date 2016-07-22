<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;

use View;
use App\Alarm;
use App\Alarm_Cust;

class MonitorController extends Controller
{
    public function Monitor() {
    	$alarms = Alarm::orderBy('alarm_id', 'desc')->take(10)->skip(5)->get();
    	$last_id = $alarms[0]['alarm_id'];
    	$result = array();
    	foreach ($alarms as $alarm) {
			$alarm['position'] = $alarm['node'] . ' ' . $alarm['rack'] . ' ' . $alarm['card'] . ' ' . $alarm['port'] . ' ' . $alarm['s1'] . ' ' . $alarm['s2'];
			if ($alarm['result'] == "0") {
				$alarm['result'] = "Stop";
			}
			else {
				$alarm['result'] = "Start";
			}
			array_push($result, $alarm);
		}

    	return View::make('monitor')->with('result', $result)
    								->with('offset', 11)
    								->with('last_id',$last_id);
    }
}
