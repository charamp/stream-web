<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;

use App\Alarm;
use App\AlarmCust;

class LoadAlarmController extends Controller
{	
	public function LoadNewAlarm(Request $request) {
		$last_id = $request->input('last_id');
		$last_time_updated = $request->input('last_time_updated');
		if ($last_id == '') {
			$alarms = Alarm::orderBy('time_updated', 'desc')->take(10)->get();
		}
		else {
			$alarms = Alarm::where('time_updated', '>', $last_time_updated)->orderBy('alarm_id')->get();
		}
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
		#return $result;
		return response()->json($result);
	}

	public function LoadAlarmMore(Request $request) {
		$offset = $request->input('offset');
		$alarms = Alarm::orderBy('time_updated', 'desc')->take(10)->skip((int)$offset)->get();
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
		return response()->json($result);
	}
	
	public function LoadDetail(Request $request) {
		$alarm_id = $request->input('alarm_id');
		$alarm = Alarm::where('alarm_id', '=', $alarm_id)->first();
		$alarm['position'] = $alarm['node'] . ' ' . $alarm['rack'] . ' ' . $alarm['card'] . ' ' . $alarm['port'] . ' ' . $alarm['s1'] . ' ' . $alarm['s2'];
		if ($alarm['result'] == "0") {
			$alarm['result'] = "Stop";
		}
		else {
			$alarm['result'] = "Start";
		}
		$customers = AlarmCust::where('alarm_id', '=', $alarm_id)->get();
		$alarm['customer_list'] = $customers;
		$result = $alarm;
		return response()->json($result);
	}
}
