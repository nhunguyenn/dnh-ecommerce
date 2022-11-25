<?php

namespace App\Models\admin;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PurchaseHistory extends Model
{
    use HasFactory;

    protected $table = 'purchase_history';
    protected $fillable = ['id','id_purchase','id_product','price_product','price_discount','price_voucher','price_delivery','created_at','updated_at'];
}
