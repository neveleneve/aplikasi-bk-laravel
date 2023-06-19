<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Teacher extends Model
{
    protected $fillable = [
        'name', 'mapel_id'
    ];

    public function record()
    {
        return $this->hasOne('App\Record');
    }
}
