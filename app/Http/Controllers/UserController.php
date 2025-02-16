<?php

namespace App\Http\Controllers;

use App\Http\Requests\UserStoreUpdateRequest;
use App\Http\Resources\UserResource;
use App\Models\User;
use Illuminate\Support\Facades\DB;

class UserController extends Controller
{   
    public function __construct(
        protected User $userModel
    ) {}
    public function index()
    {
        return UserResource::collection(
            $this->userModel->get()
        );
    }

    public function store(UserStoreUpdateRequest $request)
    {
        DB::beginTransaction();

        try {

            $data = $request->validated();
            $data['password'] = bcrypt($request->password);
            $user = $this->userModel->create($data);
            $user->wallet()->create(['balance' => 0]); 

            DB::commit();

            return new UserResource($user);
            
        } catch (\Exception $e) {
            DB::rollBack();
            $error = $e->getMessage();
            return response()->json(['error' => $error], 500);
        }
    }

    public function show(string $id)
    {   
        return new UserResource(
            $this->userModel->findOrFail($id)
        );
    }

    public function balance()
    {
        $wallet = auth()->user()->wallet;
        return response()->json(['balance' => $wallet->balance]);
    }

    public function update(UserStoreUpdateRequest $request, string $id)
    {   
        $user = $this->userModel->findOrFail($id);

        $data = $request->validated();
        if($request->password) $data['password'] = bcrypt($request->password);
        $user->update($data);

        return new UserResource($user);
    }

    public function changeStatus(string $id)
    {   
        $user = $this->userModel->findOrFail($id);
        $user->status = $user->status === 1 ? 2 : 1;
        $user->save();
        return new UserResource($user);
    }

    public function destroy(string $id)
    {
        $user = $this->userModel->findOrFail($id);
        $user->delete();
        return response()->noContent();
    }
}
