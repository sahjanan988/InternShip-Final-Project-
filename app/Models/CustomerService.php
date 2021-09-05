<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CustomerService extends Model
{
    use HasFactory;
    protected $table = 'customerServices';
    public $timestamps = false;

    protected $fillable = [
       'customer_id',
       'service_id',
    ];
}
