<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class Biditem extends Model
{
    protected $fillable = ['name', 'description', 'endtime'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function getFormattedEndTimeAttribute()
    {
        return Carbon::createFromFormat('Y-m-d H:i:s', $this->attributes['endtime'])
            ->format('Y/n/d g:i A');
    }

    public function getFormattedCreatedAtAttribute()
    {
        return Carbon::createFromFormat('Y-m-d H:i:s', $this->attributes['created_at'])
            ->format('Y/n/d g:i A');
    }

    public function bidrequests()
    {
        return $this->hasMany(Bidrequest::class);
    }
}
