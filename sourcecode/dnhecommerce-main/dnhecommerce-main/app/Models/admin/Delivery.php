<?php

namespace App\Models\admin;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Delivery extends Model
{
    use HasFactory;

    protected $table = 'delivery';
    protected $fillable = ['id','name','phone','price','note','active','created_at','updated_at'];
}
