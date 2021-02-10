<?php

namespace App\Http\Controllers\RelevanceTesting;

use App\Models\RelevanceTesting\Group;
use App\Models\RelevanceTesting\Run;
use App\Models\RelevanceTesting\Suite;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class RunController
{
    private $userId;
    private $userEmail;

    private function getUser(Request $request)
    {
        $accessToken = $request->session()->get('accessToken');
        $values = $accessToken->getValues();

        $this->userId = $values['user']['id'];
        $this->userEmail = $values['user']['email'];
    }

    public function addRun(Request $request, $suiteId)
    {
        $this->getUser($request);

        $suite = Suite::find($suiteId);

        if (!$suite) return new JsonResponse(404);
        if (!$suite->isWritableBy($this->userId, $this->userEmail)) return new JsonResponse(null, 403);

        $run = new Run();
        $run->suite_id = $suiteId;
        $run->app_id = $request->post('app_id');
        $run->index_name = $request->post('index_name');
        $run->hits_per_page = (int) $request->post('hits_per_page');
        $run->params = $request->post('params');
        $run->save();

        return $run;
    }

    public function updateRun(Request $request, $suiteId, $runId)
    {
        $this->getUser($request);

        $run = Run::find($runId);

        if (!$run || (int) $suiteId !== $run->suite_id) return new JsonResponse(404);
        if (!$run->isWritableBy($this->userId, $this->userEmail)) return new JsonResponse(null, 403);

        $run->app_id = $request->post('app_id');
        $run->index_name = $request->post('index_name');
        $run->hits_per_page = (int) $request->post('hits_per_page');
        $run->params = $request->post('params');
        $run->save();

        return $run;
    }

    public function deleteRun(Request $request, $suiteId, $runId)
    {
        $this->getUser($request);

        $run = Run::find($runId);

        if (!$run || (int) $suiteId !== $run->suite_id) return new JsonResponse(404);
        if (!$run->isWritableBy($this->userId, $this->userEmail)) return new JsonResponse(null, 403);

        $run->delete();
    }
}
