<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;

class PassportAuthController extends Controller
{
    // registration

    public function register(Request $request)
    {
        $this->validate($request, [ // 유효성 검사가 실패하면, 적절한 응답이 자동으로 생성됨
            'name' => 'Required|min:4',
            'email' => 'required|email',
            'password' => 'required|min:8',
        ]);

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => bcrypt($request->password),
        ]);

        $token = $user->createToken('LaravelAuthApp')->accessToken; // createToken('토큰이름')

        return response()->json(['token' => $token], 200); // json responses
    }

    //login

    public function login(Request $request)
    {
        $data = [
            'email' => $request->email,
            'password' => $request->password,
        ];

        if (auth()->attempt($data)) {
            $token = auth()->user()->createToken('LaravelAuthApp')->accessToken;
            return response()->json(['token' => $token], 200);
        } else {
            return response()->json(['error' => 'Unauthorised']);
        }
    }
}
