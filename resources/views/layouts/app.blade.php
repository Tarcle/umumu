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
                            <input type="text" v-model="input_search" name="search" placeholder="친구 검색" @keypress="(e)=>{keypress_button(e,search)}">
                            <button @click="search">검색</button>
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
                    <img src="/img/character.png" width="50%" alt="">
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