<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Game_play extends Model             
{
    
    protected $fillable = ['id','user_id','host_id','point','game_id','status','out_status','created_at','updated_at'];              
}  