<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Tim extends Model
{
    protected $table = 'tim';
    protected $fillable = [
        'nama_tim', 'semboyan', 'pemilihan'
    ];

    public function kandidat(){
        return $this->hasMany('App\Kandidat');
    }
}
