<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class TodoMirror extends Model
{
    protected $fillable = [
        'name',
        'description',
    ];
}
