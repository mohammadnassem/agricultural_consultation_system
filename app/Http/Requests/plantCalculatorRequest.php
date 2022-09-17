<?php

namespace App\Http\Requests;

use App\Traits\GeneralTrait;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\ValidationException;

class plantCalculatorRequest extends FormRequest
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
            'area' => 'required|numeric|gt:0',
            'length' => 'nullable|numeric|gt:0',
            'width' => 'nullable|numeric|gt:0',
        ];
    }

    protected function failedValidation(\Illuminate\Contracts\Validation\Validator $validator)
    {
        $response =  $this->returnError("400",$validator->errors()->first());

        throw new ValidationException($validator, $response);
    }
}
