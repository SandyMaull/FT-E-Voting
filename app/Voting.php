<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Voting extends Model
{
    protected $table = 'votings';
    protected $fillable = [
        'judul', 'mulai', 'berakhir', 'pending', 'result'
    ];

    public function kandidat(){
        return $this->hasMany('App\Kandidat');
    }
}
