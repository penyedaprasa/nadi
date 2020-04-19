<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use App\Tanaman;
use Yajra\DataTables\DataTables;

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
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data = Tanaman::with('petani')->get();
        return view('admin.tanaman.index', ['data'=>$data]);
        // return view('home');
    }

}
