<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Article;
use App\Models\Category;
use App\Models\Tag;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache; // Cache وارد شده
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class ArticleController extends Controller
{
    public function index()
    {
        $articles = Article::with(['category', 'user'])
            ->latest()
            ->paginate(10);
            
        return view('admin.articles.index', compact('articles'));
    }

    public function create()
    {
        $categories = Category::all();
        $tags = Tag::all();
        return view('admin.articles.create', compact('categories', 'tags'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|max:255',
            'content' => 'required',
            'excerpt' => 'nullable',
            'category_id' => 'nullable|exists:categories,id',
            'tags' => 'nullable|array',
            'tags.*' => 'exists:tags,id',
            'featured_image' => 'nullable|image|max:2048',
            'status' => 'required|in:draft,published,scheduled',
            'published_at' => 'nullable|date',
        ]);
        
        if ($validated['status'] === 'published' && empty($validated['published_at'])) {
            $validated['published_at'] = now();
        }
        
        if ($request->hasFile('featured_image')) {
            $path = $request->file('featured_image')->store('articles', 'public');
            $validated['featured_image'] = $path;
        }
        
        $article = Article::create([
            'title' => $validated['title'],
            'slug' => Str::slug($validated['title']),
            'excerpt' => $validated['excerpt'] ?? null,
            'content' => $validated['content'],
            'category_id' => $validated['category_id'] ?? null,
            'user_id' => auth()->id(),
            'featured_image' => $validated['featured_image'] ?? null,
            'status' => $validated['status'],
            'published_at' => $validated['published_at'] ?? null,
        ]);
        
        if (isset($validated['tags'])) {
            $article->tags()->sync($validated['tags']);
        }
        
        return redirect()
            ->route('admin.articles.index')
            ->with('success', 'مقاله با موفقیت ایجاد شد.');
    }

    public function show(Article $article)
    {
        if (!$article->isPublishedOrScheduled()) {
            abort(404);
        }
        
        $article->increment('views');
        
        $relatedArticles = Cache::remember('related_articles_' . $article->id, now()->addHours(3), function () use ($article) {
            return Article::published()
                ->with(['category', 'user', 'tags'])
                ->where('id', '!=', $article->id)
                ->where(function ($query) use ($article) {
                    $query->where('category_id', $article->category_id)
                        ->orWhereHas('tags', function ($q) use ($article) {
                            $q->whereIn('id', $article->tags->pluck('id'));
                        });
                })
                ->take(5)
                ->get();
        });

        return view('articles.show', compact('article', 'relatedArticles'));
    }

    public function edit(Article $article)
    {
        $categories = Category::all();
        $tags = Tag::all();
        return view('admin.articles.edit', compact('article', 'categories', 'tags'));
    }

    public function update(Request $request, Article $article)
    {
        $validated = $request->validate([
            'title' => 'required|max:255',
            'content' => 'required',
            'excerpt' => 'nullable',
            'category_id' => 'nullable|exists:categories,id',
            'tags' => 'nullable|array',
            'tags.*' => 'exists:tags,id',
            'featured_image' => 'nullable|image|max:2048',
            'status' => 'required|in:draft,published,scheduled',
            'published_at' => 'nullable|date',
            'remove_image' => 'nullable|boolean',
        ]);
        
        if ($validated['status'] === 'published' && empty($validated['published_at'])) {
            $validated['published_at'] = now();
        }
        
        if (isset($validated['remove_image']) && $validated['remove_image'] && $article->featured_image) {
            Storage::disk('public')->delete($article->featured_image);
            $article->featured_image = null;
        }
        
        if ($request->hasFile('featured_image')) {
            if ($article->featured_image) {
                Storage::disk('public')->delete($article->featured_image);
            }
            $path = $request->file('featured_image')->store('articles', 'public');
            $article->featured_image = $path;
        }
        
        $article->update([
            'title' => $validated['title'],
            'slug' => Str::slug($validated['title']),
            'excerpt' => $validated['excerpt'] ?? null,
            'content' => $validated['content'],
            'category_id' => $validated['category_id'] ?? null,
            'status' => $validated['status'],
            'published_at' => $validated['published_at'] ?? null,
        ]);
        
        if (isset($validated['tags'])) {
            $article->tags()->sync($validated['tags']);
        } else {
            $article->tags()->detach();
        }
        
        return redirect()
            ->route('admin.articles.index')
            ->with('success', 'مقاله با موفقیت بروزرسانی شد.');
    }

    public function destroy(Article $article)
    {
        if ($article->featured_image) {
            Storage::disk('public')->delete($article->featured_image);
        }
        
        $article->delete();
        
        return redirect()
            ->route('admin.articles.index')
            ->with('success', 'مقاله با موفقیت حذف شد.');
    }

    public function category(Category $category)
    {
        $articles = $category->articles()
            ->where('status', 'published')
            ->latest()
            ->paginate(10);

        return view('articles.category', compact('category', 'articles'));
    }
}