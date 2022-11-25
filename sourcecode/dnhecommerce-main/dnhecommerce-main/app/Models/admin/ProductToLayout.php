<?php

namespace App\Models\admin;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProductToLayout extends Model
{
    use HasFactory;
    protected $table = 'product_to_layout';
    protected $fillable = ['id','id_product','note','created_at','updated_at'];
}
