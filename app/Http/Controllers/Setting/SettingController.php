<?php

namespace App\Http\Controllers\Setting;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Comment;
use App\Models\Post;
use App\Models\UserFollowing;
use App\User;
use Auth;
use Log;

class SettingController extends Controller
{
    
    public function index()
    {
        $user = Auth::user();

        $unfollowingUsers = unfollowingUserList();

        return view('settings.home', get_defined_vars());

    }
    
    public function store(Request $request)
    {
        $this->validate($request, [
            'name' => ['required', 'string', 'max:255'],
            'username' => ['required', 'string', 'max:255', 'unique:users,username,'.Auth::id()],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users,email,'.Auth::id()],
            'file' => ['nullable', 'mimes:jpeg,jpg,png,gif', 'max:50000']
        ]);

        if($request->hasFile('file')) {
            $extension = $request->file('file')->getClientOriginalExtension();
            $imageName = "user_".Auth::id().'.'.$extension;
            $destinationPath = 'user_images/';
            $request->file('file')->move($destinationPath, $imageName);

            $request->request->add(['profile_photo' => $imageName]);
        }

        User::where('id', Auth::id())
            ->update($request->except(['file', '_token']));

        return redirect()->back();
    }
    
}
