<?php

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
});