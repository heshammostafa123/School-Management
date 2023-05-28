<?php

use App\Http\Controllers\Teachers\dashboard\OnlineZoomClassController;
use App\Http\Controllers\Teachers\dashboard\ProfileController;
use App\Http\Controllers\Teachers\Dashboard\QuestionController;
use App\Http\Controllers\Teachers\dashboard\QuizzController;
use App\Http\Controllers\teachers\dashboard\StudentController;
use App\Models\Student;
use App\Models\Teacher;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Mcamara\LaravelLocalization\Facades\LaravelLocalization;

/*
|--------------------------------------------------------------------------
| student Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

//==============================Translate all pages============================
Route::group(
    [
        'prefix' => LaravelLocalization::setLocale(),
        'middleware' => ['localeSessionRedirect', 'localizationRedirect', 'localeViewPath', 'auth:teacher']
    ], function () {

    //==============================dashboard============================
    Route::get('/teacher/dashboard', function () {
        $sections_ids=Teacher::findOrFail(auth()->user()->id)->sections()->pluck('section_id');
        $data['count_sections']=$sections_ids->count();
        $data['count_students']=Student::whereIn('section_id',$sections_ids)->count();

        return view('pages.Teachers.dashboard.dashboard',$data);
    });


    Route::get('student',[StudentController::class,'index'])->name('student.index');
    Route::get('sections',[StudentController::class,'sections'])->name('sections');
    Route::post('attendance',[StudentController::class,'attendance'])->name('attendance');
    
    //===========attendance report==========
    Route::get('attendance_report',[StudentController::class,'attendanceReport'])->name('attendance.report');
    Route::post('attendance_report',[StudentController::class,'attendanceSearch'])->name('attendance.search');

    //============quiz=======//
    Route::resource('quizzes', QuizzController::class);

    Route::resource('questions', QuestionController::class);

    Route::resource('online_zoom_classes', OnlineZoomClassController::class);
    Route::get('/indirect',[OnlineZoomClassController::class,'indirectCreate'])->name('indirect.teacher.create');
    Route::post('/indirect',[OnlineZoomClassController::class,'storeIndirect'])->name('indirect.teacher.store');

    Route::get('/profile',[ProfileController::class,'index'])->name('profile.show');
    Route::post('/profile/{id}',[ProfileController::class,'update'])->name('profile.update');

});