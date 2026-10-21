<?php
Route::middleware(['auth', 'auth.employees'])->group(function () {
    Route::get('/applications-credentials', 'AuthController@getAppsCredentials');
    Route::get('/apps/{appIds}', 'ApplicationController@getApps');
});

Route::middleware(['auth', 'auth.oldEmployees'])->group(function () {
    Route::get('/user/info', 'AuthController@currentUser');
    Route::get('/signature/{appId}', 'AuthController@getSignature');

    Route::post('/state', 'StateController@addState');
    Route::get('/state/get/{code}', 'StateController@getState');

    /**
     * Relevance testing
     */
    Route::get('/relevance-testing/suites', 'RelevanceTesting\SuiteController@listSuites');
    Route::post('/relevance-testing/suites', 'RelevanceTesting\SuiteController@addSuite');
    Route::get('/relevance-testing/suites/{id}', 'RelevanceTesting\SuiteController@getSuite');
    Route::put('/relevance-testing/suites/{id}', 'RelevanceTesting\SuiteController@updateSuite');
    Route::delete('/relevance-testing/suites/{id}', 'RelevanceTesting\SuiteController@deleteSuite');

    Route::post('/relevance-testing/suites/{suiteId}/groups', 'RelevanceTesting\GroupController@addGroup');
    Route::put('/relevance-testing/suites/{suiteId}/groups/{groupId}', 'RelevanceTesting\GroupController@updateGroup');
    Route::delete('/relevance-testing/suites/{suiteId}/groups/{groupId}', 'RelevanceTesting\GroupController@deleteGroup');

    Route::post('/relevance-testing/suites/{suiteId}/groups/{groupId}/tests', 'RelevanceTesting\TestController@addTest');
    Route::post('/relevance-testing/suites/{suiteId}/groups/{groupId}/tests/batch', 'RelevanceTesting\TestController@addTests');
    Route::put('/relevance-testing/suites/{suiteId}/groups/{groupId}/tests/{testId}', 'RelevanceTesting\TestController@updateTest');
    Route::delete('/relevance-testing/suites/{suiteId}/groups/{groupId}/tests/{testId}', 'RelevanceTesting\TestController@deleteTest');

    Route::post('/relevance-testing/suites/{suiteId}/runs', 'RelevanceTesting\RunController@addRun');
    Route::put('/relevance-testing/suites/{suiteId}/runs/{runId}', 'RelevanceTesting\RunController@updateRun');
    Route::delete('/relevance-testing/suites/{suiteId}/runs/{runId}', 'RelevanceTesting\RunController@deleteRun');

    /**
     * Transform
     */
    Route::post('/transformations/update', 'TransformationController@updateTransformation');
    Route::post('/transformations/get-all', 'TransformationController@getTransformations');
    Route::post('/transformations/delete', 'TransformationController@deleteTransformation');
});

Route::get('/login/callback', 'AuthController@algoliaLoginCallback');

Route::get('/clear', function (\Illuminate\Http\Request $request) {
    $request->session()->flush();
});
