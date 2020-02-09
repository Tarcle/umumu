@extends('layouts.app')

@section('content')
<div class="container">
    <form method="POST" action="{{ route('register') }}" id="register">
        @csrf
        <p>
            <label for="userid">아이디</label>
            <input type="text" name="userid" id="userid" autofocus>
        </p>
        <p>
            <label for="password">비밀번호</label>
            <input type="password" name="password" id="password">
        </p>
        <p>
            <label for="password-confirm">비밀번호 확인</label>
            <input type="password" name="password-confirm" id="password">
        </p>
        <p>
            <label for="gender">성별</label>
            <label><input type="radio" name="gender" id="male" value="1">남</label>
            <label><input type="radio" name="gender" id="female" value="2">여</label>
        </p>
        <p>
            <label for="birthday">생년월일</label>
            <select name="year" id="year">
                <script>
                    for(i=2020;i>=1920;i--) {document.write('<option value="'+i+'">'+i+'</option>')}
                </script>
            </select>
            <select name="month" id="month">
                <script>
                    for(i=1;i<=12;i++) {document.write('<option value="'+i+'">'+i+'</option>')}
                </script>
            </select>
            <select name="year" id="year">
                <script>
                    for(i=1;i<=31;i++) {document.write('<option value="'+i+'">'+i+'</option>')}
                </script>
            </select>
        </p>
        <button type="submit">회원가입</button>
    </form>
</div>
@endsection
