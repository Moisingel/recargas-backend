<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class TransactionLog extends Model
{
    use HasFactory, SoftDeletes;
    protected $table = 'transaction_logs';
    protected $primaryKey = 'id';
    protected $fillable = [
        'wallet_transaction_id',
        'action',
        'old_data',
        'new_data',
        'observation',
        'promoter_id',
    ];

    public function promoter(){
        return $this->belongsTo(Promoter::class);
    }
}
