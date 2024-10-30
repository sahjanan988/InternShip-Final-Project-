<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Area extends Model
{
    use HasFactory;
    public $timestamps = false;
    protected $fillable = [
        'name',
    ];

    public function streets(){
        return $this->hasMany(Street::class);
    }

    public function customers(){
        return $this->hasMany(Customer::class);
    }
}
