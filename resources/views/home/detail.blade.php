@extends('layouts.default')
@section('content')
    <div class="about_main">
        <div class="services_main">
            <div class="container">
                <div class="creative_taital">
                    <h1 class="creative_text">{{ $article->title }}</h1>
                    <p style="color: #050000; text-align: center;">{!! html_entity_decode($converter->convert($article->content), ENT_QUOTES, 'UTF-8') !!}</p>
                </div>
            </div>
        </div>
    </div>
@endsection
