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

Route::get('/', function () {
    return view('welcome');
});

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');

Route::get('tasks/autocomplete', 'TaskController@autocomplete')->name('tasks.autocomplete');
Route::get('tasks/{task}/delete', 'TaskController@delete')->name('tasks.delete');
Route::get('tasks/completed', 'TaskController@completed')->name('tasks.completed');
Route::resource('tasks', 'TaskController');

Route::get('metrics/{metric}/delete', 'MetricController@delete')->name('metrics.delete');
Route::resource('metrics', 'MetricController');

Route::get('gantt', 'GanttController@show')->name('gantt.show');


Route::get('unsplash', function () {
    $final = session('unsplash_final');
    $expires = session('unsplash_expires', time());

    if (empty($final) || $expires <= time()) {
        $url = 'https://source.unsplash.com/random/1200x800';

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_HEADER, true);
        curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_NOBODY, true);
        curl_exec($ch);
        $final = curl_getinfo($ch, CURLINFO_EFFECTIVE_URL);
        curl_close( $ch );

        session([
            'unsplash_final' => $final,
            'unsplash_expires' => strtotime('+1 hour'),
        ]);
    }

    return redirect(strval($final));
});
