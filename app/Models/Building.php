<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Building extends Model
{
    use HasFactory;
    public $timestamps = false;

    protected $fillable = [
        'name',
        'street_id',
    ];

    public function street(){
        return $this->belongsTo(Street::class);
    }
    public function boxes(){
        return $this -> hasMany(Box::class);
    }
	
    public function customers(){
        return $this->hasMany(Customer::class);
    }	

}
