<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\API\BaseController;
use App\Models\User;
use Illuminate\Support\Facades\Validator;

class AuthController extends BaseController
{
    public function signin(Request $request)
    {
        if (Auth::attempt(['email' => $request->email, 'password' => $request->password])) {
            $authUser = Auth::user();
            $success['token'] = $authUser->createToken('MyAuthApp')->plainTextToken; //plainTextToken -> 해시되지 않음
            $success['name'] = $authUser->name;

            return $this->sendResponse($success, 'User signed in');
        } else {
            return $this->sendError('Unauthorised.', ['error' => 'Unauthorised']);
        }
    }

    public function signup(Request $request)
    {
        // validator 수동으로 생성하기
        $validator = Validator::make($request->all(), [
            'name' => 'required',
            'email' => 'required|email',
            'password' => 'required',
            'confirm_password' => 'required|same:password',
        ]);

        if ($validator->fails()) {
            return $this->sendError('Error validation', $validator->errors()); // MessageBag 인스턴스를 받음
        }

        $input = $request->all();
        $input['password'] = bcrypt($input['password']);
        $user = User::create($input);
        $success['token'] = $user->createToken('MyQuthApp')->plainTextToken;
        $success['name'] = $user->name;

        return $this->sendResponse($success, 'User created successfully.');
    }
}
