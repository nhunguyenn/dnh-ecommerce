<?php

namespace App\Models\admin;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;

    protected $table = 'order';
    protected $fillable = ['id','id_address','id_cart_product','id_product_discount','id_voucher','id_delivery','active','date_unpaid','date_toship','date_shipping','date_completed','date_cancelled','created_at','updated_at'];
}
