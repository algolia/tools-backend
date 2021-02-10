<?php

namespace App\Http\Controllers\RelevanceTesting;

use App\Models\RelevanceTesting\Group;
use App\Models\RelevanceTesting\Test;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class TestController
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

    public function addTest(Request $request, $suiteId, $groupId)
    {
        $this->getUser($request);

        $group = Group::find($groupId);

        if (!$group || (int) $suiteId !== $group->suite_id) return new JsonResponse(404);
        if (!$group->isWritableBy($this->userId, $this->userEmail)) return new JsonResponse(null, 403);

        $test = new Test();
        $test->group_id = $groupId;
        $test->test_data = $request->post('test_data');
        $test->save();

        return $test;
    }

    public function addTests(Request $request, $suiteId, $groupId)
    {
        $this->getUser($request);

        $group = Group::find($groupId);

        if (!$group || (int) $suiteId !== $group->suite_id) return new JsonResponse(404);
        if (!$group->isWritableBy($this->userId, $this->userEmail)) return new JsonResponse(null, 403);


        $tests = $request->post('tests');

        if (!$tests) return [];

        return array_map(function ($testData) use ($groupId) {
            $test = new Test();
            $test->group_id = $groupId;
            $test->test_data = $testData;
            $test->save();

            return $test;
        }, $tests);
    }

    public function updateTest(Request $request, $suiteId, $groupId, $testId)
    {
        $this->getUser($request);

        $test = Test::find($testId);

        if (!$test || (int) $groupId !== $test->group_id || (int) $suiteId !== $test->group->suite_id) return new JsonResponse(404);
        if (!$test->isWritableBy($this->userId, $this->userEmail)) return new JsonResponse(null, 403);

        $test->test_data = $request->post('test_data');
        $test->save();

        return $test;
    }

    public function deleteTest(Request $request, $suiteId, $groupId, $testId)
    {
        $this->getUser($request);

        $test = Test::find($testId);

        if (!$test || (int) $groupId !== $test->group_id || (int) $suiteId !== $test->group->suite_id) return new JsonResponse(404);
        if (!$test->isWritableBy($this->userId, $this->userEmail)) return new JsonResponse(null, 403);

        $test->delete();
    }
}
