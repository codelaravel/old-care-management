<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Profile extends Model
{
    protected $fillable = ['user_id', 'location', 'about'];


    public function user()
    {
        $this->belongsTo('App\User');
    }
}
