<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Review extends Model
{
    protected $fillable = [
        'rate', 'comment', 
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function bidinfo()
    {
        return $this->belongsTo(Bidinfo::class);
    }
}
