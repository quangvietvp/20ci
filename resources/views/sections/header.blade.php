<div class="header">
    <div class="container">
        <!--  header inner -->
        <div class="col-sm-12">

            <div class="menu-area">
                <nav class="navbar navbar-expand-lg ">
                    <!-- <a class="navbar-brand" href="#">Menu</a> -->
                    <button class="navbar-toggler collapsed" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                        <i class="fa fa-bars"></i>
                    </button>
                    <div class="collapse navbar-collapse" id="navbarSupportedContent">
                        <ul class="navbar-nav mr-auto">
                            <li class="nav-item active">
                                <a class="nav-link" href="/">HOME<span class="sr-only">(current)</span></a>
                            </li>
                            @auth
                            <li class="nav-item" href="#">
                                <a class="nav-link" href="{{ route('blog.index') }}">BLOG</a>
                            </li>
                            <li class="last">
                                <a href="{{ route('auth.logout') }}">Logout</a>
                            </li>
                            @else
                            <li class="last">
                                <a href="{{ route('auth.login') }}">Login</a>
                            </li>
                            @endauth
                        </ul>
                        
                    </div>
                </nav>
            </div>
        </div>
    </div>
</div>
<!--  header end -->
