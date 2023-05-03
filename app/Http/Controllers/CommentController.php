<?php

namespace App\Http\Controllers;

use App\Models\Comment;
use App\Models\Blog;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class CommentController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request, $blog_id, $rows)
    {
        $comments = DB::table('comments')
        ->leftJoin('users', 'users.id', '=', 'comments.user_id')
        ->join('blogs', 'blogs.id', '=', 'comments.blog_id')
        ->select('comments.*', 'users.name')
        ->where('blogs.id', '=', $blog_id)
        ->orderBy('comments.created_at', 'desc')
        ->skip(intval($rows)-10)
        ->take(10)
        ->get();


        return response()->json($comments);
    }


    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $comment = Comment::create([
                'user_id' => $request->user_id,
                'blog_id' => $request->blog_id,
                'comment' => $request->comment,
            ]);
            $lastComment = DB::table('comments')
            ->join('users', 'users.id', '=', 'comments.user_id')
            ->join('blogs', 'blogs.id', '=', 'comments.blog_id')
            ->select('comments.*', 'users.name')
            ->where('comments.id', '=', $comment->id)
            ->first();
            return response()->json($lastComment);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Comment $comment)
    {
        $validatedData = $request->validate([
            'comment' => 'required|string',
        ]);

        $comment->comment = $validatedData['comment'];

        $comment->save();

        return response()->json(['success' => true], 200);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Comment $comment)
    {
        $comment->delete();
        return response()->json(['success' => true], 200);
    }

    /*
    * List length
    */

    public function count(Request $request, $blog_id)
    {
        $comments = DB::table('comments')
        ->where('blog_id', '=', $blog_id)
        ->get()
        ->count('id');



        return response()->json($comments);
    }
}
