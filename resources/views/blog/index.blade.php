@extends('layouts.default')
@section('title', 'Blog index')
@section('content')
    <div class="panel">
        <div class="panel-body container-fluid">
            <div class="row row-lg">
                @include('sections.left_menu')
                <div class="col-lg-9">
                    <!-- Example Hover Table -->
                    <div class="example-wrap">
                        <div class="card card-info">
                            <form class="form-horizontal">
                                <div class="card-body">
                                    <div class="form-group row">
                                        <label for="inputEmail3" class="col-sm-2 col-form-label">Status</label>
                                        <div class="form-group">
                                            <select class="custom-select rounded-0" id="exampleSelectRounded0" name="status_filtering">
                                                <option value="1" @if (isset($status_filtering) && $status_filtering == 1) selected="selected" @endif>Approved</option>
                                                <option value="0" @if (isset($status_filtering) && $status_filtering == 0) selected="selected" @endif>Waiting approve</option>
                                                <option value="2" @if (!isset($status_filtering)) selected="selected" @endif>All</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label for="inputPassword3" class="col-sm-2 col-form-label">Published</label>
                                        <div class="col-sm-10">
                                            <input type="date" class="form-control" id="inputPublished" placeholder="Published" autocomplete="off" name="published_filtering" value="{{ $published_filtering }}"/>
                                        </div>
                                    </div>
                                </div>
                                <div class="card-footer">
                                    <button type="submit" class="btn btn-warning">Filter</button>
                                </div>
                            </form>
                        </div>
                        <div class="example table-responsive">
                            @if ($errors->any())
                                <div class="alert alert-danger">
                                    <ul>
                                        @foreach ($errors->all() as $error)
                                            <li>{{ $error }}</li>
                                        @endforeach
                                    </ul>
                                </div>
                            @endif
                            <table class="table table-hover">
                                <thead>
                                <tr>
                                    <th>#</th>
                                    <th>User</th>
                                    <th>Title</th>
                                    <th>Content</th>
                                    <th><a href="{{route('blog.index', ['status' => $status])}}" class="btn-link">Status</a></th>
                                    <th><a href="{{route('blog.index', ['created' => $created])}}" class="btn-link">Created</a></th>
                                    <th>Published</th>
                                    <th>Action</th>
                                </tr>
                                </thead>
                                <tbody>
                                @foreach ($articles as $article)
                                    <tr class="{{ ($article->status == 0)? 'bg-warning' : '' }}">
                                        <td>{{ $loop->index +1 }}</td>
                                        <td>{{ $article->user_id }}</td>
                                        <td>{{ $article->title }}</td>
                                        <td>{{ \Illuminate\Support\Str::limit($article->content, 120) }}</td>
                                        <td>{{ ($article->status == 1)? 'Approved' : 'Waiting accept'}}</td>
                                        <td>{{ \Carbon\Carbon::parse($article->created_at)->format('M, d Y') }}</td>
                                        <td>{{ ($article->published == NULL)? '' : \Carbon\Carbon::parse($article->published)->format('M, d Y') }}</td>
                                        <td>
                                            <a href="{{ route('blog.edit', $article->id) }}" class="btn-link">Edit</a>
                                            <form action="{{ route('blog.destroy', $article->id)}}" method="POST">
                                                @method('DELETE')
                                                @csrf
                                                <input class="btn btn-danger" type="submit" value="Delete" />
                                            </form>
                                        </td>
                                    </tr>
                                @endforeach
                                </tbody>
                            </table>
                            <div class="col-md-9">
                                {{ $articles->links() }}
                            </div>
                        </div>
                    </div>
                    <!-- End Example Hover Table -->
                </div>

            </div>
        </div>
    </div>
@endsection
