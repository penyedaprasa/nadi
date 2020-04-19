<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class StatusNotif extends Model
{
    protected $table = 'tb_status_notif';
    protected $primaryKey = 'id_status_notif';

    protected $fillable = [
       'waktu', 'hari_ke', 'id_channel', 
       'temperature', 'humadity', 'moisture', 'light', 'level_water', 'ph', 'rssi',
       'value_temperature', 'value_humadity', 'value_moisture', 'value_light', 'value_level_water', 'value_ph', 'value_rssi', 
       'created_at', 'updated_at',
    ];


    public function device()
    {
        return $this->hasOne(Device::class, 'id_channel', 'id_channel');
    }
    public function tanaman()
    {
         return $this->belongsTo(Tanaman::class, 'id_channel', 'id_channel');
    }

    // elequent notif
    public function temperature()
    {
         return $this->hasOne(Notification::class, 'id_notif', 'temperature');
    }

    public function humadity()
    {
         return $this->hasOne(Notification::class, 'id_notif', 'humadity');
    }
    public function moisture()
    {
         return $this->hasOne(Notification::class, 'id_notif', 'moisture');
    } 
    public function light()
    {
         return $this->hasOne(Notification::class, 'id_notif', 'light');
    }
    public function level_water()
    {
         return $this->hasOne(Notification::class, 'id_notif', 'level_water');
    }
    public function ph()
    {
         return $this->hasOne(Notification::class, 'id_notif', 'ph');
    }
    public function rssi()
    {
         return $this->hasOne(Notification::class, 'id_notif', 'rssi');
    }
}
