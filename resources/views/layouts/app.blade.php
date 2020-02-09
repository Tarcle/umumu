<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html;charset=UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link rel="stylesheet" href="/css/nanumsquare.css">
        <link rel="stylesheet" href="/css/nanumsquareround.min.css">
        <link rel="stylesheet" href="/css/common.css">
        <link rel="stylesheet" href="/css/main.css">
        
        @yield('head')
    </head>

    <body>
        <div id="app">
            <div id="gnb">
                <div class="container">
                    <div class="left">
                        <a href="/"><img src="/img/top_logo.png" alt=""></a>
                        <div id="search-box">
                            <input type="text" name="search" placeholder="친구 검색" onkeypress="if(event.keyCode==13)this.nextElementSibling.click()">
                            <button onclick="location.href='/search/'+document.getElementsByName('search')[0].value">검색</button>
                        </div>
                    </div>
                    <div class="right">
                        <div class="profile">
                            @if(Auth::check())
                                <a class="name" href="/profile/{{ Auth::user()->userid }}">{{ Auth::user()->name }}</a>
                                <a href="/logout">로그아웃</a>
                            @else
                                <a href="/login">로그인</a>
                                <a href="/register">회원가입</a>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
            @yield('content')
            @if(!Auth::check())
            <div id="footer">
                <div class="container">
                    Portfolio by Jongchan Choi
                </div>
            </div>
            @endif
        </div>
    </body>
    <script>
        window.laravel = {!! json_encode([
            'csrfToken' => csrf_token(),
        ], JSON_UNESCAPED_UNICODE) !!};
    </script>
    @yield('script')
    <script src="{{ asset('js/app.js') }}"></script>
</html>