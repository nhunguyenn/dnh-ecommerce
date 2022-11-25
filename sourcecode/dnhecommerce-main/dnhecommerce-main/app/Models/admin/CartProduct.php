<?php

namespace App\Models\admin;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CartProduct extends Model
{
    use HasFactory;

    protected $table = 'cart_product';
    protected $fillable = ['id','id_product','id_size','id_color','quantity_product','note','status','active','created_at','updated_at'];
}
