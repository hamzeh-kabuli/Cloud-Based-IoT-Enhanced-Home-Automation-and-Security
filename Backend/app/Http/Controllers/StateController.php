<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Record;

class StateController extends Controller
{
    //
	public function index(Request $request){

		$record = Record::latest()->first();

		return response()->json($record, 200);

	}
	

}
