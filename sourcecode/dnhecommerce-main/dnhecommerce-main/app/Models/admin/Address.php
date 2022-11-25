<?php

namespace App\Models\admin;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Address extends Model
{
    use HasFactory;

    protected $table = 'address';
    protected $fillable = ['id','id_customer','specific_address','city','distric','ward','phone','active','created_at','updated_at'];
}
