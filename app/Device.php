<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Device extends Model
{
    protected $primaryKey = 'id_device';
    protected $table = 'tb_device';
   
 

    public function device()
    {
        return $this->belongsTo(Tanaman::class, 'id_device', 'id_device');
    } 

    public function petani()
    {
        return $this->belongsTo(Petani::class, 'id_petani', 'id_petani');
    }

     public function statusTanaman()
    {
        return $this->hasMany(StatusTanaman::class, 'id_channel', 'id_channel');
    } 


}
