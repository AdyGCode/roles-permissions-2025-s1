<?php

namespace App\Http\Controllers;

use App\Models\Post;
use Illuminate\Http\Request;

class PostController extends Controller
{





    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {

        $validated = $request->validate([
            'search' => ['nullable', 'string',]
        ]);


        $search = $validated['search'] ?? '';


        $posts = Post::whereAny(
            ['title', 'content',], 'LIKE', "%$search%")
            ->paginate(15)
            ->appends(['search' => $search]);


        return view('posts.index')
            ->with('posts', $posts)
            ->with('search', $search);

    }



    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return "create post";
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        return $request;
    }

    /**
     * Display the specified resource.
     */
    public function show(Request $request, Post $post)
    {
        if (!$request->post() ||  $request->post()->cannot(['read own post','read any post'], Post::class)) {
            return back()->with("info","You are not permitted to read posts.");
        }

        return view('posts.show', compact(['post']));    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Post $post)
    {
        return $post;
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Post $post)
    {
        return compact($request,$post);
    }

    /**
     * Confirm the removal of the specified post.
     *
     * This is a prequel to the actual destruction of the record.
     * Put in place to provide a "confirm the action".
     *
     * @param Post $post
     */
    public function delete(Post $post)
    {
        // TODO: Update when we add Roles & Permissions

        return view("posts.delete", compact(['post',]));

    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Post $post)
    {
        return $post;
    }
}
