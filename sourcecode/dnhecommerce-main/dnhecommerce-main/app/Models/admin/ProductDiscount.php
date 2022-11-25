<?php

namespace App\Models\admin;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProductDiscount extends Model
{
    use HasFactory;

    protected $table = 'product_discount';
    protected $fillable = ['id','id_product','percent_discount','quantity','note','active','time_start','time_end','created_at','updated_at'];
}
