<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Voters extends Model
{
    protected $table = 'voters';
    protected $fillable = [
        'nama', 'nim', 'prodi', 'token', 'password', 'foto_siakad', 'nmor_wa', 'has_vote', 'verified',
    ];

    public function tervote(){
        return $this->hasOne('App\Tervote');
    }
}
