<?php

namespace App\Http\Requests;

use App\Traits\GeneralTrait;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\ValidationException;

class UserRequest extends FormRequest
{
    use GeneralTrait;
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {

        return  true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        $arr = explode('@', $this->route()->getActionName());
        $method = $arr[1];  // The controller method

        switch ($method) {
            case 'login':
                return [
                     'tokenNotif' => 'required|string',
                    'email'=> 'required|string|max:255|email',
                    'password'=> 'required|string|max:8|min:5'
                ];
                break;
            case 'register':
                return [
                    'name' => 'required|string|max:255',
                    'location' => 'nullable|string|max:255',
                    'phone' => 'required|string|max:255',
                    'about' => 'required|string|max:255',
                    'email'=> 'required|string|max:255|unique:users,email|email',
                    'password'=> 'required|string|max:8|min:5',
                ];
                break;
            case 'delete':
                // .... and so
        }


    }

    protected function failedValidation(\Illuminate\Contracts\Validation\Validator $validator)
    {
        $response =  $this->returnError("400",$validator->errors()->first());

        throw new ValidationException($validator, $response);
    }
}
