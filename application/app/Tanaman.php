<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Tanaman extends Model
{
    protected $table = 'tb_tanaman';
    protected $primaryKey = 'id_tanaman';


    protected $fillable = [
        'id_petani', 'foto_tanaman', 'id_jenis_tanaman', 'id_device', 'id_channel', 'tgl_tanam', 'lokasi',
    ];

    protected $hidden = [
        'password', 'remember_token',
    ];


    public function jenisTanaman()
    {
         return $this->belongsTo(JenisTanaman::class, 'id_jenis_tanaman', 'id_jenis_tanaman');
    } 

    public function device()
    {
         return $this->hasOne(Device::class, 'id_device', 'id_device');
    }

    public function statusTanaman()
    {
         return $this->hasMany(StatusTanaman::class, 'id_channel', 'id_channel')->orderBy('id_status_tanaman', 'desc')->limit(21);
    }

    public function statusTanamanOne()
    {
         return $this->hasOne(StatusTanaman::class, 'id_channel', 'id_channel')->orderBy('id_status_tanaman', 'desc');
    } 
    public function petani()
    {
         return $this->belongsTo(Petani::class, 'id_petani', 'id_petani');
    }    

    // untuk web
    public function statusNotifWeb()
    {
         return $this->hasOne(StatusTanaman::class, 'id_channel', 'id_channel')->orderBy('id_status_tanaman', 'desc');
    }
    

    
}
