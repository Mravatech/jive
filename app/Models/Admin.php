<?php

namespace App\Models;

use \Illuminate\Database\Eloquent\Model as Model;
use Illuminate\Database\Eloquent;

class Admin extends Model
{
    protected $table = "admin"; 
    protected $fillable = ['username', 'email', 'phone_number', 'fname', 'lname', 'profile_picture', 'start_date', 'end_date', 'type'];
}