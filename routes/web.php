<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/
use \App\Follow;
use \App\Board;
use \App\Comment;

Auth::routes();
Route::get('logout', 'Auth\LoginController@logout');

/* 메인 */
Route::get('/', function () {
    return view('main');
});
/* 게시물 불러오기 */
Route::post('load/posts/{load_count}', function ($load_count) {
    $follows = Follow::where('from', Auth::user()->id ?? 0)->pluck('to');
    if(Auth::check()) $follows = [Auth::user()->id, $follows];
    $posts = Board::whereIn('writer', $follows)
        ->join('users', 'users.id', 'boards.writer')
        ->select('boards.*', 'users.userid', 'users.name')
        ->orderBy('id', 'desc')
        ->skip($load_count)
        ->limit($load_count<1 ? 10 : 5)
        ->get();
    return json_encode($posts);
});
/* 댓글 개수 불러오기 */
Route::post('load/comment_count/{postid}', function ($postid) {
    return Comment::where('board_num', $postid)->count();
});
/* 댓글 불러오기 */
Route::post('load/comments/{postid}', function ($postid) {
    $comments = Comment::where('board_num', $postid)
        ->join('users', 'users.id', 'comments.writer')
        ->select('comments.*', 'users.name', 'users.userid')
        ->get();
    return json_encode($comments, JSON_UNESCAPED_UNICODE);
})->where('postid', '[0-9]+');

/* 글 작성 */
Route::post('write/board', function () {
    $req = Request::all();
    if($req['content'] && Auth::check()) {
        $res = Board::create([
            'body' => $req['content'],
            'writer' => Auth::user()->id,
            'like' => '{}',
        ]);
    } else {
        $res = false;
    }
    if($res) {
        return redirect()->back();
    } else {
        return "<script>alert('게시물 작성에 실패했습니다.');location.href='/';</script>";
    }
});
/* 댓글 작성 */
Route::post('write/comment/{postid}', function ($postid) {
    $req = Request::all();
    if(!$req['content'] || !Auth::check()) return redirect()->back();
    $res = Comment::create([
        'comment' => $req['content'],
        'board_num' => $postid,
        'writer' => Auth::user()->id,
        'reply' => $req['reply'],
        'like' => '{}',
    ]);
    if($res) return redirect()->back();
});