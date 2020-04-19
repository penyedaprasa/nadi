<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Administrator extends Model
{
	protected $primaryKey = 'id_admin';
	protected $table = 'tb_admin';
    protected $fillable = [
        'nama_admin', 'id_user',
    ];


    public function user()
    {
    	  return $this->belongsTo(User::class, 'id_user', 'id_user');
    }
}
