{{-- <!DOCTYPE html> --}}
<html>
    <head>
        <meta name="csrf-token" content="{{ csrf_token() }}">
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <title>{{config('app.name')}} | {{underscoreToCamelCase(@$route_active)}}</title>
        <!-- Tell the browser to be responsive to screen width -->
        <meta name="viewport" content="width=device-width, initial-scale=1">
        {{-- ReactJS --}}
        <link rel="stylesheet" href="{{asset('css/app.css')}}">
        <link rel="stylesheet" href="{{asset('css/style.css')}}">

        <link rel="stylesheet" href="{{asset('theme/plugins/fontawesome-free/css/all.min.css')}}">
        <link rel="stylesheet" href="{{asset('theme/dist/css/adminlte.min.css')}}">
        <link rel="stylesheet" href="{{asset('theme/plugins/overlayScrollbars/css/OverlayScrollbars.min.css')}}">
        <link href="{{asset('css/googlefont.css')}}" rel="stylesheet">
        <link rel="stylesheet" href="{{asset('css/toastr.min.css')}}">
        <link href="{{asset('css/select2.min.css')}}" rel="stylesheet" />
        <link rel="stylesheet" href="{{asset('theme/plugins/tempusdominus-bootstrap-4/css/tempusdominus-bootstrap-4.min.css')}}">

        <link rel="stylesheet" href="{{asset('theme/plugins/bootstrap-material-datetimepicker/css/bootstrap-material-datetimepicker.css')}}">
        
        {{-- CRM custom CSS for Contact --}}
        <link rel="stylesheet" href="{{asset('css/crmcontact.css')}}">
        <link rel="stylesheet" href="{{asset('css/clean-switch.css')}}">
        <link rel="stylesheet" href="{{asset('css/daterangepicker.css')}}">

        <link rel="stylesheet" href="{{asset('css/buttons.dataTables.min.css')}}">
        @yield('styles')

    </head>
        {{-- if you want to make left side auto collape, add this class to the body - "sidebar-collapse" --}}
        <body class="hold-transition text-sm " >

        <div class="wrapper" >

            @include('client.layouts.navbar')
            @include('client.layouts.sidebar')
            <div class="mt-2"></div>
            @yield('content')

            <footer class="main-footer">
                <strong>Copyright &copy;
                    {{date('Y')}}-{{date('y')+1}}
                    <a href="{{url('/')}}">{{config('app.name')}}</a>.</strong>
                All rights reserved.
                <div class="float-right d-none d-sm-inline-block">
                    <b>Version</b>
                    1.3.1
                </div>
            </footer>

            <aside class="control-sidebar control-sidebar-dark">
            </aside>
        </div>

        <script src="{{asset('js/app.js')}}"></script>
        <script src="{{asset('js/datatable.js')}}"></script>
        <script src="{{asset('theme/plugins/jquery-ui/jquery-ui.min.js')}}"></script>
        <script src="{{asset('theme/plugins/bootstrap/js/bootstrap.bundle.min.js')}}"></script>
        <script src="{{asset('js/popper.min.js')}}" ></script>
 
        <script src="{{asset('theme/plugins/moment/moment.min.js')}}"></script>
        <script src="{{asset('theme/plugins/daterangepicker/daterangepicker.js')}}"></script>
        <script src="{{asset('theme/plugins/tempusdominus-bootstrap-4/js/tempusdominus-bootstrap-4.min.js')}}"></script>
        <script src="{{asset('theme/plugins/summernote/summernote-bs4.min.js')}}"></script>
        <script src="{{asset('theme/dist/js/adminlte.js')}}"></script>
        <script src="{{asset('js/jquery.form-validator.min.js')}}"></script>
        <script src="{{asset('js/select2.min.js')}}"></script>
        <script src="{{asset('js/toastr.min.js')}}"></script>
        <script src="{{asset('js/script.js')}}"></script>
        
        @include('crm.layouts.app_js')
        @yield('scripts')  
    </body>
</html>
