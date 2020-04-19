<?php

namespace App\Http\Controllers;

use Validator;
use Carbon\Carbon;
use DB;
use GuzzleHttp\Exception\GuzzleException;
use GuzzleHttp\Client;
use Illuminate\Http\Request;
use App\Petani;
use App\Device;
use App\User;
use App\Administratior;
use App\Tanaman;
use App\JenisTanaman;
use App\PerawatanTanaman;
use App\Notification;
use App\StatusNotif;
use App\StatusTanaman;
use App\Test;

class ApiController extends Controller
{
    //get tanaman
    public function getTanaman()
    {
    	$data = Tanaman::all();
    	return response()->json([
			'msg'  	  => 'success',
			'data' 	  => $data,
			'status'  => 200
		]); 
    }


    // get master tanaman
    public function getTentangTanaman()
    {
    	$data = JenisTanaman::all();
    	return response()->json([
			'msg'  	  => 'success',
			'data' 	  => $data,
			'status'  => 200
		]); 
    }

    public function getPetaniWeb(Request $request)
    {
        $id_petani = $request->id_petani;
        $device = Device::where('status', '=', 0)->where('id_petani', '=', $id_petani)->get();

        return response()->json([
			'msg'  	  => 'success',
			'data' 	  => $device,
			'status'  => 200
		]);
    }


    // get master notifikasi
    public function getNotif()
    {
    	$data = Notification::all();

    	// $data =Tanaman::where('id_petani', '=', $id)->with('statusNotif.notification')->get();

    	return response()->json([
			'msg'  	  => 'success',
			'data' 	  => $data,
			'status'  => 200
		]); 
    }

    public function getHistoryWithId($id){
    	$qry = Tanaman::where('id_petani', '=', $id)->with('jenisTanaman')->get();

    	foreach ($qry as $key => $value) {
    	 	$id_channel = $value['id_channel'];
    		$notif = StatusNotif::where('id_channel', '=', $id_channel)->with('temperature', 'humadity', 'moisture', 'light', 'level_water', 'ph')->get();
    	 	$qry[$key]['notif'] = $notif;
    	}
    	return response()->json([
			'msg'  	  => 'success',
			'data' 	  => $qry,
			'status'  => 200
		]); 
    }

	public function getNotifWithId($id)
    {
    	$qry = Tanaman::where('id_petani', '=', $id)->with('jenisTanaman')->get();

    	foreach ($qry as $key => $value) {
    	 	$id_channel = $value['id_channel'];
    		$notif = StatusNotif::where('id_channel', '=', $id_channel)->with('temperature', 'humadity', 'moisture', 'light', 'level_water', 'ph')->orderBy('id_status_notif', 'DESC')->first();
    	 	$qry[$key]['notif'] = $notif;
    	}

    	return response()->json([
			'msg'  	  => 'success',
			'data' 	  => $qry,
			'status'  => 200
		]); 
    }


   // perawatan atau penjadwalan
    public function getPerawatan($id)
    {
    	// $data =Tanaman::where('id_petani', '=', $id)->with('JenisTanaman.perawatanTanaman')->get();
    	// $data = PerawatanTanaman::with('JenisTanaman.Tanaman')->get();
    	// $data2 = [];
    	// $data = json_decode($data, true);
    	// foreach ($data as $key => $value) {
	    // 	$tanam = date("Y-m-d", strtotime($value['tgl_tanam']));
	    //     $datetime1 = new Carbon($tanam);
	    //     $datetime2 = now();
	    //     $interval = date_diff($datetime1, $datetime2);
	    //     $interval = $datetime1->diff($datetime2);
	    //     $now_usia = $interval->format('%a');
    	// 	$data[$key]['usia'] = $now_usia;
    		
    	// }
    	$data = DB::select("SELECT * FROM tb_perawatan_tanaman p INNER JOIN tb_jenis_tanaman j ON p.id_jenis_tanaman = j.id_jenis_tanaman INNER JOIN tb_tanaman t ON j.id_jenis_tanaman = t.id_jenis_tanaman WHERE t.id_petani='$id'");

    	return response()->json([
			'msg'  	  => 'success',
			'data' 	  => $data,
			'status'  => 200
		]);
    }


    // get semua tanaman dengan id petani
    public function getKebunkuWithId($id)
    {
    	$qry =Tanaman::where('id_petani', '=', $id)->with('device', 'jenisTanaman', 'statusTanamanOne')->get();
        // $qry =Tanaman::where('id_petani', '=', $id)->with('device', 'jenisTanaman', 'statusTanamanOne')->orderBy('DESC')->limit(1)->get();
    	$data2 = [];
    	$data = json_decode($qry, true);
    	foreach ($data as $key => $value) {
	    	$tanam = date("Y-m-d", strtotime($value['tgl_tanam']));
	        $datetime1 = new Carbon($tanam);
	        $datetime2 = now();
	        $interval = date_diff($datetime1, $datetime2);
	        $interval = $datetime1->diff($datetime2);
	        $now_usia = $interval->format('%a');
    		$data[$key]['usia'] = $now_usia;
    		
    	}

        // dd($data);


    	return response()->json([
			'msg'  	  => 'success',
			'data' 	  => $data,
			'status'  => 200
		]);
    }

    public function getChart($id)
    {
    	$qry =Tanaman::where('id_tanaman', '=', $id)->with('statusTanaman')->limit(21)->get();
    	$data2 = [];
    	$data = json_decode($qry, true);
    	foreach ($data as $key => $value) {
	    	$tanam = date("Y-m-d", strtotime($value['tgl_tanam']));
	        $datetime1 = new Carbon($tanam);
	        $datetime2 = now();
	        $interval = date_diff($datetime1, $datetime2);
	        $interval = $datetime1->diff($datetime2);
	        $now_usia = $interval->format('%a');
    		$data[$key]['usia'] = $now_usia;
    		
    	}
        // dd($data);
    	return response()->json([
			'msg'  	  => 'success',
			'data' 	  => $data,
			'status'  => 200
		]);
    }

   
    // get kebunku
    public function getKebunku($id)
    {
    	$data = Tanaman::all();
    	// $data = Lahan::where('id_petani', '=', $id)->with('device', 'tanaman.jenisTanaman', 'statusLahan')->get();
    	return response()->json([
			'msg'  	  => 'success',
			'data' 	  => $data,
			'status'  => 200
		]); 
    }

    // get profile
    public function getProfile($id)
    {
    	// $data = Lahan::all();
    	$data = User::where('id_user', '=', $id)->with('petani')->get();
    	return response()->json([
			'msg'  	  => 'success',
			'data' 	  => $data,
			'status'  => 200
		]); 
    }
	
    // ini proses tambah tanaman 

    // get data device
    public function getDevice($id)
    {
    	$data = Device::where('status', '=', 0)->where('id_petani', '=', $id)->get();
    	return response()->json([
			'msg'  	  => 'success',
			'data' 	  => $data,
			'status'  => 200
		]); 
    }

    // get master tanaman
    public function getJenisTanaman()
    {
    	$data = jenisTanaman::all();
    	return response()->json([
			'msg'  	  => 'success',
			'data' 	  => $data,
			'status'  => 200
		]); 
    }

	// post tanaman
	public function postTanaman(Request $request)
	{

		$validator = Validator::make($request->all(), [
            'tgl_tanam'  => 'required',
            'lokasi'  => 'required',
            'id_device' => 'required',
				
		]);


		if($validator->fails()){
			return response()->json([
				'msg'  => 'failed create user',
				'error' => $validator->errors(),
				'status' => 401
			]);
		}
		
		// ambil id_channel
		$qry = Device::where('id_device', '=', $request->id_device)->first();
		$id_channel = $qry['id_channel'];

		$photo = $request->foto_tanaman;
		$savename = time().'.jpg';
		file_put_contents("images/".$savename, base64_decode($photo));
		$create = Tanaman::create([
			'tgl_tanam'   		=> $request->tgl_tanam,
			'lokasi'     		=> $request->lokasi,
			'id_petani'   		=> $request->id_petani,
			'id_jenis_tanaman'  => $request->id_jenis_tanaman,
			'id_device' 		=> $request->id_device,
			'id_channel' 		=> $id_channel,
			'foto_tanaman' 		=> $savename
		]);
		if($create){
			$update = Device::where('id_device', '=', $request->id_device)->update([
					'status'  	=> 1
			]);
		}
		return response()->json([
			'msg'  	  => 'success',
			'data' 	  => $create,
			'status'  => 200
		]); 

	}


    // register
 	public function postRegister(Request $request)
	{

		$validator = Validator::make($request->all(), [
            // 'nama'  => 'required',
			'email'  		=> 'required|string|email|max:255|unique:tb_users',
			'password'  	=> 'required',
            // 'id_user' 		=> 'required',
			'nama_petani' 	=> 'required',
			'alamat' 		=> 'required',
			'no_hp'			=> 'required'		
		]);


		if($validator->fails()){
			return response()->json([
				'msg'  => 'failed create user',
				'error' => $validator->errors(),
				'status' => 401
			]);
		}

		$create = User::create([
			'email'     => $request->email,
			'password'  => encrypt($request->password),
			'level'  	=> 0

		]);
		if($create){

			$photo = $request->foto_petani;
			$savename = time().'.jpg';
			file_put_contents("images/petani/".$savename, base64_decode($photo));

			$create2 = Petani::create([
				'id_user' 		=> $create->id_user, 
				'nama_petani'	=> $request->nama_petani,
				'alamat'		=> $request->alamat,
				'no_hp'			=> $request->no_hp,
				'foto_petani'   => $savename
			
			]);
			if($create2){
				return response()->json([
					'msg'  	  => 'user created',
					'user' 	  => $create,
					'datauser'=>$create2,
					'status'  => 200
				]);
			}
		}

		return response()->json([
			'msg'  => 'failed',
			'error' => 'something error',
			'status' => 400
		]);

	}


	// edit petani
	public function editAkun(Request $request, $id)
	{

		$validator = Validator::make($request->all(), [
            // 'nama'  => 'required',
			// 'email'  		=> 'required|string|email|max:255|unique:tb_users',
			// 'email'  		=> 'required|string|email|max:255',
			'password'  		=> 'required',
			'new_password'  	=> 'required',
            

			
		]);


		if($validator->fails()){
			return response()->json([
				'msg'  	 => 'failed create user',
				'error'  => $validator->errors(),
				'status' => 401
			]);
		}

		if($data = User::select('password')->where('id_user', '=', $id)->where('level', '=', '0')->first()){
			if(decrypt($data->password)==$request->password){
				$update = User::where('id_user', '=', $id)->update([
					// 'email'     => $request->email,
					'password'  => encrypt($request->new_password),
					'level'  	=> 0

				]);
			}
			else{
				return response()->json([
					'msg'  => 'failed update',
					'error' => 'wrong old password',
					'status' => 401
				]);
			}
		}
		 if($update){
            return response()->json([
                'msg'  => 'data updated',
                'data' => '',
                'status' => 200
            ]);
        }

		return response()->json([
			'msg'  => 'failed',
			'error' => 'something error',
			'status' => 400
		]);
	}

	// login
	public function postLogin(Request $request)
	{

		$validator = Validator::make($request->all(), [
			'email'  => 'required',
			'password'  => 'required',
		]);


		if($validator->fails()){
			return response()->json([
				'msg'  => 'failed login',
				'error' => $validator->errors(),
				'status' => 400,
			]);
		}

        // dd(encrypt($request->password));

		if($data = User::with('petani')->where('email', '=', $request->email)->where('level', '=', '0')->first()){
			if(decrypt($data->password)==$request->password){
				return response()->json([
					'msg'  => 'success login as owner',
					'user' => $data,
					'status' => 200,
				]);
			}
		}
		return response()->json([
			'msg'  => 'failed login',
			'error' => 'email or password invalid',
			'status' => 400,
		]);

	}


    public function getFromStation($id){
        // proses pengambilan api_key dari tb_device
        $device = Device::where('id_channel', '=', $id)->first();
        $api_key = $device['api_key'];

        // untuk insert ke thingspeak
        // https://api.thingspeak.com/update?api_key=M53BFTR3OYLU20CS&field1=0&field2=0&field3=0&field4=0&field6=0&field7=0

        // id yg di pake
        // 574588
        
        $client = new Client(); //GuzzleHttp\Client
        $result = $client->get('https://thingspeak.com/channels/'.$id.'/feed.json');
        // $result = $client->get('https://thingspeak.com/channels/'.$id.'/feed.json?api_key='.$api_key.'');

        $json = (string) $result->getBody();

        $p = json_decode($json, true);

        $id_channel= $p['channel']['id'];
        $last_entry= $p['channel']['last_entry_id'];
        foreach ($p['feeds'] as $value) {

                //keterangan
    			//temperature = field1 = suhu 
				//humadity = field2 = kelembaban
				//light = field4 = cahaya
				//level_water = field5 = tangki_air
				//ph = field6 = field6 = air_tanah
				//rssi = field7
				//moisture = field3 = nutrisi

	        StatusTanaman::create([
                // 'id_device'  => '24',
                'id_channel' => $id_channel,
                'cahaya'     => $value['field4'],
                'kelembaban' => $value['field2'],
                'tangki_air' => $value['field5'],
                'suhu' 		 => $value['field1'],
                'nutrisi'	 => $value['field6'],
                // 'entry_id'	 => $value['entry_id'],
                'air_tanah'	 => $value['field3'],
                'rssi'		 => $value['field7'],
                'entry_id'	 => $last_entry,
			]);
        }

        return response()->json([
			'msg'  	  => 'success',
			'data' 	  => $value,
			'status'  => 200
		]); 
		//dd($temperatur);

        //echo $result->getBody();
    }

    public function revisi($id){
    	$channel = StatusTanaman::where('id_channel', '=', $id)->select('id_channel')->with('device')->first();
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
    	// dd($min_light);
    	
    	$dari = date("2018-09-02 14:00:00");
    	$sampai = date("2018-09-02 18:00:00");
    	$cahaya = StatusTanaman::where('id_channel', '=', $id)
    	->where('created_at', '>=', $dari)
    	->where('created_at', '<=', $sampai)
    	->max('cahaya');
     	// dd($cahaya);

     	// $now_hours = date("Y-m-d 13:10:00");
     	$now_hours = date("Y-m-d H:i:s");
     	if ($now_hours <= date("Y-m-d 06:10:00")) {
    		$now_hours = 'pagi bgt';
    		$cahaya = 'tanaman istirahat';
    		$value_cahaya = 'kosong';

    		$ph = 'tanaman istirahat';
    		$value_ph = 'kosong';

    		$humadity = 'tanaman istirahat';
    		$value_humadity = 'kosong';

    		$temperature = 'tanaman istirahat';
    		$value_temperature = 'kosong';

    		$moisture = 'tanaman istirahat';
    		$value_moisture = 'kosong';

    		$level_water = 'tanaman istirahat';
    		$value_level_water = 'kosong';

    		$rssi = 'tanaman istirahat';
    		$value_rssi = 'kosong';
    	}
    	else if ($now_hours <= date("Y-m-d 11:00:00")) {
    		$now_hours = 'pagi';
    		$dari = date("Y-m-d 06:00:00");
    		$sampai = date("Y-m-d 11:00:00");
    		// $dari = date("2018-09-02 06:00:00");
    		// $sampai = date("2018-09-02 11:00:00");
    		// cahaya
    		$cahaya = StatusTanaman::where('id_channel', '=', $id)
	    	->where('created_at', '>=', $dari)
	    	->where('created_at', '<=', $sampai)
	    	->max('cahaya');
        	$value_cahaya = $cahaya;
    		// dd($cahaya);
    		if (empty($cahaya)) {
    			$cahaya = 22;
    		}
    		else if ($cahaya > $max_light) {
    			// $cahaya = 'cahaya pagi berlebih men';
    			$cahaya = 12;
    		}
        	else if($cahaya <= $max_light && $cahaya >= $min_light) {
				// $cahaya = 'cahaya pagi aman men';
				$cahaya = 11;
			}
			else if ($cahaya < $min_light) {
				// $cahaya = 'cahaya pagi kurang men';
				$cahaya = 10;
			}

			// ph
			$ph = StatusTanaman::where('id_channel', '=', $id)
	    	->where('created_at', '>=', $dari)
	    	->where('created_at', '<=', $sampai)
	    	->max('nutrisi');
        	$value_ph = $ph;
    		// dd($cahaya);
    		if (empty($ph)) {
    			$ph = 22;
    		}
    		else if ($ph > $max_ph) {
    			// $cahaya = 'cahaya pagi berlebih men';
    			$ph = 18;
    		}
        	else if($ph <= $max_ph && $ph >= $min_ph) {
				// $cahaya = 'cahaya pagi aman men';
				$ph = 17;
			}
			else if ($ph < $min_ph) {
				// $cahaya = 'cahaya pagi kurang men';
				$ph = 16;
			}

			// humadity
			$humadity = StatusTanaman::where('id_channel', '=', $id)
	    	->where('created_at', '>=', $dari)
	    	->where('created_at', '<=', $sampai)
	    	->max('kelembaban');
        	$value_humadity = $humadity;
    		// dd($cahaya);
    		if (empty($humadity)) {
    			$humadity = 22;
    		}
    		else if ($humadity > $max_humadity) {
    			// $cahaya = 'cahaya pagi berlebih men';
    			$humadity = 6;
    		}
        	else if($humadity <= $max_humadity && $humadity >= $min_humadity) {
				// $cahaya = 'cahaya pagi aman men';
				$humadity = 5;
			}
			else if ($humadity < $min_humadity) {
				// $cahaya = 'cahaya pagi kurang men';
				$humadity = 4;
			}

			// temperature
			$temperature = StatusTanaman::where('id_channel', '=', $id)
	    	->where('created_at', '>=', $dari)
	    	->where('created_at', '<=', $sampai)
	    	->max('suhu');
        	$value_temperature = $temperature;
    		// dd($cahaya);
    		if (empty($temperature)) {
    			$temperature = 22;
    		}
    		else if ($temperature > $max_temperature) {
    			// $cahaya = 'cahaya pagi berlebih men';
    			$temperature = 3;
    		}
        	else if($temperature <= $max_temperature && $temperature >= $min_temperature) {
				// $cahaya = 'cahaya pagi aman men';
				$temperature = 2;
			}
			else if ($temperature < $min_temperature) {
				// $cahaya = 'cahaya pagi kurang men';
				$temperature = 1;
			}

			// moisture
			$moisture = StatusTanaman::where('id_channel', '=', $id)
	    	->where('created_at', '>=', $dari)
	    	->where('created_at', '<=', $sampai)
	    	->max('air_tanah');
        	$value_moisture = $moisture;
    		// dd($cahaya);
    		if (empty($moisture)) {
    			$moisture = 22;
    		}
    		else if ($moisture > $max_moisture) {
    			// $cahaya = 'cahaya pagi berlebih men';
    			$moisture = 9;
    		}
        	else if($moisture <= $max_moisture && $moisture >= $min_moisture) {
				// $cahaya = 'cahaya pagi aman men';
				$moisture = 8;
			}
			else if ($moisture < $min_moisture) {
				// $cahaya = 'cahaya pagi kurang men';
				$moisture = 7;
			}

			// level water
			$level_water = StatusTanaman::where('id_channel', '=', $id)
	    	->where('created_at', '>=', $dari)
	    	->where('created_at', '<=', $sampai)
	    	->max('tangki_air');
        	$value_level_water = $level_water;
			if (empty($level_water)) {
				$level_water = 22;
			}
			else if ($level_water == 3) {
    			// $level_water = 'level_water pagi penuh men';
    			$level_water = 15;
    		}
        	else if($level_water == 2) {
				// $level_water = 'level_water pagi sedang men';
				$level_water = 14;
			}
			else if($level_water == 1) {
				// $level_water = 'level_water pagi kurang men';
				$level_water = 13;
			}
			else {
				// $level_water = 'data kosong';
				$level_water = 22;
			}
		}
		else if ($now_hours <= date("Y-m-d 14:00:00")) {
			$now_hours = 'siang';
			$dari = date("Y-m-d 11:00:00");
    		$sampai = date("Y-m-d 14:00:00");
			// $dari = date("2018-09-02 11:00:00");
   //  		$sampai = date("2018-09-02 14:00:00");
    		// cahaya
    		$cahaya = StatusTanaman::where('id_channel', '=', $id)
	    	->where('created_at', '>=', $dari)
	    	->where('created_at', '<=', $sampai)
	    	->max('cahaya');
        	$value_cahaya = $cahaya;
    		// dd($cahaya);
    		if (empty($cahaya)) {
    			$cahaya = 22;
    		}
    		else if ($cahaya > $max_light) {
    			// $cahaya = 'cahaya pagi berlebih men';
    			$cahaya = 12;
    		}
        	else if($cahaya <= $max_light && $cahaya >= $min_light) {
				// $cahaya = 'cahaya pagi aman men';
				$cahaya = 11;
			}
			else if ($cahaya < $min_light) {
				// $cahaya = 'cahaya pagi kurang men';
				$cahaya = 10;
			}

			// ph
			$ph = StatusTanaman::where('id_channel', '=', $id)
	    	->where('created_at', '>=', $dari)
	    	->where('created_at', '<=', $sampai)
	    	->max('nutrisi');
        	$value_ph = $ph;
    		// dd($cahaya);
    		if (empty($ph)) {
    			$ph = 22;
    		}
    		else if ($ph > $max_ph) {
    			// $cahaya = 'cahaya pagi berlebih men';
    			$ph = 18;
    		}
        	else if($ph <= $max_ph && $ph >= $min_ph) {
				// $cahaya = 'cahaya pagi aman men';
				$ph = 17;
			}
			else if ($ph < $min_ph) {
				// $cahaya = 'cahaya pagi kurang men';
				$ph = 16;
			}

			// humadity
			$humadity = StatusTanaman::where('id_channel', '=', $id)
	    	->where('created_at', '>=', $dari)
	    	->where('created_at', '<=', $sampai)
	    	->max('kelembaban');
        	$value_humadity = $humadity;
    		// dd($cahaya);
    		if (empty($humadity)) {
    			$humadity = 22;
    		}
    		else if ($humadity > $max_humadity) {
    			// $cahaya = 'cahaya pagi berlebih men';
    			$humadity = 6;
    		}
        	else if($humadity <= $max_humadity && $humadity >= $min_humadity) {
				// $cahaya = 'cahaya pagi aman men';
				$humadity = 5;
			}
			else if ($humadity < $min_humadity) {
				// $cahaya = 'cahaya pagi kurang men';
				$humadity = 4;
			}

			// temperature
			$temperature = StatusTanaman::where('id_channel', '=', $id)
	    	->where('created_at', '>=', $dari)
	    	->where('created_at', '<=', $sampai)
	    	->max('suhu');
        	$value_temperature = $temperature;
    		// dd($cahaya);
    		if (empty($temperature)) {
    			$temperature = 22;
    		}
    		else if ($temperature > $max_temperature) {
    			// $cahaya = 'cahaya pagi berlebih men';
    			$temperature = 3;
    		}
        	else if($temperature <= $max_temperature && $temperature >= $min_temperature) {
				// $cahaya = 'cahaya pagi aman men';
				$temperature = 2;
			}
			else if ($temperature < $min_temperature) {
				// $cahaya = 'cahaya pagi kurang men';
				$temperature = 1;
			}

			// moisture
			$moisture = StatusTanaman::where('id_channel', '=', $id)
	    	->where('created_at', '>=', $dari)
	    	->where('created_at', '<=', $sampai)
	    	->max('air_tanah');
        	$value_moisture = $moisture;
    		// dd($cahaya);
    		if (empty($moisture)) {
    			$moisture = 22;
    		}
    		else if ($moisture > $max_moisture) {
    			// $cahaya = 'cahaya pagi berlebih men';
    			$moisture = 9;
    		}
        	else if($moisture <= $max_moisture && $moisture >= $min_moisture) {
				// $cahaya = 'cahaya pagi aman men';
				$moisture = 8;
			}
			else if ($moisture < $min_moisture) {
				// $cahaya = 'cahaya pagi kurang men';
				$moisture = 7;
			}

			// level water
			$level_water = StatusTanaman::where('id_channel', '=', $id)
	    	->where('created_at', '>=', $dari)
	    	->where('created_at', '<=', $sampai)
	    	->max('tangki_air');
        	$value_level_water = $level_water;
			if (empty($level_water)) {
				$level_water = 22;
			}
			else if ($level_water == 3) {
    			// $level_water = 'level_water pagi penuh men';
    			$level_water = 15;
    		}
        	else if($level_water == 2) {
				// $level_water = 'level_water pagi sedang men';
				$level_water = 14;
			}
			else if($level_water == 1) {
				// $level_water = 'level_water pagi kurang men';
				$level_water = 13;
			}
			else {
				// $level_water = 'data kosong';
				$level_water = 22;
			}
		}
		else if ($now_hours <= date("Y-m-d 18:00:00")) {
			$now_hours = 'sore';
			$dari = date("Y-m-d 14:00:00");
    		$sampai = date("Y-m-d 18:00:00");
			// $dari = date("2018-09-02 14:00:00");
   //  		$sampai = date("2018-09-02 18:00:00");
    		// cahaya
    		$cahaya = StatusTanaman::where('id_channel', '=', $id)
	    	->where('created_at', '>=', $dari)
	    	->where('created_at', '<=', $sampai)
	    	->max('cahaya');
        	$value_cahaya = $cahaya;
    		// dd($cahaya);
    		if (empty($cahaya)) {
    			$cahaya = 22;
    		}
    		else if ($cahaya > $max_light) {
    			// $cahaya = 'cahaya pagi berlebih men';
    			$cahaya = 12;
    		}
        	else if($cahaya <= $max_light && $cahaya >= $min_light) {
				// $cahaya = 'cahaya pagi aman men';
				$cahaya = 11;
			}
			else if ($cahaya < $min_light) {
				// $cahaya = 'cahaya pagi kurang men';
				$cahaya = 10;
			}

			// ph
			$ph = StatusTanaman::where('id_channel', '=', $id)
	    	->where('created_at', '>=', $dari)
	    	->where('created_at', '<=', $sampai)
	    	->max('nutrisi');
        	$value_ph = $ph;
    		// dd($cahaya);
    		if (empty($ph)) {
    			$ph = 22;
    		}
    		else if ($ph > $max_ph) {
    			// $cahaya = 'cahaya pagi berlebih men';
    			$ph = 18;
    		}
        	else if($ph <= $max_ph && $ph >= $min_ph) {
				// $cahaya = 'cahaya pagi aman men';
				$ph = 17;
			}
			else if ($ph < $min_ph) {
				// $cahaya = 'cahaya pagi kurang men';
				$ph = 16;
			}

			// humadity
			$humadity = StatusTanaman::where('id_channel', '=', $id)
	    	->where('created_at', '>=', $dari)
	    	->where('created_at', '<=', $sampai)
	    	->max('kelembaban');
        	$value_humadity = $humadity;
    		// dd($cahaya);
    		if (empty($humadity)) {
    			$humadity = 22;
    		}
    		else if ($humadity > $max_humadity) {
    			// $cahaya = 'cahaya pagi berlebih men';
    			$humadity = 6;
    		}
        	else if($humadity <= $max_humadity && $humadity >= $min_humadity) {
				// $cahaya = 'cahaya pagi aman men';
				$humadity = 5;
			}
			else if ($humadity < $min_humadity) {
				// $cahaya = 'cahaya pagi kurang men';
				$humadity = 4;
			}

			// temperature
			$temperature = StatusTanaman::where('id_channel', '=', $id)
	    	->where('created_at', '>=', $dari)
	    	->where('created_at', '<=', $sampai)
	    	->max('suhu');
        	$value_temperature = $temperature;
    		// dd($cahaya);
    		if (empty($temperature)) {
    			$temperature = 22;
    		}
    		else if ($temperature > $max_temperature) {
    			// $cahaya = 'cahaya pagi berlebih men';
    			$temperature = 3;
    		}
        	else if($temperature <= $max_temperature && $temperature >= $min_temperature) {
				// $cahaya = 'cahaya pagi aman men';
				$temperature = 2;
			}
			else if ($temperature < $min_temperature) {
				// $cahaya = 'cahaya pagi kurang men';
				$temperature = 1;
			}

			// moisture
			$moisture = StatusTanaman::where('id_channel', '=', $id)
	    	->where('created_at', '>=', $dari)
	    	->where('created_at', '<=', $sampai)
	    	->max('air_tanah');
        	$value_moisture = $moisture;
    		// dd($cahaya);
    		if (empty($moisture)) {
    			$moisture = 22;
    		}
    		else if ($moisture > $max_moisture) {
    			// $cahaya = 'cahaya pagi berlebih men';
    			$moisture = 9;
    		}
        	else if($moisture <= $max_moisture && $moisture >= $min_moisture) {
				// $cahaya = 'cahaya pagi aman men';
				$moisture = 8;
			}
			else if ($moisture < $min_moisture) {
				// $cahaya = 'cahaya pagi kurang men';
				$moisture = 7;
			}

			// level water
			$level_water = StatusTanaman::where('id_channel', '=', $id)
	    	->where('created_at', '>=', $dari)
	    	->where('created_at', '<=', $sampai)
	    	->max('tangki_air');
        	$value_level_water = $level_water;
			if (empty($level_water)) {
				$level_water = 22;
			}
			else if ($level_water == 3) {
    			// $level_water = 'level_water pagi penuh men';
    			$level_water = 15;
    		}
        	else if($level_water == 2) {
				// $level_water = 'level_water pagi sedang men';
				$level_water = 14;
			}
			else if($level_water == 1) {
				// $level_water = 'level_water pagi kurang men';
				$level_water = 13;
			}
			else {
				// $level_water = 'data kosong';
				$level_water = 22;
			}
		}
		else if ($now_hours <= date("Y-m-d 24:00:00")) {
     		$now_hours = 'malam';
    		$cahaya = 'tanaman istirahat';
    		$value_cahaya = 'kosong';

    		$ph = 'tanaman istirahat';
    		$value_ph = 'kosong';

    		$humadity = 'tanaman istirahat';
    		$value_humadity = 'kosong';

    		$temperature = 'tanaman istirahat';
    		$value_temperature = 'kosong';

    		$moisture = 'tanaman istirahat';
    		$value_moisture = 'kosong';

    		$level_water = 'tanaman istirahat';
            $value_level_water = 'kosong';

    		$rssi = 'tanaman istirahat';
    		$value_rssi = 'kosong';
    	}	

  //   	$a = [$value_cahaya, $value_ph, $value_temperature, $value_humadity, $value_moisture, $value_level_water];
  //   	$b = [$cahaya, $ph, $temperature, $humadity, $moisture, $level_water];
		// dd(['waktu'=>$now_hours, 'isi'=>$a, 'status'=>$b]);

		// proses penambahan data ke status_notif	
	    if (date("Y-m-d H:i:s") > date("Y-m-d 06:00:00") && date("Y-m-d H:i:s") < date("Y-m-d 18:00:00")){
	  		$get_hari = Tanaman::where('id_channel', '=', $id)->first();		 
			$tanam = date("Y-m-d", strtotime($get_hari['tgl_tanam']));
		    $datetime1 = new Carbon($tanam);
		    // $datetime2 = now();
		    $datetime2 = new Carbon(date("Y-m-d H:i:s"));
		    // menampilkan harinya min jika tgl tanamnya lebih dari tgl sekarang
		    if ($datetime1 >= $datetime2) {
		    	$interval = date_diff($datetime1, $datetime2);
		    	$now_usia = $interval->format('-'.'%a');
		    }
		    else if ($datetime1 <= $datetime2) {
		    	$interval = date_diff($datetime1, $datetime2);
		    	$now_usia = $interval->format('%a');
		    }

		    // dd($now_usia);
	    		
	    		$create = StatusNotif::create([    	
					'id_channel'  	=> $id,
					'waktu'		  	=> $now_hours,
					'temperature' 	=> $temperature,
					'humadity'		=> $humadity,
					'moisture'		=> $moisture,
					'light'			=> $cahaya,
					'level_water'	=> $level_water,
					'ph'			=> $ph,
					// 'rssi'			=> $rssi,

					// hari ke
					'hari_ke'		=> $now_usia,
					// isi dari status_tanaman
					'value_temperature' 	=> $value_temperature,
					'value_humadity'		=> $value_humadity,
					'value_moisture'		=> $value_moisture,
					'value_light'			=> $value_cahaya,
					'value_level_water'	=> $value_level_water,
					'value_ph'			=> $value_ph,
					// 'value_rssi'			=> $value_rssi,
				]);
	    	}
	    else {
	    	$create = 'kosong';
	    }
    }

    public function teye($id){
    	//keterangan
		//temperature = field1 = suhu 
		//humadity = field2 = kelembaban
		//light = field4 = cahaya
		//level_water = field5 = tangki_air
		//ph = field6 = field6 = air_tanah
		//rssi = field7
		//moisture = field3 = nutrisi

    	// 10 adalah id jenis tanaman di tabel tb_jenis_tanaman yang menginisialkan tanaman bawang
    	$bawang = DB::table('tb_status_tanaman')
            ->join('tb_tanaman', 'tb_status_tanaman.id_channel', '=', 'tb_tanaman.id_channel')
            ->join('tb_jenis_tanaman', 'tb_tanaman.id_jenis_tanaman', '=', 'tb_jenis_tanaman.id_jenis_tanaman')
            ->where('tb_status_tanaman.id_channel', '=', $id)
            ->where('tb_tanaman.id_jenis_tanaman', '=', 10)
            ->select('tb_status_tanaman.id_channel', 'tb_tanaman.id_jenis_tanaman', 'tb_jenis_tanaman.nama_tanaman')
            ->first();

    	// 21 adalah id jenis tanaman di tabel tb_jenis_tanaman yang menginisialkan tanaman cabai   
        $cabai = DB::table('tb_status_tanaman')
            ->join('tb_tanaman', 'tb_status_tanaman.id_channel', '=', 'tb_tanaman.id_channel')
            ->join('tb_jenis_tanaman', 'tb_tanaman.id_jenis_tanaman', '=', 'tb_jenis_tanaman.id_jenis_tanaman')
            ->where('tb_status_tanaman.id_channel', '=', $id)
            ->where('tb_tanaman.id_jenis_tanaman', '=', 21)
            ->select('tb_status_tanaman.id_channel', 'tb_tanaman.id_jenis_tanaman', 'tb_jenis_tanaman.nama_tanaman')
            ->first();

    	$channel = StatusTanaman::where('id_channel', '=', $id)->select('id_channel')->with('device')->first();
    	$id_channel = $channel['id_channel'];
    	$now_hours = date("Y-m-d H:i:s");
    	// $now_hours = date("Y-m-d 16:00:00");
    	// $jenis_tanaman = StatusTanaman::where('id_channel', '=', $id, 'AND', 'id_jenis_tanaman', '=', '216')->with('tanaman')->first();

	    	if ($now_hours <= date("Y-m-d 06:10:00")) {
	    		$now_hours = 'terlalu pagi coy datanya engga ada, tanamannya masih kedinginan';
	    		$cahaya = 'tanaman istirahat';
	    		$value_cahaya = 'kosong';

	    		$ph = 'tanaman istirahat';
	    		$value_ph = 'kosong';

	    		$humadity = 'tanaman istirahat';
	    		$value_humadity = 'kosong';

	    		$temperature = 'tanaman istirahat';
	    		$value_temperature = 'kosong';

	    		$moisture = 'tanaman istirahat';
	    		$value_moisture = 'kosong';

	    		$level_water = 'tanaman istirahat';
	    		$value_level_water = 'kosong';

	    		$rssi = 'tanaman istirahat';
	    		$value_rssi = 'kosong';
	    	}

	    	// di sini kondisi jika tanaman cabai
	    	// 06 ~ 11
	    	else if ($now_hours <= date("Y-m-d 11:00:00") && !empty($cabai) ) {
	    		$now_hours = 'pagi';
	    		$dari = date("Y-m-d 06:00:00");
	    		$sampai = date("Y-m-d 10:30:00");

	    		// cahaya
	        	$cahaya = DB::table('tb_status_tanaman')->where('id_channel', '=', $id)->where('created_at', '>=', $dari)->where('created_at', '<=', $sampai)->max('cahaya'); 
	    		$value_cahaya = $cahaya;
	    		// dd($cahaya);
	    		if (empty($cahaya)) {
	    			$cahaya = 22;
	    		}
	    		else if ($cahaya > 75) {
	    			// $cahaya = 'cahaya pagi berlebih men';
	    			$cahaya = 12;
	    		}
	        	else if($cahaya <= 75 && $cahaya >= 0) {
					// $cahaya = 'cahaya pagi aman men';
					$cahaya = 11;
				}
				else if ($cahaya < 0) {
					// $cahaya = 'cahaya pagi kurang men';
					$cahaya = 10;
				}
				// else {
				// 	// $cahaya = 'data kosong'; 
				// 	$cahaya = 22;
				// }

				// ph = nutrisi
	        	$ph = DB::table('tb_status_tanaman')->where('id_channel', '=', $id)->where('created_at', '>=', $dari)->where('created_at', '<=', $sampai)->max('nutrisi'); 
				$value_ph = $ph;

				if (empty($ph)) {
					$ph = 22;
				}
				else if ($ph > 6.8) {
	    			// $ph = 'ph pagi berlebih men';
	    			$ph = 18;
	    		}
	        	else if($ph <= 6.8 && $ph >= 5.5) {
					// $ph = 'ph pagi aman men';
					$ph = 17;
				}
				else if($ph < 5.5) {
					// $ph = 'ph pagi kurang men';
					$ph = 16;
				}
				// else {
				// 	// $ph = 'data kosong';
				// 	$ph = 22;
				// }

				// moisture = air_tanah
				$moisture = DB::table('tb_status_tanaman')->where('id_channel', '=', $id)->where('created_at', '>=', $dari)->where('created_at', '<=', $sampai)->max('air_tanah'); 
				$value_moisture = $moisture;

				if (empty($moisture)) {
					$moisture = 22;
				}
				else if ($moisture > 80) {
	    			// $moisture = 'moisture pagi berlebih men';
	    			$moisture = 9;
	    		}
	        	else if($moisture <= 80 && $moisture >= 70) {
					// $moisture = 'moisture pagi aman men';
					$moisture = 8;
				}
				else if($moisture < 70) {
					// $moisture = 'moisture pagi kurang men';
					$moisture = 7;
				}
				// else {
				// 	// $moisture = 'data kosong';
				// 	$moisture = 22;
				// }

				// humadity = kelembaban
				$humadity = DB::table('tb_status_tanaman')->where('id_channel', '=', $id)->where('created_at', '>=', $dari)->where('created_at', '<=', $sampai)->max('kelembaban');
				$value_humadity = $humadity;

				if (empty($humadity)) {
					$humadity = 22;
				}
				else if($humadity > 70) {
	    			// $humadity = 'humadity pagi berlebih men';
	    			$humadity = 6;
	    		}
	        	else if($humadity <= 70 && $humadity >= 50) {
					// $humadity = 'humadity pagi aman men';
					$humadity = 5;
				}
				else if($humadity < 50) {
					// $humadity = 'humadity pagi kurang men';
					$humadity = 4;
				}
				// else {
				// 	// $humadity = 'data kosong';
				// 	$humadity = 22;
				// }

				// level_water = tangki_air
				$level_water = DB::table('tb_status_tanaman')->where('id_channel', '=', $id)->where('created_at', '>=', $dari)->where('created_at', '<=', $sampai)->max('tangki_air');
				$value_level_water = $level_water;

				if (empty($level_water)) {
					$level_water = 22;
				}
				else if ($level_water == 3) {
	    			// $level_water = 'level_water pagi penuh men';
	    			$level_water = 15;
	    		}
	        	else if($level_water == 2) {
					// $level_water = 'level_water pagi sedang men';
					$level_water = 14;
				}
				else if($level_water == 1) {
					// $level_water = 'level_water pagi kurang men';
					$level_water = 13;
				}
				else {
					// $level_water = 'data kosong';
					$level_water = 22;
				}	

				// temperature = suhu
				$temperature = DB::table('tb_status_tanaman')->where('id_channel', '=', $id)->where('created_at', '>=', $dari)->where('created_at', '<=', $sampai)->max('suhu');
				$value_temperature = $temperature;

				if (empty($temperature)) {
					$temperature = 22;
				}
				else if ($temperature > 27) {
	    			// $temperature = 'temperatur pagi berlebih men';
	    			$temperature = 3;
	    		}
	        	else if($temperature <= 27 && $temperature >= 25) {
					// $temperature = 'temperatur pagi aman men';
					$temperature = 2;
				}
				else if($temperature < 25) {
					// $temperature = 'temperatur pagi kurang men';
					$temperature = 1;
				}
				// else {
				// 	// $temperature = 'data kosong';
				// 	$temperature = 22;
				// }
				// rssi
				$rssi = DB::table('tb_status_tanaman')->where('id_channel', '=', $id)->where('created_at', '>=', $dari)->where('created_at', '<=', $sampai)->max('rssi');
				$value_rssi = $rssi;

				if (empty($rssi)) {
					$rssi = 22;
				}
				else if ($rssi >= 30) {
	    			// $temperature = 'temperatur pagi berlebih men';
	    			$rssi = 21;
	    		}
	        	else if($rssi < 30 && $rssi >= 15) {
					// $temperature = 'temperatur pagi aman men';
					$rssi = 20;
				}
				else if($rssi <= 15 && $rssi >= -60) {
					// $temperature = 'temperatur pagi kurang men';
					$rssi = 19;
				}
				// else {
				// 	// $temperature = 'data kosong';
				// 	$rssi = 22;
				// }
	    	}
	    	// 11 ~ 14
	    	else if ($now_hours <= date("Y-m-d 14:30:00") && !empty($cabai)){
	    		$now_hours = 'siang';
	    		$dari = date("Y-m-d 11:00:00");
	    		$sampai = date("Y-m-d 14:30:00");

	    		// cahaya = field4 = light
	        	// cahaya
	        	$cahaya = DB::table('tb_status_tanaman')->where('id_channel', '=', $id)->where('created_at', '>=', $dari)->where('created_at', '<=', $sampai)->max('cahaya'); 
	    		$value_cahaya = $cahaya;
	    		
	    		if (empty($cahaya)) {
	    			$cahaya = 22;
	    		}
	    		else if ($cahaya > 75) {
	    			// $cahaya = 'cahaya pagi berlebih men';
	    			$cahaya = 12;
	    		}
	        	else if($cahaya <= 75 && $cahaya >= 0) {
					// $cahaya = 'cahaya pagi aman men';
					$cahaya = 11;
				}
				else if ($cahaya < 0) {
					// $cahaya = 'cahaya pagi kurang men';
					$cahaya = 10;
				}

				// ph = nutrisi
	        	$ph = DB::table('tb_status_tanaman')->where('id_channel', '=', $id)->where('created_at', '>=', $dari)->where('created_at', '<=', $sampai)->max('nutrisi'); 
				$value_ph = $ph;

				if (empty($ph)) {
					$ph = 22;
				}
				else if ($ph > 6.8) {
	    			// $ph = 'ph pagi berlebih men';
	    			$ph = 18;
	    		}
	        	else if($ph <= 6.8 && $ph >= 5.5) {
					// $ph = 'ph pagi aman men';
					$ph = 17;
				}
				else if($ph < 5.5) {
					// $ph = 'ph pagi kurang men';
					$ph = 16;
				}

				// moisture = air_tanah
				$moisture = DB::table('tb_status_tanaman')->where('id_channel', '=', $id)->where('created_at', '>=', $dari)->where('created_at', '<=', $sampai)->max('air_tanah'); 
				$value_moisture = $moisture;

				if (empty($moisture)) {
					$moisture = 22;
				}
				else if ($moisture > 80) {
	    			// $moisture = 'moisture pagi berlebih men';
	    			$moisture = 9;
	    		}
	        	else if($moisture <= 80 && $moisture >= 70) {
					// $moisture = 'moisture pagi aman men';
					$moisture = 8;
				}
				else if($moisture < 70) {
					// $moisture = 'moisture pagi kurang men';
					$moisture = 7;
				}

				// humadity = kelembaban
				$humadity = DB::table('tb_status_tanaman')->where('id_channel', '=', $id)->where('created_at', '>=', $dari)->where('created_at', '<=', $sampai)->max('kelembaban');
				$value_humadity = $humadity;

				if (empty($humadity)) {
					$humadity = 22;
				}
				else if($humadity > 70) {
	    			// $humadity = 'humadity pagi berlebih men';
	    			$humadity = 6;
	    		}
	        	else if($humadity <= 70 && $humadity >= 50) {
					// $humadity = 'humadity pagi aman men';
					$humadity = 5;
				}
				else if($humadity < 50) {
					// $humadity = 'humadity pagi kurang men';
					$humadity = 4;
				}

				// level_water = tangki_air
				$level_water = DB::table('tb_status_tanaman')->where('id_channel', '=', $id)->where('created_at', '>=', $dari)->where('created_at', '<=', $sampai)->max('tangki_air');
				$value_level_water = $level_water;

				if (empty($level_water)) {
					$level_water = 22;
				}
				else if ($level_water == 3) {
	    			// $level_water = 'level_water pagi penuh men';
	    			$level_water = 15;
	    		}
	        	else if($level_water == 2) {
					// $level_water = 'level_water pagi sedang men';
					$level_water = 14;
				}
				else if($level_water == 1) {
					// $level_water = 'level_water pagi kurang men';
					$level_water = 13;
				}
				else {
					// $level_water = 'data kosong';
					$level_water = 22;
				}	

				// temperature = suhu
				$temperature = DB::table('tb_status_tanaman')->where('id_channel', '=', $id)->where('created_at', '>=', $dari)->where('created_at', '<=', $sampai)->max('suhu');
				$value_temperature = $temperature;

				if (empty($temperature)) {
					$temperature = 22;
				}
				else if ($temperature > 27) {
	    			// $temperature = 'temperatur pagi berlebih men';
	    			$temperature = 3;
	    		}
	        	else if($temperature <= 27 && $temperature >= 25) {
					// $temperature = 'temperatur pagi aman men';
					$temperature = 2;
				}
				else if($temperature < 25) {
					// $temperature = 'temperatur pagi kurang men';
					$temperature = 1;
				}

				// rssi
				$rssi = DB::table('tb_status_tanaman')->where('id_channel', '=', $id)->where('created_at', '>=', $dari)->where('created_at', '<=', $sampai)->max('rssi');
				$value_rssi = $rssi;

				if (empty($rssi)) {
					$rssi = 22;
				}
				else if ($rssi >= 30) {
	    			// $temperature = 'temperatur pagi berlebih men';
	    			$rssi = 21;
	    		}
	        	else if($rssi < 30 && $rssi >= 15) {
					// $temperature = 'temperatur pagi aman men';
					$rssi = 20;
				}
				else if($rssi <= 15 && $rssi >= -60) {
					// $temperature = 'temperatur pagi kurang men';
					$rssi = 19;
				}

	    	}
	    	// 14 ~ 17
	    	else if ($now_hours <= date("Y-m-d 17:30:00") && !empty($cabai)) {
	    		$now_hours = 'sore';
	    		$dari = date("Y-m-d 14:30:00");
	    		$sampai = date("Y-m-d 17:00:00");
	    		
	    		// cahaya
	        	$cahaya = DB::table('tb_status_tanaman')->where('id_channel', '=', $id)->where('created_at', '>=', $dari)->where('created_at', '<=', $sampai)->max('cahaya'); 
	    		$value_cahaya = $cahaya;
	    		
	    		if (empty($cahaya)) {
	    			$cahaya = 22;
	    		}
	    		else if ($cahaya > 75) {
	    			// $cahaya = 'cahaya pagi berlebih men';
	    			$cahaya = 12;
	    		}
	        	else if($cahaya <= 75 && $cahaya >= 0) {
					// $cahaya = 'cahaya pagi aman men';
					$cahaya = 11;
				}
				else if ($cahaya < 0) {
					// $cahaya = 'cahaya pagi kurang men';
					$cahaya = 10;
				}

				// ph = nutrisi
	        	$ph = DB::table('tb_status_tanaman')->where('id_channel', '=', $id)->where('created_at', '>=', $dari)->where('created_at', '<=', $sampai)->max('nutrisi'); 
				$value_ph = $ph;

				if (empty($ph)) {
					$ph = 22;
				}
				else if ($ph > 6.8) {
	    			// $ph = 'ph pagi berlebih men';
	    			$ph = 18;
	    		}
	        	else if($ph <= 6.8 && $ph >= 5.5) {
					// $ph = 'ph pagi aman men';
					$ph = 17;
				}
				else if($ph < 5.5) {
					// $ph = 'ph pagi kurang men';
					$ph = 16;
				}

				// moisture = air_tanah
				$moisture = DB::table('tb_status_tanaman')->where('id_channel', '=', $id)->where('created_at', '>=', $dari)->where('created_at', '<=', $sampai)->max('air_tanah'); 
				$value_moisture = $moisture;

				if (empty($moisture)) {
					$moisture = 22;
				}
				else if ($moisture > 80) {
	    			// $moisture = 'moisture pagi berlebih men';
	    			$moisture = 9;
	    		}
	        	else if($moisture <= 80 && $moisture >= 70) {
					// $moisture = 'moisture pagi aman men';
					$moisture = 8;
				}
				else if($moisture < 70) {
					// $moisture = 'moisture pagi kurang men';
					$moisture = 7;
				}

				// humadity = kelembaban
				$humadity = DB::table('tb_status_tanaman')->where('id_channel', '=', $id)->where('created_at', '>=', $dari)->where('created_at', '<=', $sampai)->max('kelembaban');
				$value_humadity = $humadity;

				if (empty($humadity)) {
					$humadity = 22;
				}
				else if($humadity > 70) {
	    			// $humadity = 'humadity pagi berlebih men';
	    			$humadity = 6;
	    		}
	        	else if($humadity <= 70 && $humadity >= 50) {
					// $humadity = 'humadity pagi aman men';
					$humadity = 5;
				}
				else if($humadity < 50) {
					// $humadity = 'humadity pagi kurang men';
					$humadity = 4;
				}

				// level_water = tangki_air
				$level_water = DB::table('tb_status_tanaman')->where('id_channel', '=', $id)->where('created_at', '>=', $dari)->where('created_at', '<=', $sampai)->max('tangki_air');
				$value_level_water = $level_water;

				if (empty($level_water)) {
					$level_water = 22;
				}
				else if ($level_water == 3) {
	    			// $level_water = 'level_water pagi penuh men';
	    			$level_water = 15;
	    		}
	        	else if($level_water == 2) {
					// $level_water = 'level_water pagi sedang men';
					$level_water = 14;
				}
				else if($level_water == 1) {
					// $level_water = 'level_water pagi kurang men';
					$level_water = 13;
				}
				else {
					// $level_water = 'data kosong';
					$level_water = 22;
				}	

				// temperature = suhu
				$temperature = DB::table('tb_status_tanaman')->where('id_channel', '=', $id)->where('created_at', '>=', $dari)->where('created_at', '<=', $sampai)->max('suhu');
				$value_temperature = $temperature;

				if (empty($temperature)) {
					$temperature = 22;
				}
				else if ($temperature > 27) {
	    			// $temperature = 'temperatur pagi berlebih men';
	    			$temperature = 3;
	    		}
	        	else if($temperature <= 27 && $temperature >= 25) {
					// $temperature = 'temperatur pagi aman men';
					$temperature = 2;
				}
				else if($temperature < 25) {
					// $temperature = 'temperatur pagi kurang men';
					$temperature = 1;
				}

				// rssi
				$rssi = DB::table('tb_status_tanaman')->where('id_channel', '=', $id)->where('created_at', '>=', $dari)->where('created_at', '<=', $sampai)->max('rssi');
				$value_rssi = $rssi;

				if (empty($rssi)) {
					$rssi = 22;
				}
				else if ($rssi >= 30) {
	    			// $temperature = 'temperatur pagi berlebih men';
	    			$rssi = 21;
	    		}
	        	else if($rssi < 30 && $rssi >= 15) {
					// $temperature = 'temperatur pagi aman men';
					$rssi = 20;
				}
				else if($rssi <= 15 && $rssi >= -60) {
					// $temperature = 'temperatur pagi kurang men';
					$rssi = 19;
				}
	    	}
	    	// start
	    	// di sini kondisi jika tanaman bawang
	    	// 06 ~ 11
	    	else if ($now_hours <= date("Y-m-d 11:00:00") && !empty($bawang) ) {
	    		$now_hours = 'pagi';
	    		$dari = date("Y-m-d 06:00:00");
	    		$sampai = date("Y-m-d 10:30:00");

	    		// cahaya
	        	$cahaya = DB::table('tb_status_tanaman')->where('id_channel', '=', $id)->where('created_at', '>=', $dari)->where('created_at', '<=', $sampai)->max('cahaya'); 
	    		$value_cahaya = $cahaya;
	    		
	    		if (empty($cahaya)) {
	    			$cahaya = 22;
	    		}
	    		else if ($cahaya > 100) {
	    			// $cahaya = 'cahaya pagi berlebih men';
	    			$cahaya = 12;
	    		}
	        	else if($cahaya <= 100 && $cahaya >= 70) {
					// $cahaya = 'cahaya pagi aman men';
					$cahaya = 11;
				}
				else if ($cahaya < 70) {
					// $cahaya = 'cahaya pagi kurang men';
					$cahaya = 10;
				}

				// ph = nutrisi
	        	$ph = DB::table('tb_status_tanaman')->where('id_channel', '=', $id)->where('created_at', '>=', $dari)->where('created_at', '<=', $sampai)->max('nutrisi'); 
				$value_ph = $ph;

				if (empty($ph)) {
					$ph = 22;
				}
				else if ($ph > 6.5) {
	    			// $ph = 'ph pagi berlebih men';
	    			$ph = 18;
	    		}
	        	else if($ph <= 6.5 && $ph >= 5.6) {
					// $ph = 'ph pagi aman men';
					$ph = 17;
				}
				else if($ph < 5.6) {
					// $ph = 'ph pagi kurang men';
					$ph = 16;
				}

				// moisture = air_tanah
				$moisture = DB::table('tb_status_tanaman')->where('id_channel', '=', $id)->where('created_at', '>=', $dari)->where('created_at', '<=', $sampai)->max('air_tanah'); 
				$value_moisture = $moisture;

				if (empty($moisture)) {
					$moisture = 22;
				}
				else if ($moisture > 70) {
	    			// $moisture = 'moisture pagi berlebih men';
	    			$moisture = 9;
	    		}
	        	else if($moisture <= 70 && $moisture >= 60) {
					// $moisture = 'moisture pagi aman men';
					$moisture = 8;
				}
				else if($moisture < 60) {
					// $moisture = 'moisture pagi kurang men';
					$moisture = 7;
				}

				// humadity = kelembaban
				$humadity = DB::table('tb_status_tanaman')->where('id_channel', '=', $id)->where('created_at', '>=', $dari)->where('created_at', '<=', $sampai)->max('kelembaban');
				$value_humadity = $humadity;

				if (empty($humadity)) {
					$humadity = 22;
				}
				else if($humadity > 70) {
	    			// $humadity = 'humadity pagi berlebih men';
	    			$humadity = 6;
	    		}
	        	else if($humadity <= 70 && $humadity >= 50) {
					// $humadity = 'humadity pagi aman men';
					$humadity = 5;
				}
				else if($humadity < 50) {
					// $humadity = 'humadity pagi kurang men';
					$humadity = 4;
				}

				// level_water = tangki_air
				$level_water = DB::table('tb_status_tanaman')->where('id_channel', '=', $id)->where('created_at', '>=', $dari)->where('created_at', '<=', $sampai)->max('tangki_air');
				$value_level_water = $level_water;

				if (empty($level_water)) {
					$level_water = 22;
				}
				else if ($level_water == 3) {
	    			// $level_water = 'level_water pagi penuh men';
	    			$level_water = 15;
	    		}
	        	else if($level_water == 2) {
					// $level_water = 'level_water pagi sedang men';
					$level_water = 14;
				}
				else if($level_water == 1) {
					// $level_water = 'level_water pagi kurang men';
					$level_water = 13;
				}
				else {
					// $level_water = 'data kosong';
					$level_water = 22;
				}	

				// temperature = suhu
				$temperature = DB::table('tb_status_tanaman')->where('id_channel', '=', $id)->where('created_at', '>=', $dari)->where('created_at', '<=', $sampai)->max('suhu');
				$value_temperature = $temperature;

				if (empty($temperature)) {
					$temperature = 22;
				}
				else if ($temperature > 32) {
	    			// $temperature = 'temperatur pagi berlebih men';
	    			$temperature = 3;
	    		}
	        	else if($temperature <= 32 && $temperature >= 25) {
					// $temperature = 'temperatur pagi aman men';
					$temperature = 2;
				}
				else if($temperature < 25) {
					// $temperature = 'temperatur pagi kurang men';
					$temperature = 1;
				}

				// engga dipake 
				// rssi
				$rssi = DB::table('tb_status_tanaman')->where('id_channel', '=', $id)->where('created_at', '>=', $dari)->where('created_at', '<=', $sampai)->max('rssi');
				$value_rssi = $rssi;

				if (empty($rssi)) {
					$rssi = 22;
				}
				else if ($rssi >= 30) {
	    			// $temperature = 'temperatur pagi berlebih men';
	    			$rssi = 21;
	    		}
	        	else if($rssi < 30 && $rssi >= 15) {
					// $temperature = 'temperatur pagi aman men';
					$rssi = 20;
				}
				else if($rssi <= 15 && $rssi >= -60) {
					// $temperature = 'temperatur pagi kurang men';
					$rssi = 19;
				}
	    	}
	    	// 11 ~ 14
	    	else if ($now_hours <= date("Y-m-d 14:30:00") && !empty($bawang)){
	    		$now_hours = 'siang';
	    		$dari = date("Y-m-d 11:00:00");
	    		$sampai = date("Y-m-d 14:30:00");

	    		// cahaya
	        	$cahaya = DB::table('tb_status_tanaman')->where('id_channel', '=', $id)->where('created_at', '>=', $dari)->where('created_at', '<=', $sampai)->max('cahaya'); 
	    		$value_cahaya = $cahaya;
	    		
	    		if (empty($cahaya)) {
	    			$cahaya = 22;
	    		}
	    		else if ($cahaya > 100) {
	    			// $cahaya = 'cahaya pagi berlebih men';
	    			$cahaya = 12;
	    		}
	        	else if($cahaya <= 100 && $cahaya >= 70) {
					// $cahaya = 'cahaya pagi aman men';
					$cahaya = 11;
				}
				else if ($cahaya < 70) {
					// $cahaya = 'cahaya pagi kurang men';
					$cahaya = 10;
				}

				// ph = nutrisi
	        	$ph = DB::table('tb_status_tanaman')->where('id_channel', '=', $id)->where('created_at', '>=', $dari)->where('created_at', '<=', $sampai)->max('nutrisi'); 
				$value_ph = $ph;

				if (empty($ph)) {
					$ph = 22;
				}
				else if ($ph > 6.5) {
	    			// $ph = 'ph pagi berlebih men';
	    			$ph = 18;
	    		}
	        	else if($ph <= 6.5 && $ph >= 5.6) {
					// $ph = 'ph pagi aman men';
					$ph = 17;
				}
				else if($ph < 5.6) {
					// $ph = 'ph pagi kurang men';
					$ph = 16;
				}

				// moisture = air_tanah
				$moisture = DB::table('tb_status_tanaman')->where('id_channel', '=', $id)->where('created_at', '>=', $dari)->where('created_at', '<=', $sampai)->max('air_tanah'); 
				$value_moisture = $moisture;

				if (empty($moisture)) {
					$moisture = 22;
				}
				else if ($moisture > 70) {
	    			// $moisture = 'moisture pagi berlebih men';
	    			$moisture = 9;
	    		}
	        	else if($moisture <= 70 && $moisture >= 60) {
					// $moisture = 'moisture pagi aman men';
					$moisture = 8;
				}
				else if($moisture < 60) {
					// $moisture = 'moisture pagi kurang men';
					$moisture = 7;
				}

				// humadity = kelembaban
				$humadity = DB::table('tb_status_tanaman')->where('id_channel', '=', $id)->where('created_at', '>=', $dari)->where('created_at', '<=', $sampai)->max('kelembaban');
				$value_humadity = $humadity;

				if (empty($humadity)) {
					$humadity = 22;
				}
				else if($humadity > 70) {
	    			// $humadity = 'humadity pagi berlebih men';
	    			$humadity = 6;
	    		}
	        	else if($humadity <= 70 && $humadity >= 50) {
					// $humadity = 'humadity pagi aman men';
					$humadity = 5;
				}
				else if($humadity < 50) {
					// $humadity = 'humadity pagi kurang men';
					$humadity = 4;
				}

				// level_water = tangki_air
				$level_water = DB::table('tb_status_tanaman')->where('id_channel', '=', $id)->where('created_at', '>=', $dari)->where('created_at', '<=', $sampai)->max('tangki_air');
				$value_level_water = $level_water;

				if (empty($level_water)) {
					$level_water = 22;
				}
				else if ($level_water == 3) {
	    			// $level_water = 'level_water pagi penuh men';
	    			$level_water = 15;
	    		}
	        	else if($level_water == 2) {
					// $level_water = 'level_water pagi sedang men';
					$level_water = 14;
				}
				else if($level_water == 1) {
					// $level_water = 'level_water pagi kurang men';
					$level_water = 13;
				}
				else {
					// $level_water = 'data kosong';
					$level_water = 22;
				}	

				// temperature = suhu
				$temperature = DB::table('tb_status_tanaman')->where('id_channel', '=', $id)->where('created_at', '>=', $dari)->where('created_at', '<=', $sampai)->max('suhu');
				$value_temperature = $temperature;

				if (empty($temperature)) {
					$temperature = 22;
				}
				else if ($temperature > 32) {
	    			// $temperature = 'temperatur pagi berlebih men';
	    			$temperature = 3;
	    		}
	        	else if($temperature <= 32 && $temperature >= 25) {
					// $temperature = 'temperatur pagi aman men';
					$temperature = 2;
				}
				else if($temperature < 25) {
					// $temperature = 'temperatur pagi kurang men';
					$temperature = 1;
				}

				// engga dipake 
				// rssi
				$rssi = DB::table('tb_status_tanaman')->where('id_channel', '=', $id)->where('created_at', '>=', $dari)->where('created_at', '<=', $sampai)->max('rssi');
				$value_rssi = $rssi;

				if (empty($rssi)) {
					$rssi = 22;
				}
				else if ($rssi >= 30) {
	    			// $temperature = 'temperatur pagi berlebih men';
	    			$rssi = 21;
	    		}
	        	else if($rssi < 30 && $rssi >= 15) {
					// $temperature = 'temperatur pagi aman men';
					$rssi = 20;
				}
				else if($rssi <= 15 && $rssi >= -60) {
					// $temperature = 'temperatur pagi kurang men';
					$rssi = 19;
				}
	    	}
	    	// 14 ~ 17
	    	else if ($now_hours <= date("Y-m-d 17:30:00") && !empty($bawang)) {
	    		$now_hours = 'sore';
	    		$dari = date("2018-09-02 14:30:00");
	    		$sampai = date("2018-09-02 17:00:00");
	    		
	    		// cahaya
	        	$cahaya = DB::table('tb_status_tanaman')->where('id_channel', '=', $id)->where('created_at', '>=', $dari)->where('created_at', '<=', $sampai)->max('cahaya'); 
	    		$value_cahaya = $cahaya;
	    		
	    		if (empty($cahaya)) {
	    			$cahaya = 22;
	    		}
	    		else if ($cahaya > 100) {
	    			// $cahaya = 'cahaya pagi berlebih men';
	    			$cahaya = 12;
	    		}
	        	else if($cahaya <= 100 && $cahaya >= 70) {
					// $cahaya = 'cahaya pagi aman men';
					$cahaya = 11;
				}
				else if ($cahaya < 70) {
					// $cahaya = 'cahaya pagi kurang men';
					$cahaya = 10;
				}

				// ph = nutrisi
	        	$ph = DB::table('tb_status_tanaman')->where('id_channel', '=', $id)->where('created_at', '>=', $dari)->where('created_at', '<=', $sampai)->max('nutrisi'); 
				$value_ph = $ph;

				if (empty($ph)) {
					$ph = 22;
				}
				else if ($ph > 6.5) {
	    			// $ph = 'ph pagi berlebih men';
	    			$ph = 18;
	    		}
	        	else if($ph <= 6.5 && $ph >= 5.6) {
					// $ph = 'ph pagi aman men';
					$ph = 17;
				}
				else if($ph < 5.6) {
					// $ph = 'ph pagi kurang men';
					$ph = 16;
				}

				// moisture = air_tanah
				$moisture = DB::table('tb_status_tanaman')->where('id_channel', '=', $id)->where('created_at', '>=', $dari)->where('created_at', '<=', $sampai)->max('air_tanah'); 
				$value_moisture = $moisture;

				if (empty($moisture)) {
					$moisture = 22;
				}
				else if ($moisture > 70) {
	    			// $moisture = 'moisture pagi berlebih men';
	    			$moisture = 9;
	    		}
	        	else if($moisture <= 70 && $moisture >= 60) {
					// $moisture = 'moisture pagi aman men';
					$moisture = 8;
				}
				else if($moisture < 60) {
					// $moisture = 'moisture pagi kurang men';
					$moisture = 7;
				}

				// humadity = kelembaban
				$humadity = DB::table('tb_status_tanaman')->where('id_channel', '=', $id)->where('created_at', '>=', $dari)->where('created_at', '<=', $sampai)->max('kelembaban');
				$value_humadity = $humadity;

				if (empty($humadity)) {
					$humadity = 22;
				}
				else if($humadity > 70) {
	    			// $humadity = 'humadity pagi berlebih men';
	    			$humadity = 6;
	    		}
	        	else if($humadity <= 70 && $humadity >= 50) {
					// $humadity = 'humadity pagi aman men';
					$humadity = 5;
				}
				else if($humadity < 50) {
					// $humadity = 'humadity pagi kurang men';
					$humadity = 4;
				}

				// level_water = tangki_air
				$level_water = DB::table('tb_status_tanaman')->where('id_channel', '=', $id)->where('created_at', '>=', $dari)->where('created_at', '<=', $sampai)->max('tangki_air');
				$value_level_water = $level_water;

				if (empty($level_water)) {
					$level_water = 22;
				}
				else if ($level_water == 3) {
	    			// $level_water = 'level_water pagi penuh men';
	    			$level_water = 15;
	    		}
	        	else if($level_water == 2) {
					// $level_water = 'level_water pagi sedang men';
					$level_water = 14;
				}
				else if($level_water == 1) {
					// $level_water = 'level_water pagi kurang men';
					$level_water = 13;
				}
				else {
					// $level_water = 'data kosong';
					$level_water = 22;
				}	

				// temperature = suhu
				$temperature = DB::table('tb_status_tanaman')->where('id_channel', '=', $id)->where('created_at', '>=', $dari)->where('created_at', '<=', $sampai)->max('suhu');
				$value_temperature = $temperature;

				if (empty($temperature)) {
					$temperature = 22;
				}
				else if ($temperature > 32) {
	    			// $temperature = 'temperatur pagi berlebih men';
	    			$temperature = 3;
	    		}
	        	else if($temperature <= 32 && $temperature >= 25) {
					// $temperature = 'temperatur pagi aman men';
					$temperature = 2;
				}
				else if($temperature < 25) {
					// $temperature = 'temperatur pagi kurang men';
					$temperature = 1;
				}

				// engga dipake 
				// rssi
				$rssi = DB::table('tb_status_tanaman')->where('id_channel', '=', $id)->where('created_at', '>=', $dari)->where('created_at', '<=', $sampai)->max('rssi');
				$value_rssi = $rssi;

				if (empty($rssi)) {
					$rssi = 22;
				}
				else if ($rssi >= 30) {
	    			// $temperature = 'temperatur pagi berlebih men';
	    			$rssi = 21;
	    		}
	        	else if($rssi < 30 && $rssi >= 15) {
					// $temperature = 'temperatur pagi aman men';
					$rssi = 20;
				}
				else if($rssi <= 15 && $rssi >= -60) {
					// $temperature = 'temperatur pagi kurang men';
					$rssi = 19;
				}
	    	}
	    	// end

	    	// 17 ~ 24
	    	else if ($now_hours <= date("Y-m-d 24:00:00")) {
	     		$now_hours = 'matahari sudah terbenam hari sudah menunjukan waktu malam men, jadi tanaman ingin bobo';
	    		$cahaya = 'tanaman istirahat';
	    		$value_cahaya = 'kosong';

	    		$ph = 'tanaman istirahat';
	    		$value_ph = 'kosong';

	    		$humadity = 'tanaman istirahat';
	    		$value_humadity = 'kosong';

	    		$temperature = 'tanaman istirahat';
	    		$value_temperature = 'kosong';

	    		$moisture = 'tanaman istirahat';
	    		$value_moisture = 'kosong';

	    		$level_water = 'tanaman istirahat';
	            $value_level_water = 'kosong';

	    		$rssi = 'tanaman istirahat';
	    		$value_rssi = 'kosong';
	    	}

	    // proses penambahan data ke status_notif	
	    if (date("Y-m-d H:i:s") > date("Y-m-d 06:00:00") && date("Y-m-d H:i:s") < date("Y-m-d 18:00:00"))  {
	    // if (date("Y-m-d H:i:s") > date("Y-m-d 06:00:00") && date("Y-m-d H:i:s") < date("Y-m-d 22:40:00"))  {

	    	$get_hari = Tanaman::where('id_channel', '=', $id)->first();		 
			$tanam = date("Y-m-d", strtotime($get_hari['tgl_tanam']));
		    $datetime1 = new Carbon($tanam);
		    // $datetime2 = now();
		    $datetime2 = new Carbon(date("Y-m-d H:i:s"));
		    // menampilkan harinya min jika tgl tanamnya lebih dari tgl sekarang
		    if ($datetime1 >= $datetime2) {
		    	$interval = date_diff($datetime1, $datetime2);
		    	$now_usia = $interval->format('-'.'%a');
		    }
		    else if ($datetime1 <= $datetime2) {
		    	$interval = date_diff($datetime1, $datetime2);
		    	$now_usia = $interval->format('%a');
		    }

		    // dd($now_usia);
	    		
	    		$create = StatusNotif::create([    	
					'id_channel'  	=> $id_channel,
					'waktu'		  	=> $now_hours,
					'temperature' 	=> $temperature,
					'humadity'		=> $humadity,
					'moisture'		=> $moisture,
					'light'			=> $cahaya,
					'level_water'	=> $level_water,
					'ph'			=> $ph,
					'rssi'			=> $rssi,

					// hari ke
					'hari_ke'		=> $now_usia,
					// isi dari status_tanaman
					'value_temperature' 	=> $value_temperature,
					'value_humadity'		=> $value_humadity,
					'value_moisture'		=> $value_moisture,
					'value_light'			=> $value_cahaya,
					'value_level_water'	=> $value_level_water,
					'value_ph'			=> $value_ph,
					'value_rssi'			=> $value_rssi,
				]);
	    	}
	    else {
	    	$create = 'kosong';
	    }	
	    

		// $data = StatusNotif::where('id_channel', '=', $id)->with('device', 'tanaman.jenisTanaman', 'temperature', 'humadity', 'moisture', 'light', 'level_water', 'ph', 'rssi')->orderBy('id_status_notif', 'DESC')->first();

    	return response()->json([
			'msg'  	  		=> 'success',
			'channel'		=> $id_channel,
			'waktu' 	  	=> $now_hours,
			'temperature' 	=> $value_temperature,
			'humadity'		=> $value_humadity,
			'moisture'		=> $value_moisture,
			'cahaya'  		=> $value_cahaya,
			'level_water'	=> $value_level_water,
			'ph'  			=> $value_ph,
			'rssi'			=> $value_rssi,
			'proses_create'	=> $create,
			'status'  		=> 200
		]);
    }

    public function getPemupukanWithId($id){
        // bawang usia sampai 70 hari
        // id_jenis_tanaman 10 = bawang
    	// cabai merah usia sampai 90 hari
        // id_jenis_tanaman 21 = cabai


        // query
    	$qry =Tanaman::where('id_petani', '=', $id)->with('jenisTanaman')->get();
        
    	if (empty($qry)) {
    		return 'petani tidak mempunyai tanaman';
    	}

    	else {
            $data2 = [];
	    	$data = json_decode($qry, true);
	    	foreach ($data as $key => $value) {

	    	    $tanam = date("Y-m-d", strtotime($value['tgl_tanam']));
	    	    $datetime1 = new Carbon($tanam);
			    $datetime2 = now();
			    // menampilkan harinya min jika tgl tanamnya lebih dari tgl sekarang
			    if ($datetime1 >= $datetime2) {
			    	$interval = date_diff($datetime1, $datetime2);
			    	$now_usia = $interval->format('-'.'%a');
			    }
			    else if ($datetime1 <= $datetime2) {
			    	$interval = date_diff($datetime1, $datetime2);
			    	$now_usia = $interval->format('%a');
			    }

			    // lama
			    // $interval = date_diff($datetime1, $datetime2);
			    // $interval = $datetime1->diff($datetime2);

			    // kondisi hari min atau plus
			    // if ($interval >= date('Y-m-d H:i:s')) {
			    // 	$now_usia = $interval->format('-'.'%a');
			    // } else if ($interval <= date('Y-m-d H:i:s')) {
			    // 	$now_usia = $interval->format('%a');
			    // }

			    // // $now_usia = $interval->format('%a');

			    // dd($now_usia);
			    

			    $j = $value['id_jenis_tanaman'];

			    
			    // pemupukan bawang
                if ($j == 10 && $now_usia >= 10 && $now_usia <= 15) {
	    			$pupuk = 'Pemupukan susulan I menggunakan Urea (150-200 kg/ha), ZA (300-500 kg/ha) dan KCl (150-200 kg/ha). ';
	            }

                else if ($j == 10 && $now_usia == 21) {
	        		$pupuk = '100 kg NPK(15-15-15) Mutiara ';
	            }
	        	else if ($j == 10 && $now_usia == 30) {
	        		$pupuk = 'Pemupukan susulan II menggunakan Urea (150-200 kg/ha), ZA (300-500 kg/ha) dan KCl (150-200 kg/ha). ';
	        	}
	        	

	        	//pemupukan cabai merah
	        	else if ($j == 21 && $now_usia >= 10 && $now_usia <=15) {
	        		$pupuk = 'Pupuk Susulan';
	        	}
	        	else if ($j == 21 && $now_usia == 40) {
	        		$pupuk = 'Pupuk Susulan 2';
	        	}
	        	else if ($j == 21 && $now_usia == 70) {
	        		$pupuk = 'Pupuk Susulan 3';
	        	}
	        	else {
	        		$pupuk = 'Belum waktunya pemupukan';
	        	}

	        	// pemupukan hayati bawang
	        	if ($j == 10 && $now_usia > 1 && $now_usia <= 28 ) {
	        		$pupuk_hayati = 'pupuk hayati diaplikasikan dengan penyemprotan';
	        	}
	        	else {
	        		$pupuk_hayati = 'Sudah tidak menggunakan pupuk hayati lagi';
	        	}

	        	// penyiraman bawang
	        	if ($j == 10 && $now_usia >= 0 && $now_usia <= 10 ) {
	        		$penyiraman = 'penyiraman dilakukan dua kali yakni pagi dan sore hari, setiap  hari.';
	        	}
	        	else if ($j == 10 && $now_usia > 10 && $now_usia <= 70) {
	        		$penyiraman = 'penyiraman dilakukan satu kali baiknya Pagi hari, setiap  hari.';
	        	}

	        	//penyiraman cabai
	        	else if ($j == 21 && $now_usia >=0 && $now_usia <= 30) {
	        		$penyiraman = 'Penyiraman 1 hari sekali';
	        	}
	        	else if ($j == 21 && $now_usia > 30 && $now_usia <= 90) {
	        		$penyiraman = 'Penyiraman 2-3 hari sekali';
	        	}
	        	else {
	        		$penyiraman = 'tanaman sudah di panen';
	        	}

	        	//pemangkasan cabai
	        	if ($j == 21 && $now_usia == 60) {
	        		$pangkas = 'Pemangkasan Tunas air';
	        	}

	        	//penyiangan
	        	if ($j == 21 && $now_usia == 15) {
	        		$penyiangan = 'Penyiangan';
	        	}
	        	else if ($j == 21 && $now_usia == 45) {
	        		$penyiangan = 'Penyiangan 2';
	        	}
	        	else if ($j == 21 && $now_usia == 75) {
	        		$penyiangan = 'Penyiangan 3';
	        	}

	        	// dd($penyiangan);

	        // // yang di butuhkan
	        // $data[$key]['usia'] = $now_usia;
        	// $data[$key]['pupuk'] = $pupuk;

        	// jika statusnya milik tanaman bawang
        	if ($j == 10) {
        		$data[$key]['usia'] = $now_usia;
        		$data[$key]['pupuk'] = $pupuk;
        		$data[$key]['pupuk_hayati'] = $pupuk_hayati;
        		$data[$key]['penyiraman'] = $penyiraman;
        	}
        	else if ($j == 21) {
	      		$data[$key]['usia'] = $now_usia;
        		$data[$key]['pupuk'] = $pupuk;
        		$data[$key]['penyiraman'] = $penyiraman;
        		// $data[$key]['pemangkasan'] = $pangkas;
        		// $data[$key]['penyiangan'] = $penyiangan;
        	}
        	
        	
            }
            // end foreach
		
    	

	    	// json
	    	if (empty($data)) {
	    		return response()->json([
				'msg'  	  		=> 'failed',
				'data'			=> 'petani tidak mempunyai tanaman',
				'status'  		=> 200
				]);
	    	}
	    	else {
		    	return response()->json([
					'msg'  	  		=> 'success',
					'data'			=> $data,
					'status'  		=> 200
				]);
	    	}
    	}
    }
    public function coba($id)
    {
    	// 10 adalah id jenis tanaman di tabel tb_jenis_tanaman yang menginisialkan tanaman bawang
    	$bawang = DB::table('tb_status_tanaman')
            ->join('tb_tanaman', 'tb_status_tanaman.id_channel', '=', 'tb_tanaman.id_channel')
            ->join('tb_jenis_tanaman', 'tb_tanaman.id_jenis_tanaman', '=', 'tb_jenis_tanaman.id_jenis_tanaman')
            ->where('tb_status_tanaman.id_channel', '=', $id)
            ->where('tb_tanaman.id_jenis_tanaman', '=', 10)
            ->select('tb_status_tanaman.id_channel', 'tb_tanaman.id_jenis_tanaman', 'tb_jenis_tanaman.nama_tanaman')
            ->first();

    	// 21 adalah id jenis tanaman di tabel tb_jenis_tanaman yang menginisialkan tanaman cabai   
        $cabai = DB::table('tb_status_tanaman')
            ->join('tb_tanaman', 'tb_status_tanaman.id_channel', '=', 'tb_tanaman.id_channel')
            ->join('tb_jenis_tanaman', 'tb_tanaman.id_jenis_tanaman', '=', 'tb_jenis_tanaman.id_jenis_tanaman')
            ->where('tb_status_tanaman.id_channel', '=', $id)
            ->where('tb_tanaman.id_jenis_tanaman', '=', 21)
            ->select('tb_status_tanaman.id_channel', 'tb_tanaman.id_jenis_tanaman', 'tb_jenis_tanaman.nama_tanaman')
            ->first();
         $c = 'adwas/'.$id.'/adw';
    	return response()->json([
			'msg'  	  		=> 'success',
			'bawang'			=> $bawang,
			'cabai'			=> $cabai,
			'id_param'			=> $c,
			'status'  		=> 200
		]);
    }

    public function getPenyiramanWithId($id)
    {


    	$qry =Tanaman::where('id_petani', '=', $id)->with('jenisTanaman')->get();
        //dd($qry);
    	if (empty($qry)) {
    		return 'data kosong';
    	}
    	else {
            $data2 = [];
	    	$data = json_decode($qry, true);
	    	foreach ($data as $key => $value) {

	    	    $tanam = date("Y-m-d", strtotime($value['tgl_tanam']));
	    	    $datetime1 = new Carbon($tanam);
		    $datetime2 = now();
		    $interval = date_diff($datetime1, $datetime2);
		    $interval = $datetime1->diff($datetime2);
		    $now_usia = $interval->format('%a');

                if ($now_usia >=0 && $now_usia <=10 ) {
	    			$siram = 'penyiraman dilakukan dua kali yakni pagi dan sore hari, setiap  hari.';
	            }
	        	else {
	        		$siram = 'penyiraman dilakukan satu kali baiknya Pagi hari, setiap  hari.';
	        	}
	        	
	        $data[$key]['usia'] = $now_usia;
        	$data[$key]['siram'] = $siram;
        	


        
            }
		
    	}

    	

    	return response()->json([
			'msg'  	  		=> 'success',
			'data'			=> $data,
			'status'  		=> 200
		]);	
    }

    public function penyakitHama()
    {
    	$bawang['ulat_daun_bawang'] = 'Gejala serangan: pada daun yang terserang terlihat bercak putih transparan. Hal ini karena ulat menggerek daun dan masuk ke dalamnya sehingga merusak jaringan daun sebelah dalam sehingga kadang-kadang daun terkulai.
Cara pengendalian: rotasi tanaman, waktu tanam serempak, atau dengan pengendalian secara kimiawi yaitu menggunakan Curacron 50 EC, Diasinon 60 EC, atau Bayrusil 35 EC.
';
		$bawang['trips'] = 'Gejala serangan: terdapat bintik-bintik keputihan pada helai daun yang diserang, yang akhirnya daun menjadi kering. Serangan biasanya terjadi pada musim kemarau.
Cara pengendalian: mengatur waktu tanam yang tepat, atau secara kimiawi yakni dengan penyemprotan Curacron 50 EC, Diasinon 60 EC, atau Bayrusil 35 EC.
';
		$bawang['ulat_tanah'] = 'Pengendalian dilakukan secara manual yakni dengan mengumpulkan ulat ulat pada sore/senja hari di antara pertanaman serta menjaga kebersihan areal pertanaman.';
		$bawang['penyakit_bercak_ungu'] = 'Gejala seranga: pada daun yang terserang (umumnya daun tua) terdapat bercak keputih-putihan dan agak mengendap, lama kelamaan berwarna ungu berbentuk oval, keabu-abuan dan bertepung hitam. Serangan umumnya terjadi pada musim hujan.
Cara pengendalian: rotasi tanaman, melakukan penyemprotan setelah hujan dengan air untuk mengurangi spora yang menempel pada daun. Pengendalian secara kimiawi dilakukan dengan penyemprotan fungisida, antara lain Antracol 70 WP, Ditane M-45, Deconil 75 WP, atau Difolatan 4F.
';

		$cabai['ulat_tanah'] = 'Hama ini menyerang batang muda cabai. Pencegahan dapat dilakukan dengan cacing tanah secara manual mengambil dan menghancurkannya. Kendali dilakukkan dengan menerapkan insektisida Diptrex 95 SP atau Drusban 0,2% pada dosis yang dianjurkan.';
		$cabai['ulat_buah'] = 'Hama ini menyerang buah. Buah yang terserang akan membusuk dan rontok. Agar tidak menular, buah yang telah diserang harus dibuang dan dimusnahkan. Pengendalian hama ini dengan insektisida Agrymicin, Buldok 25 EC, Cucacron 500 EC dengan dosis yang dianjurkan.';
		$cabai['ulat_grayak'] = 'Hama ini menyerang daun dan buah cabai. Gejala yang ditimbulkan adalah rusaknya daun dan buah cabai akibat gigitan ulat ini. Pencegahannya bias diaplikasikan insektisida seperti Atabron 50 EC, Curracon 500 EC, Dharmafur 3 G, Fenval 200 EC dengan dosis sesuai anjuran.';
		$cabai['trips'] = 'Hama ini menyerang daun dan buah cabai. Gejala serangan hama ini adalah adanya strip-strip pada daun dan berwarna keperakan. Bias pencegahan diterapkan insektisida sebagai Atabron 50 EC, Curracon 500 EC, Dharmafur 3 G, Fenval 200 EC dengan dosis yang dianjurkan.';
		$cabai['belalang'] = 'Bagian yang diserang adalah tunas muda dan batang. Pencegahan bias dilakukan dengan mengambil dan memusnahkan secara manual atau dengnan memasang perangkap disekitar tanaman. Pengendalian dilakukan dengan insektisida Orthene, Diazinon, Malathion dengan dosis sesuai anjuran.';
		$cabai['lalat_buah'] = 'Adalah musuh utama dalam budidaya cabai. Lalat buah menyuntikkan telur mereka dalam serangan dengan cabai, telur ini berkembang dan menjadi larva dalam buah yang menggerogoti dari dalam yang menyebabkan busuk buah dan rontok. Pencegahan dilakukan dengan menetapkan perangkap dengan bahan aktif metil eugenol. Pengendalian dilakukan dengan menerapkan insektisida sebagai Buldok 25 EC, Curracon 500 EC, Decis 2,5 EC dengan dosis yang dianjurkan.';

		//penyakit
		$cabai['bercak_daun'] = 'Disebabkan oleh jamur Cercospora sp yang menyerang daun, batang dan tangkai buah. Gejala serangan muncul bercak kecil bulat dengan diameter 0,5 cm. Penyakit ini biasanya menyebabkan daun, buah dan batang layu dan rontok. Pengendalian aplikasi fungisida Anvil 50 SC, Alto 100 SL, Baycor 25 WP, WP 75 Daconil, Antracol 70 WP dengan dosis yang dianjurkan.';
		$cabai['layu_fusarium'] = 'Disebabkan oleh jamur Fusarium oxisporum, menyerang daun cabai. Gejala yang disebabkan layu daun yang lebih rendah dan menyebar ke seluruh daun. Banyak tanaman cabai diserang tumbuh di dataran tinggi yang terlalu lembab. Pengendalian dilakukan dengan menerapkan fungisida Saco P atau Benlate dengan dosis yang dianjurkan.';
		$cabai['patek_atau_antraknosa'] = 'Disebabkan oleh jamur. Gejala timbul jamur merah muda atau bulat hitam buah muda dan buah yang matang yang sudah hampir busuk buah yang menyebabkan, kering dan akhirnya rontok. Pencegahan dilakukan dengan mengatur jarak tanam dan memelihara lahan sanitasi. Buah diserang harus dihancurkan agar tidak menular. Pengendalian dilakukan dengan aplikasi Ridomil MZ, Previcur-N, Provit, Daconil, Antracol dengan dosis yang dianjurkan.';
		$cabai['hawar'] = 'Disebabkan oleh jamur Phytophthora infestans, adalah munculnya gejala yang disebabkan bintik-bintik hitam seperti cacar pada daun dan buah. Penyakit ini menyebabkan buah dan daun kering yang terkena menjadi era dank yang akhirnya membusuk. Pencegahan penyakit ini dilakukan dengan meningkatkan tanggul dan menjaga sanitasi. Pengendalian dilakukan dengan penerapan fungisida seperti Previcur-N, Cucapit, Dipolatan AF, Dithane M-45 dengan dosis yang dianjurkan.';
		$cabai['layu_bakteri'] = 'Disebabkan oleh bakteri Pseudomonas solanacearum dengan gejala seperti daun layu panas, batang dan cabang dari waktu ke waktu dan tanaman akan mati.Pencegahan tertular penyakit ini adalah kerusakan tanaman yang terserang, rotasi tanaman dilahan. Pengendalian dilakukan dengan aplikasi bakterisida seperti Agrept 20 WP atau Agrimycin 15 / 1.5 WP dengan dosis yang dianjurkan.';
		$cabai['damping_off'] = 'Serangan sejak pembibitan, gejala adalah pangkal batang berubah warna menjadi coklat kemudian membusuk.Disebabkan oleh jamur Rhizoctonia sp dan sp Phytium. Pencegahan penyakit ini dilakukan dengan merendam akar benih yang akan ditanam menggunakan solusi propamokarbihidroklorida. Pengendalian dilakukan dengan fungisida Vitigran Biru, Previcur N, Vendozeb 80 WP, WP 70 Antracol dengan dosis yang dianjurkan.';
		$cabai['penyakit_virus'] = 'Virus yang menyerang biasanya membawa sejumlah hama, seperti kutu daun, thrips dan tungau. Gejala serangan virus, antara lain, bintik-bintik melingkar yang semakin banyak didaun atau buah, daun keriting, tanaman tampak kurus dan sengsara, akhirnya mati. Penyakit ini belum diatasi Bias.';

		return response()->json([
			'msg'  	  		=> 'success',
			// 'data'			=> $data,
			'bawang'		=> $bawang,
			'cabai'			=> $cabai,
			'status'  		=> 200
		]);
    }

}
