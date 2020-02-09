@extends('layouts.app')

@section('head')
<link rel="stylesheet" href="/css/auth.css">
@endsection
@section('content')
<div class="container">
    <form method="POST" action="{{ route('login') }}" id="login">
        @csrf
        <p>
            <label for="userid">아이디</label>
            <input type="text" name="userid" id="userid" autofocus>
        </p>
        <p>
            <label for="password">비밀번호</label>
            <input type="password" name="password" id="password">
        </p>
        <button type="submit">로그인</button>
    </form>
    @if ($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif
</div>
@endsection
