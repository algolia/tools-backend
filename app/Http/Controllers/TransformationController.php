<?php

namespace App\Http\Controllers;

use App\Models\State;
use App\Models\Transformation;
use Illuminate\Http\Request;

class TransformationController {
    private function getUserId(Request $request) {
        $accessToken = $request->session()->get('accessToken');
        $values = $accessToken->getValues();

        return $values['user']['id'];
    }

    public function updateTransformation(Request $request)
    {
        $transformationName = $request->post('name');
        $transformationBody = $request->post('body');

        $transformation = Transformation::firstOrNew([
            'name' => $transformationName,
            'user_id' => $this->getUserId($request)
        ]);
        $transformation->body = $transformationBody;
        $transformation->save();

        return $transformation;
    }

    public function getTransformations(Request $request)
    {
        return Transformation::where('user_id', '=', $this->getUserId($request))->get();
    }

    public function deleteTransformation(Request $request)
    {
        $transformationName = $request->post('name');

        Transformation::where('user_id', '=', $this->getUserId($request))
            ->where('name', '=', $transformationName)
            ->delete();
    }
}
