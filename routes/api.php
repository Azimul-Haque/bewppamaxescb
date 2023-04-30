<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

Route::get('/testapi', 'APIController@test')->name('api.test');

Route::get('/checkuid/{softtoken}/{phonenumber}', 'APIController@checkUid')->name('api.checkuid');
Route::get('/checkpackagevalidity/{softtoken}/{phonenumber}', 'APIController@checkPackageValidity')->name('api.checkpackagevalidity');
Route::post('/adduser', 'APIController@addUser')->name('api.adduser');
Route::post('/addonesignaldata', 'APIController@addOneSignaldata')->name('api.adduser');
Route::post('/updateuser', 'APIController@updateUser')->name('api.updateuser');
Route::post('/notification/single', 'APIController@sendSingleNotification')->name('api.sendsinglenotification');
Route::get('/notification/test', 'APIController@testNotification')->name('api.testnotification');

Route::get('/testcache', 'APIController@testCache')->name('api.testcache');
Route::get('/getcourses/{softtoken}/{coursetype}', 'APIController@getCourses')->name('api.getcourses');
Route::get('/getcourses/exams/{softtoken}/{id}', 'APIController@getCourseExams')->name('api.getcourses.exams');
Route::get('/getothercourses/exams/{softtoken}/{coursetype}', 'APIController@getOtherCourseExams')->name('api.getothercourses.exams');
Route::get('/getcourses/exam/{softtoken}/{id}/questions', 'APIController@getCourseExamQuestions')->name('api.getcourses.exam.questions');
Route::get('/gettopicwise/exam/{softtoken}/{id}/questions', 'APIController@getTopicExamQuestions')->name('api.gettopicwise.exam.questions');
Route::get('/gettopics/{softtoken}', 'APIController@getTopics')->name('api.gettopics');
Route::get('/getpackages/{softtoken}', 'APIController@getPackages')->name('api.getpackages');
Route::post('/payment/proceed', 'APIController@paymentProceed')->name('api.paymentproceed');

Route::post('/message/store', 'APIController@storeMessage')->name('api.storemessage');

Route::get('/getpaymenthistory/{softtoken}/{phonenumber}', 'APIController@getPaymentHistory')->name('api.getpaymenthistory');

Route::get('/getmaterials/{softtoken}', 'APIController@getMaterials')->name('api.getmaterials');