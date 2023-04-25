<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Promoter extends Model
{
    use HasFactory, SoftDeletes;
    protected $table = 'promoters';
    protected $primaryKey = 'id';
    protected $fillable = [
        'names',
        'surnames'
    ];
}
