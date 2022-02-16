@extends('layouts.default')
@section('header-scripts')
<script src="https://cdn.tiny.cloud/1/3o0l8m4axf5cpjwd993mwksj6f7plpadk1c3bypqr4g0ppkn/tinymce/5/tinymce.min.js" referrerpolicy="origin"></script>
@endsection
@section('content')
    <div class="panel">
        <div class="panel-body container-fluid">
            <div class="row row-lg">
                @include('sections.left_menu')
                <div class="col-md-8">
                    <div class="card card-primary">
                        <div class="card-header">
                            <h3 class="card-title">Edit Article</h3>
                        </div>
                        <form action="/blog/{{ $article->id }}" method="POST">
                            @if ($errors->any())
                                <div class="alert alert-danger">
                                    <ul>
                                        @foreach ($errors->all() as $error)
                                            <li>{{ $error }}</li>
                                        @endforeach
                                    </ul>
                                </div>
                            @endif
                            @csrf
                            @method('PUT')
                            <div class="card-body">
                                <div class="form-group">
                                    <label for="exampleInputEmail1">Title</label>
                                    <input type="input" class="form-control" id="inputTitle" placeholder="Enter email" autocomplete="off" name="title" value="{{ $article->title }}" />
                                </div>
                                <div class="form-group">
                                    <label for="exampleInputPassword1">Content</label>
                                    <textarea class="form-control" name="content">{{ $article->content }}</textarea>
                                </div>
                                @if (Auth::user()->role == 'Admin')
                                    <div class="form-group">
                                        <div class="form-check">
                                            <input id="inputStatus" class="form-check-input" type="checkbox" value="1" @if ($article->status == 1) checked="checked" @endif name="status"/>
                                            <label for="inputStatus" class="form-check-label">Approve status</label>
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label for="inputPublished" class="col-sm-2 col-form-label">Published</label>
                                        <div class="col-sm-10">
                                            <input type="datetime-local" class="form-control" id="inputPublished" placeholder="Published" autocomplete="off" name="published" value="{{ \Illuminate\Support\Str::limit(\Carbon\Carbon::parse($article->published)->format('c'), strpos(\Carbon\Carbon::parse($article->published)->format('c'), '+'), '') }}"/>
                                        </div>
                                    </div>
                                @endif
                            </div>

                            <div class="card-footer">
                                <button type="submit" class="btn btn-primary">Submit</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('footer-scripts')
@endsection
