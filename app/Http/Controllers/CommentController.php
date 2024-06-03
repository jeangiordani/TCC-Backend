<?php

namespace App\Http\Controllers;

use App\Models\Comment;
use Illuminate\Http\Request;

class CommentController extends Controller
{
    // api
    public function index($questionId)
    {
        return Comment::with('user', 'question')->where('question_id', $questionId)->get();
    }


    public function store(Request $request)
    {
        $request->validate([
            'text' => 'required|string',
            'user_id' => 'required|exists:users,id',
            'question_id' => 'required|exists:questions,id',
        ]);

        $comment = new Comment();
        $comment->text = $request->text;
        $comment->user_id = $request->user_id;
        $comment->question_id = $request->question_id;
        $comment->save();
        return $comment;
    }

    public function show($id)
    {
        return Comment::find($id);
    }

    public function update(Request $request, $id)
    {
        $comment = Comment::find($id);
        $comment->text = $request->text;
        $comment->user_id = $request->user_id;
        $comment->question_id = $request->question_id;
        $comment->save();
        return $comment;
    }

    public function destroy($id)
    {
        $comment = Comment::find($id);
        $comment->delete();
        return $comment;
    }

    
}
