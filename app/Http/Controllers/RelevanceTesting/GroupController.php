<?php

namespace App\Http\Controllers\RelevanceTesting;

use App\Models\RelevanceTesting\Group;
use App\Models\RelevanceTesting\Suite;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class GroupController
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

    public function addGroup(Request $request, $suiteId)
    {
        $this->getUser($request);

        $suite = Suite::find($suiteId);

        if (!$suite) return new JsonResponse(404);
        if (!$suite->isWritableBy($this->userId, $this->userEmail)) return new JsonResponse(null, 403);

        $group = new Group();
        $group->name = $request->post('name');
        $group->suite_id = $suite->id;
        $group->save();
        $group->tests; // Load tests

        return $group;
    }

    public function updateGroup(Request $request, $suiteId, $groupId)
    {
        $this->getUser($request);

        $group = Group::with('tests')->find($groupId);

        if (!$group || (int) $suiteId !== $group->suite_id) return new JsonResponse(404);
        if (!$group->isWritableBy($this->userId, $this->userEmail)) return new JsonResponse(null, 403);

        $group->name = $request->post('name');
        $group->save();

        return $group;
    }

    public function deleteGroup(Request $request, $suiteId, $groupId)
    {
        $this->getUser($request);

        $group = Group::find($groupId);

        if (!$group || (int) $suiteId !== $group->suite_id) return new JsonResponse(404);
        if (!$group->isWritableBy($this->userId, $this->userEmail)) return new JsonResponse(null, 403);

        $group->delete();
    }
}
