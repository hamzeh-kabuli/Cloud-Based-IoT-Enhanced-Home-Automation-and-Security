<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Record;
use App\Models\Fan;
use App\Models\Light;
use App\Models\Buzzer;

class LogController extends Controller
{
    //

	public function state() {
	    $log = Record::orderBy('id', 'desc')->paginate(10);
	    
	    return response()->json($log, 200);
	}

	public function fan() {
		$log = Fan::orderBy('id', 'desc')->paginate(10);

		return response()->json($log, 200);
	}

	public function light() {
		$log = Light::orderBy('id', 'desc')->paginate(10);

		return response()->json($log, 200);
	}

	public function buzzer() {
		$log = Buzzer::orderBy('id', 'desc')->paginate(10);

		return response()->json($log, 200);
	}
}
