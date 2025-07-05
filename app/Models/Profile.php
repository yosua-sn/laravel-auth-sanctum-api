<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Profile extends Model
{
    protected $fillable = [
        'first_name',
        'last_name',
        'date_of_birth',
        'bio'
    ];

    public function users(){
        return $this->belongsTo(User::class);
    }
}
