<?php

namespace App\Http\Controllers;
use App\Models\State;
use Illuminate\Http\Request;

class StateController {
    public function addState(Request $request) {
        $userId = $this->getUserId($request);

        $stateValue = $request->post('value');

        $state = State::firstOrNew([
            'user_id' => $userId,
            'value' => $stateValue,
        ]);

        if ($state->id) {
            return $state;
        }

        $state->save();

        $state->short_code = uniqid();
        $state->save();

        return $state;
    }

    public function getState($shortCode) {
        return State::where('short_code', '=', $shortCode)->first();
    }
}