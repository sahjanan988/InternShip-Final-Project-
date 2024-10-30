<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Box extends Model
{
    use HasFactory;
    public $timestamps = false;

    protected $fillable = [
        'name',
        'building_id',
    ];

    public function building(){
        return $this->belongsTo(Building::class);
    }

    public function customers(){
        return $this->hasMany(Customer::class);
    }
}
