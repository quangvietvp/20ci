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
                            <h3 class="card-title">Add Article</h3>
                        </div>
                        <form action="{{ route('blog.store') }}", method="POST">
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
                            <div class="card-body">
                                <div class="form-group">
                                    <label for="exampleInputEmail1">Title</label>
                                    <input type="input" class="form-control" id="inputTitle" placeholder="Enter title" autocomplete="off" name="title" value="{{ old('title') }}" />
                                </div>
                                <div class="form-group">
                                    <label for="exampleInputPassword1">Content</label>
                                    <textarea class="form-control" name="content">{{ old('content') }}</textarea>
                                </div>
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
