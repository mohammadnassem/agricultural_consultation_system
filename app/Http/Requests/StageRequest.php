<?php

namespace App\Http\Requests;

use App\Traits\GeneralTrait;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\ValidationException;

class StageRequest extends FormRequest
{
    use GeneralTrait;
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
     * @return array
     */
    public function rules()
    {
        return [
            'name' => 'required|string',
            'plant_id' => 'required|numeric',
            'step' => 'required|numeric',
            'description' => 'nullable|string',
            'watering_period' => 'nullable|timestamp',
            'interval' => 'nullable|string',
            'image' => 'nullable|string',

        ];
    }

    protected function failedValidation(\Illuminate\Contracts\Validation\Validator $validator)
    {
        $response =  $this->returnError("400",$validator->errors()->first());

        throw new ValidationException($validator, $response);
    }
}
