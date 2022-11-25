<?php

namespace App\Models\admin;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ReturnOrder extends Model
{
    use HasFactory;

    protected $table = 'return_order';
    protected $fillable = ['id','id_purchase','active','created_at','updated_at'];
}
