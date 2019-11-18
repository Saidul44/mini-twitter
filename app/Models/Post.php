<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
    protected $table = 'posts';

    protected $fillable = ["user_id", 'content', 'photo'];

  	public function user()
    {
    	return $this->belongsTo('App\User');
    }

    public function comments()
    {
    	return $this->hasMany('App\Models\Comment');
    }
}
