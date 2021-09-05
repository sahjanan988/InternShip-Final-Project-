<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Plan extends Model
{
    use HasFactory;
    public $timestamps = false;

    protected $fillable = [
        'name',
        'upload',
        'download',
        'price',
        'cost',
    ];

    public function customers(){
        return $this->hasMany(Customer::class);
    }
}
