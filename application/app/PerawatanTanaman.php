<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class PerawatanTanaman extends Model
{
	protected $primaryKey = 'id_perawatan_tanaman';
	protected $table = 'tb_perawatan_tanaman';

	public function jenisTanaman()
    {
    	return $this->belongsTo(JenisTanaman::class, 'id_jenis_tanaman', 'id_jenis_tanaman');
    }
}
