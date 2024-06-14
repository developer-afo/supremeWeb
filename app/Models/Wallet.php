<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Wallet extends Model
{
    use HasFactory;

    protected $fillable = ['user_id', 'wallet_type_id', 'balance'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function walletType()
    {
        return $this->belongsTo(WalletType::class);
    }

    public function sendMoney($amount, Wallet $recipientWallet)
    {
        if ($this->balance < $amount) {
            throw new \Exception('Insufficient funds');
        }

        $this->balance -= $amount;
        $this->save();

        $recipientWallet->balance += $amount;
        $recipientWallet->save();
    }
}

