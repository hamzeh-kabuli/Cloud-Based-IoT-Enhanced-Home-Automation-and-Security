<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\RaspberryRequest;
use App\Http\Requests\RaspberryVideoRequest;
use App\Models\Record;
use App\Models\Buzzer;
use App\Models\Fan;
use App\Models\Light;
use Illuminate\Support\Facades\Storage;
use Str;

class RaspberryController extends Controller
{
    //

	public function store(RaspberryRequest $request) {
		$data = $request->validated();

		$record = Record::create($data);

		return response()->json($record, 201);
	}

	public function switch(){

		$fan = Fan::latest()->first();
		$light = Light::latest()->first();
		$buzzer = Buzzer::latest()->first();

		if($fan){
			if($fan->is_read){
				$fan = null;
			}else{
				$fan->update(['is_read' => 1]);
			}
		}

		if($light){
			if($light->is_read){
				$light = null;
			}else{
				$light->update(['is_read' => 1]);
			}
		}

		if($buzzer){
			if($buzzer->is_read){
				$buzzer = null;
			}else{
				$buzzer->update(['is_read' => 1]);
			}
		}

		return response()->json([
			'fan' => $fan,
			'light' => $light,
			'buzzer' => $buzzer
		], 200);

	}

	public function save(RaspberryVideoRequest $request) {
		$data = $request->validated();
		// return $data;
		$videoName = null;
		$uploadedFile = request()->file('video');
		
		if($uploadedFile){
			
			$videoName = (string) Str::uuid() .'.'. $uploadedFile->getClientOriginalExtension();
			
			$path = 'public/videos/';


			Storage::putFileAs(
				$path,
				$uploadedFile,
				$videoName
			);

		}

		
		$data = $request->validated();
		$data['video'] = $videoName;

		$record = Record::create($data);

		return response()->json($record, 201);
	}
}
