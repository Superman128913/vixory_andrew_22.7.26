<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\Searches\SearchUsersRequest;
use App\Models\BlogPost;


class SitemapController extends Controller
{
    public function index()
    {
        $posts = BlogPost::all();
        return response()->view('sitemap', [
            'posts' => $posts
        ])->header('Content-Type', 'text/xml');        
    }
}