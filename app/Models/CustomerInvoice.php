<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CustomerInvoice extends Model
{
    use HasFactory;
    protected $table = 'customerInvoices';
    public $timestamps = false;

    protected $fillable = [
        'customer_id',
        'type',
        'cost',
        'price',
        'discount',
        'due',
        'notes',
        'margin',
        'date',
        'total',
        'employee_id',
    ];

    public function customer(){
        return $this->belongsTo(Customer::class);
    }

    public function employee(){
        return $this->belongsTo(Employee::class);
    }
}
