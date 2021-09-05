<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class IPTV extends Model
{
    use HasFactory;
    public $timestamps = false;
    protected $table = 'iptv';

    protected $fillable = [
        'name',
        'price',
        'cost',
    ];

    public function customers(){
        return $this->hasMany(Customer::class);
    }
}
