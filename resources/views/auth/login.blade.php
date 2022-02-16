@extends('layouts.default')
@section('content')
    <div class="touch_section">
        <div class="container">
            <h1 class="touch_text">Login</h1>
        </div>
    </div>
    <div class="lets_touch_main">
        <div class="container">
            <div class="row">
                <div class="col-md-6">
                    <div class="input_main">
                        <form action="{{ route('auth.authenticate') }}" method="POST">
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
                            <div class="container">
                                <div class="form-group">
                                    <input type="text" class="email-bt" value="{{ old('email') }}" placeholder="Email" name="email">
                                </div>
                                <div class="form-group">
                                    <input type="password" class="email-bt" placeholder="Password" name="password">
                                </div>
                            </div>
                            <div class="send_btn">
                                <button type="submit" class="main_bt">Send</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!--touch_section end -->
    <div class="contact_main"></div>
@endsection
