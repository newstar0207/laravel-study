<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Inertia\Inertia;

class roomController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        return Inertia::render('Container', [
            'user' => $user,
        ]);
    }
}
