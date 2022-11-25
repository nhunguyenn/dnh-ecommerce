<?php

namespace App\Models\admin;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    protected $table = 'product';
    protected $fillable = ['id','id_supplier','id_tax','id_category','id_related','name','image','quantity','cost','price','viewed','active_sale','active_purchase','note','active','created_at','updated_at'];
}
