<?php

namespace App\Models\admin;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Supplier extends Model
{
    use HasFactory;

    protected $table = 'supplier';
    protected $fillable = ['id','name','phone','email','address','bank_name','bank_number','note','active','created_at','updated_at'];
}
