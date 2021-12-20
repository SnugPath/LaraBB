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
                        <a href="#" class="list-group-item border-end-0 d-inline-block text-truncate" data-bs-parent="#sidebar"><i class="bi bi-bootstrap"></i> <span>Item</span> </a>
                        <a href="#" class="list-group-item border-end-0 d-inline-block text-truncate" data-bs-parent="#sidebar"><i class="bi bi-film"></i> <span>Item</span></a>
                        <a href="#" class="list-group-item border-end-0 d-inline-block text-truncate" data-bs-parent="#sidebar"><i class="bi bi-heart"></i> <span>Item</span></a>
                        <a href="#" class="list-group-item border-end-0 d-inline-block text-truncate" data-bs-parent="#sidebar"><i class="bi bi-bricks"></i> <span>Item</span></a>
                        <a href="#" class="list-group-item border-end-0 d-inline-block text-truncate" data-bs-parent="#sidebar"><i class="bi bi-clock"></i> <span>Item</span></a>
                        <a href="#" class="list-group-item border-end-0 d-inline-block text-truncate" data-bs-parent="#sidebar"><i class="bi bi-archive"></i> <span>Item</span></a>
                        <a href="#" class="list-group-item border-end-0 d-inline-block text-truncate" data-bs-parent="#sidebar"><i class="bi bi-gear"></i> <span>Item</span></a>
                        <a href="#" class="list-group-item border-end-0 d-inline-block text-truncate" data-bs-parent="#sidebar"><i class="bi bi-calendar"></i> <span>Item</span></a>
                        <a href="#" class="list-group-item border-end-0 d-inline-block text-truncate" data-bs-parent="#sidebar"><i class="bi bi-envelope"></i> <span>Item</span></a>
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
    <script src="{{ mix('/js/app.js') }}"></script>
    <script src="{{ mix('/js/bootstrap.js') }}"></script>

</body>
</html>