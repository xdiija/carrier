<?php

namespace App\Http\Controllers;

use App\Http\Resources\StateResource;
use App\Models\State;

class StateController extends Controller
{
    protected State $stateModel;

    public function __construct(State $stateModel)
    {
        $this->stateModel = $stateModel;
    }

    public function index()
    {
        return StateResource::collection(
            $this->stateModel->all()
        );
    }

    public function show($id)
    {
        $state = $this->stateModel->findOrFail($id);

        return new StateResource($state);
    }
}
