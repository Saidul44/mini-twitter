<?php

namespace App\Http\Controllers\Post;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Post;
use Session;
use Auth;

class PostController extends Controller
{
    
    public function index()
    {
        $posts = Post::with(['user', 'comments.user'])->orderBy('id', 'desc')->get();

        return view('home', get_defined_vars());
    }

    public function store(Request $request)
    {

        $this->validate($request, [
            'post_content' => 'required',
            'file' => 'required|image'
        ]);

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
