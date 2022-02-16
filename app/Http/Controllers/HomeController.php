<?php

namespace App\Http\Controllers;

use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use League\CommonMark\CommonMarkConverter;

class HomeController extends Controller
{
    /**
     * @param Request $request
     * @return void
     */
    public function index(Request $request)
    {
        $articles = DB::table('articles')
            ->where('status', 1)
            ->where('published', '<=', \Carbon\Carbon::now()->toDateTimeString())
            ->orderBy('created_at', 'DESC')
            ->paginate(15);
        return view('home.index', ['articles' => $articles]);
    }

    /**
     * @param Request $request
     * @return Application|Factory|View|RedirectResponse
     */
    public function detail(Request $request): View|Factory|RedirectResponse|Application
    {
        // For markdown syntax converter
        $converter = new CommonMarkConverter([
            'html_input' => 'strip',
            'allow_unsafe_links' => false,
        ]);

        // Get data from database
        $article = DB::table('articles')
            ->where('id', $request->blog_id)
            ->where('status', 1)->first();

        // If found
        if ($article) {
            return view('home.detail', ['article' => $article, 'converter' => $converter]);
        } else { // Not found or unpublished yet
            return redirect()->intended('/');
        }
    }
}
