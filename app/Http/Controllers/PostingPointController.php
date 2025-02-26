<?php

namespace App\Http\Controllers;

use App\Http\Requests\PostingPointStoreUpdateRequest;
use App\Http\Resources\PostingPointResource;
use App\Models\PostingPoint;
use Illuminate\Support\Facades\DB;

class PostingPointController extends Controller
{   
    public function __construct(
        protected PostingPoint $postingPointModel
    ) {}

    public function index()
    {
        return PostingPointResource::collection(
            $this->postingPointModel->get()
        );
    }

    public function store(PostingPointStoreUpdateRequest $request)
    {
        DB::beginTransaction();

        try {
            $data = $request->validated();
            $postingPoint = $this->postingPointModel->create($data);

            DB::commit();

            return new PostingPointResource($postingPoint);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    public function show(string $id)
    {   
        return new PostingPointResource(
            $this->postingPointModel->findOrFail($id)
        );
    }

    public function update(PostingPointStoreUpdateRequest $request, string $id)
    {   
        $postingPoint = $this->postingPointModel->findOrFail($id);

        $data = $request->validated();
        $postingPoint->update($data);

        return new PostingPointResource($postingPoint);
    }

    public function destroy(string $id)
    {
        $postingPoint = $this->postingPointModel->findOrFail($id);
        $postingPoint->delete();
        return response()->noContent();
    }
}
