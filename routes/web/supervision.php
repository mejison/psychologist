<?php
//Only auth user can see this pages
Route::group(['middleware' => 'auth'], function () {
    Route::post('/psychologistRegSupervision', 'SupervisionController@registrationSupervisor');  
    Route::post('/findSupervisor', 'SupervisionController@searchSupervisor');
    Route::post('/attachSupervisor', 'SupervisionController@attachSupervisor');
    Route::get('/getAllSupervisors', 'SupervisionController@getAllSupervisors');
    Route::post('/registerSupervision', 'SupervisionController@registerSupervision');
    Route::post('/uploadBilagFile', 'SupervisionController@uploadBilagFile');
    Route::post('/deleteBilagFile', 'SupervisionController@deleteBilagFile');
    
    Route::get('/getSupervisionStatus', 'SupervisionController@getSupervisionStatus');
    Route::get('/getSupervisionPsText', 'SupervisionController@getSupervisionPsText');

    Route::get('/getSupervisionOptions', 'SupervisionController@getSupervisionOptions');
    Route::get('/getSupervisionOptionsChecks', 'SupervisionController@getSupervisionOptionsChecks');
    
    Route::post('/getInfoSupervision', 'SupervisionController@getInfoSupervision');
    Route::get('/getSupervisionsSession', 'SupervisionController@getSupervisionsSession');
    Route::post('/updateSupervisionStatus', 'SupervisionController@updateSupervisionStatus');
    Route::post('/findGlobalSupervision', 'SupervisionController@searchGlobalSupervisor');
    Route::post('/findSupervisionProfile', 'SupervisionController@findSupervisionProfile');
    Route::post('/getSupervisionInformation', 'SupervisionController@getSupervisionInformation');
    Route::post('/addToMineList', 'SupervisionController@addToMineList');
    Route::get('/getMineListSupervisors', 'SupervisionController@getMineListSupervisors');
    Route::post('/addToFavoriteList', 'SupervisionController@addToFavoriteList');
    Route::get('/getFavoriteListSupervisors', 'SupervisionController@getFavoriteListSupervisors');
    Route::post('/deleteSupervisionFromFavoriteList', 'SupervisionController@deleteSupervisionFromFavoriteList');
    Route::post('/deleteRegisterSupervisionsList', 'SupervisionController@deleteRegisterSupervisionsList');
    Route::post('/getAllSupervisionBilags', 'SupervisionController@getAllBilagFiles');
    Route::post('/getSupervisionPsychologyInformation', 'SupervisionController@getSupervisionPsychologyInformation');
    Route::delete('/deleteSupervisorFromMineList', 'SupervisionController@deleteSupervisorFromMineList');
    Route::post('/getUserRoleSupervisionInformation', 'SupervisionController@getUserRoleSupervisionInformation');
    

//    Editing psychology supervisor profile
    Route::post('/updateSupervisionPsychologyName', 'SupervisionController@updateSupervisionPsychologyName');
    Route::post('/updateSupervisionPsychologyAddress', 'SupervisionController@updateSupervisionPsychologyAddress');
    Route::post('/updateSupervisionPsychologyEmailPhone', 'SupervisionController@updateSupervisionPsychologyEmailPhone');
    Route::post('/updateSupervisionPsychologyPresentationDescription', 'SupervisionController@updateSupervisionPsychologyPresentationDescription');
    Route::post('/updateSupervisionPsychologyFormType', 'SupervisionController@updateSupervisionPsychologyFormType');

//    Editing  supervisor profile managing
    Route::patch('/updateSupervisionMainInfo', 'SupervisionController@updateSupervisionMainInfo');
    Route::patch('/updateSupervisionTypes', 'SupervisionController@updateSupervisionTypes');
    Route::post('/addSupervisionSpecialisation', 'SupervisionController@addSupervisionSpecialisation');
    Route::delete('/deleteSpecialisation', 'SupervisionController@deleteSupervisionSpecialisation');



});