<?php

namespace App\Http\Controllers;


use App\Models\Post;
use App\Models\User;
use Illuminate\Routing\Controllers\HasMiddleware;
use Illuminate\Routing\Controllers\Middleware;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class PostController extends Controller implements HasMiddleware
{

    // applying certain middle =wars to different methods
    public static function middleware(): array
    {
        return [
            // new Middleware('auth', only: ['store']), //you need to be authenticated to use this method
            new Middleware('auth', except: ['index', 'show']), //everything you need authorization except index and show
        ];
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // instead of get we use paginate so we can paginate the data
        $posts = Post::orderBy('created_at', 'desc')->paginate(6);
        return view('posts.index', ['posts' => $posts]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // storing a file we can use the Storage from facades
        // chaining the disk method so that we ca use the public drive to store the image so it iis accessible publicly
        Storage::disk('public')->put('posts_images', $request->image);



        // Validate
        $fields = $request->validate([
            'title' => ['required', 'max:225'],
            'body' => ['required', 'min:10']
        ]);

        // create the post using the user instance
        Auth::user()->posts()->create($fields);


        // redirect
        return back()->with('success', 'Your post was created');
    }

    /**
     * Display the specified resource.
     */
    public function show(Post $post)
    {
        return view('posts.show', ['post' => $post]);
    }

    public function testing()
    {
        return dd('this works');
    }
    public function edit(Post $post)
    {
        // adding a policy to an edit function to ensure only authorized users are allowed to modify the posts
        Gate::authorize('modify', $post);
        return view('posts.edit', ['post' => $post]);
    }
    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Post $post)
    {
        Gate::authorize('modify', $post);
        $fields = $request->validate([
            'title' => ['required', 'max:225'],
            'body' => ['required', 'min:10']
        ]);

        // update the post
        $post->update($fields);


        // redirect
        return redirect()->route('dashboard')->with('success', 'Your post was updated');
    }


    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Post $post)
    {
        Gate::authorize('modify', $post);
        $post->delete();

        return back()->with('delete', 'Your post was deleted!');
    }
}
