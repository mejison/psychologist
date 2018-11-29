<?php
Auth::routes();

Route::get('/home', function () {
    return view('application.dashboard');
});

Route::get("admin/signin", "AdminController@signin");
Route::post("admin/signin", "AdminController@auth")->middleware('messages');
Route::post('/api/getModulesAll', 'AdminController@get_modules_all');
Route::post('/getEducationsAll', 'TeorikurserController@get_education_all');
Route::get('/getUser', 'TeorikurserController@get_user');

Route::group(['prefix' => 'admin', 'middleware' => ['admin']], function() {
    Route::get('/', 'AdminController@welcome');
    Route::get('/users/{role}', 'AdminController@users');
    Route::get('/users/view/{id}', 'AdminController@view');
    Route::get('/modules', 'AdminController@course_groups_list');
    Route::get('/course/educations', 'AdminController@educations');
    Route::get('/modules/sub_modules/{id}', 'AdminController@sub_groups');
    Route::get('/sub_modules/{id}/courses', 'AdminController@courses');
    Route::get('/praksis', 'AdminController@praksis');
    Route::get('/praksis/spv-educations', 'AdminController@spv_educations');
});

Route::group(['prefix' => 'api', 'middleware' => ['messages']], function() {
    Route::group(['prefix' => 'admin', 'middleware' => ['admin']], function() {
        Route::get('/signout', 'AdminController@signout');
        Route::post('/delete-user', 'AdminController@delete_user');
        Route::post('/updateInfoPraksis', 'AdminController@updateInfoPraksis');

        Route::post('/add_require_course', 'AdminController@add_require_course');

        Route::any('/add-groups', 'AdminController@add_groups');
        Route::any('/delete-groups', 'AdminController@delete_groups');
        Route::any('/update-groups', 'AdminController@update_groups');
        Route::any('/updateStatusGroup', 'AdminController@updateStatusGroup');
        Route::any('/updateShowSubModules', 'AdminController@updateShowSubModules');

        Route::post('/add_group_to_educations', 'AdminController@add_group_to_educations');
        Route::post('/delete_group_from_educations', 'AdminController@delete_group_from_educations');
        
        Route::any('/getSubModules', 'AdminController@get_sub_groups');
        Route::any('/add-sub_groups', 'AdminController@add_sub_groups');
        Route::any('/update-sub_groups', 'AdminController@update_sub_groups');
        Route::any('/delete-sub_groups', 'AdminController@delete_sub_groups');

        Route::any('/getCourses', 'AdminController@get_courses');
        Route::any('/add-courses', 'AdminController@add_courses');
        Route::any('/update-courses', 'AdminController@update_courses');
        Route::any('/delete-courses', 'AdminController@delete_courses');

        Route::any('/update_desc_education', 'AdminController@update_desc_education');
        Route::any('/update_praksis_education', 'AdminController@update_praksis_education');
        
        Route::any('/spv-educations-update', 'AdminController@spv_educations_update');
        Route::any('/sv-option-update', 'AdminController@sv_option_update');
    });
});