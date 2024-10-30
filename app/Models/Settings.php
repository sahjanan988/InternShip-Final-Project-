<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Settings extends Model
{
    use HasFactory;
    public $timestamps = false;
    protected $table = 'settings';

    protected $fillable = [
        'radius_username',
        'radius_password',
        'company_name',
        'company_phone',
        'company_address',
        'radius_url',
        'company_logo',
    ];
}
