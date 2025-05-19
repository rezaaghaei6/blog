<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Article;
use App\Models\Category;
use App\Models\Tag;

class DashboardController extends Controller
{
    public function index()
    {
        $stats = [
            'articles_count' => Article::count(),
            'published_articles_count' => Article::where('status', 'published')->count(),
            'categories_count' => Category::count(),
            'tags_count' => Tag::count(),
        ];

        $recent_articles = Article::latest()->take(5)->get();

        return view('admin.dashboard', compact('stats', 'recent_articles'));
    }
}