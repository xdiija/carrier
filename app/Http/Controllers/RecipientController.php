<?php

namespace App\Http\Controllers;

use App\Http\Requests\RecipientStoreUpdateRequest;
use App\Http\Resources\RecipientResource;
use App\Models\Recipient;
use Illuminate\Support\Facades\DB;

class RecipientController extends Controller
{
    public function __construct(
        protected Recipient $recipientModel
    ) {}

    public function index()
    {
        return RecipientResource::collection(
            $this->recipientModel->with('state')->get()
        );
    }

    public function store(RecipientStoreUpdateRequest $request)
    {
        DB::beginTransaction();

        try {
            // Validate and create the recipient
            $data = $request->validated();
            $recipient = $this->recipientModel->create($data);

            DB::commit();

            // Return the newly created recipient as a resource
            return new RecipientResource($recipient);
        } catch (\Exception $e) {
            DB::rollBack();
            // Return error if something goes wrong
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    public function show(string $id)
    {
        // Find the recipient by ID or fail if not found
        $recipient = $this->recipientModel->with('state')->findOrFail($id);
        return new RecipientResource($recipient);
    }

    public function update(RecipientStoreUpdateRequest $request, string $id)
    {
        DB::beginTransaction();

        try {
            // Find the recipient and update with validated data
            $recipient = $this->recipientModel->findOrFail($id);
            $data = $request->validated();
            $recipient->update($data);

            DB::commit();

            // Return the updated recipient as a resource
            return new RecipientResource($recipient);
        } catch (\Exception $e) {
            DB::rollBack();
            // Return error if something goes wrong
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    public function destroy(string $id)
    {
        // Find the recipient and delete
        $recipient = $this->recipientModel->findOrFail($id);
        $recipient->delete();
        return response()->noContent();
    }
}
