<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class TestController extends Controller
{
    public function index() {
        $name = 'newstar';
        $age = 21;
        return view('test.show', compact('name', 'age'));
    }
}
