<?php

namespace App\Http\Controllers;

use App\Http\Requests\SenderStoreUpdateRequest;
use App\Http\Resources\SenderResource;
use App\Models\Sender;
use Illuminate\Support\Facades\DB;

class SenderController extends Controller
{
    public function __construct(
        protected Sender $senderModel
    ) {}

    public function index()
    {
        return SenderResource::collection(
            $this->senderModel->with('state')->get()
        );
    }

    public function store(SenderStoreUpdateRequest $request)
    {
        DB::beginTransaction();

        try {
            $sender = $this->senderModel->create(
                $request->validated()
            );

            DB::commit();

            return new SenderResource($sender->load('state'));
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    public function show(string $id)
    {
        $sender = $this->senderModel->with('state')->findOrFail($id);
        return new SenderResource($sender);
    }

    public function update(SenderStoreUpdateRequest $request, string $id)
    {
        $sender = $this->senderModel->findOrFail($id);

        $sender->update(
            $request->validated()
        );

        return new SenderResource($sender->load('state'));
    }

    public function destroy(string $id)
    {
        $sender = $this->senderModel->findOrFail($id);
        $sender->delete();

        return response()->noContent();
    }
}
