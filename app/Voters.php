<?php

namespace App;

// use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class Voters extends Authenticatable
{

    use Notifiable;

    protected $guard = 'voter';
    protected $table = 'voters';
    protected $fillable = [
        'nama', 'nim', 'prodi', 'token', 'password', 'foto_siakad', 'nmor_wa', 'has_vote', 'verified',
    ];

    protected $hidden = [
        'password', 'token', 'nmor_wa'
    ];

    public function tervote(){
        return $this->hasOne('App\Tervote');
    }
}
