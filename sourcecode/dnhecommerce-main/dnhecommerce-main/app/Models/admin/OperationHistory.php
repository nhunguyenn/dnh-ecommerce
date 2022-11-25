<?php

namespace App\Models\admin;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OperationHistory extends Model
{
    use HasFactory;

    protected $table = 'operation_history';
    protected $fillable = ['id','id_employee','table','operation','created_at'];
}
