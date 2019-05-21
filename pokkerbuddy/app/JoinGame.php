<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class JoinGame extends Model             
{
    
    protected $fillable = ['user_id','game_id','status','out_status','game_host_id','type','show_data','u_id','h_id','type_key'];              
}  