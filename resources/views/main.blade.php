@extends('layouts/app')

@section('content')
    @php
    function display_datetime($datetime = '')
    {
        if (empty($datetime)) {
            return false;
        }

        $diff = time() - strtotime($datetime);

        $s = 60; //1분 = 60초
        $h = $s * 60; //1시간 = 60분
        $d = $h * 24; //1일 = 24시간
        $y = $d * 10; //1년 = 1일 * 10일

        if ($diff < $s) {
            $result = $diff . '초 전';
        } elseif ($h > $diff && $diff >= $s) {
            $result = round($diff/$s) . '분 전';
        } elseif ($d > $diff && $diff >= $h) {
            $result = round($diff/$h) . '시간 전';
        } elseif ($y > $diff && $diff >= $d) {
            $result = round($diff/$d) . '일 전';
        } else {
            $result = date('Y.m.d.', strtotime($datetime));
        }

        return $result;
    }
    @endphp
    <div class="container">
        <div id="left"></div>
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
                <div is="post" v-for="post in posts" :post="post"></div>
            </div>
        </div>
        <div id="right"></div>
    </div>
@endsection

@section('script')
<script>
    window.laravel = Object.assign(window.laravel, {!! json_encode([
        'posts' => $posts ?? [],
        'comment_count' => $comment_count ?? [],
    ], JSON_UNESCAPED_UNICODE) !!});
</script>
@endsection