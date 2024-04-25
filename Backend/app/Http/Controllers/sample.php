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
    // Store environmental records from the Raspberry Pi
    public function store(RaspberryRequest $request) {
        $data = $request->validated();
        $record = Record::create($data);
        return response()->json($record, 201);
    }

    // Retrieve the latest state of the fan, light, and buzzer
    public function switch(){
        // Logic to get latest device states and update 'is_read' status
        ...
        return response()->json([...], 200);
    }

    // Save video and environmental data from the Raspberry Pi
    public function save(RaspberryVideoRequest $request) {
        $data = $request->validated();
        ...
        $record = Record::create($data);
        return response()->json($record, 201);
    }
}
