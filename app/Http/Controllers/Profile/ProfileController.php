<?php

namespace App\Http\Controllers\Profile;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Comment;
use App\Models\Post;
use App\User;
use Auth;
use Log;

class ProfileController extends Controller
{
    
    public function index($username)
    {

        $user = User::where('username', $username)->first();

        if(! $user) {
            return redirect('home');
        }

        $posts = Post::with(['user', 'comments.user'])
                        ->where('user_id', $user->id)
                        ->orderBy('id', 'desc')
                        ->get();

        return view('profile.home', get_defined_vars());

    }
    
    
}
