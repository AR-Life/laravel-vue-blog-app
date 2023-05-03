<?php

namespace App\Http\Controllers;

use App\Models\Blog;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;


class BlogController extends Controller
{
    /**
     * Display a listing of the resource.
     */

    public function index(Request $reques, $rows)
    {
        $blogs = DB::table('blogs')
            ->join('users', 'users.id', '=', 'blogs.user_id')
            ->select('blogs.*', 'users.name')
            ->orderBy('blogs.created_at', 'desc')
            ->skip(intval($rows)-12)
            ->take(12)
            ->get();

        return response()->json($blogs);

    }

    public function getUserIndex(Request $reques, $user_id, $rows)
    {
        $blogs = DB::table('blogs')
            ->join('users', 'users.id', '=', 'blogs.user_id')
            ->select('blogs.*', 'users.name')
            ->where('users.id', '=', intval($user_id))
            ->orderBy('blogs.created_at', 'desc')
            ->skip(intval($rows)-12)
            ->take(12)
            ->get();

        return response()->json($blogs);

    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        Blog::create([
            'title' => $request->title,
            'content' => $request->content,
            'user_id' => $request->user_id
        ]);
        return response('success', 200);
    }

    /**
     * Display the specified resource.
     */
    public function show(Blog $blog)
    {
        $blogWithUser = $blog->load('user');

        return response()->json($blogWithUser);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Blog $blog)
    {
        return response()->json($blog);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Blog $blog)
    {
        $validatedData = $request->validate([
            'title' => 'required|string',
            'content' => 'required|string',
        ]);

        $blog->title = $validatedData['title'];
        $blog->content = $validatedData['content'];

        $blog->save();

        return response()->json(['success' => true], 200);
    }


    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Blog $blog)
{
    $blog->delete();

    return response()->json(['success' => true], 200);
}

    /*
    * List length
    */

    public function count(Request $request)
    {
        $blog = DB::table('blogs')
        ->get()
        ->count('id');

        return response()->json($blog);
    }

    /*
    * User's List length
    */

    public function getUserCount(Request $request, $user_id)
    {
        $blog = DB::table('blogs')
        ->where('user_id','=',intval($user_id))
        ->get()
        ->count('id');

        return response()->json($blog);
    }
}
