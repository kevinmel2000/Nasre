<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>{{config('app.name')}}</title>

        <!-- Fonts -->
        <link href="https://fonts.googleapis.com/css?family=Nunito:200,600" rel="stylesheet">

        <!-- Styles -->
        <link rel="stylesheet" href="{{asset('css/success.css')}}">
        <link rel="stylesheet" href="{{asset('css/app.css')}}">
        <link rel="stylesheet" href="{{asset('css/style.css')}}">
    </head>
    <body>
        <div class="flex-center position-ref full-height">
            @if (Route::has('login'))
                <div class="top-right links">
                    @auth
                        <a href="{{ url('/home') }}">{{__('auth.home')}}</a>
                    @else
                        <a href="{{ route('login') }}">{{__('auth.login')}}</a>
                        @if (Route::has('register'))
                            <a href="{{ route('register') }}">{{__('auth.register')}}</a>
                        @endif
                    @endauth
                </div>
            @endif

            <div class="content">
                <div class="title m-b-md">
                    <img src="{{asset('storage/adminfiles/'.session('logo_file'))}}" alt="crm-logo" width="250" height="250">
                    <br/>
                    {{config('app.name')}}

                </div>
                {{$message}}
            </div>
        </div>

        <script src="{{asset('js/app.js')}}"></script>
    </body>
</html>
