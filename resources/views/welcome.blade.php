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
        <link rel="stylesheet" href="{{asset('css/style.css')}}">
        <link rel="stylesheet" href="{{asset('css/welcome.css')}}">
    </head>
    <body>
        <div class="flex-center position-ref full-height">
            @if (Route::has('login'))
                <div class="top-right links">

                    @auth
                        <a href="{{ url('/home') }}">{{__('auth.home')}}</a>
                    @else
 
                        @if(file_exists(STORAGE_PATH('INSTALLED')))
                            {{-- If CRM is installed --}}
                            <a href="{{ url('client/login') }}">{{__('auth.client_login')}}</a>
                            <a href="{{ route('login') }}">{{__('auth.login')}}</a>
                            @if (Route::has('register'))
                                <a href="{{ route('register') }}">{{__('auth.register')}}</a>
                            @endif
                        @endif
                    @endauth
                </div>
            @endif

            <div class="content">
                <div class="title m-b-md">
                    @if ($logo == null)
                        <img src="{{asset('images/cover.png')}}" alt="crm-logo"  width="50%">
                    @else
                        <img src="{{asset('storage/adminfiles/'.$logo)}}" alt="crm-logo"  width="350">
                    @endif
                    <br>
                    @if(!file_exists(STORAGE_PATH('INSTALLED')))
                        <div class="row">
                            <div class="col-md-4 offset-md-4">
                                <a href="{{url('/install')}}" class="btn btn-block rounded text-light installBtnBG" ><i class="fas fa-laptop-code pr-2"></i> {{__('auth.install')}}</a>
                            </div>
                        </div>
                    @endif
                </div>
            </div>
        </div>

        <script src="{{asset('js/app.js')}}"></script>
    </body>
</html>
