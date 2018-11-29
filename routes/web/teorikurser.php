<?php
//Only auth user can see this pages
Route::group(['middleware' => 'auth'], function () {
    Route::post('/findGlobalTeorikurser', 'TeorikurserController@searchGlobalKurser');
    Route::post('/searchGlobalCoursesByTeachers', 'TeorikurserController@searchGlobalCoursesByTeachers');
    Route::post('/findKursusProfile', 'TeorikurserController@findKursusProfile');



    //Routes for managing Courses Owners
    Route::any('/getDashbaordGroups', 'CourseManagingController@getDashbaordGroups');
    Route::post('/getCourseInformation', 'CourseManagingController@getCourseInformation');
    Route::post('/addCourseProgram', 'CourseManagingController@addCourseProgram');
    Route::post('/addCourseTeacher', 'CourseManagingController@addCourseTeacher');
    Route::delete('/deleteCourseProgram', 'CourseManagingController@deleteCourseProgram');
    Route::delete('/deleteCourseTeacher', 'CourseManagingController@deleteCourseTeacher');
    Route::patch('/updateCoursePrice', 'CourseManagingController@updateCoursePrice');
    Route::patch('/updateCourseDate', 'CourseManagingController@updateCourseDate');
    Route::patch('/updateCourseMainInfo', 'CourseManagingController@updateCourseMainInfo');
    Route::post('/getTeacher', 'CourseManagingController@getTeacher');
    Route::any('/getAllCourseByModule', 'CourseManagingController@getAllCourseByModule');

    // routes courses
    Route::get('/getRegisterCourses', 'TeorikurserController@getRegisterCourses');
    Route::get('/getFavoritsListCourses', 'TeorikurserController@getFavoritsListCourses');
    Route::post('/removeFavorite', 'TeorikurserController@removeFavorite');
    Route::post('/removeMine', 'TeorikurserController@removeMine');
    Route::post('/addToMineListPsychologist', 'TeorikurserController@addToMineListPsychologist');
    Route::post('/addToFavoriteListPsychologist', 'TeorikurserController@addToFavoriteListPsychologist');
    Route::get('/getAllRegisterCourses', 'TeorikurserController@getAllRegisterCourses');
    Route::post('/getRegisterCourseInformation', 'TeorikurserController@getRegisterCourseInformation');
    Route::post('/deleteFileRegisterCourse', 'TeorikurserController@deleteFileRegisterCourse');
    Route::post('/addRegisterCourse', 'TeorikurserController@addRegisterCourse');
    Route::post('/deleteRegisterCourse', 'TeorikurserController@deleteRegisterCourse');
    Route::post('/getCourse', 'TeorikurserController@getCourse');
    Route::post('/getCourseAllByDate', 'TeorikurserController@getCourseAllByDate');
    Route::post('/updateRegisterCourse', 'TeorikurserController@updateRegisterCourse');

    Route::get('/getInfoPsychologist', 'TeorikurserController@getInfoPsychologist');
    Route::post('/updateInfoPsychologist', 'TeorikurserController@updateInfoPsychologist');

    Route::post('/searchCourse', 'TeorikurserController@searchCourse');
});