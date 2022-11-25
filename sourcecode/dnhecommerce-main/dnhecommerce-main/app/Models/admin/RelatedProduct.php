<?php

namespace App\Models\admin;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RelatedProduct extends Model
{
    use HasFactory;

    protected $table = 'related_product';
    protected $fillable = ['id','name','related_category','note','active','created_at','updated_at'];
}
