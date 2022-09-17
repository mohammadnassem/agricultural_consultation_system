<?php

namespace App\Http\Requests;

use App\Traits\GeneralTrait;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\ValidationException;

class startPlantationRequest extends FormRequest
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
            'plant_id' => 'required|numeric',
            'user_id' => 'required|numeric',
            'stage_id' => 'nullable|numeric',
            'is_finished' => 'nullable|boolean',
            'is_protected' => 'nullable|timestamp',
            'is_clean' => 'nullable|timestamp',
            'watering_date' => 'nullable|timestamp',
            'long' => 'required|numeric',
            'city' => 'required|string',
            'soil_type' => 'required|string',
            'lat' => 'required|numeric',
            'area' => 'required|numeric',

        ];
    }

    protected function failedValidation(\Illuminate\Contracts\Validation\Validator $validator)
    {
        $response =  $this->returnError("400", $validator->errors()->first());

        throw new ValidationException($validator, $response);
    }
}
