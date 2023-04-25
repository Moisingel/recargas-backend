<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Currency extends Model
{
    use HasFactory, SoftDeletes;
    protected $table = 'currencies';
    protected $primaryKey = 'id';
    protected $fillable = [
        'name',
        'country_id'
    ];

    public function country()
    {
        return $this->belongsTo(Country::class);
    }

    public function exchanges()
    {
        return $this->hasMany(CurrencyExchange::class, 'from_currency_id', 'id');
    }
}
