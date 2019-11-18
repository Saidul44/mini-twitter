<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Comment extends Model
{
    protected $table = 'comments';

    protected $fillable = ['comment_id', "user_id", 'post_id', 'comment', 'photo'];

    public function user()
    {
    	return $this->belongsTo('App\User');
    }

    public function post()
    {
    	return $this->belongsTo('App\Models\Post');
    }

}
