<?php

namespace App\Http\Controllers;

use App\Models\Article;
use App\Models\Category;
use App\Models\Tag;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    /**
     * نمایش صفحه اصلی سایت
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        // دریافت آخرین مقالات منتشر شده
        $latestArticles = Article::published()
            ->with(['category', 'user'])
            ->latest()
            ->take(6)
            ->get();
            
        // دریافت مقالات محبوب
        $featuredArticles = Article::published()
            ->with(['category', 'user'])
            ->where('is_featured', true)
            ->latest()
            ->take(2)
            ->get();
            
        // دریافت دسته‌بندی‌های محبوب
        $categories = Category::withCount('articles')
            ->orderByDesc('articles_count')
            ->take(6)
            ->get();
            
        return view('home', compact('latestArticles', 'featuredArticles', 'categories'));
    }
    
    /**
     * نمایش صفحه درباره ما
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function about()
    {
        return view('pages.about');
    }
    
    /**
     * نمایش صفحه تماس با ما
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function contact()
    {
        return view('pages.contact');
    }
    
    /**
     * پردازش فرم تماس با ما
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function sendContact(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'subject' => 'required|string|max:255',
            'message' => 'required|string',
        ]);
        
        // در اینجا می‌توانید پیام را به ایمیل مدیر سایت ارسال کنید
        // یا در دیتابیس ذخیره کنید
        
        return back()->with('success', 'پیام شما با موفقیت ارسال شد. به زودی با شما تماس خواهیم گرفت.');
    }
}