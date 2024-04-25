<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class RaspberryVideoRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules()
    {
        return [
            'humidity' => 'required|numeric',
			'temperature' => 'required|numeric',
			'light_intensity' => 'required|numeric',
			'motion' => 'required||numeric|in:0,1',
			
			'fan' => 'nullable|numeric|in:0,1',
			'lights' => 'nullable|numeric|in:0,1',
			'buzzer' => 'nullable|numeric|in:0,1',
			'video' => 'nullable|file'
        ];
    }
}
