<?php

namespace App\Http\Controllers\Comment;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Comment;
use App\Models\Post;
use App\User;
use Auth;
use Log;

class CommentController extends Controller
{
    
    public function index()
    {
        //
    }

    
    public function create()
    {
        //
    }

    
    public function store(Request $request, Comment $comment)
    {
        $this->validate($request, [
                'comment' => 'required',
                'post_id' => 'required'
            ]);

        $request['user_id'] = Auth::id();

        $comment = $comment->create($request->all());

        $comment->user_info = Auth::user();

        $comment->formatted_date = dayBefore($comment->created_at);

        return response()->json(['error' => false, 'data' => $comment]);

    }
    public function show($id)
    {
        //
    }
    public function edit($id)
    {
        //
    }

    
    public function update(Request $request, Comment $comment)
    {
        $this->validate($request, [
                'comment' => 'required',
            ]);

        if(Auth::id() != $comment->user_id) {
            return response()->json(['error' => true, 'msg' => 'You are not able to edit this comment']);
        }

        $comment->update($request->all());

        return response()->json(['error' => false, 'data' => $comment]);
    }

    public function destroy(Comment $comment)
    {
        if($comment) {
            if($comment->user_id != Auth::id()) {
                return response()->json(['error' => true, 'msg' => 'You are not able to delete this comment']);
            }

            Comment::where('comment_id', $comment->id)->delete();
            $comment->delete();

            return response()->json(['error' => false]);
        } else {
            return response()->json(['error' => true, 'msg' => 'Comment not exists.']);
        }
    }

    public function load_reply(Request $request) {
        $this->validate($request, [
                'comment_id' => 'required',
                'thread_id' => 'required',
            ]);
        
        $reply_comments = Comment::where('thread_id', $request->thread_id)->where('comment_id', $request->comment_id)->get();

        foreach ($reply_comments as $reply_comment) {
            $reply_comment->count_reply_comment = count_reply($reply_comment->id, $reply_comment->thread_id);
            $reply_comment->user_info = User::find($reply_comment->user_id);
        }

        return response()->json(['error' => false, 'data' => $reply_comments]);
    }

    public function reply_store(Request $request) {
        $this->validate($request, [
                'comment' => 'required',
                'thread_id' => 'required',
                'comment_id' => 'required',
            ]);

        $request['user_id'] = Auth::id();

        $reply_comment = Comment::create($request->all());

        $reply_comment->count_reply_comment = count_reply($reply_comment->id, $reply_comment->thread_id);
        $reply_comment->user_info = User::find($reply_comment->user_id);

        return response()->json(['error' => false, 'data' => $reply_comment]);
    }
}
