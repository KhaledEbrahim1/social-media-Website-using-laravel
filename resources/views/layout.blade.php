<!doctype html>
<html lang="en">

<head>
    <title>Title</title>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Bootstrap CSS v5.2.1 -->
    <link href="{{ asset('css/profile.css') }}" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.1/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-iYQeCzEYFbKjA/T2uDLTpkwGzCiq6soy8tYaI1GyVh/UjpbCx/TYkiZhlZB6+fzT" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">

</head>

<body>
    <header>
        <!-- place navbar here -->
        <nav class="navbar navbar-expand-sm navbar-light bg-light">
            <div class="container">
                <a class="navbar-brand" href="{{ route('Home') }}">HowYou</a>
                <button class="navbar-toggler d-lg-none" type="button" data-bs-toggle="collapse"
                    data-bs-target="#collapsibleNavId" aria-controls="collapsibleNavId" aria-expanded="false"
                    aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>
                <div class="collapse navbar-collapse" id="collapsibleNavId">
                    <ul class="navbar-nav me-auto mt-2 mt-lg-0">

                        @guest()
                            <li class="nav-item">
                                <a class="nav-link" href="{{ route('login') }}">Log in</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="{{ route('register-user') }}">Register</a>
                            </li>
                        @else
                            <li class="nav-item dropdown ">
                                <a class="nav-link dropdown-toggle" href="#" id="dropdownId" data-bs-toggle="dropdown"
                                    aria-haspopup="true" aria-expanded="false"> <img class="me-2 avatar-sm rounded-circle"
                                        src="{{ asset('/storage/images/' . Auth::user()->image) }}"alt="avatar"></a>
                                <div class="dropdown-menu" aria-labelledby="dropdownId">
                                    <a class="dropdown-item"
                                        href="{{ route('profile.user', [Auth::user()->id, Auth::user()->name]) }}">
                                        <img class="me-2 avatar-sm rounded-circle"
                                            src="{{ asset('/storage/images/' . Auth::user()->image) }}"alt="avatar">
                                        {{ Auth::user()->name }}</a>
                                    <a class="dropdown-item" href="{{ route('signout') }}">Log Out</a>
                                </div>
                            </li>
                        @endguest
                    </ul>
                    <form class="d-flex my-2 my-lg-0" action="{{ route('search.user') }}">
                        <input class="form-control me-sm-2" type="text" placeholder="Search" name="query">
                        <button class="btn btn-outline-success my-2 my-sm-0" type="submit">Search</button>
                    </form>
                </div>
            </div>
        </nav>

    </header>
    <main>
        <div class="container">
            @yield('content')
        </div>

    </main>

    <!-- Bootstrap JavaScript Libraries -->
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"
        integrity="sha384-oBqDVmMz9ATKxIep9tiCxS/Z9fNfEXiDAYTujMAeBAsjFuCZSmKbSSUnQlmh/jp3" crossorigin="anonymous">
    </script>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.1/dist/js/bootstrap.min.js"
        integrity="sha384-7VPbUDkoPSGFnVtYi0QogXtr74QeVeeIs99Qfg5YCF+TidwNdjvaKZX19NZ/e6oz" crossorigin="anonymous">
    </script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

    @yield('scripts')
</body>

</html>
