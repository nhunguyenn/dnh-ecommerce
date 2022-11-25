<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class AdminOperationHistoryController extends Controller
{
    public function index()
    {
        $operations = DB::select('SELECT `operation_history`.*, `employee`.`name` FROM `operation_history`, `employee` WHERE `operation_history`.`id_employee` = `employee`.`id`');
        return view('admin.history.operation', [
            'operations' => $operations,
        ]);
    }
}
