<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;

use Illuminate\Http\Request;
use App\Tanaman;
use App\Device;
use App\Petani;
use App\JenisTanaman;
use App\StatusNotif;
use App\StatusTanaman;

use Carbon\Carbon;

class TanamanController extends Controller
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


        $data = Tanaman::with('petani', 'device', 'jenisTanaman')->get();
        foreach ($data as $key) {
            $tanam = date("Y-m-d", strtotime($key['tgl_tanam']));
            $datetime1 = new Carbon($tanam);
            $datetime2 = now();
            $interval = date_diff($datetime1, $datetime2);
            $interval = $datetime1->diff($datetime2);
            $now_usia = $interval->format('%a');
         
            
        }
        $id_channel = $key['id_channel']; 
        $status = StatusTanaman::where('id_channel', '=', $id_channel)->get();

        $cek = StatusTanaman::all();
        foreach ($cek as $key) {
            $sw = $key['created_at'];
             
        }
        // dd($status);
        // dd($id_channel);
        // if (empty($now_hours)) {
        //     return view('admin.tanaman.index', ['data'=>$data]); 
        // }
        // else if ($now_hours > 0) {
        //     return view('admin.tanaman.index', ['data'=>$data, 'now_usia'=>$now_usia]);
        // } 
        return view('admin.tanaman.index', ['data'=>$data, 'now_usia'=>$now_usia, 'status'=>$status]);
    }
       
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        $petani = Petani::all();
        $tanaman = JenisTanaman::all();
        

        // $device = Device::all();
        // $device = Device::where('status', '=', 0)->where('id_petani', '=', $id_petani)->get();
        return view('admin.tanaman.tambah_edit',  ['petani'=>$petani, 'tanaman'=>$tanaman]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->validate($request, [
            // 'nama_tanaman' => 'required|min:5',
            // 'tgl_tanam' => 'required|min:10',
            // 'usia_tanaman' => 'required|min:1',
            // 'keterangan' => 'required|min:10',
        ]);

        // foto_tanaman
        $file = $request->foto_tanaman;
        $ext = $file->getClientOriginalExtension();
        $newName = rand(100000,1001238912).".".$ext;
        $file->move('images/',$newName);

        // dapetin id_channel dari request id device
        $query = Device::where('id_device', '=', $request->id_device)->first();
        $id_channel = $query['id_channel'];

        $data = new Tanaman();
        $data->id_petani        = $request->id_petani;
        $data->id_jenis_tanaman = $request->id_jenis_tanaman;
        $data->id_device        = $request->id_device;
        $data->id_channel       = $id_channel;
        $data->tgl_tanam        = $request->tgl_pas_tanam;
        $data->lokasi           = $request->lokasi;
        $data->foto_tanaman     = $newName;
        if ($data) {
            $data->save(); 
            $update = Device::where('id_device', '=', $request->id_device)->update([
                    'status'    => 1
            ]);
            return redirect()->route('tanaman.index')->with('alert', 'Data Sukses Disimpan');       
        }
        
        // dd($data);
        

    }

    public function history($id)
    {
        $tanaman = Tanaman::where('id_channel', '=', $id)->with('jenisTanaman')->get();
        foreach ($tanaman as $jenis) {
            $id_jenis = $jenis['JenisTanaman']['id_jenis_tanaman'];
            $nama_jenis = $jenis['JenisTanaman']['nama_tanaman'];
            $min_light = $jenis['JenisTanaman']['min_cahaya'];
            $max_light = $jenis['JenisTanaman']['max_cahaya'];
            $min_temperature = $jenis['JenisTanaman']['min_suhu'];
            $max_temperature = $jenis['JenisTanaman']['max_suhu'];
            $min_humadity = $jenis['JenisTanaman']['min_kelembaban'];
            $max_humadity = $jenis['JenisTanaman']['max_kelembaban'];
            $min_moisture = $jenis['JenisTanaman']['min_tanah'];
            $max_moisture = $jenis['JenisTanaman']['max_tanah'];
            $min_ph = $jenis['JenisTanaman']['min_nutrisi'];
            $max_ph = $jenis['JenisTanaman']['max_nutrisi'];
            // $min_rssi = $jenis['JenisTanaman']['max_rssi'];
            // $max_rssi = $jenis['JenisTanaman']['max_rssi'];
        }

        $data = StatusNotif::where('id_channel', '=', $id)->with('tanaman')->get();
      

        // dd(['data'=>$data,
        //     'id_jenis'=>$id_jenis, 'nama_jenis'=>$nama_jenis, 
        //     'min_light'=>$min_light, 'max_light'=>$max_light,
        //     'min_temperature'=>$min_temperature, 'max_temperature'=>$max_temperature,
        //     'min_humadity'=>$min_humadity, 'max_humadity'=>$max_humadity,
        //     'min_moisture'=>$min_moisture, 'max_moisture'=>$max_moisture,
        //     'min_ph'=>$min_ph, 'max_ph'=>$max_ph]);
        return view('admin.tanaman.history', ['data'=>$data, 
            'id_jenis'=>$id_jenis, 'nama_jenis'=>$nama_jenis, 
            'min_light'=>$min_light, 'max_light'=>$max_light,
            'min_temperature'=>$min_temperature, 'max_temperature'=>$max_temperature,
            'min_humadity'=>$min_humadity, 'max_humadity'=>$max_humadity,
            'min_moisture'=>$min_moisture, 'max_moisture'=>$max_moisture,
            'min_ph'=>$min_ph, 'max_ph'=>$max_ph]);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $data = Tanaman::with('petani', 'jenisTanaman', 'device', 'statusNotifWeb')->findOrFail($id);
        $t = Tanaman::where('id_tanaman', '=', $id)->first();
        $j = $t['id_jenis_tanaman'];
        $id_channel = $t['id_channel'];
        $tanam = date("Y-m-d", strtotime($data['tgl_tanam']));
        $datetime1 = new Carbon($tanam);
        $datetime2 = now();
        // menampilkan harinya min jika tgl tanamnya lebih dari tgl sekarang
            if ($datetime1 > $datetime2) {
                $interval = date_diff($datetime1, $datetime2);
                $now_usia = $interval->format('-'.'%a') - 1;
            }
            else if ($datetime1 < $datetime2) {
                $interval = date_diff($datetime1, $datetime2);
                $now_usia = $interval->format('%a');
            }

            // $now_hours = date("Y-m-d H:i:s");
            // if ($now_hours <= date("Y-m-d 06:10:00") ) {
            //     $now_hours = 'Istirahat';
            // }
            // else if ($now_hours <= date("Y-m-d 10:00:00") ) {
            //     $now_hours = 'Pagi';
            // }
            // else if ($now_hours <= date("Y-m-d 14:40:00")) {
            //     $now_hours = 'Siang';
            // }
            // else if ($now_hours <= date("Y-m-d 18:00:00")) {
            //     $now_hours = 'Sore';
            // }
            // else{
            //     $now_hours = 'Malam';
            // }

        $tanaman = Tanaman::where('id_channel', '=', $id_channel)->with('jenisTanaman')->get();
        foreach ($tanaman as $jenis) {
            $id_jenis = $jenis['JenisTanaman']['id_jenis_tanaman'];
            $nama_jenis = $jenis['JenisTanaman']['nama_tanaman'];
            $min_light = $jenis['JenisTanaman']['min_cahaya'];
            $max_light = $jenis['JenisTanaman']['max_cahaya'];
            $min_temperature = $jenis['JenisTanaman']['min_suhu'];
            $max_temperature = $jenis['JenisTanaman']['max_suhu'];
            $min_humadity = $jenis['JenisTanaman']['min_kelembaban'];
            $max_humadity = $jenis['JenisTanaman']['max_kelembaban'];
            $min_moisture = $jenis['JenisTanaman']['min_tanah'];
            $max_moisture = $jenis['JenisTanaman']['max_tanah'];
            $min_ph = $jenis['JenisTanaman']['min_nutrisi'];
            $max_ph = $jenis['JenisTanaman']['max_nutrisi'];
            // $min_rssi = $jenis['JenisTanaman']['max_rssi'];
            // $max_rssi = $jenis['JenisTanaman']['max_rssi'];
        }
       
        return view('admin.tanaman.show', ['data'=>$data, 'now_usia'=>$now_usia, 'j'=>$j,
            'id_jenis'=>$id_jenis, 'nama_jenis'=>$nama_jenis, 
            'min_light'=>$min_light, 'max_light'=>$max_light,
            'min_temperature'=>$min_temperature, 'max_temperature'=>$max_temperature,
            'min_humadity'=>$min_humadity, 'max_humadity'=>$max_humadity,
            'min_moisture'=>$min_moisture, 'max_moisture'=>$max_moisture,
            'min_ph'=>$min_ph, 'max_ph'=>$max_ph]);


    }

    public function detailStatus($id)
    {
        $data = StatusNotif::where('id_channel', '=', $id)->with('device', 'tanaman.jenisTanaman', 'temperature', 'humadity', 'moisture', 'light', 'level_water', 'ph', 'rssi')->orderBy('id_status_notif', 'DESC')->first();
       // return view('admin.tanaman.index', ['data'=>$data, 'now_usia'=>$now_usia]);
        // dd($data);
        return $data;
    }
    
    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {

        // $data = Tanaman::findOrFail($id);
        // return view('admin.tanaman.tambah_edit', ['update'=>'1', 'data'=>$data]);
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
        // $data = Tanaman::findOrFail($id);
        // $data->nama_tanaman   = $request->nama_tanaman;
        // $data->usia_tanaman        = $request->usia_tanaman;
        // $data->keterangan   = $request->keterangan;
        // $data->save();
        // return redirect()->route('tanaman.index')->with('alert', 'Data Sukses Diedit');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $data = Tanaman::findOrFail($id);
        $id_channel = $data['id_channel'];
        $data->delete();
        return back()->with('alert', 'Data Sukses Dihapus');
        // dd($id_channel);
        // if ($data) {
        //     $data2 = StatusTanaman::where('id_channel', '=', $id_channel)->delete();
        //     $data3 = StatusNotif::where('id_channel', '=', $id_channel)->delete();
        //     if ($data2 && $data3) {
        //         $data->delete();
        //         return back()->with('alert', 'Data Sukses Dihapus');
        //     }
        // }
        
    }

    public function umurTanaman()
    {

        // $data = Tanaman::select('tgl_tanam')->where('id_tanaman', '=', '19')->first();
        $data = Tanaman::select('tgl_tanam')->first();
        // $timestamp = strtotime('$data');
        // $day = date('D', $timestamp);
        // var_dump($day); 
        // dd($data['tgl_tanam']);   

        // $day = date("d-m-Y", strtotime($data));
        $day = date("d", strtotime($data['tgl_tanam']));

        $now = now();
        $sekarang = date("d", strtotime($now));

        $w = $sekarang - $day;



       
            $tanam = date("Y-m-d", strtotime($data['tgl_tanam']));
            $datetime1 = new Carbon($tanam);
            // tgl sekarang
            $datetime2 = now();
            $interval = date_diff($datetime1, $datetime2);
            $interval = $datetime1->diff($datetime2);
            $hasil = $interval->format('%a');
        


        // return response()->json([
        //     'msg'     => 'success',
        //     'data'    => $day,
        //     'status'  => 200
        // ]);
        // return $hasil;

            dd($hasil);


            // $date1 = new Carbon('2018-6-10');
            // $date2 = new Carbon();
            // $diff = $date1->diffForHumans($date2);
            // print 'Date1 is ' + $diff . ' away from Date2';
    }
}
