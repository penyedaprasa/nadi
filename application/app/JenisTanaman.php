<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class JenisTanaman extends Model
{
    protected $table = 'tb_jenis_tanaman';
    protected $primaryKey = 'id_jenis_tanaman';

    // protected $fillable = [
    //     'nama_tanaman', 'tgl_tanam', 'usia_tanaman', 'keterangan',
    // ];


    // protected $hidden = [
    //     'created_at', 'updated_at',
    // ];

    public function lahan()
    {
         return $this->belongsTo(Lahan::class, 'id_jenis_tanaman', 'id_jenis_tanaman');
    } 

    public function tanaman()
    {
    	return $this->hasMany(Tanaman::class, 'id_jenis_tanaman', 'id_jenis_tanaman');
    }

    public function tanamanNama()
    {
        return $this->belongsTo(Tanaman::class, 'id_jenis_tanaman', 'id_jenis_tanaman');
    }

    public function perawatanTanaman()
    {
         return $this->hasMany(PerawatanTanaman::class, 'id_jenis_tanaman', 'id_jenis_tanaman');
    }
}
