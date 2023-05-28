<?php

use App\Http\Controllers\Attendance\AttendanceController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Classroom\ClassroomController;
use App\Http\Controllers\Fees\FeesInvoicesController;
use App\Http\Controllers\Grades\GradeController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\Library\LibraryController;
use App\Http\Controllers\OnlineClasse\OnlineClasseController;
use App\Http\Controllers\Payment\PaymentController;
use App\Http\Controllers\ProcessingFee\ProcessingFeeController;
use App\Http\Controllers\Questions\QuestionController;
use App\Http\Controllers\Quizzes\QuizzController;
use App\Http\Controllers\Receipt\ReceiptStudentsController;
use App\Http\Controllers\Sections\SectionController;
use App\Http\Controllers\SettingController;
use App\Http\Controllers\Students\FeesController;
use App\Http\Controllers\Students\GraduatedController;
use App\Http\Controllers\Students\PromotionController;
use App\Http\Controllers\Students\StudentController;
use App\Http\Controllers\Subjects\SubjectsController;
use App\Http\Controllers\Teachers\TeacherController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use Mcamara\LaravelLocalization\Facades\LaravelLocalization;

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

// Auth::routes();
// Route::group(['middleware'=>['guest']],function(){
// 	Route::get('/', function()
// 	{
// 		return view('auth.login');
// 	});
// });

Route::get('/',[HomeController::class,'index'])->name('selection');

Route::get('/login/{type}',[LoginController::class,'loginForm'])->middleware('guest')->name('login.show');

Route::post('/login',[LoginController::class,'login'])->name('login');

Route::get('/logout/{type}', [LoginController::class,'logout'])->name('logout');

Route::group(
	[
		'prefix' => LaravelLocalization::setLocale(),
		'middleware' => [ 'localeSessionRedirect', 'localizationRedirect', 'localeViewPath' ,'auth:web' ]
	], function(){
		// Route::get('/', function()
		// {
		// 	return view('empty');
		// });

		Route::get('/dashboard', [App\Http\Controllers\HomeController::class, 'dashboard'])->name('dashboard');

		
		Route::resource('Grades', GradeController::class);


		Route::resource('Classrooms', ClassroomController::class);
		Route::post('delete_all', [ClassroomController::class,'delete_all'])->name('delete_all');
		Route::post('Filter_Classes', [ClassroomController::class,'Filter_Classes'])->name('Filter_Classes');

		//=====================Sections=========
		Route::resource('Sections',SectionController::class);
		Route::get('/classes/{id}',[SectionController::class,'getclasses']);

		///======================parent===========
		Route::view('add_parent','livewire.show_Form')->name('add_parent');

		//=====================teachers=========
		Route::resource('Teachers',TeacherController::class);

		//=====================students===
		Route::resource('Students',StudentController::class);
		Route::post('Upload_attachment', [StudentController::class,'Upload_attachment'])->name('Upload_attachment');
        Route::get('Download_attachment/{studentsname}/{filename}',[StudentController::class,'Download_attachment'])->name('Download_attachment');
        Route::post('Delete_attachment',[StudentController::class,'Delete_attachment'])->name('Delete_attachment');

		//====================Promotion========
		Route::resource('Promotion',PromotionController::class);
		//====================Graduated==========
		Route::resource('Graduated',GraduatedController::class);

		//==============Fees====================
		Route::resource('Fees', FeesController::class);

		Route::resource('Fees_Invoices', FeesInvoicesController::class);

		Route::resource('receipt_students', ReceiptStudentsController::class);

		Route::resource('ProcessingFee', ProcessingFeeController::class);

		Route::resource('Payment_students',PaymentController::class);

		Route::resource('Attendance', AttendanceController::class);


		Route::resource('subjects', SubjectsController::class);


		Route::resource('Quizzes', QuizzController::class);
		
		Route::resource('questions',QuestionController::class);

		Route::resource('online_classes', OnlineClasseController::class);
		Route::get('/indirect_admin', [OnlineClasseController::class,'indirectCreate'])->name('indirect.create.admin');
        Route::post('/indirect_admin', [OnlineClasseController::class,'storeIndirect'])->name('indirect.store.admin');

		///library
		Route::resource('library', LibraryController::class);
		Route::get('download_file/{filename}', [LibraryController::class,'downloadAttachment'])->name('downloadAttachment');

		////settings
		//Route::get('settings/index',[SettingController::class,'index'])->name('settings.index');
		Route::resource('setting', SettingController::class);


});		


