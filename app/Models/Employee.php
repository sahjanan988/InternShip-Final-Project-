<?php

namespace App\Models;


use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;

class Employee extends Authenticatable
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'username',
        'phone',
        'name',
        'enrolled_at',
        'salary',
        'password',
        'role',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password',
    ];

    protected $casts = [
        'salary' => 'float',
    ];

    public function customers(){
        return $this->hasMany(Customer::class,'emp_id');
    }

    public function invoices(){
        return $this->hasMany(CustomerInvoice::class);
    }

}
