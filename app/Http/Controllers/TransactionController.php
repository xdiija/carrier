<?php

namespace App\Http\Controllers;

use App\Models\Transaction;
use Illuminate\Http\Request;

class TransactionController extends Controller
{

    public function __construct(
        protected Transaction $modelTransaction,
    ) {}

    public function index()
    {
        $wallet = auth()->user()->wallet;
        $transactions = $this->modelTransaction->where('wallet_id', $wallet->id)
            ->orderBy('created_at', 'desc')
            ->get();

        return response()->json(['transactions' => $transactions]);
    }

    public function deposit(Request $request)
    {
        $request->validate([
            'amount' => ['required', 'numeric', 'min:0.01'],
            'description' => ['nullable', 'string'],
        ]);

        $wallet = auth()->user()->wallet;
        $wallet->balance += $request->amount;
        $wallet->save();

        $this->modelTransaction->create([
            'wallet_id' => $wallet->id,
            'amount' => $request->amount,
            'transaction_type' => 'deposit'
        ]);

        return response()->json(['message' => 'Transação concluída.', 'balance' => $wallet->balance]);
    }

    public function subtract(Request $request)
    {
        $request->validate([
            'amount' => ['required', 'numeric', 'min:0.01'],
            'description' => ['nullable', 'string'],
        ]);

        $wallet = auth()->user()->wallet;

        if ($wallet->balance < $request->amount) {
            return response()->json(['error' => 'Saldo insuficiente.'], 400);
        }

        $wallet->balance -= $request->amount;
        $wallet->save();

        $this->modelTransaction->create([
            'wallet_id' => $wallet->id,
            'amount' => $request->amount,
            'transaction_type' => 'subtract'
        ]);

        return response()->json(['message' => 'Transação concluída.', 'balance' => $wallet->balance]);
    }

    public function destroy($transactionId)
    {
        $transaction = $this->modelTransaction->find($transactionId);

        if (!$transaction) {
            return response()->json(['error' => 'Transação não encontrada.'], 404);
        }

        $wallet = $transaction->wallet;

        if($wallet->user_id != auth()->user()->id) {
            return response()->json(['error'=> 'Transação não pertence à carteira do usuario logado'], 400);
        }

        if ($transaction->transaction_type == 'deposit') {
            $wallet->balance -= $transaction->amount;
        } elseif ($transaction->transaction_type == 'subtract') {
            $wallet->balance += $transaction->amount;
        }

        $wallet->save();
        $transaction->delete();

        return response()->json(['message' => 'Transação excluida.', 'balance' => $wallet->balance]);
    }
}
