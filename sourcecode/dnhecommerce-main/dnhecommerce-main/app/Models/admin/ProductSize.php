<?php

namespace App\Models\admin;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProductSize extends Model
{
    use HasFactory;

    protected $table = 'product_size';
    protected $fillable = ['id','id_product','name','quantity','note','active','created_at','updated_at'];
}
