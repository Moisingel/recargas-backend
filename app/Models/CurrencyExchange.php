<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class CurrencyExchange extends Model
{
    use HasFactory, SoftDeletes;
    protected $table = 'currency_exchanges';
    protected $primaryKey = 'id';
    protected $fillable = [
        'from_currency_id',
        'to_currency_id',
        'rate'
    ];
}
