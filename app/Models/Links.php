<?php
/**
 * Created by PhpStorm.
 * User: codeliter
 * Date: 2/5/19
 * Time: 11:09 AM
 */

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Links extends Model
{
    protected $table = 'links';
    protected $fillable = ['uuid','event_id', 'created_by', 'link', 'visit_count'];
}