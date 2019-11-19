<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class UserFollowing extends Model
{
    protected $table = 'user_following';

    protected $fillable = [ "user_id", 'following_user_id'];

    public function user()
    {
    	return $this->belongsTo('App\User');
    }

    public function following_user()
    {
    	return $this->belongsTo('App\User', 'following_user_id');
    }

}
