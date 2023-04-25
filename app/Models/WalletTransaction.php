<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class WalletTransaction extends Model
{
    use HasFactory, SoftDeletes;
    protected $table = 'wallet_transactions';
    protected $primaryKey = 'id';
    protected $fillable = [
        'wallet_id',
        'type',
        'bank_id',
        'channel_id',
        'promoter_id',
        'currency_id',
        'date',
        'amount',
        'exchange_rate',
        'amount_converted',
    ];

    public function wallet()
    {
        return $this->belongsTo(Wallet::class);
    }

    public function bank()
    {
        return $this->belongsTo(Bank::class);
    }

    public function channel()
    {
        return $this->belongsTo(Channel::class);
    }

    public function promoter()
    {
        return $this->belongsTo(Promoter::class);
    }

    public function currency()
    {
        return $this->belongsTo(Currency::class);
    }


}
