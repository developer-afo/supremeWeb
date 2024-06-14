<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Wallet;
use App\Models\WalletType;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class WalletController extends Controller
{

    public function getAllWallets()
    {
        $wallets = Wallet::paginate(10);;
        return response()->json(['status' => 'success', 'msg' => 'All wallets fetched successfully', 'data' => $wallets], 200);
    }

    public function getWalletDetails($id)
    {
        $wallet = Wallet::with('user', 'walletType')->find($id);

        if (!$wallet) {
            return response()->json(['status' => 'error', 'msg' => 'Wallet not found', 'data' => null], 404);
        }

        return response()->json(['status' => 'success', 'msg' => 'Wallet details fetched successfully', 'data' => $wallet], 200);
    }

    public function createWalletType(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'minimum_balance' => 'required|numeric|min:0',
            'monthly_interest_rate' => 'required|numeric|min:0|max:100',
        ]);

        if ($validator->fails()) {
            return response()->json(['status' => 'error', 'msg' => 'Validation error', 'data' => $validator->errors()], 422);
        }

        $walletType = WalletType::create($request->all());

        return response()->json(['status' => 'success', 'msg' => 'Wallet type created successfully', 'data' => $walletType], 201);
    }

    public function createWallet(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'wallet_type_id' => 'required|exists:wallet_types,id',
        ]);

        if ($validator->fails()) {
            return response()->json(['status' => 'error', 'msg' => 'Validation error', 'data' => $validator->errors()], 422);
        }

        $user = Auth::user();

        $wallet = new Wallet([
            'user_id' => $user->id,
            'wallet_type_id' => $request->wallet_type_id,
            'balance' => 0,
        ]);

        $wallet->save();

        return response()->json(['status' => 'success', 'msg' => 'Wallet created successfully', 'data' => $wallet], 201);
    }

    public function fundWallet(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'wallet_id' => 'required|exists:wallets,id',
            'amount' => 'required|numeric|min:0.01',
        ]);

        if ($validator->fails()) {
            return response()->json(['status' => 'error', 'msg' => 'Validation error', 'data' => $validator->errors()], 422);
        }

        $user = Auth::user();
        $wallet = $user->wallets()->find($request->wallet_id);

        if (!$wallet) {
            return response()->json(['status' => 'error', 'msg' => 'Wallet not found or does not belong to the user', 'data' => null], 404);
        }

        $wallet->balance += $request->amount;
        $wallet->save();

        return response()->json(['status' => 'success', 'msg' => 'Wallet funded successfully', 'data' => $wallet], 200);
    }

    public function sendMoney(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'from_wallet_id' => 'required|exists:wallets,id',
            'to_wallet_id' => 'required|exists:wallets,id',
            'amount' => 'required|numeric|min:0.01',
        ]);

        if ($validator->fails()) {
            return response()->json(['status' => 'error', 'msg' => 'Validation error', 'data' => $validator->errors()], 422);
        }
        
        if($request->from_wallet_id == $request->to_wallet_id){
            return response()->json(['status' => 'error', 'msg' => "From and to can not be the same wallet"], 404);
        }

        $user = Auth::user();
        $fromWallet = $user->wallets()->find($request->from_wallet_id);
        $toWallet = Wallet::find($request->to_wallet_id);

        if (!$fromWallet) {
            return response()->json(['status' => 'error', 'msg' => 'Sender wallet not found or does not belong to the user'], 404);
        }

        try {
            $fromWallet->sendMoney($request->amount, $toWallet);
            return response()->json(['status' => 'success', 'msg' => 'Money sent successfully', 'data' => $fromWallet], 200);
        } catch (\Exception $e) {
            return response()->json(['status' => 'error', 'msg' => $e->getMessage(), 'data' => null], 400);
        }
    }


}
