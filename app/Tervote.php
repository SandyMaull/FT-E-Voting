<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Tervote extends Model
{
    protected $table = 'tervotes';
    protected $fillable = [
        'tim_id', 'voting_dpm', 'voters_id'
    ];

    public function voters(){
        return $this->belongsTo('App\Voters');
    }
}
