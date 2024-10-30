<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Street extends Model
{
    use HasFactory;
    public $timestamps = false;

    protected $fillable = [
        'name',
        'area_id',
    ];

    public function  buildings(){
        return $this->hasMany(Building::class);
    }

    public function area(){
        return $this->belongsTo(Area::class);
    }
}
