<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Customer extends Model
{
    use HasFactory;
    public $timestamps = false;

    protected $fillable = [
        'username',
        'name',
        'phone',
        'area_id',
        'street_id',
        'building_id',
        'box_id',
        'plan_id',
        'price',
        'custom_price',
        'discount',
        'expires_at',
        'active',
        'iptv_id',
        'free_account',
        'notes',
        'password',
        'emp_id',
        'radius_exp'
    ];
    public function area(){

        return $this->belongsTo(Area::class);
    }

    public function street(){
        return $this->belongsTo(Street::class);
    }

    public function building(){
        return $this->belongsTo(Building::class);
    }


    public function box(){
        return $this->belongsTo(Box::class);
    }

    public function plan(){
        return $this->belongsTo(Plan::class);
    }

    public function iptv(){
        return $this->belongsTo(IPTV::class);
    }

    public function employee(){
        return $this->belongsTo(Employee::class,'emp_id');
    }

    public function invoices(){
        return $this->hasMany(CustomerInvoice::class);
    }

    public function services()
    {
        //return $this->belongsToMany(RelatedModel, pivot_table_name, foreign_key_of_current_model_in_pivot_table, foreign_key_of_other_model_in_pivot_table);
        return $this->belongsToMany(
            Service::class,
            'customerServices',
            'customer_id',
            'service_id');
    }
}
