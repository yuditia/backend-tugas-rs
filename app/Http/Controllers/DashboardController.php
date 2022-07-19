<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\User;
use Illuminate\Http\Request;


class DashboardController extends Controller
{
    public function index()
    {

        $usercount = User::count();
        $productcount = Product::count();

        return view('layouts.index',[
            'usercount'=>$usercount,
            'productcount'=>$productcount
        ]);
    }



}
