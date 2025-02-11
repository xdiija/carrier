<?php

namespace App\Http\Controllers;

use App\Http\Requests\UserStoreUpdateRequest;
use App\Http\Resources\UserResource;
use App\Models\PessoaFisica;
use App\Models\PessoaJuridica;
use App\Models\User;

class UserController extends Controller
{   
    public function __construct(
        protected User $userModel,
        protected PessoaJuridica $pessoaJuridicaModel,
        protected PessoaFisica $pessoaFisicaModel,
    ) {}
    public function index()
    {
        return UserResource::collection(
            $this->userModel->get()
        );
    }

    public function store(UserStoreUpdateRequest $request)
    {   
        $data = $request->validated();
        $data['password'] = bcrypt($request->password);
        $user = $this->userModel->create($data);

        if ($request->has('pessoa_fisica')) {
            $pessoaFisica = new PessoaFisica($data['pessoa_fisica']);
            $user->pessoaFisica()->save($pessoaFisica);
        }
        
        if ($request->has('pessoa_juridica')) {
            $pessoaJuridica = new PessoaJuridica($data['pessoa_juridica']);
            $user->pessoaJuridica()->save($pessoaJuridica);
        }

        return new UserResource($user->load(['pessoaFisica', 'pessoaJuridica']));
    }

    public function show(string $id)
    {   
        return new UserResource(
            $this->userModel->with(['pessoaFisica', 'pessoaJuridica'])->findOrFail($id)
        );
    }

    public function update(UserStoreUpdateRequest $request, string $id)
    {   
        $user = $this->userModel->with(['pessoaFisica', 'pessoaJuridica'])->findOrFail($id);

        $data = $request->validated();
        if($request->password) $data['password'] = bcrypt($request->password);
        $user->update($data);

        if ($request->has('pessoa_fisica')) {

            if($user->pessoaFisica){
                $user->pessoaFisica->update($data['pessoa_fisica']);
            } else {
                $pessoaFisica = new PessoaFisica($data['pessoa_fisica']);
                $user->pessoaFisica()->save($pessoaFisica);
            }
        }

        if ($request->has('pessoa_juridica')) {

            if($user->pessoaJuridica){
                $user->pessoaJuridica->update($data['pessoa_juridica']);
            } else {
                $pessoaJuridica = new PessoaJuridica($data['pessoa_juridica']);
                $user->pessoaJuridica()->save($pessoaJuridica);
            }
        }

        return new UserResource($user->load(['pessoaFisica', 'pessoaJuridica']));
    }

    public function changeStatus(string $id)
    {   
        $user = $this->userModel->findOrFail($id);
        $user->status = $user->status === 1 ? 2 : 1;
        $user->save();
        return new UserResource($user->load(['pessoaFisica', 'pessoaJuridica']));
    }

    public function destroy(string $id)
    {
        $user = $this->userModel->findOrFail($id);

        if ($user->pessoaFisica) {
            $user->pessoaFisica->delete();
        } elseif ($user->pessoaJuridica) {
            $user->pessoaJuridica->delete();
        }

        $user->delete();

        return response()->noContent();
    }
}
