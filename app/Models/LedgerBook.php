<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LedgerBook extends Model
{
    use HasFactory;
    public $timestamps = false;
    protected $table = 'ledgerBook';

    protected $fillable = [
        'type',
        'amount',
        'date',
        'description',
    ];
}
