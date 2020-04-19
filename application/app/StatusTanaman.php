<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class StatusTanaman extends Model
{
    protected $table = 'tb_status_tanaman';
    protected $primaryKey = 'id_status_tanaman';

   	protected $fillable = [
        'id_tanaman', 'id_device', 'id_channel', 'cahaya', 'kelembaban', 'tangki_air', 'suhu', 'air_tanah', 'rssi', 
        'nutrisi', 'entry_id', 'created_at', 'updated_at',
    ];



    public function tanaman()
    {
         return $this->belongsTo(Tanaman::class, 'id_channel', 'id_channel');
    } 

    public function device()
    {
         return $this->belongsTo(Device::class, 'id_channel', 'id_channel');
    } 
}
