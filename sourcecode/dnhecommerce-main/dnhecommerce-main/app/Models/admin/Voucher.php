<?php

namespace App\Models\admin;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Voucher extends Model
{
    use HasFactory;

    protected $table = 'voucher';
    protected $fillable = ['id','name','price','total_product','note','active','created_at','updated_at'];
}
