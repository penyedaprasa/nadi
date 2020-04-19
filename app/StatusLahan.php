<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class StatusLahan extends Model
{
    protected $table = 'tb_status_lahan';
    protected $primaryKey = 'id_status_lahan';



    public function lahan()
    {
         return $this->belongsTo(Lahan::class, 'id_lahan', 'id_lahan');
    } 
}
