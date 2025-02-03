<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class BankAccount extends Model
{
    use HasFactory,HasUuids;
    
    protected $fillable = [
        'number',
        'name',
        'firstname',
        'balance',
        'user_id',
        'statut',
    ];
}
