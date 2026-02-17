<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreCommentRequest;
use App\Models\Comment;
use App\Models\Post;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class PostsController extends Controller
{
    public function index(): View
    {
        $posts = Post::paginate(15);

        return view('posts.index', compact('posts'));
    }

    public function show(Post $post): View
    {
        return view('posts.show', compact('post'));
    }

    public function commentStore(StoreCommentRequest $request, Post $post): RedirectResponse
    {
        $data = $request->validated();

        Comment::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'body' => $data['body'],
            'post_id' => $post->id
        ]);

        return redirect()->route('posts.show', $post)->with('success');
    }
}
