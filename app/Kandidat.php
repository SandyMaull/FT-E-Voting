<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Kandidat extends Model
{
    protected $table = 'kandidats';
    protected $fillable = [
        'nama', 'nim', 'jurusan', 'visi', 'misi', 'pengalaman', 'image', 'voting_id', 'tim_id'
    ];

    public function voting(){
        return $this->belongsTo('App\Voting');
    }
    public function tim(){
        return $this->belongsTo('App\Tim');
    }
}
