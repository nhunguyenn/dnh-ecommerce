<?php

namespace App\Models\admin;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Purchase extends Model
{
    use HasFactory;

    protected $table = 'purchase';
    protected $fillable = ['id','id_order','id_cart_product','active_confirm','active_return','created_at','updated_at'];
}
