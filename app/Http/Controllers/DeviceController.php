<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Device;
use App\Petani;

class DeviceController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:admin');
        // $this->middleware('api', [
        // 'only' => ['','']
        // ]);
        
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $no = 1;
        $data = Device::with('petani')->get();
        return view('admin.device.index', ['data'=>$data, 'no'=>$no]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $petani = Petani::all();

        return view('admin.device.tambah_edit', ['petani'=>$petani]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $data = new Device();
        $data->id_channel   = $request->id_channel;
        $data->api_key      = $request->api_key;
        $data->id_petani    = $request->petani_id;
        $data->tahun        = $request->tahun;
        $data->keterangan   = $request->keterangan;
        $data->status       = '0';
        $data->save();
        // dd($data);
        return redirect()->route('device.index')->with('alert', 'Data Sukses Disimpan');
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
        $data = Device::with('petani')->findOrFail($id);
        $petani = Petani::all();
        return view('admin.device.tambah_edit', ['update'=>'1', 'data'=>$data, 'petani'=>$petani]);
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
        $data = Device::findOrFail($id);
        $data->id_channel   = $request->id_channel;
        $data->api_key      = $request->api_key;
        $data->id_petani    = $request->petani_id;
        $data->tahun        = $request->tahun;
        $data->keterangan   = $request->keterangan;
        $data->save();
        return redirect()->route('device.index')->with('alert', 'Data Sukses Diedit');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $data = Device::findOrFail($id);
        $data->delete();
        return back()->with('alert', 'Data Sukses Dihapus');
        // if ($data) {
        //     return back()->with('alert', 'Data Sukses Dihapus');
        // }
        // else{
        //     $id_channel = Device::where('id_device', '=', $id)->first();
        //     $data2 = StatusTanaman::where('id_channel', '=', $id_channel)->get();
        //     $data2->delete();
        // }
        
    }
}
