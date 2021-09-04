<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ProductsController extends Controller
{
    public function index()
    {
        // $title = 'pass data!';
        // $discription = 'created by saebyul';
        // $data = [
        //     'productsOne' => 'iphone',
        //     'productsTwo' => 'Samsung',
        // ];

        //use compact
        // return view('products.index', compact('title', 'discription'));

        //use with(key, value)
        // return view('products.index')->with('data', $data);

        //directly in to view
        // return view('products.index', [
        //     'data' => $data,
        // ]);

        //use route name
        print_r(route('products'));
        return view('products.index');
    }

    public function about()
    {
        return 'about us!!!';
    }

    public function show($name, $id)
    {
        $data = [
            '0' => 'iphone',
            'Samsung' => 'Samsung',
        ];
        return view('products.index', [
            'product' => $data[$name] ?? 'Product ' . $name . ' does not exist' . $id,
        ]);
    }
}
