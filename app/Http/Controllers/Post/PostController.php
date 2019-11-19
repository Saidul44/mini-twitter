<?php

namespace App\Http\Controllers\Post;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Post;
use App\Models\UserFollowing;
use App\User;
use Session;
use Auth;

class PostController extends Controller
{
    
    public function index()
    {
        
    }

    public function store(Request $request)
    {

        logger($request->all());

        $this->validate($request, [
            'post_content' => ['required'],
        ]);

        if($request->hasFile('file')) {
            $this->validate($request, [
                'file' => 'image|max:50000'
            ]);    
        }

        $post = Post::create([
                            'user_id' => Auth::id(),
                            'content' => $request->post_content
                        ]);

        if($request->hasFile('file')) {

            $extension = $request->file('file')->getClientOriginalExtension();
            $imageName = "post_$post->id.$extension";
            $destinationPath = 'post_images/';
            $request->file('file')->move($destinationPath, $imageName);

            $post->update([
                'photo' => $imageName
            ]);
        }

        return  response()->json([
            'error' => false,
            'msg' => 'Successfully added a new post'
        ]);
    }
}
