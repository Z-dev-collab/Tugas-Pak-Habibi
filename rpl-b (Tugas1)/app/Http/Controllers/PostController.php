<?php

namespace App\Http\Controllers;

use App\Models\Post;
use Illuminate\Http\Request;
use Illuminate\View\View;

class PostController extends Controller
{
    public function index()
    {
        $posts =  Post::all();
        return view('posts.index', compact('posts'));
    }

    public function create()
    {
        return view('posts.create');
    }

    public function store(Request $request)
    {
       $validated  = $request->validate([
        'title' => 'required|string|max:255',
        'content' => 'required|string|max:255',
       ]);
       
       Post::create($validated);
         return redirect()->route('posts.index');
    }
}
