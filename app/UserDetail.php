<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\User;
class UserDetail extends Model
{
    // ho una relazione 1 a 1
    // questa è la parte dipendente della relazione, cioè quella che ha la FK
    public function user() {
        return $this->belongsTo('App\User');
    }
}
