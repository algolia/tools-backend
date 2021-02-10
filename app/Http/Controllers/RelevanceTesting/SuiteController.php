<?php

namespace App\Http\Controllers\RelevanceTesting;

use App\Models\RelevanceTesting\Group;
use App\Models\RelevanceTesting\Permission;
use App\Models\RelevanceTesting\Suite;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class SuiteController {
    private $userId;
    private $userEmail;

    private function getUser(Request $request)
    {
        $accessToken = $request->session()->get('accessToken');
        $values = $accessToken->getValues();

        $this->userId = $values['user']['id'];
        $this->userEmail = $values['user']['email'];
    }

    public function getSuite(Request $request, $id)
    {
        $this->getUser($request);

        $suite = Suite::with(['groups', 'groups.tests', 'runs', 'permissions'])->find($id);

        if (!$suite) return new JsonResponse(404);
        if (!$suite->isReadableBy($this->userId, $this->userEmail)) return new JsonResponse(null, 403);

        return $suite;
    }

    public function addSuite(Request $request)
    {
        $this->getUser($request);

        $suite = new Suite();
        $suite->name = $request->post('name');
        $suite->user_id = $this->userId;
        $suite->save();

        $group = new Group();
        $group->suite_id = $suite->id;
        $group->name = 'Group of tests 1';
        $group->save();

        foreach ($request->post('permissions') as $p) {
            $permission = new Permission();
            $permission->suite_id = $suite->id;
            $permission->email = $p['email'];
            $permission->read = 1;
            $permission->write = 1;
            $permission->save();
        }

        return $suite;
    }

    public function updateSuite(Request $request, $id)
    {
        $this->getUser($request);

        $suite = Suite::find($id);

        if (!$suite) return new JsonResponse(404);
        if (!$suite->isWritableBy($this->userId, $this->userEmail)) return new JsonResponse(null, 403);

        $suite->name = $request->post('name');
        $suite->user_id = $this->userId;
        $suite->save();

        $emails = array_map(function ($p) { return $p['email']; }, $request->input('permissions'));
        Permission::where('suite_id', '=', $suite->id)->whereNotIn('email', $emails)->delete();

        foreach ($emails as $email) {
            $permission = Permission::firstOrNew([
                'suite_id' => $suite->id,
                'email' => $email,
            ]);
            $permission->read = 1;
            $permission->write = 1;
            $permission->save();
        }

        return $suite;
    }

    public function deleteSuite(Request $request, $id)
    {
        $this->getUser($request);

        $suite = Suite::find($id);

        if (!$suite) return new JsonResponse(404);
        if (!$suite->isWritableBy($this->userId, $this->userEmail)) return new JsonResponse(null, 403);

        $suite->delete();
    }

    public function listSuites(Request $request)
    {
        $this->getUser($request);

        $suites = [
            'persoSuites' => Suite::with('permissions')->where('user_id', '=', $this->userId)->get()->toArray(),
            'sharedSuites' => Suite::whereHas('permissions', function ($q) {
                $q->where('email', '=', $this->userEmail);
            }, '>=', 1)->get()->toArray(),
        ];

        return $suites;
    }
}
