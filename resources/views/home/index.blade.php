@extends('layouts.default')
@section('content')
    <div class="row">
        <div class="col-sm-12">
            <h1 class="blog_text">Our Blog</h1>
        </div>
    </div>

    <div class="blog_section_2">
        <div class="row">
            @foreach ($articles as $article)
            <div class="col-sm-4 article_section">
                <div class="section_1">
                    <div><img src="images/code.jpg" style="max-width: 100%;"></div>
                    <button type="button" class="date-bt">{{ \Carbon\Carbon::parse($article->created_at)->format('d, M Y') }}</button>
                    <p>{{ \Illuminate\Support\Str::limit($article->content, 120) }}</p>
                    <p><a href="{{ route('home.detail', ['blog_id' =>$article->id]) }}" class="btn-link">Detail</a></p>
                </div>
            </div>
            @endforeach
        </div>
    </div>
    {{ $articles->links() }}
@endsection
