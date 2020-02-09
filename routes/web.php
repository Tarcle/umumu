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

Route::get('/', function () {
    $follows = Follow::where('from', Auth::user()->id ?? 0)->pluck('to');
    if(Auth::check()) $follows = [Auth::user()->id, $follows];
    $posts = Board::whereIn('writer', $follows)
        ->join('users', 'users.id', 'boards.writer')
        ->select('boards.*', 'users.userid', 'users.name')
        ->orderBy('id', 'desc')
        ->limit(10)
        ->get();
    $comment_count = Comment::whereIn('board_num', $posts->pluck('id'))
        ->groupBy('board_num')
        ->selectRaw('board_num, count(board_num) as count')
        ->pluck('count', 'board_num');

    session()->flash('load_count', count($posts));

    return view('main', ['posts' => $posts, 'comment_count' => $comment_count]);
});

Route::post('write/{where}', function ($where) {
    $req = Request::all();
    $i = array_search($where, ['board', 'comment']);
    if(Auth::check() && $req['content']) {
        $res = [
            function ($req) {
                return Board::create([
                    'body' => $req['content'],
                    'writer' => Auth::user()->id,
                    'like' => '{}',
                ]);
            },
            function ($req) {
                return Comment::create([
                    'comment' => $req['comment'],
                    'board_num' => $req['board_num'],
                    'writer' => Auth::user()->id,
                    'reply' => $req['reply'],
                    'like' => '{}',
                ]);
            }
        ][$i]($req);
        if($res) {
            return redirect('/');
        }
    } else {
        return redirect('/');
    }
})->where('where', 'board|comment');

Auth::routes();
Route::get('logout', 'Auth\LoginController@logout');