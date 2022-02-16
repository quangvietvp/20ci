<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class ArticlesController extends Controller
{
    /**
     * ArticlesController constructor.
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        // Parse parameter
        $status = $request->status?? 'ASC';
        $status = (strtoupper($status) == 'ASC' || strtoupper($status) == 'DESC')? $status : 'ASC';

        $created = $request->created?? 'DESC';
        $created = (strtoupper($created) == 'ASC' || strtoupper($created) == 'DESC')? $created : 'DESC';

        // Get data from database
        $q = DB::table('articles')
                    ->where('user_id', Auth::id())
                    ->orderBy('status', $status)
                    ->orderBy('created_at', $created);

        $params = [
            'status' => (strtoupper($status) == 'ASC')? 'DESC' : 'ASC',
            'created' => (strtoupper($created) == 'ASC')? 'DESC' : 'ASC',
        ];

        // Filtering by status
        if (isset($request->status_filtering)) {
            $status_filtering = $request->status_filtering;
            if ($status_filtering == 1 || $status_filtering == 0) {
                $q->where('status', $status_filtering);
                $params['status_filtering'] = $status_filtering;
            }
        }

        // Filtering by published date
        if (isset($request->published_filtering)) {
            $q->whereDate('published', '=', \Carbon\Carbon::parse($request->published_filtering)->format('Y-m-d'));
            $params['published_filtering'] = $request->published_filtering;
        } else {
            $params['published_filtering'] = NULL;
        }
        $articles = $q->paginate(20);

        $params['articles'] = $articles;
        return view('blog.index', $params);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('blog.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $duplicate = DB::table('articles')->where('title', $request->title)->first();
        if ($duplicate) {
            return redirect('/blog')->withErrors('Title already exists.')->withInput();
        }

        $queryState = DB::table('articles')->insert(
            [
                'user_id' => Auth::id(),
                'title' => $request->title,
                'content' => $request->content,
                'status' => 0,
                'created_at' => \Carbon\Carbon::now()->format('Y-m-d h:i:s'),
                'updated_at' => \Carbon\Carbon::now()->format('Y-m-d h:i:s')
            ]
        );

        // Checking insert
        if ($queryState) {
            return redirect('blog');
        } else {
            return redirect('blog/create')->withErrors('Create article failed')->withInput();
        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $article = DB::table('articles')->where('id', $id)->first();
        if (Auth::user()->role != 'Admin' && Auth::id() != $article->user_id) {
            return redirect('blog')->withErrors(['message' => 'You dont have permission']);
        }
        return view('blog.edit', ['article' => $article]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $params = [
            'title' => $request->title,
            'content' => $request->content,
            'updated_at' => \Carbon\Carbon::now()->format('Y-m-d h:i:s')
        ];

        // Checking role
        $user = Auth::user();
        if ($user['role'] == 'Admin') { // If user is admin
            if (isset($request->status)) {
                $params['status'] = $request->status;
            } else {
                $params['status'] = 0;
            }

            if (isset($request->published)) {
                $params['published'] = $request->published;
            } else {
                $params['published'] = NULL;
            }
        } else { // Checking owner
            $article = DB::table('articles')->where('id', $id)->first();
            if ($user->id != $article->user_id) {
                return redirect('blog')->withErrors(['message' => 'You dont have permission']);
            }
        }

        $queryState = DB::table('articles')
            ->where('id', $id)
            ->update($params);

        // Checking insert
        if ($queryState) {
            return redirect('blog');
        } else {
            return redirect('blog/' . $id . '/0update')->withErrors('Update article failed')->withInput();
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $user = Auth::user();
        if ($user['role'] == 'Admin') { // If admin
            DB::table('articles')
                ->where('id', $id)
                ->delete();
        } else {
            DB::table('articles')
                ->where('id', $id)
                ->where('user_id', $user['id'])
                ->delete();
        }
        return redirect('/blog');
    }
}
