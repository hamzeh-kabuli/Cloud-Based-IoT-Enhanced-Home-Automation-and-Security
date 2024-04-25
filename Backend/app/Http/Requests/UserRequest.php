<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UserRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
		$user = request()->user();
        return ($user->type == 1 || $user->type == 2);
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            //
			'name' => 'required|min:3|max:32',
			'type' => 'nullable',
			'location_id' => 'nullable|integer|exists:locations,id',
			'email' => 'required|email',
			'password' => 'required_if:id,""|min:6|max:32'

        ];
    }
}
