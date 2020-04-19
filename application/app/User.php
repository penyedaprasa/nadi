<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{

    use Notifiable;

    
    protected $primaryKey = 'id_user';
    protected $table = 'tb_users';
   

    protected $fillable = [
        'email', 'password', 'level',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    public function petani()
    {
         return $this->hasOne(Petani::class, 'id_user', 'id_user');
    }

    public function admin()
    {
        return $this->hasOne(Administrator::class, 'id_user', 'id_user');
    }

}
