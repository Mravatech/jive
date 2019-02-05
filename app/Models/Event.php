<?php

namespace App\Models;

use \Illuminate\Database\Eloquent\Model as Model;
use Illuminate\Database\Eloquent;

class Event extends Model
{
    protected $table = "events"; 
    protected $fillable = ['name', 'description', 'logo', 'cover', 'created_by', 'max_usage', 'start_date', 'end_date', 'type'];
}