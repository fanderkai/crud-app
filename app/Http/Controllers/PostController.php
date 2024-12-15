<?php

namespace App\Http\Controllers;

use App\Models\Post;
use Inertia\Inertia;
use Illuminate\Support\Facades\Redis;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class PostController extends Controller
{
    public function index()
    {
        $cachedPosts = Redis::get('posts');
        if ($cachedPosts) {
            $posts = json_decode($cachedPosts, true);
        } else {
            $posts = Post::all();
            Redis::setex('posts', 600, json_encode($posts));
        }

        return Inertia::render('Post/Index', ['posts' => $posts]);
    }
    
    public function create()
    {
        return Inertia::render('Post/Create');
    }

    public function store(Request $request)
    {
        $post = new Post($request->all());
        $post->save();
        Redis::del('posts');
        return redirect()->route('posts.index');
    }

    public function destroy(Post $post)
    {
        $post->delete();
        Redis::del('posts');
        return redirect()->back();
    }

    public function edit(Post $post)
    {
        return Inertia::render('Post/Create', ['post' => $post, 'isUpdating' => true]);
    }

    public function update(Request $request, Post $post)
    {
        $post->update($request->all());
        Redis::del('posts');
        return redirect()->route('posts.index');
    }
}
