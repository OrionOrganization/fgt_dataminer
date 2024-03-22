<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Models\BlogPost;

class BlogPostController extends Controller
{
    public function index()
    {
        $blogPosts = BlogPost::all();

        return view('blog')->with(compact('blogPosts'));
    }

    public function show(BlogPost $model)
    {
        $model->views += 1;
        $model->save();

        return view('blog_show')->with(compact('model'));
    }
}
