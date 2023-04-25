<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Wallet extends Model
{
    use HasFactory, SoftDeletes;
    protected $table = 'wallets';
    protected $primaryKey = 'id';
    protected $fillable = [
        'client_id',
        'currency_id',
        'total',
        'last_recharge'
    ];

    public function client()
    {
        return $this->belongsTo(Client::class);
    }

    public function currency()
    {
        return $this->belongsTo(Currency::class);
    }

    public function transactions()
    {
        return $this->hasMany(WalletTransaction::class);
    }
}
