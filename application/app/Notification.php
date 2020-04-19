<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Notification extends Model
{
    protected $table = 'tb_notification';
    protected $primaryKey = 'id_notif';


   
    // public function statusNotif()
    // {
    //      return $this->belongsTo(StatusNotif::class, 'id_notif', 'id_notif');
    // }

    // public function n_temperature()
    // {
    //      return $this->belongsTo(StatusNotif::class, 'id_notif', 'temperature');
    // } 

}
