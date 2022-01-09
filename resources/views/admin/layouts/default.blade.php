<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" theme="light">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="{{ mix('/css/app.css') }}">
    <title>@yield('title')</title>
</head>
<body>
    <div class="container-fluid">
        <div class="row flex-nowrap">
            <div class="col-auto px-0">
                <div id="sidebar" class="collapse collapse-horizontal show border-end">
                    <div id="sidebar-nav" class="list-group border-0 rounded-0 text-sm-start min-vh-100">
                        <div id="app-logo">
                            LaraBB
                        </div>
                        <div id="sidebar-items">
                            {!! $sidebar->render(); !!}
                        </div>
                    </div>
                </div>
            </div>
            <main class="col ps-md-2 pt-2">
                <div class="container-fluid no-gutters p-0">
                    <div class="col-12">
                        <header class="ascent d-flex justify-content-between align-items-center">
                            <a href="#" data-bs-target="#sidebar" data-bs-toggle="collapse" style="font-size: 30px" class="text-decoration-none"><i class="bi bi-list"></i></a>
                            <div class="d-flex justify-content-between align-items-center">

                            </div>
                        </header>
                    </div>
                </div>

                <!-- START MAIN CONTENT -->
                @yield('content')
                <!-- END MAIN CONTENT -->

            </main>
        </div>
    </div>
{{--    <script src="{{ mix('/js/app.js') }}"></script>--}}
    <script src="{{ mix('/js/bootstrap.js') }}"></script>

</body>
</html>
