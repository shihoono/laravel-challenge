<?php

namespace App;

use Carbon\Carbon;

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

    public function getFormattedCreatedAtAttribute()
    {
        return Carbon::createFromFormat('Y-m-d H:i:s', $this->attributes['created_at'])
            ->format('Y/n/d g:i A');
    }
}
