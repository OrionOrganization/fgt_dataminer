<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Models\BlogPost;

class BlogPostController extends Controller
{
    public function index()
    {
        $blogPosts = BlogPost::all();

        return view(backpack_view('blog'))->with(compact('blogPosts'));
    }
}