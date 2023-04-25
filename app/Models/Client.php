<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Client extends Model
{
    use HasFactory, SoftDeletes;
    protected $table = 'clients';
    protected $primaryKey = 'id';
    protected $fillable = [
        'names',
        'surnames',
        'player_id',
        'country_id'
    ];

    public function country()
    {
        return $this->belongsTo(Country::class);
    }

    public function wallet()
    {
        return $this->hasOne(Wallet::class);
    }
}
