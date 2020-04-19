<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Petani extends Model
{
	protected $primaryKey = 'id_petani';
	protected $table = 'tb_petani';
    
    protected $fillable = [
    	'id_user','nama_petani', 'alamat', 'no_hp', 'id_device', 'foto_petani'
    ];

    public function user()
    {
    	  return $this->belongsTo(User::class, 'id_user', 'id_user');
    }

    public function lahan()
    {
         return $this->hasOne(Lahan::class, 'id_petani', 'id_petani');
    } 

     public function statusNotif()
    {
         return $this->hasOne(StatusNotif::class, 'id_petani', 'id_petani');
    } 

    public function tanaman()
    {
         return $this->hasOne(Tanaman::class, 'id_petani', 'id_petani');
    } 

    public function device()
    {
         return $this->hasOne(Device::class, 'id_petani', 'id_petani');
    } 
}
