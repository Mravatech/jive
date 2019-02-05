<?php
/**
 * Created by PhpStorm.
 * User: codeliter
 * Date: 2/5/19
 * Time: 11:13 AM
 */

namespace App\Models;


use Illuminate\Database\Eloquent\Model;

class LinksLog extends Model
{
    protected $table = 'links_log';
    protected $fillable = ['uuid', 'event_id','link_id','user_id'];
}