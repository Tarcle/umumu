@extends('layouts/app')

@section('content')
    <div class="container">
        <div id="left">왼쪽</div>
        <div id="center">
            @if(Auth::check())
            <form action="/write/board" method="POST" id="board-write">
                @csrf
                <div class="content">
                    <div style="background-image: url(/img/{{ Auth::user()->id }}.jpg)"></div>
                    <textarea name="content" placeholder="소식을 전해보세요."></textarea>
                </div>
                <div class="media">
                    <button type="submit">글쓰기</button>
                    <button type="button" class="photo">사진 / 동영상</button>
                    <button type="button" class="emoji">이모티콘</button>
                </div>
            </form>
            @endif
            <div id="newsfeed">
                <div is="post" v-if="posts.length" v-for="(post,i) in posts" :post="post" :comment_count="comment_count" :key="i"></div>
                <img v-else src="/img/character.png" alt="">
            </div>
        </div>
        <div id="right">오른쪽</div>
    </div>
@endsection

@section('script')
<script>
    window.laravel = Object.assign(window.laravel, {!! json_encode([
        'user' => Auth::user(),
    ], JSON_UNESCAPED_UNICODE) !!});
</script>
@endsection