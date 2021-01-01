<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Bidinfo extends Model
{
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function biditem()
    {
        return $this->belongsTo(Biditem::class);
    }
}
