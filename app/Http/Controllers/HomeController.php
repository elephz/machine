<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Product;
use App\Money;
class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $data=Product::all();
        $data2=Money::all();
        $all = [];
        $all['product'] = $data;
        $all['money'] = $data2;
        
        return view('home')
                    ->with('product', $data)
                    ->with('money', $data2);
    }
}
