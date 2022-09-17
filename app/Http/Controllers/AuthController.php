<?php

namespace App\Http\Controllers;

use App\Http\Requests\UserRequest;
use App\Traits\GeneralTrait;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Validator;
use \Exception as Exception;

use App\Models\User;

class AuthController extends Controller
{
    use GeneralTrait;

    public function login(UserRequest $request)
    {
        if (Auth::attempt(['email' => $request->email, 'password' => $request->password])) {
            $auth = Auth::user();
            $auth->tokenNotif=$request->tokenNotif;
            $auth->save();
            $success['token'] =  $auth->createToken('LaravelSanctumAuth')->plainTextToken;
            $auth['token'] = $success['token'];
            return $this->returnData('user', $auth);
        } else {
            return $this->returnError("400", "The Password or Email not Correct");
        }
    }

    public function register(UserRequest $request)
    {
        try {
            $input = $request->validated();
            $input['password'] = bcrypt($input['password']);
            $user = User::create($input);
            $user['token'] =  $user->createToken('LaravelSanctumAuth')->plainTextToken;
            $user['token_type'] = 'Bearer';

            return $this->returnData('user', $user);
        } catch (Exception $e) {
            return $this->returnError("400", "Invalid Data");
        }
    }

    public  function logout()
    {
        Auth::user()->tokens()->delete();
        return $this->returnSuccessMessage("you have successfully logout and token was successfully deleted");
    }
    public function me(Request $request)
    {

        return $this->returnData('user', $request->user());
    }

    public function getUserById($user_id)
    {
        return User::find($user_id);
    }
}
