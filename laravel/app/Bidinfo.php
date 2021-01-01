<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Bidinfo extends Model
{
    protected $table = 'bidinfo';
    protected $fillable = ['price', 'user_id', 'biditem_id'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function biditem()
    {
        return $this->belongsTo(Biditem::class);
    }
}
