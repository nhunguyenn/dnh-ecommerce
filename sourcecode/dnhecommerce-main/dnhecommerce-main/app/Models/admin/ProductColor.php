<?php

namespace App\Models\admin;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProductColor extends Model
{
    use HasFactory;

    protected $table = 'product_color';
    protected $fillable = ['id','id_product','name','color_code','quantity','price','note','active','created_at','updated_at'];
}
