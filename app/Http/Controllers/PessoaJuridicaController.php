<?php

namespace App\Http\Controllers;

use App\Http\Requests\PessoaJuridicaStoreUpdateRequest;
use App\Http\Resources\PessoaJuridicaResource;
use App\Models\PessoaJuridica;

class PessoaJuridicaController extends Controller
{
    public function __construct(
        protected PessoaJuridica $pessoaJuridicaModel
    ) {}

    public function index()
    {
        return PessoaJuridicaResource::collection(
            $this->pessoaJuridicaModel->with('user')->get()
        );
    }

    public function store(PessoaJuridicaStoreUpdateRequest $request)
    {
        $pessoaJuridica = $this->pessoaJuridicaModel->create($request->validated());
        return new PessoaJuridicaResource($pessoaJuridica->load('user'));
    }

    public function show($id)
    {
        return new PessoaJuridicaResource(
            $this->pessoaJuridicaModel->with('user')->findOrFail($id)
        );
    }

    public function update(PessoaJuridicaStoreUpdateRequest $request, $id)
    {
        $pessoaJuridica = $this->pessoaJuridicaModel->findOrFail($id);
        $pessoaJuridica->update($request->validated());
        return new PessoaJuridicaResource($pessoaJuridica->load('user'));
    }

    public function destroy($id)
    {
        $pessoaJuridica = $this->pessoaJuridicaModel->findOrFail($id);
        $pessoaJuridica->delete();
        return response()->noContent();
    }
}
