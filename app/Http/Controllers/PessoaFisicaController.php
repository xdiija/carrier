<?php

namespace App\Http\Controllers;

use App\Http\Requests\PessoaFisicaStoreUpdateRequest;
use App\Http\Resources\PessoaFisicaResource;
use App\Models\PessoaFisica;

class PessoaFisicaController extends Controller
{
    public function __construct(
        protected PessoaFisica $pessoaFisicaModel
    ) {}

    public function index()
    {
        return PessoaFisicaResource::collection(
            $this->pessoaFisicaModel->with('user')->get()
        );
    }

    public function store(PessoaFisicaStoreUpdateRequest $request)
    {
        $pessoaFisica = $this->pessoaFisicaModel->create($request->validated());
        return new PessoaFisicaResource($pessoaFisica->load('user'));
    }

    public function show($id)
    {
        return new PessoaFisicaResource(
            $this->pessoaFisicaModel->with('user')->findOrFail($id)
        );
    }

    public function update(PessoaFisicaStoreUpdateRequest $request, $id)
    {
        $pessoaFisica = $this->pessoaFisicaModel->findOrFail($id);
        $pessoaFisica->update($request->validated());
        return new PessoaFisicaResource($pessoaFisica->load('user'));
    }

    public function destroy($id)
    {
        $pessoaFisica = $this->pessoaFisicaModel->findOrFail($id);
        $pessoaFisica->delete();
        return response()->noContent();
    }
}