<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Bidrequest extends Model
{
    protected $fillable = ['price'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function biditem()
    {
        return $this->belongsTo(Biditem::class);
    }
}
