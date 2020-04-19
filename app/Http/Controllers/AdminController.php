<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\JenisTanaman;

class AdminController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth:admin');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data = JenisTanaman::all();
        return view('admin.home', ['data'=>$data,]);
        // return view('admin');
    }
}
