<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Biditem extends Model
{
    protected $fillable = ['name', 'description', 'endtime'];

    protected $dates = ['endtime'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
