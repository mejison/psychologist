<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8" />
        <meta http-equiv="X-UA-Compatible" content="IE=edge" />
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
        <meta name="csrf-token" content="{{ csrf_token() }}" />

        <title>Admin Panel</title>

        <link rel="stylesheet" href="https://netdna.bootstrapcdn.com/font-awesome/4.0.3/css/font-awesome.min.css" />
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-beta/css/bootstrap.min.css" />
        <link rel="stylesheet" href="https://cdn.datatables.net/1.10.16/css/dataTables.bootstrap4.min.css" />
        <link rel="stylesheet" href="//cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.css" />
        <link href="{{ asset('css/admin.css') }}" rel="stylesheet" />

        @stack('app-styles')
        
    </head>
    <body class=" {{ Auth::check() && Auth::user()->hasRole('admin') ? 'fixed-nav ' : '' }}  bg-dark" id="page-top">
        
        @if( Auth::check() && Auth::user()->hasRole('admin') )
            @include('admin.navbar')
        @endif
        
        <div class="{{ Auth::check() && Auth::user()->hasRole('admin') ? 'content-wrapper' : '' }}">
            <div class="container-fluid">
                @yield('breadcrumb')
                @yield('content')
            </div>
        </div>

      
        <script src="https://code.jquery.com/jquery-3.2.1.min.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.17.0/jquery.validate.min.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.11.0/umd/popper.min.js"></script>
        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-beta/js/bootstrap.min.js"></script>
        <script src="https://cdn.datatables.net/1.10.16/js/jquery.dataTables.min.js"></script>
        <script src="https://cdn.datatables.net/1.10.16/js/dataTables.bootstrap4.min.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>
        <script src="/js/admin.js"></script>
        @stack('app-scripts')
    </body>
</html>
    