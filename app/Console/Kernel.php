<?php

namespace App\Console;

use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;
use GuzzleHttp\Client;
use Validator;
use Carbon\Carbon;
use DB;
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


class Kernel extends ConsoleKernel
{
    /**
     * The Artisan commands provided by your application.
     *
     * @var array
     */
    protected $commands = [
        //
    ];

    /**
     * Define the application's command schedule.
     *
     * @param  \Illuminate\Console\Scheduling\Schedule  $schedule
     * @return void
     */
    protected function schedule(Schedule $schedule)
    {
        // $schedule->command('inspire')
        //          ->hourly();
        $schedule->call(function(){
            // create in thingspeak
            // https://api.thingspeak.com/update?api_key=M53BFTR3OYLU20CS&field1=24&field2=80&field3=77&field4=90&field5=3&field6=6.1&field7=80

            // proses pengambilan data dari midlewhere
            $client = new Client(); //GuzzleHttp\Client
            $result = $client->get('https://thingspeak.com/channels/574588/feed.json');
            // $result = $client->get('https://thingspeak.com/channels/'.$id.'/feed.json?api_key='.$api_key.'');

            $json = (string) $result->getBody();

            $p = json_decode($json, true);

            $id_channel= $p['channel']['id'];
            $last_entry= $p['channel']['last_entry_id'];
            foreach ($p['feeds'] as $value) {
                StatusTanaman::create([
                    // 'id_device'  => '24',
                    'id_channel' => $id_channel,
                    //light = field4 = cahaya
                    'cahaya'     => $value['field4'],
                    //humadity = field2 = kelembaban
                    'kelembaban' => $value['field2'],
                    //level_water = field5 = tangki_air
                    'tangki_air' => $value['field5'],
                    //temperature = field1 = suhu 
                    'suhu'       => $value['field1'],
                    //ph = field6 = field6 = nutrisi
                    'nutrisi'    => $value['field6'],
                    //moisture = field3 = air_tanah
                    'air_tanah'  => $value['field3'],
                    //rssi = field7
                    'rssi'       => $value['field7'],
                    'entry_id'   => $last_entry,
                ]);
            }
        })->everyMinute();
    }

    protected function kondisi(Schedule $schedule)
    {
        $schedule->call(function(){

            $id = '574588';
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
            // $now_hours = date("Y-m-d H:i:s");
            $now_hours = date("Y-m-d 16:00:00");
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
                    //  // $cahaya = 'data kosong'; 
                    //  $cahaya = 22;
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
                    //  // $ph = 'data kosong';
                    //  $ph = 22;
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
                    //  // $moisture = 'data kosong';
                    //  $moisture = 22;
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
                    //  // $humadity = 'data kosong';
                    //  $humadity = 22;
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
                    //  // $temperature = 'data kosong';
                    //  $temperature = 22;
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
                    //  // $temperature = 'data kosong';
                    //  $rssi = 22;
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
                        'id_channel'    => $id_channel,
                        'waktu'         => $now_hours,
                        'temperature'   => $temperature,
                        'humadity'      => $humadity,
                        'moisture'      => $moisture,
                        'light'         => $cahaya,
                        'level_water'   => $level_water,
                        'ph'            => $ph,
                        'rssi'          => $rssi,

                        // hari ke
                        'hari_ke'       => $now_usia,
                        // isi dari status_tanaman
                        'value_temperature'     => $value_temperature,
                        'value_humadity'        => $value_humadity,
                        'value_moisture'        => $value_moisture,
                        'value_light'           => $value_cahaya,
                        'value_level_water'     => $value_level_water,
                        'value_ph'              => $value_ph,
                        'value_rssi'            => $value_rssi,
                    ]);
                }
            else {
                $create = 'kosong';
            }
        
        })->everyMinute();
        
    }

    /**
     * Register the commands for the application.
     *
     * @return void
     */
    protected function commands()
    {
        $this->load(__DIR__.'/Commands');

        require base_path('routes/console.php');
    }
}
