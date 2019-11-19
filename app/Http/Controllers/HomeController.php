<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Post;
use App\User;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        // $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $userCount = User::count();
        
        if($userCount == 0) {
            return redirect('register');
        }

        $posts = Post::with(['user', 'comments.user'])->orderBy('id', 'desc')->get();

        $unfollowingUsers = unfollowingUserList();

        return view('home', get_defined_vars());
    }
}
