<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Laravel\Socialite\Facades\Socialite;
use Illuminate\Support\Str;

class KakaoAuthController extends Controller
{
    public function redirect()
    {
        // redirect 메소드는 사용자를 OAuth 서비스로 이동시키고
        return Socialite::driver('kakao')->redirect();
    }

    public function callback()
    {
        // user 메소드는 유입되는 request를 읽어들여, 사용자 정보를 조회합니다
        $user = Socialite::driver('kakao')->user();

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
