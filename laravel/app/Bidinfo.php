<?php

namespace App;

use Carbon\Carbon;
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

    public function getFormattedCreatedAtAttribute()
    {
        return Carbon::createFromFormat('Y-m-d H:i:s', $this->attributes['created_at'])
            ->format('Y/n/d g:i A');
    }
}
