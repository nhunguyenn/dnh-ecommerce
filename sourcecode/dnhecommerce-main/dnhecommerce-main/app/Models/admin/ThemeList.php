<?php

namespace App\Models\admin;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ThemeList extends Model
{
    use HasFactory;

    protected $table = 'theme_list';
    protected $fillable = ['id','name','image','note','active','created_at','updated_at'];
}
