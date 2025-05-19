<?php

namespace App\Http\Controllers;

use App\Models\Article;
use App\Models\Category;
use App\Models\Tag;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;

class ArticleController extends Controller
{
    /**
     * نمایش لیست مقالات
     */
    public function index()
    {
        // استفاده از کش برای بهبود عملکرد
        $articles = Cache::remember('articles_page_' . request()->get('page', 1), now()->addMinutes(10), function () {
            return Article::with(['category', 'user', 'tags'])
                ->published()
                ->latest('published_at')
                ->paginate(10);
        });
                          
        $categories = Cache::remember('categories_with_count', now()->addHours(6), function () {
            return Category::withCount(['articles' => function($query) {
                $query->published();
            }])
            ->orderBy('name')
            ->get();
        });
        
        $tags = Cache::remember('tags_with_count', now()->addHours(6), function () {
            return Tag::withCount(['articles' => function($query) {
                $query->published();
            }])
            ->having('articles_count', '>', 0)
            ->orderBy('name')
            ->get();
        });
        
        return view('articles.index', compact('articles', 'categories', 'tags'));
    }
    
    /**
     * نمایش یک مقاله
     */
    public function show(Article $article)
    {
        // بررسی وضعیت انتشار مقاله
        if (!$article->isPublishedOrScheduled()) {
            abort(404);
        }
        
        // افزایش تعداد بازدید
        $article->increment('views');
        
        // دریافت مقالات مرتبط
        $relatedArticles = Cache::remember('related_articles_' . $article->id, now()->addHours(3), function () use ($article) {
            return Article::published()
                ->with(['category', 'user', 'tags'])
                ->where('id', '!=', $article->id)
                ->where(function($query) use ($article) {
                    $query->where('category_id', $article->category_id)
                        ->orWhereHas('tags', function($q) use ($article) {
                            $q->whereIn('id', $article->tags->pluck('id'));
                        });
                })
                ->latest('published_at')
                ->limit(3)
                ->get();
        });
                                 
        return view('articles.show', compact('article', 'relatedArticles'));
    }
    
    /**
     * نمایش مقالات یک دسته‌بندی خاص
     */
    public function byCategory(Category $category)
    {
        $articles = Article::with(['category', 'user', 'tags'])
            ->published()
            ->where('category_id', $category->id)
            ->latest('published_at')
            ->paginate(10);
            
        $popularArticles = Article::published()
            ->where('category_id', $category->id)
            ->orderByDesc('views')
            ->limit(5)
            ->get();
                          
        return view('articles.by_category', compact('articles', 'category', 'popularArticles'));
    }
    
    /**
     * نمایش مقالات یک برچسب خاص
     */
    public function byTag(Tag $tag)
    {
        $articles = $tag->articles()
            ->with(['category', 'user', 'tags'])
            ->published()
            ->latest('published_at')
            ->paginate(10);
                       
        return view('articles.by_tag', compact('articles', 'tag'));
    }
    
    /**
     * جستجو در مقالات
     */
    public function search(Request $request)
    {
        $query = $request->input('query');
        
        // بررسی اعتبار کوئری جستجو
        if (empty($query) || strlen($query) < 3) {
            return redirect()->route('home')
                ->with('error', 'عبارت جستجو باید حداقل ۳ کاراکتر باشد.');
        }
        
        // جستجوی مقالات با استفاده از پارامترهای bind شده برای امنیت بیشتر
        $articles = Article::with(['category', 'user', 'tags'])
            ->published()
            ->where(function($q) use ($query) {
                $q->whereRaw('LOWER(title) LIKE ?', ['%' . strtolower($query) . '%'])
                    ->orWhereRaw('LOWER(content) LIKE ?', ['%' . strtolower($query) . '%'])
                    ->orWhereRaw('LOWER(excerpt) LIKE ?', ['%' . strtolower($query) . '%']);
            })
            ->latest('published_at')
            ->paginate(10);
            
        // حفظ کوئری جستجو در پیجینیشن
        $articles->appends(['query' => $query]);
                          
        return view('articles.search', compact('articles', 'query'));
    }
    
    /**
     * نمایش آرشیو مقالات بر اساس سال و ماه
     */
    public function archive($year, $month = null)
    {
        $articlesQuery = Article::published()->whereYear('published_at', $year);
        
        if ($month) {
            $articlesQuery->whereMonth('published_at', $month);
        }
        
        $articles = $articlesQuery->latest('published_at')->paginate(10);
        
        return view('articles.archive', compact('articles', 'year', 'month'));
    }
}