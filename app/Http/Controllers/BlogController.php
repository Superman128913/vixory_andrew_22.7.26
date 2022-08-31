<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\BlogPost;
use App\Models\BlogCategory;

class BlogController extends Controller
{
    public function list()
    {
        $posts = BlogPost::with(["blog_category"])->paginate(20);
        return response()->json($posts, 200);
    }

    public function categories()
    {
        $categories = BlogCategory::all();
        return response()->json($categories, 200);
    }

    public function recent()
    {
        $posts = BlogPost::latest()->limit(4)->get();
        return response()->json($posts, 200);
    }

    public function featured()
    {
        $featured = BlogPost::where("is_featured", 1)->first();
        return response()->json($featured, 200);
    }

    public function single(Request $request)
    {
        $blog = BlogPost::where("title", 'like', $request->title . '%')->with(["blog_category"])->first();
        return response()->json($blog, 200);
    }
}
