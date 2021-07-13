<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Laravel\Socialite\Facades\Socialite;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class GithubAuthController extends Controller
{
    // public function __construct()
    // {
    //     $this->middleware(['guest']);
    // }

    public function redirect()
    {
        return Socialite::driver('github')->redirect();
    }

    public function callback()
    {
        $user = Socialite::driver('github')->user();
        // dd($user);

        // 1. 디비에 저장함-> 디비에 저장되어 있을 경우, 저장할 필요 없음

        $user = User::firstOrCreate(
            [
                'email' => $user->getEmail()
            ],
            [ // 검색조건
                'password' => Hash::make(Str::random(24)), // 없는 경우 포함해서 저장
                'name' => $user->getName()
            ]
        );

        // 로그인 처리
        Auth::login($user);

        // 원래 요청한 페이지가 없을 경우 dashbord 로 감
        return redirect()->intended('/dashboard');
    }
}
