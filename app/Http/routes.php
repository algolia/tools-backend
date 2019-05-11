<?php

Route::middleware(['auth', 'auth.beta'])->group(function () {
    Route::get('/user/info', 'AuthController@currentUser');

    Route::get('/user/apps', function (\Illuminate\Http\Request $request) {
        return ['AJ0P3S7DWQ', 'N6E3P8T447', 'RSBCBF0EG8'];
    });

    Route::get('/signature/{appId}', function ($appId, \Illuminate\Http\Request $request) {

        $ip = last(request()->getClientIps());
        Log::debug($_SERVER['HTTP_X_FORWARDED_FOR']);
        Log::debug($ip);
        $base = $appId.$ip;
        $encrypt = 'etneckthyghykHookofvotPayWrimtOkyajhyThracyochiWettijWiHiatAkOavpyWyddelUshByafIrwytUjAckvarhadJoymsEipIbdyewCuwocjodsEnsaubyefsProynwacdebnirobinpyivJavephaumhavCacShoglivPhaynfinWutCavsingyealwothIxIskOcbiwygByctAwtupnurrUdveOsjovurNuemavjorUsoavEaverOt3boicAwtyubeirdyanivjoodsyejTyFlupMyphlybNetEicOahinAvtydarnijtethPembeavRirnEevhijBukGubVaccagEdheabyoctOdtisjuIpfithCyxAdkobnerraicityajWurckEim0queOnBydjoitIkDegJatPeffasUpteroneetVislykiftOcibviDrareicyodphictUddepsEewOflisjuWeryachaygtatpedbomrathliryeeeBlyftowAjPoshficVeksejtanBicgigdaquitdymkuingiatdusIjokseibyojbeidnidifGiGunocatAumfefkageysespOmfewHeOvHyshrarjojhyctevDatirrkorEewhynnOghudTumIg1fagChigs(quafUv9QueingIdyofVidashophCobyoumCufemghoactIstArgyohig7hayctojMiCejajNegAcJeunLawUlAgsiksAtNevef';
        $toHash = $base.$encrypt;
        $signature = hash('sha256', $toHash);

        return [
            'signature' => $signature
        ];
    });
});

Route::get('/login/callback', 'AuthController@algoliaLoginCallback');

Route::get('/clear', function (\Illuminate\Http\Request $request) {
    $request->session()->flush();
});

Route::get('/', function (\Illuminate\Http\Request $request) {
    dd($request->session()->get('accessToken'));
});