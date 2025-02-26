<?php

namespace App\Http\Controllers;

use App\Http\Requests\ShippingStoreUpdateRequest;
use App\Http\Resources\SenderResource;
use App\Models\Package;
use App\Models\Recipient;
use App\Models\Sender;
use App\Models\Shipping;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class ShippingController extends Controller
{
    public function __construct(
        protected Recipient $recipientModel,
        protected Sender $senderModel,
        protected Shipping $shippingModel,
        protected Package $packageModel,
    ) {}

    public function store(ShippingStoreUpdateRequest $request)
    {
        DB::beginTransaction();

        try {
            $sender = Sender::create($request->input('sender'));
            $recipient = Recipient::create($request->input('recipient'));
            $trackingCode = Str::upper(Str::random(10));

            $shipping = Shipping::create([
                'user_id' => Auth::id(),
                'sender_id' => $sender->id,
                'recipient_id' => $recipient->id,
                'posting_point_id' => $request->input('posting_point_id'),
                'tracking_code' => $trackingCode,
                'status' => 1,
                'estimated_delivery' => now()->addDays(7),
                'actual_delivery' => null,
            ]);

            foreach ($request->input('packages') as $packageData) {
                $shipping->packages()->create($packageData);
            }

            DB::commit();

            return response()->json([
                'message' => 'Envio registrado com sucesso',
                'data' => $shipping->load('sender', 'recipient', 'packages'),
            ], 201);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json([
                'message' => 'Falha ao registrar o envio', 'error' => $e->getMessage()
            ], 500);
        }
    }
    public function show($id)
    {
        $shipping = Shipping::with(['sender', 'recipient', 'packages', 'postingPoint', 'user'])
            ->find($id);

        if (!$shipping) {
            return response()->json([
                'message' => 'Shipping not found',
            ], 404);
        }

        return response()->json([
            'message' => 'Shipping details retrieved successfully',
            'data' => $shipping,
        ], 200);
    }

    public function update(ShippingStoreUpdateRequest $request, $id)
    {
        DB::beginTransaction();

        try {
            $shipping = Shipping::with(['sender', 'recipient', 'packages'])->find($id);

            if (!$shipping) {
                return response()->json([
                    'message' => 'Envio não encontrado',
                ], 404);
            }

            $senderData = $request->input('sender');
            $shipping->sender->update($senderData);

            $recipientData = $request->input('recipient');
            $shipping->recipient->update($recipientData);

            $shippingData = $request->only(['posting_point_id', 'status', 'estimated_delivery', 'actual_delivery']);
            $shipping->update($shippingData);

            $packagesData = $request->input('packages');
            $shipping->packages()->delete();
            foreach ($packagesData as $package) {
                $shipping->packages()->create($package);
            }

            DB::commit();

            return response()->json([
                'message' => 'Envio atualizado com sucesso!',
                'data' => $shipping->load(['sender', 'recipient', 'packages']),
            ], 200);
        } catch (\Exception $e) {
            DB::rollBack();

            return response()->json([
                'message' => 'Falha ao atualizar envio',
                'error' => $e->getMessage(),
            ], 500);
        }
    }

    public function destroy(string $id)
    {
        $sender = $this->senderModel->findOrFail($id);
        $sender->delete();

        return response()->noContent();
    }
}
