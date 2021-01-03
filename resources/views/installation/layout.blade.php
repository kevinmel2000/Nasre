<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link rel="icon" href="{{asset('images/logo_small.png')}}">
        <title>{{config('app.name')}}</title>
        <!-- Fonts -->
        <link href="https://fonts.googleapis.com/css?family=Nunito:200,600" rel="stylesheet">
        <!-- Styles -->
        <link rel="stylesheet" href="{{asset('css/app.css')}}">
        <link rel="stylesheet" href="{{asset('css/bootstrap.min.css')}}">
        <link rel="stylesheet" href="{{asset('css/style.css')}}">
        <link rel="stylesheet" href="{{asset('theme/plugins/fontawesome-free/css/all.min.css')}}">
        <style>
          .full-height {
            height: 100vh;
          }

          .flex-center {
            align-items: center;
            display: flex;
            justify-content: center;
          }

          .position-ref {
            position: relative;
          }

          #installer{
            background-image: url({{url('images/installer_bg.jpg')}})
          }
        </style>
    </head>
    <body id="installer">
      
        <div class="flex-center position-ref full-height">
            <div class="content">
              @yield('content')
            </div>
        </div>

        <script src="{{asset('js/app.js')}}"></script>
    </body>
</html>
