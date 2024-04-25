<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Buzzer;
use App\Models\Fan;
use App\Models\Light;
use App\Http\Requests\SwitchRequest;

class SwitchController extends Controller
{
    //

	public function store(SwitchRequest $request) {
		$data = $request->validated();

		$row = null;

		if($data['name'] == 'buzzer') {

			$row = Buzzer::create([
				'state' => $data['value']
			]);

		}elseif($data['name'] == 'fan') {

			$row = Fan::create([
				'state' => $data['value']
			]);

		}if($data['name'] == 'light') {

			$row = Light::create([
				'state' => $data['value']
			]);

		}

		return response()->json($row, 201);
	}
}
