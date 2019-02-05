<?php

namespace App\Models;

use \Illuminate\Database\Eloquent\Model as Model;
use Illuminate\Database\Eloquent;

class Users extends Model
{
    protected $table = "users"; 
    protected $fillable = ['username', 'email', 'phone_number', 'fname', 'lname', 'profile_picture'];
    
}