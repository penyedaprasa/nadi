<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Test extends Model
{
    protected $primaryKey = 'id_test';
 	protected $table = 'tb_test';
    protected $fillable = [
        'nama', 'keterangan',
        ];

    protected $hidden = [
        'created_at', 'updated_at',
    ];
}
