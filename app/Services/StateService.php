<?php

namespace App\Services;

use App\Models\State;

class StateService
{
    public function getAllStates()
    {
        return State::with('country')->paginate(10);
    }

    public function createState(array $data)
    {
        return State::create($data);
    }

    public function updateState(State $state, array $data)
    {
        $state->update($data);
        return $state;
    }

    public function deleteState(State $state)
    {
        $state->delete();
    }
}
