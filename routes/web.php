<?php

use Illuminate\Support\Facades\Route;


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

Route::group(['middleware'=>['auth','admin']],function(){
    Route::get('/dashboard', function () {
        return view('admin.dashboard');
    })->name('admin.index');
    Route::get('/student', function () {
        return view('admin.student');
    })->name('student.index');
});


Route::post('/add-student','StudentController@addStudent')->name('student.add');
Route::post('/search-student','StudentController@searchStudent')->name('student.search');
Route::post('/students','StudentController@getStudentById')->name('student.getbyid');
Route::put('/student','StudentController@updateStudent')->name('student.update');
Route::delete('/students/{id}','StudentController@deleteStudent')->name('student.delete');
Route::get('/getStudent','StudentController@index')->name('student.getstudent');
// Route::resource('/student',"StudentController");