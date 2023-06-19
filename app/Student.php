<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Student extends Model
{
    protected $guarded = [
        'id'
    ];

    protected $fillable = [
        'code',
        'name',
        'level',
        'program',
        'room',
        'class',
    ];

    public function records()
    {
        return $this->belongsToMany('App\Record');
    }
}
