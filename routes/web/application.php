<?php
//Only auth user can see this pages
Route::group(['middleware' => 'auth'], function () {
    Route::get('/application', 'ApplicationController@index');
    Route::get('/informationAboutUser', 'ApplicationController@getInformation');
    Route::post('/updateInformationUser', 'ApplicationController@updateInformation');
    Route::post('/userImageUploadAvatar','ApplicationController@imageUploadPost');
    Route::post('/deleteUserAvatar','ApplicationController@deleteUserAvatar');
    Route::post('/sendCommentMessage', 'ApplicationController@sendCommentMessage');
//    Managing account routs
    Route::patch('/addProfileVisitor', 'ApplicationController@addProfileVisitor');
    Route::patch('/addProfileWebPageVisitor', 'ApplicationController@addProfileWebPageVisitor');
    Route::patch('/updateUserProfileVersionPro', 'ApplicationController@updateUserProfileVersionPro');
    Route::patch('/updateUserProfileVersionFree', 'ApplicationController@updateUserProfileVersionFree');
    Route::patch('/updateUserAddress', 'ApplicationController@updateUserAddress');
    Route::patch('/updateUserEmailPhone', 'ApplicationController@updateUserEmailPhone');
    Route::patch('/updateUserWebsite', 'ApplicationController@updateUserWebsite');
    Route::patch('/updateUserPresentation', 'ApplicationController@updateUserPresentation');
    Route::delete('/deleteUserPicture', 'ApplicationController@deleteUserPicture');
    Route::post('/uploadUserImages', 'ApplicationController@uploadUserImages');
    Route::post('/uploadUserVideos', 'ApplicationController@uploadUserVideos');
    Route::post('/uploadUserVideosUrl', 'ApplicationController@uploadUserVideosUrl');
    Route::delete('/deleteUserVideos', 'ApplicationController@deleteUserVideos');
});