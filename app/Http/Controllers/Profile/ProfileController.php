<?php

namespace App\Http\Controllers\Profile;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Comment;
use App\Models\Post;
use App\Models\UserFollowing;
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

        $followingCount = UserFollowing::where('user_id', $user->id)
                                    ->count();

        $followersCount = UserFollowing::where('following_user_id', $user->id)
                                    ->count();

        return view('profile.home', get_defined_vars());

    }
    

    public function following(Request $request, $username)
    {
        
        $user = User::where('username', $username)->first();

        if(! $user) {
            return redirect('home');
        }

        $followingUsers = UserFollowing::with('following_user')
                                    ->where('user_id', $user->id)
                                    ->orderBy('id', 'desc')
                                    ->get();

        return view('profile.following', get_defined_vars());

    }
    
    public function followers(Request $request, $username)
    {
        
        $user = User::where('username', $username)->first();

        if(! $user) {
            return redirect('home');
        }

        $followers = UserFollowing::with('user')
                                    ->where('following_user_id', $user->id)
                                    ->orderBy('id', 'desc')
                                    ->get();

        return view('profile.followers', get_defined_vars());

    }

    public function follow(Request $request, $userId)
    {
        
        $user = User::find($userId);

        if(! $user) {
            return redirect()->back();
        }

        $alreadyFollowing = UserFollowing::where('user_id', Auth::id())
                                    ->where('following_user_id', $user->id)
                                    ->first();

        if(! $alreadyFollowing) {
            UserFollowing::create([
                'user_id' => Auth::id(),
                'following_user_id' => $user->id
            ]);
        }

        return redirect()->back();

    }

    public function unfollow(Request $request, $userId)
    {
        
        $user = User::find($userId);

        if(! $user) {
            return redirect()->back();
        }

        $alreadyFollowing = UserFollowing::where('user_id', Auth::id())
                                    ->where('following_user_id', $user->id)
                                    ->first();

        if($alreadyFollowing) {
            $alreadyFollowing->delete();
        }

        return redirect()->back();

    }
    
}
