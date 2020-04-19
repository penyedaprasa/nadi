<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\JenisTanaman;

class JenisTanamanController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:admin');
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data = JenisTanaman::all();
        // return $data;
        return view('admin.jenis_tanaman.jenis_tanaman', ['data'=>$data]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.jenis_tanaman.tambah_edit');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $data = new JenisTanaman();
        $data->nama_tanaman   = $request->nama_tanaman;
        $data->usia_tanaman   = $request->usia_tanaman;
        $data->keterangan   = $request->keterangan;


        $photos = $request->file('foto_tanaman');
        $namaFile = $photos->getClientOriginalExtension();
        $savename = time().'.'.$namaFile;
        $photos->move("images/jenis_tanaman/", $savename);
        $data->gambar_tanaman = $savename;

        // $data->gambar_tanaman('foto_tanaman') = $savename;
        
        // $data->gambar_tanaman = $model;
        $data->min_cahaya   = $request->min_cahaya;
        $data->max_cahaya   = $request->max_cahaya;
        $data->min_nutrisi   = $request->min_nutrisi;
        $data->max_nutrisi   = $request->max_nutrisi;
        $data->min_kelembaban   = $request->min_kelembaban;
        $data->max_kelembaban   = $request->max_kelembaban;
        $data->min_suhu   = $request->min_suhu;
        $data->max_suhu   = $request->max_suhu;
        $data->min_tanah   = $request->min_tanah;
        $data->max_tanah   = $request->max_tanah;
        $data->save();
        // dd($data);



        return redirect()->route('jenis_tanaman.index')->with('alert', 'Data Sukses Disimpan');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $data = JenisTanaman::findOrFail($id);
        return view('admin.device.tambah_edit', ['update'=>'1', 'data'=>$data]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
