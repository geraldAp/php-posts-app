<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Post;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{



    public function index()
    {
        $posts = Auth::user()->posts()->latest()->paginate(6); // get the authenticated users posts
        return view('users.dashboard', ['posts' => $posts]);
    }

    public function userPosts(User $user)
    {

        $posts =  $user->posts()->latest()->paginate(6);

        return view('users.posts' ,['posts' =>$posts,'user' => $user]);
    }
}
